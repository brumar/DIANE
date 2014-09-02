<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="fr">
<head>
</head>
<body>
<form action="index.php" method="post">
  <div style="width: 500px; text-align: left;">type
d'exercice
  <select style="" size="1" name="exercice_afficher">
<option>xa1</option>
<option>xa2</option>
<option>xad</option>
<option>xot</option>
<option>xop</option>
<option>xfi</option>
<option>xfc</option>
<option>xff</option>
</select>
<br>
  </div>
  <input value="Afficher" type="submit">
 <br>
 <br>
 
</form>
<?php  if( (isset($_POST['exercice_afficher'])) ) {$ex_aff=$_POST['exercice_afficher'];

switch ($ex_aff) {
case 'xot' :
$typexo='xot';
echo "xot   :    Claire a 3 billes.
Pierre a 9 billes.
Combien de billes ont-ils ensemble ?";
break;
case 'xop' :
echo "xop   :    Paul a 4  billes. 
Ensemble, Marie et Paul ont 11 billes.
Combien de billes Marie a-t-elle ? ";
break;
case 'xa2' :
echo "xa2   :    Jean a 8 billes
Carine a 5 billes de plus que Jean
Combien Carine a-t-elle de billes ?
";
break;
case 'xad' :
echo "xad   :   Clara a 9 billes. 
Tom a  14 billes.
Combien de billes Tom a-t-il  de plus que Clara?
";
break;
case 'xa1' :
echo "xa1  :   L�a a 11 billes
Elle a 5 billes de plus que J�r�me.
Combien J�r�me a-t-il de billes ?
";
break;
case 'xff' :
echo "xff  :   Lise avait 7 billes.
Elle gagne 5 billes. 
Combien de billes a-t-elle maintenant?
";
break;
case 'xfc' :
echo "xfc  :   Anne avait 7 billes. 
Elle gagne des billes et elle a maintenant 11 billes.
Combien de billes a-t-elle  gagn�?";
break;
case 'xfi':
$typexo='xfi';							
echo "xfi   :    Simon gagne 6 billes et maintenant il a 13 billes. 
Combien Simon avait-t-il de billes?";

break;
}
echo"</br>";
echo"</br>";

} ?>
<form action="index.php" method="post">
  <div style="width: 500px; text-align: left;" ="&lt;p">Entrez une r�ponse � analyser
  <input maxlength="150" size="100" style=""
 name="texte"><br>
  </div>
  <div style="width: 500px; text-align: left;" ="&lt;p">Affichez l'�nonc� correspondant � votre r�ponse avant de tester
<INPUT type="hidden" value="<?php if( (isset($_POST['exercice_afficher'])) ) {$ex_aff=$_POST['exercice_afficher'];echo $ex_aff;}?>" name="type_exercice">
<br>
  </div>
  
  <input value="Tester" type="submit">
 <br>
 <br>
 
</form>


</body>
</html>




<?php

