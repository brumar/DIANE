<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Creation de problème</title>
<link rel="stylesheet" type="text/css" href="view.css" media="all">
</head>
<body>
<br><br>

<?php
$nomSerie=$_POST["name"];
$commentaire=$_POST["comments"];
$exo=array();
$nbExo=0;
//foreach($_POST as $vblname => $value) echo $vblname . ' = ' . $value . "<br />\n";
foreach($_POST as $vblname => $value) {
	
	if(substr($vblname,0,2)=="id")
		{
		$exo[$nbExo+1]=$value;
		$nbExo++;
		}
}

//print_r($exo);
for($i=$nbExo+1;$i<26;$i++){
	$exo[]=0;	
}
//print_r($exo);

$Requete_SQL = "INSERT INTO serie (`nomSerie`, `commentaire`,nbExo, `exo1`, `type1`, `questi1`, `exo2`, `type2`, `questi2`, `exo3`, `type3`, `questi3`,
 `exo4`, `type4`, `questi4`, `exo5`, `type5`, `questi5`, `exo6`, `type6`, `questi6`, `exo7`, `type7`, `questi7`,
 `exo8`, `type8`, `questi8`, `exo9`, `type9`, `questi9`, `exo10`, `type10`, `questi10`, `exo11`, `type11`, `questi11`,
 `exo12`, `type12`, `questi12`, `exo13`, `type13`, `questi13`, `exo14`, `type14`, `questi14`, `exo15`, `type15`, `questi15`,
 `exo16`, `type16`, `questi16`, `exo17`, `type17`, `questi17`, `exo18`, `type18`, `questi18`, `questi19`, `exo19`, `type19`,
 `exo20`, `type20`, `questi20`, `exo21`, `type21`, `questi21`, `exo22`, `type22`, `questi22`, `exo23`, `type23`, `questi23`,
 `exo24`, `type24`, `questi24`) VALUES ('".$nomSerie."','".$commentaire."','".$nbExo."','".$exo[1]."',
 		'Gpbm','' ,'".$exo[2]."', 'Gpbm','' ,'".$exo[3]."', 'Gpbm','' ,'".$exo[4]."', 'Gpbm','' ,'".$exo[5]."', 
 		'Gpbm','' ,'".$exo[6]."', 'Gpbm','' ,'".$exo[7]."', 'Gpbm','' ,'".$exo[8]."', 'Gpbm','' ,'".$exo[9]."', 
 		'Gpbm','' ,'".$exo[10]."', 'Gpbm','' ,'".$exo[11]."', 'Gpbm','' ,'".$exo[12]."', 'Gpbm','' ,'".$exo[13]."', 
 		'Gpbm','' ,'".$exo[14]."', 'Gpbm','' ,'".$exo[15]."', 'Gpbm','' ,'".$exo[16]."', 'Gpbm','' ,'".$exo[17]."', 
 		'Gpbm','' ,'".$exo[18]."', 'Gpbm','' ,'".$exo[19]."', 'Gpbm','' ,'".$exo[20]."', 'Gpbm','' ,'".$exo[21]."', 
 		'Gpbm','' ,'".$exo[22]."', 'Gpbm','' ,'".$exo[23]."', 'Gpbm','' ,'".$exo[24]."', 'Gpbm','');";
require_once("conn.php");


mysql_query($Requete_SQL,$BD_link);
mysql_close($BD_link);
?>
<img id="top" src="top.png" alt="">
<div id="form_container">
<form id="form_470585" class="appnitro"  method="post" action="">
<p>Votre série a bien été enregistré.</p>
<a href="choixSerie-D2.php">La mettre au premier plan dès maintenant</a><br><br>
<a href="admin.php">Retour</a>
</form>
</div>

</body>
</html>