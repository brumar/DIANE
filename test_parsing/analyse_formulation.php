<?php 

//remplacer les il (sauf il y), lui et elle par P1 et P2, noter les cas ininterprétables (doublons)

$ininterpretable=false;
$formulation_douteuse=array();
$tab_NB=array();
$recup_chiffre="#([0-9]{1,2})#";
$da=preg_match_all($recup_chiffre,$text,$tab_NB);

if ($da==0) {
	if (preg_match('#= ([0-9]{1,2})\s?bil#',$text_initial,$get)){ 		//type var est défini au début du script integre...
		$text=preg_replace('#bil#',$get[1].' billes', $text);
		$tab_NB=array($get[1]);
		$options_speciales[4]="billes accolées au nombre";
	
	}else {
$tab_NB=$tab_NB[0]; }
}
else {
$tab_NB=$tab_NB[0]; }


$nombre_de_EXPR=array_sum($tab_EXPR);
$nombre_de_NB =count($tab_NB);
$nombre_de_NAMES=array_sum($tab_NAMES);
$nombre_de_NAMES;
$nombre_de_VERBES=array_sum($tab_VERBES);

echo"<u>";echo "Interprétation : ";echo"</u>";

//on met en place des variables pour contenir les informations trouvées.

$expressions_spéciales="";
$interp="";

