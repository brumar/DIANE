<?php 
		require_once("conn.php");
		$numTrace = 120;//$_POST['numTrace'];
		$sql ="select * from trace where id =".$numTrace;
		$result = mysql_query($sql) or die("Erreur de S&eacute;lection dans la base : ". $sql .'<br />'. mysql_error());
		while ($r = mysql_fetch_assoc($result))
			{
			  $zonetext =  $r["zonetext"];
			  if ($r["typeExo"]=='a')
			  	{
				$type = 'comparaison';
				$type1 ="a";
				}
			  else if ($r["typeExo"]=='e')
			  	{
				$type = 'complement';
				$type1 ="e";
				}
			  $num = $r["numExo"]; 
			  $questi = $r["questInt"];
			  $sas =$r["sas"];
			  $choix = $r["choix"];
			  $oper1 = $r["operation1"];
			  $oper2 = $r["operation2"];
			  $op1 = $r["operande1"];
			  $op2 = $r["operande2"];
			  $op3 = $r["operande3"];
			  $resultat=  $r["resultat"];
			}
			$Requete_SQL2 = "SELECT * FROM $type where numero=$num";
			$result = mysql_query($Requete_SQL2) or die("Erreur de S&eacute;lection dans la base : ". $Requete_SQL2 .'<br />'. mysql_error());
			$nombreExemple = 1;
			//while ($enregistrement = mysql_fetch_array($result))
			//while ($enregistrement = mysql_fetch_object($result))
			while ($enregistrement = mysql_fetch_assoc($result))
				{
				  $text1 =  $enregistrement["enonce1"];
				  $text1 = eregi_replace(" *\.",".",$text1);
				  $text1 = eregi_replace(" *,",",",$text1);
				  $text2 =  $enregistrement["question1"];
				  $text2 = eregi_replace(" *\.",".",$text2);
				  $text2 = eregi_replace(" *,",",",$text2);
				  $text3 =  $enregistrement["enonce2"];
				  $text3 = eregi_replace(" *\.",".",$text3);
				  $text3 = eregi_replace(" *,",",",$text3);
				  $text4 =  $enregistrement["question2"];
				  $text4 = eregi_replace(" *\.",".",$text4);
				  $text4 = eregi_replace(" *,",",",$text4);
				  $variable =  $enregistrement["variable"];
				  $question =  $enregistrement["question"];
				}
			$codeExo = $variable.$type1.$question.$questi;	
define ('FPDF_FONTPATH' ,'font/' ); 
require( 'fpdf.php' ); 

$pdf =new FPDF (); 
$pdf -> AddPage (); 
$pdf -> SetFont ('Times' ,'B' ,14 );
$pdf -> SetXY(50,35);
$pdf -> Cell(15,5,$codeExo,1,0,"C");

$pdf -> SetFont ('Times' ,'' ,12 );
/* $pdf -> Rect(15,40,85,80,'D');
$pdf -> SetXY(18,45);
$pdf -> MultiCell(78,5,$text1);
$pdf -> Ln(3);
$pdf -> SetX(18);
$pdf -> MultiCell(78,5,$text2);
$pdf -> Ln(3);
$pdf -> SetX(18);
$pdf -> MultiCell(78,5,$text3);
$pdf -> Ln(3);
$pdf -> SetX(18);
$pdf -> MultiCell(78,5,$text4); */
$pdf -> SetXY(18,45);
$pdf -> MultiCell(80,6,$text1."\n".$text2."\n".$text3."\n".$text4,1);
$pdf ->Ln(2);
$pdf -> SetFontSize(10);
$y = $pdf ->  GetY();
$pdf -> SetXY(18,$y+5);
$pdf -> Image("images/effacer.jpg",18,$y+5,0,5);
//$pdf -> Cell(15,5,"Effacer",1,0,"C"); 

$pdf -> Rect(35,$y+5,35,5,'D');
$pdf -> SetX(35);
$pdf -> Cell(35,5,$sas,0);

