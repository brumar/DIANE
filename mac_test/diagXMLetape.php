<?php 
require_once("conn.php");
$requete1 = "select * from diagetape where numEleve =".$_POST["numEleve"];
//$requete1 = "select * from diag_etape where colonne2=2 and colonne14=0";//".$_POST["numDiag"];
//$requete1 = "select * from diag_etape where numDiag = 80";//.$_POST["numDiag"];
//$requete1 = "select * from diag_etape where numDiag between 34 and 377";
//$requete1 = "select * from diag_etape where colonne1=2";

$result = mysql_query($requete1) or die("Impossible d'interroger la base de données");
$num = mysql_num_rows($result);
if ($num != 0) 
{ 
	$file= fopen("diagnostics\\diagXMLetape.xml", "w"); 
	$_xml ="<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\r\n"; 
	$_xml .="<?xml-stylesheet href=\"diag_etape.xsl\" type=\"text/xsl\"?>\r\n";
	$_xml .="<diagnostic>\r\n"; 
	while ($r = mysql_fetch_array($result)) 
	 { 
		
	unset($reponse,$tabImplicite,$tabOperation,$tabNombre,$tab,$tabSR,$tabR,$tabOper,$tabTOper,$tabTOperateur,$tabImp,$tabReponse,$i,$j);
		
		$req = "select zoneText as reponse from trace where id=".$r["numTrace"];
		$res = mysql_query($req) or die("Impossible d'interroger la base de données");
		while ($rc = mysql_fetch_array($res)) 
	  	{
		//suprime tous caractere different de [^\d+-=:*]
		 $reponse =  $rc["reponse"];
		 $reponseEleve = $reponse;
		 $reponse = ereg_replace ('([a-zA-Z]) *- *([a-zA-Z])','\1 \2',$reponse);
		
		//suprime tous caractere different de [^\d+-=:*]
		$reponse = trim(eregi_replace ('[^0-9|,|(|)|+|*|:|=|-]', " ",$reponse));
		
		//tabNombre contient  tous les nombres que contient la réponse de l'apprenant
		$tabNombre = preg_split ("/[\s]+/", $reponse);
		$tabNombre = array_values (preg_grep("/\d/", $tabNombre));

		//ER qui reconnait les operation de type a+....+a = a ou sans le signe egale 
		//(?:) parenthèse non capturante 
		$pattern = "/(((?:\d+\s*[\+\-\*\/x:]\s*)+\d+\s*)=?\s*(\d*))/"; 
		preg_match_all($pattern,$reponse,$tab);
		
		//tableau des opérations utilisées dans la réponse de l'apprenant ==> tabOperation
		$tabOperation = $tab[0];
		$tabSR = $tab[2];
		$tabR = $tab[3];
		
		//tableau des opérandes 
		$pat1 = "/\d+/";
		$tabTOper= array();
		for($i=0;$i<count($tabOperation); $i++)
		{
			preg_match_all($pat1,$tabOperation[$i],$tabTOperande);
			${"tabOper".$i}=$tabTOperande[0];
			$tabTOper=array_merge($tabTOper,${"tabOper".$i});
		}
		
		//tableau des opérandes 
		$pat1 = "/\+|-|\*|\//";
		$tabTOperateur= array();
		for($i=0;$i<count($tabOperation); $i++)
		{
			preg_match_all($pat1,$tabOperation[$i],$tabTOperateur);
			${"tabOperateur".$i}=$tabTOperateur[0];
			$tabTOperateur=array_merge($tabTOperateur,${"tabOperateur".$i});
		}
		$tabNombre1=$tabNombre;
		//tableau implicite
		for ($i=0; $i<count($tabTOper); $i++)
			 {
				for ($j=0 ; $j < count($tabNombre) ; $j++)
					{
					  if ($tabTOper[$i] == $tabNombre[$j])
						{
							$tabNombre[$j]='';
							break 1;
						}
					}
			 }

		$tabReponse=array();
		for ($i=0 ; $i < count($tabNombre) ;$i++)
			if ($tabNombre[$i]!='')  
				{
					$tabReponse[] = $tabNombre[$i];
				}
		//comparer les résultats des opérations avec ceux du tableau tabImp
		$tabImp=array_diff($tabReponse,$tabR);
		if(isset($tabImp) and count($tabImp)>0)
			$calImp=1;
		else 
			$calImp=0;
			
//operation à réaliser d'après l'énoncé du pb (addition ou soustraction)
$enonceAdd = array ('EFA','EIP','tout');
$enonceSous = array ('EFP','EIA','TrP','TrA','partie','diff');

//print($reponse);print("<br>");			
//print ("le tableau des operations :  ");print_r($tabOperation);print ("<br>");
//print ("le tableau d'operande :  ");print ("<br>");
/* for($i=0;$i<count($tabOperation);$i++)
{
print_r(${"tabOper".$i});print ("<br>");
}

print ("le tableau des nombres :  ");print_r($tabNombre1);print ("<br>");
print ("le tableau contient les nombres qui sont implicites ou dans la reponse de l'élève:  ");print_r($tabReponse);print ("<br>");
print ("le tableau sans resultats :  ");print_r($tabSR);print ("<br>");
print ("le tableau resultat :  ");print_r($tabR);print ("<br>");
print ("le tableau implicite :  ");print_r($tabImp);print ("<br><br><br><br>"); */

		
		
		
		//Recherche les informations sur l'énoncé dans la BD
		$requete2 = "SELECT * FROM etape where numero=".$r["numExo"];
		$result2 = mysql_query($requete2) or die("Erreur de S&eacute;lection dans la base : ". $requete2 .'<br />'. mysql_error());
		while ($r2 = mysql_fetch_assoc($result2))
				{
					$text1 = stripslashes($r2["enonce"]);
					$text2 = stripslashes($r2["question"]);
					$enonce=$text1."\r\n".$text2;
					
					$enonce = ereg_replace("\r\n", "<br/>",$enonce);
					$partie1=$r2["partie1"]; $partie2=$r2["partie2"]; $tout=$r2["tout"];
					$var = $r2["variable"];
					$typePb = $r2["typePb"];
					$inconnu = $r2["inconnu"];
					$nombre = trim(eregi_replace ('[^0-9]', " ",$r2["enonce"]));
					$donnees =  array_values(preg_split ("/[\s]+/", $nombre));
					//echo("le tableau de données :"); print_r($donnees);
					//varInc : définit la variable inconnu de l'énoncé à calculer 
					if(in_array($partie1,$donnees) and in_array($partie2,$donnees))
						$varInc="tout";
					else if(in_array($partie1,$donnees) and in_array($tout,$donnees))
						$varInc="partie2";
					else if(in_array($partie2,$donnees) and in_array($tout,$donnees))
						$varInc="partie1";	
				}
		//Rechercher le Nom, Prénom et le sexe de l'apprenant
		$requete3 = "select nom, prenom, sexe from eleve where numEleve=".$r["numEleve"];
		$result3 = mysql_query($requete3) or die("Erreur de S&eacute;lection dans la base : ". $requete3 .'<br/>'. mysql_error());
		while ($r3 = mysql_fetch_assoc($result3))
				{
					$nom = substr($r3["nom"],0,1);//$r3["nom"];
					$prenom = $r3["prenom"];
					$sexe= $r3["sexe"];									
				}
		$nbOper=count($tabOperation);
		switch ($nbOper)
				{ 
					case "0" : $nbOperLettre="zéro"; break;
					case "1" : $nbOperLettre="un"; break;
					case "2" : $nbOperLettre="deux"; break;
					case "3" : $nbOperLettre="trois"; break;
					case "4" : $nbOperLettre="quatre"; break;
					case "5" : $nbOperLettre="cinq"; break;
					case "6" : $nbOperLettre="six"; break;
					case "7" : $nbOperLettre="sept"; break;
					default : $nbOperLettre=$nbOper; break;
				}
		$_xml .="<exercice numTrace='".$r["numTrace"]."'>\r\n"; 
		$_xml .="<enonce>".$enonce."</enonce>\r\n";
		$_xml .="<reponse>".$reponseEleve."</reponse>\r\n";
		$_xml .="<nom>".ucfirst($prenom)." ".strtoupper($nom)."</nom>\r\n";
		$_xml .="<col1 code='".$r["col1"]."'> </col1>\r\n";
		$_xml .="<prenom col1=\"".$r["col1"]."\">".ucfirst($prenom)."</prenom>\r\n";
		$_xml .="<nbOper nbOper=\"".$nbOper."\" calImp=\"".$calImp."\" sexe=\"".$sexe."\" col1=\"".$r["col1"]."\">".$nbOperLettre."</nbOper>\r\n";
		$_xml .="<operation sexe=\"".$sexe."\" nbOper=\"".$nbOper."\" type='".$varInc."' col1='".$r["col1"]."' col2='".$r["col2"]."' col3='".$r["col3"]."' col4='".$r["col4"]."' col5='".$r["col5"]."'>\r\n"; 
			if($nbOper==0)
			{
				$_xml .="<res>".end($tabImp)."</res>\r\n";	
			}
			else if($nbOper==1)
			{
				if(in_array($inconnu,$enonceSous))
				{
					  if($r["col2"]==1)
							{
								$_xml .="<op>".$tabOper0[0]." + ? = ".$tabOper0[2]."</op>\r\n";	
								$resultat=$tabOper0[1];
							}
						else if($r["col2"]==7)
							{
								$_xml .="<op>".$tabOper0[0]." - ? =  ".$tabOper0[2]."</op>\r\n";
								$resultat=$tabOper0[1];
							}
						else if($r["col2"]==6)
							{
								$_xml .="<op>".$tabOper0[0]." - ? =  ".$tabOper0[2]."</op>\r\n";
								$resultat=$tabOper0[1];
							}
						else if($r["col2"]==2 || $r["col2"]==3 || $r["col2"]==4 || $r["col2"]==5 || $r["col2"]==51 || $r["col2"]==52 || $r["col2"]==53)
							{
								$_xml .="<op>".$tabSR[0]."</op>\r\n";
								$resultat=$tabR[0];
							}
						
				}
				else if(in_array($inconnu,$enonceAdd))
				{
					if($r["col2"]==1)
							{
								$_xml .="<op>".$tabOper0[0]." + ? = ".$tabOper0[2]."</op>\r\n";	
								$resultat=$tabOper0[1];
							}
				
						else 
							{
								$_xml .="<op>".$tabSR[0]."</op>\r\n";
								$resultat=$tabR[0];
							}
					
				}
			}
			else if($nbOper>1)
			{
				$_xml .="<op>";
				for($i=0;$i<count($tabOperation);$i++)
				{
					$_xml .=$tabOperation[$i]."<br/>";
				}
				$_xml .="</op>\r\n";
			}

		$_xml .="</operation>\r\n";
		
		$_xml .="<col4 sexe=\"".$sexe."\" nbOper=\"".$nbOper."\" col1='".$r["col1"]."' col3='".$r["col3"]."' col4='".$r["col4"]."' col5='".$r["col5"]."'>\r\n"; 
						$_xml .="<res>".$resultat."</res>\r\n";
						if($r["col5"]==1 || $r["col5"]==11)
							$_xml .="<resErr>".end($tabNombre)."</resErr>\r\n";
						
		$_xml .="</col4>\r\n"; 
		$_xml .="</exercice>\r\n"; 
 		}//fin du if ($r["numDiag"]) 
	 
	  } 
	$_xml .="</diagnostic>"; 
	fwrite($file, utf8_encode($_xml)); 
	fclose($file); 
	//echo "le fichier XML vient d'être créer.  <a href=\"diagnostics\\diagXMLphp.php\">visualiser</a><br/>"; 	
		echo "Le fichier vient d'être créer.  <a href=\"diagnostics\\diagXMLetape.xml\">visualiser</a><br/>"; 	

} 
else 
{ 
	echo "Pas d'enregistrement. <a href=\"javascript:history.go(-1)\">Retour</a> "; 
} 

?>
