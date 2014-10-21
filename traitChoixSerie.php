<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Creation de problème</title>
<link rel="stylesheet" type="text/css" href="static/css/view.css" media="all">
</head>
<body>
<br><br>
<div id="form_container">
		<form id="form_470585" class="appnitro"  method="post" action="">
<h4>Séries selectionnées : </h4>
<?php 
	require_once("conn.php");
	$sql1 = "select count(*) as total from serie";
	$result1 = mysql_query($sql1) or die ("Requéte incorrecte");
	$sql2 = "update serie set choix ='0'";
	$result2 = mysql_query($sql2) or die ("Requéte incorrecte");
	$tab=array();
	while ($r1 = mysql_fetch_assoc($result1))
		{
			$total=$r1["total"];
		}
	
	for ($i=1;$i<=$total;$i++)
	{
		if (isset($_POST["choix".$i]) and isset($_POST["ordre_serie".$i]))
		{
			if($_POST["choix".$i]!=0 and $_POST["ordre_serie".$i]>0)
			{
				$lien=$_POST["lien".$i];
				$k=$_POST["ordre_serie".$i];
				$tab[$k]=$lien;
				//echo ("<tr><td align=\"center\">".$lien."</td></tr>");
				$sql = "update serie set choix =".$_POST["ordre_serie".$i]." where numSerie =".$_POST["choix".$i];
				$result = mysql_query($sql) or die ("Requéte incorrecte");	
			}
		}
	
	}
	for ($i=1;$i<=count($tab);$i++)
	{
		echo ($tab[$i]);
	}

?>
<br><br>
		<a href="admin.php">Retour</a>
</form>
</div>
  

<img id="bottom" src="static/images/bottom.png" alt="">
</body>
</html>
