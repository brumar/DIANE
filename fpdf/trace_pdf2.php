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
			  	$nom =strtoupper(substr($r3["nom"],0,1));$prenom=strtoupper($r3["prenom"]);
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
			   else if ($r["typeExo"]=='d')
			  	{
				$type = 'distributivite';
				$type1 ="d";
				}
			   else if ($r["typeExo"]=='changement' || $r["typeExo"]=='combinaison' || $r["typeExo"]=='comparaison')
			  	{
				$type = 'etape';
				$type1 ="etape";
				}
			  $numSerie =  $r["numSerie"];
			  $num = $r["numExo"]; $questi = $r["questInt"]; $sas =$r["sas"]; $choix = $r["choix"];
			  $oper1 = $r["operation1"]; $oper2 = $r["operation2"];
			  $op1 = $r["operande1"]; 
			  $op2 = $r["operande2"]; 
			  $resultat=$r["resultat"];
			  if ($op1==0 and $op2==0 and $resultat==0)
			  {$op1=''; $op2=''; $resultat='';}
			}
			
		    $sql2 = "SELECT * FROM $type where numero=$num";
		    $result = mysql_query($sql2) or die("Erreur de S&eacute;lection dans la base : ". $sql2 .'<br />'. mysql_error());
			if($type1=="d") //Enoncé de distributivite
			{
				while ($enregistrement = mysql_fetch_assoc($result))
					{
					  $text1 =  $enregistrement["enonce"];
					  $text1 = eregi_replace(" *\.",".",$text1); $text1 = eregi_replace(" *,"," ,",$text1);
					  $text1 = stripslashes($text1);
					  $text2 =  $enregistrement["question"];
					  $text2 = eregi_replace(" *\.",".",$text2);  $text2 = eregi_replace(" *,"," ,",$text2);
					  $text2 = stripslashes($text2);
					  $varFacteur = $enregistrement["varFacteur"];
					  $varFactorise = $enregistrement["varFactorise"];
					  $facteur = $enregistrement["facteur"];
				}
			    if (isset($facteur) and $facteur =='debut') 
					$codeExo = "D".$varFacteur.$varFactorise."0";
				else if (isset($facteur) and $facteur =='fin') 
					$codeExo = "D".$varFacteur.$varFactorise."1";

			}
			else if($type1=='a' || $type1=='e')// Enoncé de complement et/ou de comparaison
			{
				while ($enregistrement = mysql_fetch_assoc($result))
				{
				  $text1 =  $enregistrement["enonce1"]; $text1 = eregi_replace(" *\.",".",$text1); $text1 = eregi_replace(" *,"," ,",$text1); 
				  $text1 = stripslashes($text1);
				  $text2 =  $enregistrement["question1"]; $text2 = eregi_replace(" *\.",".",$text2);  $text2 = eregi_replace(" *,"," ,",$text2);
				  $text2 = stripslashes($text2);
				  $text3 =  $enregistrement["enonce2"]; $text3 = eregi_replace(" *\.",".",$text3);  $text3 = eregi_replace(" *,"," ,",$text3);
				  $text3 = stripslashes($text3);
				  $text4 =  $enregistrement["question2"]; $text4 = eregi_replace(" *\.",".",$text4); $text4 = eregi_replace(" *,"," ,",$text4);
				  $text2 = stripslashes($text3);
				  $variable =  $enregistrement["variable"]; 
				  $question =  $enregistrement["question"];
				}
				$codeExo = $variable.$type1.$question.$questi;
			}
			else if($type1=='etape')// Enoncé de complement et/ou de comparaison
			{
				while ($enregistrement = mysql_fetch_assoc($result))
				{
				  $text1 =  $enregistrement["enonce"]; $text1 = eregi_replace(" *\.",".",$text1); $text1 = eregi_replace(" *,"," ,",$text1);
				  $text2 =  $enregistrement["question"]; $text2 = eregi_replace(" *\.",".",$text2);  $text2 = eregi_replace(" *,"," ,",$text2);
				  $variable =  $enregistrement["variable"]; 
				  $typePb=  $enregistrement["typePb"];
				  $inconnu=  $enregistrement["inconnu"];
				}
				$codeExo = $typePb.'_'.$variable.'_'.$inconnu;
			}
			
			$pdf -> AddPage (); 
			$pdf -> SetFont ('Times' ,'' ,10 );
			$pdf -> Cell(0,5,$nom." ".$prenom." | Numéro de série ".$numSerie." | Numéro exercice ".$num. " | Numéro de trace ".$k[$i],0,0,"C");
			$pdf -> SetFont ('Times' ,'B' ,14 );
			
			
			
			if($type1=="d") 
			{
				$pdf -> SetXY(50,35);
				$pdf -> Cell(15,6,$codeExo,1,0,"C");
				$pdf -> SetFont ('Times' ,'' ,12 );
				$pdf -> SetXY(18,45);
				$pdf -> MultiCell(80,6,$text1."\n".$text2,1);
			}
			else if($type1=='a' || $type1=='e')
			{
				$pdf -> SetXY(50,35);
				$pdf -> Cell(15,6,$codeExo,1,0,"C");
				$pdf -> SetFont ('Times' ,'' ,12 );
				$pdf -> SetXY(18,45);
				if ($questi=='1')
				  {	$pdf -> MultiCell(80,6,$text1."\n".$text2."\n".$text3."\n".$text4,1);}
				else if ($questi=='0')
				  {	$pdf -> MultiCell(80,6,$text1."\n".$text3."\n".$text4,1);}
			}
			else if($type1=="etape") 
			{
				$pdf -> SetXY(28,35);
				$pdf -> Cell(60,6,$codeExo,1,0,"C");
				$pdf -> SetFont ('Times' ,'' ,12 );
				$pdf -> SetXY(18,45);
				$pdf -> MultiCell(80,6,$text1."\n".$text2,1);
			}
			//partie sas
			$pdf -> SetFont ('Times','B',10);
			$y = $pdf ->  GetY();
			$pdf -> SetXY(18,$y+2);
			$pdf -> Cell(0,5,"Pour écrire, tu peux cliquer sur les mots de l'énoncé");			
			$pdf -> SetFontSize(9);
			$pdf -> SetXY(18,$y+8);
			$pdf -> Rect(18,$y+8,80,5,'D');
			$pdf -> SetX(18);
			$pdf -> Cell(18,5,$sas,0);
			$pdf -> Image("images/boutons_sas.jpg",18,$y+15,80,8);
			
			//partie calculette
			$pdf -> SetFont ('Times','B',10);
			$y = $pdf ->  GetY();
			$pdf -> SetXY(38,$y+16);
			$pdf -> Cell(0,5,"Tu peux faire tes calculs ici");			
			$pdf -> SetFontSize(9);
			
			$pdf -> SetXY(18,$y+22);
			$pdf -> Rect(18,$y+22,55,5,'D');
			$pdf -> Image("images/egale.jpg",74,$y+21,7,7);
			$pdf -> Rect(84,$y+22,15,5,'D');
			$pdf -> SetX(18);$pdf -> Cell(18,5,$op1,0);
			$pdf -> SetX(84);$pdf -> Cell(84,5,$resultat,0);
			
			$pdf ->Ln(15);
			$y = $pdf ->  GetY();
			$pdf -> Image("images/calculette.jpg",18,$y+4,80,0);
			$pdf ->Ln(25);

				
			$pdf -> SetXY(110,30);
			$pdf -> SetFont ('Times' ,'B' ,12 );
			$pdf -> Cell(0,5,"Ecris tes calculs et ta réponse dans cette feuille");
			$pdf -> Image("images/boutons_solution.jpg",110,37,85,7);
			$pdf -> Rect(110,45,85,140,'D');
			$pdf -> SetXY(112,47);
			$pdf -> SetFont ('Times' ,'' ,10 );
			
			$pdf -> MultiCell(82,5,stripslashes($zonetext));
			$pdf -> Image("images/exerciceTermine.jpg",115,200,0,5);
			$pdf -> SetY(-60);
			if ($type1=="d")
			{
				$pdf->Table('select numTrace as Trace,id as Diag, D, Dc, De, De2, F, Fc, Fe, Fe2, Addition as addi, Multiplication as Mult, Position as Pos, B, At, M, M2, M3, N, A, Di, Em, Ed, Ea, Cimp from diagdistrib where numEleve='.$numEleve." and numTrace =".$k[$i]);
			}
			else if($type1=='a' || $type1=='e')
			{
				$pdf->Table('select numTrace as Trace,numDiag as Diag,CONCAT(var,typeExo,question,questInt) as Type, colonne1 as col1,
							colonne2 as col2,colonne3 as col3,colonne4 as col4,colonne5 as col5,colonne6 as col6,colonne7 as col7,
			      		    colonne8 as col8,colonne9 as col9,colonne10 as col10,colonne11 as col11,colonne12 as col12,colonne13 as 
							col13,colonne14 as col14,colonne15 as col15,colonne16 as col16,colonne17 as col17,colonne18 as col18 
							from diagnostic where numEleve='.$numEleve." and numTrace =".$k[$i]);
			}
			else if($type1=='etape')
			{
				$pdf->Table('select numTrace as Trace,numDiag as Diag,typePb as Type, inconnu as Inc, var, col1,col2,col3,col4 from diagetape where numEleve='.$numEleve." and numTrace =".$k[$i]);
			
			}
		}
