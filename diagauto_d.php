<?php
 //supprime les traits d'union
$text = ereg_replace ('([a-zA-Z]) *- *([a-zA-Z])','\1 \2',$text);
$text=trim($text);
$longueur = strlen($text);
//print($text."<br>");
//suprime tous caractere different de [^\d+-=:*]
 $calcules = trim(eregi_replace ('[^0-9|,|+|*|:|=|-]', " ",$text));
 $calcules2= trim(eregi_replace ('[^0-9|,|+|*|:|=|-|(|)]', " ",$text));
 $tabCal =  preg_split ("/[\s]+/", $calcules); //scinde la phrase grâce au virgule et espacement
 //$tabCal =  preg_split ("/[\s]+/", $calcules2);
 //$pattern = "/((?:\d+\s*[\+\-\*\/x:]\s*)*(?:\(\s*(?:\d+\s*[\+\-\*\/x:]\s*)+\d+\s*\)\s*[\+\-\*\/x:]?\s*)*\d*\s*=?\s*\d+)/";
 //$pattern = "/\d+\s*[\+\-\*\/x:]\s*)*(\(\s*(\d+\s*[\+\-\*\/x:]\s*)+\d+\s*\)\s*[\+\-\*\/x:]?\s*)*\d*\s*=?\d*\s*/";
 //$pattern = "/((\d+\s*[\+\-\*\/x:]\s*)+\d+\s*=?\s*\d+)/";
//preg_match($pattern,$text,$tab);
//print_r($tab[0]);
//print("<br>");
//print_r($tab);
//print_r($tabCal);print("<br>");
//print_r($tab[3]);print("<br>");
								
								/* Reconnaissance des opération utilisées dans le texte*/

$pat1 = "/\d+\s*[\+\-\*\/x:]\s*\d+\s*([\+\-\*\/x:]\s*\d+\s*)*\s*=\s*\d+\s*/"; //opération de type a+b+...+c=resultat
$pat2 = "/\d+\s*[\*xX:\/]\s*\(\s*\d+\s*[\+\-\*\/x:]\s*\d+\s*([\+\-\*\/x:]\s*\d+\s*)*\)\s*=\s*\d+/"; //opération de type a*(b+c+...)=resultat
$pat3 = "/\(\s*\d+\s*[\+\-\*\/x:]\s*\d+\s*([\+\-\*\/xX:]\s*\d+\s*)*\)\s*[\*\/xX:]\s*\d+\s*\=\s*\d+/"; ////opération de type (a+b+...)*c=resultat
$pat4 = "/(\(?\s*\d+\s*([\+\-\*\/x:]\s*\d+\s*)?\)?\s*([\+\*\/xX:]\s*)?)*=\s*\d+/";
preg_match_all($pat1,$text,$tab1);
for($i=0; $i<count($tab1[0]);$i++)
{
	$tabOp1[$i]=$tab1[0][$i];	
	$tabOp1[$i]= ereg_replace("\s+|\r|\t|\e|\n|\f| ", "",$tabOp1[$i]);//suppression des espaces
}

preg_match_all($pat2,$text,$tab2);
for($i=0; $i<count($tab2[0]);$i++)
{
	$tabOp2[$i]=$tab2[0][$i];
	$tabOp2[$i]= ereg_replace("\s+|\r|\t|\e|\n|\f| ", "",$tabOp2[$i]);//suppression des espaces
}

preg_match_all($pat3,$text,$tab3);
for($i=0; $i<count($tab3[0]);$i++)
{
	$tabOp3[$i]=$tab3[0][$i];	
	$tabOp3[$i]= ereg_replace("\s+|\r|\t|\e|\n|\f| ", "",$tabOp3[$i]);//suppression des espaces

}
preg_match_all($pat4,$text,$tab4);
for($i=0; $i<count($tab4[0]);$i++)
{
	$tabOp4[$i]=$tab4[0][$i];	
	$tabOp4[$i]= ereg_replace("\s+|\r|\t|\e|\n|\f| ", "",$tabOp4[$i]);//suppression des espaces
}
if(isset($tabOp1)) $nbOper1 = count($tabOp1); else $nbOper1=0;
if(isset($tabOp2)) $nbOper2 = count($tabOp2); else $nbOper2=0;;
if(isset($tabOp3)) $nbOper3 = count($tabOp3); else $nbOper3=0;;
if(isset($tabOp4)) $nbOper4 = count($tabOp4); else $nbOper4=0;;

$nbOper = $nbOper1+$nbOper2+$nbOper3;
if($nbOper==0)
$nbOper=$nbOper4;

/* echo($nbOper);
print_r($tabOp1);print("<br>");
print_r($tabOp2);print("<br>");
print_r($tabOp3);print("<br>");
print_r($tabOp4);print("<br>");
 */
//exit(); 

//ER qui reconnait les operations 
$pattern = "/((?:\d+\s*[\+\-\*\/x:]\s*)*(?:\(?\s*(?:\d+\s*[\+\-\*\/x:]\s*)+\d+\s*\)?\s*[\+\-\*\/x:]?\s*)*\d*\s*)=(\s*\d+)/";

preg_match_all($pattern,$text,$tab);
//tableau des opération utilisées dans la réponse de l'apprenant ==> tabOperation
$tabOperation = $tab[0];
$tabSR = $tab[1];
$tabR = $tab[2];
//print_r($tabOperation);print("<br>");
//supprimer les espaces blanc
for($i=0; $i<count($tabOperation);$i++)
{
	$tabOperation[$i]= ereg_replace("\s+|\r|\t|\e|\n|\f| ", "",$tabOperation[$i]);//suppression des espaces
	$tabOperation[$i]= ereg_replace("x|X", "*",$tabOperation[$i]);
}

$tabMot = preg_split ("/[\s]+/", $text);

//recherche les nombres dans le tableau tabMot
$numeros = array_values (preg_grep("/\d/", $tabMot));
//echo count($numeros);
//exit;
/*print("les mots du textes<br>");
for ($i=0 ; $i < count($tabMot) ;$i++)
print($tabMot[$i]."<br>");
print ("<br>-------------------------------<br>");
print ("les nombres que le texte contient sont");*/
for ($i=0 ; $i < count($numeros) ;$i++)
{
	//print($numeros[$i]." "."<br>");
	$tab = preg_split ("/[\s\+\-\*\:\=]+/", $numeros[$i]);
	$num = array_values (preg_grep("/\d/", $tab));
	for ($j=0 ; $j < count($num) ;$j++)
	{
		$a = eregi_replace('[^(0-9\,)]',"",$num[$j]);
		$nombre[] = $a;
	}
}
/*for ($i=0 ; $i < count($nombre) ;$i++)
print($nombre[$i]." ");exit;*/
$tabNombre = $nombre;
//====================================================
 require_once("conn.php");
 $Requete_SQL1 = "SELECT * FROM $t where numero = $n";
 $result = mysql_query($Requete_SQL1) or die("Erreur de S&eacute;lection dans la base : ". $Requete_SQL1 .'<br/>'. mysql_error());
 
 while ($val = mysql_fetch_array($result))
	{
    	$va1 = $val["va1"];
		$va2 = $val["va2"];
		$va3 = $val["va3"];
		$va4 = $val["va4"];
		$va5 = $val["va5"];
		$fact=$val["fact"];
		$nva = $val["nva"];
		/*$r1=$val["r1"];
		$r2=$val["r2"];
		$r3=$val["r3"];
		$r4=$val["r4"];
		$r5=$val["r5"];
		$resfin=$val["resfin"];
    	$sommeva=$val["sommeva"];*/
	}
						
		$r1=$va1*$fact;
		$r2=$va2*$fact;
		$r3=$va3*$fact;
		$r4=$va4*$fact;
		$r5=$va5*$fact;
		$sommeva=$va1+$va2+$va3+$va4+$va5;
		$resfin=$sommeva*$fact;
    	
		
				
$chaineOp = implode (' ',$tabOperation);
$chaineOper = trim(eregi_replace ('[^0-9|,]', " ",$chaineOp));
//print ($chaineOper);
//exit;
$tabOperande= array_values(preg_split ("/[\s]+/", $chaineOper));
/* print ("le tableau des operations :  ");print_r($tabOperation);print ("<br>"); 
print ("le tableau des operations :  ");print_r($tabOperation2);print ("<br>");
exit();
 */
 //print ("le tableau d'operande :  ");print_r($tabOperande);print ("<br>"); exit;
//print ("le tableau des nombres :  ");print_r($nombre);print ("<br>"); exit;
//$nombre_bis=$nombre;
//$tabDiff = array_diff($nombre,$tabOperande);print_r($tabDiff);exit();//montre si il y a des valeurs qui sont dans le tableau 1 et pas au 2 ou vis versa
/*effectuer la difference entre les deux tableaux $nombre et $tabOperande*/

for ($i=0; $i<count($tabOperande); $i++)
			 {
				for ($j=0 ; $j < count($nombre) ; $j++)
					{
					  if ($tabOperande[$i] == $nombre[$j])
						{
							$nombre[$j]='';
							break 1;
						}
					}
			 }

for ($i=0 ; $i < count($nombre) ;$i++)
		if ($nombre[$i]!='')
		  $tabImp[] = $nombre[$i];

/*print ("le tableau tabImp \"Implicite\"");
if (isset($tabImp))
print_r($tabImp);
print ("<br>");//exit("ok");*/

for ($i=0; $i<count($tabOperation);$i++)
{
	${'tab'.$i}=$tabOperation[$i];
	${'chaineOper'.$i} = trim(eregi_replace ('[^0-9|,]', " ",${'tab'.$i}));
	${'tabOperande'.$i}= array_values(preg_split ("/[\s]+/", ${'chaineOper'.$i}));
 
}
//print_r($tabOperande);exit;
//dernier tableau d'operande pour le calcul final; cas d'une addition a trou
$i=count($tabOperation)-1;
$dernierTabOp=${'tabOperande'.$i};
//echo "le dernier tableau d'operande est :<br>"; print_r($dernierTabOp);echo "<br><br>";exit;
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
//print_r($tabImp);
/*======ajouter le signe egale a l'operation s'il n'existe pas=======*/

for ($i=0,$k=0; $i < count($tabOperation);$i++)
{
	if(!strstr($tabOperation[$i],'='))
	{
	$tabOperation[$i]=$tabOperation[$i]."=".$tabImp[$k];
	}
	$k++;
}
//Réinitialiser les enregistrements à 0
$requete_init = "UPDATE diagdistrib SET D=0, Dc=0, De=0, De2=0, F=0, Fc=0, Fe=0, Fe2=0, Addition=0, Multiplication=0, Position=0, B=0, At=0, M=0, M2=0, M3=0, N=0, A=0, Di=0, Em=0, Ed=0, Ea=0, Ej=0, Cimp=0 where numTrace = $numTrace";
$result = mysql_query($requete_init) or die("Erreur d'Insertion dans la base :".$requete_init.'<br/>'.mysql_error());

//print ("le tableau des operations si le signe egale est absent :  ");print_r($tabOperation);print ("<br>");
//exit;
/*-------fin difference entre les deux tableaux-----------*/
//$bool=false;
								//N=1 pas d'opération que du texte saisi

