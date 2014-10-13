<?php
 session_start();
  //$_SESSION["numExo"]++;
   $nbExo=$_POST['nbExo']; 
   $nbExo--;
 
 $numExo=$_POST["numExo"];
 $numExo++;
 
 $questi=$_SESSION['questi'];
 $n=(int) $_SESSION['num'];
 $t=$_SESSION['type'];
 $text=$_POST["zonetexte"];
 $sas = addslashes($_POST['T1']);
// $choix=$_POST['R1'];
 $oper1=trim($_POST['oper1']); $oper_1=$oper1;
 $oper2=trim($_POST['oper2']); $oper_2=$oper2;
 $op1=$_POST['operande1']; $op_1=$op1;
 //$op2=$_POST['operande2']; $op_2=$op2;
 //$op3=$_POST['operande3']; $op_3=$op3;
 $resultat=$_POST['resultat1'];
 $numSerie=$_SESSION["numSerie"];
 $aujourdhui=getdate(); $mois=$aujourdhui['mon']; $jour=$aujourdhui['mday']; $annee=$aujourdhui['year'];
 $heur=$aujourdhui['hours']; $minute=$aujourdhui['minutes']; $seconde=$aujourdhui['seconds'];
 $date=$annee.":".$mois.":".$jour." ".$heur.":".$minute.":".$seconde;


 function calcul($a1,$a2,$a3)
  {
	switch ($a2)
	{
		case "+" : $cal = $a1+$a3;
					break;
		case "-" : $cal = $a1-$a3 ;
					break;
		case "*" : $cal = $a1*$a3 ;
					break;
		case ":" : $cal = $a1/$a3 ;
					break;
	}
	return $cal;
  }
  function calcul2($tab1,$tab2)
	{
		$cal=$tab2[0];
		for($i=0;$i<count($tab1);$i++)
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

if ($text=='')
 {
	print ("vous n'avez rien saisie");
    print(" colonne1=9 "); $colonne1=9;
    //exit() ;
 }
 //print($text."<br>");
 //suprime tous caractere different de [^\d+-=:*]
 $calcules=trim(eregi_replace ('[^0-9|,|+|*|:|=|-]', " ",$text));
//print($calcules);
 $tabCal=preg_split ("/[\s]+/", $calcules);
/*for ($i=0; $i < count($tabCal) ; $i++)
{
	switch ($tabCal[$i])
		{
		case "+" : if (($tabCal[$i+2]=="=") and (($tabCal[$i-2]=="") || (ereg("[^-\+]",$tabCal[$i-2]))))
					 {
						 $tabOperation[]=$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
					 }
				   else if (($tabCal[$i+2]=="=")and(($tabCal[$i-2]=="+")||($tabCal[$i-2]=="-"))and(($tabCal[$i-4]=="+")||($tabCal[$i-4]=="-"))and(($tabCal[$i-6]=="+")||($tabCal[$i-6]=="-")))
						 {
							 $tabOperation[]=$tabCal[$i-7].$tabCal[$i-6].$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
							 $tabOperation2[]=$tabCal[$i-7].$tabCal[$i-6].$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
						 }
				   else if (($tabCal[$i+2]=="=")and(($tabCal[$i-2]=="+")||($tabCal[$i-2]=="-"))and(($tabCal[$i-4]=="+")||($tabCal[$i-4]=="-")))
						 {
							 $tabOperation[]=$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
							 $tabOperation2[]=$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
						 }
				   else if (($tabCal[$i+2]=="=")and(($tabCal[$i-2]=="+")||($tabCal[$i-2]=="-")))
						 {
							 $tabOperation[]=$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
							 $tabOperation2[]=$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
						 }
				   else if (ereg("[0-9]",$tabCal[$i+2])|| $tabCal[$i+2]=="")
								$tabOperation[]=$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1];
				 break;
		case "-" :if (($tabCal[$i+2]=="=") && ((ereg("[^\+\-]",$tabCal[$i-2]))||($tabCal[$i-2]=="")))
					 {
						 $tabOperation[]=$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
					 }
				    else if (($tabCal[$i+2]=="=")and(($tabCal[$i-2]=="+")||($tabCal[$i-2]=="-"))and(($tabCal[$i-4]=="+")||($tabCal[$i-4]=="-"))and(($tabCal[$i-6]=="+")||($tabCal[$i-6]=="-")))
						 {
							 $tabOperation[]=$tabCal[$i-7].$tabCal[$i-6].$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
							 $tabOperation2[]=$tabCal[$i-7].$tabCal[$i-6].$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
						 }
				   else if (($tabCal[$i+2]=="=")and(($tabCal[$i-2]=="+")||($tabCal[$i-2]=="-"))and(($tabCal[$i-4]=="+")||($tabCal[$i-4]=="-")))
						 {
							 $tabOperation[]=$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
							 $tabOperation2[]=$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
						 }
				   else if (($tabCal[$i+2]=="=")and(($tabCal[$i-2]=="+")||($tabCal[$i-2]=="-")))
						 {
							 $tabOperation[]=$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
							 $tabOperation2[]=$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
						 }
				   else if (ereg("[0-9]",$tabCal[$i+2])|| $tabCal[$i+2]=="")
								$tabOperation[]=$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1];
					 break;
		case "*" :if (($tabCal[$i+2]=="=") && ((ereg("[^\*\:]",$tabCal[$i-2]))||($tabCal[$i-2]=="")))
					 {
						 $tabOperation[]=$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
					 }
				    else if (($tabCal[$i+2]=="=")and(($tabCal[$i-2]=="*")||($tabCal[$i-2]==":"))and(($tabCal[$i-4]=="*")||($tabCal[$i-4]==":"))and(($tabCal[$i-6]=="*")||($tabCal[$i-6]==":")))
						 {
							 $tabOperation[]=$tabCal[$i-7].$tabCal[$i-6].$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
							 $tabOperation2[]=$tabCal[$i-7].$tabCal[$i-6].$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
						 }
				   else if (($tabCal[$i+2]=="=")and(($tabCal[$i-2]=="*")||($tabCal[$i-2]==":"))and(($tabCal[$i-4]=="*")||($tabCal[$i-4]==":")))
						 {
							 $tabOperation[]=$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
							 $tabOperation2[]=$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
						 }
				   else if (($tabCal[$i+2]=="=")and(($tabCal[$i-2]=="*")||($tabCal[$i-2]==":")))
						 {
							 $tabOperation[]=$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
							 $tabOperation2[]=$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
						 }
				   else if (ereg("[0-9]",$tabCal[$i+2])|| $tabCal[$i+2]=="")
								$tabOperation[]=$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1];
				   break;

		case ":" : if (($tabCal[$i+2]=="=") && ((ereg("[^\*\:]",$tabCal[$i-2]))||($tabCal[$i-2]=="")))
					 {
						 $tabOperation[]=$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
					 }
				   else if (($tabCal[$i+2]=="=")and(($tabCal[$i-2]=="*")||($tabCal[$i-2]==":"))and(($tabCal[$i-4]=="*")||($tabCal[$i-4]==":"))and(($tabCal[$i-6]=="*")||($tabCal[$i-6]==":")))
						 {
							 $tabOperation[]=$tabCal[$i-7].$tabCal[$i-6].$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
							 $tabOperation2[]=$tabCal[$i-7].$tabCal[$i-6].$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
						 }
				   else if (($tabCal[$i+2]=="=")and(($tabCal[$i-2]=="*")||($tabCal[$i-2]==":"))and(($tabCal[$i-4]=="*")||($tabCal[$i-4]==":")))
						 {
							 $tabOperation[]=$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
							 $tabOperation2[]=$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
						 }
				   else if (($tabCal[$i+2]=="=")and(($tabCal[$i-2]=="*")||($tabCal[$i-2]==":")))
						 {
							 $tabOperation[]=$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
							 $tabOperation2[]=$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
						 }
				   else if (ereg("[0-9]",$tabCal[$i+2])|| $tabCal[$i+2]=="")
								$tabOperation[]=$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1];
					 break;
		}

}*/
		
		 $reponse = $text;
		 $reponse = ereg_replace ('([a-zA-Z]) *- *([a-zA-Z])','\1 \2',$reponse);
		//suprime tous caractere different de [^\d+-=:*]
		$reponse = trim(eregi_replace ('[^0-9|,|+|*|:|=|-]', " ",$reponse));
				   
		$pattern = "/(((?:\d+\s*[\+\-\*\/x:]\s*)+\d+\s*)=?\s*(\d*))/"; //(?:) parenthèse non capturante 
		preg_match_all($pattern,$reponse,$tab);
		
		//tableau des opération utilisées dans la réponse de l'apprenant ==> tabOperation
		$tabOperation = $tab[0];
		$tabOperation2 = $tabOperation;
		$tabSR = $tab[2];
		$tabR = $tab[3];

/*
print("les operation qui ont ete saisie sont : <br>");
for ($i=0; $i < count($tabOperation) ; $i++)
   {
	 print($tabOperation[$i]."<br>");
   }
print ("<br>-------------------------------<br>");exit("ok");
 */
$tabMot=preg_split ("/[\s]+/", $text);
//recherche les nombre dans le tableau tabMot
$numeros=array_values (preg_grep("/\d/", $tabMot));
//echo count($numeros);
/*print("les mots du textes<br>");
for ($i=0 ; $i < count($tabMot) ;$i++)
	print($tabMot[$i]."<br>");
print ("<br>-------------------------------<br>");
print ("les nombres que le texte contient sont"); */
for ($i=0 ; $i < count($numeros) ;$i++)
{
	//print($numeros[$i]." "."<br>");
	$tab=preg_split ("/[\s\+\-\*\:\=]+/", $numeros[$i]);
	$num=array_values (preg_grep("/\d/", $tab));
	$nombre=array();
	for ($j=0 ; $j < count($num) ;$j++)
	{
		//print($num[$j]." ");
		$a=eregi_replace('[^(0-9\,)]',"",$num[$j]);
		$nombre[]=$a;
	}
}
/*  for ($i=0 ; $i < count($nombre) ;$i++)
	print($nombre[$i]." ");*/
$tabNombre=$nombre;
//====================================================
 require_once("conn.php");
 $Requete_SQL1="SELECT * FROM $t where numero = $n";
 $result=mysql_query($Requete_SQL1) or die("Erreur de S&eacute;lection dans la base : ". $Requete_SQL1 .'<br />'. mysql_error());
 while ($val=mysql_fetch_array($result))
	{
    	$partie1=$val["partie1"];
    	$partie2=$val["partie2"];
		$partie3=$val["partie3"];
		$tout1=$val["tout1"];
		$tout2=$val["tout2"];
		$valdiff=$val["valdiff"];
		$question=$val["question"];
		$var=$val["variable"];
 	}

$chaineOp=implode (' ',$tabOperation);
$chaineOper=trim(eregi_replace ('[^0-9|,]', " ",$chaineOp));
$tabOperande= array_values(preg_split ("/[\s]+/", $chaineOper));
/*  print ("le tableau des operations :  ");print_r($tabOperation);print ("<br>");
print ("le tableau d'operande :  ");print_r($tabOperande);print ("<br>");
print ("le tableau des nombres :  ");print_r($nombre);print ("<br>");*/

/*effectuer la difference entre les deux tableaux $nombre et $tabOperande*/
for ($i=0; $i<count($tabOperande); $i++)
			 {
				for ($j=0 ; $j < count($nombre) ; $j++)
					{
					  if ($tabOperande[$i]==$nombre[$j])
						{
							$nombre[$j]='';
							break 1;
						}
					}
			 }
$tabImp=array();
for ($i=0 ; $i < count($nombre) ;$i++)
		if ($nombre[$i]!='')
		  $tabImp[]=$nombre[$i];
/*   print ("le tableau tabImp \"Implicite\""); print_r($tabImp);print ("<br>");
 *//*======ajouter le signe egale a l'operation s'il n'existe pas=======*/

for ($i=0,$k=0; $i < count($tabOperation);$i++)
{
	if(!strstr($tabOperation[$i],'='))
	{
	$tabOperation[$i]=$tabOperation[$i]."=".$tabImp[$k];
	}
	$k++;
}
/*  print ("le tableau des operations :  ");print_r($tabOperation);print ("<br>");*/

/*-------fin difference entre les deux tableaux-----------*/
/* -----------------------------verifier si l'operation est implicite ou pas-------------------------------------- */
if (isset($tabImp)) 
{
	//print ("<br><br>le tableau tabImp \"Implicite\"");	print_r($tabImp); print ("<br><br>");
	
	for ($i=0; $i<count($tabOperation);$i++)
	{
		${'tab'.$i}=$tabOperation[$i];
		${'chaineOper'.$i}=trim(eregi_replace ('[^0-9|,]', " ",${'tab'.$i}));
		${'tabOperande'.$i}= array_values(preg_split ("/[\s]+/", ${'chaineOper'.$i}));
		//print_r(${'tabOperande'.$i});print("<BR>");
	}

	//dernier tableau d'operande pour le calcul final; cas d'une addition a trou
	$i=count($tabOperation)-1;
	$dernierTabOp=${'tabOperande'.$i};
	//echo "le dernier tableau d'operande est :<br>"; print_r($dernierTabOp);echo "<br><br>";
	if (isset($tabImp) and ($dernierTabOp["1"]==end($tabImp)||$dernierTabOp["0"]==end($tabImp)))
	{
		$addTrou=true;
	}
	//debut de l'élimination des nombres implicite (nombres qui ne sont pas des opérandes
	
	if(count($tabOperation)==3)
	{
		if(count($tabImp)==3)
		{
			if (((in_array($tabImp[0],$tabOperande0))xor(in_array($tabImp[0],$tabOperande1)))and
				((in_array($tabImp[1],$tabOperande0))xor(in_array($tabImp[1],$tabOperande1)))and
				(in_array($tabImp[2],$tabOperande2)))
			{
				unset($tabImp);
			}
		}
		else if(count($tabImp)==2)
		{
			if (((in_array($tabImp[0],$tabOperande0)) and (in_array($tabImp[1],$tabOperande1)))xor
				((in_array($tabImp[0],$tabOperande1)) and (in_array($tabImp[1],$tabOperande2)))xor
				((in_array($tabImp[0],$tabOperande0)) and (in_array($tabImp[1],$tabOperande2))))
			{
				unset($tabImp);
			}
		}
		else if(count($tabImp)==1)
		{
			if((in_array($tabImp[0],$tabOperande0))||(in_array($tabImp[0],$tabOperande1))||(in_array($tabImp[0],$tabOperande2)))
			{
				unset($tabImp);
			}
		}
	}
	else if(count($tabOperation)==2)
	{
		if(count($tabImp)==3)
		{
			if (((in_array($tabImp[0],$tabOperande0))xor(in_array($tabImp[0],$tabOperande1)))and
				((in_array($tabImp[1],$tabOperande0))xor(in_array($tabImp[1],$tabOperande1))))
				{
					$a=$tabImp[2];
					unset($tabImp);
					$tabImp[0]=$a;
					//exit($tabImp[0]);
				}
	
			else if ((in_array($tabImp[0],$tabOperande1)) and (in_array ($tabImp[1],$tabOperande1)) and (in_array($tabImp[2],$tabOperande1)))
				{
					if (in_array($tabImp[0],$tabOperande0))
					{
						$a=$tabImp[1];
						unset($tabImp);
						$tabImp[0]=$a;
						//exit($tabImp[0]);
					}
					if (in_array($tabImp[1],$tabOperande0))
					{
						$a=$tabImp[0];
						unset($tabImp);
						$tabImp[0]=$a;
						//exit($tabImp[0]);
					}
	
				}
		}
		else if(count($tabImp)==2)
		{
			if(in_array($tabImp[0],$tabOperande0) and in_array($tabImp[1],$tabOperande1))
			{
				unset($tabImp);
			}
			else if(in_array($tabImp[0],$tabOperande0) and in_array($tabImp[0],$tabOperande1))
			{
				$a=$tabImp[1];
				unset($tabImp);
				$tabImp[0]=$a;
				//exit($tabImp[0]);
			}
			else if(in_array($tabImp[1],$tabOperande0) and in_array($tabImp[1],$tabOperande1))
			{
				$a=$tabImp[0];
				unset($tabImp);
				$tabImp[0]=$a;
				//exit($tabImp[0]);
			}
		}
		else if(count($tabImp)==1)
		{
			if (in_array($tabImp[0],$tabOperande1))
			{
				unset($tabImp);
			}
		}
	}
	else if(count($tabOperation)==1)
	{
		if(count($tabImp)==3)
		{
			if ((in_array($tabImp[0],$tabOperande0)) and (in_array ($tabImp[1],$tabOperande0)) and (in_array($tabImp[2],$tabOperande0)))
			{
				$a=$tabImp[0];$b=$tabImp[1];
				unset($tabImp);
				$tabImp[0]=$a;$tabImp[1]=$b;
			}
			else if (in_array($tabImp[0],$tabOperande0))
			{
				$a=$tabImp[1];$b=$tabImp[2];
				unset($tabImp);
				$tabImp[0]=$a;$tabImp[1]=$b;
			}
			else if (in_array($tabImp[1],$tabOperande0))
			{
				$a=$tabImp[0];$b=$tabImp[2];
				unset($tabImp);
				$tabImp[0]=$a;$tabImp[1]=$b;
			}
		}
		else if(count($tabImp)==2)
		{
			if(in_array($tabImp[0],$tabOperande0) and in_array($tabImp[1],$tabOperande0))
			{
				unset($tabImp);
			}
			else if (in_array($tabImp[0],$tabOperande0))
			{
				$a=$tabImp[1];
				unset($tabImp);
				$tabImp[0]=$a;
				//exit($tabImp[0]);
			}
			else if (in_array($tabImp[1],$tabOperande0))
			{
				$a=$tabImp[0];
				unset($tabImp);
				$tabImp[0]=$a;
				//exit($tabImp[0]);
			}
	
		}
		else if(count($tabImp)==1)
		{
			if(in_array($tabImp[0],$tabOperande0))
			{
				unset($tabImp);
			}
		}
	}
}
//début de la verification des cas implicites
$bool=false;
if ((count($tabOperation)==0) and ((count($tabImp)==1)||(count($tabImp)==2)))
{
 	switch ($question)
	{
		case 't':if (($tabImp[0]==$partie2 ) and (count($tabImp)==1))
				 {
				  $resultat=$partie2; $colonne2=0;$colonne3=9;$colonne4=0;
				  /*  print("colonne2=0 colonne3=9 colonne4=0");*/
				  $etape1=true; $etape=true;
				 }
				else if (($tabImp[0]==$valdiff) and (count($tabImp)==1))
				 {
				  //$resultat=$valdiff;
				  $resultatd=$valdiff;  $colonne10=0; $colonne11=9; $colonne12=0; $colonne16=9;
				  /*  print("colonne10=0 colonne11=9 colonne12=0");*/
				  $difference=true;$diff=true;
				 }
		        else if (($tabImp[0]==$tout2) and (count($tabImp)==1))
					{
					//$resultatf=$tout2;
					$colonne14=0; $colonne15=0; $colonne16=9; $colonne17=0 ;
					/*  print("colonne14=0 colonne15=0 colonne16=9 colonne17=0"); */
					$varImp=true;
					}
				else if (($tabImp[1]==$tout2) and ($tabImp[0]==$partie2) and (count($tabImp)==2))
					{
					$resultat=$partie2; $colonne2=0;$colonne3=9;$colonne4=0;
					$colonne14=0; $colonne15=0;$colonne16=9; $colonne17=0 ;
					/* print("colonne14=0 colonne15=0 colonne16=9 colonne17=0");  */
					$etape=true;
					$varImp=true;
					}
				else if (($tabImp[0]==$valdiff) and ($tabImp[1]==$tout2) and (count($tabImp)==2))
				  {
     			   $resultatd=$valdiff;  $colonne10=0; $colonne11=9; $colonne12=0;
				  $colonne14=0; $colonne15=0; $colonne16=9; $colonne17=0 ;
				  }
				else if (($tabImp[0]==$partie2) and (($tabImp[1]!=$tout2) || ($tabImp[1]!=$valdiff)) and (count($tabImp)==2))
				  {
     			   $colonne2=0; $colonne3=9; $colonne4=0; $etape=true;
				   $colonne14=0; $colonne15=0; $colonne16=9; $colonne17=9 ;
				  }
				else if (($tabImp[0]!=$tout2) and (count($tabImp)==1))
					{
					//$resultat=$tout2;
					$colonne1=6;$colonne14=0; $colonne15=0; $colonne16=9; $colonne17=9 ;
					}
				else if (($tabImp[1]!=$tout2) and (count($tabImp)==2))
					{
					//$resultat=$tout2;
					$colonne1=6; $colonne14=0; $colonne15=0;$colonne16=9; $colonne17=9 ; 
					}
				break;
		case 'p':
			if (($tabImp[0]==$partie2 ) and (count($tabImp)==1))
				 {
				  $resultat=$partie2; $colonne2=0;$colonne3=9;$colonne4=0;
				  /*  print("colonne2=0 colonne3=9 colonne4=0");*/
				  $etape1=true; $etape=true;
				 }
				else if (($tabImp[0]==$valdiff) and (count($tabImp)==1))
				 {
				  //$resultat=$valdiff;
				  $resultatd=$valdiff;
				  $colonne10=0; $colonne11=9; $colonne12=0; $colonne16=9;
				  /*  print("colonne10=0 colonne11=9 colonne12=0");*/
				  $difference=true;$diff=true;
				 }
		        else if (($tabImp[0]==$partie3) and (count($tabImp)==1))
					{
					//$resultatf=$tout2;
					$colonne14=0; $colonne15=0; $colonne16=9; $colonne17=0 ;
					/*  print("colonne14=0 colonne15=0 colonne16=9 colonne17=0"); */
					$etape=true;
					$varImp=true;
					}
				else if (($tabImp[1]==$partie3) and ($tabImp[0]==$partie2) and (count($tabImp)==2))
					{
					$resultat=$partie2; $colonne2=0;$colonne3=9;$colonne4=0;
					$colonne14=0; $colonne15=0;$colonne16=9; $colonne17=0 ;
					/* print("colonne14=0 colonne15=0 colonne16=9 colonne17=0");  */
					$etape=true;
					$varImp=true;
					}
				else if (($tabImp[0]==$valdiff) and ($tabImp[1]==$partie3) and (count($tabImp)==2))
				  {
     			   $resultatd=$valdiff;  $colonne10=0; $colonne11=9; $colonne12=0;
				  $colonne14=0; $colonne15=0; $colonne16=9; $colonne17=0 ;
				  }
				else if (($tabImp[0]==$partie2) and (($tabImp[1]!=$partie3) || ($tabImp[1]!=$valdiff)) and (count($tabImp)==2))
				  {
     			   $colonne2=0; $colonne3=9; $colonne4=0; $etape=true;
				   $colonne14=0; $colonne15=0; $colonne16=9; $colonne17=9 ;
				  }  
				else if (($tabImp[0]!=$partie3) and (count($tabImp)==1))
					{
					//$resultat=$tout2;
					$colonne1=6;$colonne14=0; $colonne15=0; $colonne16=9; $colonne17=9 ;
					/*  print("colonne14=0 colonne15=0 colonne16=9 colonne17=8"); */
					//$varImp=true;
					$colonne1=1;
					}
				else if (($tabImp[1]!=$partie3)and (count($tabImp)==2))
					{
					//$resultat=$tout2;
					$colonne14=0; $colonne15=0;$colonne16=9; $colonne17=9 ; $colonne1=6;
					/* print("colonne14=0 colonne15=0 colonne16=9 colonne17=8");  */
					//$varImp=true;
					}
				break;
	}
}
else if (count($tabOperation)==1)
{
	switch ($question)
	{
		case 't':if (($tabImp[0]==$partie2 ) and (count($tabImp)==1))
				 {
				  $resultat=$partie2; $colonne2=0;$colonne3=9;$colonne4=0;
				  /*  print("colonne2=0 colonne3=9 colonne4=0");*/
				  $etape1=true; $etape=true;
				 }
				else if (($tabImp[0]==$valdiff) and (count($tabImp)==1))
				 {
				  //$resultat=$valdiff;
				  $resultatd=$valdiff;  $colonne10=0; $colonne11=9; $colonne12=0; $colonne16=9;
				  /*  print("colonne10=0 colonne11=9 colonne12=0");*/
				  $difference=true;$diff=true;
				 }
		        else if (($tabImp[0]==$tout2) and (count($tabImp)==1))
					{
					//$resultatf=$tout2;
					$colonne14=0; $colonne15=0; $colonne16=9; $colonne17=0 ;
					/*  print("colonne14=0 colonne15=0 colonne16=9 colonne17=0"); */
					$varImp=true;
					}
				else if (($tabImp[1]==$tout2) and ($tabImp[0]==$partie2) and (count($tabImp)==2))
					{
					$resultat=$partie2; $colonne2=0;$colonne3=9;$colonne4=0;
					$colonne14=0; $colonne15=0;$colonne16=9; $colonne17=0 ;
					/* print("colonne14=0 colonne15=0 colonne16=9 colonne17=0");  */
					$etape=true;
					$varImp=true;
					}
				else if (($tabImp[0]==$valdiff) and ($tabImp[1]==$tout2) and (count($tabImp)==2))
				  {
     			   $resultatd=$valdiff;  $colonne10=0; $colonne11=9; $colonne12=0;
				  $colonne14=0; $colonne15=0; $colonne16=9; $colonne17=0 ;
				  }
				break;
		case 'p':
			if (($tabImp[0]==$partie2 ) and (count($tabImp)==1))
				 {
				  $resultat=$partie2; $colonne2=0;$colonne3=9;$colonne4=0;
				  /*  print("colonne2=0 colonne3=9 colonne4=0");*/
				  $etape1=true; $etape=true;
				 }
				else if (($tabImp[0]==$valdiff) and (count($tabImp)==1))
				 {
				  //$resultat=$valdiff;
				  $resultatd=$valdiff;
				  $colonne10=0; $colonne11=9; $colonne12=0; $colonne16=9;
				  /*  print("colonne10=0 colonne11=9 colonne12=0");*/
				  $difference=true;$diff=true;
				 }
		        else if (($tabImp[0]==$partie3) and (count($tabImp)==1))
					{
					//$resultatf=$tout2;
					$colonne14=0; $colonne15=0; $colonne16=9; $colonne17=0 ;
					/*  print("colonne14=0 colonne15=0 colonne16=9 colonne17=0"); */
					$etape=true;
					$varImp=true;
					}
				else if (($tabImp[1]==$partie3) and ($tabImp[0]==$partie2) and (count($tabImp)==2))
					{
					$resultat=$partie2; $colonne2=0;$colonne3=9;$colonne4=0;
					$colonne14=0; $colonne15=0;$colonne16=9; $colonne17=0 ;
					/* print("colonne14=0 colonne15=0 colonne16=9 colonne17=0");  */
					$etape=true;
					$varImp=true;
					}
				else if (($tabImp[0]==$valdiff) and ($tabImp[1]==$partie3) and (count($tabImp)==2))
				  {
     			   $resultatd=$valdiff;  $colonne10=0; $colonne11=9; $colonne12=0;
				  $colonne14=0; $colonne15=0; $colonne16=9; $colonne17=0 ;
				  }
				break;
	}//fin du switch
	if (((($question=='t')and(count($tabImp)==1) and (end($tabImp)==$tout2)))
	||((($question=='p')and(count($tabImp)==1) and (end($tabImp)==$partie3))))
	{
	$colonne14=0;$colonne15=0;$colonne16=9;$colonne17=0;
	}
	$operation_f=$tabOperation[0];
	$oper=trim(eregi_replace ('[^-|+|*|:]', " ",$operation_f));
    $T1=array_values(preg_split ("/[\s]+/", $oper));
	$operande=trim(eregi_replace ('[^0-9|,]', " ",$operation_f));
	$T2=array_values(preg_split ("/[\s]+/", $operande));
	for ($i=0; $i<count($T2); $i++)
		 {
			for ($j=0 ; $j < count($nombre) ; $j++)
				{
				  if ($T2[$i]==$nombre[$j])
					{
						$nombre[$j]='';
						break 1;
					}
				}
		 }
	for ($i=0 ; $i < count($nombre) ;$i++)
	{
		if ($nombre[$i]!='')
		 {
		 $T3[]=$nombre[$i];
		 }
	}
    $op1=$T2[0]; $op2=$T2[1]; $res=$T2[2]; $op=$T1[0];

	if (count($tabImp)==1)
	{
		$resultat=$tabImp[0]; $resultatd=$tabImp[0];
		$implicite=true;
		/*  print("<br>resultat intermediaire".$resultat."<br>");*/
	}
	else if (count($tabImp)==2)
	{
		$resultat_f=$tabImp[1]; $resultat=$tabImp[0]; $resultatd=$tabImp[0];
		$implicite=true;
		/* print("<br>resultat final".$resultat_f."<br>");
		print("<br>resultat intermediaire".$resultat."<br>"); */
	}

	$bool=true;
}/* fin de la verification des cas implicites */
//print_r($tabImp);print("<br>colonne2=".$colonne2."colonne3=".$colonne3."colonne4=".$colonne4);
/* ****************************************************************************** */
	/* initialisation */
	if (count($tabOperation)==1)
	{
		$bool=true;
	}
	$exclusion=false;  //colonnes par différence		  
	$exclusion1=false; //colonne par étape

for ($k=0 ; (($k <= count($tabOperation)-1)||($bool==true)); $k++)
{
	$bool=false; $etape1=false; $difference=false;/* Initialisation */
	$operation1=$tabOperation[$k];
	//suprime tous caractere different de [^+-:*] , les resultats dans un tableau T1
	 $oper=trim(eregi_replace ('[^-|+|*|:]', " ",$operation1));
	 $T1=array_values(preg_split ("/[\s]+/", $oper));
	//suprime tous caractere different des operandes , les resultats dans un tableau T2
	$operande=trim(eregi_replace ('[^0-9|,]', " ",$operation1));
	$T2=array_values(preg_split ("/[\s]+/", $operande));
	//print("le tableau T2 contient :  ");print_r($T2);print ("<br>");
	for ($i=0; $i<count($T2); $i++)
		 {
			for ($j=0 ; $j < count($nombre) ; $j++)
				{
				  if ($T2[$i]==$nombre[$j])
					{
						$nombre[$j]='';
						break 1;
					}
				}
		 }
	//print("<br>les nombres restant apres elimination des operandes  : ");
	for ($i=0 ; $i < count($nombre) ;$i++)
	{
		if ($nombre[$i]!='')
		 {
		 $T3[]=$nombre[$i];
		 }
	}
	//print_r($T3); print("<br>");
//=========il n' y a qu'une operation=============
	if (count ($T1)==1 )
	 {
		   $op1=$T2[0]; $op2=$T2[1]; $res=$T2[2];
		   $op=$T1[0];

		  // if ($T2[2]!="")
		   //print ("<br>l'operation est : ".$op1.$op.$op2."=".$res."<br>");

/*==========cas de calcul par différence pour les problèmes de complement===============*/
//=================  colonne10=============
		if ($question=='t')
		{
			if ((($op1.$op.$op2."=".$res)==($partie1."+".$op2."=".$partie3))||(($op1.$op.$op2."=".$res)==($partie3."+".$op2."=".$partie1)))
			   {
				 //if ($colonne10==9 || $colonne10=='')
				 //print (" colonne 10=1 ");
				 if (count($tabOperation==1))
				 {
				 $colonne14=3;$colonne15=1;$colonne16=1;$colonne17=0;
			     $NonPertinent=true;
				 }
				 else
				 {
					 $colonne10=1; //addition a trou
					 $operande1=$op1; $operande2=$res; $resultat=$op2;$resultatd=$op2;
					 $resultat_comp=calcul($operande2,"-",$operande1);
					 $difference=true ; $diff=true;
				 }
			   }
			  else if (((($op1.$op.$op2."=".$res)==($partie1."-".$partie3."=".$res))||(($op1.$op.$op2."=".$res)==($partie3."-".$partie1."=".$res)))&&($op1<=$op2))
				{
				 //print ("colonne 10=3");
				 $colonne10=3;
				 $operande1=$op1; $operande2=$op2; $resultat=$res;$resultatd=$res;
				 $resultat_comp=-calcul($operande1,$op,$operande2);
				 $difference=true ; $diff=true;
				}


			 else if ((($op1.$op.$op2."=".$res)==($partie1."-".$partie3."=".$res))||(($op1.$op.$op2."=".$res)==($partie3."-".$partie1."=".$res)))
				{
				 //print ("colonne 10=2");
				 $colonne10=2;
				 $operande1=$op1; $operande2=$op2; $resultat=$res; $resultatd=$res;
				 $resultat_comp=calcul($operande1,$op,$operande2);
				 $difference=true ;$diff=true;
				}
			//revoir ce cas avec emmanuel et ajouter le meme cas pour les pbs de partie
			/* else if (($op1.$op.$op2."=".$res)==($tout1."-".$partie3."=".$res))
				{
				 $colonne10=2;
				 $operande1=$op1; $operande2=$op2; $resultat=$res; $resultatd=$res;
				 $resultat_comp=calcul($operande1,$op,$operande2);
				 $difference=true ; //$diff=true;
				}  */
			/*else if ((($op1.$op.$op2."=".$res)==($partie1."*".$partie3."=".$res))||(($op1.$op.$op2."=".$res)==($partie3."*".$partie1."=".$res))||(($op1.$op.$op2."=".$res)==($partie1.":".$partie3."=".$res))||(($op1.$op.$op2."=".$res)==($partie3.":".$partie1."=".$res)))
				{
				 //print ("colonne 10=5");
				 $colonne10=5;
				 $operande1=$op1; $operande2=$op2; $resultat=$res; $resultatd=$res;
				 $resultat_comp=calcul($operande1,$op,$operande2);
				 $difference=true ;$diff=true;
				}*/
			else if ((($op1.$op.$op2."=".$res)==($partie1."-".$op2."=".$partie3))||(($op1.$op.$op2."=".$res)==($partie3."-".$op2."=".$partie1)))
				{
				 //print ("colonne 10=7");//soustraction à trou
				 $colonne10=7 ;
				 $operande1=$op1; $operande2=$res; $resultat=$op2; $resultatd=$op2;
				 $resultat_comp=calcul($operande1,"-",$operande2);
				 $difference=true ;$diff=true;
				}
			else if (!(ereg("[0-6]",$colonne10)))
				{
				 //print ("colonne10 =9");
				 $colonne10=9;
				}
		}
		else if ($question=='p')
		{
			if ((($op1.$op.$op2."=".$res)==($tout1."+".$op2."=".$tout2))||(($op1.$op.$op2."=".$res)==($tout2."+".$op2."=".$tout1)))
			   {
				 //print (" colonne 10=1 ");
				 if (count($tabOperation==1))
				 {
				 $colonne10 =9;$colonne14=3;$colonne15=1;$colonne16=1;$colonne17=0;
			     $NonPertinent=true;
				 }
				 else
				 {
				 $colonne10=1; //addition a trou
				 $operande1=$op1; $operande2=$res; $resultat=$op2;$resultatd=$op2;
				 $resultat_comp=calcul($operande2,"-",$operande1);
				 }
				 $difference=true ; $diff=true;
			   }
			 else if (((($op1.$op.$op2."=".$res)==($tout1."-".$tout2."=".$res))||(($op1.$op.$op2."=".$res)==($tout2."-".$tout1."=".$res)))&&($op1<=$op2))
				{
				 //print ("colonne 10=3");
				 $colonne10=3;
				 $operande1=$op1; $operande2=$op2; $resultat=$res; $resultatd=$res;
				 $resultat_comp=-calcul($operande1,$op,$operande2);
				 //print("<br>".$resultat_comp."<br>");
				 $difference=true ; $diff=true;
				}
			 else if ((($op1.$op.$op2."=".$res)==($tout1."-".$tout2."=".$res))||(($op1.$op.$op2."=".$res)==($tout2."-".$tout1."=".$res)))
				{
				 //print ("colonne 10=2");
				 $colonne10=2;
				 $operande1=$op1; $operande2=$op2; $resultat=$res; $resultatd=$res;
				 $resultat_comp=calcul($operande1,$op,$operande2);
				 $difference=true ; $diff=true;
				}
			/*  else if ((($op1.$op.$op2."=".$res)==($tout1."+".$tout2."=".$res))||(($op1.$op.$op2."=".$res)==($tout2."+".$tout1."=".$res)))
				{
				 //print ("colonne 10=4");
				 $colonne10=4;
				 $operande1=$op1; $operande2=$op2; $resultat=$res; $resultatd=$res;
				 $resultat_comp=calcul($operande1,$op,$operande2);
				 $difference=true ; $diff=true;
				} 
			else if ((($op1.$op.$op2."=".$res)==($tout1."*".$tout2."=".$res))||(($op1.$op.$op2."=".$res)==($tout2."*".$tout1."=".$res))||(($op1.$op.$op2."=".$res)==($tout1.":".$tout2."=".$res))||(($op1.$op.$op2."=".$res)==($tout2.":".$tout1."=".$res)))
				{
				 //print ("colonne 10=5");
				 $colonne10=5;
				 $operande1=$op1; $operande2=$op2; $resultat=$res; $resultatd=$res;
				 $resultat_comp=calcul($operande1,$op,$operande2);
				 $difference=true ; $diff=true;
				}*/
			else if ((($op1.$op.$op2."=".$res)==($tout1."-".$op2."=".$tout2))||(($op1.$op.$op2."=".$res)==($tout2."-".$op2."=".$tout1)))
				{
				 //print ("colonne 10=7");//n'existe pas dans le codage
				 $colonne10=7 ;
				 $operande1=$op1; $operande2=$res; $resultat=$op2; $resultatd=$op2;
				 $resultat_comp=calcul($operande1,"-",$operande2);
				 $difference=true ; $diff=true;
				}
			/*  else if (($implicite)and(($resultat==$valdiff )||($resultat==$valdiff+1 )||($resultat==$valdiff-1 )))
				{
					 //print ("colonne10=0");
					 $colonne10=0;
					 $operande1=''; $operande2=''; $resultat=$valdiff; $resultatd=$valdiff;
					 $difference=true ; $diff=true;
					 $resultat_comp= $resultat; 
				} */
			else if (!(isset($colonne10))||(!(ereg("[0-6]",$colonne10))))
				{
					 //print ("colonne10 =9");
					 $colonne10=9;
				}
		 }
//================= colonne11====================if (($difference)||($colonne10==9))
		{
		  if (($colonne10==9)||($colonne10==0))
			{
			  $colonne11=9;//print(" colonne11=9 ");
			  //$exclusion=true;

			}
			else if (($question=='p') and ((($operande1==$tout1)||($operande1==$tout2))&&(($operande2==$tout2)||($operande2==$tout1))))
			{
				$colonne11=0; //print(" colonne11=0 ");
				$exclusion=true;
			}
			else if (($question=='t') and ((($operande1==$partie1)||($operande1==$partie3))&&(($operande2==$partie3)||($operande2==$partie1))))
			{
				 $colonne11=0; //print(" colonne11=0 ");
				 $exclusion=true;
			}
		   else if (($question=='p') and ((($operande1==$tout1)||($operande1==$tout2))xor(($operande2==$tout1)||($operande2==$tout2))))
			{
				$colonne11=1; //print(" colonne11=1 ");
				$exclusion=true;
			}
		   else if (($question=='t') and ((($operande1==$partie1)||($operande1==$partie3))xor(($operande2==$partie1)||($operande2==$partie3))))
			{
				 $colonne11=1;//print(" colonne11=1 ");
				 $exclusion=true;
			}
			else if (($colonne10==0)and($resultat!=$valdiff))
			{
				 $colonne11=9;//print(" colonne11=8 ");
				 $exclusion=true;
			}
//================= colonne 12=============
		 if (($colonne10==9)||($colonne10==0)||($resultat==''))
			{
					$colonne12=9; //print(" colonne12=9 ");
			}
		  else if (($colonne11==9) and($colonne10==0)and ($exclusion))
			{
				$colonne12=9; //print(" colonne12=8 ");
			}
		  else if ($resultatd==$resultat_comp)
			{
				 $colonne12=0; //print(" colonne12=0 ");
			}
		  else if (($resultatd==$resultat_comp-1)||($resultatd==$resultat_comp+1))
			{
				 $colonne12=1;//print(" colonne12=1 ");
			}
		  else if (($resultatd < $resultat_comp-1) ||($resultatd > $resultat_comp-1))
			{
				 $colonne12=2; //print(" colonne12=2 ");
			}
	}//fin du if ($difference)

/*==============strategie par etape======================*/
	  if ($difference != true)
		{
//================= colonne2=============
		   if (($op1.$op.$op2."=".$res)==($partie1."+".$op2."=".$tout1))
			   {
				 //print ("colonne 2=1");
				 $colonne2=1; //addition a trou
				 $operande1=$op1; $operande2=$res; $resultat=$op2;
				 $resultat_comp=$partie2;
				 $etape1=true; $etape=true;$fine=$k;
				}
			else if (($op1.$op.$op2."=".$res)==($op1."+".$partie1."=".$tout1))
			   {
				 //print ("colonne 2=1");
				 $colonne2=1; //addition a trou
				 $operande1=$res; $operande2=$op2 ; $resultat=$op1;
				 $resultat_comp=$partie2;
				 $etape1=true ; $etape=true;$fine=$k;
				}
			/* else if (($op1.$op.$op2."=".$res)==($op1."+".$op2."=".$tout1))
			   {
				 //print ("colonne 2=1");
				 $colonne2=1; //addition a trou
				 $operande1=$op1; $operande2=$res; $resultat=$op2;
				 $resultat_comp=calcul($operande2,"-",$operande1);
				 $etape1=true ;$etape=true;$fine=$k;
			   } */
			else if (($op1.$op.$op2."=".$res)==($tout1."-".$op2."=".$partie1))
				{
				 //print ("colonne 2=7");//n'existe pas dans le codage
				 $colonne2=7 ;
				 $operande1=$op1; $operande2=$res; $resultat=$op2;
				 $resultat_comp=calcul($operande1,"-",$operande2);
				 $etape1=true ;$etape=true;$fine=$k;
				}
			else if (($op1.$op.$op2."=".$res)==($partie1."-".$op2."=".$tout1))
				{
				 //print ("colonne 2=7");//n'existe pas dans le codage addition a trou erreur dans le signe de l'opperation
				 $colonne2=7 ;
				 $operande1=$op1; $operande2=$res; $resultat=$op2;
				 $resultat_comp=calcul($operande1,"-",$operande2);
				 $etape1=true ;$etape=true;$fine=$k;
				}
			else if (($op1.$op.$op2."=".$res)==($tout1."-".$partie1."=".$res))//||(($op1.$op.$op2."=".$res)==($tout1."-".$op2."=".$res)&&($tout1>=$op2)))
			   {
				 //print ("colonne 2=2");
				 $colonne2=2;
				 $operande1=$op1; $operande2=$op2; $resultat=$res;
				 $resultat_comp=calcul($operande1,$op,$operande2);
				 $etape1=true ;$etape=true;$fine=$k;
			   }
			else if (($op1.$op.$op2."=".$res)==($tout1."-".$partie3."=".$res)and(!$etape))
			   {
				 //print ("colonne 2=2");
				 $colonne2=2;
				 $operande1=$op1; $operande2=$op2; $resultat=$res;
				 $resultat_comp=calcul($operande1,$op,$operande2);
				 $etape1=true;$fine=$k;
			   }			   
			else if (($op1.$op.$op2."=".$res)==($partie1."-".$tout1."=".$res))
		      {
				// print ("colonne 2=3");
				 $colonne2=3;
				 $operande1=$op1; $operande2=$op2; $resultat=$res;
				 $resultat_comp=$partie2;
				 $etape1=true ;$etape=true;$fine=$k;
			   }
			else if ((($op1.$op.$op2."=".$res)==($tout1."+".$partie1."=".$res)) || (($op1.$op.$op2."=".$res)==($partie1."+".$tout1."=".$res)))
				{
				 //print ("colonne 2=4");
				 $colonne2=4;
				 $operande1=$op1; $operande2=$op2; $resultat=$res;
				 $resultat_comp=calcul($operande1,$op,$operande2);
				 $etape1=true ;$etape=true;$fine=$k;
				 $NonPertinent =true;
				}

			else if ((($op1.$op.$op2."=".$res)==($op1."+".$op2."=".$partie2)) || (($op1.$op.$op2."=".$res)==($op1."+".$op2."=".$partie2)))
				{
				 //print ("colonne 2=4");
				 $colonne2=4;$colonne3=1;
				 $operande1=$op1; $operande2=$op2; $resultat=$res;
				 $resultat_comp=calcul($operande1,$op,$operande2);
				 $etape1=true ;$etape=true;
				}
			else if ((($op1.$op.$op2."=".$res)==($op1."*".$op2."=".$res))||(($op1.$op.$op2."=".$res)==($op1.":".$op2."=".$res)))
				{
				// print ("colonne 2=5");
				 $colonne2=5;
				 $operande1=$op1; $operande2=$op2; $resultat=$res;
				 $resultat_comp=calcul($operande1,$op,$operande2);
				 $etape1=true ; $etape=false;$NonPertinent =true;//$verrou1=true;
				}
		  }//fin=> if($difference=true)
			else if (!(ereg("[0-7]",$colonne2)))
				{
				 //print ("colonne2 =9");
				 $colonne2=9;
				}
		 //=================colonne3=============

		  if (($colonne2==0) and ($resultat!=$partie2) and ($etape1))
			{
				$colonne3=9; //print(" colonne3=9");
			}
			else if ($colonne2==9)
			{
				$colonne3=9; //print(" colonne3=9");
				$exclusion1=true;
			}
			else if (((($operande1==$tout1)and($operande2==$partie1))||(($operande2==$tout1)and($operande1==$partie1)))and ($etape1))
			{
				 $colonne3=0;//print(" colonne3=0 ");
				 $exclusion1=true;
			}
		   else if (((($operande1==$tout1)||($operande1==$partie1))xor(($operande2==$tout1)||($operande2==$partie1)))and ($etape1))
			{
				 $colonne3=1; //print(" colonne3=1 ");
				 $exclusion1=true;
				 $NonPertinent=true;
			}

		 //=================colonne4=============
		if (($colonne3==9)and ($colonne2==0)and($etape1))
			{
				$colonne4=8; //print(" colonne4=8 ");
			}
		else if (((($colonne2==0)||($resultat==''))and ($etape1))||($colonne2==9))
			{
				$colonne4=9; //print(" colonne4=9 ");
			}
		else if (($resultat==$resultat_comp)and ($etape1))
			{
				$colonne4=0; //print(" colonne4=0 ");
			}
		 else if ((($resultat==$resultat_comp-1)||($resultat==$resultat_comp+1))and ($etape1))
			{
				 $colonne4=1; //print(" colonne4=1 ");
			}
		 else if ((($resultat < $resultat_comp-1) ||($resultat > $resultat_comp-1))and ($etape1))
			{
				$colonne4=2;//print(" colonne4=2 ");
			}
	 }
	else if ((count ($T1)==2) and(count($tabOperation)>1))
	{
		$colonne15=8;
	}
	else if (count($T1)==3 || count($T1)==4)
	{
	 $colonne2=6; $colonne3 =1; $resultat=end($T2);
	 if ($T1[0]=="+")  $resultat_comp=$T2[0] + $T2[1];  else if($T1[0]=="-") $resultat_comp=$T2[0]- $T2[1];
	 if ($T1[1]=="+")  $resultat_comp=$resultat_comp + $T2[2]; else if($T1[1]=="-") $resultat_comp=$resultat_comp- $T2[2];
	 if ($T1[2]=="+")  $resultat_comp=$resultat_comp + $T2[3]; else if($T1[2]=="-") $resultat_comp=$resultat_comp - $T2[3];
	 if ($T1[3]=="+")  $resultat_comp=$resultat_comp + $T2[4]; else if($T1[3]=="-") $resultat_comp=$resultat_comp - $T2[4];

	if ($resultat==$resultat_comp)  $colonne4=0;
	else if (($resultat==$resultat_comp-1)||($resultat==$resultat_comp+1)) 	$colonne4=1;
	else if (($resultat < $resultat_comp-1) ||($resultat > $resultat_comp-1))  $colonne4=2;
	if (count($tabOperation)>1)
	$colonne15=8;
	}

}//fin du for

/*====colonne 14 à 18 solution final========*/
//===================== colonnne 14 et 15===========================
if (count($tabOperation)==1)
{
	$operation_f=$tabOperation[0];
}
else if(count($tabOperation)> 1)
{
	$operation_f=$tabOperation[count($tabOperation)-1];
}

//print("<br>la derniere operation que l'enfant a saisie est : ".$operation_f."<br>");
/*suprime tous caractere different de [^+-:*] , les resultats dans un tableau T1*/
$oper=trim(eregi_replace ('[^-|+|*|:]', " ",$operation_f));
$T1=array_values(preg_split ("/[\s]+/", $oper));
//suprime tous caractere different des operandes , les resultats dans un tableau T2
$operande=trim(eregi_replace ('[^0-9|,]', " ",$operation_f));
$T2=array_values(preg_split ("/[\s]+/", $operande));

$op1=$T2[0]; $op=$T1[0]; $op2=$T2[1]; $res=$T2[2];

/*-----------------------------------------------------------*/
if ((count($tabOperation)>=1) and ($question=='t'))
{
	if (((($op1.$op.$op2."=".$res)==($tout1."+".$partie3."=".$res))||(($op1.$op.$op2."=".$res)==($partie3."+".$tout1."=".$res)))
	and (count($tabOperation)==1))
	{
		$operande1=$op1; $operande2=$op2; $resultatf=$res;
		$colonne1 =4; $colonne2=9;$colonne3=9;$colonne4=9;$colonne5=9;$colonne6=9;$colonne7=9;
		$colonne8=9;$colonne9=9;$colonne10=9;$colonne11=9;$colonne12=9;$colonne13=9;
		$colonne14=5;$colonne15=4;$colonne16=1;
		$resultat_compf=calcul($operande1,"+",$operande2);$etape1=false;
	}
	else if (((($op1.$op.$op2."=".$res)==($partie1."+".$partie3."=".$res))||(($op1.$op.$op2."=".$res)==($partie3."+".$partie1."=".$res)))
	and (count($tabOperation)==1))
	{
		$operande1=$op1; $operande2=$op2; $resultatf=$res;
		$colonne1 =4; $colonne2=9;$colonne3=9;$colonne4=9;$colonne5=9;$colonne6=9;$colonne7=9;
		$colonne8=9;$colonne9=9;$colonne10=9;$colonne11=9;$colonne12=9;$colonne13=9;
		$colonne14=5;$colonne15=4;$colonne16=1;
		$resultat_compf=calcul($operande1,"+",$operande2);$etape1=false;
	}
   else if ((($op1.$op.$op2."=".$res)==($op1."+".$partie3."=".$res))and($op1!=$tout1)and(!$etape)and(!$exclusion1))
	{
		//if ($op1==$partie2)
		//{
		$resultat=$op1;
		//}
		$operande1=$op1; $operande2=$partie3; $resultatf=$res;
		$colonne2=0; $colonne3=9;$colonne4=1;$etape=true;
		$colonne10=9;$colonne11=9;$colonne12=9;
		$resultat_compf=calcul($operande1,"+",$operande2);
	}

else if ((!$exclusion1)and(!$etape)and($op2!=$tout1)and(($op1.$op.$op2."=".$res)==($partie3."+".$op2."=".$res)||($op1.$op.$op2."=".$res)==($op."+".$partie3."=".$res)))
	{   
		if ($op2==$partie2)
		{
			$resultat=$op2;
		}
		else if ($op1==$partie2)
		{
			$resultat=$op1;
		}
		$operande1=$partie3; $operande2=$op2; $resultatf=$res;
		$colonne2=0; $etape=true;
		$colonne10=9;$colonne11=9;$colonne12=9;
		$resultat_compf=calcul($operande1,"+",$operande2);
		if(count($tabOperation)==1 and $res=end($tabNombre))
		{
			$colonne14=5;$colonne15=4;$colonne16=1;	
			//$tabImp='';
		}

	}
   else if ((($op1.$op.$op2."=".$res)==($op1."+".$tout1."=".$res))and($op1!=$partie3)and(!$exclusion)and(!$NonPertinent)and count(tabOpeartion2)==0)
	{
		if ($op1==$valdiff)
		{
		$resultat=$op1;
		}
		$operande1=$op1; $operande2=$tout1; $resultatf=$res;
		$colonne10=0;
		//$colonne2=9;$colonne3=9;$colonne4=9;
		$resultat_compf=calcul($operande1,$op,$operande2);
		$diff=true; $difference=true;
	}
	else if ((($op1.$op.$op2."=".$res)==($tout1."+".$op2."=".$res))and($op1!=$partie3)and(!$exclusion)and(!$NonPertinent) and count(tabOpeartion2)==0 )
	{
		if ($op2==$valdiff)
		$resultat=$op2;
		//$resultat=$op2;
		$operande1=$tout1; $operande2=$op2; $resultatf=$res;
		$colonne10=0; //$colonne2=9;$colonne3=9;$colonne4=9;
		$resultat_compf=calcul($operande1,$op,$operande2);
		$diff=true; $difference=true;//print("colonne2=".$colonne2);
	}

   if (($resultat==$partie2) and (($etape) and ($colonne2==0)))
	{
		$colonne3=9; $colonne4=0; //print(" colonne 2=0 colonne3=9 colonne4=0 ");
	}
  else if ((($resultat > $partie2-1)||($resultat < $partie2-1))and(($etape1)and($colonne2==0)))
	{
		$colonne3=9;$colonne4=1;//print (" colonne 2=0 colonne 3=8 colonne 4=8 ");
	}

	if (($resultat==$valdiff) and (($diff) and ($colonne10==0)))
	{
		$colonne11=9; $colonne12=0;//print(" colonne 10=0 colonne11=9 colonne12=0 ");
	}
	else if ((($resultat > $valdiff-1)||($resultat < $valdiff-1))and(($diff)and($colonne10==0)))
	{
		$colonne11=9;$colonne12=1;//print (" colonne 10=0 colonne 11=8 colonne 12=8 ");
	}
}
else if ((count($tabOperation)>=1) and ($question=='p'))
{
  if ((($op1.$op.$op2."=".$res)==($tout1."+".$tout2."=".$res))||(($op1.$op.$op2."=".$res)==($tout2."+".$tout1."=".$res)))
	{
		$operande1=$op1; $operande2=$op2; $resultatf=$res;
		$colonne1 =4; $colonne2=9;$colonne3=9;$colonne4=9;$colonne5=9;$colonne6=9;$colonne7=9;
		$colonne8=9;$colonne9=9;$colonne10=9;$colonne11=9;$colonne12=9;$colonne13=9;
		$colonne14=5;$colonne15=7;
		$resultat_compf=calcul($operande1,"+",$operande2);$etape1=false;
	}
  if ((($op1.$op.$op2."=".$res)==($partie1."+".$tout2."=".$res))||(($op1.$op.$op2."=".$res)==($tout1."+".$partie1."=".$res)))
	{
		$operande1=$op1; $operande2=$op2; $resultatf=$res;
		$colonne1=4; $colonne2=9;$colonne3=9;$colonne4=9;$colonne5=9;$colonne6=9;$colonne7=9;
		$colonne8=9;$colonne9=9;$colonne10=9;$colonne11=9;$colonne12=9;$colonne13=9;
		$colonne14=5;$colonne15=4;
		$resultat_compf=calcul($operande1,"+",$operande2);$etape1=false;
	}
  else if ((($op1.$op.$op2."=".$res)==($tout2."-".$op2."=".$res))and($op2!=$partie1)and(!$diff)and(count($tabOperation)==$fine+1))
	{
		$resultat=$op2; $operande1=$tout2; $operande2=$op2; $resultatf=$res;
		$colonne2=0; $etape1=true;$etape=true;
		$resultat_compf=calcul($operande1,"-",$operande2);
	}
  else if ((($op1.$op.$op2."=".$res)==($op2."-".$tout2."=".$res))and(count($tabOperation)==$fine+1))
	{
		$resultat=$op2; $operande2=$tout2; $operande1=$op1; $resultatf=$res;
		$colonne2=0; $etape1=true;$etape=true;
		$resultat_compf=-calcul($operande1,"-",$operande2);
	}
  else if ((($op1.$op.$op2."=".$res)==($partie2."+".$op2."=".$tout2)||($op1.$op.$op2."=".$res)==($op1."+".$partie2."=".$tout2))and(count($tabOperation)==$fine+1))
	{/*adition a trou*/
		if($op1==$partie2)
		{$resultat=$op1; $resultatf=$op2;$operande1=$op1;}
		else if ($op2==$partie2)
		{$resultat=$op2; $resultatf=$op1;$operande1=$op2;}
		 $operande2=$tout2;
		$colonne2=0; $etape1=true;$etape=true;
		$resultat_compf=calcul($operande2,"-",$operande1);
	}

	if (($resultat==$partie2) and ($etape) and ($colonne2==0))
	{
		$colonne3=9; $colonne4=0;
	}
	else if ((($resultat >= $partie2-1)||($resultat <= $partie2-1))and(($colonne2==0)and($etape1)))
	{
		//print (" colonne 2=0 colonne 3=8 colonne 4=8 ");
		$colonne3=9;$colonne4=9;
	}
}
//=========colonne 14 et 15=============

	 if (($question=='p') and ($addTrou) and (($op1.$op.$op2."=".$res)==($resultat."+".$op2."=".$tout2)||($op1.$op.$op2."=".$res)==($partie2."+".$op2."=".$tout2)))
		   {
		   	 //print ("colonne 14=1  colonne15=1");
			 $colonne14=1; $colonne15=1;//addition a trou
			 $operande1=$op1; $operande2=$res; $resultatf=$op2;
			 $resultat_compf=calcul($operande2,"-",$operande1);
			 $etape2=true ;
		   }
	  else if (($question=='p')and($etape) and(($op1.$op.$op2."=".$res)==($op1."+".$resultat."=".$tout2)))
		   {
		   	 //print ("colonne 14=1  colonne15=1");
			 $colonne14=1; $colonne15=1;//addition a trou
			 $operande1=$op2; $operande2=$res; $resultatf=$op1;
			 $resultat_compf=calcul($operande2,"-",$operande1);
			 $etape2=true ;
		   }
	  else if (($question=='p')and ($etape)and(($op1.$op.$op2."=".$res)==($tout2."-".$resultat."=".$res)))
		   {
			 //print (" colonne 14=1  colonne15=2 ");
			 $colonne14=1; $colonne15=2;
			 $operande1=$op1; $operande2=$op2; $resultatf=$res;
			 $resultat_compf=calcul($operande1,$op,$operande2);
			 $etape2=true ;
		   }
	  else if (($question=='p')and ($etape)and(($op1.$op.$op2."=".$res)==($resultat."-".$tout2."=".$res)))
		   {
			 //print (" colonne 14=1  colonne15=3 ");
			 $colonne14=1; $colonne15=3;
			 $operande1=$op1; $operande2=$op2; $resultatf=$res;
			 $resultat_compf=$partie3;
			 $etape2=true ;
		   }
	   else if (($question=='p')and($etape)and(($op1.$op.$op2."=".$res)==($tout2."-".$res."=".$resultat)) and end($tabNombre)==$op2)
		   {
			 //print (" colonne 14=1  colonne15=3 ");
			 $colonne14=1; $colonne15=71;
			 $operande1=$op1; $operande2=$res; $resultatf=$op2;
			 $resultat_compf=$partie3;
			 $etape2=true ;
		   }
	  else if (($question=='t') and ($etape) and ($resultat!=$tout1) and((($op1.$op.$op2."=".$res)==($resultat."+".$partie3."=".$res)) ||
	  		   (($op1.$op.$op2."=".$res)==($partie3."+".$resultat."=".$res))))
			{
			 //print (" colonne 14=2  colonne15=4 ");
			 $colonne14=2; $colonne15=4; 
			 if ($resultat==$partie2) $colonne16=0; 
			 $operande1=$op1; $operande2=$op2; $resultatf=$res;
			 $resultat_compf=calcul($operande1,$op,$operande2);
			 $etape2=true;
			}
     else if (($question=='t') and ($op1.$op.$op2."=".$res)==($tout1."-".$partie3."=".$res))
			{
			 //print (" colonne 14=2  colonne15=4 ");
			 if (count($tabOperation)==1)
			    {$colonne2=9;$colonne3=9;$colonne4=9;$etape1=false;$etape=false;}
			 $colonne14=5; $colonne15=2;
			 $operande1=$op1; $operande2=$op2; $resultatf=$res;
			 $resultat_compf=calcul($operande1,$op,$operande2);
			 $etape2=true ;
			}
	 else if (($question=='p') and ($op1.$op.$op2."=".$res)==($tout1."-".$partie3."=".$res))
			{
			 if (count($tabOperation)==1)
			    {$colonne2=9;$colonne3=9;$colonne4=9;$etape1=false;$etape=false;}
			 $colonne14=5; $colonne15=2;
			 $operande1=$op1; $operande2=$op2; $resultatf=$res;
			 $resultat_compf=calcul($operande1,$op,$operande2);
			 $etape2=true ;
			}
	 

/* ------------------- cas par difference --------------------- */
	 else if ((($question=='t')and($diff)) and ((($op1.$op.$op2."=".$res)==($resultatd."+".$partie1."=".$res))
	 		 ||(($op1.$op.$op2."=".$res)==($partie1."+".$resultatd."=".$res))))
	 		{
			 //print (" colonne 14=3  colonne15=4 ");
			 $colonne14=3; $colonne15=4;
			 $operande1=$op1; $operande2=$op2; $resultatf=$res;
			 $resultat_compf=calcul($operande1,$op,$operande2);
			 $difference2=true ; //$etape=false;$etape1=false;
			}
	else if ((($question=='p')and($diff)and($tout1>$tout2)) and ((($op1.$op.$op2."=".$res)==($partie1."-".$resultatd."=".$res))))
	 		{
			 //print (" colonne 14=3  colonne15=2 ");
			 $colonne14=3; $colonne15=2;
			 $operande1=$op1; $operande2=$op2; $resultatf=$res;
			 $resultat_compf=calcul($operande1,$op,$operande2);
			 $difference2=true ; //$etape=false;$etape1=false;
			}
	else if ((($question=='p')and($diff)and($tout2>$tout1))
			and ((($op1.$op.$op2."=".$res)==($partie1."+".$resultatd."=".$res)||($op1.$op.$op2."=".$res)==($resultatd."+".$partie1."=".$res))))
	 		{
			 //print (" colonne 14=3  colonne15=2 ");
			 $colonne14=3; $colonne15=4;
			 $operande1=$op1; $operande2=$op2; $resultatf=$res;
			 $resultat_compf=calcul($operande1,$op,$operande2);
			 $difference2=true ;
			}
			
	else if ((($question=='t')and($diff)and($partie3>$partie1)) and (($op1.$op.$op2."=".$res)==($resultatd."+".$tout1."=".$res)
	 		 ||($op1.$op.$op2."=".$res)==($tout1."+".$resultat."=".$res)))
	 		{
			$colonne14=3; $colonne15=4;
			 $operande1=$op1; $operande2=$op2; $resultatf=$res;
			 $resultat_compf=calcul($operande1,$op,$operande2);
			 $difference2=true ; //$etape=false;$etape1=false;
			}
	else if ((($question=='t')and($diff)and($partie3<$partie1)) and (($op1.$op.$op2."=".$res)==($resultatd."-".$tout1."=".$res)
	 		 ||($op1.$op.$op2."=".$res)==($tout1."-".$resultat."=".$res)))
	 		{
			 //print (" colonne 14=3  colonne15=2 ");
			 $colonne14=3; $colonne15=2;
			 $operande1=$op1; $operande2=$op2; $resultatf=$res;
			 $resultat_compf=calcul($operande1,$op,$operande2);
			 $difference2=true ; //$etape=false;$etape1=false;
			}
	else if (((($question=='t')and($partie3<$partie1)) and (($op1.$op.$op2."=".$res)==($valdiff."-".$tout1."=".$res)
			 ||($op1.$op.$op2."=".$res)==($tout1."-".$valdiff."=".$res)))and(count($tabOperation)==1))
			{
			 //print (" colonne 14=3  colonne15=2 ");
			 $colonne10=0;$colonne11=9;$colonne12=0;$diff=true;$difference=true;$resultatd=$valdiff;
			 $colonne14=3; $colonne15=2;
			 $operande1=$op1; $operande2=$op2; $resultatf=$res;
			 $resultat_compf=calcul($operande1,$op,$operande2);
			 $difference2=true ;//$etape=false;$etape1=false;
			}
	else if ((($question=='t')and ((($op1.$op.$op2."=".$res)==($valdiff."+".$partie1."=".$res))
			 ||(($op1.$op.$op2."=".$res)==($partie1."+".$valdiff."=".$res))))and(count($tabOperation)==1))
			{
			 //print (" colonne 14=3  colonne15=4 ");
			 $colonne10=9;$colonne11=9;$colonne12=9;$diff=true;$difference=true;$resultatd=$valdiff;
			 $colonne14=3; $colonne15=4;
			 $operande1=$op1; $operande2=$op2; $resultatf=$res;
			 $resultat_compf=calcul($operande1,$op,$operande2);
			 $difference2=true ; //$etape=false;$etape1=false;
			}
	else if ((($question=='p') and ((($op1.$op.$op2."=".$res)==($partie1."-".$valdiff."=".$res))))and(count($tabOperation)==1))
			{
			 //print (" colonne 14=3  colonne15=2 ");
			 $colonne10=0;$colonne11=9;$colonne12=0;$diff=true;$difference=true;$resultatd=$valdiff;
			 $colonne14=3; $colonne15=2;
			 $operande1=$op1; $operande2=$op2; $resultatf=$res;
			 $resultat_compf=calcul($operande1,$op,$operande2);
			 $difference2=true ; //$etape=false;$etape1=false;
			}
	else if (($op1.$op.$op2."=".$res)==($partie1."-".$op2."=".$res) and (count($tabOperation)==1)and !isset($colonne14))
		{
			$operande1=$op1; $operande2=$op2; $resultatf=$res;
			$colonne1 =4; $colonne2=9;$colonne3=9;$colonne4=9;$colonne5=9;$colonne6=9;$colonne7=9;
			$colonne8=9;$colonne9=9;$colonne10=9;$colonne11=9;$colonne12=9;$colonne13=9;
			$colonne14=5;
			if($op1>$op2) $colonne15=2;
			else $colonne15=72;//soustraction inveser
			$colonne16=1;
			$resultat_compf=calcul($operande1,"-",$operande2);$etape1=false;$difference2=false ;
		}
/* ------------------- fin  difference --------------------- */
	else if ((($question=='p')and($diff) and ($tout2>$tout1)and((($op1.$op.$op2."=".$res)==($resultat."+".$tout2."=".$res))||(($op1.$op.$op2."=".$res)==($tout2."+".$resultat."=".$res))))
			||(($question=='p')and((($op1.$op.$op2."=".$res)==($resultat."+".$tout2."=".$res))||(($op1.$op.$op2."=".$res)==($tout2."+".$resultat."=".$res)))))		

			{
			 //print (" colonne 14=4  colonne15=4 ");
			 $colonne14=4; $colonne15=4;$colonne16=1;
			 $operande1=$op1; $operande2=$op2; $resultatf=$res;
			 $resultat_compf=abs(calcul($operande1,$op,$operande2)); 
			 }
	else if (($question=='t')and((($op1.$op.$op2."=".$res)==($resultat.$op.$partie3."=".$res))||(($op1.$op.$op2."=".$res)==($partie3.$op.$resultat."=".$res))))
	 		{
			 //print (" colonne 14=4  colonne15=3 ");
			 $operande1=$op1; $operande2=$op2; $resultatf=$res;
			 if (($operande1 >= $operande2) and ($op=="-"))
			 	$colonne15=2;
			 else if (($operande1 < $operande2) and ($op=="-"))
			 	$colonne15=3;
			 else if ($op=="+")
			 	$colonne15=4;
			 $colonne14=4;$colonne16=1;
			 
			 $resultat_compf=abs(calcul($operande1,$op,$operande2));
			 }
	 else if (($NonPertinent)and((($op1.$op.$op2."=".$res)==($partie1."+".$tout1."=".$res))||(($op1.$op.$op2."=".$res)==($tout1."+".$partie1."=".$res))))
	{		if(count($tabOperation)==1)
			{
			  $colonne2= 9; $colonne3=9;$colonne4=9;
			}
			 $colonne14=5; $colonne15=4;$colonne16=1;
			 $operande1=$op1; $operande2=$op2; $resultatf=$res;
			 $resultat_compf=calcul($operande1,$op,$operande2);
			 $etape2=true ;
	}
	 else if (((($op1.$op.$op2."=".$res)==($resultat."*".$tout2."=".$res))||(($op1.$op.$op2."=".$res)==($resultat.":".$tout2."=".$res))||
			  (($op1.$op.$op2."=".$res)==($tout2."*".$resultat."=".$res))||(($op1.$op.$op2."=".$res)==($tout2.":".$resultat."=".$res))) and ($etape))
			{
			// print (" colonne 14=5  colonne15=8 ");
			 $colonne14=5; $colonne15=8;
			 $operande1=$op1; $operande2=$op2; $resultatf=$res;
			 $resultat_compf=calcul($operande1,$op,$operande2);
			 $etape2=true ;
			}

	 else if ((($op1.$op.$op2."=".$res)==($resultat."*".$partie3."=".$res))||(($op1.$op.$op2."=".$res)==($resultat.":".$partie3."=".$res))||
			  (($op1.$op.$op2."=".$res)==($partie3."*".$resultat."=".$res))||(($op1.$op.$op2."=".$res)==($partie3.":".$resultat."=".$res)))
			{
			 //print (" colonne 14=5  colonne15=8 ");
			 $colonne14=5; $colonne15=8;$etape=false;
			 $operande1=$op1; $operande2=$op2; $resultatf=$res;
			 $resultat_compf=calcul($operande1,$op,$operande2);
			 $etape2=true ;
			}
	else if ((($question=='t')and(count($tabOperation)>1)and
				((($op1.$op.$op2."=".$res)==($partie1."+".$partie3."=".$res))||
				(($op1.$op.$op2."=".$res)==($partie3."+".$partie1."=".$res))||
				(($op1.$op.$op2."=".$res)==($partie1."+".$tout1."=".$res))||
				(($op1.$op.$op2."=".$res)==($tout1."+".$partie1."=".$res))||
				(($op1.$op.$op2."=".$res)==($partie3."+".$tout1."=".$res))||
				(($op1.$op.$op2."=".$res)==($tout1."+".$partie3."=".$res))))
			||
			(($question=='p')and (count($tabOperation)>1)and
				((($op1.$op.$op2."=".$res)==($partie1."+".$tout2."=".$res))||	
				(($op1.$op.$op2."=".$res)==($tout2."+".$partie1."=".$res))||
				(($op1.$op.$op2."=".$res)==($partie1."+".$tout1."=".$res))||
				(($op1.$op.$op2."=".$res)==($tout1."+".$partie1."=".$res))||
				(($op1.$op.$op2."=".$res)==($tout2."+".$tout1."=".$res))||
				(($op1.$op.$op2."=".$res)==($tout1."+".$tout2."=".$res)))))
	 		{
			 //print (" colonne 14=5  colonne15=4 ");
			  $colonne14=5; $colonne15=4; $colonne16=1;//
			  if (!$etape) $NonPertinent=true;
			 $operande1=$op1; $operande2=$op2; $resultatf=$res;
			 $resultat_compf=abs(calcul($operande1,$op,$operande2));
			}
            /* else if (($question=='t')and(($op1.$op.$op2."=".$res)==($resultat."+".$op2."=".$res)))
	 		{
			 //print (" colonne 14=5 colonne15=1 ");
			 $colonne14=5; $colonne15=1;
			 $operande1=$res; $operande2=$op1; $resultatf=$op2;
			 $resultat_compf=abs(calcul($operande1,"-",$operande2));
			 } */
	else if ((!$etape and !$exclusion1) and ((($op1.$op.$op2."=".$res)==($partie2."+".$partie3."=".$res))||
	(($op1.$op.$op2."=".$res)==($partie3."+".$partie2."=".$res))and($question=='t')))
			{
			 $etape=true; $colonne2=0; $colonne3=9; $colonne4=0; $colonne14=2; $colonne15=4;
			 $operande1=$op1; $operande2=$op2; $resultatf=$res;
			 $resultat_compf=abs(calcul($operande1,$op,$operande2));
			}
	else if (($question=='p')and(!$etape and !$exclusion1)and(($op1.$op.$op2."=".$res)==($tout2."-".$partie2."=".$res)))
			{
			 $etape=true; $colonne2=0; $colonne3=9; $colonne4=0; $colonne14=1; $colonne15=2;
			 $operande1=$op1; $operande2=$op2; $resultatf=$res;
			 $resultat_compf=abs(calcul($operande1,$op,$operande2));
			}
	else if (($op1.$op.$op2."=".$res) and ($op=='-')and($op1<$op2)and(!$imp3)and(!$etape))
			{
			 $colonne14=5; $colonne15=3;
			 $operande1=$op1; $operande2=$op2; $resultatf=$res;
			 $resultat_compf=abs(calcul($operande1,$op,$operande2));
			 $etape2=true ; $colonne16=1;$NonPertinent=true;
			}
	else if (($op1.$op.$op2."=".$res) and(!$NonPertinent) and (count($tabOperation)>1)and(count($T1)==1))
   		   {
		   	   $colonne14=5;
				 if ($colonne15==8)
				 	$colonne15=8;
				 else if (($op=='+') and ($addTrou))
					$colonne15=1;
				else  if ($op=='+')
					$colonne15=4;
				 else if ($op=='-')
					 $colonne15=2;
				 else
					$colonne15=7;
			 if(count($tabOperation)==1)
			 {
				  if($op1==$partie2 || $op2==$partie2)
				  {
				  $colonne2=0;$colonne3=9;$colonne4=0;$etape=true;
				  }
				  if($op1==$valdiff || $op2==$valdiff)
				  {
				  $colonne10=0;$colonne11=9;$colonne12=0;$diff=true;$difference=true;
				  }
			 }
			 $operande1=$op1; $operande2=$op2; $resultatf=$res;
			 $resultat_compf=calcul($operande1,$op,$operande2);
			 $etape2=true ; $colonne16=1;
			}
	else if (($op1.$op.$op2."=".$res) and(!$NonPertinent) and ($diff) and (count($tabOperation)==1)and(count($T1)==1))
   		   {
		   $colonne14=3;
				 if ($op=='+')
					$colonne15=4;
				 else if ($op=='-')
					 $colonne15=2;
      		 $colonne10=9;$colonne11=9;$colonne12=9;
			 $operande1=$op1; $operande2=$op2; $resultatf=$res;
			 $resultat_compf=calcul($operande1,$op,$operande2);
			 $etape2=true ; $colonne16=1;$colonne1=2;
			}
	else if ((count($tabImp)!=0)and(count($tabOperation)==0)and
			 ((($question=="t")and(!ereg("$partie2|$valdiff|$tout2",$tabImp[0])))||(($question=="p")and(!ereg("$partie2|$valdiff|$partie3",end($tabImp))))))
 		{
		 $colonne14=0;$colonne15=0;$colonne16=9; $colonne17=9; $colonne1=6;
		}
   else if (($etape) and (count($tabOperation)==1) and (!isset($tabImp))and($colonne2==1||$colonne2==2||$colonne2==3||$colonne2==7))
	{
		$colonne17=$colonne4;
		  if ($question=='t')
			$colonne14=1;
		  else if ($question=='p')
			$colonne14=1;
		if ($colonne2==1) $colonne15=1;
		else if (($colonne2==2)||($colonne2==7)) $colonne15=2;
		else if ($colonne2==3) $colonne15=3;
		$colonne16=1;$NonPertinent=true;
		$colonne2=9;$colonne3=9;$colonne4=9;$etape=false;$etape1=false;
	}
  else if (($op1.$op.$op2."=".$res)and(count($T1)==1)and($colonne14!=0))
   		   {
			 $colonne14=5;
				 if ($colonne15==8)
				 	$colonne15=8;
				 else if (($op=='+') and ($addTrou))
					$colonne15=1;
				 else if ($op=='+')
					$colonne15=4;
				 else if (($op=='-')and($op1<$op2))
					 $colonne15=3;
				 else if ($op=='-')
					 $colonne15=2;
				 else
					$colonne15=7;
			 $operande1=$op1; $operande2=$op2; $resultatf=$res;
			 $resultat_compf=abs(calcul($operande1,$op,$operande2));
			 $etape2=true ;$colonne16=1;
			}
 else if ((count($tabOperation)==1) and ($res!=end($tabNombre)) and (($resultat!=end($tabNombre) and $etape)||($resultatd!=end($tabNombre) and $difference)))
		{
		 	 $colonne14=0; $colonne15=0;
			 if(($question=='t' and end($tabImp)==$tout2)||($question=='p' and end($tabImp)==$partie3))
			 {
				$colonne16=9; $colonne17=0; $imp3=true;$etape2=true ;
			 }
			 else 
			 {
				$tabImp[]=end($tabNombre);
				$colonne16=8; $colonne17=8; $imp3=true;
				print_r($tabImp);
			 }
		}
else if ($question=='p' and ($op1.$op.$op2."=".$res)==($partie1."-".$tout2."=".$res))
{
	$colonne14=43;$colonne15=3;$colonne16=1;
	$operande1=$op1; $operande2=$op2; $resultatf=$res;
	$resultat_compf=abs(calcul($operande1,$op,$operande2));
}
else if ($question=='p' and ($op1.$op.$op2."=".$res)==($tout2."-".$partie1."=".$res) and count($tabOperation)==1)
{
	if($res==end($tabNombre))
	{
	$colonne14=43;$colonne15=2;$colonne16=1;
	$operande1=$op1; $operande2=$op2; $resultatf=$res;
	$resultat_compf=abs(calcul($operande1,$op,$operande2));
	}
	else 
	{//revoir ce cas. calcul implicite comme réponse à la question finale
	
	$colonne2=2;$colonne3=1;
	$operande1=$op1; $operande2=$op2; $resultatf=$res;
	$resultat_comp=abs(calcul($operande1,$op,$operande2));
	if($resultat_comp==$res) $colonne4=0;
	else if($resultat_comp!=$res) $colonne4=1;
	
	if (end($tabNombre)==$partie3)
		{$colonne14=0;$colonne15=0;$colonne16=9;$colonne17=0;}
	else
		{$colonne14=0;$colonne15=0;$colonne16=8;$colonne17=8;}
	}
}
else if ($question=='p' and ($op1.$op.$op2."=".$res)==($partie1."+".$op2."=".$tout2) and $op2==end($tabNombre))
{
	$colonne14=43;$colonne15=1;$colonne16=1;
	$operande1=$op1; $operande2=$res; $resultatf=$op2;
	$resultat_compf=abs(calcul($operande1,"-",$operande2));
}
else if ($question=='p' and ($op1.$op.$op2."=".$res==$op1."+".$tout2."=".$res || $op1.$op.$op2."=".$res==$tout2."+".$op2."=".$res))
{
	$colonne14=5;$colonne15=4;$colonne16=1;
	$operande1=$op1; $operande2=$op2; $resultatf=$res;
	$resultat_compf=abs(calcul($operande1,"-",$operande2));
}
/*================= colonne 16 pertinence des données de l'operation==============*/
	
	 if ($colonne16==4)
	 {
	 	$colonne16=4;
	 }
	else if ($colonne16==1)
	{
		$colonne16=1;
	}
	else if ($colonne16==8)
	{
		$colonne16=8;
	}
	 else if ($colonne16==9 and $colonne14==0)
	 {
	 	$colonne16==9;
	 }
	 else if ($colonne16==9)
	 {
	 	$colonne16==9;
	 }
	 else if (
	 /* 			 (($operande1==$tout2)and($operande2==$resultat)and(($colonne4==1)||($colonne8==1)||($colonne12==1)))||
				 (($operande1==$resultat)and($operande2==$tout2)and(($colonne4==1)||($colonne8==1)||($colonne12==1)))||
				 (($operande1==$partie3)and($operande2==$resultat)and(($colonne4==1)||($colonne8==1)||($colonne12==1)))||
				 (($operande1==$resultat)and($operande2==$partie3)and(($colonne4==1)||($colonne8==1)||($colonne12==1)))||
				 (($operande1==$tout1)and($operande2==$resultatd)and(($colonne4==1)||($colonne8==1)||($colonne12==1)))||
				 (($operande1==$resultatd)and($operande2==$tout1)and(($colonne4==1)||($colonne8==1)||($colonne12==1)))||
				 (($operande1==$partie1)and($operande2==$resultatd)and(($colonne4==1)||($colonne8==1)||($colonne12==1)))||
				 (($operande1==$resultatd)and($operande2==$partie1)and(($colonne4==1)||($colonne8==1)||($colonne12==1)))
			 */
			($colonne4==1)||($colonne8==1)||($colonne4==8)||($colonne8==8)||($colonne12==1) ||($colonne12==8)

		)
	  {
	  	$colonne16=2; //print(" colonne16=2 ");
	  }
	 else  if (
				/* (($operande1==$tout2)and($operande2==$resultat)and(($colonne4==2)||($colonne8==2)||($colonne12==2)))||
				 (($operande1==$resultat)and($operande2==$tout2)and(($colonne4==2)||($colonne8==2)||($colonne12==2)))||
				 (($operande1==$partie3)and($operande2==$resultat)and(($colonne4==2)||($colonne8==2)||($colonne12==2)))||
				 (($operande1==$resultat)and($operande2==$partie3)and(($colonne4==2)||($colonne8==2)||($colonne12==2)))||

				 (($operande1==$tout1)and($operande2==$resultatd)and(($colonne4==2)||($colonne8==2)||($colonne12==2)))||
				 (($operande1==$resultatd)and($operande2==$tout1)and(($colonne4==2)||($colonne8==2)||($colonne12==2)))||
				 (($operande1==$partie1)and($operande2==$resultatd)and(($colonne4==2)||($colonne8==2)||($colonne12==2)))||
				 (($operande1==$resultatd)and($operande2==$partie1)and(($colonne4==2)||($colonne8==2)||($colonne12==2))) */
				(($colonne4==2 and $etape )||($colonne12==2 and $diff))and($etape2)
			 )
	  {
	  $colonne16=3; //print(" colonne16=3");
	  }
	 else if (

				 (($question=='p')and($operande1==$tout2)and($operande2==$resultat)and($colonne2!=5))||
				 (($question=='p')and($operande1==$resultat)and($operande2==$tout2)and($colonne2!=5))||
				 (($question=='t')and($operande1==$partie3)and($operande2==$resultat)and($colonne2!=5))||
				 (($question=='t')and($operande1==$resultat)and($operande2==$partie3)and($colonne2!=5))||

				 (($question=='t')and($operande1==$tout1)and($operande2==$resultatd)and($colonne2!=5))||
				 (($question=='t')and($operande1==$resultatd)and($operande2==$tout1)and($colonne2!=5))||
				 (($question=='p')and($operande1==$partie1)and($operande2==$resultatd)and($colonne2!=5))||
				 (($question=='p')and($operande1==$resultatd)and($operande2==$partie1)and($colonne2!=5))||

				 (($question=='t')and($operande1==$tout1)and($operande2==$resultat)and($colonne2!=5))||
				 (($question=='t')and($operande1==$resultat)and($operande2==$tout1)and($colonne2!=5))||
				 (($question=='p')and($operande1==$partie1)and($operande2==$resultat)and($colonne2!=5))||
				 (($question=='p')and($operande1==$resultat)and($operande2==$partie1)and($colonne2!=5))

			 )
	  {
	  	$colonne16=0; //print(" colonne16=0 ");
	  }
	 else if ((($question=='t')and (($operande1==$partie2)and($operande2==$partie3)) || (($operande2==$partie3)and($operande2==$partie2)))
	           ||(($question=='p')and($operande1==$tout2)and($operande2==$partie2)))
	  {
	  	$colonne16=0; //print(" colonne16=1 ");
	  }
	 else if ((($question=='t')and (($operande1==$tout1)and($operande2==$partie3)) || (($operande2==$partie3)and($operande2==$tout1)))
	 ||((($question=='p')and($difference2))and (($operande1==$tout1)xor($operande2==$resultatd)) || (($operande2==$resultatd)xor($operande2==$tout1))))
	  {
	  	$colonne16=1; //print(" colonne16=1 ");
	  }
	  else if (((($question=='t')and($difference2))and (($operande1==$partie1)xor($operande2==$resultatd)) || (($operande2==$resultatd)xor($operande2==$partie1)))
	         ||((($question=='p')and($difference2))and (($operande1==$tout1)xor($operande2==$resultatd)) || (($operande2==$resultatd)xor($operande2==$tout1))))
	  {
	  	$colonne16=1; //print(" colonne16=1 ");
	  }
	 else if (((($question=='t')and (($operande1==$partie3)xor($operande2==$resultat)) || (($operande2==$resultat)xor($operande2==$partie3)))
	         ||(($question=='p')and (($operande1==$tout2)xor($operande2==$resultat)) || (($operande2==$resultat)xor($operande2==$tout2))))||($colonne16==1))
	  {

		$colonne16=1; //print(" colonne16=1 ");
	  }
	 else if ((($colonne14==9)||($colonne14==0)) and (!(ereg("[0-8]",$colonne17))))
		{
			$colonne16=9; //print(" colonne16=9 ");
		}
	 else if ((($operande1==$tout2)||($operande1==$resultat)||($operande1==$partie3))&&(($operande2==$tout2)||($operande2==$partie3)||($operande2==$resultat)))
	  	{
			$colonne16=0; //print(" colonne16=0 ");
		}
	 else if (($colonne4==1)||($colonne8==1)||($colonne12==1))
		{
			$colonne16=2;//print(" colonne16=2 ");
		}

	if ((($question=='t')and (($operande1==$partie2)and($operande2==$partie3)) || (($operande2==$partie3)and($operande2==$partie2)))
	           ||(($question=='p')and($operande1==$tout2)and($operande2==$partie2)))
	  {
	  	$colonne16=0; //print(" colonne16=1 ");
	  }
	  /*else if ((($operande1==$tout2)xor($operande2==$resultat))||(($operande2==$tout2)xor($operande1==$resultat))||
	          (($operande1==$partie3)xor($operande2==$resultat))||(($operande2==$partie3)xor($operande2==$resultat)))
		{
			 $colonne16=2; //print(" colonne16=2 ");
		} else if (($colonne4==2)||($colonne8==2)||($colonne12==2))
		{
			 $colonne16=3; //print(" colonne16=3 ");
		}*/
/* --------------  cas d'une opartation a trois operande -----------------------*/
if (count($tabOperation2 >= 1))
{
if (count ($T1)==2 )
{
	$op1=$T2[0]; $op2=$T2[1]; $op3=$T2[2] ; $res=$T2[3];
	$op=$T1[0];$oper=$T1[1];
	//if ($T2[3]!="")
	//print ("<br>l'operation est : ".$op1.$op.$op2.$oper.$op3."=".$res."<br>");
	if ((($question=='t')and($T1[0]=="+")and($T1[1]=="+")and(in_array($partie1,$T2))and(in_array($tout1,$T2))and(in_array($partie3,$T2))) ||
	   (($question=='p')and($T1[0]=="+")and($T1[1]=="+")and(in_array($partie1,$T2))and(in_array($tout1,$T2))and(in_array($tout2,$T2))))
	{
	 //print (" colonne 14=5  colonne15=5 ");

	 $colonne1=4;$colonne2=9;$colonne3=9;$colonne4=9;$colonne5=9;$colonne6=9;$colonne7=9;
	 $colonne8=9;$colonne9=9;$colonne10=9;$colonne11=9;$colonne12=9;$colonne13=9;
	 $colonne14=5; $colonne15=5;$colonne16=1;
	 $etape=false; $etape1=false; $diff=false; $difference=false; $difference2=false;$etape2=false ;
	 $operande1=$op1; $operande2=$op2; $operande3=$op3; $resultatf=$res;
	 $resultat_compf=$op1+$op2+$op3;
	}
	else if (($T1[0]=="+")and($T1[1]=="+")and((in_array($valdiff,$T2))or(in_array($partie2,$T2))))
	{
	 //print (" colonne 14=5  colonne15=5 ");
	 $colonne1=4;$colonne2=9;$colonne3=9;$colonne4=9;$colonne5=9;$colonne6=9;$colonne7=9;
	 $colonne8=9;$colonne9=9;$colonne10=9;$colonne11=9;$colonne12=9;$colonne13=9;
	 $colonne14=5; $colonne15=8;$colonne16=1;
	 $etape=false; $etape1=false; $diff=false; $difference=false; $difference2=false;$etape2=false ;
	 	if(in_array($partie2,$T2))
		 	{$colonne1=1;$colonne2=0;$colonne3=9;$colonne4=0;$colonne15=4;$etape=true;}
		  else if(in_array($valdiff,$T2))
		 	{$colonne10=0;$colonne11=9;$colonne12=0;}
	 $operande1=$op1; $operande2=$op2; $operande3=$op3; $resultatf=$res;
	 $resultat_compf=$op1+$op2+$op3;
	}
	else if ((($question=='t')and(($T1[0]=="*")and($T1[1]=="*")and(in_array($partie1,$T2))and(in_array($tout1,$T2))and(in_array($partie3,$T2))))||
	(($question=='p')and(($T1[0]=="*")and($T1[1]=="*")and(in_array($partie1,$T2))and(in_array($tout1,$T2))and(in_array($tout2,$T2)))))
	{
	 //print (" colonne 14=5  colonne15=5 ");
	 $colonne1=4;$colonne2=9;$colonne3=9;$colonne4=9;$colonne5=9;$colonne6=9;$colonne7=9;
	 $colonne8=9;$colonne9=9;$colonne10=9;$colonne11=9;$colonne12=9;$colonne13=9;
	 $colonne14=5; $colonne15=6;$colonne16=1;
	 $etape=false; $etape1=false; $diff ; $difference=false; $difference2=false;$etape2=false ;
	 $operande1=$op1; $operande2=$op2; $operande3=$op3; $resultatf=$res;
	 $resultat_compf=$op1*$op2*$op3;
	}
	else if ((($question=='t')and(($T1[0]==":")and($T1[1]==":")and(in_array($partie1,$T2))and(in_array($tout1,$T2))and(in_array($partie3,$T2))))||
	(($question=='p')and(($T1[0]==":")and($T1[1]==":")and(in_array($partie1,$T2))and(in_array($tout1,$T2))and(in_array($tout2,$T2)))))
	{
	 //print (" colonne 14=5  colonne15=5 ");
	 $colonne1=4;$colonne2=9;$colonne3=9;$colonne4=9;$colonne5=9;$colonne6=9;$colonne7=9;
	 $colonne8=9;$colonne9=9;$colonne10=9;$colonne11=9;$colonne12=9;$colonne13=9;
	 $colonne14=5; $colonne15=6;$colonne16=1;
	 $etape=false; $etape1=false; $diff =false; $difference=false; $difference2=false;$etape2=false ;
	 $operande1=$op1; $operande2=$op2; $operande3=$op3; $resultatf=$res;
	 $resultat_compf=$op1/$op2/$op3;
	}
	else if ((($question=='t')and((($op1.$op.$op2.$oper.$op3."=".$res)==($tout1."+".$partie3."-".$partie1."=".$res))||
	(($op1.$op.$op2.$oper.$op3."=".$res)==($partie3."+".$tout1."-".$partie1."=".$res)))))
	{
	 $colonne1=2;$colonne2=9;$colonne3=9;$colonne4=9;$colonne6=9;$colonne7=9;
	 $colonne8=9;$colonne9=9;$colonne10=2;$colonne11=0;$colonne12=9;$colonne13=9;
	 $colonne14=3; $colonne15=4;$colonne16=0;
	 $etape=false; $etape1=false; $diff=false; $difference=true; $difference2=true; $diff=true;$etape2=false ;
	 $operande1=$op1; $operande2=$op2; $operande3=$op3; $resultatf=$res;
	 $resultat_compf=$op1+$op2-$op3;
	}
	else if (($question=='t')and(($op1.$op.$op2.$oper.$op3."=".$res)==($tout1."-".$partie1."+".$partie3."=".$res)))
	{
	 $colonne1=1;$colonne2=2;$colonne3=0;$colonne4=9;$colonne6=9;$colonne7=9;
	 $colonne8=9;$colonne9=9;$colonne10=9;$colonne11=9;$colonne12=9;$colonne13=9;
	 $colonne14=2; $colonne15=4;$colonne16=0;
	 $etape=true; $etape1=true;  $diff=false; $difference=false; $difference2=false;$etape2=true ;
	 $operande1=$op1; $operande2=$op2; $operande3=$op3; $resultatf=$res;
	 $resultat_compf=$op1-$op2+$op3;
	}
  	else if ((($question=='t')and($partie3>$partie1))and((($op1.$op.$op2.$oper.$op3."=".$res)==($partie3."-".$partie1."+".$tout1."=".$res))
	||(($op1.$op.$op2.$oper.$op3."=".$res)==($tout1."+".$partie3."-".$partie1."=".$res))))
	{
	 $colonne1=2;$colonne2=9;$colonne3=9;$colonne4=9;$colonne6=9;$colonne7=9;
	 $colonne8=9;$colonne9=9;$colonne10=2;$colonne11=0;$colonne12=9;$colonne13=9;
	 $colonne14=3; $colonne15=4;$colonne16=0;
	 $etape=false; $etape1=false; $diff=false; $difference=true; $difference2=true;$diff=true;$etape2=false;
	 $operande1=$partie3; $operande2=$partie1; $operande3=$tout1; $resultatf=$res;
	 $resultat_compf=$op1-$op2+$op3;
	}
	else if ((($question=='t')and($partie3<$partie1))and((($op1.$op.$op2.$oper.$op3."=".$res)==($partie1."-".$partie3."+".$tout1."=".$res))
	||(($op1.$op.$op2.$oper.$op3."=".$res)==($tout1."+".$partie1."-".$partie3."=".$res))))
	{
	 $colonne1=2;$colonne2=9;$colonne3=9;$colonne4=9;$colonne6=9;$colonne7=9;
	 $colonne8=9;$colonne9=9;$colonne10=2;$colonne11=0;$colonne12=9;
	 $colonne14=3; $colonne15=4;$colonne16=0;
	 $etape=false; $etape1=false;  $diff=false; $difference=true; $difference2=true;$diff=true;$etape2=false;
	 $operande1=$partie1; $operande2=$partie3; $operande3=$tout1; $resultatf=$res;
	 $resultat_compf=$op1-$op2+$op3;
	}
	else if ((($question=='p')and($tout2>$tout1))and((($op1.$op.$op2.$oper.$op3."=".$res)==($tout2."-".$tout1."+".$partie1."=".$res))
	||(($op1.$op.$op2.$oper.$op3."=".$res)==($partie1."+".$tout2."-".$tout1."=".$res))))
	{
	 $colonne1=2;$colonne2=9;$colonne3=9;$colonne4=9;$colonne6=9;$colonne7=9;
	 $colonne8=9;$colonne9=9;$colonne10=2;$colonne11=0;$colonne12=9;
	$colonne14=3; $colonne15=4;$colonne16=0;
	 $etape=false; $etape1=false; $diff=false; $difference=true; $difference2=true; $diff=true;$etape2=false;
	 $operande1=$tout2; $operande2=$tout1; $operande3=$partie1; $resultatf=$res;
	 $resultat_compf=$op1-$op2+$op3;
	}
	else if ((($question=='p')and($tout2<$tout1))and((($op1.$op.$op2.$oper.$op3."=".$res)==($tout1."-".$tout2."+".$partie1."=".$res))
	||(($op1.$op.$op2.$oper.$op3."=".$res)==($partie1."+".$tout1."-".$tout2."=".$res))))
	{
	 $colonne1=2;$colonne2=9;$colonne3=9;$colonne4=9;$colonne6=9;$colonne7=9;
	 $colonne8=9;$colonne9=9;$colonne10=2;$colonne11=0;$colonne12=9;
	 $colonne14=3; $colonne15=4;$colonne16=0;
	 $etape=false; $etape1=false;  $diff=false; $difference=true; $difference2=true;$etape2=false;
	 $operande1=$tout1; $operande2=$tout2; $operande3=$partie1; $resultatf=$res;
	 $resultat_compf=$op1-$op2+$op3;
	}
	else

	{
	 $colonne1=4;$colonne2=9;$colonne3=9;$colonne4=9;$colonne6=9;$colonne7=9;
	 $colonne8=9;$colonne9=9;$colonne10=9;$colonne11=9;$colonne12=9;$colonne13=9;
	 $colonne14=5; $colonne15=6;$colonne16=1;
	 $etape=false; $etape1=false; $diff=false; $difference=false; $difference2=false;$etape2=false;
	 $operande1=$op1; $operande2=$op2; $operande3=$op3; $resultatf=$res;
	 if (($op=="-") and ($oper=="-"))
	 $resultat_compf=$op1-$op2-$op3;
	 else  if (($op=="-") and ($oper=="+"))
	 $resultat_compf=$op1-$op2+$op3;
	 else if (($op=="+") and ($oper=="-"))
	 $resultat_compf=$op1+$op2-$op3;
	}
}
else if ((count($T1)==3 || count($T1)==4)and(end($tabOperation2)==$operation_f))
	{
	 $colonne1=4; $colonne2=9; $colonne3=9; $colonne4=9; $colonne14=5; $colonne15=8; $colonne16=1;
	 $etape=false; $etape1=false; $diff=false; $difference=false; $etape2=false ;$etape2=false;$NonPertinent=true;
	 $resultatf=end($T2);
     if ($T1[0]=="+")  $resultat_compf=$T2[0] + $T2[1];  else if($T1[0]=="-") $resultat_compf=$T2[0]- $T2[1];
	 if ($T1[1]=="+")  $resultat_compf=$resultat_compf + $T2[2];	 else if($T1[1]=="-") $resultat_compf=$resultat_compf- $T2[2];
	 if ($T1[2]=="+")  $resultat_compf=$resultat_compf + $T2[3];	 else if($T1[2]=="-") $resultat_compf=$resultat_compf - $T2[3];
	 if ($T1[3]=="+")  $resultat_compf=$resultat_compf + $T2[4];  else if($T1[3]=="-") $resultat_compf=$resultat_compf - $T2[4];
	}
}
/*----------------------------- fin if (count($tabOperation2 >= 1))---------------------------------*/
/*=============== colonne 17 exactitude du resultat du calcul=================*/
 if ($colonne17==8)
	{
	    $colonne17=8;
	}
else if ((($colonne15==9)||($resultatf==''))and (!(ereg("[0-8]",$colonne17))))
	{
	     $colonne17=9; //	print(" colonne17=9 ");
	}
else if (isset($resultatf) and ($resultatf==$resultat_compf))
	{
		 $colonne17=0; //print(" colonne17=0 ");
	}
else if (isset($resultatf) and (($resultatf==$resultat_compf-1)||($resultatf==$resultat_compf+1)))
	{
		$colonne17=1; //print(" colonne17=1 ");
	}
else if (isset($resultatf) and (($resultatf < $resultat_compf-1) ||($resultatf > $resultat_compf-1)))
	{
		 $colonne17=2; //print(" colonne17=2 ");
	}
//cas ou il y a plusieurs opération qui n'ont pas de place dans le codage colonne14=51
if(($colonne14=='5') and (ereg("[1-7]",$colonne2)) and (ereg("[1-7]",$colonne10)) and (count($tabOperation)-1>2)) 
{
$colonne14=51;
}
else if(($colonne14=='5') and (ereg("[1-7]",$colonne2)) and (!ereg("[1-7]",$colonne10)) and (count($tabOperation)-1==2)) 
{
$colonne14=51;
}
else if(($colonne14=='5') and (!ereg("[1-7]",$colonne2)) and (ereg("[1-7]",$colonne10)) and (count($tabOperation)-1==2)) 
{
$colonne14=51;
}
/*----------------- coder la stategie colonne 1 -----------------------*/
if(count($tabOperation)==0 and count($tabImp)==1 and $colonne14==0 and $colonne15==0 and $colonne17==9)
{
	$colonne1=6;
}
else if (($colonne1==4)||($NonPertinent))
{
	$colonne1=4;
}

else if ($colonne1==6)
{
	$colonne1=6;
}
else if ($varImp and count($tabOperation)==0 and count($tabImp)==1)//à revoire
{
	if(($question=='t' and $tabImp[0]==$tout2)||($question=='p' and $tabImp[0]==$partie3))
	{
		$colonne1=5;//print(" colonne1=5 ");
	}
}
else if (($etape) and ($diff))
{
	$colonne1=3; //print(" colonne1=3 ");
}
else if ((($etape1)and($etape2))||($etape))
 {
  $colonne1=1; //print(" colonne1=1 ");
 }
else if ((($diff)and($difference2))||($colonne1==2))
 {
  $colonne1=2; //print(" colonne1=2 ");
 }
else if (count($tabNombre)==0)
{
	$colonne1=9;//print(" colonne1=9 ");
}
else
{
	$colonne1=4;//print(" colonne1=4 ");
}
/*===========================colonne 18=========================
if (((end($tabImp)==$operande1)||(end($tabImp)==$operande2))and
	((($colonne14==0)||($colonne14==1)||($colonne14==2))and(($colonne15==0)||($colonne15==1)||($colonne15==2)||($colonne15==4))))
{
$colonne18=3;
}
else if ((($colonne17==0)and($colonne16==3))||(($colonne17==2)and(($colonne16==0)||($colonne16==2)||($colonne16==3)))
			and((($colonne14==0)||($colonne14==1)||($colonne14==2)))and($colonne15==0||$colonne15==1||$colonne15==2||$colonne15==4))
{
$colonne18=2;
}
else if (((($colonne17==0)and($colonne16==2))||(($colonne17==1)and(($colonne16==2)||($colonne16==0)))||((end($tabImp)!=$resultatf)))
			and((($colonne14==0)||($colonne14==1)||($colonne14==2)))and($colonne15==0||$colonne15==1||$colonne15==2||$colonne15==4))
{
$colonne18=1;
}
else if ((($colonne17==0)) and (($colonne16==0)||($colonne16==9))
	and(($colonne14==0)||($colonne14==1)||($colonne14==2))and(($colonne15==7)||($colonne15==8)||($colonne15==5)||($colonne15==6)))
{
$colonne18=5;
}
else if (($colonne17==0) and (($colonne16==0)||($colonne16==9))
	and(($colonne14==0)||($colonne14==1)||($colonne14==2))and($colonne15==0||$colonne15==1||$colonne15==2||$colonne15==4))
{
$colonne18=0;
}*/
if (!isset($colonne1) || !(ereg("[0-7]",$colonne1))) 
{for ($i=1;$i<=18;$i++) ${"colonne".$i}=9;}
if (!isset($colonne2) || !(ereg("[0-8]",$colonne2))) $colonne2=9;
if (!isset($colonne3) || !(ereg("[0-8]",$colonne3))) $colonne3=9;
if (!isset($colonne4) || !(ereg("[0-8]",$colonne4))) $colonne4=9;
if (!isset($colonne5) || !(ereg("[0-7]",$colonne5))) $colonne5=9;
if (!isset($colonne6) || !(ereg("[0-5]",$colonne6))) $colonne6=9;
if (!isset($colonne7) || !(ereg("[0-8]",$colonne7))) $colonne7=9;
if (!isset($colonne8) || !(ereg("[0-8]",$colonne8))) $colonne8=9;
if (!isset($colonne9) || !(ereg("[0-5]",$colonne9))) $colonne9=9;
if (!isset($colonne10) || !(ereg("[0-7]",$colonne10))) $colonne10=9;
if (!isset($colonne11) || !(ereg("[0-8]",$colonne11))) $colonne11=9;
if (!isset($colonne12) || !(ereg("[0-8]",$colonne12))) $colonne12=9;
if (!isset($colonne13) || !(ereg("[0-5]",$colonne13))) $colonne13=9;
if (!isset($colonne14) || !(ereg("[0-5]",$colonne14))) $colonne14=9;
if (!isset($colonne15) || !(ereg("[0-8]",$colonne15))) $colonne15=9;
if (!isset($colonne16) || !(ereg("[0-8]",$colonne16))) $colonne16=9;
if (!isset($colonne17) || !(ereg("[0-8]",$colonne17))) $colonne17=9;
if (!isset($colonne18) || !(ereg("[0-8]",$colonne18))) $colonne18=9;
$nbOper = count($tabOperation);
//print_r($tabOperation);
 /* print("<br>colonne1=".$colonne1." | colonne2=".$colonne2." | colonne3=".$colonne3.
		 " | colonne4=".$colonne4." | colonne10=".$colonne10." | colonne11=".$colonne11." | colonne12=".$colonne12.
		 " | colonne14=".$colonne14." | colonne15=".$colonne15." | colonne16=".$colonne16." | colonne17=".$colonne17
		 ." | colonne18=".$colonne18."<br>"); */
//exit ("ok");
$typeExo="e";
//$text=str_replace("'","\'",$text);
$text=addslashes($text);
/*_____________________________________________________________________________________*/
$Requete_SQL="INSERT INTO trace (numEleve,numSerie,numExo,typeExo,questInt,sas ,
				operation1, operation2, operande1, operande2,operande3,zonetext,resultat,actions) VALUES
				('".$_SESSION['numEleve']."','".$numSerie."','".$n."','".$typeExo."','".$questi."','".$sas."',
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


$Requete_SQL1="INSERT INTO diagnostic (numSerie,numTrace,numEleve,date,numExo,typeExo,question,var ,questInt,
				colonne1, colonne2, colonne3, colonne4,colonne5,colonne6, colonne7, colonne8, colonne9,colonne10,
				colonne11,colonne12,colonne13,colonne14,colonne15,colonne16,colonne17,colonne18,nbOper) VALUES
				('".$numSerie."','".$id."','".$_SESSION['numEleve']."','".$date."','".$n."','".$typeExo."','".$question."','".$var."','".$questi."',
				$colonne1,$colonne2,$colonne3,$colonne4,$colonne5, $colonne6,$colonne7,$colonne8,$colonne9,$colonne10,
				$colonne11,$colonne12,$colonne13,$colonne14,$colonne15,$colonne16,$colonne17,$colonne18,$nbOper)";

