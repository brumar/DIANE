<?php
	require_once("verifSessionChercheur.php");
	require_once("conn_pdo.php");
	require_once("ListFunction.php");
	require_once("diagnostic/class.answer.php");
	require_once("diagnostic/parsingFunctions.php");

	$verbose = false; // if true, print feedback
	$download_zip = false; // does the client download the zip (dataP) ?
	$suppress_files = true; //  does the server suppress the files after the download ,	
	$diag_auto = null;
	$log = "";

	function supprAccents($text){
		$text = strtr($text, 'ÁÀÂÄÃÅÇÉÈÊËÍÏÎÌÑÓÒÔÖÕÚÙÛÜÝ', 'AAAAAACEEEEEIIIINOOOOOUUUUY');
		$text = strtr($text, 'áàâäãåçéèêëíìîïñóòôöõúùûüýÿ', 'aaaaaaceeeeiiiinooooouuuuyy');
		return $text;
	}

	function replace_clones($words, $replacements, $clones){
		// Remplace les noms des clones par leur valeur (utilisé sur les mots clés recherchés)
		// $words : la liste de mots clés de cette réponse attendue
		// $replacements : les replacements tels que stockés dans la table pbm mis 
		// $clones : la liste des clones

		$newWords = array();
		foreach($words as $w){
			foreach($clones as $cc){
				$c = $cc['type'].(string)$cc['compteur'];

				if($pos = stripos($w, $c)){ 
					$compteur = substr($c, -1);
					$name = substr($c, 0, strlen($c)-1);
					$index = '<<'.$cc['brut'].'>>';
					$repl = $replacements[$index];
					$w = substr_replace($w, $repl, $pos, strlen($w));
				}
			}
			$newWords[] = $w;
		}
		return $newWords;
	}

	

	$pbm_included = array();


	if(isset($_POST['diag_auto'])){
		$diag_auto = $_POST['diag_auto'];
	}
	if(isset($_POST['dl_dataP'])){
		$download_zip = $_POST['dl_dataP'];
	}

	if(isset($_POST['serieToDiagnose'])){
		
		$idSerie = $_POST['serieToDiagnose'];

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

		$regexNombreX = '#<<Nombre\(([0-9]+)\)=([0-9]+)>>#';


		if($diag_auto){
			while($t = $req->fetch()){
				// Pour chaque trace, on choisit une expected_answer, soit automatiquement, soit à la main
				
				$t_id_trace = $t[0]; // Pour une raison moche sur la jointure... (il y a plusieurs paramètres nommées "id", $t['id'] ne désigne pas l'id de la trace)
				$goodAnswer = null;

				// $t contient la jointure complexe entre trace, pbm et pb_template
				// Il faut prendre en compte uniquement la première fois qu'un élève a rempli la série si jamais il l'a passée plusieurs fois
				// => On retient "eleve - ordreSerie", et on vérifie que ce n'est pas inclus

				$new_trace = (string)$t['eleve'].",".(string)$t['ordreSerie'];
				if(in_array($new_trace, $existing_traces)){ //Déjà inclus : on ne fait rien
					$log.= "Duplication de la trace ".$new_trace."<br>";
				}
				else{
					$existing_traces[] = $new_trace;

					// ********************* Récupération des nombres du problème *********************
					
					// Code surement améliorable, exploite pas pbm_elements
					$replacements = $t['replacements'];
					assert($replacements != null); // TODO : gérer par try catch...
					$readable_replacements = unserialize(base64_decode($replacements)); // echo "<br><br>".print_r(htmlentities(print_r($readable_replacements,true)),1)."<br><br>";
					$t_brut = $t['Text_brut'];

					preg_match_all($regexNombreX, $t_brut, $matches); // $matches[1] comprend les numéros des "NombreX", $matches[2] les valeurs données aux nombres
					// Organization of numbers in the class answer : $numbers["Cp1_v1"]=array("5"=>"P1", "12"=>"T1", "3"=>"d");

					$numbers_problem = array();
					for($i=0; $i<count($matches[1]); $i++) {
						$n = $readable_replacements['<<Nombre('.(string)$matches[1][$i].')='.(string)$matches[2][$i].">>"];
						$numbers_problem[$n] = "n".(string)$matches[1][$i];
					}
					
					$reqClone = $bdd->query('SELECT * FROM pbm_elements WHERE idTemplate='.$t['idTemplate']);
					$clones = array();
					while($clone = $reqClone->fetch()){
						$clones[] = $clone;
					}

					// ********************* Instanciation de la classe Answer et export *********************

					$answer = new Answer($t['zonetext'], $numbers_problem, $t_id_trace);
					$answer->process();

					// On teste si la trace a déjà été analysée : si oui, on ne la recréée pas
					if(exists_in_BDD('answer', 'idTrace=?', array($t_id_trace), $bdd)){
						$idAnswer = get_value_BDD('id', 'answer', 'idTrace=?', array($t_id_trace), $bdd);
					}
					else{
						$idAnswer = $answer->export($bdd);
						$answer->exportFormulas($bdd, $idAnswer);
					}

					$interpretable_answer = get_value_BDD('interpretable', 'answer', 'id=?', array($idAnswer), $bdd);

					// ********************* Comparaison avec les réponses attendues *********************
					// pour l'instant on ne gère que les cas où il y a une seule question... 

					$n_question = count_BDD('SELECT COUNT(*) FROM pbm_questions WHERE idTemplate=?', array($t['idTemplate']), $bdd);

					if($n_question == 1){
						$idQuestion = get_value_BDD('id', 'pbm_questions', 'idTemplate=?', array($t['idTemplate']), $bdd);
						$expectedAnswers = $bdd->query('SELECT * FROM pbm_expectedAnswers WHERE idQuestion ='.$idQuestion);

						// *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** 
						// 1) On compare la version symbolique de la formule avec les expected_answers
						// *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** 

						$formule_reponse = trim($answer->get_finalFormula());
						$formule_reponse = str_replace(' ', '', $formule_reponse);
						$log.= "form_rep : ".$formule_reponse."<br>";

						$formula_found = false;
						$propertiesAnswer = array();
						//$goodAnswer = null;

						$allWordsArrays = array(); // Tous les mots clés pour chaque expected answer
						$foundFormulasWordsArrays = array(); // Les mots clés pour les expected answers dont la formule est détectée

						while($expAns = $expectedAnswers->fetch()){
							// On remplace les noms de variables par "n + numéro", et on supprime les espaces
							$toCompare = preg_replace("#[a-zA-Z]+([0-9]+)#", "n$1", str_replace(' ', '', $expAns['variable']));
							$log .= "to_comp : ".$toCompare."<br>";

							//On utilise un tableau pour gérer les cas de dissociation de plusieurs réponses équivalentes (N1+N2|N2+N1)
							$tabToCompare = array();
							if(strpos($toCompare, "|")){
								$tabToCompare = explode("|", $toCompare);
							}
							else{
								$tabToCompare[] = $toCompare;
							}
							
							foreach($tabToCompare as $formToCompare){
								if($formule_reponse == $formToCompare){
									$log.= "Réponse attendue détectée : ".$formule_reponse."<br>";
									$log.= "Propriétés de cette réponse : ".(string)$expAns['properties']."<br>";
									$log.= "Bonne réponse : ".(string)$expAns['goodAnswer']."<br>";
									$log.= "Calcul intemédiaire : ".(string)$expAns['intermComput']."<br>";

									$propertiesAnswer = explode("|||",$expAns['properties']);
									$goodAnswer = $expAns['goodAnswer'];

									$key_words = replace_clones(explode(",", $expAns['keywords']), $readable_replacements, $clones);
									$foundFormulasWordsArrays[] = array("id"=> $expAns['id'], "words"=> $key_words);
									$formula_found = true;
									break;
								}
							}

							if(!($formula_found)){
								// Surement il faudra un peu améliorer le prétraitement, explode ça a l'air de laisser des caractères qui devraient pas être pris en compte
								$key_words = replace_clones(explode(",", $expAns['keywords']), $readable_replacements, $clones);
								$wordsArrays[] = array("id" => $expAns['id'], "words" => $key_words);
							}
						}
						
						// *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** 
						// 2) On cherche les mots clés des expected answers
						// *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** 

						// Policy : si on a trouvé au moins une formule, on regarde les mots clés de ces formules trouvées
						$logPickBest = ($verbose)? "<br>Log PickBest :-<br>": null;	

						if($formula_found){
							$interpretation = PickBest($t['zonetext'], $foundFormulasWordsArrays, $logPickBest);
						}
						else{ // Si on a pas trouvé de formule, on reprend toutes les interprétations possibles
							$interpretation = PickBest($t['zonetext'], $wordsArrays, $logPickBest);
						}

						$log .= "<br><br>Une interprétation a été choisie :".print_r($interpretation, true);
						$log .= "<br>IdExpectedAnswer =".(string)$interpretation['id'];
						$log .= "<br>Note obtenue : ".(string)$interpretation['eval'];

						// *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** 
						// 3) il faudrait vérifier si le résultat final est bon même si la formule est pas trouvée ? 
						// *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** 
						// Géré par la classe Answer ?

					}
					else{ // Il y a 0 ou plus qu'une question => le diagnostic n'est pas actuellement géré
						$log.= "Il y a 0 ou plus qu'une question dans ce template -> cela n'est pas géré pour le moment...<br>";
					}
					
					

					// Récupération des données pour l'export pour STAR
					$idPbm = $t['pbm'];
					$idSession = $t['eleve']; // Pour l'instant on différencie pas d'idSubject
					$subject = $t['eleve'];

					$t_AnswersPbm .= (string)$idAnswer.";".(string)$idPbm."\n"; //$idAnswers avec un "s" dans le fichier...
					$t_AnswersSession .= (string)$idSession.";".(string)$idPbm.";".(string)$idAnswer."\n";

					// Properties Answer
					if(!$interpretable_answer){
						$t_PropertiesAnswers .= "ininterprétable;".(string)$idAnswer."\n";			
					}
					foreach($propertiesAnswer as $propertyAnswer){
						$t_PropertiesAnswers .= (string)$propertyAnswer.";".(string)$idAnswer."\n";	
					}
					if(isset($goodAnswer)){
						if($goodAnswer){
							$t_PropertiesAnswers .= "bonne_réponse;".(string)$idAnswer."\n";
						}
					}
					if($answer->noFormula()){
						$t_PropertiesAnswers .= "pas_de_réponse;".(string)$idAnswer."\n";			
					}

					if(!(in_array($idPbm, $pbm_included))){
						$pbm_included[] = $idPbm;
						$tabPropertiesProblem = explode("|||", $t['properties']);
						foreach($tabPropertiesProblem as $propertyProblem){
							if($propertyProblem != ""){
								$t_PropertiesProblem .= (string)$propertyProblem.";".(string)$idPbm."\n";	
							}
						}
					}

					$t_Sessions .= (string)$idSession.";".(string)$subject."\n";

					// TODO : faudrait actualiser la table answer dans la BDD



				}
			} //fin du while($t = $req->fetch())
			$req->closeCursor();

			if($download_zip){

				$directory_name = "diagnostic/diagnostics/".(string)$_SESSION['id']."_".(string)(time());
				mkdir($directory_name);

				$f_AnswersPbm = fopen($directory_name."/AnswersPbm.csv", "w");
				$f_AnswersSession = fopen($directory_name."/AnswersSession.csv", "w");
				$f_PropertiesAnswers = fopen($directory_name."/PropertiesAnswers.csv", "w");
				$f_PropertiesProblem = fopen($directory_name."/PropertiesProblem.csv", "w");
				$f_Sessions = fopen($directory_name."/Sessions.csv", "w");

				$header_AnswersPbm = "idAnswers;idPbm\n";
				$header_AnswersSession = "idSession;idPbm;idAnswer\n";
				$header_PropertiesAnswers = "idPropertiesAnswer;idAnswer\n";
				$header_PropertiesProblem = "idPropertiesProblem;idProblem\n";
				$header_Sessions = "sessionID;subject\n";

				$toWrite_AnswersPbm = $header_AnswersPbm.$t_AnswersPbm;
				$toWrite_AnswersSession = $header_AnswersSession.$t_AnswersSession;
				$toWrite_PropertiesAnswers = $header_PropertiesAnswers.$t_PropertiesAnswers;
				$toWrite_PropertiesProblem = $header_PropertiesProblem.$t_PropertiesProblem;
				$toWrite_Sessions = $header_Sessions.$t_Sessions;

				// $toWrite_AnswersPbm = supprAccents($header_AnswersPbm.$t_AnswersPbm);
				// $toWrite_AnswersSession = supprAccents($header_AnswersSession.$t_AnswersSession);
				// $toWrite_PropertiesAnswers = supprAccents($header_PropertiesAnswers.$t_PropertiesAnswers);
				// $toWrite_PropertiesProblem = supprAccents($header_PropertiesProblem.$t_PropertiesProblem);
				// $toWrite_Sessions = supprAccents($header_Sessions.$t_Sessions);

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

			    /*// VIRER TOUT CA A LA FIN DES TESTS
				    header('Content-Transfer-Encoding: binary'); //Transfert en binaire (fichier).
					header('Content-Disposition: attachment; filename='.$zip_name); //Nom du fichier.
					header('Content-Length: '.filesize($zip_name)); //Taille du fichier.
					readfile($zip_name); 
				///*/


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
		else{ // Diagnostic step by step
			$data_diag_step_by_step = array();
			while($t = $req->fetch()){ 
				$data_expected_answers = array();
				$t_id_trace = $t[0];
				$new_trace = (string)$t['eleve'].",".(string)$t['ordreSerie'];
				
				if(!(in_array($new_trace, $existing_traces))){
					$existing_traces[] = $new_trace;

					// ********************* Récupération des nombres du problème *********************
					
					$replacements = $t['replacements'];
					assert($replacements != null); 
					$readable_replacements = unserialize(base64_decode($replacements));
					$t_brut = $t['Text_brut'];
					preg_match_all($regexNombreX, $t_brut, $matches); 

					$numbers_problem = array();
					for($i=0; $i<count($matches[1]); $i++) {
						$n = $readable_replacements['<<Nombre('.(string)$matches[1][$i].')='.(string)$matches[2][$i].">>"];
						$numbers_problem[$n] = "n".(string)$matches[1][$i];
					}
					
					$reqClone = $bdd->query('SELECT * FROM pbm_elements WHERE idTemplate='.$t['idTemplate']);
					$clones = array();
					while($clone = $reqClone->fetch()){
						$clones[] = $clone;
					}

					// ********************* Instanciation de la classe Answer et export *********************

					$answer = new Answer($t['zonetext'], $numbers_problem, $t_id_trace);
					$answer->process();

					// On teste si la trace a déjà été analysée : si oui, on ne la recréée pas
					if(exists_in_BDD('answer', 'idTrace=?', array($t_id_trace), $bdd)){
						$idAnswer = get_value_BDD('id', 'answer', 'idTrace=?', array($t_id_trace), $bdd);
					}
					else{
						$idAnswer = $answer->export($bdd);
						$answer->exportFormulas($bdd, $idAnswer);
					}

					$interpretable_answer = get_value_BDD('interpretable', 'answer', 'id=?', array($idAnswer), $bdd);

					// ********************* Comparaison avec les réponses attendues *********************
					// pour l'instant on ne gère que les cas où il y a une seule question... 

					$n_question = count_BDD('SELECT COUNT(*) FROM pbm_questions WHERE idTemplate=?', array($t['idTemplate']), $bdd);

					if($n_question == 1){
						$idQuestion = get_value_BDD('id', 'pbm_questions', 'idTemplate=?', array($t['idTemplate']), $bdd);
						$expectedAnswers = $bdd->query('SELECT * FROM pbm_expectedAnswers WHERE idQuestion ='.$idQuestion);

						// *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** 
						// 1) On compare la version symbolique de la formule avec les expected_answers
						// *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** 

						$formule_reponse = trim($answer->get_finalFormula());
						$formule_reponse = str_replace(' ', '', $formule_reponse);
						$formula_found = false;

						$allWordsArrays = array(); // Tous les mots clés pour chaque expected answer
						$foundFormulasWordsArrays = array(); // Les mots clés pour les expected answers dont la formule est détectée

						

						while($expAns = $expectedAnswers->fetch()){
							// On remplace les noms de variables par "n + numéro", et on supprime les espaces
							$toCompare = preg_replace("#[a-zA-Z]+([0-9]+)#", "n$1", str_replace(' ', '', $expAns['variable']));

							//On utilise un tableau pour gérer les cas de dissociation de plusieurs réponses équivalentes (N1+N2|N2+N1)
							$tabToCompare = array();
							if(strpos($toCompare, "|")){
								$tabToCompare = explode("|", $toCompare);
							}
							else{
								$tabToCompare[] = $toCompare;
							}
							
							foreach($tabToCompare as $formToCompare){
								if($formule_reponse == $formToCompare){

									$key_words = replace_clones(explode(",", $expAns['keywords']), $readable_replacements, $clones);
									$foundFormulasWordsArrays[] = array("id"=> $expAns['id'], "words"=> $key_words);
									$formula_found = true;
									break;
								}
							}

							if(!($formula_found)){
								// Surement il faudra un peu améliorer le prétraitement, explode ça a l'air de laisser des caractères qui devraient pas être pris en compte
								$key_words = replace_clones(explode(",", $expAns['keywords']), $readable_replacements, $clones);
								$wordsArrays[] = array("id" => $expAns['id'], "words" => $key_words);
							}


							$newExpAns = array();
							$newExpAns['id'] = $expAns['id'];
							$newExpAns['variable'] = $expAns['variable'];
							$newExpAns['keywords'] = $expAns['keywords'];
							$newExpAns['comments'] = $expAns['comments'];
							$newExpAns['properties'] = $expAns['properties'];
							$data_expected_answers[] = $newExpAns;

						}
						
						// *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** 
						// 2) On cherche les mots clés des expected answers
						// *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** 

						if($formula_found){
							$interpretation = PickBest($t['zonetext'], $foundFormulasWordsArrays);
						}
						else{
							$interpretation = PickBest($t['zonetext'], $wordsArrays);
						}

						$newData = array();
						$newData["id_trace"] = $t_id_trace;
						$newData["pbm_enonce"] = $t['enonce'];
						$newData["reponse_eleve"] = $t['zonetext'];
						$newData["reponses_attendues"] = $data_expected_answers;
							
						if($answer->noFormula()){
							$newData["reponse_suggeree"] = -1;					
						}
						elseif(!$interpretable_answer){
							$newData["reponse_suggeree"] = -2;
						}
						else{
							$newData["reponse_suggeree"] = $interpretation['id'];
						}
						
						$data_diag_step_by_step[] = $newData;

					} // fin de "il y a une seule question"
				} // fin de if(!(in_array($new_trace, $existing_traces))){
			} //fin du while($t = $req->fetch())
			$req->closeCursor();
		}
	}
	
?>

<!DOCTYPE html>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Diagnostic</title>
		<link rel="stylesheet" type="text/css" href="static/css/view.css" media="all">
		<link rel="stylesheet" type="text/css" href="static/css/diagStepByStep.css" media="all">
		<script type="text/javascript" src="static/js/view.js"></script>
	</head>
	<body id="main_body">
		<?php require_once("headerEnseignant.php"); ?>
			<div id="form_container">
			<h1><a>Untitled Form</a></h1>
				
				<h2>Choisissez les modalités du diagnostic</h2>
				<form id="form_diagnostic" method="post" action="diagnostic.php">
					<p>Voulez vous que le diagnostic soit automatic ou bien qu'il soit simplement assisté ?</p>
					<input type="radio" name="diag_auto" id="diag_auto_auto" value="1">Automatique
					<input type="radio" name="diag_auto" id="diag_auto_step" value="0">Pas à Pas

					<p>Voulez vous télécharger le fichier dataP (à utiliser dans STAR) ?</p>
					<input type="radio" name="dl_dataP" id="dl_dataP_oui" value="1">oui
					<input type="radio" name="dl_dataP" id="dl_dataP_non" value="0">non

					<h2>Choisir une série d'exercices à analyser</h2>

					<div>
						<?php
							$vosSeries = $bdd->prepare("SELECT * FROM serie WHERE idCreator = ? ORDER BY ordrePres");
							$vosSeries->execute(array($_SESSION['id']));
							while ($enregistrement = $vosSeries->fetch()){
								echo '<button onclick="check_diagnostic('.$enregistrement['idSerie'].')">'.$enregistrement['nomSerie'].'</button><br>';
							} 
							$vosSeries->closeCursor();

							$autresSeries = $bdd->prepare("SELECT * FROM serie WHERE idCreator <> ? ORDER BY ordrePres");
							$autresSeries->execute(array($_SESSION['id']));

							while ($enregistrement = $autresSeries->fetch()){
								echo '<button onclick="check_diagnostic('.$enregistrement['idSerie'].')">'.$enregistrement['nomSerie'].'</button><br>';
							}
							$autresSeries->closeCursor();
						?>
						</select>
					</div>

					<input type="hidden" value="" name="serieToDiagnose" id="serieToDiagnoseID">
				</form>


				<!-- <form id="form_diagnostic2" method="post" action="diagnostic.php">
					<input type="hidden" value="" name="serieToDiagnose" id="serieToDiagnoseID">
				</form> -->


				<div id="feedback">
					<p>
					<?php
						if($verbose){
							echo $log;
							if(isset($logPickBest)){echo $logPickBest;}
						}
						?>
					</p>
				</div>

				<div id="diag_step_by_step">
					<?php
						if(isset($diag_auto)){

							if(!($diag_auto)){
								if(count($data_diag_step_by_step)>0){
									$i = 1;
									foreach($data_diag_step_by_step as $taa){ //$taa pour "trace à analyser"
										echo '<div class="taa" id="taa_'.(string)$i. '">';
											echo 'Enoncé du Problème :';
											echo '<p class="taa_pbm">'.$taa['pbm_enonce'].'</p>';
											echo 'Réponse de l\'élève :';
											echo '<p class="taa_rep">'.$taa['reponse_eleve'].'</p>';
											echo 'Réponses attendues (suggestion de DIANE encadrée) :';


											foreach($taa["reponses_attendues"] as $repAt){

												if($taa['reponse_suggeree']==$repAt['id']){
													echo '<div class="rep_attendue suggested" onclick="choice_expAns('.$repAt['id'].','.$taa['id_trace'].');" id="'.$taa['id_trace']."_".$repAt['id'].'">'.$repAt['variable']."<br>".$repAt['keywords'].'</div>';
												}
												else{
													echo '<div class="rep_attendue" onclick="choice_expAns('.$repAt['id'].','.$taa['id_trace'].');" id="'.$taa['id_trace']."_".$repAt['id'].'">'.$repAt['variable']."<br>".$repAt['keywords'].'</div>';
												}
												
											}
											if($taa['reponse_suggeree']==-1){
												echo '<div class="rep_attendue suggested" onclick="choice_expAns(-1,'.$taa['id_trace'].');" id="'.$taa['id_trace'].'_noFormula">Pas de formule<br></div>';
											}
											else{
												echo '<div class="rep_attendue" onclick="choice_expAns(-1,'.$taa['id_trace'].');" id="'.$taa['id_trace'].'_noFormula">Pas de formule<br></div>';	
											}
											if($taa['reponse_suggeree']==-2){
												echo '<div class="rep_attendue suggested" onclick="choice_expAns(-2,'.$taa['id_trace'].');" id="'.$taa['id_trace'].'_ininterpretable">ininterprétable<br></div>';
											}
											else{
												echo '<div class="rep_attendue" onclick="choice_expAns(-2,'.$taa['id_trace'].');" id="'.$taa['id_trace'].'_ininterpretable">ininterprétable<br></div>';
											}
										echo '</div>';

										$i++;
									}
								}
								else{
									echo "Cette série n'est pas interprétable (les prolbèmes ne sont pas associés à des templates), ou bien il n'y a aucune réponse d'élève.";
								}
							}
						}
					?>
				</div>

				<!-- <form id="form_step_by_step" method="post" action="diagnostic.php" onsubmit="return form_save()">
					<input type="submit" value="Sauvegarder progression">
					<input type="hidden" value="" name="" id="">
				</form> -->

			</div>

		<img id="bottom" src="static/images/bottom.png" alt="">
	</body>
	<script type="text/javascript">

		function form_save(){
			alert("Sauvegarder");
			return false;
		}

		function check_diagnostic(idSerie){
			form_diagnostic = document.getElementById("form_diagnostic");
			serieToDiagnose = document.getElementById("serieToDiagnoseID");
			serieToDiagnose.value = idSerie;
			form_diagnostic.submit();
		}


		var visibleExpAns = null;
		var current_taa = 0;
		var choices = [];

		function choice_expAns(idExpAns, idTrace){
			<?php 
			if($diag_auto){
				echo "if(false){";
			}
			?>

			choices.push(idExpAns);
			current_taa+=1;
			if(current_taa >= <?php if(isset($data_diag_step_by_step)){echo count($data_diag_step_by_step);}else{echo "4";}?> ){
				alert("Toutes les réponses ont été catégorisées");
			}
			else{
				display_choose_expAns();	
			}

			<?php 
			if($diag_auto){
				echo "}";
			}
			?>
			
		}
		
		function display_choose_expAns(){
			<?php 
			if($diag_auto){
				echo "if(false){";
			}
			?>

			if(visibleExpAns != null){
				document.getElementById(visibleExpAns).style.display = 'none';
			}
			visibleExpAns = 'taa_'+String(current_taa+1);
			document.getElementById(visibleExpAns).style.display = 'block';
			
			<?php 
			if($diag_auto){
				echo "}";
			}
			?>
		};

		display_choose_expAns();

	</script>
</html>
