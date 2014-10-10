<?php 
$db_name = "projet";
$connection = mysql_connect("localhost", "root", "") or die("Connexion impossible.");
$table_name = 'complement';
$link=$connection;
$db = mysql_select_db($db_name, $link);
$query = "select * from " . $table_name;
$result = mysql_query($query, $connection) or die("Impossible d'interroger la base de données");
$num = mysql_num_rows($result);

if ($num != 0) 
{ 
	$file= fopen("results.xml", "w"); 
	$_xml ="<?xml version=\"1.0\" encoding=\"iso-8859-1\" ?>\r\n"; 
	$_xml .="<complement>\r\n"; 
	while ($row = mysql_fetch_array($result)) 
	  { 
		if ($row["numero"]) 
			{ 
				$_xml .="\t<Exercice numero=\"" . $row["numero"] . "\" codage=\"" . $row["variable"] ."e". $row["question"] . "0"."\">\r\n"; 
				$_xml .="\t\t<partie1>" . $row["enonce1"] . "</partie1>\r\n";
				$_xml .="\t\t<question1>" .$row["question1"] . "</question1>\r\n";
				$_xml .="\t\t<partie2>" .$row["enonce2"] . "</partie2>\r\n";
				$_xml .="\t\t<question2>" . $row["question2"] . "</question2>\r\n";
				$_xml .="\t</Exercice>\r\n"; 
			} 
			else 
			{ 
				$_xml .="\t<Exercice numero=\"Nothing Returned\">\r\n";
				$_xml .="\t\t<file>none</file>\r\n"; 
				$_xml .="\t</Exercice>\r\n"; 
			} 
	  } 
	$_xml .="</complement>"; 
	fwrite($file, $_xml); 
	fclose($file); 
	echo "le fichier XML vient d'être créer.  <a href=\"results.xml\">visualiser</a>"; 
} 
else 
{ 
	echo "No Records found"; 
} 

?>
