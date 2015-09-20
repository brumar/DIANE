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

//echo "Hell yeah!<br />";
?>

<form action="calc_number_of_results.php" method="post">
	Soit S le nombre d'operateurs a considerer: S = <input type="number" name="S"><br>
	Soit N le nombre de nombres dans l'ennonce. N = <input type="number" name="N"><br>
	Soit C le nombre de calculs a effectuer. C = <input type="number" name="C"><br>
	<input type="submit">
</form>

<?php
$s = $_POST["S"];
$n = $_POST["N"];
$c = $_POST["C"];
$somme = 0;
for ($i = $n; $i <= $n + $c - 1; $i++)
{
	$somme += $i * $s;
}
echo "Le nombre de sous-resultats a calculer est de ".$somme . "\n";
?>

</body>
