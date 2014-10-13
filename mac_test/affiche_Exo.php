<?php 
require_once("conn.php"); 
session_start();

?>
<html>
<head>
<title>Document sans titre</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<p align="center">
<a href="../index.html">Accueil</a> &nbsp;&nbsp;
<a href="admin.php">Admin</a>&nbsp;&nbsp;
<a href="eleve.html">Elève</a>
</p>
<h4 align="center">Cliquez <?php print("<a href=\"affiche_Exo2.php?numSerie=".$_GET["numSerie"]."\"> ici</a>"); ?> pour afficher tous les exercices de la s&eacute;rie "<?php echo $_GET["nom"]; ?>"</h4>
	

<table border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#0000FF">
  <tr> 
    <td  align="center" bgcolor="#99FF00"><strong><?php print("<a href=\"affiche_Exo2.php?numSerie=".$_GET["numSerie"]."\"> Exercices : ".$_GET["nom"]."</a>");?></strong></td>
  </tr>
<?php
$numSerie = $_GET["numSerie"];
session_register('numSerie');
$sql1 = "SELECT * FROM serie where numSerie=".$_GET["numSerie"];
$result1 = mysql_query($sql1) or die ("Requête incorrecte");
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

?>
  <tr> 
    <td height="28" align="center">
	<?php print("<a href=\"affiche_Exo1.php?num=".$exo."&type=".$type."&questi=".$questi."\">exercice ".$i."</a><br>"); ?> 
    </td>
  </tr>
<?php 
}
}
} 
?>
</table>
</body>
</html>