function saisir($b,$c) { //cette fonction est utilis�e dans analyse formulation.php

for ($j=0;$j<count($b);$j++) {
	if ($b[$j]==1) {
	return $c[$j];
	}
}
}


 if( (isset($_POST['texte']))&&(isset($_POST['type_exercice'])))  {
 
 
 $text=$_POST['texte'];
	//type var est d�fini au d�but du script integre...
$text=preg_replace('#([0-9]{1,2})#', " $0 " , $text); //permet d'espacer le necessaire

$descriptif=array();
 
$ex=$_POST['type_exercice'];
$Pdeux="";
$Pun="";
switch ($ex) {
case 'xot' :
$typexo='xot';
$P1=3;
$T1=9;
$n=115;
$Pdeux="pier;il ;lui";
$Pun="clair;elle";
break;
case 'xop' :
$typexo='xop';
$P1=4;
$T1=11;
$n=116;
$Pdeux="marie;elle";
$Pun="paul;il ;lui";
break;
case 'xa2' :
$typexo='xa2';
$P1=5;
$T1=8;
$n=117;
$Pdeux="carin;carrin;elle";
$Pun="jean;il ;lui";
break;
case 'xad' :
$typexo='xad';
$P1=9;
$T1=14;
$n=118;
$Pdeux="tom;il ;lui";
$Pun="clara;clarra;elle;marc;claire";
break;
case 'xa1' :
$typexo='xa1';
$P1=5;
$T1=11;
$n=119;
$Pdeux="l�a;lea;elle";
$Pun="j�rom;jerom;jer�m;j�r�m;il ;lui";
break;
case 'xff' :
$typexo='xff';	
$P1=5;
$T1=7;
$n=120;
$Pdeux="lise;elle";
$Pun="lise;elle";
break;
case 'xfc' :
$typexo='xfc';
$P1=7;
$T1=11;
$n=121;
$Pdeux="anne;ane;elle";
$Pun="anne;ane;elle";
break;
case 'xfi':
$typexo='xfi';							
$P1=6;
$T1=13;
$n=122;
$Pdeux="Simon;Simmon;il ;lui";
$Pun="Simon;Simmon;il ;lui";
break;
}


$text_initial=$text;
$type_var="bill|bile";


echo '<div style="text-align: center;"><big><big><span
 style="font-weight: bold; text-decoration: underline;">1)
analyse de la verbalisation</span></big></big></div>';

include ("suppression_calculs.php");
// echo "<br>";
echo"<u>"; echo " texte apr�s suppression des op�rations : "; echo"</u>";
echo $text;
echo "<br>";

include("correction.php");
echo "<br>";

include("detection.php");
echo "<br>";
echo "<br>";
include("analyse_formulation.php");
echo "<br>";
echo"<u>"; echo "mots_clefs_detect�s : ";echo"</u>";echo "<br>";
echo "(nb expressions : ";echo $nombre_de_EXPR.')';
echo "<br>";echo "(nb nombres : ";echo $nombre_de_NB.')';
echo "<br>";
echo "(nb names : ";echo $nombre_de_NAMES.')';echo "<br>";echo "(nb verbes : ";
echo $nombre_de_VERBES.')';
echo "<br>" ;
/*
if ($interp=='P1 perte ou T1-P1'){ if ( $u==118) {
$interp='T1-P1';
}
else if ($u==121){
$interp='P1 perte';}
else {$interp="ininterp";}
}

if ($interp=='P1 gain ou P1-T1'){ if ( $u==118) {
$interp='P1-T1';
}
else if ($u==121){
$interp='P1 gain';}
else {$interp="ininterp";}
}

if ($interp=='T1 perte ou P1-T1'){ if ( $u==118) {
$interp='P1-T1';
}
else if ($u==121){
$interp='T1 perte';}
else {$interp="ininterp";}
}



if ($interp=='T1 gain ou T1-P1'){ if ( $u==118) {
$interp='T1-P1';
}
else if ($u==121){
$interp='T1 gain';}
else {$interp="ininterp";}
}
*/
echo "<br>" ;
echo "<br>" ;echo 'interpretation  : '; echo '<span style="color: rgb(102, 51, 255);">'; 
echo $interp;
echo '</span>';
echo "<br>" ;
echo "<br>" ;
if (!(empty($nb))){
echo 'nombre isol�  : '.$nb; }
else $nb='';
echo "<br>" ;


echo '<div style="text-align: center;"><big><big><span
 style="font-weight: bold; text-decoration: underline;">2)
analyse de la formule de calcul</span></big></big></div>';

echo "<br>" ;
echo "<br>" ;

//etude du calcul


$reponse = ereg_replace ('([a-zA-Z]) *- *([a-zA-Z])','\1 \2',$reponse);
//suprime tous caractere different de [^\d+-=:*]
$reponse = trim(eregi_replace ('[^0-9|,|(|)|+|*|=|-]', " ",$reponse));//supprimer la division
		