if ((count($tabOperation)==0)&&(count($tabImp)==0)&&($longueur!=0))
	{$Requete_SQL2 ="update diagdistrib set date='".$date."', N='1' where numTrace = $numTrace";
	 $result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base :".$Requete_SQL2.'<br/>'.mysql_error());}



								/*CODE Cimp=1*/


if (isset($tabImp) and (count($tabOperation)==0) and (count($tabImp)==1)and(in_array($sommeva,$tabImp)))
	{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,Cimp) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','3')";
	$Requete_SQL2 ="update diagdistrib set numSerie=$numSerie,date='".$date."',numExo=$n,Cimp='1' where numTrace = $numTrace";
	 $result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base :".$Requete_SQL2.'<br/>'.mysql_error());}


								/*CODE Cimp=3*/


if (isset($tabImp) and (count($tabOperation)==0)&&(in_array($resfin,$tabImp)))
	{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,Cimp) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','3')";
	$Requete_SQL2 ="update diagdistrib set numSerie=$numSerie,date='".$date."',numExo=$n,Cimp='3' where numTrace = $numTrace";
	 $result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base :".$Requete_SQL2.'<br/>'.mysql_error());}
								/*CODE (M=1) et calcul implicite (Cimp=2)*/

$m=$nva*$fact;
if (isset($tabImp) and (count($tabOperation)==0)&&(in_array($m,$tabImp)))
	{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,M,Cimp) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','2')";
	$Requete_SQL2 ="update diagdistrib set numSerie=$numSerie,date='".$date."',numExo=$n,M='1', Cimp='2' where numTrace = $numTrace";
	 $result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base :".$Requete_SQL2.'<br/>'.mysql_error());}
							
								/*CODE Addition totale(At=1) et calcul implicite (Cimp=2)*/
$at=$sommeva+$fact;
if (isset($tabImp) and (count($tabOperation)==0)&&(in_array($at,$tabImp)))
	{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,At,Cimp) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','2')";
	$Requete_SQL2 ="update diagdistrib set numSerie=$numSerie,date='".$date."',numExo=$n,At='1',Cimp='2' where numTrace = $numTrace";
	 $result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base :".$Requete_SQL2.'<br/>'.mysql_error());}	
																
																	
								/*CODE B*/

if ($longueur==0)
	{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,B) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1')";
	$Requete_SQL2 ="update diagdistrib set numSerie=$numSerie,date='".$date."',numExo=$n,B='1' where numTrace = $numTrace";
	 $result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base :".$Requete_SQL2.'<br/>'.mysql_error());}
//début 1 opération


								/*CODE 1 opération (Fc,A, M, At,Fe,Ed,Em,Ea,Dc)*/
//print_r($tabOperation);
//echo(count($tabOperation));
//exit();
//if (count($tabOperation)==1)
if ($nbOper==1)
{			$operation = $tabOperation[0];
			if(isset($tabOp1) and count($tabOp1)==1)
				$operation = $tabOp1[0];
			elseif(isset($tabOp2)and count($tabOp2)==1)
				$operation = $tabOp2[0];
			elseif(isset($tabOp3) and count($tabOp3)==1)
				$operation = $tabOp3[0];
			//suprime tous caractere different de [^+-:*] , les resultats dans un tableau T1
	 		$oper = trim(eregi_replace ('[^-|+|*|:]', " ",$operation));
	 		$T1 =  array_values(preg_split ("/[\s]+/", $oper));
	 		//suprime tous caractere different des operandes , les resultats dans un tableau T2
			$operande = trim(eregi_replace ('[^0-9|,]', " ",$operation));
			$T2 = array_values(preg_split ("/[\s]+/", $operande));
			/*print("le tableau T2 contient :  ");print_r($T2);print ("<br>");
			print("le tableau T2 contient ". count($T2). "elements");print ("<br>");
			print("le tableau T1 contient :  ");print_r($T1);print ("<br>");
			print("le tableau T1 contient ". count($T1). "elements");print ("<br>");

			for ($k = 0 ; $k < count($T1); $k++)	
				{
					print_r($T1[$k]);print("<br>");
				}
			exit(); */ 
			
							//Condensation (Fc) (a+b+c)*f=r
			
			for ($i=0 , $j=0; $i < count($T1) ;$i++)
				{
					if ($T1[$i]=='+')
					 {
					 	$add[$j]=$T1[$i]; $j++;
					 }
				}	
	
			for ($i=0, $j=0 ; $i < count($T1) ;$i++)
				{	if($T1[$i]=='*')
						{$mul[$j]=$T1[$i]; $j++;}
		 		} 	
				
			//print(count($add));exit;	
			for ($i=0,$j=0; $i<$nva; $i++)
				{$T3[$j]=$T2[$i]; $j++;}
				
			if (isset($T3) and (in_array ($va1,$T3)) and (in_array ($va2,$T3)) and (in_array ($va3,$T3)))
				{$presvar=true;}
			else
				{$presvar=false;}
			//print($presvar);exit;
				
			if ((count($T1)==$nva)&&(count($T2)==($nva+2))&&(count($add)==($nva-1))&&(count($mul)==1)&&($presvar==true)&&($T2[4]==$resfin)&&($T2[3]==$fact))
				{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,Fc) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1')";
				$Requete_SQL2 ="update diagdistrib set date='".$date."',Fc='1' where numTrace = $numTrace";
		 		 $result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base :".$Requete_SQL2.'<br/>'.mysql_error());}
				 											
							//Condensation (Fc) avec erreur de calul non identifiée (add=mult=4)
				 
			if ((count($T1)==$nva)&&(count($T2)==($nva+2))&&(count($add)==($nva-1))&&(count($mul)==1)&&($presvar==true)&&($T2[4]!=$resfin)&&($T2[3]==$fact))
				{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,Fc,Addition,Multiplication) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','4','4')";
			$Requete_SQL2 ="update diagdistrib set date='".$date."',Fc='1',Addition='4',Multiplication='4' where numTrace = $numTrace";

		 	 $result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base :".$Requete_SQL2.'<br/>'.mysql_error());}
												
							//Condensation (Fc) f*(a+b+c)=r
			for ($i=1,$j=0; $i<($nva+1); $i++)
				{$T3[$j]=$T2[$i]; $j++;}
							
			if (isset($T3) && (in_array ($va1,$T3))&&(in_array ($va2,$T3))&&(in_array ($va3,$T3)))
				{$presvar=true;}
			else
				{$presvar=false;}
			//print($presvar);exit;
				
			
			if ((count($T1)==$nva)&&(count($T2)==($nva+2))&&(count($add)==($nva-1))&&(count($mul)==1)&&($presvar==true)&&($T2[4]==$resfin)&&($T2[0]==$fact))
				{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,Fc) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1')";
				$Requete_SQL2 ="update diagdistrib set date='".$date."',Fc='1' where numTrace = $numTrace";
		 		$result =mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base:".$Requete_SQL2.'<br/>'.mysql_error());}
			if (($calcules2[4]=='(')&&($calcules2[14]==')')&&(count($T1)==$nva)&&(count($T2)==($nva+2))&&(count($add)==($nva-1))&&(count($mul)==1)&&($presvar==true)&&($T2[4]!=$resfin)&&($T2[0]==$fact))
				{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,Fc,Addition,Multiplication) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','4','4')";
			$Requete_SQL2 ="update diagdistrib set date='".$date."',Fc='1',Addition='4',Multiplication='4' where numTrace = $numTrace";
		 	$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base :".$Requete_SQL2.'<br/>'.mysql_error());}
							
							
							/*
								condensation avec erreur de parenthèse de  type f * a+b+c =r
								Addition='5',Multiplication='5'  a ajouter dans la grille de codage
							*/
	
if ((count($T1)==$nva)&&(count($T2)==($nva+2))&&(count($add)==($nva-1))&&(count($mul)==1)&&(end($T2)!=$sommeva)&& ((end($T2)==($r1+$va2+$va3)) || (end($T2)==($r2+$va1+$va3)) || (end($T2)==($r3+$va2+$va1)))) 
				{
				//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,Fc,Addition,Multiplication) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','5','5')";
			$Requete_SQL2 ="update diagdistrib set date='".$date."',Fc='1',Addition='5',Multiplication='5' where numTrace = $numTrace";
		 	$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base :".$Requete_SQL2.'<br/>'.mysql_error());
				}				
							
							/*CODE ADDITION(A=1)*/
		$add=true;
		for ($i=0; (($i < count($T1))&& ($add==true));$i++)
			{	if($T1[$i]=='+')
					{$add=true;}
		 		else
					{$add=false;}
			} 	
		if ((count($T1)==($nva-1))&&($add==true)&& (in_array($va1,$T2)) && (in_array($va2,$T2)) && (in_array($va3,$T2)) &&($T2[$nva]==$sommeva)&&(count($T2)==$nva+1))
			{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,A) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1')";
			$Requete_SQL2 ="update diagdistrib set date='".$date."',A='1' where numTrace = $numTrace";
		 	$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base : ". $Requete_SQL2 .'<br/>'. mysql_error());}
		
							/*CODE ADDITION(A=1) avec add fin ratée (add=2)*/
		
		else if ((count($T1)==($nva-1))&&($add==true)&& (in_array($va1,$T2)) && (in_array($va2,$T2)) && (in_array($va3,$T2)) &&($T2[$nva]!=$sommeva)&&(count($T2)==($nva+1)))
			{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,A,Addition) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','2')";
			$Requete_SQL2 ="update diagdistrib set date='".$date."',A='1',Addition='2' where numTrace = $numTrace";
			$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base :".$Requete_SQL2.'<br/>'.mysql_error());}
			
							/*(D) avec calcul intermédiaire implicite (Cimp=1)*/
			 
			 if ((count($T1)==($nva-1))&&($add==true)&& (in_array($r1,$T2)) && (in_array($r2,$T2)) && (in_array($r3,$T2)) &&($T2[$nva]==$resfin))
			{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,D,Cimp) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','1')";
			$Requete_SQL2 ="update diagdistrib set date='".$date."',D='1',Cimp='1' where numTrace = $numTrace";
		 	$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base : ". $Requete_SQL2 .'<br/>'. mysql_error());}
			 
			 
						/*(D) avec calcul intermédiaire implicite (Cimp=1) et erreur de calcul dans l'addition finale (Add=2)*/
			 
			if ((count($T1)==($nva-1))&&($add==true)&& (in_array($r1,$T2)) && (in_array($r2,$T2)) && (in_array($r3,$T2)) &&($T2[$nva]!=$resfin))
			{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,D,Cimp,Addition) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','1','2')";
			$Requete_SQL2 ="update diagdistrib set date='".$date."',D='1',Cimp='1',Addition='2' where numTrace = $numTrace";
		 	$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base : ". $Requete_SQL2 .'<br/>'. mysql_error());}
			
						 /*(D) avec calcul intermédiaire implicite (Cimp=1) et erreur d'unité mal placé*/
			
			if ($r1%10==$r1) $r11=$r1*10; else $r11=$r1;
			if ($r2%10==$r2) $r21=$r2*10; else $r21=$r2;
			if ($r3%10==$r3) $r31=$r3*10; else $r31=$r3;
			$resMP=$r11+$r21+$r31;
	
			if ((count($T1)==($nva-1))&&($add==true)&& (in_array($r1,$T2)) && (in_array($r2,$T2)) && (in_array($r3,$T2)) &&($T2[$nva]!=$resfin)&&($T2[$nva]==$resMP))
			{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,D,Cimp,Addition,Position) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','1','2','1')";
			$Requete_SQL2 ="update diagdistrib set date='".$date."',D='1',Addition='2',Position='1',Cimp=1 where numTrace = $numTrace";
		 	$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base : ". $Requete_SQL2 .'<br/>'. mysql_error());}
																		
 					
						/*(D) avec calcul intermédiaire implicite (Cimp=1) et erreur de retenue*/
			$max = max (strlen($r1),strlen($r2),strlen($r3));
			$r1Tab="".$r1;
			if(strlen($r1)<$max)
			{
				$diff=$max-strlen($r1);
				for($i=0;$i<$diff;$i++)
				  $r1Tab="0".$r1Tab;
			}
			
			$r2Tab="".$r2;
			if(strlen($r2)<$max)
			{
				$diff=$max-strlen($r2);
				for($i=0;$i<$diff;$i++)
				  $r2Tab="0".$r2Tab;
			}
			$r3Tab="".$r3;
			if(strlen($r3)<$max)
			{
				$diff=$max-strlen($r3);
				for($i=0;$i<$diff;$i++)
				  $r3Tab="0".$r3Tab;
			}
			for($i=0;$i<$max;$i++)
			{
				$tabInt[$i]=($r1Tab{$i}+$r2Tab{$i}+$r3Tab{$i})%10;
			}
			//print_r($tabInt);
			$resErrR = implode($tabInt);

			if ((count($T1)==($nva-1))&&($add==true)&& (in_array($r1,$T2)) && (in_array($r2,$T2)) && (in_array($r3,$T2))
					&&($T2[$nva]!=$resfin)&&($T2[$nva]==$resErrR))
			{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,D,Cimp,Addition,Position) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','1','2','2')";
		 	$Requete_SQL2 ="update diagdistrib set date='".$date."',D='1',Addition='2',Position='2',Cimp='1' where numTrace = $numTrace";
			$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base : ". $Requete_SQL2 .'<br/>'. mysql_error());}																		
														
														
						/*(F) avec calcul intermédiaire implicite (Cimp=1)*/
			$mul=true;
			for ($j=0; (($j < count($T1))&& ($mul==true));$j++)
				{	if($T1[$j]=='*')
								{$mul=true;}
		 			else
								{$mul=false;}
				} 	
			
			//erreur de retenu multiplicative
			$max = max (strlen($T2[0]),strlen($T2[1]));
			if(strlen($T2[0])<strlen($T2[1]))
			 {
				$facteur=$T2[0];
				$r1Tab="".$T2[1];
			 }
			else
			 {
				$r1Tab="".$T2[0];
				$facteur=$T2[1];
			 }

			for($i=0;$i<$max;$i++)
			{
				$tabInt[$i]=($r1Tab{$i}*$facteur)%10;
			}
			$resErrR = implode($tabInt);

			if ((count($T1)==1)&&($mul==true)&& (in_array($sommeva,$T2)) && (in_array($facteur,$T2))&&($T2[2]==$resErrR)&&($resfin!=$resErrR))
			{
			
			$Requete_SQL2 ="update diagdistrib set date='".$date."',F='1',Multiplication='2',Position='3',Cimp='1' where numTrace = $numTrace";
			$result =mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base:".$Requete_SQL2.'<br/>'.mysql_error());
			}																
			 
			 //pas d'erreur de caclul
			 if ((count($T1)==1)&&($mul==true)&& (in_array($sommeva,$T2)) && (in_array($fact,$T2)) &&($T2[2]==$resfin))
			{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,F,Cimp) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','1')";
			$Requete_SQL2 ="update diagdistrib set date='".$date."',F='1',Cimp='1' where numTrace = $numTrace";
		 	$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base : ". $Requete_SQL2 .'<br/>'. mysql_error());}
			
	/*(F) avec calcul intermédiaire implicite (Cimp=1) et erreur de calcul dans la multiplication finale (Multi=2)*/
			
		else if ((count($T1)==1)&&($mul==true)&& (in_array($sommeva,$T2)) && (in_array($fact,$T2)) &&($T2[2]!=$resfin))
			{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,F,Cimp,Multiplication) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','1','2')";
			$Requete_SQL2 ="update diagdistrib set date='".$date."',F='1',Multiplication='2',Cimp='1' where numTrace = $numTrace";
		 	$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base : ". $Requete_SQL2 .'<br/>'. mysql_error());}
			
								
						/*CODE (M=1)*/
																				
		else if ((count($T1)==1)&&($T1[0]=="*")&& (in_array($fact,$T2)) && (in_array($nva,$T2))&& ($T2[2]==$nva*$fact))
			{
			//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,M) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1')";
$Requete_SQL2 ="update diagdistrib set date='".$date."',M='1' where numTrace = $numTrace";
			 $result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base : ". $Requete_SQL2 .'<br/>'. mysql_error());
			 }
			 
			 
			 			/*CODE (M=1) et multiplication ratée (Multiplication=2)*/
																				
		else if ((count($T1)==1)&&($T1[0]=="*")&& (in_array($fact,$T2)) && (in_array($nva,$T2))&& ($T2[2]!=$nva*$fact))
			{
			//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,M,Multiplication) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','2')";
			 $Requete_SQL2 ="update diagdistrib set date='".$date."',M='1',Multiplication='2' where numTrace = $numTrace";
			 $result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base : ".$Requete_SQL2 .'<br/>'.mysql_error());}
		
			 
			 	
						/*CODE Add totale(At=1)*/
											
		else if ((count($T1)==$nva)&&($add==true)&& (in_array($va1,$T2)) && (in_array($va2,$T2)) && (in_array($va3,$T2)) && (in_array($fact,$T2))&&($T2[$nva+1]==$sommeva+$fact))
			{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,At) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1')";
			 $Requete_SQL2 ="update diagdistrib set date='".$date."',At='1' where numTrace = $numTrace";
			 $result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base :".$Requete_SQL2.'<br/>'.mysql_error());}


						/*CODE Add totale(At=1) avec addition ratée (add=2)*/
											
		else if ((count($T1)==$nva)&&($add==true)&& (in_array($va1,$T2)) && (in_array($va2,$T2)) && (in_array($va3,$T2)) && (in_array($fact,$T2))&&($T2[$nva+1]!=$sommeva+$fact))
			{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,At,Addition) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','2')";
			$Requete_SQL2 ="update diagdistrib set date='".$date."',At='1',Addition='2' where numTrace = $numTrace";
			 $result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base :".$Requete_SQL2.'<br/>'.mysql_error());}
																				
																				
																				
																																								
						/*CODE Explosion1 (Fe=1) et Cimp=1*/
		$diff=array();
		for ($i=0,$k=0 ; $i < count($T2) ;$i++)
		 	{	 if ($T2[$i] != $sommeva)
		  	    	{
						$diff[$k] = $T2[$i];
						$k++;
				 	}
				
		 	}
	
		//for ($i=0; $i < count($diff) ; $i++)
		//{print ($diff[$i]."<br>");}
		//exit;}
		
		if (($add==true)&&(count($diff)==1)&& ($diff[0]==$resfin)&&(count($T1)==$fact-1))
			{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,Fe,Cimp) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','1')";
			$Requete_SQL2 ="update diagdistrib set date='".$date."',Fe='1',Cimp='1' where numTrace = $numTrace";
			 $result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base :".$Requete_SQL2.'<br/>'.mysql_error());}
			 
			 
			 /*CODE Explosion1 (Fe) 1 seule opération (15+15+15+15=60) avec addition finale ratée (add=2)*/
			 
		if (($add==true)&&(count($diff)==1)&& ($diff[0]!=$resfin)&&(count($T1)==$fact-1))
			{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,Fe,Addition,Cimp) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','2','1')"; 
			 $Requete_SQL2 ="update diagdistrib set date='".$date."',Fe='1',Addition='2',Cimp='1' where numTrace = $numTrace";
			 $result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base :".$Requete_SQL2.'<br/>'.mysql_error());}
			 

						/*Décomposition(Ed)*/
		$dif=array();
		for ($i=0,$k=0 ; $i < count($T2) ;$i++)
			{	if ($T2[$i]!=$fact)
		 	 		{$dif[$k] = $T2[$i];$k++;}
			}
		//print($add);exit;
		//print(count($diff));exit;
		if (($va1==$va2)&&($va1==$va3)&&($va2==$va3)&&($va1==$fact))
			{$cp=true;}
		if (($add==true)&&(count($dif)==1)&& ($dif[0]==$resfin)&&(count($T2)==$sommeva+1)&&($cp==false))
			{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,Ed) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1')";
			$Requete_SQL2 ="update diagdistrib set date='".$date."',Ed='1' where numTrace = $numTrace";
			$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base : ". $Requete_SQL2 .'<br/>'. mysql_error());}
			
						/*Décomposition(Ed) avec erreur de calcul addition finale (add=2)*/
			
		if (($add==true)&&(count($dif)==1)&& ($dif[0]!=$resfin)&&(count($T2)==$sommeva+1)&&($cp==false))
			{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,Ed,Addition) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','2')";
			$Requete_SQL2 ="update diagdistrib set date='".$date."',Ed='1',Addition='2' where numTrace = $numTrace";
			$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base : ". $Requete_SQL2 .'<br/>'. mysql_error());
			}
			

						/*Myriade(Em)*/
												
						/* Myriade(Em) 3 variables de valeur différente */
		if(($va1!=$va2)&&($va1!=$va3)&&($va2!=$va3))
		{
			for ($i=0,$k=0,$j=0 ; $i < count($T2) ;$i++)
			{	
				if ($T2[$i]==$va1)
		  		{$v1[$k] = $T2[$i];$k++;}
		 		 else if ($T2[$i]==$va2)
		 		 {$v2[$k] = $T2[$i];$k++;}
		 		 else if ($T2[$i]==$va3)
		  		{$v3[$k] = $T2[$i];$k++;}
		 		 else 
		  		{$re[$j] = $T2[$i];$j++;}
			}

			if (($add==true)&&(count($v1)==$fact)&&(count($v2)==$fact)&&(count($v3)==$fact)&&($re[0]==$resfin)&&(count($re)==1))
				{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,Em) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1')";
				$Requete_SQL2 ="update diagdistrib set date='".$date."',Em='1' where numTrace = $numTrace";
				 $result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base :".$Requete_SQL2.'<br/>'.mysql_error());}
				 
				 		/*Addition ratée pour myriade (Add=2) (Em=1)*/
				 
			if (($add==true)&&(count($v1)==$fact)&& (count($v2)==$fact)&& (count($v3)==$fact)&&($re[0]!=$resfin)&&(count($re)==1))
				{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,Em,Addition) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','2')";
				 $Requete_SQL2 ="update diagdistrib set date='".$date."',Em='1',Addition='2' where numTrace = $numTrace";
				 $result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base :".$Requete_SQL2.'<br/>'.mysql_error());}
		}

						/* Myriade(Em) 3 variables de valeur égale ; valeur du facteur différente de la valeur des variables */
												
		else if (($va1==$va2)&&($va1==$va3)&&($va2==$va3)&&($fact!=$va1))
		{
				for ($i=0,$k=0,$j=0 ; $i < count($T2) ;$i++)
				 	{	if ($T2[$i]==$va1)
			 		 		{$v1[$k] = $T2[$i];$k++;}
			 			else 
			  	  			{$re[$j] = $T2[$i];$j++;}
					}

		/*for ($k = 0 ; $k < count($re); $k++)
		{print_r($re);print("<br>");}exit;*/
		
		if (($add==true)&&(count($v1)==$fact*$nva)&& ($re[0]==$resfin)&&(count($re)==1))
			{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,Em) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1')";
			$Requete_SQL2 ="update diagdistrib set date='".$date."',Em='1' where numTrace = $numTrace";
			$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base : ". $Requete_SQL2 .'<br/>'. mysql_error());}
			
						 /*Addition ratée pour myriade (Add=2) (Em=1)*/
			 
		if (($add==true)&&(count($v1)==$fact*$nva)&& ($re[0]!=$resfin)&&(count($re)==1))
			{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,Em,Addition) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','2')";
			$Requete_SQL2 ="update diagdistrib set date='".$date."',Em='1',Addition='2' where numTrace = $numTrace";
			$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base : ". $Requete_SQL2 .'<br/>'. mysql_error());}

		}
		
				/* Myriade(Em) 3 variables de valeur égale ; valeur du facteur égale à la valeur des variables (Ed aussi)*/
												
		else if (($va1==$va2)&&($va1==$va3)&&($va2==$va3)&&($fact==$va1))
		{
				for ($i=0,$k=0,$j=0 ; $i < count($T2) ;$i++)
				 	{	if ($T2[$i]==$va1)
			 		 		{$v1[$k] = $T2[$i];$k++;}
			 			else 
			  	  			{$re[$j] = $T2[$i];$j++;}
					}

		/*for ($k = 0 ; $k < count($re); $k++)
		{print_r($re);print("<br>");}exit;*/
		
		if (($add==true)&&(count($v1)==$fact*$nva)&& ($re[0]==$resfin)&&(count($re)==1))
			{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,Em,Ed) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','1')";
			$Requete_SQL2 ="update diagdistrib set date='".$date."',Em='1',Ed='1' where numTrace = $numTrace";
			$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base : ". $Requete_SQL2 .'<br/>'. mysql_error());}
			
			 /*Addition ratée pour myriade (Add=2) (Em=1 et Ed=1)*/
		if (($add==true)&&(count($v1)==$fact*$nva)&& ($re[0]!=$resfin)&&(count($re)==1))
		{
		//$Requete_SQL2 = "INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,Em,Ed,Addition) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','1','2')";
		$Requete_SQL2 ="update diagdistrib set date='".$date."',Em='1',Ed='1',Addition='2' where numTrace = $numTrace";
		$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base : ". $Requete_SQL2 .'<br/>'. mysql_error());
		}

		}
		/* Myriade(Em) 2 variables de valeur égale et la 3ème différente */
													
		else if (($va1==$va2)&&($va1!=$va3))
		{	for ($i=0,$k=0,$j=0 ; $i < count($T2) ;$i++)
			{	if ($T2[$i]==$va1)
		  		{$v1[$k] = $T2[$i];$k++;}

				 else if ($T2[$i]==$va3)
				{$v2[$k]=$T2[$i];$k++;}
		 		else
		 		 {$re[$j] = $T2[$i];$j++;}
			}

		
			if (($add==true)&&(count($v1)==$fact*($nva-1))&&(count($v2)==$fact)&&($re[0]==$resfin)&&(count($re)==1))
			{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,Em) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1')";
			$Requete_SQL2 ="update diagdistrib set date='".$date."',Em='1' where numTrace = $numTrace";
			$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base : ". $Requete_SQL2 .'<br/>'. mysql_error());}
			
			 		/*Addition ratée pour myriade (Add=2) (Em=1)*/
			 
			 if (($add==true)&&(count($v1)==$fact*($nva-1))&&(count($v2)==$fact)&&($re[0]!=$resfin)&&(count($re)==1))
			{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,Em,Addition) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','2')";
			$Requete_SQL2 ="update diagdistrib set date='".$date."',Em='1',Addition='2' where numTrace = $numTrace";
			$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base : ". $Requete_SQL2 .'<br/>'. mysql_error());}
				 	 
		}

		else if (($va2==$va3)&&($va2!=$va1))
		{
			for ($i=0,$k=0,$j=0 ; $i < count($T2) ;$i++)
			{	if ($T2[$i]==$va2)
		  		{$v1[$k] = $T2[$i];$k++;}
		 	else if ($T2[$i]==$va1)
		  		{$v2[$k]=$T2[$i];$k++;}
		 	else
		  		{$re[$j] = $T2[$i];$j++;}
			}

				/*for ($k = 0 ; $k < count($re); $k++)
				{print_r($re);print("<br>");}
				exit;*/
		
			if (($add==true)&&(count($v1)==$fact*($nva-1))&&(count($v2)==$fact)&&($re[0]==$resfin)&&(count($re)==1))
			{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,Em) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1')";
			$Requete_SQL2 ="update diagdistrib set date='".$date."',Em='1' where numTrace = $numTrace";
			$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base : ". $Requete_SQL2 .'<br/>'. mysql_error());}
			
			 					/*Addition ratée pour myriade (Add=2) (Em=1)*/
			 
			 if (($add==true)&&(count($v1)==$fact*($nva-1))&&(count($v2)==$fact)&&($re[0]!=$resfin)&&(count($re)==1))
			{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,Em,Addition) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','2')";
			$Requete_SQL2 ="update diagdistrib set date='".$date."' , Em='1' , Addition='2' where numTrace = $numTrace";
			$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base : ". $Requete_SQL2 .'<br/>'. mysql_error());}
			
		}
		else if (($va1==$va3)&&($va2!=$va1))
		{
			for ($i=0,$k=0,$j=0 ; $i < count($T2) ;$i++)
			{	if ($T2[$i]==$va1)
		 		 {$v1[$k] = $T2[$i];$k++;}
		 	else if ($T2[$i]==$va2)
		  		{$v2[$k]=$T2[$i];$k++;}
		 	else
		  		{$re[$j] = $T2[$i];$j++;}
			}

		/*for ($k = 0 ; $k < count($re); $k++)
		{print_r($re);print("<br>");	}
		exit;*/
		
		
			if (($add==true)&&(count($v1)==$fact*($nva-1))&&(count($v2)==$fact)&&($re[0]==$resfin)&&(count($re)==1))
			{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,Em) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1')";
			$Requete_SQL2 ="update diagdistrib set date='".$date."',Em='1'  where numTrace = $numTrace";
			$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base : ". $Requete_SQL2 .'<br/>'. mysql_error());}
			
			 			/*Addition ratée pour myriade (Add=2) (Em=1)*/
			 
			 if (($add==true)&&(count($v1)==$fact*($nva-1))&&(count($v2)==$fact)&&($re[0]!=$resfin)&&(count($re)==1))
			{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,Em,Addition) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','2')";
			$Requete_SQL2 ="update diagdistrib set date='".$date."', Em='1', Addition='2' where numTrace = $numTrace";
			$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base : ". $Requete_SQL2 .'<br/>'. mysql_error());}

		}
		
					/* Mise en brique (Ea)*/
		
		$mb=true;
		if (($T2[0]==$fact)&&(count($T2)==$sommeva+1))
					{	for ($i=1 ; (($i<($sommeva-1))&&($mb==true)) ;$i++)
						 	{	if ($T2[$i]==$T2[$i-1]+$fact)
							  		{$mb=true;}
								else
									{$mb=false;}
						 	}
					}
		if (($T2[0]==$fact)&&(count($T2)==$sommeva+1)&&($add==true)&&($mb==true)&&($T2[$sommeva]==$resfin))
			{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,Ea) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1')";
			$Requete_SQL2 ="update diagdistrib set date='".$date."',Ea='1'  where numTrace = $numTrace";
			$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base : ". $Requete_SQL2 .'<br/>'. mysql_error());}
		
					/*Addition ratée pour mise en brique (Ea=1) (Addition=2)*/
		
		if (($T2[0]==$fact)&&(count($T2)==$sommeva+1)&&($add==true)&&($mb==true)&&($T2[$sommeva]!=$resfin))
			{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,Ea,Addition) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','2')";
			$Requete_SQL2 ="update diagdistrib set date='".$date."',Ea='1', Addition='2' where numTrace = $numTrace";
			$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base : ". $Requete_SQL2 .'<br/>'. mysql_error());}
		
		
			
																	
					/* Condensation (Dc)*/
			
			$condi=true;
			for ($i=0 ; (($i<(count($T1)-2))&&($condi==true)) ;$i+=2)
						 	{	if (($T1[$i]=="*")&&($T1[$i+1]=="+"))
							  		{$condi=true;}
								else
									{$condi=false;}
						 	}
							
			if (($condi==true)&&(count($T1)==((2*$nva)-1))&&(in_array($va1,$T2))&&(in_array($va2,$T2))&&(in_array($va3,$T2))&&
			    (in_array($fact,$T2))&&($T2[$nva*2]==$resfin)&&($T1[count($T1)-1]=="*"))
			{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,Dc) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1')";
			$Dc=1;
			$Requete_SQL2 ="update diagdistrib set date='".$date."',Dc='1' where numTrace = $numTrace";
			$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base : ". $Requete_SQL2 .'<br/>'. mysql_error());
			}
					/* (Dc=1) et Erreur de calcul non identifiée (Add=4;Multi=4) pour (Dc)*/
			
			else if (($condi==true)&&(count($T1)==((2*$nva)-1))&&(in_array($va1,$T2)) && (in_array($va2,$T2))&&(in_array($va3,$T2))&& 
			         (in_array($fact,$T2))&&($T2[$nva*2]!=$resfin)&&($T1[count($T1)-1]=="*"))
			{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,Dc,Addition,Multiplication) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','4','4')";
		   $Dc=1;
		   $Requete_SQL2 ="update diagdistrib set date='".$date."',Dc='1', Addition='4', Multiplication='4' where numTrace = $numTrace";
		   $result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base :".$Requete_SQL2.'<br/>'.mysql_error());
		   }
			
					/* Code (M2=1) multiplication (x2)*/
			switch ($nva)
			{
			case "3" : $minva = min($va1,$va2,$va3);break;
						
			case "4" : $minva = min($va1,$va2,$va3,$va4);break;
						
			case "5" : $minva = min($va1,$va2,$va3,$va4,$va5);break;
			}

  			for ($i=0,$k=0 ; $i < count($T2) ;$i++)
				{	
					if ($T2[$i]==$minva)
		 		 		{$mdeux[$k] = $T2[$i];$k++;}
				}
			$resmdeux=($minva*$va1)+($minva*$va2)+($minva*$va3);
			
			if (($condi==true)&&(count($T1)==((2*$nva)-1))&&(in_array($va1,$T2))&&(in_array($va2,$T2))&&(in_array($va3,$T2))&&
			    (count($mdeux)>=$nva)&&($T2[$nva*2]==$resmdeux)&&($T1[count($T1)-1]=="*"))
			{ //$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,M2) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1')";
			$Requete_SQL2 ="update diagdistrib set date='".$date."',M2='1' where numTrace = $numTrace";
			$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base : ". $Requete_SQL2 .'<br/>'. mysql_error());
			}
			 
					/* Code  (M2=1) et erreur de calcul non identifiée (Add=4;Multi=4) */
																	
			else if (($condi==true)&&(count($T1)==((2*$nva)-1))&&(in_array($va1,$T2)) && (in_array($va2,$T2)) && (in_array($va3,$T2))&& (count($mdeux)>=$nva)&&($T2[$nva*2]!=$resmdeux)&&($T1[count($T1)-1]=="*")&&(isset($Dc) and $Dc!=1))
			{ //$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,M2,Addition,Multiplication) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','4','4')";
		$Requete_SQL2 ="update diagdistrib set date='".$date."',M2='1', Addition='4', Multiplication='4' where numTrace = $numTrace";
		$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base : ". $Requete_SQL2 .'<br/>'. mysql_error());
		}
																	 
					/* multiplication (x3) (M3=1)*/
																	
			for ($i=0,$k=0 ; $i < count($T2) ;$i++)
				{
				if ($T2[$i]==$nva)
		 		 {
					 $mtrois[$k] = $T2[$i];
					 $k++;
				 }
				}
			$resmtrois=($nva*$va1)+($nva*$va2)+($nva*$va3);
																	
			if (($condi==true)&&(count($T1)==((2*$nva)-1))&&(in_array($va1,$T2))&&(in_array($va2,$T2))&&(in_array($va3,$T2))&&
			    (count($mtrois)==$nva)&&($T2[$nva*2]==$resmtrois)&&($T1[count($T1)-1]=="*"))
			{
			//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,M3) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1')";
			$Requete_SQL2 ="update diagdistrib set date='".$date."',M3='1' where numTrace = $numTrace";
			$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base : ". $Requete_SQL2 .'<br/>'. mysql_error());

			}
			
								/* (M3=1) erreur de calcul non identifiée (Add=4;Multi=4)  */
																	
			else if (($condi==true)&&(count($T1)==((2*$nva)-1))&&(in_array($va1,$T2)) && (in_array($va2,$T2)) && (in_array($va3,$T2))&& (count($mtrois)==$nva)&&($T2[$nva*2]!=$resmtrois)&&($T1[count($T1)-1]=="*"))
			{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,M3,Addition,Multiplication) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','4','4')";
			$Requete_SQL2 ="update diagdistrib set date='".$date."',M3='1', Addition='4', Multiplication=4 where numTrace = $numTrace";
			$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base : ". $Requete_SQL2 .'<br/>'. mysql_error());	
			}
		
}
//fin nombre opérations=1

					//Explosion2 (Fe2)