$result=mysql_query($Requete_SQL1) or die("Erreur d'Insertion dans la base : ". $Requete_SQL1 .'<br />'. mysql_error());
// Execution de la requete SQL.

 //mysql_close($BD_link);
?>
<?php
// ----------------------------------------------------------------------------
define("FORMAT_REEL",   1); // #,##0.00
define("FORMAT_ENTIER", 2); // #,##0
define("FORMAT_TEXTE",  3); // @

$cfg_formats[FORMAT_ENTIER]="FF0";
$cfg_formats[FORMAT_REEL]="FF2";
$cfg_formats[FORMAT_TEXTE]="FG0";

// ----------------------------------------------------------------------------
/* 
$cfg_hote='localhost';
$cfg_user='root';
$cfg_pass='';
$cfg_base='projet';
 */
// ----------------------------------------------------------------------------

//if (mysql_connect($BD_hote, $BD_login, $BD_pass))
//{
    // construction de la requête
    // ------------------------------------------------------------------------
    $sql="SELECT numSerie,numTrace,numEleve,date,numExo,typeExo,question,var ,questInt,colonne1, colonne2, colonne3, colonne4,colonne5,colonne6, colonne7, colonne8, colonne9,colonne10,colonne11,colonne12,colonne13,colonne14,colonne15,colonne16,colonne17,colonne18 ";
    $sql .= "FROM diagnostic ";
    $sql .= "WHERE numEleve=".$_SESSION['numEleve'] ;


    // définition des différentes colonnes de données
    // ------------------------------------------------------------------------
    $champs=Array(
      //     champ       en-tête     format         alignement  largeur
      Array( 'numSerie',     'Numero Serie',       FORMAT_ENTIER, 'L',         15 ),
      Array( 'numTrace',     'Numero Trace',       FORMAT_ENTIER, 'L',         15 ),
	  Array( 'numEleve',     'Num Eleve',       FORMAT_ENTIER, 'L',         12 ),
	  Array( 'date',     'Date',       FORMAT_TEXTE, 'L',         20 ),
      Array( 'numExo',     'Num Exo',       FORMAT_ENTIER, 'L',         10 ),
      Array( 'typeExo', 'Type Exo', FORMAT_TEXTE,  'L',        10 ),
      Array( 'question',    'Question',   FORMAT_TEXTE,  'L',        10 ),
      Array( 'var',   'Variable',   FORMAT_TEXTE,  'L',        10 ),
	  Array( 'questInt',   'Question Int',   FORMAT_ENTIER,  'L',       10 ),
	  Array( 'colonne1',   'Colonne 1',   FORMAT_ENTIER,  'L',        10 ),
  	  Array( 'colonne2',   'Colonne 2',   FORMAT_ENTIER,  'L',        10 ),
	  Array( 'colonne3',   'Colonne 3',   FORMAT_ENTIER,  'L',        10 ),
	  Array( 'colonne4', 'Colonne 4',   FORMAT_ENTIER,  'L',        10 ),
	  Array( 'colonne5',   'Colonne 5',   FORMAT_ENTIER,  'L',        10 ),
	  Array( 'colonne6',   'Colonne 6',   FORMAT_ENTIER,  'L',        10 ),
	  Array( 'colonne7',   'Colonne 7',   FORMAT_ENTIER,  'L',        10 ),
	  Array( 'colonne8',   'Colonne 8',   FORMAT_ENTIER,  'L',        10 ),
	  Array( 'colonne9',   'Colonne 9',   FORMAT_ENTIER,  'L',        10 ),
	  Array( 'colonne10',   'Colonne 10',   FORMAT_ENTIER,  'L',        10 ),
	  Array( 'colonne11',   'Colonne 11',   FORMAT_ENTIER,  'L',        10 ),
	  Array( 'colonne12',   'Colonne 12',   FORMAT_ENTIER,  'L',        10 ),
	  Array( 'colonne13',   'Colonne 13',   FORMAT_ENTIER,  'L',        10 ),
	  Array( 'colonne14',   'Colonne 14',   FORMAT_ENTIER,  'L',        10 ),
	  Array( 'colonne15',   'Colonne 15',   FORMAT_ENTIER,  'L',        10 ),
	  Array( 'colonne16',   'Colonne 16',   FORMAT_ENTIER,  'L',        10 ),
	  Array( 'colonne17',   'Colonne 17',   FORMAT_ENTIER,  'L',        10 ),
	  Array( 'colonne18',   'Colonne 18',   FORMAT_ENTIER,  'L',        10 )
    );
    // ------------------------------------------------------------------------
    if ($resultat=mysql_db_query($BD_base, $sql))
    {
        // en-tête HTTP
        // --------------------------------------------------------------------
        /*header('Content-disposition: filename=fichier.slk');
        header('Content-type: application/octetstream');
        header('Pragma: no-cache');
        header('Expires: 0');*/

        // en-tête du fichier SYLK
        // --------------------------------------------------------------------
		$x= "ID;PASTUCES-phpInfo.net\n";// ID;Pappli
		$x=$x."\n";
        // formats
		$x=$x."P;PGeneral\n";
		$x=$x."P;P#,##0.00\n";    // P;Pformat_1 (reels)
		$x=$x."P;P#,##0\n";          // P;Pformat_2 (entiers)
		$x=$x."P;P@\n";              // P;Pformat_3 (textes)
		$x=$x."\n";
        // polices
		$x=$x."P;EArial;M200\n";
		$x=$x."P;EArial;M200\n";
		$x=$x."P;EArial;M200\n";
		$x=$x."P;FArial;M200;SB\n";
		$x=$x."\n";
        // nb lignes * nb colonnes :  B;Yligmax;Xcolmax
		$x=$x."B;Y".(mysql_num_rows($resultat)+1);
		$x=$x.";X".($nbcol=mysql_num_fields($resultat))."\n";
		$x=$x."\n";

        // récupération des infos de formatage des colonnes
        // --------------------------------------------------------------------
		for ($cpt=0; $cpt < $nbcol; $cpt++)
        {
            $num_format[$cpt]=$champs[$cpt][2];
            $format[$cpt]=$cfg_formats[$num_format[$cpt]].$champs[$cpt][3];
        }

        // largeurs des colonnes
        // --------------------------------------------------------------------
        for ($cpt=1; $cpt <= $nbcol; $cpt++)
        {
            // F;Wcoldeb colfin largeur
			$x=$x."F;W".$cpt." ".$cpt." ".$champs[$cpt-1][4]."\n";
        }
		$x=$x."F;W".$cpt." 256 8\n"; // F;Wcoldeb colfin largeur
		$x=$x."\n";

        // en-tête des colonnes (en gras --> SDM4)
        // --------------------------------------------------------------------
		for ($cpt=1; $cpt <= $nbcol; $cpt++)
        {
			$x=$x."F;SDM4;FG0C;".($cpt==1 ? "Y1;" : "")."X".$cpt."\n";
			$x=$x."C;N;K\"".$champs[$cpt-1][1]."\"\n";
        }
		$x=$x."\n";

        // données utiles
        // --------------------------------------------------------------------
        $ligne=2;
        while ($enr=mysql_fetch_array($resultat))
        {
            // parcours des champs
            for ($cpt=0; $cpt < $nbcol; $cpt++)
            {
                // format
				$x=$x."F;P".$num_format[$cpt].";".$format[$cpt];
				$x=$x.($cpt==0 ? ";Y".$ligne : "").";X".($cpt+1)."\n";
                // valeur
                if ($num_format[$cpt]==FORMAT_TEXTE)
                   {
					$x=$x."C;N;K\"".str_replace(';', ';;', $enr[$cpt])."\"\n";
					}
                else
                    {
					$x=$x."C;N;K".$enr[$cpt]."\n";
					}
            }
			$x=$x."\n" ;
            $ligne++;
        }
   // fin du fichier
        // --------------------------------------------------------------------
        //echo "E\n";
		$x=$x."E\n";
    }
    //creattion du fichier
	$fichier="diag/".$_SESSION['nom'].$_SESSION['numEleve'].".slk";
	$fp=fopen ("$fichier", "w");
	//enregistre les données dans le fichier
	fputs($fp, "$x");
	fclose ($fp);
    mysql_close();
//}

?>
<?php
	//$interface = "interfaceIE.php?numSerie=".$numero;
	//print("<a href=\"javascript:;\" onClick=\"window.open('$interface','Interface','fullscreen');\">".$nomSerie."</a>");
	echo "<script type='text/javascript'>location.href='interfaceIE.php?lienRetour=oui&numSerie=".$_SESSION['numSerie']."&nbExo=".$nbExo."&numExo=".$numExo."';</script>";

?>