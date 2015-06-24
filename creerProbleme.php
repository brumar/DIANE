<?php
	session_start();
	$default_pbm_type = 1; //TODO : gérer les types de problèmes


	if(isset($_SESSION['login'])) {

		//if (isset($_POST['replacements'])){$replacements=$_POST['replacements'];}
		//$sql = "INSERT INTO pbm_instancied (numero, idpbm,text, replacements) VALUES (NULL, '$idpbm', '$text', '$replacements');";


		if (isset($_POST['enonce'])) {
			$text_enonce = $_POST['enonce'];

			// TODO : vérification que "enonce" contient un énoncé correct ? Plutôt faire ça en JS
			// TODO : implémenter des "sauts de ligne" dans les énoncés. => permettre d'avoir du HTML, surement.

			//Enregistrement
			require_once("conn_pdo.php");
			$reqInsert = $bdd->prepare('INSERT INTO pbm(enonce, type, idCreator) VALUES(?, ?, ?)');
			$idCreator = $_SESSION['id'];

			if($reqInsert->execute(array($text_enonce, $default_pbm_type, $idCreator) ) ) {
				$_SESSION['pbm_recorded'] = true;
				header("Location: " . $_SERVER['REQUEST_URI']); // Redirige pour éviter de prendre plusieurs fois le questionnaire en compte
   				exit();
			}
			else{
				$_SESSION['pbm_recorded'] = false;
				// Faudrait plutôt un try catch ?
			}
		}

	}
	else{
		header("Location: enseignant.php"); //TODO : Message ?
	}

	



?>



<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Création de problème</title>
		<link rel="stylesheet" type="text/css" href="static/css/view.css" media="all">
		<script type="text/javascript" src="static/js/view.js"></script>
		<script type="text/javascript" src="static/js/userscript.js"></script>
	</head>
	

	<body id="main_body" >
		<img id="top" src="static/images/top.png" alt="">
		<div id="form_container">
		<h1><a>Untitled Form</a></h1>
		<form name="form1" id="form1" class="appnitro" method="post" action="creerProbleme.php">
				<h2>Enregistrez votre énoncé </h2>
				<?php 
					if(isset($_SESSION['pbm_recorded'])){
						if ($_SESSION['pbm_recorded']){
							echo "Votre problème a bien été enregistré.";
						}
						else{
							echo "Il y a eu un problème lors de l'enregistrement du problème.";
						}
						unset($_SESSION['pbm_recorded']);
					}
				?>
				<h3>Zone d'écriture</h3>
				<ul>
					<li id="li_1" >

					<div><textarea id="textarea" name="enonce" class="element textarea medium"  ><?php if (isset($textBrut)){echo($textBrut);}?></textarea>
					</div><p class="guidelines" id="guide_1"><small>Cette zone de texte vous permet de rentrer votre énoncé. Il sera presenté tel quel à l'élève.
					</small></p>
					<input type="hidden" name="replacements" value="">
					<input type="submit" value="valider">
				</ul>
		
	</body>

</html>
