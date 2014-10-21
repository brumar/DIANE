<?
// Liste les données de la table
 require ("conn.php");

// -------------------------------------------
$resQuery = mysql_query("SELECT * FROM diagnostic");

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
