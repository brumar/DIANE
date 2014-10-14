<?php 
require_once("conn.php");
$numExo=$_GET["numExo"];
$typeExo=$_GET["typeExo"];
$requeteSQL="delete from ".$typeExo." where numero=".$numExo;
$result = mysql_query($requeteSQL) or die ("Requ&ecirc;te incorrecte");

if($typeExo=="comparaison")
{
	header('Location: affichage_a.php');
}
else if($typeExo=="complement")
{
	header('Location: affichage_e.php');
}
else if($typeExo=="distributivite")
{
	header('Location: affichage_d.php');
}
else if($typeExo=="etape")
{
	header('Location: affichage_etape.php');
}
?>
