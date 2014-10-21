<?php 
  require_once("conn.php");
  $nom = strtolower(trim($_POST[nom]));
  $prenom = strtolower(trim($_POST[prenom]));
  //$password = 
  $Requete_SQL = "INSERT INTO enseignant(nom, prenom) VALUES ('".$nom."','".$prenom."')";
   // Execution de la requete SQL.
  $result = mysql_query($Requete_SQL) or die("Erreur d'Insertion dans la base : ". $Requete_SQL1 .'<br />'. mysql_error());

?>