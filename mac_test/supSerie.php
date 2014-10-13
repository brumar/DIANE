<html>
<head>
<title>Supprimer une série d'exercices</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <style type="text/css">
<!--
 
 .tableau
  {
	border-collapse: collapse; 
	border-style: solid; 
	border-width: 1px;
	background-color ;
  }

 body {
	margin: 5;
	padding: 0;
	text-align: center;
	font: 0.75em/1.4em Arial, Helvetica, sans-serif;
}
.entete{
	padding:5px;
	font-size-adjust:inherit;
	font-size:13px;
	background-color:#CCFF99;
	font-weight: bold;
	font-variant: normal;
}
 -->
  </style>

</head>

<body>
<p align="center">
<a href="../index.html">Accueil</a> &nbsp;&nbsp;
<a href="admin.php">Admin</a>&nbsp;&nbsp;
<a href="eleve.html">Elève</a>
</p><form  method="post" action="traitSupSerie.php">
  <h3 align="center">S&eacute;lectionnez les s&eacute;ries d'exercices &agrave;  supprimer</h3>
  <table border="1" align="center" bordercolor="windowtext;" cellpadding="5" class="tableau">	 
    <tr align="center" class="entete"> 
      
    <td width="61" height="29"><div class="entete">S&eacute;lection</div></td>
	  
    <td width="123" height="29"><div class="entete">S&eacute;ries</div></td>
	      
    </tr>
<?php 
require_once("conn.php");
$sql1 = "SELECT numSerie,nomSerie,commentaire FROM serie";
$result1 = mysql_query($sql1) or die ("Requête incorrecte");
$i=1;
while ($r1 = mysql_fetch_assoc($result1))
	{
	$numero=$r1["numSerie"];
	$nom=$r1["nomSerie"];
	$commentaire=$r1["commentaire"];
?>	
	<tr>
    <td height="27" align="center">
	<input name="<?php echo ("choix".$i);?>" type="checkbox" value="<?php echo ("$numero"); ?>">
	</td>
    <td align="center">
	<?php
		//print("<a href=\"affiche_Exo.php?numSerie=".$numero."\">Serie ".$i."</a><br>");
	 	$lien = "<a href=\"affiche_Exo.php?numSerie=".$numero."&nom=".$nom."\" title=\"".$commentaire."\">".$nom."</a><br>";
		echo($lien);
	?>
	<input name="<?php echo ("lien".$i);?>" type="hidden" value="<?php echo ($nom);?>">
	</td>
    </tr>
<?php 
$i++;
} ?>
</table>
  <p align="center">
    <input type="submit" name="Submit" value="Supprimer">
  </p>
</form>

</body>
</html>
