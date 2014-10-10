<?php
 session_start();/*
 $nbExo=$_POST['nbExo']; $nbExo--;
if (empty($nbExo)) 
{ 
echo "<script>alert(\"la variable est nulle\")</script>"; 
} 
 $numExo=$_POST["numExo"]; $numExo++;
*/
   $nbExo=$_POST['nbExo']; 
   $nbExo--;
 
 $numExo=$_POST["numExo"];
 $numExo++;
 //fin rectificatif


 $questi=$_SESSION['questi'];
 $n=(int) $_SESSION['num'];
 $t=$_SESSION['type'];
 $text=$_POST["zonetexte"];
 $sas = addslashes($_POST['T1']);


 $op1=$_POST['operande1']; $op_1=$op1;
 $resultat=$_POST['resultat1'];
 
 $numSerie=$_SESSION["numSerie"];
 $aujourdhui=getdate(); $mois=$aujourdhui['mon']; $jour=$aujourdhui['mday']; $annee=$aujourdhui['year'];
 $heur=$aujourdhui['hours']; $minute=$aujourdhui['minutes']; $seconde=$aujourdhui['seconds'];
 $date=$annee.":".$mois.":".$jour." ".$heur.":".$minute.":".$seconde;
$tabNombre=array();
$tabReponse=array();

		 //suprime tous caractere different de [^\d+-=:*]
		 $reponse = $_POST["zonetexte"];
		 $reponse = ereg_replace ('([a-zA-Z]) *- *([a-zA-Z])','\1 \2',$reponse);
		
		//suprime tous caractere different de [^\d+-=:*]
		$reponse = trim(eregi_replace ('[^0-9|(|)|+|*|:|=|-]', " ",$reponse));
		
		//tabNombre contient  tous les nombres que contient la réponse de l'apprenant
		$tabNombre = preg_split ("/[\s]+/", $reponse);
		$tabNombre = array_values (preg_grep("/\d/", $tabNombre));
		$tabNombre1=$tabNombre;
		//ER qui reconnait les operation de type a+....+a = a ou sans le signe egale 
		$pattern = "/(((?:\d+\s*[\+\-\*\/x:]\s*)+\d+\s*)=?\s*(\d*))/"; //(?:) parenthèse non capturante 
		preg_match_all($pattern,$reponse,$tab);
		
		//tableau des opération utilisées dans la réponse de l'apprenant ==> tabOperation
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
		
		//tableau des opérateurs 
		$pat1 = "/\+|-|\*|\//";
		$tabTOperateur= array();
		for($i=0;$i<count($tabOperation); $i++)
		{
			preg_match_all($pat1,$tabOperation[$i],$tabTOperateur);
			${"tabOperateur".$i}=$tabTOperateur[0];
			$tabTOperateur=array_merge($tabTOperateur,${"tabOperateur".$i});
		}
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
				{
					$tabReponse[] = $tabNombre[$i];
				}
		//comparer les résultats des opérations avec ceux du tableau tabImp
		$tabImp=array_diff($tabReponse,$tabR);

			
