<?php
$liste_MOTS= array("pas","plus","moins","maintenant", "avant", "ensemble");
$count=0;
$detections=array();
foreach ($liste_MOTS as $index => $pattern){
	$count=$count+1;
	$detections[$count]=preg_match('#'.$pattern.'#',$text);
}
var_dump($detections);
?>