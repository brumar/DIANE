<?php

  //ce tableau permet de mémoriser des éléments importants qui aideron é l'analyse finale de la formulation

$tab_expression=array();



//quantificateurs


$tab_expression['1 bille']=array('une bil');
$tab_expression['plus']=array('plu','\+');
$tab_expression['moins']=array('moin');
$tab_expression['plus de']=array('plu');
$tab_expression['moins']=array( 'moin');
$tab_expression['ils ont']=array('il ont');
$tab_expression['ils avaient']=array('il avaient');
$tab_expression['c\'est']=array('il y');


// verbes 

$tab_expression['reste']=array('rest');
$tab_expression['gagne']=array('gagn','gane','ganié','trouv');
$tab_expression['perd']=array('per');
$tab_expression['avait']=array('avé','avai');
$tab_expression['détient']=array('detient');

// noms  ....A instancier !!!

$tab_expression['_P_']=preg_split( "#;#" ,$Pun);
$tab_expression['_T_']=preg_split( "#;#" ,$Pdeux);
$tab_expression['_P_ et _T_']=array('P et T','T et P','ils','elles'); /// 

// expressions

$tab_expression['billes']=array('bill');

$tab_expression['maintenant']=array('mintenan','maintenan','aujourd\'hui','maitenant');
$tab_expression['ensemble']=array('en commun','ensemb','en semb','tout les deux','tous les deux','tou les de','enssanbl','enssenb','ensemb','antou', 'en tout', 'entou');
$tab_expression['avant']=array('aven','avan');


//chiffres

/////note importante :  si quatr et quatre sont tous deux associéé 4 l'algo n'a besoin que de connaétre que quatr => 4 detecter la racine suffit)

$tab_expression['2']=array('deu');
$tab_expression['3']=array('troi');  // seul la racine compte.
$tab_expression['4']=array('catr','quatr');
$tab_expression['5']=array('cinq','sinq','sinc','sinc');
$tab_expression['6']=array('sis','six','cis','cix');
$tab_expression['7']=array('sept','cept');
$tab_expression['8']=array('uit');
$tab_expression['9']=array('neuf','nef');
$tab_expression['10']=array('dix');


/*


$lste_EXPR= array("pas","plus","plus de","mons","mons de","maintenant", "avant", "ensemble");
$lste_NAMES= array("Pun", "Pdeux", "ls");
$lste_VERBES= array("reste","gagne", "perd","avait", "detent");
*/



foreach ($tab_expression as $index => $patterns){
	$pattern_final='#';
	foreach ($patterns as $pattern){
		$pattern_final=$pattern_final.$pattern.'|';
	}
	$pattern_final = substr($pattern_final,0,strlen($pattern_final)-1);  //permet d'enlever le dernier |' en trop
	$pattern_final=$pattern_final.'#i';
	$tab_expression[$index]=$pattern_final;
}

// fin constitution des patterns, 

// on remplace maintenant chacune des mauvaise écriture par la bonne

//
/*
foreach ($tab_expression as $index => $pattern){
$text=preg_replace( $pattern,$index,$text,-1,$count);
}*/
foreach ($tab_expression as $index => $pattern){
$replace='<span
 style="text-decoration: underline; font-weight: bold;">'.$index.'</span>';

$text=preg_replace( $pattern,$replace,$text,-1,$count);
}

?>