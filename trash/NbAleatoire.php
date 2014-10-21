<? 
require ("conn.php"); 
$sql = "SELECT * FROM complement";
$result = mysql_query($sql) or die ("Requête incorrecte");
if ($result) // Si il y'a des résultats
{ 
	while ($enregistrement = mysql_fetch_assoc($result))
	 {
	  $t[]= $enregistrement["numero"];
	 }
	 print_r($t);
	 $trand=array_rand($t,4);
	 print("<br>".$trand[0]."\n");  
	 print($trand[1]."\n");  
	 print($trand[2]."\n");  
	 print($trand[3]);  


}
?>


