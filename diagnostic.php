<?php
	require_once("verifSessionChercheur.php");
	require_once("conn_pdo.php");
	require_once("ListFunction.php");
	require_once("diagnostic/class.answer.php");
	require_once("diagnostic/parsingFunctions.php");

	$verbose = true;
	$download_zip = false; // does the client download the zip (dataP) ?
	$suppress_files = true; //  does the server suppress the files after the download ,	
	$expectedAnswer_analysis = true;
	$log = "";

	if(isset($_POST['serieToDiagnose'])){
		

		$idSerie = $_POST['serieToDiagnose'];

		// Version sans jointure
		// $req = $bdd->prepare('SELECT * FROM trace WHERE serie = ?');
		// $req->execute(array($idSerie));
		// $req = $bdd->prepare($sql);
		// $req->execute(array($idSerie));

		// Attention, s'il n'y a pas de template, cette requête ne renvoie rien
		$sql = 'SELECT * FROM `trace` JOIN `pbm`
				ON `trace`.`pbm` = `pbm`.`idPbm`
				JOIN `pbm_template`
				ON `pbm`.`idTemplate` = `pbm_template`.`id`
				WHERE `serie` = '.$idSerie;
		$req = $bdd->query($sql);

		$existing_traces = array();

		$t_AnswersPbm = "";
		$t_AnswersSession = "";
		$t_PropertiesAnswers = "";
		$t_PropertiesProblem = "";
		$t_Sessions = "";

		$header_AnswersPbm = "idAnswers;idPbm\n";
		$header_AnswersSession = "idAnswerSubject;idSession;idPbm;idAnswer\n";
		$header_PropertiesAnswers = "idPropertiesAnswer;idAnswer\n";
		$header_PropertiesProblem = "idPropertiesProblem;idProblem\n";
		$header_Sessions = "sessionID;subject\n";

		$count_answers = 1; // Mmmm c'est ce que je mets dans "idAnswerSubject", mais je suis pas du tout sûr que c'est ça que je veux
		$regexNombreX = '#<<Nombre\(([0-9]+)\)=([0-9]+)>>#';

		while($t = $req->fetch()){
			// $t contient la jointure complexe entre trace, pbm et pb_template

			// ATTENTION : il faut prendre en compte uniquement la première fois qu'un élève a rempli la série si jamais il l'a passée plusieurs fois
			// => On retient "eleve - ordreSerie", et on vérifie que ce n'est pas inclus

			$new_trace = (string)$t['eleve'].",".(string)$t['ordreSerie'];
			if(in_array($new_trace, $existing_traces)){
				//Déjà inclus : on ne fait rien !
				$log.= "Duplication de la trace ".$new_trace."<br>";
			}
			else{
				$existing_traces[] = $new_trace;

				// ********************* Récupération des nombres du problème *********************

				$replacements = $t['replacements'];
				assert($replacements != null); // TODO : gérer par try catch...
				$readable_replacements = unserialize(base64_decode($replacements)); // echo "<br><br>".print_r(htmlentities(print_r($readable_replacements,true)),1)."<br><br>";
				$t_brut = $t['Text_brut'];

				preg_match_all($regexNombreX, $t_brut, $matches); // $matches[1] comprend les numéros des "NombreX", $matches[2] les valeurs données aux nombres
				// Organization of numbers in the class answer : $numbers["Cp1_v1"]=array("5"=>"P1", "12"=>"T1", "3"=>"d");

				$numbers_problem = array();

				for($i=0; $i<count($matches[1]); $i++) {
					//$numbers_problem[$matches[2][$i]] = "n".(string)$matches[1][$i]; // NOPE ON NE VEUT PAS $matches[2] 
					$n = $readable_replacements['<<Nombre('.(string)$matches[1][$i].')='.(string)$matches[2][$i].">>"];
					$numbers_problem[$n] = "n".(string)$matches[1][$i];
				}
				

				// ********************* Instanciation de la classe Answer et export *********************

				$answer = new Answer($t['zonetext'], $numbers_problem, $t['id']);
				$answer->process();

				// On teste si la trace a déjà été analysée
				if(exists_in_BDD('answer', 'idTrace=?', array($t['id']), $bdd)){
					$idAnswer = get_value_BDD('id', 'answer', 'idTrace=?', array($t['id']), $bdd);
				}
				else{
					$idAnswer = $answer->export($bdd);
					$answer->exportFormulas($bdd, $idAnswer);
				}


				// ********************* Comparaison avec les réponses attendues *********************

				if($expectedAnswer_analysis){
					// Gros problème : pour l'instant on ne gère que les cas où il y a une seule question... 
					$n_question = count_BDD('SELECT COUNT(*) FROM pbm_questions WHERE idTemplate=?', array($t['idTemplate']), $bdd);

					if($n_question == 1){
						$idQuestion = get_value_BDD('id', 'pbm_questions', 'idTemplate=?', array($t['idTemplate']), $bdd);

						//echo "<br>idQuest:". $idQuestion."<br>";
						// On récupère les expected_answers
						$expectedAnswers = $bdd->query('SELECT * FROM pbm_expectedAnswers WHERE idQuestion ='.$idQuestion);


					// *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** 
					// 1) On compare la version symbolique de la formule avec les expected_answers
					// *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** 

						// On veut comparer fetch()['variable'] avec $lastFormula['formul']...
						$formule_reponse = trim($answer->get_finalFormula());
						$formule_reponse = str_replace(' ', '', $formule_reponse);
						$log.= "form_rep : ".$formule_reponse."<br>";

						$formula_found = false;
						$propertiesAnswer = array();
						$goodAnswer = null;

						$allWordsArrays = array(); // Tous les mots clés pour chaque expected answer
						$foundFormulasWordsArrays = array(); // Les mots clés pour les expected answers dont la formule est détectée

						while($expAns = $expectedAnswers->fetch()){
							// On remplace les noms de variables par "n + numéro", et on supprime les espaces
							$toCompare = preg_replace("#[a-zA-Z]+([0-9]+)#", "n$1", str_replace(' ', '', $expAns['variable']));
							$log .= "to_comp : ".$toCompare."<br>";

							if($formule_reponse == $toCompare){
								$log.= "Réponse attendue détectée : ".$formule_reponse."<br>";
								$log.= "Propriétés de cette réponse : ".(string)$expAns['properties']."<br>";
								$log.= "Bonne réponse : ".(string)$expAns['goodAnswer']."<br>";
								$log.= "Calcul intemédiaire : ".(string)$expAns['intermComput']."<br>";

								$propertiesAnswer = explode("|||",$expAns['properties']);
								$goodAnswer = $expAns['goodAnswer'];
								//$foundFormulasWordsArrays[$expAns['id']] = explode(",", $expAns['keywords']);
								$foundFormulasWordsArrays[] = array("id"=> $expAns['id'], "words"=> explode(",", $expAns['keywords']));
								$formula_found = true;
							}
							
							// Surement il faudra un peu améliorer le prétraitement, explode ça a l'air de laisser des caractères qui devraient pas être pris en compte
							//$wordsArrays[$expAns['id']] = explode(",", $expAns['keywords']); //ça parait mieux pour récupérer l'id de la réponse par PickBest
							$wordsArrays[] = array("id" => $expAns['id'], "words" => explode(",", $expAns['keywords'])); //ça parait mieux pour récupérer l'id de la réponse par PickBest
							//$wordsArrays[] = explode(",", $expAns['keywords']); //sans la clé dans l'array
						}

						// *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** 
						// 2) On cherche les mots clés des expected answers
						// *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** 

						/*
							// Policy "on observe toutes les formules à la recherche des mots clés"
							if($verbose){
								$logPickBest = "<br>Log PickBest :-<br>";
							}
							else{
								$logPickBest = null;
							}
							$a = PickBest($t['zonetext'], $wordsArrays, $logPickBest);


							// Policy "on n'étudie que les formules qui correspondent à une formule de calcul"
							if($verbose){
								$logPickBestF .= "<br>Log PickBest pour les foundFormulas :-<br>";
							}
							else{
								$logPickBestF = null;
							}
							$b = PickBest($t['zonetext'], $foundFormulasWordsArrays, $logPickBestF);
						*/


						// Politique actuelle : si on a trouvé au moins une formule, on regarde les mots clés de cha
						if($verbose){
							$logPickBest = "<br>Log PickBest :-<br>";
						}
						else{
							$logPickBest = null;
						}

						$logPickBest  = null; //A VIRER PLUS TARD..

						if($formula_found){
							$interpretation = PickBest($t['zonetext'], $foundFormulasWordsArrays, $logPickBest);
							//peut être faudra différencier entre "1" et plus ?
						}
						else{
							$interpretation = PickBest($t['zonetext'], $wordsArrays, $logPickBest);
						}



						$log .= "<br><br>Une interprétation a été choisie :".print_r($interpretation, true);
						$log .= "<br>IdExpectedAnswer =".(string)$interpretation['id'];
						$log .= "<br>Note obtenue : ".(string)$interpretation['eval'];

						// *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** 
						// 3) il faudrait vérifier si le résultat final est bon même si la formule est pas trouvée..
						// *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** 


					}
					else{
						$log.= "Il y a 0 ou plus qu'une question dans ce template -> cela n'est pas géré pour le moment...<br>";
					}
				}
				
				// Récupération des données pour l'export pour STAR
				$idPbm = $t['pbm'];
				$idAnswerSubject = $count_answers; // Pas sûr...
				$idSession = $t['eleve']; // Plus ou moins comme "idSubject... au final"
				$subject = $t['eleve'];

				$t_AnswersPbm .= (string)$idAnswer.";".(string)$idPbm."\n"; //$idAnswers avec un "s" dans le fichier...
				$t_AnswersSession .= (string)$idAnswerSubject.";".(string)$idSession.";".(string)$idPbm.";".(string)$idAnswer."\n";

				// Pour les properties, il y a plusieurs lignes par sujet
				//$tabPropertiesAnswer = explode("|||", $t['properties']);
				foreach($propertiesAnswer as $propertyAnswer){
					$t_PropertiesAnswers .= (string)$propertyAnswer.";".(string)$idAnswer."\n";	
				}

				$tabPropertiesProblem = explode("|||", $t['properties']);
				foreach($tabPropertiesProblem as $propertyProblem){
					$t_PropertiesProblem .= (string)$propertyProblem.";".(string)$idPbm."\n";	
				}

				$t_Sessions .= (string)$idSession.";".(string)$subject."\n";

				$count_answers++;
			}
		}
		$req->closeCursor();

		if($download_zip){

			$directory_name = "diagnostic/diagnostics/".(string)$_SESSION['id']."_".(string)(time());
			mkdir($directory_name);

			$f_AnswersPbm = fopen($directory_name."/AnswersPbm.csv", "w");
			$f_AnswersSession = fopen($directory_name."/AnswersSession.csv", "w");
			$f_PropertiesAnswers = fopen($directory_name."/PropertiesAnswers.csv", "w");
			$f_PropertiesProblem = fopen($directory_name."/PropertiesProblem.csv", "w");
			$f_Sessions = fopen($directory_name."/Sessions.csv", "w");

			$toWrite_AnswersPbm = $header_AnswersPbm.$t_AnswersPbm;
			$toWrite_AnswersSession = $header_AnswersSession.$t_AnswersSession;
			$toWrite_PropertiesAnswers = $header_PropertiesAnswers.$t_PropertiesAnswers;
			$toWrite_PropertiesProblem = $header_PropertiesProblem.$t_PropertiesProblem;
			$toWrite_Sessions = $header_Sessions.$t_Sessions;

			fputs($f_AnswersPbm, $toWrite_AnswersPbm, strlen($toWrite_AnswersPbm));
			fputs($f_AnswersSession, $toWrite_AnswersSession, strlen($toWrite_AnswersSession));
			fputs($f_PropertiesAnswers, $toWrite_PropertiesAnswers, strlen($toWrite_PropertiesAnswers));
			fputs($f_PropertiesProblem, $toWrite_PropertiesProblem, strlen($toWrite_PropertiesProblem));
			fputs($f_Sessions, $toWrite_Sessions, strlen($toWrite_Sessions));

			fclose($f_AnswersPbm);
			fclose($f_AnswersSession);
			fclose($f_PropertiesAnswers);
			fclose($f_PropertiesProblem);
			fclose($f_Sessions);

			$zip = new ZipArchive();
			$serie_name = get_value_BDD('nomSerie', 'serie', 'idSerie=?', array($idSerie), $bdd);
			$zip_name = $serie_name."_".(string)date("d-m-Y").".zip";
			$dataP_name = $serie_name."_".(string)date("d-m-Y").".dataP";

			if($zip->open($zip_name, ZipArchive::CREATE) === true){
				$zip->addFile($directory_name."/AnswersPbm.csv", "AnswersPbm.csv");
				$zip->addFile($directory_name."/AnswersSession.csv", "AnswersSession.csv");
				$zip->addFile($directory_name."/PropertiesAnswers.csv", "PropertiesAnswers.csv");
				$zip->addFile($directory_name."/PropertiesProblem.csv", "PropertiesProblem.csv");
				$zip->addFile($directory_name."/Sessions.csv", "Sessions.csv");
				$zip->close();
		    }

		    // On renomme maintenant (si on le fait à la création du zip, le zip ne se forme pas bien :/)
		    rename($zip_name, $dataP_name); 
		    header('Content-Transfer-Encoding: binary'); //Transfert en binaire (fichier).
			header('Content-Disposition: attachment; filename='.$dataP_name); //Nom du fichier.
			header('Content-Length: '.filesize($dataP_name)); //Taille du fichier.
			readfile($dataP_name); 

			unlink($dataP_name);

			if($suppress_files){
				unlink($directory_name."/AnswersPbm.csv");
				unlink($directory_name."/AnswersSession.csv");
				unlink($directory_name."/PropertiesAnswers.csv");
				unlink($directory_name."/PropertiesProblem.csv");
				unlink($directory_name."/Sessions.csv");
				unlink("myLog.log");
				rmdir($directory_name);
			}

		}
		

	}
	