if (count($tabOperation)==2)
{
		$pat1 = "/\d+/";$pat2 = "/\+/";
		//tableau des opérandes 
		preg_match_all($pat1,$tabSR[0],$tabOperande);
		$tabOper1 = $tabOperande[0];
		preg_match_all($pat2,$tabSR[0],$tabOperateur);
		$tabOperateur1 = $tabOperateur[0];
		$resOp1 = calcul2($tabOperateur,$tabOper);
		
		if(in_array($va1,$tabOper1) and in_array($va2,$tabOper1) and in_array($va3,$tabOper1)and count($tabOperateur1)==2)
		{
			$cond1=true;
		}	
		
		//tableau des opérandes 
		$nbResInt=0;
		preg_match_all($pat1,$tabSR[1],$tabOperande);
		$tabOper2 = $tabOperande[0];
		preg_match_all($pat2,$tabSR[1],$tabOperateur);
		$tabOperateur2 = $tabOperateur[0];
		$resOp2 = calcul2($tabOperateur,$tabOper);
		
		for($i=0;$i<count($tabOper2);$i++)
			if($tabOper2[$i]==$tabR[0])
				 $nbResInt=$nbResInt+1;

		if(count($tabOperateur2)==3 and $nbResInt==4)
		{
			$cond2=true;
		}	
	
		if(isset($cond1) and isset($cond2) and $cond1=true and $cond2=true)
		{
			if ($tabR[0]==$sommeva and $tabR[1]==$resfin)
			{
				$Requete_SQL2 ="update diagdistrib set date='".$date."',Fe2='1' where numTrace = $numTrace";
				$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base :".$Requete_SQL2.'<br/>'.mysql_error());
			}
			else if ($tabR[0]!=$sommeva and $tabR[1]==$resfin)
			{
				$Requete_SQL2 ="update diagdistrib set date='".$date."',Fe2='1', Addition='1' where numTrace = $numTrace";
				$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base :".$Requete_SQL2.'<br/>'.mysql_error());
			}
			else if ($tabR[0]==$sommeva and $tabR[1]!=$resfin)
			{
				$Requete_SQL2 ="update diagdistrib set date='".$date."',Fe2='1', Addition='2' where numTrace = $numTrace";
				$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base :".$Requete_SQL2.'<br/>'.mysql_error());
			}
			else if ($tabR[0]!=$sommeva and $tabR[1]!=$resfin)
			{
				$Requete_SQL2 ="update diagdistrib set date='".$date."',Fe2='1', Addition='3' where numTrace = $numTrace";
				$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base :".$Requete_SQL2.'<br/>'.mysql_error());
			}
		}
}
if (count($tabOperation)==$fact+1)
//print(count($tabOperation));exit;	
{		
		$int=true;
		$add=true;
			for ($i=0 ; (($i<$fact)&& ($int==true));$i++)
			{	$operation=$tabOperation[$i];
				$oper = trim(eregi_replace ('[^-|+|*|:]', " ",$operation));
				$T1 =  array_values(preg_split ("/[\s]+/", $oper));
				$operande = trim(eregi_replace ('[^0-9|,]', " ",$operation));
				$T2 = array_values(preg_split ("/[\s]+/", $operande));
				
				$add=true;
				for ($j=0; (($j < count($T1))&& ($add==true));$j++)
					{	if($T1[$j]=='+')
								{$add=true;}
		 				else
								{$add=false;}
					} 	
					//print($add);exit;
					
				if(($add==true)&&(in_array($va1,$T2)) && (in_array($va2,$T2)) && (in_array($va3,$T2)) && ($T2[$nva]==$sommeva)&&(count($T2)==$nva+1))
					{$int=true;}
				else {$int=false;}
			}
				//print($int);exit;
		
				$operation_f = $tabOperation[count($tabOperation)-1];
				$oper = trim(eregi_replace ('[^-|+|*|:]', " ",$operation_f));
				$T1 =  array_values(preg_split ("/[\s]+/", $oper));
				$operande = trim(eregi_replace ('[^0-9|,]', " ",$operation_f));
				$T2 = array_values(preg_split ("/[\s]+/", $operande));
				
				for ($i=0,$k=0 ; $i < count($T2) ;$i++)
				{	if ($T2[$i]!=$sommeva)
		  				{$diff[$k] = $T2[$i];$k++;}
				}
	
				//for ($i=0; $i < count($diff) ; $i++)
				//{print ($diff[$i]."<br>");}
				//exit;}
				$add=true;
				for ($i=0; (($i < count($T1))and ($add==true));$i++)
				{	if($T1[$i]=="+")
						{$add=true;}
				else
						{$add=false;}
				}

				if (($add==true)&&(count($diff)==1)&& (end($tabR)==$resfin)&&(count($T1)==$fact-1)&& ($int==true))
					{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,Fe2) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1')";
				 	$Requete_SQL2 ="update diagdistrib set date='".$date."',Fe2='1' where numTrace = $numTrace";
					$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base : ". $Requete_SQL2 .'<br/>'. mysql_error());}
					
					/*Addition finale ratée pour Fe2 (Fe2=1) (Addition=2)*/
					
				else if (($add==true)&&(count($diff)==1)&& (end($tabR)!=$resfin)&&(count($T1)==$fact-1)&& ($int==true))
				{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,Fe2,Addition) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','2')";
				 $Requete_SQL2 ="update diagdistrib set date='".$date."', Fe2='1', Addition='2' where numTrace = $numTrace";
				 $result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base:".$Requete_SQL2.'<br/>'.mysql_error());
				}
													
					/*Explosion 2 (Fe2) mais avec une ou plusieurs erreurs d'addition (Addition=1 ou 3)*/
					
			$addfausse=false;			
			for ($i=0 ; (($i<$fact)&& ($addfausse==false));$i++)
			{	$operation=$tabOperation[$i];
				$oper = trim(eregi_replace ('[^-|+|*|:]', " ",$operation));
				$T1 =  array_values(preg_split ("/[\s]+/", $oper));
				$operande = trim(eregi_replace ('[^0-9|,]', " ",$operation));
				$T2 = array_values(preg_split ("/[\s]+/", $operande));
				
				$add=true;
				for ($j=0; (($j < count($T1))&& ($add==true));$j++)
					{	if($T1[$j]=='+')
								{$add=true;}
		 				else
								{$add=false;}
					} 	
					//print($add);exit;
					
				if (($add==true)&&(in_array($va1,$T2)) && (in_array($va2,$T2)) && (in_array($va3,$T2)) && ($T2[$nva]!=$sommeva)&&(count($T2)==$nva+1))
					  	{$addfausse=true;}
				else 
						{$addfausse=false;}
			}
				if ($addfausse==true)
					{	for ($i=0 ; $i<$fact ;$i++)
						{	$operation=$tabOperation[$i];
							$oper = trim(eregi_replace ('[^-|+|*|:]', " ",$operation));
							$T1 =  array_values(preg_split ("/[\s]+/", $oper));
							$operande = trim(eregi_replace ('[^0-9|,]', " ",$operation));
							$T2 = array_values(preg_split ("/[\s]+/", $operande));
							$dif[$i]=$T2[$nva];
						}					
					
						for ($i=1; $i < $fact ;$i++)
						 {$som[0]=$dif[0];
						 $som[$i]=$som[$i-1]+$dif[$i];
						 }
					}
				//print($som[$fact-1]);exit;
		

				$operation_f = $tabOperation[count($tabOperation)-1];
				$oper = trim(eregi_replace ('[^-|+|*|:]', " ",$operation_f));
				$T1 =  array_values(preg_split ("/[\s]+/", $oper));
				$operande = trim(eregi_replace ('[^0-9|,]', " ",$operation_f));
				$T2 = array_values(preg_split ("/[\s]+/", $operande));
				
				for ($i=0,$k=0 ; $i < count($T2) ;$i++)
				{	if ($T2[$i]!=$sommeva)
		  				{$diff[$k] = $T2[$i];$k++;}
				}
	
				//for ($i=0; $i < count($diff) ; $i++)
				//{print ($diff[$i]."<br>");}
				//exit;}
				$add=true;
				for ($i=0; (($i < count($T1))and ($add==true));$i++)
				{	if($T1[$i]=="+")
						{$add=true;}
					else
						{$add=false;}
				}

					//Addition intermediaire ratée (Addition=1) (Fe2=1)

				if (($add==true) && ($T2[$fact]==$som[$fact-1])&&(count($T1)==$fact-1)&& ($addfausse==true))
					{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,Fe2,Addition) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','1')";
					$Requete_SQL2 ="update diagdistrib set date='".$date."', Fe2='1', Addition='1' where numTrace = $numTrace";
				 	$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base : ". $Requete_SQL2 .'<br/>'. mysql_error());}
					
					//Add intermediaire ratée  et Addition finale ratée (Addition=3)(Fe2=1) 
					
				if (($add==true) && ($T2[$fact]!=$som[$fact-1])&&(count($T1)==$fact-1)&& ($addfausse==true))
					{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,Fe2,Addition) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','3')";
				 	$Requete_SQL2 ="update diagdistrib set date='".$date."', Fe2='1', Addition='3' where numTrace = $numTrace";
					$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base : ". $Requete_SQL2 .'<br/>'. mysql_error());}
}

															
																														
					//Forme classique (F et erreurs de calculs)