//tabNombre contient  tous les nombres que contient la r�ponse de l'apprenant
$tabNombre = preg_split ("/[\s]+/", $reponse);
$tabNombre = array_values (preg_grep("/\d/", $tabNombre));
$pattern = "/(((?:\d+\s*[\+\-\*\/x]\s*)+\d+\s*)=?\s*(\d*))/"; //(?:) parenth�se non capturante (supprimer la division :)
preg_match_all($pattern,$reponse,$tub);
		
//tableau des op�ration utilis�es dans la r�ponse de l'apprenant ==> tabOperation
$tabOperation = $tub[0];
if(!empty($tabOperation[0])){
$op=$tabOperation[0];

$tab=preg_split('#\s#',$op);
foreach ($tab as $key => $val) {
if (intval($val)!=0)
$tab[$key]=intval($val);
}
echo 'le tableau des op�rations est :  '; print_r($tab);
echo '<br>';

}

//
$ident='';
$col2='';
$formule='';
$correct='';


//
switch ($ex) {
case 'xot' :
$typexo='xot';
$P1=3;
$T1=9;
$n=115;
break;
case 'xop' :
$typexo='xop';
$P1=4;
$T1=11;
$n=116;
break;
case 'xa2' :
$typexo='xa2';
$P1=5;
$T1=8;
$n=117;
break;
case 'xad' :
$typexo='xad';
$P1=9;
$T1=14;
$n=118;
break;
case 'xa1' :
$typexo='xa1';
$P1=5;
$T1=11;
$n=119;
break;
case 'xff' :
$typexo='xff';	
$P1=5;
$T1=7;
$n=120;
break;
case 'xfc' :
$typexo='xfc';
$P1=7;
$T1=11;
$n=121;
break;
case 'xfi':
$typexo='xfi';							
$P1=6;
$T1=13;
$n=122;
break;
}

//premiers tests, aucune op�rande n'a �t� r�cup�r�e mais on trouve un nombre isol� $nb
//	on cherche si il est issu d'un calcul mental

if (empty($tab[0])&&(!empty($nb))) { 

if ($nb==$P1+$T1) {
echo "<br>";
echo "calcul mental addition";
$col2='Opmentale';
$formule='+ T1 P1';
echo "<br>";
}

else if ($nb==$T1-$P1) {
echo "<br>";
echo "calcul mental soustraction";
$col2='Opmentale';
$formule='- T1 P1';

echo "<br>";
}

}

