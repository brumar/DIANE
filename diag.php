<?php
 session_start();
//echo ($_SESSION['num']);
//echo($_SESSION['type']);
//echo ($num);
//echo ($type);  
 $n = (int) $_SESSION['num'];
 $t = $_SESSION['type'];
 $text = $_POST[zonetexte];
 if ($text=='')
 {
 print ("vous n'avez rien saisie");
 print(" colonne1 = 9 "); $colonne1=9;
 exit() ;
 }
 //print($text."<br>");
 //suprime tous caractere different de [^\d+-=:*]
 $calcules = trim(eregi_replace ('[^0-9|,|+|*|:|=|-]', " ",$text));
//print($calcules);
 $tabCal =  preg_split ("/[\s]+/", $calcules);
 for ($i=0; $i < count($tabCal) ; $i++)
	{
	switch ($tabCal[$i])
		{
		case "+" :if (($tabCal[$i+2]=="=") && ((ereg("[^\+\-]",$tabCal[$i-2]))||($tabCal[$i-2]=="")))
					 {
						 $tabOperation[] =$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
					 }
				   else if (($tabCal[$i+2]=="+")||($tabCal[$i+2]=="-"))
						 {
							 if ($tabCal[$i+4]=="=")
							 {
							 $tabOperation[] =$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3].$tabCal[$i+4].$tabCal[$i+5];
							 $tabOperation2[] =$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3].$tabCal[$i+4].$tabCal[$i+5];
							 }
						 }
						 else if (ereg("[0-9]",$tabCal[$i+2])|| $tabCal[$i+2]=="")
								$tabOperation[] =$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1];
				 break;
		case "-" :if (($tabCal[$i+2]=="=") && ((ereg("[^\+\-]",$tabCal[$i-2]))||($tabCal[$i-2]=="")))
					 {
						 $tabOperation[] = $tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
					 }
				   else if (($tabCal[$i+2]=="+")||($tabCal[$i+2]=="-"))
					 {
						 if ($tabCal[$i+4]=="=")
						 {
						 $tabOperation[] =$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3].$tabCal[$i+4].$tabCal[$i+5];
						 $tabOperation2[] =$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3].$tabCal[$i+4].$tabCal[$i+5];
						 }
					 }
					 else if (ereg("[0-9]",$tabCal[$i+2])|| $tabCal[$i+2]=="")
								$tabOperation[] =$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1];
					 break;
		case "*" :if ($tabCal[$i+2]=="=")
					 {
						$tabOperation[] =$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
					 }
					 else if (ereg("[0-9]",$tabCal[$i+2])|| $tabCal[$i+2]=="")
								$tabOperation[] =$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1];
					 break;
		case ":" :if ($tabCal[$i+2]=="=")
					 {
						$tabOperation[] =$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
					 }
					 else if (ereg("[0-9]",$tabCal[$i+2])|| $tabCal[$i+2]=="")
								$tabOperation[] =$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1];
					 break;
		}
	
}

print("les operation qui ont ete saisie sont : <br>");
for ($i=0; $i < count($tabOperation) ; $i++)
   {
	 print($tabOperation[$i]."<br>");
   }
print ("<br>-------------------------------<br>");

$tabMot = preg_split ("/[\s]+/", $text);
//recherche les nombre dans le tableau tabMot
$numeros = array_values (preg_grep("/\d/", $tabMot));
//echo count($numeros);
print("les mots du textes<br>");
for ($i=0 ; $i < count($tabMot) ;$i++)
	print($tabMot[$i]."<br>");
print ("<br>-------------------------------<br>");	
print ("les nombres que le texte contient sont"); 
for ($i=0 ; $i < count($numeros) ;$i++)
{
	//print($numeros[$i]." "."<br>");
	$tab = preg_split ("/[\s\+\-\*\:\=]+/", $numeros[$i]);
	$num = array_values (preg_grep("/\d/", $tab));
	for ($j=0 ; $j < count($num) ;$j++)
	{
		//print($num[$j]." ");
		$a = eregi_replace('[^(0-9\,)]',"",$num[$j]);
		$nombre[] = $a;
	}
}
for ($i=0 ; $i < count($nombre) ;$i++)
	print($nombre[$i]." ");
$tabNombre = $nombre;
//====================================================

 require_once("conn.php");
 $Requete_SQL1 = "SELECT * FROM $t where numero = $n";
 $result = mysql_query($Requete_SQL1) or die("Erreur de S&eacute;lection dans la base : ". $Requete_SQL1 .'<br />'. mysql_error());
 while ($val = mysql_fetch_array($result)) 
	{ 
    	$partie1 = $val["partie1"]; 
    	$partie2 = $val["partie2"]; 
		$partie3 = $val["partie3"]; 
		$tout1 = $val["tout1"]; 
		$tout2 = $val["tout2"]; 
		$valdiff = $val["valdiff"]; 
		$question = $val["question"];
 	} 
 //printf ("Lignes modifiées : %d\n" ,mysql_affected_rows ()); 
print ("<P>Construction du tableau des données :</P>\n");
print ("<P><TABLE BGCOLOR=#88ffcc border=2 cellspacing=2 cellpadding=2>\n");
print ("<TD>\n<B>numero</B>\n");
print ("<TD>\n<B>enonce1</B>\n");
print ("<TD>\n<B>question1</B>\n");
print ("<TD>\n<B>enonce2</B>\n"); 
print ("<TD>\n<B>question2</B>\n");
print ("<TD>\n<B>partie1</B>\n");
print ("<TD>\n<B>partie2</B>\n");
print ("<TD>\n<B>tout1</B>\n");
print ("<TD>\n<B>partie3</B>\n");
print ("<TD>\n<B>valdiff</B>\n");
print ("<TD>\n<B>tout2</B>\n");
print ("<TD>\n<B>variable</B>\n"); 
print ("<TD>\n<B>question</B>\n");
for ($i = 0; $i < mysql_num_rows ($result); $i++)
   {
   if (! mysql_data_seek ($result, $i))
      {
      printf ("Impossible d'atteindre la ligne %d\n", $i);
      continue;
      }
   if (! ($rangee = mysql_fetch_object ($result)))
      continue;
   printf ("<TR>\n");
   printf ("<TD>\n%s\n<TD>\n%s\n<TD>\n%s\n<TD>\n%s\n<TD>\n%s\n<TD>\n%s\n<TD>\n%s\n<TD>\n%s\n<TD>\n%s\n<TD>\n%s\n<TD>\n%s\n<TD>\n%s\n<TD>\n%s\n<br>",
           $rangee->numero, $rangee->enonce1, $rangee->question1, $rangee->enonce2, $rangee-> question2, $rangee->partie1, $rangee->partie2, $rangee->tout1, $rangee->partie3, $rangee->valdiff, $rangee->tout2, $rangee->variable, $rangee->question);
   }
printf ("</TABLE></P>\n\n"); 
 // tant qu'il y a des fiches

 ?>
<?php
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

