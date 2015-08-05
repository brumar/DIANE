<?php
	require_once("verifSessionProf.php");
	require_once("conn_pdo.php");

	if ((isset($_SESSION['infos']))&&(!(empty($_SESSION['infos'])))){
		
		$infos=$_SESSION['infos'];

		$c = (!isset($infos["constraints"])) ? '' : $infos["constraints"];
		$prop = (!isset($infos["properties"])) ? '' : implode('|||',$infos["properties"]);
		$comp = (!isset($infos["compteurs"])) ? '' : serialize($infos["compteurs"]);
		$html = (!isset($infos["html"])) ? '' : $infos["html"];
		$brut = (!isset($infos["texteBrut"])) ? '' : $infos["texteBrut"];
		$private = (!isset($infos["private"])) ? '' : $infos["private"];
		$public = (!isset($infos["public"])) ? '' : $infos["public"];


		$req = $bdd->prepare('INSERT INTO pbm_template (constraints, public_notes, compteurs, Text_html, Text_brut, properties, private_notes, idCreator) VALUES (:constraints, :public_notes, :compteurs, :Text_html, :Text_brut, :properties, :private_notes, :idCreator)');
		$req->execute(array(
			'constraints' => $c,
			'public_notes' => $public,
			'compteurs' => $comp,
			'Text_html' => $html,
			'Text_brut' => $brut,
			'properties' => $prop,
			'private_notes' => $private,
			'idCreator' => $_SESSION['id']));

		$req->closeCursor();
		
		//********MISE A JOUT DE PBM_TEMPLATE******FIN
		$index = $bdd->lastInsertId();
		

		//renommage du dossier audio si existant avec l'identifiant du problème
		
		if(isset($infos['temp']['AUDIO'])){$location="audio/pbm_instancied/exo$index";rename($infos['temp']['AUDIO'],$location);}
		//fin
		
		
		//********MISE A JOUT DE PBM_ELEMENTS******DEBUT

		foreach ($infos['clones'] as $clone_element){		
			$type= $clone_element[1][0];
			$expression= $clone_element[3][0];
			$compteur= $clone_element[2][0];
			$brut= $clone_element[0][0];


			$req = $bdd-> prepare("INSERT INTO pbm_elements (idTemplate, type, expression, compteur, brut) VALUES (:idTemplate, :type, :expression, :compteur, :brut)");
			$req->execute(array(
				'idTemplate' => $index, 
				'type' => $type,
				'expression' => $expression, 
				'compteur' => $compteur, 
				'brut' => $brut));

			$req->closeCursor();
		}
		
		//********MISE A JOUT DE PBM_ELEMENTS******FIN
		
		
		//********MISE A JOUT DE PBM_questions et pbm_expectedanswers******DEBUT
		
		foreach ($infos['questions'] as $i => $question_element){
			$type = $question_element[1][0];
			$expression = $question_element[3][0];
			$compteur = $question_element[2][0];
			$brut = $question_element[0][0];
			
			$req = $bdd-> prepare("INSERT INTO pbm_questions (idTemplate, Number, type, expression, compteur, brut) VALUES (:idTemplate, :Number, :type, :expression, :compteur, :brut)");
			$req->execute(array(
				'idTemplate' => $index, 
				'Number' => $i, 
				'type' =>$type , 
				'expression' => $expression, 
				'compteur' => $compteur, 
				'brut' => $brut));

			//FIN TABLEAU QUESTIONS
			$idQuestion = $bdd->lastInsertId();//recup de l'idQuestion
			$req->closeCursor();

			if(isset($infos['Qinfos']['description'])){
				foreach($infos['Qinfos']['description'][$i] as $a=>$answer){
					$number=$a;
					//echo($a);
					$variable = $answer["variable"];
					$keywords = $answer["keywords"];
					$comments = $answer["comments"];
					$properties="";
					//print_r($infos['Qinfos']["properties"]);
					if(isset($infos['Qinfos']["properties"][$i][$a])){
						$properties=implode('|||',$infos['Qinfos']["properties"][$i][$a]);
					}

					if(isset($answer["good_answer"])){
						if($answer["good_answer"] == "oui"){
							$good_answer = true;
						}
						else if($answer["good_answer"] == "non"){
							$good_answer = false;
						}
						else{
							$good_answer = null;
						}
					}
					else{
						$good_answer = null;
					}
					
					$req = $bdd-> prepare("INSERT INTO pbm_expectedanswers (idQuestion, Number, variable, keywords, comments, properties, goodAnswer) VALUES (:idQuestion, :Number, :variable, :keywords, :comments, :properties, :goodAnswer)");
					$req->execute(array(
						'idQuestion' => $idQuestion, 
						'Number' => $number, 
						'variable' => $variable, 
						'keywords' => $keywords, 
						'comments' => $comments, 
						'properties' => $properties,
						'goodAnswer' => $good_answer));
				}	
			}
		}
		$_SESSION['flagTemplateSaving'] = true;
		$_SESSION['templateIdIndex'] = $index;
		header("Location: enregistrement.php");
	}
	else{
		header("Location: profil_enseignant.php");
	}
?>
