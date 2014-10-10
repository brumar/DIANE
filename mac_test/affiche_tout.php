<html>
<head>
<title>Outil d'affichage</title>
<?php
// uh, mai 2001
// ATTENTION !! Les quatre variables $HOST, $USER, $PASS et $DATB doivent être adaptées au fichier inc utilisé
//require('var.inc.php3');
?>
</head>
<body>
<p align="center"> 
<a href="../index.html">Accueil</a> &nbsp;&nbsp;
<a href="admin.php">Admin</a>&nbsp;&nbsp;
<a href="eleve.html">Elève</a>  
  </p>
<?php
$cnx = mysql_connect("localhost", "root" , ""); //connexion au serveur de bases
if ($cnx)
{
    //echo "Serveur trouv&eacute; !!<br>\n";
    if(mysql_select_db("projet", $cnx))    // connexion a la base
    {
      //echo "<p>Base <b>$DATB</b> trouv&eacute;e !! </p>\n";
	  
	  if (!isset($tbl))
      {
      $res = @mysql_list_tables("projet", $cnx);
      $num_tables = mysql_num_rows($res);
      echo ("<b>Voici la liste des tables de cette base :</b><BR>");
        for ($i=0;$i<$num_tables;$i++)
        {
          $name = mysql_tablename($res, $i);
          echo ("<a href = \"affiche_tout.php?tbl=$name\">$name</a><BR>");
        }
      }
      else
      {
//$sql = "select * from complement";
        $sql = "select * from ".$_GET['tbl'];

        $res1 = mysql_query($sql,$cnx);   // selection de la table demandée
        if ($res1)
        {
           $numreg = mysql_num_rows($res1);
           echo ("<p>La table <b>$tbl</b> contient $numreg enregistrements. <a href=\"affiche_tout.php\">Autre table</a></p>");
           echo "<table border=\"1\">\n";
           echo "<tr>";
           for($i = 0; $i < mysql_num_fields($res1); $i++)
           {
              $nom_col = mysql_field_name($res1, $i);
              $type_col = mysql_field_type($res1, $i);
              $len_col = mysql_field_len($res1, $i);
              echo "<th>";
              //echo "<small>" . "Champ : " . $nom_col . "<br>" . "Type : " . $type_col . "<br>" . "Largeur : " . $len_col . "</small>";
			  echo "<small>". $nom_col . "<br></small>";
              echo "</th>";
           }
          echo "</tr>\n";
          while ($ligne = mysql_fetch_row($res1))
          {
             echo "<tr>";
             for($i = 0; $i < mysql_num_fields($res1); $i++)
             echo "<td><small>" . $ligne[$i] . "</small></td>";
             echo "</tr>\n";
          }
          echo "</table>\n";
          echo ("<p><a href=\"affiche_tout.php\">Autre table</a></p>");
          mysql_free_result($res1);
          }
          else
          {
          echo "Requ&ecirc;te $sql sans succ&egrave;s.<br>\n";   // si la requête échoue
          echo mysql_errno() . ": " . mysql_error() . "<br>\n";
         }
      }
    }
  else
    {
    echo "Base inaccessible.<br>\n";    // si la base n'est pas trouvée
    echo mysql_errno() . ": " . mysql_error() . "<br>\n";
    }
mysql_close();
}
else
{
echo "Pas de liaison avec le serveur.<br>\n";    // si la connexion au serveur ne peut pas se faire
echo mysql_errno() . ": " . mysql_error() . "<br>\n";
}

?>
</body>
</html>