$chaineOp = implode (' ',$tabOperation);
$chaineOper = trim(eregi_replace ('[^0-9|,]', " ",$chaineOp));
$tabOperande= array_values(preg_split ("/[\s]+/", $chaineOper));
print ("le tableau des operations :  ");print_r($tabOperation);print ("<br>");
print ("le tableau d'operande :  ");print_r($tabOperande);print ("<br>");
print ("le tableau des nombres :  ");print_r($nombre);print ("<br>");

/*effectuer la difference entre les deux tableaux $nombre et $tabOperande*/
for ($i=0; $i<=count($tabOperande); $i++)
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
print ("le tableau tabImp \"Implicite\""); print_r($tabImp);print ("<br>");
/*======ajouter le signe egale a l'operation s'il n'existe pas=======*/

for ($i=0,$k=0; $i < count($tabOperation);$i++)
{
	if(!strstr($tabOperation[$i],'='))
	{
	$tabOperation[$i]=$tabOperation[$i]."=".$tabImp[$k];
	$k++;
	}
}
print ("le tableau des operations :  ");print_r($tabOperation);print ("<br>");

/*-------fin difference entre les deux tableaux-----------*/
$bool=false;
/* verifier si l'operation est implicite ou pas */
if ((count($tabOperation)==0) and ((count($tabImp)==1)||(count($tabImp)==2)))
{
	if ($tabImp[0]==$partie2 ) 
	 {
	  $resultat=$partie2;
	  $colonne2=0;$colonne3=9;$colonne4=0; 
	  print("colonne2=0 colonne3=9 colonne4=9");
	  $etape1=true;
	 }
	else if ($tabImp[0]==$valdiff) 
	 {
	  $resultat=$valdiff;
	  $colonne10=0;$colonne11=9;$colonne12=0; 
	  print("colonne10=0 colonne11=9 colonne12=0");
	  $difference=true;
	 }
	switch ($question)
	{
	case 't':if (($tabImp[0]==$tout2) and (count($tabImp)==1))
				{
				$resultat=$tout2;
	  			$colonne14=0; $colonne15=0; $colonne16=9; $colonne17 = 0 ; 
				print("colonne14=0 colonne15=0 colonne16=9 colonne17=0"); 
				$varImp=true;
				}
			  else if (($tabImp[1]==$tout2)and (count($tabImp)==2))
				{
				$resultat=$tout2;
	  			$colonne14=0; $colonne15=0;$colonne16=9; $colonne17 = 0 ; 
				print("colonne14=0 colonne15=0 colonne16=9 colonne17=0"); 
				$varImp=true;
				}
				break;
	case 'p':if (($tabImp[0]==$partie3)and (count($tabImp)==1))
				{
				$resultat=$partie3;
	  			$colonne14=0; $colonne15=0;$colonne16=9; $colonne17 = 0 ;
				print("colonne14=0 colonne15=0 colonne16=9 colonne17=0");  
				$varImp=true;
				} 
			  else if (($tabImp[1]==$partie3)and (count($tabImp)==2))
				{
				$resultat=$partie3;
	  			$colonne14=0; $colonne15=0;$colonne16=9; $colonne17 = 0 ;
				print("colonne14=0 colonne15=0 colonne16=9 colonne17=0");
				$varImp=true; 
				} 
				break; 
	}
}
else if (count($tabOperation)==1)
{
    $operation_f = $tabOperation[0];
	$oper = trim(eregi_replace ('[^-|+|*|:]', " ",$operation_f));
    $T1 =  array_values(preg_split ("/[\s]+/", $oper));
	$operande = trim(eregi_replace ('[^0-9|,]', " ",$operation_f));
	$T2 = array_values(preg_split ("/[\s]+/", $operande));
	for ($i=0; $i<=count($T2); $i++)
		 {
			for ($j=0 ; $j < count($nombre) ; $j++)
				{
				  if ($T2[$i] == $nombre[$j])
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
		 $T3[] = $nombre[$i];
		 }
	}
    $op1 = $T2[0]; $op2 = $T2[1]; $res = $T2[2]; $op = $T1[0];
	    
	if (count($tabImp)==1)
	{
		$resultat = $tabImp[0];
		print("<br>resultat intermediaire".$resultat."<br>");
	}
	else if (count($tabImp)==2)
	{
		$resultat_f = $tabImp[1]; $resultat =$tabImp[0];
		print("<br>resultat finale".$resultat_f."<br>");
		print("<br>resultat intermediaire".$resultat."<br>");
	}
	$implicite=true;
	$bool=true;
}
print("<br>======================<br>");
/* fin de la verification */
if (count($tabOperation)==1)
$bool=true;
for ($k = 0 ; (($k < count($tabOperation)-1)||($bool==true)); $k++)
{
	$bool=false; $etape1=false; $difference=false;
	$operation1 = $tabOperation[$k];
	//suprime tous caractere different de [^+-:*] , les resultats dans un tableau T1
	 $oper = trim(eregi_replace ('[^-|+|*|:]', " ",$operation1));
	 $T1 =  array_values(preg_split ("/[\s]+/", $oper));
	//suprime tous caractere different des operandes , les resultats dans un tableau T2
	$operande = trim(eregi_replace ('[^0-9|,]', " ",$operation1));
	$T2 = array_values(preg_split ("/[\s]+/", $operande));
	print("le tableau T2 contient :  ");print_r($T2);print ("<br>");
	for ($i=0; $i<=count($T2); $i++)
		 {
			for ($j=0 ; $j < count($nombre) ; $j++)
				{
				  if ($T2[$i] == $nombre[$j])
					{
						$nombre[$j]='';
						break 1;
					}
				}
		 }
		 
	print("<br>les nombres restant apres elimination des operandes  : ");
	for ($i=0 ; $i < count($nombre) ;$i++)
	{
		if ($nombre[$i]!='')
		 {
		 $T3[] = $nombre[$i];
		 }
	}
	print_r($T3); print("<br>");
//=========il n' y a qu'une operation=============
	if (count ($T1) == 1 ) 
	 {
		   $op1 = $T2[0]; $op2 = $T2[1]; $res = $T2[2];
		   $op = $T1[0];
		   
		   if ($T2[2]!="")
		   print ("<br>l'operation est : ".$op1.$op.$op2."=".$res."<br>"); 
			  
/*========== cas de calcul par différence pour les problèmes de complement===============*/
//=================  colonne10  =============
		if ($question == 't')
		{
			if ((($op1.$op.$op2."=".$res) == ($partie1."+".$op2."=".$partie3))||(($op1.$op.$op2."=".$res) == ($partie3."+".$op2."=".$partie1)))
			   {
				 if ($colonne10 ==9 || $colonne10=='')
				 print (" colonne 10 = 1 ");
				 $colonne10 = 1; //addition a trou 
				 $operande1 = $op1; $operande2 = $res; $resultat = $op2;
				 $resultat_comp = calcul($operande2,"-",$operande1);
				 $difference = true ; $diff=true;
			   }
			  else if (((($op1.$op.$op2."=".$res) == ($partie1."-".$partie3."=".$res))||(($op1.$op.$op2."=".$res) == ($partie3."-".$partie1."=".$res)))&&($op1<=$op2))
				{
				 print ("colonne 10 = 3");
				 $colonne10 = 3;
				 $operande1 = $op1; $operande2 = $op2; $resultat = $res;
				 $resultat_comp = -calcul($operande1,$op,$operande2);
				 $difference = true ; $diff=true;
				}
			 else if ((($op1.$op.$op2."=".$res) == ($partie1."-".$partie3."=".$res))||(($op1.$op.$op2."=".$res) == ($partie3."-".$partie1."=".$res)))
				{
				 print ("colonne 10 = 2");
				 $colonne10 = 2;
				 $operande1 = $op1; $operande2 = $op2; $resultat = $res;
				 $resultat_comp = calcul($operande1,$op,$operande2);
				 $difference = true ;$diff=true;
				}
			else if ((($op1.$op.$op2."=".$res) == ($partie1."+".$partie3."=".$res))||(($op1.$op.$op2."=".$res) == ($partie3."+".$partie1."=".$res)))
				{
				 print ("colonne 10 = 4");
				 $colonne10 = 4;
				 $operande1 = $op1; $operande2 = $op2; $resultat = $res;
				 $resultat_comp = calcul($operande1,$op,$operande2);
				 $difference = true ; $diff=true;
				}
			else if ((($op1.$op.$op2."=".$res) == ($partie1."*".$partie3."=".$res))||(($op1.$op.$op2."=".$res) == ($partie3."*".$partie1."=".$res))||(($op1.$op.$op2."=".$res) == ($partie1.":".$partie3."=".$res))||(($op1.$op.$op2."=".$res) == ($partie3.":".$partie1."=".$res)))	
				{
				 print ("colonne 10 = 5");
				 $colonne10 = 5;
				 $operande1 = $op1; $operande2 = $op2; $resultat = $res;
				 $resultat_comp = calcul($operande1,$op,$operande2);
				 $difference = true ;$diff=true;
				}
			else if ((($op1.$op.$op2."=".$res) == ($partie1."-".$op2."=".$partie3))||(($op1.$op.$op2."=".$res) == ($partie3."-".$op2."=".$partie1)))
				{
				 print ("colonne 10 = 6");//n'existe pas dans le codage 
				 $colonne10 = 6 ;
				 $operande1 = $op1; $operande2 = $res; $resultat = $op2;
				 $resultat_comp = calcul($operande1,"-",$operande2);
				 $difference = true ;$diff=true;
				}
			else if (!(ereg("[0-6]",$colonne10)))
				{
				 print ("colonne10 =9"); $colonne10 = 9;
				}
		}
		else if ($question == 'p')
		{
			if ((($op1.$op.$op2."=".$res) == ($tout1."+".$op2."=".$tout2))||(($op1.$op.$op2."=".$res) == ($tout2."+".$op2."=".$tout1)))
			   {
				 print (" colonne 10 = 1 ");
				 $colonne10 = 1; //addition a trou 
				 $operande1 = $op1; $operande2 = $res; $resultat = $op2;
				 $resultat_comp = calcul($operande2,"-",$operande1);
				 $difference = true ; $diff=true;						
			   }
			 else if (((($op1.$op.$op2."=".$res) == ($tout1."-".$tout2."=".$res))||(($op1.$op.$op2."=".$res) == ($tout2."-".$tout1."=".$res)))&&($op1<=$op2))
				{
				 print ("colonne 10 = 3");
				 $colonne10 = 3;
				 $operande1 = $op1; $operande2 = $op2; $resultat = $res;
				 $resultat_comp = -calcul($operande1,$op,$operande2);
				 print("<br>".$resultat_comp."<br>");
				 $difference = true ; $diff=true;
				}
			 else if ((($op1.$op.$op2."=".$res) == ($tout1."-".$tout2."=".$res))||(($op1.$op.$op2."=".$res) == ($tout2."-".$tout1."=".$res)))
				{
				 print ("colonne 10 = 2");
				 $colonne10 = 2;
				 $operande1 = $op1; $operande2 = $op2; $resultat = $res;
				 $resultat_comp = calcul($operande1,$op,$operande2);
				 $difference = true ; $diff=true;
				}
			 else if ((($op1.$op.$op2."=".$res) == ($tout1."+".$tout2."=".$res))||(($op1.$op.$op2."=".$res) == ($tout2."+".$tout1."=".$res)))
				{
				 print ("colonne 10 = 4");
				 $colonne10 = 4;
				 $operande1 = $op1; $operande2 = $op2; $resultat = $res;
				 $resultat_comp = calcul($operande1,$op,$operande2);
				 $difference = true ; $diff=true;
				}
			else if ((($op1.$op.$op2."=".$res) == ($tout1."*".$tout2."=".$res))||(($op1.$op.$op2."=".$res) == ($tout2."*".$tout1."=".$res))||(($op1.$op.$op2."=".$res) == ($tout1.":".$tout2."=".$res))||(($op1.$op.$op2."=".$res) == ($tout2.":".$tout1."=".$res)))	
				{
				 print ("colonne 10 = 5");
				 $colonne10 = 5;
				 $operande1 = $op1; $operande2 = $op2; $resultat = $res;
				 $resultat_comp = calcul($operande1,$op,$operande2);
				 $difference = true ; $diff=true;
				}
			else if ((($op1.$op.$op2."=".$res) == ($tout1."-".$op2."=".$tout2))||(($op1.$op.$op2."=".$res) == ($tout2."-".$op2."=".$tout1)))
				{
				 print ("colonne 10 = 6");//n'existe pas dans le codage 
				 $colonne10 = 6 ;
				 $operande1 = $op1; $operande2 = $res; $resultat = $op2;
				 $resultat_comp = calcul($operande1,"-",$operande2);
				 $difference = true ; $diff=true;
				}
			 else if (($implicite)and(($resultat == $valdiff )||($resultat == $valdiff+1 )||($resultat == $valdiff-1 )))
				{
					 print ("colonne10 = 0");
					 $colonne10 = 0;
					 $operande1 = ''; $operande2 = ''; $resultat = $valdiff;
					 $difference = true ; $diff=true;
					 $resultat_comp= $resultat; 
				}
			else if (!(ereg("[0-6]",$colonne10)))
				{
					 print ("colonne10 =9"); $colonne10 = 9;
				}
		 }
//================= colonne11  ====================
	if (($difference)||($colonne10 ==9))	 
		{
		  if (($colonne10 == 9)||($colonne10 == 0))
			{
			 print(" colonne11 = 9 "); $colonne11=9;
			}
			else if (($question == 'p') and ((($operande1==$tout1)||($operande1==$tout2))&&(($operande2==$tout2)||($operande2==$tout1))))
			{ 
				print(" colonne11 = 0 "); $colonne11=0; 
			}
			else if (($question == 't') and ((($operande1==$partie1)||($operande1==$partie3))&&(($operande2==$partie3)||($operande2==$partie1))))
			{ 
				print(" colonne11 = 0 "); $colonne11=0; 
			}
		   else if (($question == 'p') and ((($operande1==$tout1)||($operande1==$tout2))xor(($operande2==$tout1)||($operande2==$tout2))))
			{ 
				print(" colonne11 = 1 "); $colonne11=1; 
			}
		   else if (($question == 't') and ((($operande1==$partie1)||($operande1==$partie3))xor(($operande2==$partie1)||($operande2==$partie3))))
			{ 
				print(" colonne11 = 1 "); $colonne11=1;
			}
			else if (($colonne10 == 0)and($resultat!=$valdiff))
			{ 
				print(" colonne11 = 8 "); $colonne11=8;
			}
//================= colonne 12 =============
		 if (($colonne10 == 9)||($colonne10 == 0)||($resultat==''))
			{
					print(" colonne12 = 9 "); $colonne12=9; 	
			}
		  else if ($colonne11 == 8)
			{
				print(" colonne12 = 8 "); $colonne12=8; 
			}
		  else if ($resultat == $resultat_comp)
			{
				print(" colonne12 = 0 "); $colonne12=0; 
			}
		  else if (($resultat == $resultat_comp-1)||($resultat == $resultat_comp+1))
			{
				print(" colonne12 = 1 "); $colonne12=1;
			}	
		  else if (($resultat < $resultat_comp-1) ||($resultat > $resultat_comp-1))
			{
				print(" colonne12 = 2 "); $colonne12=2; 
			}
	}//fin du if ($difference)

/*============== strategie par etape ====================== */
	  if ($difference != true)
		{
//================= colonne2 =============
		   if (($op1.$op.$op2."=".$res) == ($partie1."+".$op2."=".$tout1))
			   {
				 print ("colonne 2 = 1");
				 $colonne2 = 1; //addition a trou 
				 $operande1 = $op1; $operande2 = $res; $resultat = $op2; 
				 $resultat_comp = $partie2;
				 $etape1 = true ; $etape=true;						
				}
			else if (($op1.$op.$op2."=".$res) == ($op1."+".$op2."=".$tout1))
			   {
				 print ("colonne 2 = 1");
				 $colonne2 = 1; //addition a trou 
				 $operande1 = $op1; $operande2 = $res; $resultat = $op2;
				 $resultat_comp = calcul($operande2,"-",$operande1);
				 $etape1 = true ;$etape=true;
			   }
			else if (($op1.$op.$op2."=".$res) == ($tout1."-".$op2."=".$partie1))
				{
				 print ("colonne 2 = 6");//n'existe pas dans le codage 
				 $colonne2 = 6 ;
				 $operande1 = $op1; $operande2 = $res; $resultat = $op2;
				 $resultat_comp = calcul($operande1,"-",$operande2);
				 $etape1 = true ;$etape=true;
				}
			else if (($op1.$op.$op2."=".$res) == ($partie1."-".$op2."=".$tout1))
				{
				 print ("colonne 2 = 7");//n'existe pas dans le codage addition a trou erreur dans le signe de l'opperation
				 $colonne2 = 7 ;
				 $operande1 = $op1; $operande2 = $res; $resultat = $op2; 
				 $resultat_comp = calcul($operande1,"-",$operande2);
				 $etape1 = true ;$etape=true;
				}
			else if ((($op1.$op.$op2."=".$res) == ($tout1."-".$partie1."=".$res))||((($op1.$op.$op2."=".$res) == ($tout1."-".$op2."=".$res))&&($tout1>=$op2)) ||((($op1.$op.$op2."=".$res) == ($op1."-".$partie1."=".$res))&&($op1>=$partie1)))
			   {
				 print ("colonne 2 = 2");
				 $colonne2 = 2;
				 $operande1 = $op1; $operande2 = $op2; $resultat = $res;
				 $resultat_comp = calcul($operande1,$op,$operande2);
				 $etape1 = true ;$etape=true;
			   }
			else if (($op1.$op.$op2."=".$res) == ($partie1."-".$tout1."=".$res))
		      {
				 print ("colonne 2 = 3");
				 $colonne2 = 3; 
				 $operande1 = $op1; $operande2 = $op2; $resultat = $res;
				 $resultat_comp = $partie2;
				 $etape1 = true ;$etape=true;
			   }
			else if ((($op1.$op.$op2."=".$res) == ($tout1."+".$partie1."=".$res)) || (($op1.$op.$op2."=".$res) == ($partie1."+".$tout1."=".$res)))
				{
				 print ("colonne 2 = 4");
				 $colonne2 = 4;
				 $operande1 = $op1; $operande2 = $op2; $resultat = $res;
				 $resultat_comp = calcul($operande1,$op,$operande2);
				 $etape1 = true ;$etape=true;
				}
			else if ((($op1.$op.$op2."=".$res) == ($tout1."+".$op2."=".$res)) || (($op1.$op.$op2."=".$res) == ($op1."+".$tout1."=".$res)))
				{
				 print ("colonne 2 = 4");
				 $colonne2 = 4;
				 $operande1 = $op1; $operande2 = $op2; $resultat = $res; 
				 $resultat_comp = calcul($operande1,$op,$operande2);
				 $etape1 = true ;$etape=true;
				}
			else if ((($op1.$op.$op2."=".$res) == ($partie1."*".$tout1."=".$res))||(($op1.$op.$op2."=".$res) == ($partie1.":".$tout1."=".$res)))	
				{
				 print ("colonne 2 = 5");
				 $colonne2 = 5; 
				 $operande1 = $op1; $operande2 = $op2; $resultat = $res; 
				 $resultat_comp = calcul($operande1,$op,$operande2);
				 $etape1 = true ; $etape=true;
				}
			else if ((($op1.$op.$op2."=".$res) == ($tout1."*".$partie1."=".$res))||(($op1.$op.$op2."=".$res) == ($tout1.":".$partie1."=".$res)))	
				{
				 print ("colonne 2 = 5");
				 $colonne2 = 5;
				 $operande1 = $op1; $operande2 = $op2; $resultat = $res; 
				 $resultat_comp = calcul($operande1,$op,$operande2);
				 $etape1 = true ; $etape=true;
				}
		  }//fin => if($difference = true)
			else if (!(ereg("[0-7]",$colonne2)))
				{
				 print ("colonne2 =9");
				 $colonne2 = 9;
				}
		 //=================colonne3=============
		  if (($colonne2 == 0) and ($resultat!=$partie2) and ($etape1))
			{ 
				print(" colonne3 = 9"); $colonne3=9; 
			}
			else if ($colonne2 == 9) 
			{
				print(" colonne3 = 9"); $colonne3=9; 
			}
			else if (((($operande1==$tout1)||($operande1==$partie1))&&(($operande2==$tout1)||($operande2==$partie1)))and ($etape1))
			{ 
				print(" colonne3 = 0 "); $colonne3=0; 
			}
		   else if (((($operande1==$tout1)||($operande1==$partie1))xor(($operande2==$tout1)||($operande2==$partie1)))and ($etape1))
			{ 
				print(" colonne3 = 1 "); $colonne3=1; 
			}
		  
		 //=================colonne4=============
		 if (((($colonne2 == 0)||($resultat==''))and ($etape1))||($colonne2 == 9))
			{
				print(" colonne4 = 9 "); $colonne4=9; 	
			}
		else if (($colonne3 == 8)and ($etape1))
			{
				print(" colonne4 = 8 "); $colonne4=8; 
			}
		else if (($resultat == $resultat_comp)and ($etape1))
			{
				print(" colonne4 = 0 "); $colonne4=0; 
			}
		 else if ((($resultat == $resultat_comp-1)||($resultat == $resultat_comp+1))and ($etape1))
			{
				print(" colonne4 = 1 "); $colonne4=1; 
			}	
		 else if ((($resultat < $resultat_comp-1) ||($resultat > $resultat_comp-1))and ($etape1))
			{
				print(" colonne4 = 2 "); $colonne4=2; 
			}	
	 } 
}//fin du for	

