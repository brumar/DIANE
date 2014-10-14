<?php 
	require_once("conn.php");
	
	$numSerie=$_POST["numSerie"];
	$nomSerie=$_POST["nomSerie"];
	$commentaire=$_POST["commentaire"];
	
	$Requete_SQL1 = "UPDATE serie SET nomSerie='$nomSerie', commentaire='$commentaire' WHERE numSerie=".$numSerie;
	$result = mysql_query($Requete_SQL1) or die("Erreur d'Insertion dans la base : ". $Requete_SQL1 .'<br />'. mysql_error());
	header('Location: choixSerie.php');
//echo($Requete_SQL1);
?>