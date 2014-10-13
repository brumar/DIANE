<? 
require ("conn.php"); 
$compteur=$_SESSION['compteur'];
if ($compteur==0)
{
	$sql1 = "SELECT * FROM complement";
	$sql2= "SELECT * FROM comparaison";
	$result1 = mysql_query($sql1) or die ("Requête incorrecte");
	$result2 = mysql_query($sql2) or die ("Requête incorrecte");
		if ($result1) // Si il y'a des résultats
		{ 
			while ($enregistrement1 = mysql_fetch_assoc($result1))
			 {
			  $t1[]= $enregistrement1["numero"];
			 }
			 $trand1 = array_rand($t1,3);
		}
		if ($result2) // Si il y'a des résultats
		{ 
			while ($enregistrement2 = mysql_fetch_assoc($result2))
			 {
			  $t2[]= $enregistrement2["numero"];
			 }
			 $trand2 = array_rand($t2,3);
		}
		 $n1=$trand1[0]; $numExo1=$t1[$n1];
		 $n2=$trand1[1]; $numExo2=$t1[$n2];
		 $n3=$trand1[2]; $numExo3=$t1[$n3];
		 $n4=$trand2[0]; $numExo4=$t2[$n4];
		 $n5=$trand2[1]; $numExo5=$t2[$n5];
		 $n6=$trand2[2]; $numExo6=$t2[$n6];
		 session_register('numExo1','numExo2','numExo3','numExo4','numExo5','numExo6');
}
else 
{
	$numExo1=$_SESSION['numExo1'];
	$numExo2=$_SESSION['numExo2'];
	$numExo3=$_SESSION['numExo3'];
	$numExo4=$_SESSION['numExo4'];
	$numExo5=$_SESSION['numExo5'];
	$numExo6=$_SESSION['numExo6'];
}

?>
<html>
<head>
<title>Exercices</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<?php //echo ($_SESSION['compteur']); ?>
<h3 align="left">Cliquez sur l'un des &eacute;xercices suivant puis essaye de 
  le resoudre</h3>
<table width="36%" height="180" border="0" cellspacing="5">
  <tr> 
    <td width="68%" align="center"><a href="redirectionNav.php?num=<?php echo($numExo1); ?>&type=complement&questi=1">Exercice 
      1</a></td>
  </tr>
  <tr> 
    <td align="center"><a href="redirectionNav.php?num=<?php echo($numExo2); ?>&type=complement&questi=1">Exercice 
      2</a></td>
  </tr>
  <tr> 
    <td align="center"><a href="redirectionNav.php?num=<?php echo($numExo3); ?>&type=complement&questi=0">Exercice 
      3</a></td>
  </tr>
  <tr> 
    <td align="center"><a href="redirectionNav.php?num=<?php echo($numExo4); ?>&type=comparaison&questi=1">Exercice 
      4</a></td>
  </tr>
  <tr> 
    <td align="center"><a href="redirectionNav.php?num=<?php echo($numExo5); ?>&type=comparaison&questi=1">Exercice 
      5</a></td>
  </tr>
  <tr> 
    <td align="center"><a href="redirectionNav.php?num=<?php echo($numExo6); ?>&type=comparaison&questi=0">Exercice 
      6</a></td>
  </tr>
</table>
</body>
</html>