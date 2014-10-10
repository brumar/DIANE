<?php 
define ('FPDF_FONTPATH' ,'font/' ); 
//require( 'fpdf.php' ); 
require('PDF_MySQL_Table.class.php');

$pdf=new PDF_MySQL_Table();
$pdf->AliasNbPages();
//$pdf =new FPDF (); 
	
	$numEleve=trim($_POST["numEleve"]);
	require_once("../mac_test/conn.php");
			$sql = "SELECT id FROM trace where numEleve=".$numEleve;
			$result = mysql_query($sql) or die("Erreur de S&eacute;lection dans la base : ". $sql .'<br />'. mysql_error());
	while($record = mysql_fetch_array($result))
	{             
		$k[]=$record[0];
	}
//debut de la première page
	$sql3="select * from eleve where numeleve=".$numEleve;
	$result3 = mysql_query($sql3) or die("Erreur de S&eacute;lection dans la base : ". $sql3 .'<br />'. mysql_error());
	while ($r3 = mysql_fetch_assoc($result3))
			{
			  	$nom =strtoupper($r3["nom"]);$prenom=strtoupper($r3["prenom"]);
				$dateNais=$r3["dateNais"]; 
				if ($dateNais == '0000-00-00')
				$dateNais=''; 
				$classe=strtoupper($r3["classe"]);
				$ville =strtoupper($r3["ville"]); $ecole=strtoupper($r3["ecole"]);
			}
	
	$pdf -> AddPage (); 
	$pdf -> SetFont ('Times' ,'' ,14 );
	$pdf -> SetXY(35,50);
	$pdf -> Cell(0,10,"Numéro élève : ".$numEleve,0,2);
	$pdf -> Cell(0,10,"Nom : ".$nom,0,2);
	$pdf -> Cell(0,10,"Prénom : ".$prenom,0,2);
	$pdf -> Cell(0,10,"Date Naissance : ".$dateNais,0,2);
	$pdf -> Cell(0,10,"Ecole : ".$ecole,0,2);
	$pdf -> Cell(0,10,"Ville : ".$ville,0,2);
	$pdf -> Cell(0,10,"Classe : ".$classe,0,2);