//$pdf -> SetX(72);
//$pdf -> Cell(33,5,"Ecrire dans la feuille",1,1,"C");
$pdf -> Image("images/ecrireFeuille.jpg",72,$y+5,0,5);
$pdf ->Ln(6);
$y = $pdf ->  GetY();
//$pdf -> setX(18);
//$pdf -> Rect(22,$y+5,5,5,'D');
//$pdf -> Image("images/passerEffacer.jpg",110,40,0,5);
if(($op3==0) || ($op3=="0") || ($op3==''))//|| ($oper2=''))
	{
		$pdf -> Image("images/boutonRadioAc.jpg",20,$y+5,5,5);
		$pdf -> setXY(25,$y+5);
		$pdf -> Cell(25,5,"Une opération",0,0,"C");
		
		//$pdf -> Rect(45,$y+5,5,5,'D');
		$pdf -> Image("images/boutonRadioIn.jpg",50,$y+5,5,5);
		$pdf -> setXY(57,$y+5);
		$pdf -> Cell(25,5,"Deux opérations",0,1,"C");
	} 
	else 
		{
	
		$pdf -> Image("images/boutonRadioIn.jpg",20,$y+5,5,5);
		$pdf -> setXY(25,$y+5);
		$pdf -> Cell(25,5,"Une opération",0,0,"C");
		
		//$pdf -> Rect(45,$y+5,5,5,'D');
		$pdf -> Image("images/boutonRadioAc.jpg",50,$y+5,5,5);
		$pdf -> setXY(57,$y+5);
		$pdf -> Cell(25,5,"Deux opérations",0,1,"C");}



$pdf ->Ln(1);
$y = $pdf ->  GetY();
$pdf -> Image("images/calculette.jpg",15,$y+4,80,0);
if(($op3==0) || ($op3=="0") || ($op3==''))
{
}
else
{
	$pdf -> SetXY(45,$y+30);
	$pdf -> Cell(25,5,$op3,1,0);
	if($oper2=="+")
		{
		$pdf -> Image("images/plus.jpg",40,$y+35,0,4.7);
		}
	else if($oper2=="-")
		{
		$pdf -> Image("images/moin.jpg",40,$y+35,0,4.7);
		}
	else 
		{
		$pdf -> Image("images/rien.jpg",40,$y+35,0,4.7);
		}
}
$pdf -> SetXY(45,$y+40);
$pdf -> Cell(25,5,$op1,1,0);
	
	if($oper1=="-")
		{
		$pdf -> Image("images/moin.jpg",40,$y+45,0,5);
		}
	else if($oper1=="+")
		{
		$pdf -> Image("images/plus.jpg",40,$y+45,0,5);
		}
	else if($oper1==":")
		{
		$pdf -> Image("images/div.jpg",40,$y+45,0,5);
		}
	else if($oper1=="x")
		{
		$pdf -> Image("images/mult.jpg",40,$y+45,0,5);
		}
	else 
		{
		$pdf -> Image("images/rien.jpg",40,$y+45,0,4.7);
		}

$pdf -> SetXY(45,$y+50);
$pdf -> Cell(25,5,$op2,1,0);
$pdf -> Image("images/effacerOp.jpg",15,$y+50,0,5.2);

$pdf -> Line(37,$y+58,70,$y+58);

$pdf -> Image("images/egale.jpg",40,$y+61,0,5);
$pdf -> SetXY(45,$y+61);
$pdf -> Cell(25,5,$resultat,1,0);

$pdf -> Image("images/ecrireCal.jpg",35,$y+75,0,7);


/*$pdf -> Rect(110,40,28,5,'D');
$pdf -> SetXY(111,40);
 $pdf -> SetFont ('Times' ,'B' ,10 );
$pdf -> Cell(0,5,"Passer à la ligne");
 */
$pdf -> Image("images/passerEffacer.jpg",110,40,0,5);



$pdf -> SetXY(110,30);
$pdf -> SetFont ('Times' ,'B' ,14 );
$pdf -> Cell(0,5,"Ecris tes calculs et ta réponse ici");

/* $pdf -> Rect(145,40,30,5,'D');
$pdf -> SetXY(146,40);
$pdf -> SetFont ('Times' ,'B' ,10 );
$pdf -> Cell(0,5,"Effacer la feuille");
 */


$pdf -> Rect(110,50,85,180,'D');
$pdf -> SetXY(112,52);
$pdf -> SetFont ('Times' ,'' ,10 );
$pdf -> MultiCell(82,5,$zonetext);
$pdf -> Image("images/exerciceTermine.jpg",115,240,0,5);


$pdf -> Output (); 

?>