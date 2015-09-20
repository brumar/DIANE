<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Interface de Test</title>
<link rel="stylesheet" type="text/css" href="view.css" media="all">
<script type="text/javascript" src="view.js"></script>
<script type="text/javascript" src="userscript.js"></script>

</head>
<body id="main_body" >

<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

require_once('simple_analysis.php');
require_once('class.answer.php');

//echo "Hell yeah!<br />";

echo "<h2>Detection des types de resolution speciaux</h2>";
$nbs_problem = ["3"=>"N1", "5"=>"N2", "4"=>"N3"];
echo "Les nombres de l'ennonce sont :<br />";
print_r($nbs_problem);
echo "<br /><br />";

$str = "3 - 5 = 2";
$coucou = new Answer($str, $nbs_problem);

echo "<u><br />Les trois types d'operation a trou :</u><br /><br />";

$str = "3 + 2 = 5";
$coucou = new Answer($str, $nbs_problem);

$str = "5 - 2 = 3";
$coucou = new Answer($str, $nbs_problem);

$str = "6 - 3 = 3";
$coucou = new Answer($str, $nbs_problem);

echo "<u><br />Non implementes :</u><br /><br />";

echo "<strike>Detection de la confusion de signe</strike><br />";
$str = "5 - 3 = 8";
$coucou = new Answer($str, $nbs_problem);


?>
</body>
