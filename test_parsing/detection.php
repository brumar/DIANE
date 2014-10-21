<?php



$liste_EXPR= array("pas","plus","moins","maintenant", "avant", "ensemble");
$liste_NAMES= array("P", "T", "P et T");
$liste_VERBES= array("reste","gagne", "perd","avait", "detient");



$tab_EXPR= array(0,0,0,0,0,0);
$tab_NAMES= array(0,0,0);
$tab_VERBES= array(0,0,0,0,0);

$count=-1;

foreach ($liste_EXPR as $index => $pattern){
$count=$count+1;
$tab_EXPR[$count]=preg_match('#'.$pattern.'#',$text);
}
$count=-1;
foreach ($liste_NAMES as $index => $pattern){
$count=$count+1;
$tab_NAMES[$count]=preg_match('#'.$pattern.'#',$text);
}
$count=-1;
foreach ($liste_VERBES as $index => $pattern){
$count=$count+1;
$tab_VERBES[$count]=preg_match('#'.$pattern.'#',$text);
}



// modification :  si PDEUX et PUN présent, alors, il faut éviter de tenir compte de PUN==1 et PDEUX==1

if ($tab_NAMES[2]==1) {
$tab_NAMES[1]=0;
$tab_NAMES[0]=0;

}

//option spéciale : si PUN et PDEUX sont présents tous deux il faut savoir lequel est présent le premier

if  (($tab_NAMES[1]==1)&&($tab_NAMES[0]==1)) {
if(strpos($text,"_P_")<strpos($text, "_T_")){
$options_speciales[0]="_P_"; }
else {$options_speciales[0]="_T_";}
}


//option spéciale : la deuxième case contiendra la présence ou non de la variable de formulation

if (preg_match('#'.$type_var.'#',$text)){ //type var est défini au début du script integre...
$options_speciales[1]=true;
}
else $options_speciales[1]=false;






?>