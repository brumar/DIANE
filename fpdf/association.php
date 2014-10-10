<?php 
define ('FPDF_FONTPATH' ,'font/' ); 
require( 'fpdf.php' ); 

$pdf =new FPDF (); 

$nom = strtoupper($_POST["nom"]);
$prenom = strtoupper($_POST["prenom"]);
$date_n = $_POST["date_n"];
$tel= $_POST["tel"];
$mail = $_POST["mail"];
$cotisation = $_POST["cotisation"];
//print ($nom." ".$prenom." ".$date_n." ".$cotisation);
$nom_e1 = $_POST["nom_e1"]; $prenom_e1 = $_POST["prenom_e1"]; $date1 = $_POST["date1"];
$nom_e2 = $_POST["nom_e2"]; $prenom_e2 = $_POST["prenom_e2"]; $date2 = $_POST["date2"];
$nom_e3 = $_POST["nom_e3"]; $prenom_e3 = $_POST["prenom_e3"]; $date3 = $_POST["date3"];
$nom_e4 = $_POST["nom_e4"]; $prenom_e4 = $_POST["prenom_e4"]; $date4 = $_POST["date4"];

//$pdf -> setTextColor(25,29,200);
$pdf -> AddPage (); 
$pdf -> SetFont ('Times' ,'B' ,14 ); 
$pdf -> Cell (40 ,5 ,'Association Djemâa Saharidj',0,1);
$pdf -> SetFont (''); 
$pdf -> Cell (40 ,5 ,'Chez SI YOUCEF Tahar',0,1);
$pdf -> Cell (40 ,5 ,'117, rue du Faubourg Poissonnière',0,1);
$pdf -> Cell (40 ,5 ,'75009 Paris',0,1);
$pdf -> Ln(10);
$annee= date("Y");
$mois = date("m");
$jour = date("d");
$date = $jour." / ".$mois." / ".$annee;
$pdf -> SetFont ('Times' ,'B' ,18 ); 
$pdf -> Cell (0,10,"Bulletin d'adhésion ".$annee,0,1,'C');
$pdf -> Ln(15);
$pdf -> SetFont ('Times' ,'' ,14 ); 
$pdf -> Ln(1);
$pdf -> Cell (15 ,5 ,'Nom :',0,0); 
$pdf -> Cell (0 ,5 ,$nom,0,1); 

$pdf -> Ln(1);
$pdf -> Cell (22 ,5 ,'Prénom :',0,0);
$pdf -> Cell (0 ,5 ,$prenom,0,1); 

$pdf -> Ln(1);
$pdf -> Cell (37 ,5 ,'Date Naissance :',0,0);
$pdf -> Cell (0 ,5 ,$date_n,0,1); 

$pdf -> Ln(1);
$pdf -> Cell (15 ,5 ,'Tél :',0,0);
$pdf -> Cell (0 ,5 ,$tel,0,1); 

$pdf -> Ln(1);
$pdf -> Cell (20 ,5 ,'Email :',0,0);
$pdf -> Cell (0 ,5 ,$mail,0,1); 

$pdf -> Ln(10);
$pdf -> Cell (15 ,5 ,'',0,0);
$texte1="Je m'engage par ce présent bulletin à adhérer pour l'année ".$annee." à l'association Djemâa sahaidj et avoir pris connaissance du statut de l'association ainsi que son réglement intérieur.";
$pdf -> MultiCell(0,5,$texte1);
$texte2="Veuillez cocher ci-après la case vous concernant. Merci de joindre le règlement vous correspondant à l'ordre de l'association.";
$pdf -> Ln(4);
$pdf -> Cell (15 ,5 ,'',0,0);
$pdf -> MultiCell(0,5,$texte2);
$pdf -> Ln(7);
$pdf -> Cell (50 ,5 ,'',0,0);
$x = $pdf-> GetX();
$y = $pdf-> GetY();
//$pdf -> SetXY($x,$y);
$pdf -> Rect($x,$y,5,5,'D');
if($cotisation=='couple')
{
$pdf -> Cell (10 ,5 ,'X',0,0);
}
else 
{
$pdf -> Cell (10 ,5 ,'',0,0);
}
$pdf -> Cell (0 ,5 ,'Cotisation "Couple" (40€)',0,1);

$pdf -> Ln(2);
$pdf -> Cell (50 ,5 ,'',0,0);
$x = $pdf-> GetX();
$y = $pdf-> GetY();
$pdf -> Rect($x,$y,5,5,'D');
if($cotisation=='salarie')
{
$pdf -> Cell (10 ,5 ,'X',0,0);
}
else 
{
$pdf -> Cell (10 ,5 ,'',0,0);
}
$pdf -> Cell (0 ,5 ,'Cotisation "Salarié individuelle" - marié ou célibataire - (25€)',0,1);

