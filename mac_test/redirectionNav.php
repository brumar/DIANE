<?php
/* Rediriger vers une page en fonction du navigateur du visiteur */
session_start();
$_SESSION["numSerie"]= (int)trim($_GET["numSerie"]);
require_once("conn.php");
$sql1 = "SELECT * FROM serie where numSerie=".$_SESSION["numSerie"];
$result1 = mysql_query($sql1) or die ("Requête incorrecte");
$i=$_SESSION['numExo'];
while ($r1 = mysql_fetch_assoc($result1))
	{
	  if ($r1["exo".$i]!="0")
		{
			$num=$r1["exo".$i];
			if ($r1["type".$i]=="a")
				$type="comparaison";
			else
				$type="complement";
			$questi=$r1["questi".$i];
			//print("le numero = ".$num."<br> le type = ".$type."<br> la question inter =  ".$questi);exit("ok");
			$_SESSION["num"]= $num;
			$_SESSION["type"]= $type;
			$_SESSION["questi"]= $questi;
		    $_SESSION["terminer"]= false;
		}
	  else
		{
		 $_SESSION["terminer"]= true;
		 $_SESSION["numExo"]= 1;
		 //header("Location: serie.php");
		}
   }
?>
<html>
<head>
<title>Document sans titre</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<SCRIPT LANGUAGE="JavaScript">
function redirection()
{
	nav = navigator.appName.substring(0,3);
	ver = navigator.appVersion.substring(0,1);
	if ((navigator.platform.indexOf('Win') > -1) && (nav == "Mic" && ver >=4))
	{
	page = "interfaceIE.php";
	}
	else
	{
	page = "interfaceMac.php";
	}
	//alert(page);
	window.open(page,'Interface','fullscreen');
	//history.go(-1);
}
</script>

<SCRIPT LANGUAGE="JavaScript">
nav = navigator.appName.substring(0,3);
ver = navigator.appVersion.substring(0,1);
if ((navigator.platform.indexOf('Win') > -1) && (nav == "Mic" && ver >=4))
{
page = "interfaceIE.php";
}
else
{
page = "interfaceMac.php";
}
//alert(page);
window.open(page,'Interface','fullscreen');
//history.go(-1);
</script>
</head>
<body>
<p align="center"><a href="serie.php">retour</a></p>
</body>
</html>