if (count($tabOperation)==2)
															
					//Forme classique (F)
{		
				$operation=$tabOperation[0];
				$oper = trim(eregi_replace ('[^-|+|*|:]', " ",$operation));				
				$T1 = array_values(preg_split ("/[\s]+/", $oper));
				$operande = trim(eregi_replace ('[^0-9|,]', " ",$operation));
				$T2 = array_values(preg_split ("/[\s]+/", $operande));
				$add=true;
				for ($i=0; (($i < count($T1))and ($add==true));$i++)
					{	if($T1[$i]=="+")
								{$add=true;}
		 				else
								{$add=false;}
					} 	
					
				if(($add==true)&&(in_array($va1,$T2)) && (in_array($va2,$T2)) && (in_array($va3,$T2)) && ($T2[$nva]==$sommeva)&&(count($T2)==$nva+1))
					{$int=true;}
				else {$int=false;}
					//print($int); exit;
				$addrat=true;//Pour (Addition ratée)
				if(($add==true)&&(in_array($va1,$T2)) && (in_array($va2,$T2)) && (in_array($va3,$T2)) && ($T2[$nva]!=$sommeva)&&(count($T2)==$nva+1))//Pour (Fa)
					{$addrat=true; $saddrat=$T2[$nva];}//Pour (Addition ratée)
				else{$addrat=false;}//Pour (addition ratée)
					 
		
				$operation_f = $tabOperation[1];
				$oper = trim(eregi_replace ('[^-|+|*|:]', " ",$operation_f));
				$T1 =  array_values(preg_split ("/[\s]+/", $oper));
				$operande = trim(eregi_replace ('[^0-9|,]', " ",$operation_f));
				$T2 = array_values(preg_split ("/[\s]+/", $operande));
				
				if ((count($T1)==1)&&($T1[0]=="*")&& (in_array($fact,$T2)) && (in_array($sommeva,$T2))&&($T2[2]==$resfin)&&($int==true))
				
					{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,F) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1')";
					$Requete_SQL2 ="update diagdistrib set date='".$date."', F='1' where numTrace = $numTrace";
				 	$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base : ". $Requete_SQL2 .'<br/>'. mysql_error());}
					
					
			//erreur de retenu multiplicative
			$max = max (strlen($T2[0]),strlen($T2[1]));
			if(strlen($T2[0])<strlen($T2[1]))
			 {
				$fact=$T2[0];
				$r1Tab="".$T2[1];
				
			 }
			else
			 {
				$r1Tab="".$T2[0];
				$fact=$T2[1];
			 }
			
			for($i=0;$i<$max;$i++)
			{
				$tabInt[$i]=($r1Tab{$i}*$fact)%10;
			}
			$resErrR = implode($tabInt);

			if ((count($T1)==1)&&($T1[0]=="*")&&(in_array($fact,$T2))&&(end($T2)==$resErrR) && ($resfin!=$resErrR))  
					{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,F,Addition) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','1')";
				 	$Requete_SQL2 ="update diagdistrib set date='".$date."', F='1', Multiplication='2', Position='3' where numTrace = $numTrace";
					$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base : ". $Requete_SQL2 .'<br/>'. mysql_error());
					}
				
				//Addition ratée (Addition=1) pour(F)
				$som=$saddrat*$fact;
			if ((count($T1)==1)&&($T1[0]=="*")&& (in_array($fact,$T2)) && (in_array($saddrat,$T2))&&($T2[2]==$som)&&($addrat==true))  
					{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,F,Addition) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','1')";
				 	$Requete_SQL2 ="update diagdistrib set date='".$date."', F='1', Addition='1' where numTrace = $numTrace";
					$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base : ". $Requete_SQL2 .'<br/>'. mysql_error());}
					
					//Multiplication ratée (Multiplication=2) pour (F)
				
				if ((count($T1)==1)&&($T1[0]=="*")&& (in_array($fact,$T2)) && (in_array($sommeva,$T2))&&($T2[2]!=$resfin)&&($int==true))
					{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,F,Multiplication) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','2')";
					$Requete_SQL2 ="update diagdistrib set date='".$date."', F='1', Multiplication='2' where numTrace = $numTrace";
				 	$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base : ". $Requete_SQL2 .'<br/>'. mysql_error());}
					
					
					//Addition et multiplication ratée (Add=1 et Multi=2) pour(F)
				if ((count($T1)==1)&&($T1[0]=="*")&& (in_array($fact,$T2)) && (in_array($saddrat,$T2))&& ($T2[2]!=$som) &&($addrat==true))
					{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,F,Addition,Multiplication) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','1','2')";
					$Requete_SQL2 ="update diagdistrib set date='".$date."', F='1', Addition='1', Multiplication='2' where numTrace = $numTrace";
				 	$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base : ". $Requete_SQL2 .'<br/>'. mysql_error());}
					
					
					
					/*CODE Explosion1 (Fe) 2 opérations (2+6+7=15) et (15+15+15+15=60)*/
				$add=true;
				for ($i=0; (($i < count($T1))&&($add==true));$i++)
					{	if($T1[$i]=="+")
								{$add=true;}
		 				else
								{$add=false;}
					} 					
				
				for ($i=0,$k=0 ; $i < count($T2) ;$i++)
		 		{	 if ($T2[$i]!=$sommeva)
		  	    	  {$diff[$k] = $T2[$i];$k++;}
		 		}
	
		//for ($i=0; $i < count($diff) ; $i++)
		//{print ($diff[$i]."<br>");}
		//exit;}
		
				if (($add==true)&&(count($diff)==1)&& ($diff[0]==$resfin)&&(count($T1)==$fact-1)&&($int==true))
				{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,Fe) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1')";
			 	 $Requete_SQL2 ="update diagdistrib set date='".$date."', Fe='1' where numTrace = $numTrace";
				 $result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base :".$Requete_SQL2.'<br/>'.mysql_error());}
				 
				 //Addition finale ratée (Addition=2) pour(Fe(2 opérations))
				 if (($add==true)&&(count($diff)==1)&& ($diff[0]!=$resfin)&&(count($T1)==$fact-1)&&($int==true))
				{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,Fe,Addition) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','2')";
			 	 $Requete_SQL2 ="update diagdistrib set date='".$date."', Fe='1', Addition='2' where numTrace = $numTrace";
				 $result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base :".$Requete_SQL2.'<br/>'.mysql_error());}
					
						
					//Addition intermediaire ratée (Addition=1) pour(Fe(2 opérations))
				for ($i=0,$k=0 ; $i < count($T2) ;$i++)
		 		{	 if ($T2[$i]!=$saddrat)
		  	    	  {$di[$k] = $T2[$i];$k++;}
		 		}
																
				
				if ((count($T1)==$fact-1)&&($add==true)&& ($T2[$fact]==$som)&&($addrat==true)&&(count($di)==1)&&($di[0]==$som))  
					{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,Fe,Addition) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','1')";
					$Requete_SQL2 ="update diagdistrib set date='".$date."', Fe='1', Addition='1' where numTrace = $numTrace";
				 	$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base : ". $Requete_SQL2 .'<br/>'. mysql_error());}
					
					//Addition intermédiaire et finale ratée (Addition=3) pour(Fe(2 opérations))
					
				if ((count($T1)==$fact-1)&&($add==true)&& ($T2[$fact]!=$som)&&($addrat==true)&&(count($di)==1)&&($di[0]!=$som))  
					{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,Fe,Addition) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','3')";
					$Requete_SQL2 ="update diagdistrib set date='".$date."', Fe='1', Addition='3' where numTrace = $numTrace";
				 	$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base : ". $Requete_SQL2 .'<br/>'. mysql_error());}
}

