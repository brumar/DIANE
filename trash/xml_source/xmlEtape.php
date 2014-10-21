<?php

function XMLexoEtape() {
	
    require_once("../conn.php");
	$requete = "select * from etape";
	$result = mysql_query($requete);
	while($t=@mysql_fetch_array($result))
    {
      $myXML.="<exercice>";
      $myXML.="<numero>".$t["numero"]."</numero>";
      $myXML.="<enonce>".$t["enonce"]."</enonce>";
     
      $myXML.="<partie1>".$t["partie1"]."</partie1>";
      $myXML.="<partie2>".$t["partie2"]."</partie2>";
      
      $myXML.="<tout>".$t["tout"]."</tout>";
      
      $myXML.="<tout2>".$t["tout2"]."</tout2>";
      $myXML.="<typePb>".$t["typePb"]."</typePb>";
      $myXML.="<inconnu>".$t["inconnu"]."</inconnu>";
      $myXML.="<variable>".$t["variable"]."</variablen>";
      $myXML.="</exercice>";
      
    }
    return $myXML;
}
echo   XMLexoEtape();

?>