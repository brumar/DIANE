<?php  
$aujourdhui = getdate();  
$mois = $aujourdhui['mon'];  
$jour = $aujourdhui['mday'];  
$annee = $aujourdhui['year']; 
$heur = $aujourdhui['hours']; 
$minute = $aujourdhui['minutes']; 
$seconde = $aujourdhui['seconds']; 
$date = $annee.":".$mois.":".$jour." ".$heur.":".$minute.":".$seconde;
echo ($date);
echo ("<br>");
print_r($aujourdhui);
 
?>