?>

<!DOCTYPE html>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Diagnostic</title>
		<link rel="stylesheet" type="text/css" href="static/css/view.css" media="all">
		<script type="text/javascript" src="static/js/view.js"></script>
	</head>
	<body id="main_body">
		<?php require_once("headerEnseignant.php"); ?>
			<div id="form_container">
			<h1><a>Untitled Form</a></h1>

				<h2>Choisir une série d'exercices à analyser</h2>

				<div>
					<?php
						$vosSeries = $bdd->prepare("SELECT * FROM serie WHERE idCreator = ? ORDER BY ordrePres");
						$vosSeries->execute(array($_SESSION['id']));
						while ($enregistrement = $vosSeries->fetch()){
							echo '<button onclick="diagnostic('.$enregistrement['idSerie'].')">'.$enregistrement['nomSerie'].'</button><br>';
						} 
						$vosSeries->closeCursor();

						$autresSeries = $bdd->prepare("SELECT * FROM serie WHERE idCreator <> ? ORDER BY ordrePres");
						$autresSeries->execute(array($_SESSION['id']));

						while ($enregistrement = $autresSeries->fetch()){
							echo '<button onclick="diagnostic('.$enregistrement['idSerie'].')">'.$enregistrement['nomSerie'].'</button><br>';
						}
						$autresSeries->closeCursor();
					?>
					</select>
				</div>


				<form id="form_diagnostic" method="post" action="diagnostic.php">
					<input type="hidden" value="" name="serieToDiagnose" id="serieToDiagnose">
				</form>


				<div id="feedback">
					<p>
					<?php
						if($verbose){ // Faudrait clairement faire l'echo autre part
							echo $log;
							if(isset($logPickBest)){echo $logPickBest;}
						}
						?>
					</p>
				</div>

			</div>

		<img id="bottom" src="static/images/bottom.png" alt="">
	</body>
	<script type="text/javascript">
		function diagnostic(idSerie){
			form_diagnostic = document.getElementById("form_diagnostic");
			serieToDiagnose = document.getElementById("serieToDiagnose");
			serieToDiagnose.value = idSerie;
			form_diagnostic.submit();
		}
	</script>
</html>
