<?php 
$fp = fopen ("texte.TXT", "w");
$temp="merci khider pour tous se que tu fait pour moi";
//enregistre les données dans le fichier
fputs($fp, "$temp");

$contenu = fread ($fp, filesize ("texte.TXT"));
echo $contenu;
fclose ($fp);
?>
<?php
// ----------------------------------------------------------------------------

define("FORMAT_REEL",   1); // #,##0.00
define("FORMAT_ENTIER", 2); // #,##0
define("FORMAT_TEXTE",  3); // @

$cfg_formats[FORMAT_ENTIER] = "FF0";
$cfg_formats[FORMAT_REEL]   = "FF2";
$cfg_formats[FORMAT_TEXTE]  = "FG0";

// ----------------------------------------------------------------------------

$cfg_hote = 'localhost';
$cfg_user = 'root';
$cfg_pass = '';
$cfg_base = 'projet';

// ----------------------------------------------------------------------------

if (mysql_connect($cfg_hote, $cfg_user, $cfg_pass))
{
    // construction de la requête
    // ------------------------------------------------------------------------
    $sql  = "SELECT numEleve,numExo,typeExo,question,var ,questInt,colonne1, colonne2, colonne3, colonne4,colonne5,colonne6, colonne7, colonne8, colonne9,colonne10,colonne11,colonne12,colonne13,colonne14,colonne15,colonne16,colonne17,colonne18 ";
    $sql .= "FROM diagnostic ";
    //$sql .= "WHERE numero<7 "; // PHP
    

    // définition des différentes colonnes de données
    // ------------------------------------------------------------------------
    $champs = Array(
      //     champ       en-tête     format         alignement  largeur
      Array( 'numEleve',     'Num Eleve',       FORMAT_ENTIER, 'L',         10 ),
      Array( 'numExo',     'Num Exo',       FORMAT_ENTIER, 'L',         10 ),
      Array( 'typeExo', 'Type EXO', FORMAT_TEXTE,  'L',        10 ),
      Array( 'question',    'Question',   FORMAT_TEXTE,  'L',        10 ),
      Array( 'var',   'Variable',   FORMAT_TEXTE,  'L',        10 ),
	  Array( 'questInt',   'Question Int',   FORMAT_ENTIER,  'L',       10 ),
	  Array( 'colonne1',   'Colonne 1',   FORMAT_ENTIER,  'L',        10 ),
  	  Array( 'colonne2',   'Colonne 2',   FORMAT_ENTIER,  'L',        10 ),
	  Array( 'colonne3',   'Colonne 3',   FORMAT_ENTIER,  'L',        10 ),
	  Array( 'colonne4',   'Colonne 4',   FORMAT_ENTIER,  'L',        10 ),
	  Array( 'colonne5',   'Colonne 5',   FORMAT_ENTIER,  'L',        10 ),
	  Array( 'colonne6',   'Colonne 6',   FORMAT_ENTIER,  'L',        10 ),
	  Array( 'colonne7',   'Colonne 7',   FORMAT_ENTIER,  'L',        10 ),
	  Array( 'colonne8',   'Colonne 8',   FORMAT_ENTIER,  'L',        10 ),
	  Array( 'colonne9',   'Colonne 9',   FORMAT_ENTIER,  'L',        10 ),
	  Array( 'colonne10',   'Colonne 10',   FORMAT_ENTIER,  'L',        10 ),
	  Array( 'colonne11',   'Colonne 11',   FORMAT_ENTIER,  'L',        10 ),
	  Array( 'colonne12',   'Colonne 12',   FORMAT_ENTIER,  'L',        10 ),
	  Array( 'colonne13',   'Colonne 13',   FORMAT_ENTIER,  'L',        10 ),
	  Array( 'colonne14',   'Colonne 14',   FORMAT_ENTIER,  'L',        10 ),
	  Array( 'colonne15',   'Colonne 15',   FORMAT_ENTIER,  'L',        10 ),
	  Array( 'colonne16',   'Colonne 16',   FORMAT_ENTIER,  'L',        10 ),
	  Array( 'colonne17',   'Colonne 17',   FORMAT_ENTIER,  'L',        10 ),
	  Array( 'colonne18',   'Colonne 18',   FORMAT_ENTIER,  'L',        10 )
    );
    // ------------------------------------------------------------------------


    if ($resultat = mysql_db_query($cfg_base, $sql))
    {
        // en-tête HTTP
        // --------------------------------------------------------------------
        header('Content-disposition: filename=fichier.slk');
        header('Content-type: application/octetstream');
        header('Pragma: no-cache');
        header('Expires: 0');

        // en-tête du fichier SYLK
        // --------------------------------------------------------------------
        echo "ID;PASTUCES-phpInfo.net\n"; $x= "ID;PASTUCES-phpInfo.net\n";// ID;Pappli
        echo "\n";$x=$x."\n";
        // formats
        echo "P;PGeneral\n"; $x=$x."P;PGeneral\n"; 
        echo "P;P#,##0.00\n";$x=$x."P;P#,##0.00\n";    // P;Pformat_1 (reels)
        echo "P;P#,##0\n";$x=$x."P;P#,##0\n";          // P;Pformat_2 (entiers)
        echo "P;P@\n"; $x=$x."P;P@\n";              // P;Pformat_3 (textes)
        echo "\n";$x=$x."\n";
        // polices
        echo "P;EArial;M200\n";$x=$x."P;EArial;M200\n";
        echo "P;EArial;M200\n";$x=$x."P;EArial;M200\n";
        echo "P;EArial;M200\n";$x=$x."P;EArial;M200\n";
        echo "P;FArial;M200;SB\n";$x=$x."P;FArial;M200;SB\n";
        echo "\n";$x=$x."\n";
        // nb lignes * nb colonnes :  B;Yligmax;Xcolmax
        echo "B;Y".(mysql_num_rows($resultat)+1);
		$x=$x."B;Y".(mysql_num_rows($resultat)+1);
        echo ";X".($nbcol = mysql_num_fields($resultat))."\n";
		$x=$x.";X".($nbcol = mysql_num_fields($resultat))."\n";
        echo "\n";$x=$x."\n";

        // récupération des infos de formatage des colonnes
        // --------------------------------------------------------------------
		for ($cpt = 0; $cpt < $nbcol; $cpt++)
        {
            $num_format[$cpt] = $champs[$cpt][2];
            $format[$cpt] = $cfg_formats[$num_format[$cpt]].$champs[$cpt][3];
        }

        // largeurs des colonnes
        // --------------------------------------------------------------------
        for ($cpt = 1; $cpt <= $nbcol; $cpt++)
        {
            // F;Wcoldeb colfin largeur
            echo "F;W".$cpt." ".$cpt." ".$champs[$cpt-1][4]."\n";
			$x=$x."F;W".$cpt." ".$cpt." ".$champs[$cpt-1][4]."\n";
        }
        echo "F;W".$cpt." 256 8\n";
		$x=$x."F;W".$cpt." 256 8\n"; // F;Wcoldeb colfin largeur
        echo "\n";$x=$x."\n";

        // en-tête des colonnes (en gras --> SDM4)
        // --------------------------------------------------------------------
		for ($cpt = 1; $cpt <= $nbcol; $cpt++)
        {
            echo "F;SDM4;FG0C;".($cpt == 1 ? "Y1;" : "")."X".$cpt."\n";
			$x=$x."F;SDM4;FG0C;".($cpt == 1 ? "Y1;" : "")."X".$cpt."\n";
            echo "C;N;K\"".$champs[$cpt-1][1]."\"\n";
			$x=$x."C;N;K\"".$champs[$cpt-1][1]."\"\n";
        }
        echo "\n";$x=$x."\n";

        // données utiles
        // --------------------------------------------------------------------
        $ligne = 2;
        while ($enr = mysql_fetch_array($resultat))
        {
            // parcours des champs
            for ($cpt = 0; $cpt < $nbcol; $cpt++)
            {
                // format
                echo "F;P".$num_format[$cpt].";".$format[$cpt];
				$x=$x."F;P".$num_format[$cpt].";".$format[$cpt];
                echo ($cpt == 0 ? ";Y".$ligne : "").";X".($cpt+1)."\n";
				$x=$x.($cpt == 0 ? ";Y".$ligne : "").";X".($cpt+1)."\n";
                // valeur
                if ($num_format[$cpt] == FORMAT_TEXTE)
                   {
				    echo "C;N;K\"".str_replace(';', ';;', $enr[$cpt])."\"\n";
					$x=$x."C;N;K\"".str_replace(';', ';;', $enr[$cpt])."\"\n";
					}
                else
                    {
					echo "C;N;K".$enr[$cpt]."\n";
					$x=$x."C;N;K".$enr[$cpt]."\n";
					}
            }
            echo "\n";
			$x=$x."\n" ;
            $ligne++;
        }

        // fin du fichier
        // --------------------------------------------------------------------
        echo "E\n";$x=$x."E\n";
    }
    $fp = fopen ("exemple.slk", "w");
	//enregistre les données dans le fichier
	fputs($fp, "$x");

	$contenu = fread ($fp, filesize ("exemple.slk"));
	//echo $contenu;
	fclose ($fp);
    mysql_close();
}

?> 