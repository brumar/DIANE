<?php
	header('Content-type: text/html; charset=utf-8');
	session_start();
	session_unset();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>DIANE - élève</title>
		<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
		<link rel="stylesheet" href="static/css/view.css" />
	</head>
	<body>
		<?php require_once("headerEleve.php"); ?>
		Tu as bien fini la série d'exercices, merci ! 
	</body>
</html>