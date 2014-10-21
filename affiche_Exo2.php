<?php 
session_start();
session_register('numSerie');
$numSerie = $_GET["numSerie"];
require_once("conn.php"); 
?>
<html>
<head>
<title>Affichage des Exercices</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<p align="center">
<a href="index.html">Accueil</a> &nbsp;&nbsp;
<a href="admin.php">Admin</a>&nbsp;&nbsp;
<a href="eleve.html">Elève</a>
</p>

<table width="65%" border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#0000FF">
  
<?php 
$sql1 = "SELECT * FROM serie where numSerie=".$numSerie;
$result1 = mysql_query($sql1) or die ("Requête incorrecte 1");
while ($r1 = mysql_fetch_assoc($result1))
	{
	   for ($i=1;$i<=24;$i++)
		 {
			 if ($r1["exo".$i]!="0")
				{
				$exo=$r1["exo".$i];
				if ($r1["type".$i]=="a")
					$type="comparaison";
				else if ($r1["type".$i]=="e")
					$type="complement";
				else if ($r1["type".$i]=="d")
					$type="distributivite";
				else if ($r1["type".$i]=="et")
					$type="etape";
								
				$questi=$r1["questi".$i];
				
				if ($type =='complement')
					$typeExo="e";
				else if ($type =='comparaison')
					$typeExo="a";
				else if ($type =='distributivite')
					$typeExo="d";
				else if ($type =='etape')
					$typeExo="et";
					
				$sql1 = "SELECT * FROM $type where numero=$exo";
				$result1 = mysql_query($sql1) or die ("Requête incorrecte 2");
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
						  $exercice = "D".$varFacteur.$varFactorise."0";
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
					 	  $text1 =  $r["enonce1"]; $text2 =  $r["question1"];
						  $text3 =  $r["enonce2"]; $text4 =  $r["question2"];
						  $var = $r["variable"];  $question = $r["question"];
						  $exercice = $var.$typeExo.$question.$questi;
						  if ($questi==1)
							 $exo = $text1."<br>".$text2."<br>".$text3."<br>".$text4;
						  else if ($questi==0)
							 $exo = $text1."<br>".$text3."<br>".$text4;
					  }
					  $exo= stripcslashes($exo); 
?>
  <tr> 
    <td bgcolor="#99FF00"><strong>Exercice N° <?php echo ($i); ?> de type : &nbsp;<?php echo ($exercice); ?></strong></td>
  </tr>
 
  <tr> 
    <td> <?php print($exo); ?> </td>
  </tr>

<?php 
}
}//fin du if 
}//fin du for	
}//fin du while 
?>
</table>


</body>
</html>
