<?php 
require ("conn.php");  
$sql = "SELECT * FROM diagnostic where numDiag=30";
$result = mysql_query($sql) or die ("Requête incorrecte");
if ($result) 
  { 
  while ($enregistrement = mysql_fetch_assoc($result))
	{
		  $typeExo = $enregistrement["typeExo"];
		  $col1 =  $enregistrement["colonne1"];
		  $col2 =  $enregistrement["colonne2"];
		  $col3 =  $enregistrement["colonne3"];
		  $col4 =  $enregistrement["colonne4"];
		  if ($typeExo=="a")
		  {
		  	$col6 =  $enregistrement["colonne6"];
		  	$col7 =  $enregistrement["colonne7"];
		  	$col8 =  $enregistrement["colonne8"];
		  }
		  else if ($typeExo=="e")
		  {
		  	$col10 =  $enregistrement["colonne10"];
		  	$col11 =  $enregistrement["colonne11"];
		  	$col12 =  $enregistrement["colonne12"];
		  }
		  $col14 =  $enregistrement["colonne14"];
		  $col15 =  $enregistrement["colonne15"];
		  $col16 =  $enregistrement["colonne16"];
		  $col17 =  $enregistrement["colonne17"];
	}
	if ($typeExo=="a")
		{
			print($col1." ".$col2." ".$col3." ".$col4." ".$col6." ".$col7." ".$col8." ".$col14." ".$col15." ".$col16." ".$col17);
		}
	else if ($typeExo=="e")
		{
			print($col1." ".$col2." ".$col3." ".$col4." ".$col10." ".$col11." ".$col12." ".$col14." ".$col15." ".$col16." ".$col17);
		}
}
echo "<br>";

switch ($col1)
	{
		case "1" : echo "Etape";break;
		case "2" : echo "Différence";break;
		case "3" : echo "Etape et difference";break;
		case "4" : echo "Non pertinent";break;
		case "5" : echo "Non identifiable solution correcte";break;
		case "6" : echo "Non identifiable solution incorrecte";break;
		case "7" : echo "resultat de la difference comme résultat Erreur";break;
		case "9" : echo "absence";
	}
switch ($col2)
	{
		case "0" : echo "implicite";break;
		case "1" : echo "addition à trou";break;
		case "2" : echo "soustraction";break;
		case "3" : echo "soustraction inversée";break;
		case "4" : echo "addition";break;
		case "5" : echo "Non identifiable solution incorrecte";break;
		case "6" : echo "resultat de la difference comme résultat Erreur";break;
		case "7" : echo "absence";
	}
		

?>