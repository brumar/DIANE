<?php 
require_once("conn.php");
//$requete1 = "select * from diagnostic where numEleve =".$_POST["numDiag"];
//$requete1 = "select * from diagnostic where colonne1 = 7 and colonne6=2";//".$_POST["numDiag"];
$requete1 = "select * from diagnostic where numEleve =".$numEleve." and numTrace =".$k[$i];
//$requete1 = "select * from diagnostic where numDiag between 34 and 377";

$result = mysql_query($requete1) or die("Impossible d'interroger la base de données");
$num = mysql_num_rows($result);
if ($num != 0) 
{ 
	$file= fopen("diagnostics\\diagXML.xml", "w"); 
	$_xml ="<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\r\n"; 
	$_xml .="<?xml-stylesheet href=\"..\\static\\diag.xsl\" type=\"text/xsl\"?>\r\n";
	$_xml .="<diagnostic>\r\n"; 
	while ($r = mysql_fetch_array($result)) 
	 { 
		$reponseEleve='';
		$reponse='';
		$tabOperation[]='';
		$tabOp[]='';
		$tabOper[]='';
		$tabNombre[]='';
		$tabSR []= '';
		$tabR []= '';
		$tabTOper[]='';
		$tabImp[] = '';
		$tabImplicite[]='';
		$tabOper[]='';$tabFOperande[]='';
		$RCorrect='';$RCorrectErreur='';$RInCorrect='';
		$_xml .="<exercice>\r\n"; 
		$req = "select zoneText as reponse from trace where id=".$r["numTrace"];
		$res = mysql_query($req) or die("Impossible d'interroger la base de données");
		while ($rc = mysql_fetch_array($res)) 
	  	{
		 $reponseEleve = $rc["reponse"];
		 $reponseEleve = ereg_replace("\r\n|\n", "<br/>",$reponseEleve);
		 $reponse = $rc["reponse"];
		 $reponse = ereg_replace ('([a-zA-Z]) *- *([a-zA-Z])','\1 \2',$reponse);
		//suprime tous caractere different de [^\d+-=:*]
		$reponse = trim(eregi_replace ('[^0-9|,|(|)|+|*|:|=|-]', " ",$reponse));
		
		//tabNombre contient  tous les nombres que contient la réponse de l'apprenant
		$tabNombre = preg_split ("/[\s]+/", $reponse);
		$tabNombre = array_values (preg_grep("/\d/", $tabNombre));

		//$pattern = "/((?:\d+\s*[\+\-\*\/x:]\s*)*(?:\(\s*(?:\d+\s*[\+\-\*\/x:]\s*)+\d+\s*\)\s*[\+\-\*\/x:]?\s*)*\d*\s*=?\s*\d+)/";
		//ER qui reconnait les operation de type a+....+a = a ou sans le signe egale 
		$pattern = "/(((?:\d+\s*[\+\-\*\/x:]\s*)+\d+\s*)=?\s*(\d+))/"; //(?:) parenthèse non capturante 
		preg_match_all($pattern,$reponse,$tab);
		
		//tableau des opération utilisées dans la réponse de l'apprenant ==> tabOperation
		$tabOperation = $tab[0];
		$tabSR = $tab[2];
		$tabR = $tab[3];
		
		$resFin=trim(end($tabR));
		for($i=0;$i<count($tabOperation); $i++)
		 {
		 	$tabOp[$i]=trim(ereg_replace('\s*| ','',$tabOperation[$i]));
			$tabSR[$i]=trim(ereg_replace('\s*| ','',$tabSR[$i]));
		 }
		 $opFinSR=trim(end($tabSR));
		 $resFin=trim(end($tabR));
		//tableau des opérandes 
		$pat1 = "/\d+/";
		$tabTOper= array();
		for($i=0;$i<count($tabOperation); $i++)
		{
			preg_match_all($pat1,$tabOperation[$i],$tabTOperande);
			$tabOper{$i}=$tabTOperande[0];
			$tabTOper=array_merge($tabTOper,$tabOper{$i});
		}
				
	    //tableau des opérandes uniquement l'opération finale
		preg_match_all($pat1,end($tabOperation),$tabFOperande);
		$tabOper=$tabFOperande[0];

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

		for ($i=0 ; $i < count($tabNombre) ;$i++)
		if ($tabNombre[$i]!='')
		  $tabImp[] = $tabNombre[$i];

		//comparer les résultats des opérations avec ceux du tableau tabImp
		$tabImplicite=array_diff($tabImp,$tabR);
		
		//affectation du resultat implicicte à la variable resultat final resFin
		if(isset($tabImplicite) and count($tabImplicite)>=1 and end($tabImplicite)!="")
			$resFin=end($tabImplicite);

		//print_r($tabImp); echo(" tableau des résultats<br>");
		//print_r($tabImplicite); echo(" tableau des résultats Implicites<br>");
		//print_r($tabNombre);echo(" tableau des nombres utilisés dans la réponse<br>");
		//print_r($tabOper);echo("tableau des opérandes=>opération finale<br>");
		//print_r($tabTOper);echo("tableau des opérandes<br>");
		//print_r($tab[0]);echo(" tableau d'opérations <br>");
		//print_r($tab[2]);echo(" tableau d'opérations sans résultats<br>");
		//print_r($tab[3]);echo(" tableau de résultats<br>");
		//print_r($opFinSR);echo("<br>");
		//print_r($tabSR);echo("<br>");
		//print_r($tabOperande);echo("tableau des opérandes<br>");
		//print_r($tabOperation);echo("<br>");
	}
		//verifie si la solution est Correcte
		if((ereg("[1-3]",$r["colonne1"])) and $r["colonne14"]==0 and $r["colonne15"]==0 and $r["colonne16"]==9 and $r["colonne17"]==0)
		$RCorrect = true;
		else if(($r["colonne1"]==1 || $r["colonne1"]==3) and  $r["colonne14"]==1 and (ereg("[1-3]",$r["colonne15"])) and $r["colonne16"]==0 and $r["colonne17"]==0)
		$RCorrect = true;
		else if(($r["colonne1"]==1 || $r["colonne1"]==3) and  $r["colonne14"]==2 and $r["colonne15"]==4 and $r["colonne16"]==0 and $r["colonne17"]==0)
		$RCorrect = true;
		else if($r["colonne1"]==2 and  $r["colonne14"]==3 and (ereg("[1-4]",$r["colonne15"])) and $r["colonne16"]==0 and $r["colonne17"]==0)
		$RCorrect = true;
		else if($r["colonne1"]==3 and  $r["colonne14"]==3 and (ereg("[1-4]",$r["colonne15"])) and $r["colonne16"]==0 and $r["colonne17"]==0)
		$RCorrect = true;
		else if($r["colonne1"]==5)
		$RCorrect = true;
		//la solution est Correcte avec des erreurs de calcul
		else if(($r["colonne1"]==1 || $r["colonne1"]==2 || $r["colonne1"]==3) and 
				($r["colonne4"]==1 || $r["colonne8"]==1 || $r["colonne12"]==1 || 
				 $r["colonne4"]==2 || $r["colonne8"]==2 || $r["colonne12"]==2))
		$RCorrectErreur = true;
		//la resoltion est inCorrecte
		else if($r["colonne1"]==1 and  $r["colonne14"]==0 and $r["colonne15"]==0 and $r["colonne16"]==9 and $r["colonne17"]==9)
		$RInCorrect = true;
		else if($r["colonne1"]==4 || $r["colonne1"]==6 || $r["colonne1"]==7)
		$RInCorrect = true;
		else if($r["colonne1"]==9)
		$PasResolu = true;
		else $RInCorrect = true;
		//Nombre d'operations utilisées par l'apprenant
		$nbOper=count($tabOperation);//$r["nbOper"];
		
		//codage de la solution de l'élève
		if (isset($RCorrect) and $RCorrect==true)
			$sol=1;//solution coorect
		else if (isset($RCorrectErreur) and $RCorrectErreur==true)
			$sol=2;//solution correct avec des erreurs de calculs
		else if (isset($RInCorrect) and $RInCorrect==true)
			$sol=3;//solution incorrect
		else if (isset($PasResolu) and $PasResolu==true)
			$sol=4;//l'élève n'a pas résolu le problème
			
		//Rechercher les informations sur l'énoncé dans la BD
		if ($r["typeExo"]=="a")
			$type="comparaison";
		else
			$type="complement";
		$requete2 = "SELECT * FROM $type where numero=".$r["numExo"];
		$result2 = mysql_query($requete2) or die("Erreur de S&eacute;lection dans la base : ". $requete2 .'<br />'. mysql_error());
		while ($r2 = mysql_fetch_assoc($result2))
				{
				  $text1 = stripslashes($r2["enonce1"]);//str_replace("'","\'",$r2["enonce1"]);
				  $text2 = stripslashes($r2["question1"]);
				  $text3 = stripslashes($r2["enonce2"]);
				  $text4 = stripslashes($r2["question2"]);
				  if ($r["questInt"]=="1")
				  $enonce=$text1."\r\n".$text2."\r\n".$text3."\r\n".$text4;
				  else
				   $enonce=$text1."\r\n".$text3."\r\n".$text4;
				  $enonce = ereg_replace("\r\n", "<br/>",$enonce);
				  $partie1 = $r2["partie1"];$partie2 = $r2["partie2"];$partie3 = $r2["partie3"];
				  $tout1 = $r2["tout1"];$tout2 = $r2["tout2"];$valdiff = $r2["valdiff"];
				  $q = $r2["question"];
				}
		$_xml .="<enonce>".$enonce."</enonce>\r\n";
		$_xml .="<reponse>".$reponseEleve."</reponse>\r\n";

		//Rechercher le Nom et Prénom de l'apprenant
		$requete3 = "select nom, prenom from eleve where numEleve=".$r["numEleve"];
		$result3 = mysql_query($requete3) or die("Erreur de S&eacute;lection dans la base : ". $requete3 .'<br/>'. mysql_error());
		while ($r3 = mysql_fetch_assoc($result3))
				{
					$nom = $r3["nom"];
					$prenom = $r3["prenom"];									
				}
		$_xml .="<nom>".ucfirst($prenom)." ".strtoupper($nom)."</nom>\r\n";
		
		//l'apprenant a-t-il bien résolu le problème ?
		if (isset($RCorrect) and $RCorrect)  
			$_xml .="<resolution> a bien résolu le problème</resolution>\r\n";
		else if (isset($RCorrectErreur)and $RCorrectErreur)
			$_xml .="<resolution> a bien résolu le problème à l'exception d'erreurs de calcul</resolution>\r\n";
		else if (isset($RInCorrect) and $RInCorrect) 
			$_xml .="<resolution> n'a pas résolu le problème correctement</resolution>\r\n";
		else if (isset($PasResolu) and $PasResolu) 
			$_xml .="<resolution> n'a pas résolu le problème</resolution>\r\n";
		
		//balise qui affiche le nombre d'opérations utilisées
			$_xml .="<nbOper nbOper=\"".$nbOper."\">".$nbOper."</nbOper>\r\n";
		//debut de création du fichier diagXML.xml
		if ($r["numDiag"]) 
		{ 
			$_xml .="<colonne1 intitule=\"strategie\" q=\"".$q."\" nbOper=\"".$nbOper."\" code=\"".$r["colonne1"]."\" type=\"".$r["typeExo"]."\">\r\n"; 
				switch ($r["colonne1"])
				{
					case "1" : $_xml .= "Etape";
								break;
					case "2" : $_xml .= "Différence\r\n";
							   if($r["question"]=="p") {
							   			$_xml .="<partie1>".$partie1."</partie1>\r\n";
										$_xml .="<partie2>".$partie2."</partie2>\r\n";
										$_xml .="<tout1>".$tout1."</tout1>\r\n";
										$_xml .="<tout2>".$tout2."</tout2>\r\n";
										$_xml .="<valdiff>".$valdiff."</valdiff>\r\n";
									}
							   else if($r["question"]=="t") {
							   			$_xml .="<tout1>".$tout1."</tout1>\r\n";
										$_xml .="<tout2>".$tout2."</tout2>\r\n";
										$_xml .="<partie1>".$partie1."</partie1>\r\n";
										$_xml .="<partie2>".$partie2."</partie2>\r\n";
										$_xml .="<valdiff>".$valdiff."</valdiff>\r\n";										
									}
								break;
					case "3" : $_xml .= "Etape et difference\r\n";
							   

					case "4" : $_xml .= "Non pertinent";
								break;
					case "5" : $_xml .= "Non identifiable menant à une solution correcte";
								break;
					case "6" : $_xml .= "Non identifiable mais la solution est incorrecte";
								break;
					case "7" : $_xml .= "résultat de la difference comme résultat final Erreur";
								break;
					case "9" : $_xml .= "absence";
								break;
				}
				$_xml .="</colonne1>\r\n"; 
			if(!($r["colonne2"]=='9' and $r["colonne3"]=='9' and $r["colonne4"]=='9'))
			{
				$_xml .="<colonne2 intitule=\"calcule du résultat intermédiaire\" nbOper=\"".$nbOper."\" code=\"" . $r["colonne2"] . "\">\r\n"; 
				switch ($r["colonne2"])
				{ 
					case "0" : $_xml .= "implicite ";
								break;
					case "1" : $_xml .= "addition à trou ";
					          if($r["colonne3"]==0 and $r["colonne4"]==0) 
							  			$_xml .="<op>(".$partie1."+ ? =".$tout1.")</op>\r\n";//resultat correct
							  else if($r["colonne3"]==0 and $r["colonne4"]==1 or $r["colonne4"]==2) 
							  			$_xml .="<op>(".$partie1."+ ? =".$tout1.")</op>\r\n"; //erreur compt
							  break;
					case "2" : $_xml .= "soustraction ";
					          if($r["colonne3"]==0 and $r["colonne4"]==0) 
							  			$_xml .="<op>(".$tout1."-".$partie1.")</op>\r\n"; 
							  else if($r["colonne3"]==0 and ($r["colonne4"]==1 or $r["colonne4"]==2)) 
							  			$_xml .="<op>(".$tout1."-".$partie1.")</op>\r\n"; 

								break;
					case "3" : $_xml .= "soustraction inversée ";
					          if($r["colonne3"]==0 and $r["colonne4"]==0) 
							  			$_xml .="<op>(".$partie1."-".$tout1.")</op>\r\n";
							  else if($r["colonne3"]==0 and ($r["colonne4"]==1 or $r["colonne4"]==2)) 
							  			$_xml .="<op>(".$partie1."-".$tout1.")</op>\r\n";
								break;
					case "4" : $_xml .= "addition ";
					          if($r["colonne3"]==0 and $r["colonne4"]==0) 
							  			$_xml .="<op>(".$tout1."+".$partie1.")</op>\r\n"; 
								break;
					case "5" : $_xml .= "autre opération ";
								break;
					case "6" : $_xml .= "plusieurs opération ";
								break;
					case "7" : $_xml .= "soustraction à trou ";
					          if($r["colonne3"]==0 and $r["colonne4"]==0) 
							  			$_xml .="<op>(".$tout1."- ? =".$partie1.")</op>\r\n"; 
							  else if($r["colonne3"]==0 and $r["colonne4"]==1 or $r["colonne4"]==2) 
							  		$_xml .="<op>(".$tout1."- ? =".$partie1.")</op>\r\n"; 
								break;
					case "9" : $_xml .= "absence";
								break;
				}
				$_xml .="</colonne2>\r\n"; 
			  
			   	$_xml .="<colonne4 intitule=\"résultat de calcul\" code=\"" . $r["colonne4"] . "\">\r\n"; 
				switch ($r["colonne4"])
				{  
					case "0" :  if($r["colonne2"]<4 and $r["colonne3"]==0)
								{
									$_xml .= "correct ";
									$_xml .="<res>(".$partie2.")</res>\r\n";
								}
								else if($r["colonne2"]==4 and $r["colonne3"]==0)
								{
									$operation=$partie1+$tout1;
									$_xml .= "correct ";
									$_xml .="<res>(".$operation.")</res>\r\n";
								}
								else 
								{
									$_xml .= "correct ";
								}
								break;
					case "1" : $_xml .= "petite erreur";
								break;
					case "2" : $_xml .= "grosse erreur";
								break;
					case "9" : $_xml .= "résultat absent";
								break;
				}
				$_xml .="</colonne4>\r\n"; 
				
				$_xml .="<colonne3 intitule=\"pertinence des données de l'opération\" col2=\"".$r["colonne2"]."\" code=\"" . $r["colonne3"] . "\">\r\n"; 
				switch ($r["colonne3"])
				{ 
					case "0" : $_xml .= "correcte";
								break;
					case "1" : $_xml .= "incorectes (au moins une des données est incorrecte)";
								break;
					case "9" : $_xml .= "pas d'opération posée";
								break;
				}
				$_xml .="</colonne3>\r\n";
				 
			   	
		    }/****fin du if(!($r["colonne2"]='9' and $r["colonne3"]='9' and $r["colonne4"]='9'))****/
		
			if ($r["typeExo"]=="a") 
			{
				if (!($r["colonne6"]=='9' and $r["colonne7"]=='9' and $r["colonne8"]=='9'))
				{
			  $_xml .="<colonne6 intitule=\"calcul comparaison\" code=\"".$r["colonne6"]."\" nbOper=\"".$nbOper."\" str=\"".$r["colonne1"]."\">\r\n"; 
					switch ($r["colonne6"])
					{ 
					case "0" : $_xml .= "implicite";
									break;
					case "1" : $_xml .= "addition à trou ";
					          if(($r["colonne7"]==0) and ($r["question"]=="t")) 
							 	 $_xml .="<op>(".$valdiff."+ ? =".$partie1.")</op>\r\n"; 
							  else if(($r["colonne7"]==0) and ($r["question"]=="p")) 
							 	 $_xml .="<op>(".$valdiff."+ ? =".$tout1.")</op>\r\n"; 
							  break;
					case "2" : $_xml .= "soustraction ";
					         if(($r["colonne7"]==0) and ($r["question"]=="t")) 
							 	 $_xml .="<op>(".$partie1."-".$valdiff.")</op>\r\n"; 
							  else if(($r["colonne7"]==0) and ($r["question"]=="p")) 
							 	 $_xml .="<op>(".$tout1."-".$valdiff.")</op>\r\n"; 
								break;
					case "3" : $_xml .= "soustraction inversée ";
					           if(($r["colonne7"]==0) and ($r["question"]=="t")) 
							 	 $_xml .="<op>(".$valdiff."-".$partie1.")</op>\r\n"; 
							  else if(($r["colonne7"]==0) and ($r["question"]=="p")) 
							 	 $_xml .="<op>(".$valdiff."-".$tout1.")</op>\r\n"; 
								break;
					case "4" : $_xml .= "addition ";
					           if(($r["colonne7"]==0) and ($r["question"]=="t")) 
							 	 $_xml .="<op>(".$partie1."+".$valdiff.")</op>\r\n"; 
							  else if(($r["colonne7"]==0) and ($r["question"]=="p")) 
							 	 $_xml .="<op>(".$tout1."+".$valdiff.")</op>\r\n"; 
								break;
					case "5" : $_xml .= "autre opération";
								break;
					case "6" : $_xml .= "plusieurs opération";
								break;
					case "7" : $_xml .= "soustraction à trou ";
					          if($r["colonne7"]==0 and $r["question"]=="t") 
							 	 $_xml .="<op>(".$partie1."- ? =".$valdiff.")</op>\r\n"; 
							  else if($r["colonne7"]==0 and $r["question"]=="p") 
							 	 $_xml .="<op>(".$tout1."- ? =".$valdiff.")</op>\r\n"; 
								break;
					case "9" : $_xml .= "absence";
								break;
					}
				$_xml .="</colonne6>\r\n";
					 
					$_xml .="<colonne7 intitule=\"pertinence des données de l'opération\" code=\"" . $r["colonne7"] . "\">\r\n"; 
					switch ($r["colonne7"])
					{ 
						case "0" : $_xml .= "implicite";
									break;
						case "1" : $_xml .= "au moins une des données est incorrecte sans être le résultat d'une erreur de calcul";
									break;
						case "2" : $_xml .= "au moins une des données est incorrecte du fait d'une petite erreur de calcul";
									break;
						case "3" : $_xml .= "au moins une des données est incorrecte du fait d'une grosse erreur de calcul";
									break;
						case "9" : $_xml .= "pas d'opération posée";
									break;
					}
					$_xml .="</colonne7>\r\n"; 
					$_xml .="<colonne8 intitule=\"résultat de calcul\" code=\"" . $r["colonne8"] . "\">\r\n"; 
					switch ($r["colonne8"])
					{  
						case "0" : $_xml .= "correct ";
									if($r["question"]=="t") 
							 	          $_xml .="<res>(".$partie3.")</res>\r\n";
							  		else if($r["question"]=="p") 
										$_xml .="<res>(".$tout2.")</res>\r\n";
									break;
						case "1" : $_xml .= "petite erreur";
									break;
						case "2" : $_xml .= "grosse erreur";
									break;
						case "9" : $_xml .= "résultat absent";
									break;
					}
					$_xml .="</colonne8>\r\n"; 
				}//fin du if(!($r["colonne6"]='9' and $r["colonne7"]='9' and $r["colonne8"]='9')))
		    }//fin du if ($r["typeExo"]=="a") 
			else if ($r["typeExo"]=="e")
		    {
				if (!($r["colonne10"]=='9' and $r["colonne11"]=='9' and $r["colonne12"]=='9'))
				{
					$_xml .="<colonne10 intitule=\"calcule de la différence\" code=\"" . $r["colonne10"] . "\">\r\n"; 
					switch ($r["colonne10"])
					{ 
						case "0" : $_xml .= "implicite";
										break;
						case "1" : $_xml .= "addition à trou ";
								  if(($r["colonne11"]==0) and ($r["question"]=="t")) 
									 {
									   if($partie2 >= $partie1)				
									   		$_xml .="<op>(".$partie1."+ ? =".$partie2.")</op>\r\n"; 
									   else if($partie1 >= $partie2)
									   		$_xml .="<op>(".$partie2."+ ? =".$partie1.")</op>\r\n"; 
									 }
								 else if(($r["colonne11"]==0) and ($r["question"]=="p")) 
								   {
									   if ($tout2>=$tout1) 
											$_xml .="<op>(".$tout1."+ ? =".$tout2.")</op>\r\n";
									   else if ($tout1>=$tout2)
										 	$_xml .="<op>(".$tout2."+ ? =".$tout1.")</op>\r\n";
								    }
									break;
									
								  
						case "2" : $_xml .= "soustraction ";
								 if(($r["colonne11"]==0) and ($r["question"]=="t")) 
									 {
									   if($partie2 >= $partie1)				
									   $_xml .="<op>(".$partie2."-".$partie1.")</op>\r\n"; 
									   else if($partie1 >= $partie2)
									   $_xml .="<op>(".$partie1."-".$partie2.")</op>\r\n";
									 }
								 else if(($r["colonne11"]==0) and ($r["question"]=="p")) 
								   {
									   if ($tout2>=$tout1) 
										$_xml .="<op>(".$tout2."-".$tout1.")</op>\r\n";
									   else if ($tout1>=$tout2)
										 $_xml .="<op>(".$tout1."-".$tout2.")</op>\r\n";
								    }
									break;
						case "9" : $_xml .= "absence";
									break;
					}
					$_xml .="</colonne10>\r\n"; 
					$_xml .="<colonne11 intitule=\"pertinence des données de l'opération\" code=\"" . $r["colonne11"] . "\">\r\n"; 
					switch ($r["colonne11"])
					{ 
						case "0" : $_xml .= "implicite";
									break;
						case "1" : $_xml .= "au moins une des données est incorrecte";
									break;
						case "9" : $_xml .= "pas d'opération posée";
									break;
					}
					$_xml .="</colonne11>\r\n"; 
					
					$_xml .="<colonne12 intitule=\"résultat\" code=\"" . $r["colonne12"] . "\">\r\n"; 
					switch ($r["colonne11"])
					{ 
						case "0" : $_xml .= "correcte \r\n";
								   $_xml .="<res>(".$valdiff.")</res>\r\n";
								    break;
						case "1" : $_xml .= "petite erreur";
									break;
						case "2" : $_xml .= "grosse erreur";
									break;
						case "9" : $_xml .= "résultat absent";
									break;
					}
					$_xml .="</colonne12>\r\n"; 
				}//fin du if(!($r["colonne10"]='9' and $r["colonne11"]='9' and $r["colonne12"]='9'))			
		    }//fin du  if ($r["typeExo"]=="e") 
			
			$_xml .="<colonne14 intitule=\"nature de ce qui est calculé\" nbOper=\"".$nbOper."\" str=\"".$r["colonne1"]."\" code=\"".$r["colonne14"]."\" q=\"".$q."\" col1=\"".$r["colonne1"]."\" col15=\"".$r["colonne15"]."\" type=\"".$r["typeExo"]."\">\r\n"; 
				switch ($r["colonne14"])
				{ 
					case "0" : $_xml .= "implicite";
								break;
					case "1" : $_xml .= "une partie";
								break;
					case "2" : $_xml .= "un tout";
								break;
					case "3" : if($r["typeExo"]=="e" and $r["colonne11"]==0 and $r["colonne11"]==0)
								$_xml .= "Pour le calcul final, il a utilisé l'écart calculé précedement ($valdiff). ";
								else if($r["typeExo"]=="a")
								$_xml .= "";
								else
							    $_xml .= "un des terme de la comparaison à partir de l'autre terme de la différence";
								if ($r["colonne1"]=="3")
								{
									if($r["question"]=="p") {
											$_xml .="<partie1>".$partie1."</partie1>\r\n";
											$_xml .="<partie2>".$partie2."</partie2>\r\n";
											$_xml .="<tout1>".$tout1."</tout1>\r\n";
											$_xml .="<tout2>".$tout2."</tout2>\r\n";
											$_xml .="<valdiff>".$valdiff."</valdiff>\r\n";
										}
								   else if($r["question"]=="t") {
											$_xml .="<tout1>".$tout1."</tout1>\r\n";
											$_xml .="<tout2>".$tout2."</tout2>\r\n";
											$_xml .="<partie1>".$partie1."</partie1>\r\n";
											$_xml .="<partie2>".$partie2."</partie2>\r\n";
											$_xml .="<valdiff>".$valdiff."</valdiff>\r\n";										
										}
								}
								break;

					case "4" : $_xml .= "le résultat précédent et la dernière donnée de l'énoncé";
								break;
					case "41" : $_xml .= "addition des deux resultats précédent";
								break;
					case "42" : $_xml .= "soustratction des deux resultats précédent";
										break;
					case "5" : $_xml .= "autre";
								break;
					case "9" : $_xml .= "absence";
								break;
				}
			$_xml .="</colonne14>\r\n"; 

			$_xml .="<colonne15 intitule=\"calcule du résultat final\" code=\"" . $r["colonne15"] . "\">\r\n"; 
				switch ($r["colonne15"])
				{ 
					case "0" : $_xml .= "implicite";
								break;
					case "1" : $_xml .= "addition à trou ";
							   $_xml .="<op>(".$tabOper[0]." + ? =".$tabOper[2].")</op>\r\n";
							   $resFin=$tabOper[1];
								break;
					case "2" : $_xml .= "soustraction ";
								$_xml .="<op>(".chop($opFinSR).")</op>\r\n";
								break;
					case "3" : $_xml .= "soustraction inversée ";
								$_xml .="<op>(".chop($opFinSR).")</op>\r\n";
								break;
					case "4" : $_xml .= "addition ";
								$_xml .="<op>(".chop($opFinSR).")</op>\r\n";
								break;
					case "5" : $_xml .= "addition de tous les termes de l'énoncé ";
								$_xml .="<op>(".chop($opFinSR).")</op>\r\n";
								break;
					case "6" : $_xml .= "autre opération sur tous les termes de l'énoncé ";
								break;
					case "7" : $_xml .= "opération non pertinente sur 2 des termes de l'énoncé ";
								$_xml .="<op>(".chop($opFinSR).")</op>\r\n";
								break;
					case "8" : $_xml .= "autre ";
								$_xml .="<op>(".chop($opFinSR).")</op>\r\n";
								break;
					case "9" : $_xml .= "absence ";
								break;
				}
			$_xml .="</colonne15>\r\n"; 
			
			$_xml .="<colonne17 intitule=\"résultat du calcul final\" nbOper=\"".$nbOper."\" sol=\"".$sol."\" 
					   col14=\"".$r["colonne14"]."\" col15=\"".$r["colonne15"]."\" code=\"".$r["colonne17"]."\">\r\n"; 
				switch ($r["colonne17"])
				{  
					case "0" :  $_xml .= "correct ";
							    $_xml .= "<res>(".$resFin.")</res>";
								break;
					case "1" :  $_xml .= "petite erreur ";
							    $_xml .= "<res>(".$resFin.")</res>";
								break;
					case "2" : $_xml .= "grosse erreur ";
							    $_xml .= "<res>(".$resFin.")</res>";
								break;
					case "9" : $_xml .= "résultat absent";
								$_xml .= "<res>(".$resFin.")</res>";
								break;
				}
				$_xml .="</colonne17>\r\n";
				
				$_xml .="<colonne16 intitule=\"pertinence des données de l'opération\" code=\"".$r["colonne16"]."\" col14=\"".$r["colonne14"]."\" nbOper=\"".$nbOper."\" str=\"".$r["colonne1"]."\">\r\n"; 
				switch ($r["colonne16"])
				{ 
					case "0" : $_xml .= "correctes";
								break;
					case "1" : $_xml .= "Au moins une des données est incorrecte sans être le résultat d'une erreur de calcul";
								break;
					case "2" : $_xml .= "Au moins une des données est incorrecte du fait d'une petite erreur de calcul au cours du calcul précédent";
								break;
					case "3" : $_xml .= "Au moins une des données est incorrecte du fait d'une grosse erreur de calcul au cours du calcul précédent";
								break;
					case "4" : $_xml .= "Les données sont correctes pour la comparaison mais pas pour l'opération finale";
								break;
					case "9" : $_xml .= "pas d'opération posée";
								break;
				}
			$_xml .="</colonne16>\r\n";  
		$_xml .="</exercice>\r\n"; 
		
 		} //fin du if ($r["numDiag"]) 
	 
	  } 
	$_xml .="</diagnostic>"; 
	fwrite($file, utf8_encode($_xml)); 
	fclose($file); 
	echo "le fichier XML vient d'être cr&eacute;&eacute;.  <a href=\"diagnostics\\diagXMLphp.php\">visualiser</a><br/>"; 	
} 
else 
{ 
	echo "No Records found"; 
} 

?>
