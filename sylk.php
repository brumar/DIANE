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
    /*$sql  = "SELECT numero, partie1, tout1, partie2, partie3, tout2 ";
    $sql .= "FROM complement ";
    $sql .= "WHERE numero<7 "; // PHP*/
    $sql  ="SELECT numEleve, colonne1, colonne2, colonne3, colonne4, colonne18 from diagnostic";
	//$sql  .="FROM diagnostic";
	//$sql  .="WHERE numExo<7" ;

    // définition des différentes colonnes de données
    // ------------------------------------------------------------------------
    $champs = Array(
      //     champ       en-tête     format         alignement  largeur
      Array( 'numEleve',     'N°',       FORMAT_ENTIER, 'L',         15 ),
      Array( 'colonne1', 'Partie 1', FORMAT_ENTIER,  'L',        15 ),
      Array( 'colonne2',    'Tout 1',   FORMAT_ENTIER,  'L',        15 ),
      Array( 'colonne3',   'Partie 2',   FORMAT_ENTIER,  'L',        15 ),
	  Array( 'colonne4',   'Tout 2',   FORMAT_ENTIER,  'L',        15 ),
	  Array( 'colonne18',   'Partie 3',   FORMAT_ENTIER,  'L',        15 )
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
        echo "ID;PASTUCES-phpInfo.net\n"; // ID;Pappli
        echo "\n";
        // formats
        echo "P;PGeneral\n";      
        echo "P;P#,##0.00\n";       // P;Pformat_1 (reels)
        echo "P;P#,##0\n";          // P;Pformat_2 (entiers)
        echo "P;P@\n";              // P;Pformat_3 (textes)
        echo "\n";
        // polices
        echo "P;EArial;M200\n";
        echo "P;EArial;M200\n";
        echo "P;EArial;M200\n";
        echo "P;FArial;M200;SB\n";
        echo "\n";
        // nb lignes * nb colonnes :  B;Yligmax;Xcolmax
        echo "B;Y".(mysql_num_rows($resultat)+1);
        echo ";X".($nbcol = mysql_num_fields($resultat))."\n";
        echo "\n";

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
        }
        echo "F;W".$cpt." 256 8\n"; // F;Wcoldeb colfin largeur
        echo "\n";

        // en-tête des colonnes (en gras --> SDM4)
        // --------------------------------------------------------------------
		for ($cpt = 1; $cpt <= $nbcol; $cpt++)
        {
            echo "F;SDM4;FG0C;".($cpt == 1 ? "Y1;" : "")."X".$cpt."\n";
            echo "C;N;K\"".$champs[$cpt-1][1]."\"\n";
        }
        echo "\n";

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
                echo ($cpt == 0 ? ";Y".$ligne : "").";X".($cpt+1)."\n";
                // valeur
                if ($num_format[$cpt] == FORMAT_TEXTE)
                    echo "C;N;K\"".str_replace(';', ';;', $enr[$cpt])."\"\n";
                else
                    echo "C;N;K".$enr[$cpt]."\n";
            }
            echo "\n";
            $ligne++;
        }

        // fin du fichier
        // --------------------------------------------------------------------
        echo "E\n";
    }
    
    mysql_close();
}

?> 