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

//f("Wesh 43 + 2 = 46 gros ! Et 46 - 43 = 3 100 + 100 = 200 200 - 300 = 200", " 43, 46,");

$str = "Wesh 2 + 43 = 46 gros ! 48 - 4 = 46 ; 48 - 2 = 47";//100 + 100 = 200 200 - 300 = 200";
$nbs_problem = ["43"=>"N1", "46"=>"N2", "4"=>"N3"];
$coucou = new Answer($str, $nbs_problem);




?>
</body>