/*====colonne 14 à 18 solution final========*/
//===================== colonnne 14 et 15 ===========================
if (count($tabOperation)==1)
{
$operation_f = $tabOperation[0];
}
else if(count($tabOperation)> 1)
{
$operation_f = $tabOperation[count($tabOperation)-1];
}

print("<br>la derniere operation que l'enfant a saisie est : ".$operation_f."<br>");
/*suprime tous caractere different de [^+-:*] , les resultats dans un tableau T1*/
$oper = trim(eregi_replace ('[^-|+|*|:]', " ",$operation_f));
$T1 =  array_values(preg_split ("/[\s]+/", $oper));
//suprime tous caractere different des operandes , les resultats dans un tableau T2
$operande = trim(eregi_replace ('[^0-9|,]', " ",$operation_f));
$T2 = array_values(preg_split ("/[\s]+/", $operande));
print("le tableau T2 contient :  ");
for ($i=0 ; $i < count($T2) ;$i++)
print($T2[$i]." ");
print ("<br>");
$nombreInv = array_reverse($tabNombre);
for ($i=0; $i<=count($T2); $i++)
	 {
		for ($j=0 ; $j < count($nombreInv) ; $j++)
			{
			  if ($T2[$i] == $nombreInv[$j])
				{
					$nombreInv[$j]='';
					break 1;
				}
			}
	 }
			 
