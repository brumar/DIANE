<?php 
		require_once("conn.php");
		$numTrace = 106;//$_POST['numTrace'];
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
				  //$text1 = str_replace("'","\'",$text1);
				  $text2 =  $enregistrement["question1"];
				  //$text2 = str_replace("'","\'",$text2);
				  $text3 =  $enregistrement["enonce2"];
				  //$text3 = str_replace("'","\'",$text3);
				  $text4 =  $enregistrement["question2"];
				  //$text4 = str_replace("'","\'",$text4);
				  $variable =  $enregistrement["variable"];
				  $question =  $enregistrement["question"];
				}
			$codeExo = $variable.$type1.$question.$questi;	
define ('FPDF_FONTPATH' ,'font/' ); 
require( 'fpdf.php' ); 

$pdf =new FPDF (); 
$pdf -> AddPage (); 

$pdf -> SetFont ('Times' ,'B' ,14 );
$pdf -> SetXY(45,35);
$pdf -> Cell(15,5,$codeExo,1,0,"C");

$pdf -> SetFont ('Times' ,'' ,16 );
//$pdf -> Rect(15,40,85,80,'D');
$pdf -> SetXY(15,45);
$pdf -> MultiCell(80,10,$text1."\n".$text2."\n".$text3."\n".$text4,1);
/*
$pdf -> Ln(3);
$pdf -> SetX(18);
$pdf -> MultiCell(78,5,$text2);
$pdf -> Ln(3);
$pdf -> SetX(18);
$pdf -> MultiCell(78,5,$text3);
$pdf -> Ln(3);
$pdf -> SetX(18);
$pdf -> MultiCell(78,5,$text4);
$pdf -> Rect(110,40,30,5,'D');
$pdf -> SetXY(111,40);
$pdf -> SetFont ('Times' ,'B' ,10 );
$pdf -> Cell(0,5,"Retour à la ligne"); 
*/
$pdf -> Image("passerEffacer.jpg",110,40,0,5);
$pdf -> SetFont ('Times' ,'B' ,14 );
$pdf -> SetXY(110,30);
$pdf -> Cell(0,5,"Ecris tes calculs et ta réponse ici");

/* $pdf -> Rect(145,40,22,5,'D');
$pdf -> SetXY(146,40);
$pdf -> SetFont ('Times' ,'B' ,10 );
$pdf -> Cell(0,5,"Effacer tout"); 
 */

$pdf -> Rect(110,50,85,150,'D');
$pdf -> SetXY(112,52);
$pdf -> SetFont ('Times' ,'' ,10 );
$pdf -> MultiCell(0,5,$zonetext);


$pdf -> Output (); 

?>