<html>
<head>
<title>Choix des s&eacute;ries d'exercices</title>
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
	margin: 0;
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
<a href="index.html">Accueil</a> &nbsp;&nbsp;
  <a href="admin.php">Admin</a>&nbsp;&nbsp;
  <a href="eleve.html">Elève</a>
 </p>
<form  method="post" action="traitChoixSerie.php">
  <h3 align="center">S&eacute;lectionnez les s&eacute;ries d'exercices &agrave; activer</h3>
  <table border="1" align="center" bordercolor="windowtext;" cellpadding="5" class="tableau">	 
    <tr align="center" class="entete"> 
      
    <td width="104" height="29"><div class="content">S&eacute;lection</div></td>
    <td width="104"><div class="content">Ordre de s&eacute;l&eacute;ction</div></td>
    <td width="245"><div class="content">S&eacute;ries </div></td>
	  
    <td width="125" height="29"><div class="content">Modifier le nom de la s&eacute;rie</div></td>
	      
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
    <td align="center"><input name="<?php echo ("ordre_serie".$i); ?>" type="text" size="2" maxlength="2"></td>
    <td align="center" class="content"><?php
		//print("<a href=\"affiche_Exo.php?numSerie=".$numero."\">Serie ".$i."</a><br>");
	 	$lien = "<a href=\"affiche_Exo.php?numSerie=".$numero."&nom=".$nom."\" title=\"".$commentaire."\">".$nom."</a><br>";
		echo($lien);
	?>
      <input name="<?php echo ("lien".$i);?>" type="hidden" value='<?php echo ($lien);?>'></td>
    <td align="center" class="content"><?php echo ("<a href=\"modif_serie.php?num=$numero&nom=$nom&commentaire=$commentaire\">"); ?>Modifier</a></td>
    </tr>
<?php 
$i++;
} ?>
</table>
  <p align="center">
    <input type="submit" name="Submit" value="Valider">
  </p>
</form>

</body>
</html>