print("<br>les nombres restant apres elimination des operandes  : ");
for ($i=0 ; $i < count($nombreInv) ;$i++)
{
	if ($nombreInv[$i]!='')
	 {
	 $T3[] = $nombreInv[$i];
	 }
}
for ($i=0 ; $i < count($nombreInv) ;$i++)
{
	print($T3[$i]."  "); 
}
$op1 = $T2[0]; $op = $T1[0]; $op2 = $T2[1]; $res = $T2[2];

/*-----------------------------------------------------------*/
if ((count($tabOperation)==1) and ($question=='t'))
{
	//$etape=false;$etape1=false; $difference=false;
	if (($op1.$op.$op2."=".$res) == ($op1."+".$partie3."=".$res))
	{
		$resultat = $op1; $operande1 = $op1; $operande2 = $partie3; $resultatf = $res; 
		$colonne2 = 0; $etape1=true;
		$colonne10=9;$colonne11=9;$colonne12=9;
		$resultat_compf = calcul($operande1,"+",$operande2);
	}
	else if (($op1.$op.$op2."=".$res) == ($partie3."+".$op2."=".$res))
	{
		$resultat = $op2; $operande1 = $partie3; $operande2 = $op2; $resultatf = $res; 
		$colonne2 = 0; $etape1=true;
		$colonne10=9;$colonne11=9;$colonne12=9;
		$resultat_compf = calcul($operande1,"+",$operande2);
	}
	
	if (($op1.$op.$op2."=".$res) == ($op1."+".$tout1."=".$res))
	{
		$resultat = $op1; $operande1 = $op1; $operande2 = $tout1; $resultatf = $res; 
		$colonne10 = 0; $colonne2=9;$colonne3=9;$colonne4=9;
		$resultat_compf = calcul($operande1,$op,$operande2);
		$diff=true; $difference=true;
	}
	else if (($op1.$op.$op2."=".$res) == ($tout1."+".$op2."=".$res))
	{
		$resultat = $op2; $operande1 = $tout1; $operande2 = $op2; $resultatf = $res; 
		$colonne10 = 0; $colonne2=9;$colonne3=9;$colonne4=9;
		$resultat_compf = calcul($operande1,$op,$operande2);
		$diff=true; $difference=true;
	}
		
	if (($resultat == $partie2) and (($etape1) and ($colonne2==0)))
	{
		print(" colonne 2 = 0 colonne3 = 9 colonne4 = 0 "); $colonne3=9; $colonne4=0; 
	}
	else if ((($resultat == $partie2-1)||($resultat == $partie2+1))and (($etape1)and($colonne2==0)))
	{
		print(" colonne 2 = 0 colonne3 = 9 colonne4 = 1 "); $colonne3 =9 ; $colonne4=1; 
	}
	else if ((($resultat > $partie2-1)||($resultat < $partie2-1))and($colonne2==0))
	{
		print (" colonne 2 = 0 colonne 3 = 8 colonne 4 = 8 ");
		$colonne3=8;$colonne4=8;
	}
	
	if (($resultat == $valdiff) and (($difference) and ($colonne10==0)))
	{
		print(" colonne 10 = 0 colonne11 = 9 colonne12 = 0 "); $colonne11=9; $colonne12=0; 
	}
	else if ((($resultat == $valdiff-1)||($resultat == $valdiff+1))and (($diff)and($colonne10==0)))
	{
		print(" colonne 10 = 0 colonne11 = 9 colonne12 = 1 "); $colonne3 =11 ; $colonne12=1; 
	}
	else if ((($resultat > $valdiff-1)||($resultat < $valdiff-1))and($colonne10==0))
	{
		print (" colonne 10 = 0 colonne 11 = 8 colonne 12 = 8 ");
		$colonne11=8;$colonne12=8;
	}
	
	//$etape2 = true ;	
}
else if ((count($tabOperation)==1) and ($question=='p'))
{
	if (($op1.$op.$op2."=".$res) == ($tout2."-".$op2."=".$res))
	{
		$resultat = $op2; $operande1 = $tout2; $operande2 = $op2; $resultatf = $res; 
		$colonne2 = 0; $etape1=true;
		$resultat_compf = calcul($operande1,"-",$operande2);
	}
	else if (($op1.$op.$op2."=".$res) == ($op2."-".$tout2."=".$res))
	{
		$resultat = $op2; $operande2 = $tout2; $operande1 = $op1; $resultatf = $res; 
		$colonne2 = 0; $etape1=true;
		$resultat_compf = -calcul($operande1,"-",$operande2);
	}
	else if (($op1.$op.$op2."=".$res) == ($op1."+".$op2."=".$tout2))
	{/*adition a trou*/
		$resultat = $op1; $operande1 = $op1; $operande2 = $tout2; $resultatf = $op2; 
		$colonne2 = 0; $etape1=true;
		$resultat_compf = calcul($operande2,"-",$operande1);
	}
	
	if (($resultat == $partie2) and (($etape1) and ($colonne2==0)))
	{
		print(" colonne 2 = 0 colonne3 = 9 colonne4 = 0 "); $colonne3=9; $colonne4=0; 
	}
	else if ((($resultat == $partie2-1)||($resultat == $partie2+1))and (($etape1)and($colonne2==0)))
	{
		print(" colonne 2 = 0 colonne3 = 9 colonne4 = 1 "); $colonne3 =9 ; $colonne4=1; 
	}
	else if ((($resultat > $partie2-1)||($resultat < $partie2-1))and($colonne2==0))
	{
		print (" colonne 2 = 0 colonne 3 = 8 colonne 4 = 8 ");
		$colonne3=8;$colonne4=8;
	}
	//$etape2 = true ;
}
//=========colonne 14 et 15=============
	 if (($question=='p')and($etape1) and(($op1.$op.$op2."=".$res)==($resultat."+".$op2."=".$tout2)))
		   {
		   	 print ("colonne 14 = 1  colonne15 = 1");
			 $colonne14 = 1; $colonne15 = 1;//addition a trou 
			 $operande1 = $op1; $operande2 = $res; $resultatf = $op2; 
			 $resultat_compf = calcul($operande2,"-",$operande1);
			 $etape2 = true ; 						
		   }
	  else if (($question=='p')and ($etape1)and(($op1.$op.$op2."=".$res) == ($tout2."-".$resultat."=".$res)))
		   {
			 print (" colonne 14 = 1  colonne15 = 2 ");
			 $colonne14 = 1; $colonne15 = 2;
			 $operande1 = $op1; $operande2 = $op2; $resultatf = $res;
			 $resultat_compf = calcul($operande1,$op,$operande2);
			 $etape2 = true ;
		   }
	  else if (($question=='p')and ($etape1)and(($op1.$op.$op2."=".$res) == ($resultat."-".$tout2."=".$res)))
		   {
			 print (" colonne 14 = 1  colonne15 = 3 ");
			 $colonne14 = 1; $colonne15 = 3;
			 $operande1 = $op1; $operande2 = $op2; $resultatf = $res;
			 $resultat_compf = $partie3;
			 $etape2 = true ;
		   }
	  else if (($question=='t')and ($etape1)and((($op1.$op.$op2."=".$res) == ($resultat."+".$partie3."=".$res)) || 
	  		   (($op1.$op.$op2."=".$res) == ($partie3."+".$resultat."=".$res))))
			{
			 print (" colonne 14 = 2  colonne15 = 4 ");
			 $colonne14 = 2; $colonne15 = 4;
			 $operande1 = $op1; $operande2 = $op2; $resultatf = $res;
			 $resultat_compf = calcul($operande1,$op,$operande2);
			 $etape1 = true ;
			}
