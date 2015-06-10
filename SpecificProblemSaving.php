<?php
	header('Content-type: text/html; charset=utf-8');
	session_start();
	$_default_type = 1;

?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Création de problème</title>
		<link rel="stylesheet" type="text/css" href="static/css/view.css" media="all">
	</head>
	<body>

		<?php
			require_once("conn_pdo.php");
			if (isset($_POST['text'])){

				$enonce=$_POST['text'];

				if (isset($_POST['type'])){
					$type = $_POST['type'];
				} else{$type = $_default_type;}

				if (isset($_POST['id'])){
					$idTemplate=$_POST['id'];
				} else{$idTemplate = NULL;}//TODO : surement, changer "id". Voir quand j'utiliserai les template

				if (isset($_POST['replacements'])){
					$replacements=$_POST['replacements'];
				} else{$replacements = NULL;}

				$req = $bdd->prepare('INSERT INTO pbm (enonce, type, idCreator, idTemplate, replacements) VALUES (:enonce, :type, :idCreator, :idTemplate, :replacements)');
				$req->execute(array(
					'enonce' => $enonce,
					'type' => $type,
					'idCreator' => $_SESSION['id'],
					'idTemplate' => $idTemplate,
					'replacements' => $replacements));

				$req->closeCursor();
			}

		?>
		<img id="top" src="static/images/top.png" alt="">
			
			<div id="form_container">
				<form id="form_470585" class="appnitro"  method="post" action="">
				<p>Votre problème a bien été enregistré, <br>vous pouvez maintenant l'utiliser pour <a href="gerer_series.php">
				l'inclure dans une nouvelle série d'exercices</a></p>
				<a href="ProblemCreationInterface.php">Construire d'autres problèmes</a><br><br>
				<a href="profil_enseignant.php">Retour</a>
				</form>
			</div>
	</body>
</html>