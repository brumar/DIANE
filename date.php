<?php 
//--- le fonction sur une page séparée nommée par exemple combo.php ---// 

//$date_du_jour=date("d-m-Y"); 
$jour=date("d"); 
$mois=date("m"); 
$an=date("Y"); 
//-------Les jours--------// 
function combo_jour ($jour=""){ 
    for ($i=1;$i<32;$i++) 
    { 
    if ($i<10) $i="0$i"; 
    echo'<option value="',$i,'"'; 
    if($i==$jour){ 
    echo 'selected'; 
    } 
    echo '>',$i,'</option>'; 
    } 
} 
//------Les mois--------// 
$mois_liste = array('Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août', 
'Septembre','Octobre','Novembre','Décembre'); 
function combo_mois ($mois=""){         
    global $mois_liste; 
    for ($i=1;$i<13;$i++)  
    { 
    $j = $i-1; 
    if ($i<10) $ii="0$i"; 
    echo '<option value="',$ii,'"'; 
    if($i==$mois){ 
    echo 'selected'; 
    } 
    echo '>',$mois_liste[$j],'</option>'; 
    } 
} 
//---Les années------// 
function combo_an ($an=""){ 
    $annee = date("Y"); 
    //$limit = $annee + 2; 
    for ($i=1930;$i<$annee;$i++)  
    { 
    echo '<option value="',$i,'"'; 
    if($i==$an){ 
    echo 'selected'; 
    } 
    echo '>',$i,'</option>'; 
    } 
} 
//--- fin de la fonction ---// 
//--- 
//--- exemple de formulaire avec appel de la fonction sur une page nommée mon_script.php par exmple ---// 

//require("combo.php"); 

echo '<table border="0" bgcolor="#000000" width="540"><form method="blabla" action="truc"><tr><td colspan="2" align="center">Exemple de select avec une fonction combo<br>Sélectionne en entrée la date du jour<hr></td></tr><tr><td valign="top">Date de début :</td><td> 
    <select name="jour_deb" size="1">'; 
    combo_jour ($jour); 
    echo '</select> 
    <select name="mois_deb" size="1">'; 
    combo_mois ($mois); 
    echo '</select> 
    <select name="an_deb" size="1">'; 
    combo_an ($an);        echo '</select><br/><br/></td>';     
    echo '</tr></form></table>'; 

//--- suite de votre script 
?> 
