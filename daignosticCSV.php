<?
// Liste les données de la table
 require ("../mac/conn.php");

// -------------------------------------------
$resQuery = mysql_query("SELECT numEleve,numTrace,typeExo,var ,question,colonne1, colonne2, colonne3, 
						colonne4,colonne5,colonne6, colonne7, colonne8, colonne9,colonne10,colonne11,colonne12,colonne13,colonne14,
						colonne15,colonne16,colonne17,colonne18 FROM diagnostic WHERE numEleve >= 5");
//$resQuery = mysql_query("SELECT * from diagnostic");						   
header("Content-Type: application/csv-tab-delimited-table");
header("Content-disposition: filename=diagnostic.csv");


if (mysql_num_rows($resQuery) != 0) 
{
	 // titre des colonnes
	 $fields = mysql_num_fields($resQuery);
	 $i = 0;
	 while ($i < $fields) 
	 {
	   echo mysql_field_name($resQuery, $i).";";
	   $i++;
	 }
	 echo "\n";
	 // données de la table
	 while ($arrSelect = mysql_fetch_array($resQuery, MYSQL_ASSOC)) 
	 {
		  foreach($arrSelect as $elem)
			   {
				echo "$elem;";
			   }
		  echo "\n";
	 }
	 mysql_free_result($resQuery);
}
?>