//print ("le tableau des operations :  ");print_r($tabOperation);print ("<br>");
//print ("le tableau d'operande :  ");print ("<br>");
//for($i=0;$i<count($tabOperation);$i++)
//{print_r(${"tabOper".$i});print ("<br>");}
//print ("le tableau des nombres :  ");print_r($tabNombre);print ("<br>");
//print ("le tableau contient les nombres qui sont implicites ou dans la reponse de l'élève:  ");print_r($tabReponse);print ("<br>");
//print ("le tableau implicite :  ");print_r($tabImp);print ("<br>");
if(count($tabOperation)==0 and count($tabNombre)>0)
{
			$cNombre="";
			$pat2="/[0-9]/";
			$tabTriNombre=$tabNombre;
			sort($tabTriNombre);
			//print_r($tabTriNombre);print ("<br>");
			
				$cNombre=implode($tabTriNombre);
			
			//echo $cNombre;
			//trim(eregi_replace ('[^0-9]', " ",$tabNombre));
		

}
//exit();
//====================================================
 require_once("conn.php");
 $Requete_SQL1="SELECT * FROM $t where numero = $n";
 $result=mysql_query($Requete_SQL1) or die("Erreur de S&eacute;lection dans la base : ". $Requete_SQL1 .'<br />'. mysql_error());
 while ($val=mysql_fetch_array($result))
	{
    	$enonce=$val["enonce"];
		$nombre = trim(eregi_replace ('[^0-9]', " ",$enonce));
		$donnees =  array_values(preg_split ("/[\s]+/", $nombre));
		//echo("le tableau de données :"); print_r($donnees);
		$partie1=$val["partie1"];
    	$partie2=$val["partie2"];
		$tout=$val["tout"];
		$inconnu=$val["inconnu"];
		$typePb=$val["typePb"];
		$var=$val["variable"];
		//varInc : définit la variable inconnu de l'énoncé à calculer 
		if(in_array($partie1,$donnees) and in_array($partie2,$donnees))
			$varInc="tout";
		else if(in_array($partie1,$donnees) and in_array($tout,$donnees))
			$varInc="partie2";
		else if(in_array($partie2,$donnees) and in_array($tout,$donnees))
			$varInc="partie1";
 	}

function calcul($a1,$a2,$a3)
{
	switch ($a2)
	{
		case "+" : $cal=$a1+$a3;
					break;
		case "-" : $cal=$a1-$a3 ;
					break;
		case "*" : $cal=$a1*$a3 ;
					break;
		case ":" : $cal=$a1/$a3 ;
					break;
	}
	return $cal;
}
function calcul2($tab1,$tab2)
	{
		$cal=$tab2[0];
		for($i=0;$i<=count($tab1);$i++)
			switch ($tab1[$i])
			{
				case "+" : $cal = $cal+$tab2[$i+1];
							break;
				case "-" : $cal = $cal-$tab2[$i+1];
							break;
				case "*" : $cal = $cal*$tab2[$i+1];
							break;
				case ":" : $cal = $cal/$tab2[$i+1];
							break;
			}
		return $cal ;
	}


		//comparer les résultats des opérations avec ceux du tableau tabImp
		$tabImplicite=array_diff($tabImp,$tabR);
		//operation à réaliser d'après l'énoncé du pb (addition ou soustraction)
		$enonceAdd = array ('EFA','EIP','tout');
		$enonceSous = array ('EFP','EIA','TrP','TrA','partie','diff');

//début de la verification des cas implicites
if (count($tabOperation)==0 and count($tabImplicite)==1)
{
 switch($varInc)
	{
		case 'partie1' : if($tabImp[0]==$partie1)
							{
								$col1=0;$col2=0;$col3=9;$col4=0;
							}
						 else if($tabImp[0]!=$partie1)
						 	{
								$col1=3;$col2=0;$col3=9;$col4=9;
							}
						  break;
		case 'partie2' : if($tabImp[0]==$partie2)
							{
								$col1=0;$col2=0;$col3=9;$col4=0;
							}
						 else if($tabImp[0]!=$partie2)
						 	{
								$col1=3;$col2=0;$col3=9;$col4=9;
							}

						  break;
		case 'tout' : 	if($tabImp[0]==$tout)
							{
								$col1=0;$col2=0;$col3=9;$col4=0;
							}
						else if($tabImp[0]!=$tout)
							{
								$col1=3;$col2=0;$col3=9;$col4=9;
							}
						
						  break;
	}//fin du switch
	
}//fin du if
if($varInc=="partie1")
{
	$varInter=$partie2;
	$partie2=$partie1;
	$partie1=$varInter;//inconnu maintenant c'est partie 2 
	$varInc="partie2";
}

