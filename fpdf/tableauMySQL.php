<?php
define('FPDF_FONTPATH','font/');
require('PDF_MySQL_Table.class.php');
require('conn.php');
class PDF extends PDF_MySQL_Table
{
function Header()
{
    //Titre
    $this->SetFont('Arial','',12);
    $this->Cell(0,6,'Résultats du diagnostic',0,1,'C');
    $this->Ln(10);
    //Imprime l'en-tête du tableau si nécessaire
    parent::Header();
}
}

//Connexion à la base

$pdf=new PDF();
$pdf->Open();
$pdf->AddPage();
//Premier tableau : imprime toutes les colonnes de la requête
$pdf->Table('select numTrace as Trace,numDiag as Diag,CONCAT(var,typeExo,question,questInt) as Type, colonne1 as col1,colonne2 as col2,colonne3 as col3,colonne4 as col4,colonne5 as col5,colonne6 as col6,colonne7 as col7,
			       colonne8 as col8,colonne9 as col9,colonne10 as col10,colonne11 as col11,colonne12 as col12,colonne13 as col13,colonne14 as col14,colonne15 as col15,
				   colonne16 as col16,colonne17 as col17,colonne18 as col18 from diagnostic where numEleve=10');
//$pdf->AddPage();
//Second tableau : définit 3 colonnes
/* $pdf->AddCol('rank',20,'Rang','C');
$pdf->AddCol('name',40,'Pays');
$pdf->AddCol('pop',40,'Pop (2001)','R');
$prop=array('HeaderColor'=>array(255,150,100),
            'color1'=>array(210,245,255),
            'color2'=>array(255,255,210),
            'padding'=>2);
$pdf->Table('select name,format(pop,0) as pop,rank from country order by rank limit 0,10',$prop);
 */
$pdf->Output();
?> 