<?php
$BD_host  = "localhost";
$BD_port  = "";
$BD_login = "root"; // identifiant
$BD_pass  = "root"; // mot de passe
//$BD_base  = "projet_classe";
//$BD_base  = "projet_test";
//$BD_base  = "bd_free2007";
//$BD_base  = "free_sept2007";
$BD_base  = "diane2";

//$BD_base  = "projet_free";

//$BD_base  = "projet";
//$BD_base  = "projet_update";

$BD_link = mysql_connect("${'BD_host'}${'BD_port'}", $BD_login, $BD_pass) or die("Connexion de la base impossible : ". mysql_error());

mysql_select_db($BD_base, $BD_link) or die("S&eacute;lection de la base impossible : ". mysql_error());
//mysql_query("SET NAMES utf-8");
?>