for($i=0;$i<count($tabOperation);$i++)
{
$op1= ${"tabOper".$i}[0];
$op2= ${"tabOper".$i}[1];
$res= ${"tabOper".$i}[2];
$op=${"tabOperateur".$i}[0];
//echo("<br>".$op1.$op.$op2."=".$res."<br>");


if($varInc=="partie2")
{
	if (($op1.$op.$op2."=".$res)==($partie1."+".$op2."=".$tout))
	   {
		  $col2=1; //addition a trou 
		 $operande1=$op1; $operande2=$res; $resultat=$op2;
		 $resultat_comp=$partie2;
		}
	else if (($op1.$op.$op2."=".$res)==($op1."+".$partie1."=".$tout))
	   {
		 $col2=1; //addition a trou
		 $operande1=$res; $operande2=$op2 ; $resultat=$op1;
		 $resultat_comp=$partie2;
		}
	else if (($op1.$op.$op2."=".$res)==($tout."-".$op2."=".$partie1))
		{
		//soustraction à trou
		 $col2=7 ;
		 $operande1=$op1; $operande2=$res; $resultat=$op2;
		 $resultat_comp=calcul($operande1,"-",$operande2);
		}
	else if (($op1.$op.$op2."=".$res)==($partie1."-".$op2."=".$tout))
		{
		 //addition a trou erreur dans le signe de l'opperation
		 $col2=6 ;
		 $operande1=$op1; $operande2=$res; $resultat=$op2;
		 $resultat_comp=calcul($operande1,"-",$operande2);
		}
	else if (($op1.$op.$op2."=".$res)==($tout."-".$partie1."=".$res))
	   {
		 //soustraction 
		 $col2=2;
		 $operande1=$op1; $operande2=$op2; $resultat=$res;
		 $resultat_comp=calcul($operande1,$op,$operande2);
	   }  
	 else if (($op1.$op.$op2."=".$res)==($op1."-".$op2."=".$partie2) and ($op1!=$partie1 || $op2!=$tout))
	   {
		 //soustraction avec des données qui ne sont pas dans l'enoncé
		 $col2=2;$col3=1;$col1=3;
		 $operande1=$op1; $operande2=$op2; $resultat=$res;
		 $resultat_comp=calcul($operande1,$op,$operande2);
	   }    
	else if (($op1.$op.$op2."=".$res)==($partie1."-".$tout."=".$res))
	  {
		// soustraction inverser
		 $col2=3;
		 $operande1=$op1; $operande2=$op2; $resultat=$res;
		 $resultat_comp=$partie2;
	   }
	else if ((($op1.$op.$op2."=".$res)==($tout."+".$partie1."=".$res)) || (($op1.$op.$op2."=".$res)==($partie1."+".$tout."=".$res)))
		{
		 $col2=4; $col3=0;//addition
		 $operande1=$op1; $operande2=$op2; $resultat=$res;
		 $resultat_comp=calcul($operande1,$op,$operande2);
		 $NonPertinent =true;
		}

	else if ((($op1.$op.$op2."=".$res)==($op1."+".$op2."=".$partie2)) || (($op1.$op.$op2."=".$res)==($op1."+".$op2."=".$partie2)))
		{
		 //addition
		 $col2=4;$col3=1;
		 $operande1=$op1; $operande2=$op2; $resultat=$res;
		 $resultat_comp=calcul($operande1,$op,$operande2);
		}
	else if ((($op1.$op.$op2."=".$res)==($tout."*".$partie1."=".$partie2))||(($op1.$op.$op2."=".$res)==($partie1."*".$tout."=".$partie2)))
		{
		 //autre opération MULTIPLICATION avec les bonnes données de l'enoncé et resultat bon
		 $col2=53;$col3=0;
		 $operande1=$op1; $operande2=$op2; $resultat=$res;
		 $resultat_comp=calcul($operande1,$op,$operande2);
		 $NonPertinent =true;
		}

	else if ((($op1.$op.$op2."=".$res)==($tout."*".$partie1."=".$res))||(($op1.$op.$op2."=".$res)==($partie1."*".$tout."=".$res)))
		{
		 //autre opération MULTIPLICATION avec les bonnes données de l'enoncé
		 $col2=51;$col3=0;
		 $operande1=$op1; $operande2=$op2; $resultat=$res;
		 $resultat_comp=calcul($operande1,$op,$operande2);
		 $NonPertinent =true;
		}
	else if ((($op1.$op.$op2."=".$res)==($tout.":".$partie1."=".$res))||(($op1.$op.$op2."=".$res)==($partie1.":".$tout."=".$res)))
		{
		 //autre opération DIVISION avec les bonnes données de l'enoncé
		 $col2=52;$col3=1;
		 $operande1=$op1; $operande2=$op2; $resultat=$res;
		 $resultat_comp=calcul($operande1,$op,$operande2);
		 $NonPertinent =true;
		}
	else if ((($op1.$op.$op2."=".$res)==($op1.":".$op2."=".$res))||(($op1.$op.$op2."=".$res)==($op1."*".$op2."=".$res)))
		{
		 //Division au lieu d'une addition autre données
		 $col2=5;$col3=1;
		 $operande1=$op1; $operande2=$op2; $resultat=$res;
		 $resultat_comp=calcul($operande1,$op,$operande2);
		}
	else if (!(ereg("[0-7]",$col2)))
		{
		 $col2=9;
		}
 //=================col3=============

  if (($col2==0) and ($resultat!=$partie2))
	{
		$col3=9;
	}
	else if ($col2==9)
	{
		$col3=9;
	}
	else if ( ($operande1==$tout and $operande2==$partie1) || ($operande2==$tout and $operande1==$partie1) )
	{
		$col3=0;
	}
   else 
	{
		$col3=1; 
	}
 //=================col4=============
	if (($col3==9) and ($col2==9))
	{
		$col4=9; 
	}
	else if (($resultat==$resultat_comp))
	{
		$col4=0; 
	}
	else if ((($resultat==$resultat_comp-1)||($resultat==$resultat_comp+1)))
	{
		 $col4=1; 
	}
	else if ((($resultat < $resultat_comp-1) ||($resultat > $resultat_comp-1)))
	{
		$col4=2;
	}
	
}//fin du if($varInc=="partie2")
else if($varInc=="tout")
{
	//col 2 pour les cas d'addition deux données
	if ((($op1.$op.$op2."=".$res)==($partie1."+".$op2."=".$partie2))||(($op1.$op.$op2."=".$res)==($partie2."+".$op2."=".$partie1)))
	   {
		 $col2=1;$col3=1; //addition a trou 
		 $operande1=$op1; $operande2=$res; $resultat=$op2;
		 $resultat_comp=$partie2;
		}
	else if ((($op1.$op.$op2."=".$res)==($partie1."+".$partie2."=".$res)) || (($partie2.$op.$partie1."=".$res)==($op1."+".$op2."=".$res)))
		{
			 //addition
			 $col2=4;$col3=0;
			 $operande1=$op1; $operande2=$op2; $resultat=$res;
			 $resultat_comp=calcul($operande1,$op,$operande2);
		 }
	else if ((($op1.$op.$op2."=".$res)==($partie1."-".$partie2."=".$res)) || (($op1.$op.$op2."=".$res)==($partie2."-".$partie1."=".$res)))
		{
			 if($res!=$tout) 
			 { 	//soustraction au lieu d'une addition
			 	$col2=2;//soustraction (erreur)
			  }
			 else if($res==$tout) 
			 {//erreur de signe dans l'addition mais pas dans le calcul de l'addition
			 	$col2=41;$col4=0;
			  }
			 $col3=0;
			 $operande1=$op1; $operande2=$op2; $resultat=$res;
			 $resultat_comp=calcul($operande1,$op,$operande2);
		 }
	else if (($op1.$op.$op2."=".$res)==($op1."+".$op2."=".$tout) and 
			 ($op1!=$partie1 or $op2!=$partie2 or $op1!=$partie2 or $op2!=$partie1))
		{
			 //addition
			 $col2=4;$col3=1;$col1=3;
			 $operande1=$op1; $operande2=$op2; $resultat=$res;
			 $resultat_comp=calcul($operande1,$op,$operande2);
		 }
	else if ((($op1.$op.$op2."=".$res)==($partie1."*".$partie2."=".$tout))||(($op1.$op.$op2."=".$res)==($partie2."*".$partie1."=".$tout)))
		{
			 //Multiplication au lieu d'une addition avec les bonnes données et le bon resultat
			 $col2=53;$col3=0;
			 $operande1=$op1; $operande2=$op2; $resultat=$res;
			 $resultat_comp=calcul($operande1,$op,$operande2);
		 }
	else if ((($op1.$op.$op2."=".$res)==($partie1."*".$partie2."=".$res))||(($op1.$op.$op2."=".$res)==($partie2."*".$partie1."=".$res)))
		{
			 //Multiplication au lieu d'une addition avec les bonnes données
			 $col2=51;$col3=0;
			 $operande1=$op1; $operande2=$op2; $resultat=$res;
			 $resultat_comp=calcul($operande1,$op,$operande2);
		 }
	else if ((($op1.$op.$op2."=".$res)==($partie1.":".$partie2."=".$res))||(($op1.$op.$op2."=".$res)==($partie2.":".$partie1."=".$res)))
		{
			 //Division au lieu d'une addition avec les bonnes données
			 $col2=52;$col3=0;
			 $operande1=$op1; $operande2=$op2; $resultat=$res;
			 $resultat_comp=calcul($operande1,$op,$operande2);
		 }
	else if ((($op1.$op.$op2."=".$res)==($op1.":".$op2."=".$res))||(($op1.$op.$op2."=".$res)==($op1."*".$op2."=".$res)))
		{
			 //Division au lieu d'une addition
			 $col2=5;$col3=1;
			 $operande1=$op1; $operande2=$op2; $resultat=$res;
			 $resultat_comp=calcul($operande1,$op,$operande2);
		 }
		 //$colonne 4
		if($resultat_comp==$resultat || $col4==0) 
		 {
			$col4=0;
		 }
		 else if ($resultat_comp!=$resulat) 
		 {
			$col4=1;
		 }
}//fin du if($varInc=="tout")



//codage de la colonne 1
if(isset($col1))
{
	$col1=$col1;
}
else if($varInc=="partie2" and  (ereg("[1-3]",$col2)||ereg("[6-7]",$col2)))
	{
		if ($col4==0 || $col2==6) $col1=1;
		else if ($col4==1 || $col4==2) $col1=2;
	}
else if($varInc=="partie1" and  (ereg("[1-3]",$col2)||ereg("[6-7]",$col2)))
	{
		if ($col4==0 || $col2==6) $col1=1;
		else if ($col4==1 || $col4==2) $col1=2;
	}
else if($varInc=="tout" and ($col2==4 || $col2==41))
	{
		if ($col4==0) $col1=1;
		else if ($col4==1) $col1=2;
	}
else if(($varInc=="partie1" || $varInc=="partie2") and $col2==4 and !isset($col1))
	{
		$col1=2;
	}
else if(($varInc=="tout" and $col2==2)||($varInc=="partie1" and ($col2==4 || $col2==1)))
	{
		$col1=3;
	}
else if(!isset($col1))
	{
		//$col1=3;
	}
}//fin de la boucle for
if(count($tabOperation)>1)
{
	switch ($col1)
	{
		case 1 : $col1=41;break;
		case 2 : $col1=42;break;
		case 3 : $col1=43;break;
	}
}
if (count($tabOperation)==1 and ($col2==1 || $col2==7  || $col2==6) and (end($tabNombre1)!=$resultat))
	{
		$col5=1;//mauvais choix de réponse addition à trou, soustraction à trou et add à trou avec erreur de signe
	}
