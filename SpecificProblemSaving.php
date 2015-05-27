<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Creation de problème</title>
<link rel="stylesheet" type="text/css" href="static/css/view.css" media="all">
</head>
<body>

<?php
require_once("conn.php");


if (isset($_POST['id'])){$idpbm=$_POST['id'];}
if (isset($_POST['replacements'])){$replacements=$_POST['replacements'];}
if (isset($_POST['text'])){$text=$_POST['text'];}
$sql = "INSERT INTO pbm_instancied (numero, idpbm,text, replacements) VALUES (NULL, '$idpbm', '$text', '$replacements');";
//echo($sql);
$result = mysql_query($sql);
mysql_close($BD_link);

?>
<img id="top" src="static/images/top.png" alt="">
	
	<div id="form_container">
		<form id="form_470585" class="appnitro"  method="post" action="">
		<p>Votre problème a bien été enregistré, <br>vous pouvez maintenant l'utiliser pour <a href="createProblemSelection.php">
		l'inclure dans une nouvelle série d'exercices</a></p>
		<a href="ProblemCreationInterface.php">Construire d'autres problèmes</a><br><br>
		<a href="admin.php">Retour</a>
		</form>
	</div>
</body>
</html>