//Fin 2 opérations

						//Explosion1 (De) et  Explosion2 (De2)
if (count($tabOperation)==$nva+1)				
{					
			$add=true;
			$sommeDif1=0;$sommeDif2=0;$sommeDif3=0;//initialisation
			for ($l=0 ; (($l<$nva)&& ($add==true));$l++)
			{	
				$operation=$tabOperation[$l];
				$oper = trim(eregi_replace ('[^-|+|*|:]', " ",$operation));
				$T1 =  array_values(preg_split ("/[\s]+/", $oper));
				$operande = trim(eregi_replace ('[^0-9|,]', " ",$operation));
				$T2 = array_values(preg_split ("/[\s]+/", $operande));
				$add=true;
				for ($j=0; (($j < count($T1))&& ($add==true));$j++)
					{	if($T1[$j]=='+')
								{$add=true;}
		 				else
								{$add=false;}
					} 	
					//print($add);exit;
				if (count($T1)==$fact-1)
				{	
				  for ($i=0,$k=0 ; $i < $fact ;$i++)
					if ($T2[$i]==$va1)
					 {
						$dif1[$k] = $T2[$i];
						$sommeDif1=$sommeDif1+$dif1[$k];
					 	$k++;
					 }
				}
				if (($T2[$va1]==$r1)&&(count($T2)==$va1+1))//pour (De2)
				{	for ($i=0,$k=0 ; $i < $va1 ;$i++)
					{	if ($T2[$i]==$fact)
		  				{$diffe1[$k] = $T2[$i];$k++;}
					}
				}											//pour (De2)
			 }
			
			$add=true;
			for ($l=0 ; (($l<$nva)&& ($add==true));$l++)
			{	$operation=$tabOperation[$l];
				$oper = trim(eregi_replace ('[^-|+|*|:]', " ",$operation));
				$T1 =  array_values(preg_split ("/[\s]+/", $oper));
				$operande = trim(eregi_replace ('[^0-9|,]', " ",$operation));
				$T2 = array_values(preg_split ("/[\s]+/", $operande));
				$add=true;
				for ($j=0; (($j < count($T1))&& ($add==true));$j++)
					{	if($T1[$j]=='+')
								{$add=true;}
		 				else
								{$add=false;}
					} 	
					
				if (count($T1)==$fact-1)
				{	
				  for ($i=0,$k=0 ; $i < $fact ;$i++)
					if ($T2[$i]==$va2)
					 {
						$dif2[$k] = $T2[$i];
						$sommeDif2=$sommeDif2+$dif2[$k];
					 	$k++;
					 }
				}
				
				if (($T2[$va2]==$r2)&&(count($T2)==$va2+1))// Pour (De2)
				
				{	for ($i=0,$k=0 ; $i < $va2 ;$i++)
					{	if ($T2[$i]==$fact)
		  				{$diffe2[$k] = $T2[$i];$k++;}
					}
				}											// Pour (De2)
			 }
			
			$add=true;
			for ($l=0 ; (($l<$nva)&& ($add==true));$l++)
			{	$operation=$tabOperation[$l];
				$oper = trim(eregi_replace ('[^-|+|*|:]', " ",$operation));
				$T1 =  array_values(preg_split ("/[\s]+/", $oper));
				$operande = trim(eregi_replace ('[^0-9|,]', " ",$operation));
				$T2 = array_values(preg_split ("/[\s]+/", $operande));
				$add=true;
				for ($j=0; (($j < count($T1))&& ($add==true));$j++)
					{	if($T1[$j]=='+')
								{$add=true;}
		 				else
								{$add=false;}
					} 	
					//print($add);exit;
				if (count($T1)==$fact-1)
				{	
				  for ($i=0,$k=0 ; $i < $fact ;$i++)
					if ($T2[$i]==$va3)
					 {
						$dif3[$k] = $T2[$i];
						$sommeDif3=$sommeDif3+$dif3[$k];
					 	$k++;
						
					 }
				}
				if (($T2[$va3]==$r3)&&(count($T2)==$va3+1))// Pour (De2)
				{
					for ($i=0,$k=0 ; $i < $va3 ;$i++)
					{	if ($T2[$i]==$fact)
		  				{$diffe3[$k] = $T2[$i];$k++;}
					}										// Pour (De2)
				}
			 }
			 
			 $operation_f = $tabOperation[count($tabOperation)-1];
				$oper = trim(eregi_replace ('[^-|+|*|:]', " ",$operation_f));
				$T1 =  array_values(preg_split ("/[\s]+/", $oper));
				$operande = trim(eregi_replace ('[^0-9|,]', " ",$operation_f));
				$T2 = array_values(preg_split ("/[\s]+/", $operande));
				
				$add=true;
				for ($i=0; (($i < count($T1))and ($add==true));$i++)
				{	if($T1[$i]=="+")
						{$add=true;}
				else
						{$add=false;}
				}
			if(($add==true)&&(in_array($r1,$T2)) && (in_array($r2,$T2)) && (in_array($r3,$T2)) && ($T2[$nva]==$resfin)&&(count($T2)==$nva+1))
				{$opfin=true;}
			else 
				{$opfin=false;}
							
			if(($add==true)&&(in_array($r1,$T2)) && (in_array($r2,$T2)) && (in_array($r3,$T2)) && ($T2[$nva]!=$resfin)&&(count($T2)==$nva+1))
				{$erradd=true;}
			else
				{$erradd=false;}

//erreur d'addition dans le calcul intermédiaire 
//print_r($tabR);
if (in_array($r1,$tabR) and in_array($r2,$tabR) and in_array($r3,$tabR))
	$errAddDe=false;
else 
	$errAddDe=true; 

		if ((count($dif1)==$fact)&&(count($dif2)==$fact)&&(count($dif3)==$fact)&&($opfin==true)&&($errAddDe==false))
			{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,De) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1')";
			 $Requete_SQL2 ="update diagdistrib set date='".$date."', De='1' where numTrace = $numTrace";
			 $result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base :".$Requete_SQL2.'<br/>'.mysql_error());}
			 
			 					//Addition finale ratée (Addition=2) pour (De)
			 
		if ((count($dif1)==$fact)&&(count($dif2)==$fact)&&(count($dif3)==$fact)&&($erradd==true))
			{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,De,Addition) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','2')";
			 $Requete_SQL2 ="update diagdistrib set date='".$date."', De='1', Addition='2' where numTrace = $numTrace";
			 $result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base :".$Requete_SQL2.'<br/>'.mysql_error());
			 }
								//Addition intermédiaire ratée (Addition=1) pour (De)
		if ((count($dif1)==$fact)&&(count($dif2)==$fact)&&(count($dif3)==$fact)&&($errAddDe==true))
			{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,De,Addition) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','2')";
			 $Requete_SQL2 ="update diagdistrib set date='".$date."', De='1', Addition='1' where numTrace = $numTrace";
			 $result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base :".$Requete_SQL2.'<br/>'.mysql_error());
			 }
								//Addition intermédiaire et final ratées (Addition=3) pour (De)
		if ((count($dif1)==$fact)&&(count($dif2)==$fact)&&(count($dif3)==$fact)&&($erradd==true)&&($errAddDe==true))
			{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,De,Addition) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','2')";
			 $Requete_SQL2 ="update diagdistrib set date='".$date."', De='1', Addition='3' where numTrace = $numTrace";
			 $result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base :".$Requete_SQL2.'<br/>'.mysql_error());
			 }
				 
				 				//Explosion2 (De2)
		
		if ((count($diffe1)==$va1)&&(count($diffe2)==$va2)&&(count($diffe3)==$va3)&&($opfin==true))
			{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,De2) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1')";
			 $Requete_SQL2 ="update diagdistrib set date='".$date."', De2='1' where numTrace = $numTrace";
			 $result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base :".$Requete_SQL2.'<br/>'.mysql_error());}
				
								//Addition finale ratée (Addition=2) pour (De2)
				
		if ((count($diffe1)==$va1)&&(count($diffe2)==$va2)&&(count($diffe3)==$va3)&&($erradd==true))
			{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,De2,Addition) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','2')";
			 $Requete_SQL2 ="update diagdistrib set date='".$date."', De2='1', Addition='1' where numTrace = $numTrace";
			 $result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base :".$Requete_SQL2.'<br/>'.mysql_error());}

		
								//Addition intermédiaire ratée (Addition=1) pour (De2)
				
		if ((count($diffe1)==$va1)&&(count($diffe2)==$va2)&&(count($diffe3)==$va3)&&($errAddDe==true))
			{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,De2,Addition) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','2')";
			 $Requete_SQL2 ="update diagdistrib set date='".$date."', De2='1', Addition='2' where numTrace = $numTrace";
			 $result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base :".$Requete_SQL2.'<br/>'.mysql_error());}

								//Addition intermédiaire et final ratées (Addition=3) pour (De2)
				
		if ((count($diffe1)==$va1)&&(count($diffe2)==$va2)&&(count($diffe3)==$va3)&&($errAddDe==true)&&($erradd==true))
			{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,De2,Addition) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','2')";
			 $Requete_SQL2 ="update diagdistrib set date='".$date."', De2='1', Addition='3' where numTrace = $numTrace";
			 $result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base :".$Requete_SQL2.'<br/>'.mysql_error());}
								
								//Forme classique (D)


			$mul=true;
			for ($i=0, $k=0; (($i<$nva)&& ($mul==true));$i++)
			{	
				$operation=$tabOperation[$i];
				$oper = trim(eregi_replace ('[^-|+|*|:]', " ",$operation));
				$T1 =  array_values(preg_split ("/[\s]+/", $oper));
				$operande = trim(eregi_replace ('[^0-9|,]', " ",$operation));
				$T2 = array_values(preg_split ("/[\s]+/", $operande));
				//$a=array_count_values($T2);
				//print ($a[$fact]);exit;
				
				$mul=true;
				for ($j=0; (($j < count($T1))&& ($mul==true));$j++)
					{	if($T1[$j]=='*')
								{$mul=true;}
		 				else
								{$mul=false;}
					} 	
								
				if ((count($T1)==1)&&(count($T2)==3))
				
				{	for ($z=0 ; $z < 2 ;$z++)
					{	if ($T2[$z]!=$fact)
		  				{$valvar[$k] = $T2[$z];$k++;}
					}
					$resint[$i]=$T2[2];
				}
			}
		/*for ($y=0; $y < count($resint) ; $y++)
		{print ($resint[$y]."<br>");}
		exit;*/
			
		if ((count($valvar)==$nva)&&(in_array($va1,$valvar))&&(in_array($va2,$valvar)) && (in_array($va3,$valvar)))
			{$dev=true;}
		else
			{$dev=false;}
			
		if (($dev==true)&&(in_array($r1,$resint)) && (in_array($r2,$resint)) && (in_array($r3,$resint)))
			{$operint=true;}
		else
			{$operint=false;}
		
		if (($dev==true)&&($operint==false))
			{$erad=true;
			$somadint=$resint[0]+$resint[1]+$resint[2];}
		else
			{$erad=false;}
			
		
		$operation_f = $tabOperation[count($tabOperation)-1];
				$oper = trim(eregi_replace ('[^-|+|*|:]', " ",$operation_f));
				$T1 =  array_values(preg_split ("/[\s]+/", $oper));
				$operande = trim(eregi_replace ('[^0-9|,]', " ",$operation_f));
				$T2 = array_values(preg_split ("/[\s]+/", $operande));
				
				$add=true;
				for ($i=0; (($i < count($T1))and ($add==true));$i++)
				{	if($T1[$i]=="+")
						{$add=true;}
				else
						{$add=false;}
				}
			if(($add==true)&&(in_array($r1,$T2)) && (in_array($r2,$T2)) && (in_array($r3,$T2)) && ($T2[$nva]==$resfin)&&(count($T2)==$nva+1))
				{$opfin=true;}
			else 
				{$opfin=false;}
							
			if(($add==true)&&(in_array($r1,$T2)) && (in_array($r2,$T2)) && (in_array($r3,$T2)) && ($T2[$nva]!=$resfin)&&(count($T2)==$nva+1))
				{$erraddfin=true;}
			else
				{$erraddfin=false;}
			if(($add==true)&&(in_array($resint[0],$T2)) && (in_array($resint[1],$T2)) && (in_array($resint[2],$T2)) && ($T2[$nva]==$somadint)&&(count($T2)==$nva+1))
				{$addfjust=true;}
			else
				{$addfjust=false;}
			if(($add==true)&&(in_array($resint[0],$T2)) && (in_array($resint[1],$T2)) && (in_array($resint[2],$T2)) && ($T2[$nva]!=$somadint)&&(count($T2)==$nva+1))
				{$addffx=true;}
			else
				{$addffx=false;}
						
		if (($operint==true)&&($opfin==true))
			{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,D) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1')";
			 $Requete_SQL2 ="update diagdistrib set date='".$date."', D='1' where numTrace = $numTrace";
			 $result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base :".$Requete_SQL2.'<br/>'.mysql_error());}
			//unité mal placé
			if ($r1%10==$r1) $r11=$r1*10; else $r11=$r1;
			if ($r2%10==$r2) $r21=$r2*10; else $r21=$r2;
			if ($r3%10==$r3) $r31=$r3*10; else $r31=$r3;
			$resMP=$r11+$r21+$r31;
	
			if ((count($T1)==($nva-1))&&($add==true)&& (in_array($r1,$T2)) && (in_array($r2,$T2)) && (in_array($r3,$T2)) &&($T2[$nva]!=$resfin)&&($T2[$nva]==$resMP))
			{
			$Requete_SQL2 ="update diagdistrib set date='".$date."', D='1',  Addition='2', Position='1' where numTrace = $numTrace";
			$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base : ".$Requete_SQL2 .'<br/>'.mysql_error());
			}
			//erreur de retenu 
			$max = max (strlen($r1),strlen($r2),strlen($r3));
			$r1Tab="".$r1;
			if(strlen($r1)<$max)
			{
				$diff=$max-strlen($r1);
				for($i=0;$i<$diff;$i++)
				  $r1Tab="0".$r1Tab;
			}
			
			$r2Tab="".$r2;
			if(strlen($r2)<$max)
			{
				$diff=$max-strlen($r2);
				for($i=0;$i<$diff;$i++)
				  $r2Tab="0".$r2Tab;
			}
			$r3Tab="".$r3;
			if(strlen($r3)<$max)
			{
				$diff=$max-strlen($r3);
				for($i=0;$i<$diff;$i++)
				  $r3Tab="0".$r3Tab;
			}
			for($i=0;$i<$max;$i++)
			{
				$tabInt[$i]=($r1Tab{$i}+$r2Tab{$i}+$r3Tab{$i})%10;
			}
			//print_r($tabInt);
			$resErrR = implode($tabInt);
			if ((count($T1)==($nva-1))&&($add==true) && (in_array($r1,$T2)) && (in_array($r2,$T2)) && (in_array($r3,$T2))
					&&($T2[$nva]==$resErrR))
			{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,D,Cimp,Addition,Position) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','1','2','2')";
		 	$Requete_SQL2 ="update diagdistrib set date='".$date."',D='1',Addition='2',Position='2' where numTrace = $numTrace";
			$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base : ". $Requete_SQL2 .'<br/>'. mysql_error());}									

				// Addition finale ratée (Addition =2) pour (D)
				
		if (($operint==true)&&($erraddfin==true))
				{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,D,Addition) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','2')";
			 	 $Requete_SQL2 ="update diagdistrib set date='".$date."', D='1', Addition='2' where numTrace = $numTrace";
				 $result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base :".$Requete_SQL2.'<br/>'.mysql_error());}
				 
				 //multiplication int ratée (Multiplication=1) pour (D)
		if (($erad==true)&&($addfjust==true))
				{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,D,Multiplication) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','1')";
			 	 $Requete_SQL2 ="update diagdistrib set date='".$date."', D='1', Multiplication='1' where numTrace = $numTrace";
				 $result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base :".$Requete_SQL2.'<br/>'.mysql_error());}
		
		 		//multiplication int ratée (multiplication=1) et addition fin ratée(Add=2) pour (D)
		if (($erad==true)&&($addffx==true))
				{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,D,Addition,Multiplication) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','2','1')";
			 	 $Requete_SQL2 ="update diagdistrib set date='".$date."', D='1', Addition='2', Multiplication='1' where numTrace = $numTrace";
				 $result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base :".$Requete_SQL2.'<br/>'.mysql_error());} 
		 
				 
				 			//Forme classique (D)
																

						//Forme classique (D) (méthode non utilisée)
