<?php
	require_once("verifSessionProf.php");
	require_once("conn_pdo.php");
	
	if (isset($_GET["id"])){ // TODO : Réflexion.. niveau sécurité, je sais pas si c'est une très riche idée ça, de mettre un id dans l'URL
		$id=$_GET["id"];
	}
	else{
		header("location: copier_template.php");
		exit();
	}
	
	require_once("opening.php");


	header("Location: creation_template.php");
	exit();
?>