else if (count($tabOperation)==1 and (($col2==2 || $col2==3  || $col2==53) and ($varInc=="partie2")) and (end($tabNombre1)!=$resultat))
	{
		$col5=11;//mauvais choix de réponse soustraction, soustraction inversée, erreur de signe
	}
else if (count($tabOperation)==1 and (($col2==4 || $col2==41 || $col2==53) and ($varInc=="tout")) and (end($tabNombre1)!=$resultat))
	{
		$col5=11;//mauvais choix de réponse addition à trou, soustraction à trou et add à trou avec erreur de signe
	}
//print("<br>col1=".$col1." | col2=".$col2." | col3=".$col3." | col4=".$col4." | col5=".$col5."<br>");
//exit();
if (!isset($col1) and !(ereg("[0-3|41|42|43]",$col1))) 
{for ($i=1;$i<=5;$i++) ${"col".$i}=9;}
if (!isset($col2) and !(ereg("[0-7|41|51|52|53]",$col2))) $col2=9;
if (!isset($col3) and !(ereg("[0-5]",$col3))) $col3=9;
if (!isset($col4) and !(ereg("[0-5]",$col4))) $col4=9;
if (!isset($col5) and !(ereg("[0-8|11]",$col5))) $col5=9;
 
//$nbOper = count($tabOperation);
//print_r($tabOperation);
$typeExo="etape";
//$text=str_replace("'","\'",$text);
$text=addslashes($text);
/*_____________________________________________________________________________________*/
 $Requete_SQL="INSERT INTO trace (numEleve,numSerie,numExo,typeExo,questInt,sas ,
				operation1, operation2, operande1, operande2,operande3,zonetext,resultat,actions) VALUES
				('".$_SESSION['numEleve']."','".$numSerie."','".$n."','".$typePb."','".$question."','".$sas."',
				'".$oper_1."','".$oper_2."','".$op_1."','".$op_2."','".$op_3."','".$text."','".$_POST['resultat1']."','".$_POST['Trace']."')";
