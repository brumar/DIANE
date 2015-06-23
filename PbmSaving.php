<?php
	require_once("verifSessionProf.php");
	require_once("conn_pdo.php");

	if ((isset($_POST['infos']))&&(!(empty($_POST['infos'])))){
		
		$infos=$_POST['infos'];
		$infos=unserialize(base64_decode($infos));
		//********MISE A JOUT DE PBM_TEMPLATE******DEBUT
		/*
		$c = (!isset($infos["constraints"])) ? '' : mysql_real_escape_string($infos["constraints"]);
		$prop = (!isset($infos["properties"])) ? '' : mysql_real_escape_string(implode('|||',$infos["properties"]));
		$comp = (!isset($infos["compteurs"])) ? '' : mysql_real_escape_string(serialize($infos["compteurs"]));
		$html = (!isset($infos["html"])) ? '' : mysql_real_escape_string($infos["html"]);
		$brut = (!isset($infos["texteBrut"])) ? '' : mysql_real_escape_string($infos["texteBrut"]);
		$private = (!isset($infos["private"])) ? '' : mysql_real_escape_string($infos["private"]);
		$public = (!isset($infos["public"])) ? '' : mysql_real_escape_string($infos["public"]);
		*/
		//echo($brut);

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
		
		
		//********MISE A JOUT DE PBM_questions******DEBUT
		
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
					if(isset($infos['Qinfos']["properties"][$i][$a])){$properties=implode('|||',$infos['Qinfos']["properties"][$i][$a]);}
					
					$req = $bdd-> prepare("INSERT INTO pbm_questions (idQuestion, Number, variable, keywords, comments, properties) VALUES (:idQuestion, :Number, :variable, :keywords, :comments, :properties)");
					$req->execute(array(
						'idQuestion' => $idQuestion, 
						'Number' => $number, 
						'variable' => $variable, 
						'keywords' => $keywords, 
						'comments' => $comments, 
						'properties' => $properties));
				}	
			}
		}
		
	}
?>

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Creation de problème</title>
	<link rel="stylesheet" type="text/css" href="static/css/view.css" media="all">
	</head>
	<body>
		<?php include("headerEnseignant.php"); ?>
		<br><br>



		<img id="top" src="static/images/top.png" alt="">
			<div id="form_container">
				<form id="form_470585" class="appnitro"  method="post" action="">
				<p>Votre type de problème a bien été enregistré.</p>
				<a href="PickPbm.php?id=<?php echo($index);?>">En faire une version utilisable dès maintenant</a><br><br>
				<a href="profil_enseignant.php">Retour</a>
				</form>
			</div>
			
	</body>
</html>