/*if (count($tabOperation)==$nva+1)
//print(count($tabOperation));exit;
{			$etape=true;
			for ($i=0 ; (($i<$nva)&&($etape==true)); $i++)
			{	
				$operation=$tabOperation[$i];				
			
			}
				$tabbase[0]=$fact."*".$va1."=".$r1;
				$tabbase[1]=$fact."*".$va2."=".$r2;
				$tabbase[2]=$fact."*".$va3."=".$r3;
				$tabbase1[0]=$va1."*".$fact."=".$r1;
				$tabbase1[1]=$va2."*".$fact."=".$r2;
				$tabbase1[2]=$va3."*".$fact."=".$r3;
				$tabbase2[0]=$r1."=".$fact."*".$va1;
				$tabbase2[1]=$r2."=".$fact."*".$va2;
				$tabbase2[2]=$r3."=".$fact."*".$va3;
				$tabbase3[0]=$r1."=".$va1."*".$fact;
				$tabbase3[1]=$r2."=".$va2."*".$fact;
				$tabbase3[2]=$r3."=".$va3."*".$fact;
							
			
					if (	
							((in_array($tabbase[0],$tabOperation))||(in_array($tabbase1[0],$tabOperation))||(in_array($tabbase2[0],$tabOperation))||(in_array($tabbase3[0],$tabOperation)))			
						&&	((in_array($tabbase[1],$tabOperation))||(in_array($tabbase1[1],$tabOperation))||(in_array($tabbase2[1],$tabOperation))||(in_array($tabbase3[1],$tabOperation)))		
						&&  ((in_array($tabbase[2],$tabOperation))||(in_array($tabbase1[2],$tabOperation))||(in_array($tabbase2[2],$tabOperation))||(in_array($tabbase3[2],$tabOperation)))		
						)
						{$etape=true;}	
					else 
						{$etape=false;}
				
					
				$operation_f = $tabOperation[count($tabOperation)-1];
				$oper = trim(eregi_replace ('[^-|+|*|:]', " ",$operation_f));
				$T1 =  array_values(preg_split ("/[\s]+/", $oper));
				$operande = trim(eregi_replace ('[^0-9|,]', " ",$operation_f));
				$T2 = array_values(preg_split ("/[\s]+/", $operande));
				
				$add=true;
				for ($i=0; (($i < count($T1))and ($add==true));$i++)
				{	if($T1[$i]=="+")
						{$add=true;}
				else
						{$add=false;}
				}
			if(($add==true)&&(in_array($r1,$T2)) && (in_array($r2,$T2)) && (in_array($r3,$T2)) && ($T2[$nva]==$resfin)&&(count($T2)==$nva+1)&&($etape==true))
				{$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,D) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1')";
			 	 $result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base :".$Requete_SQL2.'<br/>'.mysql_error());}
													
}
				
			*/					
									 		
				
												
}					
				
						 //Développement incomplet (Di)
																			