if( (!empty($tab[0]))&& (!empty($tab[1]))&& (!empty($tab[2]))&& (!empty($tab[3]))&& (!empty($tab[4]))){

if((($tab[0]==$P1)&&($tab[1]=='+')&&($tab[2]==$T1))||(($tab[0]==$T1)&&($tab[1]=='+')&&($tab[2]==$P1))){
echo "c'est une addition";  $col2='Addition'; $formule='+ T1 P1';
	if(($tab[3]=='=')&&(!empty($tab[4])&&(is_int($tab[4]) ))){
	echo "  et nous avons un resultat " ; 
	if (!empty($nb)) {
	if($nb==$tab[4]) {
			echo "bien identifi� ";
			$ident='rbi';
			}
			else { echo "mal identifi�"; $ident='rmi'; } }
	
	if ($tab[4]==$T1+$P1) { 
		echo " correct" ;
		$correct=1;
		
		}
		else {
		echo " incorrect"; 
		$correct=0;
		}
	}
}


else if (($tab[0]==$T1)&&($tab[1]=='-')) {

	if ($tab[2]==$P1) {
	
	echo "c'est une soustraction"; $col2='Soustraction'; $formule='- T1 P1';
		if(($tab[3]=='=')&&(!empty($tab[4])&&(is_int($tab[4]) ))){
		echo "  et nous avons un resultat " ; 
		if (!empty($nb)) {
		if($nb==$tab[4]) {
			echo "bien identifi� ";
			$ident='rbi';
			}
			else { echo "mal identifi�"; $ident='rmi'; }}
			
			if ($tab[4]==$T1-$P1) { 
				echo " correct" ;
				$correct=1;
				}
			else {
			echo " incorrect"; 
			$correct=0;}
		}
	}
	
	else if ($tab[4]==$P1) {
	echo "c'est une soustraction"; $col2='Soustraction'; $formule='- T1 P1';
		if(($tab[3]=='=')&&(!empty($tab[4])&&(is_int($tab[4]) ))){
		echo "  et nous avons un resultat " ; 
		if (!empty($nb)) {
		if($nb==$tab[4]) {
			echo "bien identifi� ";
			$ident='rbi';
			}
			else { echo "mal identifi�"; $ident='rmi'; }}
			
			if ($tab[4]==$T1-$P1) { 
			echo " correct" ;
			$correct=1;
			}
			else {
			echo " incorrect"; 
			$correct=0;}
		}
		
		
		}
		
}	

else if (($tab[0]==$P1)&&($tab[1]=='-')&&($tab[2]==$T1)){
echo "c'est une soustraction invers�e "; $col2='SoustInvers�e'; $formule='- T1 P1';
	if(($tab[3]=='=')&&(!empty($tab[4])&&(is_int($tab[4]) ))){
	echo "  et nous avons un resultat " ; 
	if ($tab[4]==$T1-$P1) { 
		echo " correct" ;
		$correct=1;
		}
		else {
		echo " incorrect"; 
		$correct=0;}
		if (!empty($nb)) {
		
			if($nb==$tab[4]) {
			echo "bien identifi�";
			$ident='rbi';
			}
			else { echo "mal identifi�"; $ident='rmi'; }
		
	}
}}

else if (($tab[0]==$T1)&&($tab[1]=='-')&&($tab[4]==$P1)){
echo "c'est une soustraction invers�e "; $col2='Soustraction'; $formule='- T1 P1';
	if(  (!empty($tab[2]))&&(is_int($tab[2]))  ){
	echo "  et nous avons un resultat " ; 
	if ($tab[2]==$T1-$P1) { 
		echo " correct" ;
		$correct=1;
		}
		else {
		echo " incorrect"; 
		$correct=0;}
		if (!empty($nb)) {
		
			if($nb==$tab[2]) {
			echo "bien identifi�";
			$ident='rbi';
			}
			else { echo "mal identifi�"; $ident='rmi'; }
		
	}
}}


else if (($tab[0]==$P1)&&($tab[1]=='+')&&($tab[4]==$T1)&&($tab[3]=='=')){
echo "c'est une addition � trou "; $col2='Addtrou'; $formule='- T1 P1';
	if(!empty($tab[2])&&(is_int($tab[2]) )){
	echo "  et nous avons un resultat " ; 
	if ($tab[4]==$T1-$P1) { 
		echo " correct" ;
		$correct=1;
		}
		else {
		echo " incorrect"; 
		$correct=0;}
			
		
		if (!empty($nb)) {
			if($nb==$tab[2]) {
			echo "bien identifi�";
			$ident='rbi';
			}
			else { echo "mal identifi�"; $ident='rmi'; }
		
		}
	}
}

else if (($tab[2]==$P1)&&($tab[1]=='+')&&($tab[4]==$T1)&&($tab[3]=='=')){ //la m�me mais �crit dans l'autre sens
echo "c'est une addition � trou "; $col2='Addtrou'; $formule='- T1 P1';
	if(!empty($tab[0])&&(is_int($tab[0]) )){
	echo "  et nous avons un resultat " ; 
	if ($tab[4]==$T1-$P1) { 
		echo " correct" ;
		$correct=1;
		}
		else {
		echo " incorrect"; 
		$correct=0;}
		
		if (!empty($nb)) {
			if($nb==$tab[2]) {
			echo "bien identifi�";
			$ident='rbi';
			}
			else { echo "mal identifi�"; $ident='rmi'; }
		
		}
	}
}

else if ((($tab[1]=='+'))) { $col2='Addition';}
else if ((($tab[1]=='-'))) { $col2='Soustraction';}
}
echo "<br>";
echo "<br>";
echo "<br>";

