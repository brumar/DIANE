<?php
session_start();
$nbExo=$_POST['nbExo'];
$nbExo--;
require_once ("conn.php");
$numExo=$_POST["numExo"];
$numExo++;
$questi=$_SESSION['questi'];
$n=(int) $_SESSION['num'];
$t=$_SESSION['type'];
$text=$_POST["zonetexte"];
$sas = addslashes($_POST['T1']);

$numSerie=$_SESSION["numSerie"];

$aujourdhui=getdate(); $mois=$aujourdhui['mon']; $jour=$aujourdhui['mday']; $annee=$aujourdhui['year'];
$heur=$aujourdhui['hours']; $minute=$aujourdhui['minutes']; $seconde=$aujourdhui['seconds'];
$date=$annee.":".$mois.":".$jour." ".$heur.":".$minute.":".$seconde;

$typeExo="general";
$typePb="general";
$text=addslashes($text);

$Requete_SQL="INSERT INTO trace (numEleve,numSerie,numExo,typeExo,questInt,sas ,
				operation1, operation2, operande1, operande2,operande3,zonetext,resultat,actions) VALUES
				('".$_SESSION['numEleve']."','".$numSerie."','".$n."','".$typePb."','','".$sas."',
				'','','','','','".$text."','','".$_POST['Trace']."')";
// Execution de la requete SQL.
$result=mysql_query($Requete_SQL) or die("Erreur d'Insertion dans la base : ". $Requete_SQL .'<br />'. mysql_error());
mysql_close($BD_link);

//$interface = "interfaceIE.php?numSerie=".$numero;
//print("<a href=\"javascript:;\" onClick=\"window.open('$interface','Interface','fullscreen');\">".$nomSerie."</a>");
echo "<script type='text/javascript'>location.href='interfaceIE.php?lienRetour=oui&numSerie=".$_SESSION['numSerie']."&nbExo=".$nbExo."&numExo=".$numExo."';</script>";

?>