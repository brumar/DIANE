<?php
 require_once("conn.php");
 function calcul($a1,$a2,$a3)
  {
	switch ($a2)
	{
		case "+" : $cal = $a1+$a3;
					break;
		case "-" : $cal = $a1-$a3 ;
					break;
		case "*" : $cal = $a1*$a3 ;
					break;
		case ":" : $cal = $a1/$a3 ;
					break;
	}
	return $cal;
  }
  function calcul2($tab1,$tab2)
	{
		$cal=$tab2[0];
		for($i=0;$i<=count($tab1);$i++)
			switch ($tab1[$i])
			{
				case "+" : $cal = $cal+$tab2[$i+1];
							break;
				case "-" : $cal = $cal-$tab2[$i+1];
							break;
				case "*" : $cal = $cal*$tab2[$i+1];
							break;
				case ":" : $cal = $cal/$tab2[$i+1];
							break;
			}
		return $cal ;
	}
  
 if(!isset($bool)||!$bool)
 {
	$numEleve=trim($_POST["numEleve"]);
	//$numEleve=1;
	//$sql1 = "select count(*) as qte from trace where id >= 384 and numEleve=".$numEleve;
	$sql1 = "select count(*) as qte from trace where typeExo='d' and numEleve=".$numEleve;
	//$sql1 = "select count(*) as qte from trace where typeExo='d'";

	$p = mysql_query($sql1);
	$total =mysql_result($p,"0","qte");
	//print("le nombre d'enregistrement".$total);
	//$Requete_SQL1 = "SELECT id FROM trace where id >= 384 and numEleve=".$numEleve;
	$Requete_SQL1 = "SELECT id FROM trace where typeExo='d' and numEleve=".$numEleve;
	//$Requete_SQL1 = "SELECT id FROM trace where typeExo='d'";

	$result = mysql_query($Requete_SQL1) or die("Erreur de S&eacute;lection dans la base : ". $Requete_SQL1 .'<br />'. mysql_error());
	$bool=true;
	 while($record = mysql_fetch_array($result))
	{
		$tabId[]=$record[0];
	}
}
 
for($compt=0; $compt<$total; $compt++)
	{
 		//print("<br> i = ".$compt."<br>");

        $sql1 ="select * from trace where id =".$tabId[$compt];
		$result = mysql_query($sql1) or die("Erreur de S&eacute;lection dans la base : ". $sql1 .'<br />'. mysql_error());
		while ($val = mysql_fetch_assoc($result))
		{
			$questi = $val['questInt'];	$n = $val['numExo']; $t = $val['typeExo'];
			$text = $val['zonetext']; $sas = $val['sas']; $choix = $val['choix'];
			$oper1 = trim($val['operation1']); 	$oper2 = trim($val['operation2']);
			$oper_1 = trim($val['operation1']); $oper_2 = trim($val['operation2']);
			$op1 = $val['operande1']; $op2 = $val['operande2'];  $op3 = $val['operande3'];
			$op_1 = $val['operande1']; $op_2 = $val['operande2'];  $op_3 = $val['operande3'];
			//ne pas oublier de modifier resultat_aff
			$resultat_aff =$val['resultat']; $numSerie = $val["numSerie"];
			$aujourdhui = getdate(); $mois = $aujourdhui['mon']; $jour = $aujourdhui['mday']; $annee = $aujourdhui['year'];
			$heur = $aujourdhui['hours']; $minute = $aujourdhui['minutes']; $seconde = $aujourdhui['seconds'];
			$date = $annee.":".$mois.":".$jour." ".$heur.":".$minute.":".$seconde;
		}
		 	$numTrace = $tabId[$compt];
		
			$t='distributivite' ;
            print("numéro de trace ".$numTrace."   "); print($t."<br>");print($text."<br>");
            include("diagauto_d.php");
			echo "<br>______________________________________________________________<br>";
	
    }
?>