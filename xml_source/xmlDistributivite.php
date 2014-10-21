<?php

function XMLexoDistrib() {
	
    require_once("../conn.php");
	$requete = "select * from Distributivite";
	$result = mysql_query($requete);
	while($t=@mysql_fetch_array($result))
    {
      $myXML.="<exercice>";
      
      $myXML.="<numero>".$t["numero"]."</numero>";
      $myXML.="<enonce>".$t["enonce"]."</enonce>";
      $myXML.="<question>".$t["question"]."</question>";      
      $myXML.="<va1>".$t["va1"]."</va1>";
      $myXML.="<va2>".$t["va2"]."</va2>";
      $myXML.="<va3>".$t["va3"]."</va3>";
      $myXML.="<va4>".$t["va4"]."</va4>";
      $myXML.="<va5>".$t["va5"]."</va5>";
	  $myXML.="<nva>".$t["nva"]."</nva>"; 
	  $myXML.="<fact>".$t["fact"]."</fact>";
	  $myXML.="<varFacteur>".$t["varFacteur"]."</varFacteur>";
	  $myXML.="<varFactorise>".$t["varFactorise"]."</varFactorise>";
	  $myXML.="<facteur>".$t["facteur"]."</facteur>";
      
      $myXML.="</exercice>";
      
    }
    return $myXML;
}
echo   XMLexoDistrib();

?>