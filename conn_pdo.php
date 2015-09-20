<?php

$_debug = True;
$BD_host  = "localhost";
$BD_port  = "";
$BD_login = "root"; // identifiant
$BD_pass  = "root"; // mot de passe
//$BD_base  = "projet_classe";
//$BD_base  = "projet_test";
//$BD_base  = "bd_free2007";
//$BD_base  = "free_sept2007";
$BD_base  = "diane2b";

//$BD_base  = "projet_free";

//$BD_base  = "projet";
//$BD_base  = "projet_update";


try
{
	if($_debug){
		$bdd = new PDO('mysql:host='.$BD_host.';dbname='.$BD_base.';charset=utf8', $BD_login, $BD_pass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}
	else{
		$bdd = new PDO('mysql:host='.$BD_host.';dbname='.$BD_base.';charset=utf8', $BD_login, $BD_pass);
	}
	
}
catch (Exception $e)
{
    die('Erreur : ' . $e->getMessage());
}


//$BD_link = mysql_query("${'BD_host'}${'BD_port'}", $BD_login, $BD_pass) or die("Connexion de la base impossible : ". mysql_error());

//mysql_select_db($BD_base, $BD_link) or die("S&eacute;lection de la base impossible : ". mysql_error());
//mysql_query("SET NAMES utf-8");
?>