// Execution de la requete SQL.
$result=mysql_query($Requete_SQL) or die("Erreur d'Insertion dans la base : ". $Requete_SQL .'<br />'. mysql_error());
$Requete_SQL3="select id from trace order by id desc limit 1";
$result3=mysql_query($Requete_SQL3) or die("Erreur d'Insertion dans la base : ". $Requete_SQL3 .'<br />'. mysql_error());
while ($r=mysql_fetch_assoc($result3))
		{
			$id=$r["id"];
		} 
/* -------------------------------------------------------------------------------------*/
//exit();
$Requete_SQL1="INSERT INTO diagetape (numSerie,numTrace,numEleve,date,numExo,typePb,inconnu,var, col1, col2, col3, col4, col5) VALUES
				('".$numSerie."','".$id."','".$_SESSION['numEleve']."','".$date."','".$n."','".$typePb."','".$inconnu."','".$var."',$col1,$col2,$col3,$col4,$col5)";

$result=mysql_query($Requete_SQL1) or die("Erreur d'Insertion dans la base : ". $Requete_SQL1 .'<br />'. mysql_error());
// Execution de la requete SQL.

 mysql_close($BD_link);
 
	//$interface = "interfaceIE.php?numSerie=".$numero;
	//print("<a href=\"javascript:;\" onClick=\"window.open('$interface','Interface','fullscreen');\">".$nomSerie."</a>");
	echo "<script type='text/javascript'>location.href='interfaceIE.php?lienRetour=oui&numSerie=".$_SESSION['numSerie']."&nbExo=".$nbExo."&numExo=".$numExo."';</script>";

?>