if ($nombre_de_NB>1) {
$ininterpretable=true; } 

	else if ($nombre_de_NB==0) { 

			
		if ($nombre_de_NAMES==1) {
			
			$da=saisir($tab_NAMES,$liste_NAMES);
			
			if ($nombre_de_EXPR=1){
			
				if( ($tab_EXPR[0]==1)&&($tab_EXPR[1]==0)&&($tab_EXPR[2]==0)) {
				echo $da.' a 0 billes ';
				$expressions_spéciales=1;
				}
				
					else if((($tab_EXPR[0]==0)&&($tab_EXPR[1]==1)&&($tab_EXPR[2]==0)&&($tab_EXPR[2]==0))||
					( ($tab_EXPR[0]==1)&&($tab_EXPR[1]==0)&&($tab_EXPR[2]==1))) {
					echo $da.' a plus billes (desambiguiser avec l énoncé transfo/comparaison ';
					$expressions_spéciales=2;
			
					}
						else if((($tab_EXPR[0]==1)&&($tab_EXPR[1]==1)&&($tab_EXPR[2]==0)&&($tab_EXPR[2]==0))||
					( ($tab_EXPR[0]==0)&&($tab_EXPR[1]==0)&&($tab_EXPR[2]==1))) {
						echo $da.' a moins de billes (desambiguiser avec l énoncé transfo/comparaison ';
						$expressions_spéciales=3;
			
					}
					else {$ininterpretable=true;}
			
			
			}
			else {$ininterpretable=true;}
			
		}
			else if ($nombre_de_NAMES==2){
		
				if ($nombre_de_EXPR==1){
			
					if( ($tab_EXPR[0]==1)&&($tab_EXPR[1]==0)&&($tab_EXPR[2]==0)) {
					$ininterpretable=true;
					}
				
						else if((($tab_EXPR[0]==0)&&($tab_EXPR[1]==1)&&($tab_EXPR[2]==0)&&($tab_EXPR[2]==0))||
						( ($tab_EXPR[0]==1)&&($tab_EXPR[1]==0)&&($tab_EXPR[2]==1))) {
					
							if ($options_speciales[0]=="_P_"){
							echo ' P a plus billes que T';
							$expressions_spéciales=4;
							}
								else if ($options_speciales[0]=="_T_"){
								echo ' T a plus billes que P';
								$expressions_spéciales=5;
								}
			
						}
							else if((($tab_EXPR[0]==1)&&($tab_EXPR[1]==1)&&($tab_EXPR[2]==0)&&($tab_EXPR[2]==0))||
							( ($tab_EXPR[0]==0)&&($tab_EXPR[1]==0)&&($tab_EXPR[1]==0)&&($tab_EXPR[2]==1))) {
				
								if ($options_speciales[0]=="_P_"){
								echo ' P a moins billes que T';
								$expressions_spéciales=6;
								}
									else if ($options_speciales[0]=="_T_"){
									echo ' _T_ a moins billes que _P_';
									$expressions_spéciales=7;
									}
				
			
							}
							else {$ininterpretable=true;}
				}
				else {$ininterpretable=true;}
			}
			else {$interp="";} //ici il y a 0 name et 0 nombre
	}
	
	
	/////////ON PASSE AU CAS OU UN NOMBRE EST DETECTE
	
	else if ($nombre_de_NB==1) {
	
		$nb=$tab_NB[0];
		
		if ($nombre_de_EXPR>=1) {
		
			if ($tab_EXPR[5]==1) { 			//mot detecté : ensemble
		
				if ((implode('',$tab_EXPR)=="000001")||(implode('',$tab_EXPR)=="000101")) {
			//on évite les cas difficiles ou il y a plein d'expressions, on autorise juste la combinaison avec "maintenant", le reste est ininterprétable
		
		
					if((implode('',$tab_NAMES)=="001")||(implode('',$tab_NAMES)=="111")||(implode('',$tab_NAMES)=="110")) {
			
					echo 'calcul du tout, la valeur associée est '.$nb;
					
					$interp="T1+P1";
	
					}
						else if(implode('',$tab_NAMES)=="000"){
						echo 'calcul du tout, la valeur associée est '.$nb.' bien que sa formulation ne détient aucun nom';
						$interp="T1+P1";
						
						}
						else $ininterpretable=true;
			
				}
				else $ininterpretable=true;
			}
		
		
		if ((implode('',$tab_EXPR)=="000010")){
		//mot detecté : 'avant' , on autorise pas d'autres expressions
			if((implode('',$tab_NAMES)=="001")||(implode('',$tab_NAMES)=="110")) {
			
			echo 'calcul du tout passé, la valeur associée est '.$nb;
			$interp='T1+P1 passé';
			
			}
			
			else if ((implode('',$tab_NAMES)=="100")||(implode('',$tab_NAMES)=="010")){
			$da=saisir($tab_NAMES,$liste_NAMES);
			echo 'calcul de '.$da.' passé, la valeur associée est '.$nb;
				if ($da=="P") {
				$interp='P1 passé';
				}
				else { $interp='P2 passé';}
				
			}
			
			else $ininterpretable=true;
		
		
		
		}
		
		if (implode('',$tab_EXPR)=="000100") { //mot detecté : maintenant
		
		if((implode('',$tab_NAMES)=="001")||(implode('',$tab_NAMES)=="111")||(implode('',$tab_NAMES)=="110")) {
			
			echo 'calcul du tout en tant que état final, la valeur associée est '.$nb;
			$interp='T1 final';
			
			}
			
			else if ((implode('',$tab_NAMES)=="100")||(implode('',$tab_NAMES)=="010")){
			$da=saisir($tab_NAMES,$liste_NAMES);
			echo 'calcul de '.$da.' en tant que état final, la valeur associée est '.$nb;
				if ($da=="P") {
				$interp='P1 final';
				}
				else { $interp='T1 final';}
			}
			
			else $ininterpretable=true;
		
		
		}
		if (($tab_EXPR[2])==1) { // mot detecté : de moins
		
			if((implode('',$tab_EXPR)=="001000")|| (implode('',$tab_EXPR)=="001100") ) {

				if((implode('',$tab_NAMES)=="100")||(implode('',$tab_NAMES)=="010")) {
					$da=saisir($tab_NAMES,$liste_NAMES);
					echo $da.' a '.$nb.' billes de moins ';
					if ($da=="P") {
					$interp='P1 perte ou T1-P1';
					}
					else { $interp='T1 perte ou P1-T1';}
					
			}
				else if ((implode('',$tab_NAMES)=="110")||(implode('',$tab_NAMES)=="010")) {
				if ($options_speciales[0]=="P"){
					echo $liste_NAMES[0].' a '.$nb.' billes de moins que '.$liste_NAMES[1];
					$interp='P1-T1';
					}
					else echo $liste_NAMES[1].' a '.$nb.' billes de moins que '.$liste_NAMES[0];
					$interp='P1-T1';
				
				}
			
				}
				
				
				
			else $ininterpretable=true;	
		}
		if (($tab_EXPR[1])==1) {  //mot detecté : de plus
			if((implode('',$tab_EXPR)=="010000")|| (implode('',$tab_EXPR)=="010100") ) { 
				if((implode('',$tab_NAMES)=="100")||(implode('',$tab_NAMES)=="010")){
				$da=saisir($tab_NAMES,$liste_NAMES);
				echo $da.' a '.$nb.' billes de plus ';
					if ($da=="P") {
					$interp='P1 gain ou T1-P1';
					}
					else { $interp='T1 gain ou P1-T1';}
				
				
			}
					else if ((implode('',$tab_NAMES)=="110")||(implode('',$tab_NAMES)=="010")) {
				if ($options_speciales[0]=="P"){
					echo $liste_NAMES[0].' a '.$nb.' billes de plus que '.$liste_NAMES[1];
					$interp='P1-T1';
					}
					else echo $liste_NAMES[1].' a '.$nb.' billes de plus que '.$liste_NAMES[0];
					$interp='T1-P1';
				
				}
			
				}
			else  $ininterpretable=true;	
		
	}
		//on passe au  cas ou il y a un nombre et pas d'expression importante
	}
	else if ($nombre_de_NAMES==0) {
	
		echo 'asémantique : '.$nb;  // A REVOIR : a gagné 3 billes est compté comme asémantique
		$interp='';
		}
		
	else if ($nombre_de_NAMES==2) {
	echo 'calcul du tout la valeur associée est : '.$nb;
	$interp='T1+P1';
		}
	
	else if  ($nombre_de_NAMES==1) {
	
	$da=saisir($tab_NAMES,$liste_NAMES);
	
	if ($nombre_de_VERBES==0) {
	
	if ($tab_NAMES[2]==1) {echo 'calcul du tout la valeur associée est '.$nb ;
	$interp="T1+P1";
	}
	else {
	
	echo $da.' a '.$nb;
	
		if ($da=="P") {
		$interp='P1';
		}
			else { $interp='T1';}
	
	}}
	
	else if ($nombre_de_VERBES==1) {
	
	//reste perd gagne avait detient
		if ($tab_VERBES[0]==1){ 
		echo 'l\'etat final de '.$da.' est '.$nb;
		if ($da=="P") {
		$interp='P1 final';
		}
			else { $interp='T1 final';}	
		
		}
		else if ($tab_VERBES[4]==1){ 
		echo $da.' a '.$nb;
		if ($da=="P") {
		$interp='P1';
		}
			else { $interp='T1';}
		
		}
		
		else if ($tab_VERBES[2]==1){ 
		echo $da.' a eu un gain negatif de'.$nb;
		if ($da=="P") {
		$interp='P1 perte';
		}
			else { $interp='T1 perte';}
		
		}
		else if ($tab_VERBES[1]==1){ 
		echo $da.' a eu un gain positif de'.$nb;
		if ($da=="P") {
		$interp='P1 gain';
		}
			else { $interp='T1 gain';}
		
		}
		
		else if ($tab_VERBES[3]==1){ 
		echo $da.'a pour etat initial'.$nb;
		if ($da=="P") {
		$interp='P1 passé';
		}
			else { $interp='T1 passé';}
		
		}
		
		else if ($tab_VERBES[0]==1){ 
		echo $da.'a pour etat final'.$nb;
		if ($da=="P") {
		$interp='P1 final';
		}
			else { $interp='T1 final';}	
		
		}
	
	}
	else $ininterpretable=true;
	
	}
	else $ininterpretable=true;
	}

if(($ininterpretable==true)||($expressions_spéciales==1)||($expressions_spéciales==2)||
($expressions_spéciales==3)||($expressions_spéciales==4)|| ($expressions_spéciales==5)||($expressions_spéciales==6)||($expressions_spéciales==7))

{echo "ininterprétable";}


/// autres indications

	//1 présence variable (année, bille etc.....)
	
echo "<br> ";
echo"<u>";echo "présence de la variable : " ; echo"</u>";
if($options_speciales[1]==true) {
echo "vrai";
$presence=1;
}
else { echo "faux" ;$presence=0;}






?>



