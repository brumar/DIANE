<html>
<head>
<title>Document sans titre</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
 <p align="center">
<a href="../index.html">Accueil</a> &nbsp;&nbsp;
<a href="admin.php">Admin</a>&nbsp;&nbsp;
<a href="eleve.html">Elève</a>
</p>
 <?php 
require_once("conn.php"); 
$numExo = $_GET["num"];
$type = $_GET["type"];
if ($type =='complement')
	$typeExo="e";
else if ($type =='comparaison')
	$typeExo="a";
else if ($type =='distributivite')
	$typeExo="d";
else if ($type =='etape')
	$typeExo="et";

	
$questi = $_GET["questi"];
$sql1 = "SELECT * FROM $type where numero=$numExo";
$result1 = mysql_query($sql1) or die ("Requête incorrecte");
while ($r = mysql_fetch_assoc($result1))
	{
		if ($typeExo=="d")
		{
		  $text1 =  $r["enonce"]; $text2 =  $r["question"];
		  $exo = $text1."<br>".$text2;
		  $varFacteur = $r["varFacteur"];
		  $varFactorise = $r["varFactorise"];
		  $facteur = $r["facteur"];
		  //$question = $r["question"];
		  if ($facteur =='debut') 
		  $type_exo = "D".$varFacteur.$varFactorise."0";
		  else if ($facteur =='fin') 
		  $exercice = "D".$varFacteur.$varFactorise."1";
		}
	   else if ($typeExo=="et")
		{
		  $text1 =  $r["enonce"]; $text2 =  $r["question"];
		  $exo = $text1."<br>".$text2;
		  $typePb = $r["typePb"];
		  $inconnu = $r["inconnu"];
		  $variable = $r["variable"];
		  $exercice = $typePb." ".$inconnu." (".$variable.")";

		}
		else 
		{
		  $text1 =  $r["enonce1"];
		  $text2 =  $r["question1"];
		  $text3 =  $r["enonce2"];
		  $text4 =  $r["question2"];
		  $var = $r["variable"];
		  $question = $r["question"];
		  $exercice = $var.$typeExo.$question.$questi;
		  if ($questi==1)
		 	 $exo = $text1."<br>".$text2."<br>".$text3."<br>".$text4;
		  else if ($questi==0)
		 	 $exo = $text1."<br>".$text3."<br>".$text4;
         }
?>

<table width="375" border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#0000FF">
  <tr> 
    <td bgcolor="#99FF00"><strong>Exercice de type : &nbsp;<?php if (isset($exercice)) echo ($exercice); ?></strong></td>
  </tr>
 
  <tr> 
    <td height="28"> <?php print($exo); ?> </td>
  </tr>
<?php 
}
 
?>
</table>
</body>
</html>
