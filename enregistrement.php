<?php
	require_once("verifSessionProf.php");
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
				<form id="form_470585" class="appnitro"  method="post" action="">
				<p>Votre problème a bien été enregistré, <br>vous pouvez maintenant l'utiliser pour <a href="creer_serie.php">
				l'inclure dans une nouvelle série d'exercices</a></p>
				<a href="ProblemCreationInterface.php">Construire d'autres problèmes</a><br><br>
				<a href="profil_enseignant.php">Retour</a>
				</form>
			</div>
	</body>
</html>