/* ------------------- cas par difference --------------------- */			
	 else if ((($question =='p')and($difference)) and ((($op1.$op.$op2."=".$res) == ($resultat."+".$partie1."=".$res))
	 		 ||(($op1.$op.$op2."=".$res) == ($partie1."+".$resultat."=".$res))))
	 		{
			 print (" colonne 14 = 3  colonne15 = 4 ");
			 $colonne14 = 3; $colonne15 = 4;
			 $operande1 = $op1; $operande2 = $op2; $resultatf = $res; 
			 $resultat_compf = calcul($operande1,$op,$operande2);
			 $difference2 = true ; $etape=false;$etape1=false;
			}
	else if ((($question =='p')and($difference)) and ((($op1.$op.$op2."=".$res) == ($partie1."-".$resultat."=".$res))))
	 		{
			 print (" colonne 14 = 3  colonne15 = 2 ");
			 $colonne14 = 3; $colonne15 = 4;
			 $operande1 = $op1; $operande2 = $op2; $resultatf = $res; 
			 $resultat_compf = calcul($operande1,$op,$operande2);
			 $difference2 = true ; $etape=false;$etape1=false;
			}	
	else if ((($question =='t')and($difference)and($partie3>$partie1)) and (($op1.$op.$op2."=".$res) == ($resultat."+".$tout1."=".$res)
	 		 ||($op1.$op.$op2."=".$res) == ($tout1."+".$resultat."=".$res)))
	 		{
			$colonne14 = 3; $colonne15 = 4;
			 $operande1 = $op1; $operande2 = $op2; $resultatf = $res; 
			 $resultat_compf = calcul($operande1,$op,$operande2);
			 $difference2 = true ; $etape=false;$etape1=false;
			}
	else if ((($question =='t')and($difference)and($partie3<$partie1)) and (($op1.$op.$op2."=".$res) == ($resultat."-".$tout1."=".$res)
	 		 ||($op1.$op.$op2."=".$res) == ($tout1."-".$resultat."=".$res)))
	 		{
			 print (" colonne 14 = 3  colonne15 = 2 ");
			 $colonne14 = 3; $colonne15 = 2;
			 $operande1 = $op1; $operande2 = $op2; $resultatf = $res; 
			 $resultat_compf = calcul($operande1,$op,$operande2);
			 $difference2 = true ; $etape=false;$etape1=false;
			}