//fin de la boucle for
/*debut de la page du diagnotic pour les problème de complement et de comparaison*/
$pdf->AddPage();

$pdf -> SetFont ('Times' ,'B' ,14 );
$pdf -> Cell(0,10,'Diagnostic des problèmes de Complement et de Comparaison',0,0,'C');
$pdf -> SetY(25);

//Premier tableau : imprime toutes les colonnes de la requête
$pdf->Table('select numTrace as Trace,numDiag as Diag,CONCAT(var,typeExo,question,questInt) as Type, colonne1 as col1,colonne2 as col2,colonne3 as col3,colonne4 as col4,colonne5 as col5,colonne6 as col6,colonne7 as col7,
			       colonne8 as col8,colonne9 as col9,colonne10 as col10,colonne11 as col11,colonne12 as col12,colonne13 as col13,colonne14 as col14,colonne15 as col15,
				   colonne16 as col16,colonne17 as col17,colonne18 as col18 from diagnostic where numEleve='.$numEleve);
/*debut de la page du diagnotic pour les problème de Distributivité*/

$pdf->AddPage();
$pdf -> SetFont ('Times' ,'B' ,14 );
$pdf -> Cell(0,10,'Diagnostic des problèmes de Distributivité',0,0,'C');
$pdf -> SetY(25);

//Premier tableau : imprime toutes les colonnes de la requête
$pdf->Table('select numTrace as Trace,id as Diag, D, Dc, De, De2, F, Fc, Fe, Fe2, Addition as addi, Multiplication as Mult, Position as Pos, B, At, M, M2, M3, N, A, Di, Em, Ed, Ea, Cimp from diagdistrib where numEleve='.$numEleve);

/*debut de la page de diagnotic pour les problème à une seule étape*/

$pdf->AddPage();
$pdf -> SetFont ('Times' ,'B' ,14 );
$pdf -> Cell(0,10,'Diagnostic des problèmes à une seule étape',0,0,'C');
$pdf -> SetY(25);

//Premier tableau : imprime toutes les colonnes de la requête
	$pdf->Table('select numTrace as Trace,numDiag as Diag,typePb as Type, inconnu as Inc, var, col1,col2,col3,col4 from diagetape where numEleve='.$numEleve);

/* fin de la page du diagnostic */
$nomFichier=$nom."_".$prenom.$numEleve.".pdf";
$pdf -> Output ($nomFichier,"D");//le D = forcer le téléchargement et le I ouvrire sans forcer  

//$pdf -> Output (); 


?>