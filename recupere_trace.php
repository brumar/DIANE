<?php require_once('conn.php'); 
$id_session=session_id();
$numEleve=143 ;

$sql1 = "select id, numSerie,numExo from trace where numEleve = ".$numEleve." order by id DESC LIMIT 1";
$result1 = mysql_query($sql1) or die ("Requête incorrecte1");
while ($traceRecord = mysql_fetch_assoc($result1))
	{
	  $numTrace = $traceRecord["id"];
	  $numSerie =  $traceRecord["numSerie"];
	  $numExo = $traceRecord["numExo"];
	}

$sql2 = "select * from serie where numSerie = ".$numSerie;
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
	}
	
for($i=1;$i<=$nbExo;$i++)
{
	if(${'exo'.$i}==$numExo)
		$posExo=$i;
} 
$_SESSION["posExo"]=$posExo;
//echo ('le dernier exo est : '.$posExo);
?>