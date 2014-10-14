<?php 
require_once("conn.php");
$requete1 = "select * from diagnostic where numEleve =".$_POST["numEleve"];
//$requete1 = "select * from diagnostic where colonne2=2 and colonne14=0";//".$_POST["numDiag"];
//$requete1 = "select * from diagnostic where numDiag = 80";//.$_POST["numDiag"];
//$requete1 = "select * from diagnostic where numDiag between 34 and 377";
//$requete1 = "select * from diagnostic where colonne1=2";

$result = mysql_query($requete1) or die("Impossible d'interroger la base de données");
$num = mysql_num_rows($result);
if ($num != 0) 
{ 
	$file= fopen("diagnostics\\diagXML.xml", "w"); 
	$_xml ="<?xml version=\"1.0\" encoding=\"utf-8\" ?>\r\n"; 
	$_xml .="<?xml-stylesheet href=\"diag.xsl\" type=\"text/xsl\"?>\r\n";
	$_xml .="<diagnostic>\r\n"; 
	while ($r = mysql_fetch_array($result)) 
	 { 
//		$reponseEleve='';$reponse='';
//		$tabOp[]='';$tabOper[]='';$tabOperation[]='';
//		$tabNombre[]='';
//		$tabSR []= '';$tabR []= '';
//		$tabTOper[]='';	$tabImp[] = '';
//		$tabImplicite[]='';$tabOper[]='';$tabFOperande[]='';
//		$RCorrect='';$RCorrectErreur='';$RInCorrect='';
		unset($reponse,$reponseEleve,$tabImplicite,$tabOperation,$tabNombre,$tabOp,$tabOper,$tabSR,$tabR,$tabOper,$RCorrect,$RCorrectErreur,$RInCorrect);
		unset($pat_nb_lettre,$pat_nb_err1,$pat_nb_err2,$valNb,$tab_nb,$tab_nb_lettre,$tab_nb_err1,$tab_nb_err2,$tab_nb_err3,$tab_nb_ext,$tab_nb_ext1,$tab_nb_ext2);

		$_xml .="<exercice numTrace='".$r["numTrace"]."'>\r\n"; 
		$req = "select zoneText as reponse from trace where id=".$r["numTrace"];
		$res = mysql_query($req) or die("Impossible d'interroger la base de données");
		while ($rc = mysql_fetch_array($res)) 
	  	{
		 $reponseEleve = $rc["reponse"];
		 $reponseEleve = ereg_replace("\r\n|\n", "<br/>",$reponseEleve);
		 $reponse = $rc["reponse"];
		 $reponse = ereg_replace ('([a-zA-Z]) *- *([a-zA-Z])','\1 \2',$reponse);
		//suprime tous caractere different de [^\d+-=:*]
		$reponse = trim(eregi_replace ('[^0-9|,|(|)|+|*|=|-]', " ",$reponse));//supprimer la division
		
		//tabNombre contient  tous les nombres que contient la réponse de l'apprenant
		$tabNombre = preg_split ("/[\s]+/", $reponse);
		$tabNombre = array_values (preg_grep("/\d/", $tabNombre));
		
		
//======================================
		//trouver les nombres écrit en lettre
		if(count($tabNombre)==0)
		{
			$Requete_SQL0 = "SELECT * FROM nombre";
			$result0 = mysql_query($Requete_SQL0) or die("Erreur de S&eacute;lection dans la base : ". $Requete_SQL0 .'<br />'. mysql_error());
			while($valNb=mysql_fetch_array($result0))
			{
				$tab_nb[]=$valNb["nombre"];		
				$tab_nb_lettre[]=$valNb["nombre_lettre"];
				if($valNb["erreur1"]!='')
					$tab_nb_err1[]=$valNb["erreur1"];
				if($valNb["erreur2"]!='')
					$tab_nb_err2[]=$valNb["erreur2"];
				$tab_nb_err3[]=$valNb["erreur3"];
			}
			
			//cas 1 : nombre ecrit correctement
				$pat_nb_lettre = implode (' ?| ?',$tab_nb_lettre);
				$pattern1 = "/".$pat_nb_lettre."/"; 
				preg_match_all($pattern1,$rc["reponse"],$tab_nb_ext);
				//print_r($tab_nb_ext[0]);
				$tab_nb_ext=$tab_nb_ext[0];
			//cas 2 : nombre ecrit avec des erreurs erreur1
				$pat_nb_err1= implode (' ?| ?',$tab_nb_err1);
				$pattern2 = "/".$pat_nb_err1."/"; 
				preg_match_all($pattern2,$rc["reponse"],$tab_nb_ext1);
				//print_r($tab_nb_ext1[0]);
				$tab_nb_ext1=$tab_nb_ext1[0];
			//cas 3 : nombre ecrit avec des erreurs erreur3
				$pat_nb_err2= implode (' ?| ?',$tab_nb_err2);
				$pattern3 = "/".$pat_nb_err2."/"; 
				//print_r($tab_nb_ext2[0]);
				preg_match_all($pattern3,$rc["reponse"],$tab_nb_ext2);
				//print_r($tab_nb_ext2[0]);
				$tab_nb_ext2=$tab_nb_ext2[0];
				
				
			if(count($tab_nb_ext)>0)
				{
					for($i=0;$i<count($tab_nb_ext);$i++)
					{
						for($j=0;$j<=100;$j++)	
						{
							if(trim($tab_nb_lettre[$j])==trim($tab_nb_ext[$i]))
							{
								$tabNombre[]=$j;
								//echo($tab_nb_lettre[$j]."==".$tab_nb_ext[$i]);
								break;
							}
							
						}		
					}
				}
			if(count($tab_nb_ext1)>0)
				{
					for($i=0;$i<count($tab_nb_ext1);$i++)
					{
						for($j=0;$j<=100;$j++)	
						{
							if(trim($tab_nb_err1[$j])==trim($tab_nb_ext1[$i]))
							{
								$tabNombre[]=$j;
								//echo($tab_nb_err1[$j]."==".$tab_nb_ext1[$i]);
								break;
							}
							
						}		
					}
				}
			if(count($tab_nb_ext2)>0)
				{
					for($i=0;$i<count($tab_nb_ext2);$i++)
					{
						for($j=0;$j<=100;$j++)	
						{
							if(trim($tab_nb_err2[$j])==trim($tab_nb_ext2[$i]))
							{
								$tabNombre[]=$j;
								//echo($tab_nb_err2[$j]."==".$tab_nb_ext2[$i]);
								break;
							}
							
						}		
					}
				}
			if(isset($tabNombre)) $tabNombre=array_unique($tabNombre);

			if(count($tab_nb_ext)==0 and count($tab_nb_ext1)==0 and count($tab_nb_ext2)==0)
			{
				for($i=1;$i<=18;$i++)
				{
					${'colonne'.$i}=9;
				}
				//unset($tabNombre);
			}
		}
		//fin de la recherche des nombre ecris en lettre
		//==============================================
		

		//$pattern = "/((?:\d+\s*[\+\-\*\/x:]\s*)*(?:\(\s*(?:\d+\s*[\+\-\*\/x:]\s*)+\d+\s*\)\s*[\+\-\*\/x:]?\s*)*\d*\s*=?\s*\d+)/";
		//ER qui reconnait les operation de type a+....+a = a ou sans le signe egale 
		$pattern = "/(((?:\d+\s*[\+\-\*\/x]\s*)+\d+\s*)=?\s*(\d*))/"; //(?:) parenthèse non capturante (supprimer la division :)
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
				
	    //tableau des opérandes : uniquement l'opération finale
		preg_match_all($pat1,end($tabOperation),$tabFOperande);
		$tabOper = $tabFOperande[0];

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
		if(isset($tabImp) and isset($tabR))
			$tabImplicite=array_diff($tabImp,$tabR);
		
		//affectation du resultat implicicte à la variable resultat final resFin
		if(isset($tabImplicite) and count($tabImplicite)>=1 and end($tabImplicite)!="" and $r["colonne14"]==0)
			$resFin=end($tabImplicite);
		if($r["colonne14"]==0 and $r["colonne15"]==0 and $r["colonne16"]==9 and $r["colonne17"]==0)
			$resFin=end($tabNombre);
		 //echo($resFin."<br>");
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
		 //print_r($tabTOper);echo("tableau des opérandes<br>");
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
		else if(($r["colonne1"]==1 || $r["colonne1"]==2 || $r["colonne1"]==3) and ($r["colonne16"]==0) and
				($r["colonne4"]==1 || $r["colonne8"]==1 || $r["colonne12"]==1 || $r["colonne17"]==1 || 
				 $r["colonne4"]==2 || $r["colonne8"]==2 || $r["colonne12"]==2) || $r["colonne17"]==2)
				 
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
		$_xml .="<reponse>".stripslashes($reponseEleve)."</reponse>\r\n";

		//Rechercher le Nom et Prénom de l'apprenant
		$requete3 = "select nom, prenom, sexe from eleve where numEleve=".$r["numEleve"];
		$result3 = mysql_query($requete3) or die("Erreur de S&eacute;lection dans la base : ". $requete3 .'<br/>'. mysql_error());
		while ($r3 = mysql_fetch_assoc($result3))
				{
					$nom = substr($r3["nom"],0,1);//$r3["nom"];
					 
					$prenom = $r3["prenom"];
					$sexe= $r3["sexe"];									
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
		//balise qui affiche le prénom de l'élève
		$_xml .="<prenom col1=\"".$r["colonne1"]."\">".ucfirst($prenom)."</prenom>\r\n";
		
		//balise qui affiche le nombre d'opérations utilisées
		if($r["colonne2"]==0 or $r["colonne6"]==0 or $r["colonne10"]==0 or $r["colonne14"]==0)
			$calImp=1;
		/* else if(isset($tabImplicite) and count($tabImplicite)>=1 and end($tabImplicite)!="")
			$calImp=1; */
		else $calImp=0;
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
					
		$_xml .="<nbOper nbOper=\"".$nbOper."\" calImp=\"".$calImp."\" sexe=\"".$sexe."\" col1=\"".$r["colonne1"]."\">".$nbOperLettre."</nbOper>\r\n";
		//print_r($tabImplicite);echo("<br>");
		//debut de création du fichier diagXML.xml
		if ($r["numDiag"]) 
		{ 
			//S$_xml .="<sexe val=\"".$sexe."\">\r\n"; 
			$_xml .="<colonne1 sexe=\"".$sexe."\" intitule=\"strategie\" q=\"".$q."\" nbOper=\"".$nbOper."\" code=\"".$r["colonne1"]."\" col2=\"".$r["colonne2"]."\" col16=\"".$r["colonne16"]."\" type=\"".$r["typeExo"]."\">\r\n"; 
				switch ($r["colonne1"])
				{
					case "1" : $_xml .= "Etape";
								break;
					case "2" : $_xml .= "Différence\r\n";
							   if($q=="p") {
							   			$_xml .="<partie1>".$partie1."</partie1>\r\n";
										$_xml .="<partie3>".$partie3."</partie3>\r\n";
										$_xml .="<tout1>".$tout1."</tout1>\r\n";
										$_xml .="<tout2>".$tout2."</tout2>\r\n";
										$_xml .="<valdiff>".$valdiff."</valdiff>\r\n";
									}
							   else if($q=="t") {
							   			$_xml .="<tout1>".$tout1."</tout1>\r\n";
										$_xml .="<tout2>".$tout2."</tout2>\r\n";
										$_xml .="<partie1>".$partie1."</partie1>\r\n";
										$_xml .="<partie3>".$partie3."</partie3>\r\n";
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
				$_xml .="<colonne2 sexe=\"".$sexe."\" intitule=\"calcule du résultat intermédiaire\" col1=\"".$r["colonne1"]."\" nbOper=\"".$nbOper."\" code=\"" . $r["colonne2"] . "\">\r\n"; 
				switch ($r["colonne2"])
				{ 
					case "0" : $_xml .= "implicite ";
							   //$_xml .="<res>(".$partie2.")</res>\r\n";
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
							  else if($r["colonne3"]==1 and ($nbOper==1)) 
							  			$_xml .="<op>(".$tabSR[0].")</op>\r\n";

								break;
					case "3" : $_xml .= "soustraction inversée ";
					          if($r["colonne3"]==0 and $r["colonne4"]==0) 
							  			$_xml .="<op>(".$partie1."-".$tout1.")</op>\r\n";
							  else if($r["colonne3"]==0 and ($r["colonne4"]==1 or $r["colonne4"]==2)) 
							  			$_xml .="<op>(".$partie1."-".$tout1.")</op>\r\n";
								break;
					case "4" : $_xml .= "addition ";
					          if($r["colonne3"]==0) 
							  			$_xml .="<op>(".$tout1."+".$partie1.")</op>\r\n"; 
							  else if($r["colonne3"]==1 and $r["colonne4"]==0 and $nbOper>=2) 
							  			$_xml .="<op>(".$tabSR[0].")</op>\r\n"; 
							  break;
					case "5" : $_xml .= "autre opération ";
									$_xml .="<op>(".$tabOperation[0].")</op>\r\n"; 
								break;
					case "6" : $_xml .= "plusieurs opération ";
								break;
					case "61" : $_xml .= "opération non pertinente sur toutes les données de l'énoncé ";
									$_xml .="<op>(".$tabSR[0].")</op>\r\n";
								break;
					case "62" : $_xml .= "opération non pertinente ";
									$_xml .="<op>(".$tabSR[0].")</op>\r\n";
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
			  
			   	$_xml .="<colonne4 sexe=\"".$sexe."\" intitule=\"résultat de calcul\" code=\"" . $r["colonne4"] . "\">\r\n"; 
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
								else if($r["colonne2"]==4 and $r["colonne3"]==1)
								{
									$_xml .= "correct ";
									$_xml .="<res>(".$tabR[0].")</res>\r\n";
								}
								else if($r["colonne2"]==0 and $r["colonne3"]==9)
								{
									$_xml .="<res>(".$partie2.")</res>\r\n";
								}
								else if($r["colonne2"]==61 or $r["colonne3"]==62)
								{
									$_xml .="<res>(".$tabR[0].")</res>\r\n";
								}
								else if($r["colonne2"]<4 and $r["colonne3"]==1)
								{
									$_xml .="<res>(".$tabR[0].")</res>\r\n";
								}
								else
								{
									$_xml .= "correct ";
								}
								break;
					case "1" : $_xml .= "erreur ";//petite erreur  de calcul
								if($r["colonne2"]!=0)
								$_xml .="<res>(".$tabR[0].")</res>\r\n";
								break;
					case "2" : $_xml .= "erreur ";//grosse erreur de calcul
								if($r["colonne2"]!=0)
								$_xml .="<res>(".$tabR[0].")</res>\r\n";
								break;
					case "9" : $_xml .= "résultat absent";
								break;
				}
				$_xml .="</colonne4>\r\n"; 
				
				$_xml .="<colonne3 sexe=\"".$sexe."\" intitule=\"pertinence des données de l'opération\" col1=\"".$r["colonne1"]."\" col2=\"".$r["colonne2"]."\" code=\"" . $r["colonne3"] . "\">\r\n"; 
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
			  $_xml .="<colonne6 sexe=\"".$sexe."\" intitule=\"calcul comparaison\" col2=\"".$r["colonne2"]."\" code=\"".$r["colonne6"]."\" col7=\"".$r["colonne7"]."\" nbOper=\"".$nbOper."\" col14=\"".$r["colonne14"]."\" str=\"".$r["colonne1"]."\">\r\n"; 
					switch ($r["colonne6"])
					{ 
					case "0" : $_xml .= "implicite";
									break;
					case "1" : $_xml .= "addition à trou ";
					          if(($r["colonne7"]==0) and ($q=="t")) 
							 	 $_xml .="<op>(".$valdiff."+ ? =".$partie1.")</op>\r\n"; 
							  else if(($r["colonne7"]==0) and ($q=="p")) 
							 	 $_xml .="<op>(".$valdiff."+ ? =".$tout1.")</op>\r\n"; 
							  break;
					case "2" : $_xml .= "soustraction ";
					         if(($r["colonne7"]==0) and ($q=="t")) 
							 	 $_xml .="<op>(".$partie1."-".$valdiff.")</op>\r\n"; 
							  else if(($r["colonne7"]==0) and ($q=="p")) 
							 	 $_xml .="<op>(".$tout1."-".$valdiff.")</op>\r\n"; 
							  else if(($r["colonne7"]==1) and ($r["colonne8"]=="0")) 
							 	 $_xml .="<op>(".$tabSR[1].")</op>\r\n"; 	 
								break;
					case "21" : $_xml .= "soustraction avec une erreur de signe ";
					         if(($r["colonne7"]==0) and ($q=="t")) 
							 	 $_xml .="<op>(".$partie1."+".$valdiff.")</op>\r\n"; 
							  else if(($r["colonne7"]==0) and ($q=="p")) 
							 	 $_xml .="<op>(".$tout1."+".$valdiff.")</op>\r\n"; 
							  else if(($r["colonne7"]==1) and ($r["colonne8"]=="0")) 
							 	 $_xml .="<op>(".$tabSR[1].")</op>\r\n"; 	 
								break;
					case "3" : $_xml .= "soustraction inversée ";
					           if(($r["colonne7"]==0) and ($q=="t")) 
							 	 $_xml .="<op>(".$valdiff."-".$partie1.")</op>\r\n"; 
							  else if(($r["colonne7"]==0) and ($q=="p")) 
							 	 $_xml .="<op>(".$valdiff."-".$tout1.")</op>\r\n"; 
								break;
					case "4" : $_xml .= "addition ";
					           if(($r["colonne7"]==0) and ($q=="t")) 
							 	 $_xml .="<op>(".$partie1."+".$valdiff.")</op>\r\n"; 
							  else if(($r["colonne7"]==0) and ($q=="p")) 
							 	 $_xml .="<op>(".$tout1."+".$valdiff.")</op>\r\n"; 
								break;
					case "5" : $_xml .= "autre opération";
								break;
					case "6" : $_xml .= "plusieurs opération";
								break;
					case "7" : $_xml .= "soustraction à trou ";
					          if($r["colonne7"]==0 and $q=="t") 
							 	 $_xml .="<op>(".$partie1."- ? =".$valdiff.")</op>\r\n"; 
							  else if($r["colonne7"]==0 and $q=="p") 
							 	 $_xml .="<op>(".$tout1."- ? =".$valdiff.")</op>\r\n"; 
								break;
					case "9" : $_xml .= "absence";
								break;
					}
				$_xml .="</colonne6>\r\n";
					 
					$_xml .="<colonne7 sexe=\"".$sexe."\" intitule=\"pertinence des données de l'opération\" code=\"" . $r["colonne7"] . "\">\r\n"; 
					switch ($r["colonne7"])
					{ 
						case "0" : $_xml .= "implicite";
									break;
						case "1" : $_xml .= "au moins une des données est incorrecte sans être le résultat d'une erreur de calcul";
									break;
						case "2" : $_xml .= "au moins une des données est incorrecte du fait d'une erreur de calcul";//petite
									break;
						case "3" : $_xml .= "au moins une des données est incorrecte du fait d'une erreur de calcul";//grosse
									break;
						case "9" : $_xml .= "pas d'opération posée";
									break;
					}
					$_xml .="</colonne7>\r\n"; 
					$_xml .="<colonne8 sexe=\"".$sexe."\" intitule=\"résultat de calcul\" col14=\"".$r["colonne14"]."\" 
					col2=\"".$r["colonne2"]."\" col6=\"".$r["colonne6"]."\" code=\"" . $r["colonne8"] . "\">\r\n"; 
					switch ($r["colonne8"])
					{  
						case "0" : $_xml .= "correct ";
									if($q=="t" and ($r["colonne7"]==0 || $r["colonne7"]==9) and ereg("[0-3]|7",$r["colonne6"])) 
							 	         $_xml .="<res>(".$partie3.")</res>\r\n";
							  		else if($q=="p" and ($r["colonne7"]==0 || $r["colonne7"]==9)  and ereg("[0-3]|7",$r["colonne6"]))  
										$_xml .="<res>(".$tout2.")</res>\r\n";
									else if(($r["colonne7"]==1) and ($r["colonne6"]=="2")) 
							 	 		 $_xml .="<res>(".$tabR[1].")</res>\r\n";	
									break;
						case "1" : $_xml .= "erreur";//petite erreur  de calcul
								break;
						case "2" : $_xml .= "erreur";//grosse erreur de calcul
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
					$_xml .="<colonne10 sexe=\"".$sexe."\" intitule=\"calcule de la différence\" code=\"" . $r["colonne10"] . "\">\r\n"; 
					switch ($r["colonne10"])
					{ 
						case "0" : $_xml .= "implicite";
										break;
						case "1" : $_xml .= "addition à trou ";
								  if(($r["colonne11"]==0) and ($q=="t")) 
									 {
									   if($partie2 >= $partie1)				
									   		$_xml .="<op>(".$partie1."+ ? =".$partie2.")</op>\r\n"; 
									   else if($partie1 >= $partie2)
									   		$_xml .="<op>(".$partie2."+ ? =".$partie1.")</op>\r\n"; 
									 }
								 else if(($r["colonne11"]==0) and ($q=="p")) 
								   {
									   if ($tout2>=$tout1) 
											$_xml .="<op>(".$tout1."+ ? =".$tout2.")</op>\r\n";
									   else if ($tout1>=$tout2)
										 	$_xml .="<op>(".$tout2."+ ? =".$tout1.")</op>\r\n";
								    }
									break;
									
								  
						case "2" : $_xml .= "soustraction ";
								 if(($r["colonne11"]==0) and ($q=="t")) 
									 {
									   if($partie2 >= $partie1)				
									   $_xml .="<op>(".$partie2."-".$partie1.")</op>\r\n"; 
									   else if($partie1 >= $partie2)
									   $_xml .="<op>(".$partie1."-".$partie2.")</op>\r\n";
									 }
								 else if(($r["colonne11"]==0) and ($q=="p")) 
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
					$_xml .="<colonne11 sexe=\"".$sexe."\" intitule=\"pertinence des données de l'opération\" code=\"" . $r["colonne11"] . "\">\r\n"; 
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
					
					$_xml .="<colonne12 sexe=\"".$sexe."\" intitule=\"résultat\" code=\"" . $r["colonne12"] . "\">\r\n"; 
					switch ($r["colonne12"])
					{ 
						case "0" : $_xml .= "correcte ";
								   $_xml .="<res>(".$valdiff.")</res>\r\n";
								    break;
						case "1" : $_xml .= "erreur";
									break;
						case "2" : $_xml .= "erreur";
									break;
						case "9" : $_xml .= "résultat absent";
									break;
					}
					$_xml .="</colonne12>\r\n"; 
				}//fin du if(!($r["colonne10"]='9' and $r["colonne11"]='9' and $r["colonne12"]='9'))			
		    }//fin du  if ($r["typeExo"]=="e") 
			$_xml .="<colonne14 sexe=\"".$sexe."\" intitule=\"nature de ce qui est calculé\" nbOper=\"".$nbOper."\" str=\"".$r["colonne1"]."\" code=\"".$r["colonne14"]."\" q=\"".$q."\" col1=\"".$r["colonne1"]."\" col2=\"".$r["colonne2"]."\" col6=\"".$r["colonne6"]."\" col15=\"".$r["colonne15"]."\" col16=\"".$r["colonne16"]."\" type=\"".$r["typeExo"]."\">\r\n"; 
				switch ($r["colonne14"])
				{ 
					case "0" : $_xml .= "implicite";
								if($q=="p" and $r["colonne17"]==0)
									$_xml .="<res>".$partie3."</res>\r\n";
								else if($q=="t" and $r["colonne17"]==0)
									$_xml .="<res>".$tout2."</res>\r\n";
								else if($r["colonne14"]==0 and ($r["colonne17"]==9 || $r["colonne17"]==8))
									$_xml .="<res>".end($tabNombre)."</res>\r\n";
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
									if($q=="p") {
											$_xml .="<partie1>".$partie1."</partie1>\r\n";
											$_xml .="<partie2>".$partie2."</partie2>\r\n";
											$_xml .="<tout1>".$tout1."</tout1>\r\n";
											$_xml .="<tout2>".$tout2."</tout2>\r\n";
											$_xml .="<valdiff>".$valdiff."</valdiff>\r\n";
										}
								   else if($q=="t") {
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
					case "42" : $_xml .= "soustraction des deux resultats précédent";
										break;
					case "43" : $_xml .= "soustraction de  deux données de l'énoncé";
										break;
					case "5" : $_xml .= "autre";
								break;
					case "9" : $_xml .= "absence";
								break;
				}
			$_xml .="</colonne14>\r\n"; 

			$_xml .="<colonne15 sexe=\"".$sexe."\" intitule=\"calcule du résultat final\" col14=\"".$r["colonne14"]."\" code=\"" . $r["colonne15"] . "\">\r\n"; 
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
					case "52" : $_xml .= "soustraction de tous les termes de l'énoncé ";
								$_xml .="<op>(".chop($opFinSR).")</op>\r\n";
								break;
					case "6" : $_xml .= "autre opération sur tous les termes de l'énoncé";
								$_xml .="<op>(".chop($opFinSR).")</op>\r\n";
								break;
					case "7" : $_xml .= "opération non pertinente sur 2 des termes de l'énoncé";
								$_xml .="<op>(".chop($opFinSR).")</op>\r\n";
								break;
					case "71" : $_xml .= "soustraction à trou";
								$_xml .="<op>(".$tabOper[0]." - ? =".$tabOper[2].")</op>\r\n";
							   $resFin=$tabOper[1];
								break;
					case "72" : $_xml .= "soustraction inverser ";
								$_xml .="<op>(".$opFinSR.")</op>\r\n";
								break;
					case "8" : $_xml .= "autre ";
								$_xml .="<op>(".chop($opFinSR).")</op>\r\n";
								break;
					case "9" : $_xml .= "absence ";
								break;
				}
			$_xml .="</colonne15>\r\n"; 
			
			$_xml .="<colonne17 sexe=\"".$sexe."\" intitule=\"résultat du calcul final\" nbOper=\"".$nbOper."\" sol=\"".$sol."\" 
					   str=\"".$r["colonne1"]."\" col14=\"".$r["colonne14"]."\" col15=\"".$r["colonne15"]."\" code=\"".$r["colonne17"]."\">\r\n"; 
				switch ($r["colonne17"])
				{  
					case "0" :  $_xml .= "correct";
							    $_xml .= "<res>(".$resFin.")</res>";
								break;
					case "1" :  $_xml .= "erreur";
							    $_xml .= "<res>(".$resFin.")</res>";
								break;
					case "2" : $_xml .= "erreur";
							    $_xml .= "<res>(".$resFin.")</res>";
					case "8" : $_xml .= "erreur";
							    $_xml .= "<res>(".$resFin.")</res>";
								break;
					case "9" : $_xml .= "résultat absent";
								$_xml .= "<res>(".$resFin.")</res>";
								break;
				}
				$_xml .="</colonne17>\r\n";
				
				$_xml .="<colonne16 sexe=\"".$sexe."\" intitule=\"pertinence des données de l'opération\" code=\"".$r["colonne16"]."\" col14=\"".$r["colonne14"]."\" nbOper=\"".$nbOper."\" str=\"".$r["colonne1"]."\">\r\n"; 
				switch ($r["colonne16"])
				{ 
					case "0" : $_xml .= "correctes";
								break;
					//case "1" : $_xml .= "Au moins une des données est incorrecte sans être le résultat d'une erreur de calcul";
					case "1" : $_xml .= "L'échec à cette dernière opération repose sur un choix incorrect des valeurs";
								break;
					case "2" : $_xml .= "Au moins une des données est incorrecte du fait d'une erreur de calcul au cours du calcul précédent";
								break;
					case "3" : $_xml .= "Au moins une des données est incorrecte du fait d'une erreur de calcul au cours du calcul précédent";
								break;
					case "4" : if($nbOper==1 and $r["typeExo"]=="a")
								$_xml .= "Le choix des données est correct pour une autre comparaison mais pas pour répondre à la question";
								else 
								$_xml .= "Le choix des données est correct pour la comparaison mais pas pour répondre à la question";

								break;
					case "5" : $_xml .= "Lerreur au calcul final est due à lerreur commise au calcul précédent";
								break;
					case "8" : $_xml .= "erreur";
								break;
					case "9" : $_xml .= "pas d'opération posée";
								break;
				}
			$_xml .="</colonne16>\r\n"; 
		
		$_xml .="<commentaire sol=\"".$sol."\" sexe=\"".$sexe."\" type=\"".$r["typeExo"]."\" q=\"".$q."\" qi=\"".$r["questInt"]."\" 
		col2=\"".$r["colonne2"]."\" col3=\"".$r["colonne3"]."\" col4=\"".$r["colonne4"]."\"
		col6=\"".$r["colonne6"]."\" col7=\"".$r["colonne7"]."\" col8=\"".$r["colonne8"]."\"
		col10=\"".$r["colonne10"]."\" col11=\"".$r["colonne11"]."\" col12=\"".$r["colonne12"]."\"
		col14=\"".$r["colonne14"]."\" col15=\"".$r["colonne15"]."\" col16=\"".$r["colonne16"]."\" col17=\"".$r["colonne17"]."\" nbOper=\"".$nbOper."\" str=\"".$r["colonne1"]."\">\r\n"; 
		
		if($r["colonne6"]==20)
		{
			if ($q=="p")
			{
				$cal_diff=$partie1."-".$valdiff;
			}
			else if ($q=="t")
			{
				$cal_diff=$tout1."-".$valdiff;
			}
			
			$key=array_search($tabSR,$cal_diff);
			if(isset($key)) 
			{
			$cal_diff=$cal_diff."=".$tabR[$key];
			$_xml .= "<op>(".$cal_diff.")</op>";
			}
		}
		$_xml .="</commentaire>\r\n"; 

		//$_xml .="</sexe>\r\n";
		$_xml .="</exercice>\r\n"; 
		//détecter le calcul de la difference
 		} //fin du if ($r["numDiag"]) 
	 
	  } 
	$_xml .="</diagnostic>"; 
	fwrite($file, utf8_encode($_xml)); 
	fclose($file); 
	//echo "le fichier XML vient d'être créer.  <a href=\"diagnostics\\diagXMLphp.php\">visualiser</a><br/>"; 	
		echo "le fichier vient d'être créer.  <a href=\"diagnostics\\diagXML.xml\">visualiser</a><br/>"; 	

} 
else 
{ 
	echo "Pas d'enregistrement. <a href=\"javascript:history.go(-1)\">Retour</a> "; 
} 
?>
