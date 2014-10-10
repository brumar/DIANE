<?php

function XMLexoComplement() {
	
    require_once("../mac_test/conn.php");
	$requete = "select * from complement";
	$result = mysql_query($requete);
	while($t=@mysql_fetch_array($result))
    {
      $myXML.="<exercice>";
      $myXML.="<numero>".$t["numero"]."</numero>";
      $myXML.="<enonce1>".$t["enonce1"]."</enonce1>";
      $myXML.="<question1>".$t["question1"]."</question1>";
      $myXML.="<enonce2>".$t["enonce2"]."</enonce2>";
      $myXML.="<question2>".$t["question2"]."</question2>";
      $myXML.="<partie1>".$t["partie1"]."</partie1>";
      $myXML.="<partie2>".$t["partie2"]."</partie2>";
      $myXML.="<partie3>".$t["partie3"]."</partie3>";
      $myXML.="<tout1>".$t["tout1"]."</tout1>";
      $myXML.="<tout2>".$t["tout2"]."</tout2>";
      $myXML.="<valdiff>".$t["valdiff"]."</valdiff>";
      $myXML.="<variable>".$t["variable"]."</variable>";
      $myXML.="<question>".$t["question"]."</question>";
      $myXML.="</exercice>";
      
    }
    return $myXML;
}
echo   XMLexoComplement();

?>