$pdf -> Ln(2);
$pdf -> Cell (50 ,5 ,'',0,0);
$x = $pdf-> GetX();
$y = $pdf-> GetY();
$pdf -> Rect($x,$y,5,5,'D');
if($cotisation=='etudiant')
{
$pdf -> Cell (10 ,5 ,'X',0,0);
}
else 
{
$pdf -> Cell (10 ,5 ,'',0,0);
}
$pdf -> Cell (0 ,5 ,'Cotisation "Etudiant ou Chômeur" (15€)',0,1);

$pdf -> Ln(2);
$pdf -> Cell (50 ,5 ,'',0,0);
$x = $pdf-> GetX();
$y = $pdf-> GetY();
$pdf -> Rect($x,$y,5,5,'D');
//$pdf -> SetXY($x,$y);
if($cotisation=='nouvel')
{
$pdf -> Cell (10 ,5 ,'X',0,0);
}
else 
{
$pdf -> Cell (10 ,5 ,'',0,0);
}
$pdf -> Cell (0 ,5 ,'Cotisation "Nouvel adhèrant"(80€)',0,1);
$pdf -> Ln(10);
$pdf -> SetFont ('Times' ,'BI' ,14 ); 
$pdf -> Cell (0 ,5 ,'Enfants à charges',0,1);
$pdf -> Ln(4);
$pdf -> Cell (10 ,10 ,'',0,0);
$x = $pdf-> GetX();
$y = $pdf-> GetY();
$pdf -> Rect($x,$y,120,30,'D');
//ligne 1
$pdf -> SetFont ('Times' ,'B' ,12 ); 
$pdf -> SetXY($x+2,$y+1);
$pdf -> Cell (0 ,5 ,'Nom',0,0);
$pdf -> SetXY($x+42,$y+1);
$pdf -> Cell (0 ,5 ,'Prénom',0,0);
$pdf -> SetXY($x+82,$y+1);
$pdf -> Cell (0 ,5 ,'Date Naissance',0,0);
//ligne 2
$pdf -> SetFont ('Times' ,'' ,10 ); 
$pdf -> SetXY($x+2,$y+7);
$pdf -> Cell (0 ,5 ,$nom_e1,0,0);
$pdf -> SetXY($x+42,$y+7);
$pdf -> Cell (0 ,5 ,$prenom_e1,0,0);
$pdf -> SetXY($x+82,$y+7);
$pdf -> Cell (0 ,5 ,$date1,0,0);
//ligne 3
$pdf -> SetXY($x+2,$y+13);
$pdf -> Cell (0 ,5 ,$nom_e2,0,0);
$pdf -> SetXY($x+42,$y+13);
$pdf -> Cell (0 ,5 ,$prenom_e2,0,0);
$pdf -> SetXY($x+82,$y+13);
$pdf -> Cell (0 ,5 ,$date2,0,0);
//ligne 4
$pdf -> SetXY($x+2,$y+19);
$pdf -> Cell (0 ,5 ,$nom_e3,0,0);
$pdf -> SetXY($x+42,$y+19);
$pdf -> Cell (0 ,5 ,$prenom_e3,0,0);
$pdf -> SetXY($x+82,$y+19);
$pdf -> Cell (0 ,5 ,$date3,0,0);
//ligne 5
$pdf -> SetXY($x+2,$y+25);
$pdf -> Cell (0 ,5 ,$nom_e4,0,0);
$pdf -> SetXY($x+42,$y+25);
$pdf -> Cell (0 ,5 ,$prenom_e4,0,0);
$pdf -> SetXY($x+82,$y+25);
$pdf -> Cell (0 ,5 ,$date4,0,0);

$pdf -> Line($x,$y+6,$x+120,$y+6);
$pdf -> Line($x,$y+12,$x+120,$y+12);
$pdf -> Line($x,$y+18,$x+120,$y+18);
$pdf -> Line($x,$y+24,$x+120,$y+24);
$pdf -> Line($x+40,$y,$x+40,$y+30);
$pdf -> Line($x+80,$y,$x+80,$y+30);

$pdf -> SetFont ('Times' ,'' ,13 ); 
$pdf -> Ln(20);
$pdf -> Cell (120,5 ,'',0,0);
$pdf -> Cell (0 ,5 ,'Date : '.$date,0,0);
$pdf -> Ln(6);
$pdf -> Cell (130,5 ,'',0,0);
$pdf -> Cell (0 ,5 ,'Signature',0,0);
$pdf -> Ln(34);
$pdf -> SetFont ('Times' ,'IB' ,11 ); 
$pdf -> Cell (0 ,5 ,'Merci de joindre une enveloppe timbrée libellé à votre adresse pour recevoir votre reçu de règlement.',1,0,'C');

//$pdf -> cell (100,10 , 'c moi khider ton ami de toujours','RL',1); 
//$pdf -> Rect(110,40,90,30,'D');
//$pdf -> Ln(18);
//$pdf -> SetXY(110,40);
//$pdf -> Cell (40 ,10 ,'c encore moi','LR',0);
//$pdf -> Output ('association.pdf',true); 
$pdf -> Output ('formulaire.pdf',true); 

?> 