echo '<div style="text-align: center;"><big><big><span
 style="font-weight: bold; text-decoration: underline;">3)
appareillage aux options</span></big></big></div>';


$profils=array(); //associe un probl�mes les conditions pour rentrer dans les options.
$nombres=array(); //associe � un probl�me les nombres de l'�nonc�.

$valeurs['115']=array(9,3);
$valeurs['116']=array(11,4);
$valeurs['117']=array(8,5);
$valeurs['118']=array(14,9);
$valeurs['119']=array(11,5);
$valeurs['120']=array(7,5);
$valeurs['121']=array(11,7);
$valeurs['122']=array(13,6);
//9-3  11 4   8 5   9 14   11 5   7 5   13 6

$profils['115']['correct1']=array('Addition','+ T1 P1','T1+P1','rbi'); 
$profils['115']['correct2']=array('Opmentale','+ T1 P1','T1+P1','');

// EXERCICE 116

$profils['116']['correct1']=array('Soustraction','- T1 P1','T1','rbi');//11- 4 marie a 7 billes
$profils['116']['correct2']=array('Opmentale','- T1 P1','T1','');
$profils['116']['correct3']=array('Addtrou','- T1 P1','T1','rbi');

$profils['116']['interpretation_alternative_1a']=array('Addition','+ T1 P1','T1+P1','rbi'); 
$profils['116']['interpretation_alternative_1b']=array('Opmentale','+ T1 P1','T1+P1','');// 11 +4 ils ont 15 billes ensemble

$profils['116']['interpretation_alternative_2']=array('Addtrou','- T1 P1','T1+P1','rmi');  //4+7=11  11 billes  ensemble   

$profils['116']['interpretation_alternative_3']=array('','','T1+P1','',$valeurs['116'][0]); //ils ont 11 billes ensemble

$profils['116']['interpretation_alternative_4']=array('Addtrou','- T1 P1','T1','rmi',$valeurs['116'][0]); //4+7=11 marie a 11 billes    - T1 P1	Addtrou	0	rmi	T1	11


$profils['116']['interpretation_alternative_5']=array('','','T1','',$valeurs['116'][0]);//marie a 11 billes 



// EXERCICE 117


$profils['117']['correct1']=array('Addition','+ T1 P1','T1','rbi');
$profils['117']['correct2']=array('Opmentale','+ T1 P1','T1','');

$profils['117']['interpretation_alternative_1a']=array('Addtrou','- T1 P1','T1','rbi');
$profils['117']['interpretation_alternative_1b']=array('Opmentale','- T1 P1','T1','');

$profils['117']['interpretation_alternative_2']=array('','','P1','',$valeurs['117'][1]);

$profils['117']['interpretation_alternative_3a']=array('Addition','+ T1 P1','T1+P1','rbi');
$profils['117']['interpretation_alternative_3b']=array('Opmentale','+ T1 P1','T1+P1','');


// EXERCICE 118   TOM



$profils['118']['correct1']=array('Soustraction','- T1 P1','T1-P1','rbi');
$profils['118']['correct2']=array('Opmentale','- T1 P1','T1-P1','');
$profils['118']['correct3']=array('Addtrou','- T1 P1','T1-P1','rbi');

$profils['118']['interpretation_alternative_1a']=array('Addition','+ T1 P1','T1+P1','rbi'); 
$profils['118']['interpretation_alternative_1b']=array('Opmentale','+ T1 P1','T1+P1','');//ils ont 23 billes ensemble

$profils['118']['interpretation_alternative_2']=array('','','T1','',$valeurs['118'][0]); //tom a 14 billes
$profils['118']['interpretation_alternative_3']=array('Addtrou','- T1 P1','T1','rmi');  //9 + 5 = 14  tom a 14 billes
$profils['118']['interpretation_alternative_4']=array('','','T1','',$valeurs['118'][1]); //tom a 5 billes




// EXERCICE 119


