<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Formulaire pour insérer le numéro de trace</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<p align="center">
<a href="index.html">Accueil</a> &nbsp;&nbsp;
<a href="mac_test/admin.php">Admin</a>&nbsp;&nbsp;
<a href="mac_test/eleve.html">Elève</a>
</p>
<?php 
$type=$_GET["type"];
if ($type=="e" || $type=="a")
	{
	print("<form action=\"diagXML.php\"  method=\"post\">");
	$sql ="SELECT DISTINCT b.numEleve, a.nom, a.prenom from eleve a, trace b where a.numEleve = b.numEleve and (b.typeExo='a' or b.typeExo='e') order by numEleve desc";
	}
else if ($type=="d")
	{
		print("<form action=\"diagXMLdistrib.php\"  method=\"post\">");
	$sql ="SELECT DISTINCT b.numEleve, a.nom, a.prenom from eleve a, trace b where a.numEleve = b.numEleve and b.typeExo='d'  order by numEleve desc";
	}
else if ($type=="etape")
	{
		print("<form action=\"diagXMLetape.php\"  method=\"post\">");
		$sql ="SELECT DISTINCT b.numEleve, a.nom, a.prenom from eleve a, trace b where a.numEleve = b.numEleve and b.typeExo in('changement','combinaison','comparaison')  order by numEleve desc";
	}

?>
<form action="diagXML.php" method="post">
  <h4 align="center">Veuillez entrer le num&eacute;ro de DIAGNOSTIC</h4>
  <p align="center">
    <?php 
	require("mac_test/conn.php");
	$Select_String = "<select name='numEleve'>";
	$Select_End = "</select>";
	//$sql ="SELECT DISTINCT b.numEleve, a.nom, a.prenom from eleve a, trace b where a.numEleve = b.numEleve";
	$result = mysql_query($sql) or die("Erreur de S&eacute;lection dans la base : ". $sql .'<br />'. mysql_error());
		while ($r = mysql_fetch_assoc($result))
			{
				if (isset($r['numEleve'])) 
				{
				  $Select_String .= "<option value=\"".stripslashes($r['numEleve'])."\" >";
				  $Select_String .= stripslashes(strtoupper(substr($r["nom"],0,1)))."   ".stripslashes(strtoupper($r['prenom']))."</option>"; 
				}
			  
			}
			print($Select_String.$Select_End);
	?>
  </p>
    <p align="center">
    <input type="submit" name="Submit" value="Afficher">
  </p>
  
</form>
</body>
</html>
