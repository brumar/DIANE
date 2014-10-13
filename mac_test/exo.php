<html>
<head>
<title>Document sans titre</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>


<h4 align="center">Cliquez sur un exercice &agrave; resoudre</h4>

<table border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#0000FF">
  <tr> 
    <td width="163" align="center" bgcolor="#99FF00"><strong>Exercices</strong></td>
  </tr>
  <?php 
require_once("conn.php"); 
session_start();
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
				else 
					$type="complement";
				$questi=$r1["questi".$i];

?>
  <tr> 
    <td height="28" align="center">
	<?php print("<a href=\"redirectionNav.php?num=".$exo."&type=".$type."&questi=".$questi."\">exercice ".$i."</a><br>"); ?> 
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