$profils['119']['correct1']=array('Soustraction','- T1 P1','P1','rbi');
$profils['119']['correct2']=array('Opmentale','- T1 P1','P1','');
$profils['119']['correct3']=array('Addtrou','- T1 P1','P1','rbi');

$profils['119']['interpretation_alternative_1a']=array('Addition','+ T1 P1','T1+P1','rbi'); // ensemble ils ont 16
$profils['119']['interpretation_alternative_1b']=array('Opmentale','+ T1 P1','T1+P1','rbi'); // ensemble ils ont 16

$profils['119']['interpretation_alternative_2a']=array('Addition','+ T1 P1','P1','rbi'); // jerome a 16 billes
$profils['119']['interpretation_alternative_2a']=array('Opmentale','+ T1 P1','P1',''); // jerome a 16 billes

$profils['119']['interpretation_alternative_4']=array('','','P1','',$valeurs['119'][1]); //tom a 5 billes




// EXERCICE 120



$profils['120']['correct1a']=array('Addition','+ T1 P1','P1','rbi');
$profils['120']['correct1b']=array('Opmentale','+ T1 P1','P1','');
$profils['120']['correct2a']=array('Addition','+ T1 P1','P1 final','rbi');
$profils['120']['correct2b']=array('Opmentale','+ T1 P1','P1 final',''); 
$profils['120']['correct3a']=array('Addition','+ T1 P1','P1 pass�','rbi');
$profils['120']['correct3b']=array('Opmentale','+ T1 P1','P1 pass�','');         

$profils['120']['interpretation_alternative_1a']=array('Addition','+ T1 P1','P1 gain','rbi');//elle a gagn� 12 billes
$profils['120']['interpretation_alternative_1b']=array('Opmentale','+ T1 P1','P1 gain','');   //elle a gagn� 12 billes

$profils['120']['interpretation_alternative_2a']=array('','','P1 pass�','',$valeurs['120'][1]); //elle avait 5 billes
$profils['120']['interpretation_alternative_2b']=array('','','P1','',$valeurs['120'][1]);   //elle a 5 billes


//// EXERCICE 121 : Anne avait 7 billes. lle gagne des billes et elle a maintenant 11 billes.Combien de billes a-t-elle  gagn�?


$profils['121']['correct1']=array('Soustraction','- T1 P1','P1 gain','rbi');   // 11-7=4 lise a gagn� 4 billes
$profils['121']['correct2']=array('Opmentale','- T1 P1','P1 gain','');
$profils['121']['correct3']=array('Addtrou','- T1 P1','P1','rbi');

$profils['121']['interpretation_alternative_1a']=array('Opmentale','+ T1 P1','P1 gain',''); // elle a gagn� 18 biles
$profils['121']['interpretation_alternative_1b']=array('Addition','+ T1 P1','P1 gain','rbi'); 

$profils['121']['interpretation_alternative_1(2)a']=array('Opmentale','+ T1 P1','P1',''); // elle a  18 biles
$profils['121']['interpretation_alternative_1(2)b']=array('Addition','+ T1 P1','P1','rbi'); 

$profils['121']['interpretation_alternative_1(3)a']=array('Opmentale','+ T1 P1','P1 pass�',''); // elle avait  18 biles
$profils['121']['interpretation_alternative_1(3)b']=array('Addition','+ T1 P1','P1 pass�','rbi'); 

$profils['121']['interpretation_alternative_2a']=array('Addtrou','- T1 P1','P1 gain','rmi'); //7+4 = 11 elle a gagn� 11 biles 
$profils['121']['interpretation_alternative_2b']=array('Addtrou','- T1 P1','P1','rmi'); //7+4 = 11 elle a 11 billes
$profils['121']['interpretation_alternative_2b']=array('Addtrou','- T1 P1','P1 final','rmi'); //7+4 = 11 elle a maintenant 11 billes
$profils['121']['interpretation_alternative_2c']=array('Addtrou','- T1 P1','P1 pass�','rmi'); //7+4 = 11 elle avait 11 billes