/* ------------------- fin  difference --------------------- */
	 else if (($question =='p')and((($op1.$op.$op2."=".$res) == ($resultat."+".$tout2."=".$res))||(($op1.$op.$op2."=".$res) == ($tout2."+".$resultat."=".$res)))) 
	 		{
			 print (" colonne 14 = 4  colonne15 = 4 ");
			 $colonne14 = 4; $colonne15 = 4;
			 $operande1 = $op1; $operande2 = $op2; $resultatf = $res; 
			 $resultat_compf = abs(calcul($operande1,$op,$operande2));
			 $difference2 = true ; 
			 }
	else if (($question =='t')and((($op1.$op.$op2."=".$res) == ($resultat."-".$partie3."=".$res))||(($op1.$op.$op2."=".$res) == ($partie3."-".$resultat."=".$res))))
	 		{
			 print (" colonne 14 = 4  colonne15 = 3 ");
			 $operande1 = $op1; $operande2 = $op2; $resultatf = $res; 
			 if ($operande1 >= $operande2)
			 	$colonne15 = 2;
			 else if ($operande1 < $operande2)
			 	$colonne15 = 3;
			 $colonne14 = 4; 
			 $resultat_compf = abs(calcul($operande1,$op,$operande2));
			 $difference2 = true ; 
			 }
	 else if (((($op1.$op.$op2."=".$res) == ($resultat."*".$tout2."=".$res))||(($op1.$op.$op2."=".$res) == ($resultat.":".$tout2."=".$res))||
			  (($op1.$op.$op2."=".$res) == ($tout2."*".$resultat."=".$res))||(($op1.$op.$op2."=".$res) == ($tout2.":".$resultat."=".$res))) and ($etape1))	
			{
			 print (" colonne 14 = 5  colonne15 = 6 ");
			 $colonne14 = 2; $colonne15 = 8;
			 $operande1 = $op1; $operande2 = $op2; $resultatf = $res; 
			 $resultat_compf = calcul($operande1,$op,$operande2);
			 $etape2 = true ; 
			}
	
	 else if ((($op1.$op.$op2."=".$res) == ($resultat."*".$partie3."=".$res))||(($op1.$op.$op2."=".$res) == ($resultat.":".$partie3."=".$res))||
			  (($op1.$op.$op2."=".$res) == ($partie3."*".$resultat."=".$res))||(($op1.$op.$op2."=".$res) == ($partie3.":".$resultat."=".$res)))	
			{
			 print (" colonne 14 = 5  colonne15 = 6 ");
			 $colonne14 = 2; $colonne15 = 8;$etape=false;
			 $operande1 = $op1; $operande2 = $op2; $resultatf = $res; 
			 $resultat_compf = calcul($operande1,$op,$operande2);
			 $etape2 = true ; 
			}
	else if ((($question =='t')and 
				((($op1.$op.$op2."=".$res) == ($partie1."+".$partie3."=".$res))||
				(($op1.$op.$op2."=".$res) == ($partie3."+".$partie1."=".$res))||
				(($op1.$op.$op2."=".$res) == ($partie1."+".$tout1."=".$res))||
				(($op1.$op.$op2."=".$res) == ($tout1."+".$partie1."=".$res))||
				(($op1.$op.$op2."=".$res) == ($partie3."+".$tout1."=".$res))||
				(($op1.$op.$op2."=".$res) == ($tout1."+".$partie3."=".$res))))
			||
			(($question =='p')and 
				((($op1.$op.$op2."=".$res) == ($partie1."+".$tout2."=".$res))||
				(($op1.$op.$op2."=".$res) == ($tout2."+".$partie1."=".$res))||
				(($op1.$op.$op2."=".$res) == ($partie1."+".$tout1."=".$res))||
				(($op1.$op.$op2."=".$res) == ($tout1."+".$partie1."=".$res))||
				(($op1.$op.$op2."=".$res) == ($tout2."+".$tout1."=".$res))||
				(($op1.$op.$op2."=".$res) == ($tout1."+".$tout2."=".$res)))))
	 		{
			 print (" colonne 14 = 5  colonne15 = 7 ");
			 $colonne14 = 4; $colonne15 = 4;
			 $operande1 = $op1; $operande2 = $op2; $resultatf = $res; 
			 $resultat_compf = abs(calcul($operande1,$op,$operande2));
			 $difference2 = true ; 
			 }
 /*================= colonne 16 pertinence des données de l'operation ==============*/
	 if (
	 			((($question=='t')||($question=='t'))and($difference2))
				and 
	 			(
				 (($operande1==$tout1)and($operande2==$resultat))||
				 (($operande1==$esultat)and($operande2==$tout1))||
				 (($operande1==$partie1)and($operande2==$resultat))||
				 (($operande1==$resultat)and($operande2==$partie1))
				)
			 )
	  {
	  	print(" colonne16 = 0 "); $colonne16=0; 
	  }								
	 else if (((($question=='t')and($difference2))and (($operande1==$partie1)xor($operande2==$resultat)) || (($operande2==$resultat)xor($operande2==$partie1))) 
	         ||((($question=='p')and($difference2))and (($operande1==$tout1)xor($operande2==$resultat)) || (($operande2==$resultat)xor($operande2==$tout1))))
	  {
	  	print(" colonne16 = 1 "); $colonne16=1; 
	  }
	 else if ((($colonne14 == 9)||($colonne14 == 0)) and (!(ereg("[0-8]",$colonne17))))
		{
			print(" colonne16 = 9 "); $colonne16=9; 
		}
	 else if ((($operande1==$tout2)||($operande1==$resultat)||($operande1==$partie3))&&(($operande2==$tout2)||($operande2==$partie3)||($operande2==$resultat)))
	  	{
			print(" colonne16 = 0 "); $colonne16=0; 
		}
	 else if (($colonne4 == 1)||($colonne8 == 1)||($colonne12 == 1))
		{ 
			print(" colonne16 = 2 "); $colonne16=2; 
		}
	 else if ((($operande1==$tout2)xor($operande2==$resultat))||(($operande2==$tout2)xor($operande1==$resultat))||
	          (($operande1==$partie3)xor($operande2==$resultat))||(($operande2==$partie3)xor($operande2==$resultat)))
		{ 
			print(" colonne16 = 2 "); $colonne16=2; 
		} 
	 else if (($colonne4==2)||($colonne8==2)||($colonne12==2))
		{ 
			print(" colonne16 = 3 "); $colonne16=3; 
		}	
	 else if (($colonne4 == 2)||($colonne8 == 2)||($colonne12 == 2))
		{ 
			print(" colonne16 = 3 "); $colonne16=3; 
		}
