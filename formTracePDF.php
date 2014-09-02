<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Formulaire pour choisir la trace d'un élève</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<p align="center">
<a href="index.html">Accueil</a> &nbsp;&nbsp;
<a href="admin.php">Admin</a>&nbsp;&nbsp;
<a href="eleve.php">Elève</a>
</p>
<form action="../fpdf/trace_pdf2.php" method="post" target="_blank">
  <h4 align="center">Choisissez un élève</h4>
  <p align="center"> 
    <?php 
	require("conn.php");
	$Select_String = "<select name='numEleve'>";
	$Select_End = "</select>";
	$sql ="SELECT DISTINCT a.numEleve, a.nom, a.prenom from eleve a, trace b where a.numEleve = b.numEleve order by numEleve desc";
	$result = mysql_query($sql) or die("Erreur de S&eacute;lection dans la base : ". $sql .'<br />'. mysql_error());
	//$num_rows = mysql_num_rows($result);
	//echo "$num_rows Rows\n";

		while ($r = mysql_fetch_assoc($result))
			{
				//print_r($r); echo "<br>";
				if (isset($r['numEleve'])) 
				{
				  
				  $Select_String .= "<option value=\"".stripslashes($r['numEleve'])."\" >";
				  $Select_String .= stripslashes($r['numEleve'])."  :  ".stripslashes(strtoupper(substr($r["nom"],0,1)))."   ".stripslashes(strtoupper($r['prenom']))."
				  
				  </option>"; 
				}
			  
			}
			print($Select_String.$Select_End);
	?>
  </p>
  <p align="center"> 
    <input type="submit" name="Submit" value="   Télécharger   ">
  </p>
</form>
</body>
</html>
