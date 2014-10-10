<?php
require_once('../mac_test/conn.php'); 
$id_session=session_id();//session en cours

$numEleve_prec=$_GET["numEleve"];
$numSerie_prec=$_GET["numSerie"];
$id_prec=$_GET["id"];

echo('num eleve'.$numEleve_prec);
echo('num serie'.$numSerie_prec);
echo('num id'.$id_prec);

if($id_session==$id_prec)
{

}

$sql1 = "select id, numSerie,numExo from trace where numEleve = ".$numEleve_prec." and numSerie = ".$numSerie_prec." order by id DESC LIMIT 1";
$result1 = mysql_query($sql1) or die ("Requête incorrecte1");
//phpinfo();//temp
//echo('num exo 1'.$numExo);
while ($traceRecord = mysql_fetch_assoc($result1))
	{
	  $numTrace = $traceRecord["id"];
	  $numSerie =  $traceRecord["numSerie"];
	  $numExo = $traceRecord["numExo"];
	 // echo('num exo 2'.$numExo);
	}

$sql2 = "select * from serie where numSerie = ".$numSerie_prec;
$result2 = mysql_query($sql2) or die ("Requête incorrecte2");
while ($traceRecord2 = mysql_fetch_assoc($result2))
	{
	  $exo1 = $traceRecord2["exo1"];$exo2 = $traceRecord2["exo2"];$exo3 = $traceRecord2["exo3"];$exo4 = $traceRecord2["exo4"];
	  $exo5 = $traceRecord2["exo5"];$exo6 = $traceRecord2["exo6"];$exo7 = $traceRecord2["exo7"];$exo8 = $traceRecord2["exo8"];
	  $exo9 = $traceRecord2["exo9"];$exo10 = $traceRecord2["exo10"];$exo11 = $traceRecord2["exo11"];$exo12 = $traceRecord2["exo12"];
	  $exo13 = $traceRecord2["exo13"];$exo14 = $traceRecord2["exo14"];$exo15 = $traceRecord2["exo15"];$exo16 = $traceRecord2["exo16"];
	  $exo17 = $traceRecord2["exo17"];$exo18 = $traceRecord2["exo18"];$exo19 = $traceRecord2["exo19"];$exo20 = $traceRecord2["exo20"];
	  $exo21 = $traceRecord2["exo21"];$exo22 = $traceRecord2["exo22"];$exo23 = $traceRecord2["exo23"];$exo24 = $traceRecord2["exo24"];
	  $nbExo = $traceRecord2["nbExo"];
	  $nomSerie=$traceRecord2["nomSerie"];
	  $totalExo=$nbExo;
	}
	
for($i=1;$i<=$nbExo;$i++)
{
	if(${'exo'.$i}==$numExo)
		$posExo=$i+1;
	
} 
 
 if (!isset($posExo) || $posExo >$totalExo || $posExo==1 || $posExo=='')
  {
  		/* $sql1 = "SELECT numSerie,nomSerie,nbExo FROM serie where choix = '1'";
		$result1 = mysql_query($sql1) or die ("Requête incorrecte");
		while ($r1 = mysql_fetch_assoc($result1))
		{
			$numero=$r1["numSerie"];
			$nomSerie=$r1["nomSerie"];
			$nbExo=$r1["nbExo"];
			$totalExo = $r1["nbExo"];
		} */			
		$numExo=1;
		$interface = "interfaceIE.php?numSerie=".$numSerie_prec."&nbExo=".$nbExo."&totalExo=".$totalExo."&numExo=".$numExo;

  }
  else 
  {
	$nbExo=$totalExo-$posExo+1; 	
	$interface = "../mac_test/interfaceIE.php?lienRetour=oui&numSerie=".$numSerie."&nbExo=".$nbExo."&totalExo=".$totalExo."&numExo=".$posExo;

  }
	//echo($posExo.','.$nbExo.','.$totalExo);
		echo $interface;
/*echo "<script type='text/javascript'>location.href='".$interface."';</script>";*/
    
?>
