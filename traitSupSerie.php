<html>
<head>
<title>taitement de la suppression</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<p align="center">
<a href="index.html">Accueil</a> &nbsp;&nbsp;
<a href="admin.php">Admin</a>&nbsp;&nbsp;
<a href="eleve.html">Elève</a>
</p><h4 align="center">&nbsp;</h4>
    
<table align="center" cellpadding="5" cellspacing="1" bordercolor="#FF0000" border="1">
<tr bgcolor="#66FF66"><td>Les séries supprimées sont :</td></tr>
<?php 
	require_once("conn.php");
	$sql1 = "select count(*) as total from serie";
	$result1 = mysql_query($sql1) or die ("Requête incorrecte");
	$sql2 = "update serie set choix ='0'";
	$result2 = mysql_query($sql2) or die ("Requête incorrecte");
	while ($r1 = mysql_fetch_assoc($result1))
		{
			$total=$r1["total"];
		}
	
	for ($i=1;$i<=$total;$i++)
	{
		if (isset($_POST["choix".$i]))
		{
			if($_POST["choix".$i]!=0)
			{
				echo ("<tr><td align=\"center\">".$_POST["lien".$i]."</td></tr>");
				$sql = "delete from serie where numSerie =".$_POST["choix".$i];
				$result = mysql_query($sql) or die ("Requête incorrecte");
			}
		}
	
	}
?>

</table>
<p align="center"><a href="admin.php">retour</a></p>
</body>
</html>