$profils['121']['interpretation_alternative_3a']=array('','','P1','',$valeurs['121'][1]); // elle a 11 billes
$profils['121']['interpretation_alternative_3b']=array('','','P1 gain','',$valeurs['121'][1]); // elle a gagn� 11 billes
$profils['121']['interpretation_alternative_3c']=array('','','P1 pass�','',$valeurs['121'][1]); // elle avait 11 billes
$profils['121']['interpretation_alternative_3d']=array('','','P1 final','',$valeurs['121'][1]); // elle a maintenant 11 billes


$profils['121']['interpretation_alternative_4a']=array('','','P1','',$valeurs['121'][0]); // elle a 7 billes
$profils['121']['interpretation_alternative_4b']=array('','','P1 gain','',$valeurs['121'][0]); // elle a 7  billes
$profils['121']['interpretation_alternative_4c']=array('','','P1 pass�','',$valeurs['121'][0]); // elle avait 7 billes

//// EXERCICE 122 : XFI : Simon gagne 6 billes et maintenant il a 13 billes. Combien Simon avait-t-il de billes?

$profils['122']['correct1']=array('Soustraction','- T1 P1','P1 pass�','rbi');
$profils['122']['correct2']=array('Opmentale','- T1 P1','P1 pass�','');
$profils['122']['correct3']=array('Addtrou','- T1 P1','P1','rbi');

$profils['122']['interpretation_alternative_1(1)a']=array('Opmentale','+ T1 P1','P1 gain',''); // il a gagn� 19 biles
$profils['122']['interpretation_alternative_1(1)b']=array('Addition','+ T1 P1','P1 gain','rbi'); 

$profils['122']['interpretation_alternative_1(2)a']=array('Opmentale','+ T1 P1','P1',''); // il a  19 biles
$profils['122']['interpretation_alternative_1(2)b']=array('Addition','+ T1 P1','P1','rbi'); 

$profils['122']['interpretation_alternative_1(3)a']=array('Opmentale','+ T1 P1','P1 pass�',''); // il avait  19 biles
$profils['122']['interpretation_alternative_1(3)b']=array('Addition','+ T1 P1','P1 pass�','rbi'); 

$profils['122']['interpretation_alternative_2a']=array('','','P1','',$valeurs['122'][1]); // il a 6 billes
$profils['122']['interpretation_alternative_2b']=array('','','P1 gain','',$valeurs['122'][1]); // il a gagn� 6  billes
$profils['122']['interpretation_alternative_2c']=array('','','P1 pass�','',$valeurs['122'][1]); // il avait 6 billes
$profils['122']['interpretation_alternative_2d']=array('','','P1 final','',$valeurs['122'][1]); // il a maintenant 6 billes

$profils['122']['interpretation_alternative_3a']=array('Addtrou','- T1 P1','P1 gain','rmi'); //6+7=13 il a gagn� 13 biles
$profils['122']['interpretation_alternative_3b']=array('Addtrou','- T1 P1','P1','rmi'); //6+7=13 il a  13 biles
$profils['122']['interpretation_alternative_3c']=array('Addtrou','- T1 P1','P1 pass�','rmi'); //6+7=13 il avait 13 billes
$profils['122']['interpretation_alternative_3d']=array('Addtrou','- T1 P1','P1 final','rmi'); //6+7=13 il a maintenant 13 billes

$profils['122']['interpretation_alternative_4a']=array('','','P1','',$valeurs['122'][0]); // il a  13 biles
$profils['122']['interpretation_alternative_4b']=array('','','P1 gain','',$valeurs['122'][0]); // il a gagn� 13 biles
$profils['122']['interpretation_alternative_4c']=array('','','P1 pass�','',$valeurs['122'][0]); // il avait 13 billes
$profils['122']['interpretation_alternative_4d']=array('','','P1 pass�','',$valeurs['122'][0]); // il a maintenant 13 billes