/* --------------  cas d'une opartation a trois operande -----------------------*/
if (count($tabOperation2 >= 1))
{
if (count ($T1) == 2 ) 
{
	$op1 = $T2[0]; $op2 = $T2[1]; $op3 = $T2[2] ; $res = $T2[3];
	$op = $T1[0];$oper = $T1[1];
	if ($T2[3]!="")
	print ("<br>l'operation est : ".$op1.$op.$op2.$oper.$op3."=".$res."<br>"); 
	if (($T1[0]=="+")and($T1[1]=="+")and(in_array($partie1,$T2))and (in_array($tout1,$T2))and(in_array($partie3,$T2))	)
	{
	 print (" colonne 14 = 5  colonne15 = 5 ");
	 $colonne1=9;$colonne2=9;$colonne3=9;$colonne4=9;$colonne5=9;$colonne6=9;$colonne7=9;
	 $colonne8=9;$colonne9=9;$colonne10=9;$colonne11=9;$colonne12=9;$colonne13=9;
	 $colonne14 = 5; $colonne15 = 5;$colonne16=0;
	 $etape=false; $etape1=false; $difference=false; $difference1=false;$etape2 = false ; 
	 $operande1 = $op1; $operande2 = $op2; $operande3 = $op3; $resultatf = $res; 
	 $resultat_compf = $op1+$op2+$op3;
	}
	else if ((($question='t')and(($op1.$op.$op2.$oper.$op3."=".$res) == ($tout1."-".$partie1."+".$partie3."=".$res)))
		   ||(($question='p')and(($op1.$op.$op2.$oper.$op3."=".$res) == ($tout2."-".$tout1."+".$partie1."=".$res))))
	{
	 $colonne1=1;$colonne2=3;$colonne3=0;$colonne4=9;$colonne6=9;$colonne7=9;
	 $colonne8=9;$colonne9=9;$colonne10=9;$colonne11=9;$colonne12=9;$colonne13=9;
	 $colonne14 = 5; $colonne15 = 6;$colonne16=0;
	 $etape=false; $etape1=true; $difference=false; $difference1=false;$etape2 = true ; 
	 $operande1 = $op1; $operande2 = $op2; $operande3 = $op3; $resultatf = $res; 
	 $resultat_compf = $op1-$op2+$op3; 
	}
	else if (($question='t')and(($op1.$op.$op2.$oper.$op3."=".$res) == ($tout1."-".$partie1."+".$partie3."=".$res)))
	{
	 $colonne1=1;$colonne2=3;$colonne3=0;$colonne4=9;$colonne6=9;$colonne7=9;
	 $colonne8=9;$colonne9=9;$colonne10=9;$colonne11=9;$colonne12=9;$colonne13=9;
	 $colonne14 = 5; $colonne15 = 6;$colonne16=0;
	 $etape=false; $etape1=true; $difference=false; $difference1=false;$etape2 = true ; 
	 $operande1 = $op1; $operande2 = $op2; $operande3 = $op3; $resultatf = $res; 
	 $resultat_compf = $op1-$op2+$op3; 
	}
	else if ((($question='t')and($partie3>$partie1))and((($op1.$op.$op2.$oper.$op3."=".$res) == ($partie3."-".$partie1."+".$tou1."=".$res))
	||(($op1.$op.$op2.$oper.$op3."=".$res) == ($tou1."+".$partie3."-".$partie1."=".$res))))
	{
	 $colonne1=2;$colonne2=9;$colonne3=9;$colonne4=9;$colonne6=9;$colonne7=9;
	 $colonne8=9;$colonne9=9;$colonne10=2;$colonne11=0;$colonne12=9;
	 $colonne14 = 5; $colonne15 = 6;$colonne16=0;
	 $etape=false; $etape1=false; $difference=true; $difference1=true;$etape2 = false; 
	 $operande1 = $partie3; $operande2 = $partie1; $operande3 = $tout1; $resultatf = $res; 
	 $resultat_compf = $op1-$op2+$op3; 
	}
	else if ((($question='t')and($partie3<$partie1))and((($op1.$op.$op2.$oper.$op3."=".$res) == ($partie1."-".$partie3."+".$tou1."=".$res))
	||(($op1.$op.$op2.$oper.$op3."=".$res)==($tou1."+".$partie1."-".$partie3."=".$res))))
	{
	 $colonne1=2;$colonne2=9;$colonne3=9;$colonne4=9;$colonne6=9;$colonne7=9;
	 $colonne8=9;$colonne9=9;$colonne10=2;$colonne11=0;$colonne12=9;
	 $colonne14 = 5; $colonne15 = 6;$colonne16=0;
	 $etape=false; $etape1=false; $difference=true; $difference1=true;$etape2 = false; 
	 $operande1 = $partie1; $operande2 = $partie3; $operande3 = $tout1; $resultatf = $res; 
	 $resultat_compf = $op1-$op2+$op3; 
	}
	else if ((($question='p')and($tout2>$tout1))and((($op1.$op.$op2.$oper.$op3."=".$res) ==($tout2."-".$tout1."+".$partie1."=".$res))
	||(($op1.$op.$op2.$oper.$op3."=".$res)==($partie1."+".$tout2."-".$tout1."=".$res))))
	{
	 $colonne1=2;$colonne2=9;$colonne3=9;$colonne4=9;$colonne6=9;$colonne7=9;
	 $colonne8=9;$colonne9=9;$colonne10=2;$colonne11=0;$colonne12=9;
	 $colonne14 = 5; $colonne15 = 6;$colonne16=0;
	 $etape=false; $etape1=false; $difference=true; $difference1=true;$etape2 = false; 
	 $operande1 = $tout2; $operande2 = $tout1; $operande3 = $partie1; $resultatf = $res; 
	 $resultat_compf = $op1-$op2+$op3; 
	}
	else if ((($question='p')and($tout2<$tout1))and((($op1.$op.$op2.$oper.$op3."=".$res) == ($tout1."-".$tout2."+".$partie1."=".$res))
	||(($op1.$op.$op2.$oper.$op3."=".$res)==($partie1."+".$tout1."-".$tout2."=".$res))))
	{
	 $colonne1=2;$colonne2=9;$colonne3=9;$colonne4=9;$colonne6=9;$colonne7=9;
	 $colonne8=9;$colonne9=9;$colonne10=2;$colonne11=0;$colonne12=9;
	 $colonne14 = 5; $colonne15 = 6;$colonne16=0;
	 $etape=false; $etape1=false; $difference=true; $difference1=true;$etape2 = false; 
	 $operande1 = $tout1; $operande2 = $tout2; $operande3 = $partie1; $resultatf = $res; 
	 $resultat_compf = $op1-$op2+$op3; 
	}
	else 
	{
	 $colonne1=4;$colonne2=9;$colonne3=9;$colonne4=9;$colonne6=9;$colonne7=9;
	 $colonne8=9;$colonne9=9;$colonne10=9;$colonne11=9;$colonne12=9;$colonne13=9;
	 $colonne14 = 5; $colonne15 = 6;$colonne16=0;
	 $etape=false; $etape1=false; $difference=false; $difference1=false;$etape2 = false; 
	 $operande1 = $op1; $operande2 = $op2; $operande3 = $op3; $resultatf = $res; 
	 if (($op=="-") and ($oper=="-"))
	 $resultat_compf = $op1-$op2-$op3;
	 else  if (($op=="-") and ($oper=="+"))
	 $resultat_compf = $op1-$op2+$op3;
	 else if (($op=="+") and ($oper=="-"))
	 $resultat_compf = $op1-$op2-$op3;
	}
}
}
/*----------------------------- fin if (count($tabOperation2 >= 1))---------------------------------*/	
/*=============== colonne 17 exactitude du resultat du calcul =================*/
if ((($colonne15 == 9)||($resultatf==''))and (!(ereg("[0-8]",$colonne17))))
	{
		print(" colonne17 = 9 "); $colonne17=9; 	
	}