if (count($tabOperation)==$nva)
{
			$mul=true;
			for ($i=0, $k=0; (($i<$nva)&& ($mul==true));$i++)
			{	$operation=$tabOperation[$i];
				$oper = trim(eregi_replace ('[^-|+|*|:]', " ",$operation));
				$T1 =  array_values(preg_split ("/[\s]+/", $oper));
				$operande = trim(eregi_replace ('[^0-9|,]', " ",$operation));
				$T2 = array_values(preg_split ("/[\s]+/", $operande));
				//$a=array_count_values($T2);
				//print ($a[$fact]);exit;
				
				$mul=true;
				for ($j=0; (($j < count($T1))&& ($mul==true));$j++)
					{	if($T1[$j]=='*')
								{$mul=true;}
		 				else
								{$mul=false;}
					} 	
					
			
				if ((count($T1)==1)&&(count($T2)==3))
				
				{	for ($z=0 ; $z < 2 ;$z++)
					{	if ($T2[$z]!=$fact)
		  				{$valvar[$k] = $T2[$z];$k++;}
					}
					$resint[$i]=$T2[2];
				}
			}
		/*for ($y=0; $y < count($resint) ; $y++)
		{print ($resint[$y]."<br>");}
		exit;*/
			
		if ((count($valvar)==$nva)&&(in_array($va1,$valvar))&&(in_array($va2,$valvar)) && (in_array($va3,$valvar)))
			{$dev=true;}
		else
			{$dev=false;}
			
		if (($dev==true)&&(in_array($r1,$resint)) && (in_array($r2,$resint)) && (in_array($r3,$resint)))
			{$operint=true;}
		else
			{$operint=false;}
		
		if (($dev==true)&&($operint==true))
			{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,Di) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1')";
			 $Requete_SQL2 ="update diagdistrib set date='".$date."', Di='1' where numTrace = $numTrace";
			 $result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base :".$Requete_SQL2.'<br/>'.mysql_error());}
			 
						//multiplication int ratée (Multiplication=1) pour (Di)
		if (($dev==true)&&($operint==false))
				{//$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,Di,Multiplication) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1','1')";
				 $Requete_SQL2 ="update diagdistrib set date='".$date."', Di='1', Multiplication='1' where numTrace = $numTrace";			 	
				 $result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base :".$Requete_SQL2.'<br/>'.mysql_error());}
				
}

						/*Développement incomplet (non utilisée)

	if (count($tabOperation)==$nva)
{
			for ($i=0 ; $i<$nva; $i++)
			{	
			$operation=$tabOperation[$i];				
			}

			$tabbase[0]=$fact."*".$va1."=".$r1;
			$tabbase[1]=$fact."*".$va2."=".$r2;
			$tabbase[2]=$fact."*".$va3."=".$r3;
			$tabbase1[0]=$va1."*".$fact."=".$r1;
			$tabbase1[1]=$va2."*".$fact."=".$r2;
			$tabbase1[2]=$va3."*".$fact."=".$r3;
			$tabbase2[0]=$r1."=".$fact."*".$va1;
			$tabbase2[1]=$r2."=".$fact."*".$va2;
			$tabbase2[2]=$r3."=".$fact."*".$va3;
			$tabbase3[0]=$r1."=".$va1."*".$fact;
			$tabbase3[1]=$r2."=".$va2."*".$fact;
			$tabbase3[2]=$r3."=".$va3."*".$fact;
						
			
			if (	
						((in_array($tabbase[0],$tabOperation))||(in_array($tabbase1[0],$tabOperation))||(in_array($tabbase2[0],$tabOperation))||(in_array($tabbase3[0],$tabOperation)))			
					&&	((in_array($tabbase[1],$tabOperation))||(in_array($tabbase1[1],$tabOperation))||(in_array($tabbase2[1],$tabOperation))||(in_array($tabbase3[1],$tabOperation)))		
					&&  ((in_array($tabbase[2],$tabOperation))||(in_array($tabbase1[2],$tabOperation))||(in_array($tabbase2[2],$tabOperation))||(in_array($tabbase3[2],$tabOperation)))		
				)
					{$Requete_SQL2 ="INSERT INTO diagdistrib (numSerie,numEleve,date,numExo,Di) VALUES ('".$numSerie."','".$numEleve."','".$date."','".$n."','1')";
			 		 $result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base :".$Requete_SQL2.'<br/>'.mysql_error());}
	
}
print_r($taboperation);
print_r($taboperation2);
exit();
	*/
		
	/* (Ej) Adjonction  4+4=8 ; 8+4+4...+4=36 ; 36+4+...+4=60*/
if(isset($tabOp1) && count($tabOp1)==$nva)
{
	if($nva==3)
		$variable=array($va1,$va2,$va3);
	else if($nva==4)
		$variable=array($va1,$va2,$va3,$va4);
	else if($nva==5)
		$variable=array($va1,$va2,$va3,$va4,$va5);
	
	for($i=0;$i<$nva;$i++)
	{
		$tabNbOp[]=substr_count($tabOp1[$i],'+');
		$tabNbFact[]=substr_count($tabOp1[$i],$fact);
	}
	$tabComp1=array_diff($tabNbFact,$variable);
	if(count($tabComp1)==0)
	{
		$val1=$va1-1;
		$r22=$r2+$r1;
		$r33=$r3+$r22;
		//$r44=$r4+$r33;
		//$r55=$r5+$r44;
		//echo("<br>val1=".$val1." r22= ".$r22." r33=".$r33." r44=".$r44." r55=".$r55);
		//print("nb=".substr_count($tabOp1[0],$r1));		
		//print("nb=".substr_count($tabOp1[1],$r22));

		if(
			($tabNbOp[0]==$val1 and substr_count($tabOp1[0],$r1)==1)
		and ($tabNbOp[1]==$va2 and substr_count($tabOp1[1],$r1)==1 and substr_count($tabOp1[1],$r22)==1)
		and ($tabNbOp[2]==$va3 and substr_count($tabOp1[2],$r22)==1 and  substr_count($tabOp1[2],$r33)==1)
		  )
			{
		$Requete_SQL2 ="update diagdistrib set date='".$date."', Ej='1' where numTrace = $numTrace";
		$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base : ". $Requete_SQL2 .'<br/>'. mysql_error());			
		 print("ok pour Ej");
			}
			else
		 print("ok pour Ej2");
	}
}

	//print_r($tabNbOp);
	//print_r($tabNbFact);
	//exit();
	
	
	/* fin (Ej) */

if(!isset($Requete_SQL2))
{
/* $Requete_SQL2 = "update diagdistrib set 
				numSerie=$numSerie,date='".$date."',numExo=$n, 
				D=0, Dc=0, De=0, De2=0, F=0, Fc=0, Fe=0, Fe2=0, Addition=0, Multiplication=0, Position=0, 
				B=0 At=0, M=0, M2=0, M3=0, N=0, A=0, Di=0, Em=0, Ed=0, Ea=0, Ej=0, Cimp=0 
				where numTrace = $numTrace";
$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base : ". $Requete_SQL2 .'<br/>'. mysql_error());
 */}

$typeExo="d";
$text=addslashes($text);

/* $Requete_SQL = "INSERT INTO trace (numEleve,numSerie,numExo,typeExo,sas ,
				operation1, operation2, operande1, operande2,zonetext,resultat) VALUES
				('".$numEleve."','".$numSerie."','".$n."','".$typeExo."','".$sas."',
				'".$oper_1."','".$oper_2."','".$op_1."','".$op_2."','".$text."','".$_POST['resultat1']."')";
// Execution de la requete SQL.
$result = mysql_query($Requete_SQL) or die("Erreur d'Insertion dans la base : ". $Requete_SQL .'<br/>'. mysql_error());
 */
$Requete_SQL3 = "select id from trace order by id desc limit 1";
$result3 = mysql_query($Requete_SQL3) or die("Erreur d'Insertion dans la base : ". $Requete_SQL3 .'<br/>'. mysql_error());
while ($r = mysql_fetch_assoc($result3))
			{
			$idTrace = $r["id"];
			}
$Requete_SQL4 = "select id from diagdistrib order by id desc limit 1";
$result4 = mysql_query($Requete_SQL4) or die("Erreur d'Insertion dans la base : ". $Requete_SQL4 .'<br/>'. mysql_error());
while ($r = mysql_fetch_assoc($result4))
			{
			$idDiag = $r["id"];
			}
$Requete_SQL5 ="UPDATE diagdistrib SET numTrace='".$idTrace."' WHERE id='".$idDiag."'";
// Execution de la requete SQL.
$result = mysql_query($Requete_SQL5) or die("Erreur d'Insertion dans la base : ". $Requete_SQL5 .'<br/>'. mysql_error());
//affichr les resultats
$Requete_SQL6 ="select * from diagdistrib where numTrace=".$numTrace;
$result = mysql_query($Requete_SQL6) or die("Erreur d'Insertion dans la base : ". $Requete_SQL5 .'<br/>'. mysql_error());

 while ($r = mysql_fetch_array($result))
	{
		echo (" D = ".$r["D"]." Dc = ".$r["Dc"]." De = ".$r["De"]." De2 = ".$r["De2"]." F = ".$r["F"]." Fc = ".$r["Fc"]." Fe = ".$r["Fe"]." Fe2 = ".$r["Fe2"]."  Addition = ".$r["Addition"]." Multiplication = ".$r["Multiplication"]." Position = ".$r["Position"]." B = ".$r["B"]." At = ".$r["At"]." M = ".$r["M"]." M2 = ".$r["M2"]." M3 = ".$r["M3"]." N= ".$r["N"]." A= ".$r["A"]." Di = ".$r["Di"]." Em= ".$r["Em"]." Ed = ".$r["Ed"]." Ea= ".$r["Ea"]." Ej= ".$r["Ej"]." Cimp = ".$r["Cimp"]);
     }
$result = mysql_query($Requete_SQL6) or die("Erreur d'Insertion dans la base : ". $Requete_SQL5 .'<br/>'. mysql_error());
unset($Requete_SQL6,$Requete_SQL5,$Requete_SQL4,$Requete_SQL3,$Requete_SQL2,$Requete_SQL1,$Requete_SQL,$result);
unset($tabCal,$tab1,$tab2,$tab3,$tabOp1,$tabOp2,$tabOp3,$tabOperation,$tapbase,$operation,$tabImp,$a,$operation_f );
unset($text,$longeur,$calcules,$calcules2,$va1,$va2,$va3,$va4,$va5,$fact,$nva,$tabOperande,$numeros,$nombre);
unset($r1Tab,$r2Tab,$tabInt,$resErrR,$add,$mul,$resint,$dev,$erad,$somadint,$i,$j,$k,$diffe1,$diffe2,$diffe3,$max,$r,$r1,$r2,$r3,$resMP,$T1,$T2,$T3);
unset($dif1,$somadint,$tabNbOp,$tabNbFact,$_SESSION,$r1Tab,$max,$tabInt,$v1,$v2,$v3,$re, $mtrois,$int);
unset($mul,$i,$k,$T1,$T2,$a,$j,$z,$k,$resint,$y,$dev,$operint,$erad,$somadint,$erad,$operation_f,$oper,$operande,$add,$opfin,$erraddfin,$addfjust,$addffx, $r11, $r21,$r31,$resMP,$max,$r1Tab,$diff,$r2Tab,$r3Tab,$tabInt,$resErrR,$valvar);

?>