//fin de la première page
//début de la boucle for
	for($i=0; $i<count($k);$i++)
	{
		$sql1 ="select * from trace where id =".$k[$i];
		$result = mysql_query($sql1) or die("Erreur de S&eacute;lection dans la base : ". $sql1 .'<br />'. mysql_error());
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
			  $numSerie =  $r["numSerie"];
			  $num = $r["numExo"]; $questi = $r["questInt"]; $sas =$r["sas"]; $choix = $r["choix"];
			  $oper1 = $r["operation1"]; $oper2 = $r["operation2"];
			  $op1 = $r["operande1"]; $op2 = $r["operande2"]; $op3 = $r["operande3"]; $resultat=$r["resultat"];
			}
			
		    $sql2 = "SELECT * FROM $type where numero=$num";
		    $result = mysql_query($sql2) or die("Erreur de S&eacute;lection dans la base : ". $sql2 .'<br />'. mysql_error());
			while ($enregistrement = mysql_fetch_assoc($result))
				{
				  $text1 =  $enregistrement["enonce1"]; $text1 = eregi_replace(" *\.",".",$text1); $text1 = eregi_replace(" *,"," ,",$text1);
				  $text2 =  $enregistrement["question1"]; $text2 = eregi_replace(" *\.",".",$text2);  $text2 = eregi_replace(" *,"," ,",$text2);
				  $text3 =  $enregistrement["enonce2"]; $text3 = eregi_replace(" *\.",".",$text3);  $text3 = eregi_replace(" *,"," ,",$text3);
				  $text4 =  $enregistrement["question2"]; $text4 = eregi_replace(" *\.",".",$text4); $text4 = eregi_replace(" *,"," ,",$text4);
				  $variable =  $enregistrement["variable"]; 
				  $question =  $enregistrement["question"];
				}
			$codeExo = $variable.$type1.$question.$questi;	
			$pdf -> AddPage (); 
			$pdf -> SetFont ('Times' ,'' ,10 );
			$pdf -> Cell(0,5,$nom." ".$prenom." | Numéro de série ".$numSerie." | Numéro exercice ".$num. " | Numéro de trace ".$k[$i],0,0,"C");
			$pdf -> SetFont ('Times' ,'B' ,14 );
			$pdf -> SetXY(50,35);
			$pdf -> Cell(15,6,$codeExo,1,0,"C");
			$pdf -> SetFont ('Times' ,'' ,12 );
			
			$pdf -> SetXY(18,45);
			if ($questi=='1')
			  {
				$pdf -> MultiCell(80,6,$text1."\n".$text2."\n".$text3."\n".$text4,1);
			  }
			else if ($questi=='0')
			  {
				$pdf -> MultiCell(80,6,$text1."\n".$text3."\n".$text4,1);
			  }

			$pdf -> SetFontSize(9);
			$y = $pdf ->  GetY();
			$pdf -> SetXY(18,$y+5);
			$pdf -> Rect(18,$y+5,71,5,'D');
			$pdf -> SetX(18);
			$pdf -> Cell(18,5,$sas,0);
			$pdf -> Image("images/effacer.jpg",90,$y+5,0,5);
			$pdf -> Image("images/ecrireFeuille.jpg",40,$y+15,0,5);
			$pdf ->Ln(15);
			$y = $pdf ->  GetY();
			$pdf -> Image("images/calculette.jpg",15,$y+4,80,0);
			$pdf ->Ln(25);

			$y = $pdf ->  GetY();
			$pdf -> SetFontSize(10);
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
					$pdf -> Cell(25,5,"Deux opérations",0,1,"C");
					}
			
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
			$pdf -> Image("images/effacerOp.jpg",75,$y+50,0,5.2);
			
			$pdf -> Line(37,$y+58,70,$y+58);
			
			$pdf -> Image("images/egale.jpg",40,$y+61,0,5);
			$pdf -> SetXY(45,$y+61);
			$pdf -> Cell(25,5,$resultat,1,0);
			$pdf -> Image("images/ecrireCal.jpg",35,$y+75,0,7);
			$pdf -> Image("images/passerEffacer.jpg",110,40,0,5);
			
			$pdf -> SetXY(110,30);
			$pdf -> SetFont ('Times' ,'B' ,14 );
			$pdf -> Cell(0,5,"Ecris tes calculs et ta réponse ici");
			
			$pdf -> Rect(110,50,85,180,'D');
			$pdf -> SetXY(112,52);
			$pdf -> SetFont ('Times' ,'' ,10 );
			$pdf -> MultiCell(82,5,$zonetext);
			$pdf -> Image("images/exerciceTermine.jpg",115,240,0,5);
			$pdf -> SetY(-35);
			$pdf->Table('select numTrace as Trace,numDiag as Diag,CONCAT(var,typeExo,question,questInt) as Type, colonne1 as col1,colonne2 as col2,colonne3 as col3,colonne4 as col4,colonne5 as col5,colonne6 as col6,colonne7 as col7,
			       colonne8 as col8,colonne9 as col9,colonne10 as col10,colonne11 as col11,colonne12 as col12,colonne13 as col13,colonne14 as col14,colonne15 as col15,
				   colonne16 as col16,colonne17 as col17,colonne18 as col18 from diagnostic where numEleve='.$numEleve." and numTrace =".$k[$i]);

		}
//fin de la boucle for
/*debut de la page du diagnotic */
$pdf->AddPage();

$pdf -> SetFont ('Times' ,'B' ,14 );
$pdf -> Cell(0,10,'Résultats du diagnostic',0,0,'C');
$pdf -> SetY(25);

//Premier tableau : imprime toutes les colonnes de la requête
$pdf->Table('select numTrace as Trace,numDiag as Diag,CONCAT(var,typeExo,question,questInt) as Type, colonne1 as col1,colonne2 as col2,colonne3 as col3,colonne4 as col4,colonne5 as col5,colonne6 as col6,colonne7 as col7,
			       colonne8 as col8,colonne9 as col9,colonne10 as col10,colonne11 as col11,colonne12 as col12,colonne13 as col13,colonne14 as col14,colonne15 as col15,
				   colonne16 as col16,colonne17 as col17,colonne18 as col18 from diagnostic where numEleve='.$numEleve);

/* fin de la page du diagnostic */
$nomFichier=$nom.$numEleve.".pdf";
//$pdf -> Output ($nomFichier,"D");//le D = forcer le téléchargement et le I ouvrire sans forcer  
//
$pdf -> Output (); 


?>