<?php
	
	// TO DO HERE : vider $_SESSION['infos'] (que pour template?), et donner bon feedback
	$typeEnregistrement = '';
	require_once("verifSessionProf.php");
	if(isset($_SESSION['flagSpecificProblemSaving'])){
		unset($_SESSION['flagSpecificProblemSaving']);
		$typeEnregistrement = "probleme";
	}
	elseif(isset($_SESSION['flagTemplateSaving'])){
		unset($_SESSION['flagTemplateSaving']);
		$typeEnregistrement = "template";
		$templateId = $_SESSION['templateIdIndex'];
		unset($_SESSION['templateIdIndex']);
	}
	else{
		header("Location: choix_template.php");
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Création de problème</title>
		<link rel="stylesheet" type="text/css" href="static/css/view.css" media="all">
	</head>
	<body>
	<?php include("headerEnseignant.php"); ?>
	
		<img id="top" src="static/images/top.png" alt="">
			
			<div id="form_container">

				<?php 
					if($typeEnregistrement == "probleme"){ ?>
						<form id="form_470585" class="appnitro"  method="post" action="">
						<p>Votre problème a bien été enregistré, vous pouvez maintenant l'utiliser pour <a href="creer_serie.php">
						l'inclure dans une nouvelle série d'exercices.</a></p>
						<a href="creation_exercice.php">Construire d'autres problèmes</a><br><br>
						<a href="profil_enseignant.php">Retour</a>
						</form>
					<?php
					} else{?>
						<form id="form_470585" class="appnitro"  method="post" action="">
						<p>Votre type de problème a bien été enregistré.</p>
						<a href="generer_probleme.php?id=<?php echo($templateId);?>">En faire une version utilisable dès maintenant</a><br><br>
						<a href="profil_enseignant.php">Retour</a>
						</form>

					<?
					}
					?>
			</div>
	</body>
</html>