else if ($resultatf == $resultat_compf)
	{
		print(" colonne17 = 0 "); $colonne17=0; 
	}
 else if (($resultatf == $resultat_compf-1)||($resultatf == $resultat_compf+1))
	{
		print(" colonne17 = 1 "); $colonne17=1; 
	}	
 else if (($resultatf < $resultat_compf-1) ||($resultatf > $resultat_compf-1))
	{
		print(" colonne17 = 2 "); $colonne17=2; 
	}
 /*----------------- coder la stategie colonne 1 -----------------------*/
if (($etape) and ($diff) and (difference1))
{
	print(" colonne1 = 3 "); $colonne1=3;
}   
else if ((($etape1)and($etape2))||($etape1))
 {
 	print(" colonne1 = 1 "); $colonne1=1;	
 }
else if ((($difference)and($difference1))||($difference))
 {
 	print(" colonne1 = 2 "); $colonne1=2;	
 }

else if ($varImp)
{
	print(" colonne1 = 5 "); $colonne1=5;
}
else if (count($tabNombre)==0)
{
	print(" colonne1 = 9 "); $colonne1=9;
}
else 
{
	print(" colonne1 = 4 "); $colonne1=4;
}
/*===========================colonne 18=========================*/
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
}
 
print("<br><br>colonne1 = ".$colonne1." colonne2 = ".$colonne2." colonne3 = ".$colonne3.
		 " colonne4 = ".$colonne4." colonne10 = ".$colonne10." colonne11 = ".$colonne11." colonne12 = ".$colonne12.
		 " colonne14 = ".$colonne14." colonne15 = ".$colonne15." colonne16 = ".$colonne16." colonne17 = ".$colonne17
		 ." colonne18 = ".$colonne18);
?>