$profils['122']['interpretation_alternative_5']=array('Soustraction','- T1 P1','P1 gain','rbi');
$profils['122']['interpretation_alternative_5']=array('Opmentale','- T1 P1','P1 gain','');
$profils['122']['interpretation_alternative_5']=array('Addtrou','- T1 P1','P1 gain','rbi');

// Simon avait 19 billes
// Simon a /avait 6 billes
// 6+7=13 simon a/avait/a gagn� 13 billes
// simon a/avait 13 billes
// Simon a gagn� 7 billes




for ($p=115;$p<=122;$p++) { 

$profils[strval($p)]['asemantique1a']=array('Soustraction','- T1 P1','','rbi');
$profils[strval($p)]['asemantique1b']=array('Soustraction','- T1 P1','','');
$profils[strval($p)]['asemantique1c']=array('Opmentale','- T1 P1','','');

$profils[strval($p)]['asemantique2a']=array('Addition','+ T1 P1','');
$profils[strval($p)]['asemantique2b']=array('Addtrou','- T1 P1','');
$profils[strval($p)]['asemantique2c']=array('Opmentale','+ T1 P1','');

$profils[strval($p)]['asemantique3']=array('','','','',$valeurs[strval($p)][0]);
$profils[strval($p)]['asemantique4']=array('','','','',$valeurs[strval($p)][1]);

// reste les reprises d'op�randes

}
////$data['col2'],$data['col1'],$data['col5'],$data['col4'],$data['col6']

	$descriptif=array($col2,$formule,$interp,$ident,$nb);
	echo '<br>';
	echo 'Table de codage : ';
	print_r($descriptif);echo "<br>"; echo "<br>"; echo "Les 2 premi�res colonnes concernent les calculs, la troisi�me concerne le type d'affectation <br> 
	(par exemple, T1+P1 est un tout est T1-P1 est une comparaison)<br>
	la quatri�me colonne concerne l'identification du r�sultat dans le calcul.
	<br> la derni�re colonne concerne le nombre isol� s'il existe";
	
	//echo "<br>";
	$tableau=$profils[strval($n)];
	$rep=$text_initial;
	echo "<br>"; 
	echo "<br>"; 
	echo '<div style="text-align: center;"><big><big><span
 style="text-decoration: underline; font-weight: bold;"></span></big></big>
';echo "<u>";echo "<big>";
	echo "conclusion";echo "</u>"; echo"</big>";
	echo "<br>"; 
	echo "<br>"; 
	echo '<span style="color: rgb(102, 51, 255);">'; 
	echo $rep;
	echo '</span>';
	echo ' est    associ�e dans les options du mod�les des contraintes � une option de type    ';
	echo '<span style="color: rgb(102, 51, 255);">'; 
		$bool=1;
		
		foreach($tableau as $index=>$value) {
			
			$descriptif2 = array_slice($descriptif, 0,count($value));
			
		
			if ($descriptif2==$value) {
			
			$index=substr($index,0,-1);
			echo $index;
			
			
			
			
			
			
			
			
			$bool=0;
			}
		
		}
			if ($bool==1) {
			echo " aucune option particuli�re";
			}
	echo '</span>';
	echo "<br>";
	echo "<br>";
	echo "Note : les options du types asemantiqueX correspondent � des options as�mantiques, c'est � dire des options auxquelles nous n'avons pas d'�l�ments <br> 
	pour associer la r�ponse � une mauvaise interpr�tation du probl�me, le num�ro qui suit indexe l'options parmis les possibles <br>
	les options du type  interpr�tation_alternatives sont justement les autres cas, les options correctes correspondent � l'option s�mantique juste pour r�pondre au probl�me<br>";
	
	
	echo "</div>";

echo "<br>";





////FIN etude calcul

}
echo "<br>";
echo "<br>";
echo 'N\' h�sitez pas � me faire<a href="mailto:bruno.martin@it-sudparis.eu?subject=Feedback  (bug/question/suggestion)">  un retour </a>m�me tr�s succinct concernant un bug, une suggestion ou une question, merci par avance.' ;



//mysql_close(); 
?>
</body>
</html>
