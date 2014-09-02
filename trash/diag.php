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
							 $tabOperation[] =$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3].$tabCal[$i+4].$tabCal[$i+5];
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
						 $tabOperation[] =$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3].$tabCal[$i+4].$tabCal[$i+5];
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
for ($k = 0 ; $k<count($tabOperation); $k++)
{
//if ((count($tabOperation)==1)||(count($tabOperation)==0))
//{
		$operation1 = $tabOperation[$k];
		$etape1=false;
		$difference=false;
		//suprime tous caractere different de [^+-:*] , les resultats dans un tableau T1
		 $oper = trim(eregi_replace ('[^-|+|*|:]', " ",$operation1));
		 $T1 =  array_values(preg_split ("/[\s]+/", $oper));
		//suprime tous caractere different des operandes , les resultats dans un tableau T2
		 $operande = trim(eregi_replace ('[^0-9|,]', " ",$operation1));
		 $T2 = array_values(preg_split ("/[\s]+/", $operande));
		//print("le tableau T2 contient :  ");
		//for ($i=0 ; $i < count($T2) ;$i++)
		//print($T2[$i]." ");
		//print ("<br>");
		
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
		for ($i=0 ; $i < count($nombre) ;$i++)
		{
			print($T3[$i]."  "); 
		}
		
		if (count($T3)!=0)
			$c1= $T3[0];
		else $c1 = "faux";
		
		print("<br>");
		//print("l'operation est  ".$T1[0]."<br>");
		//print("les operandes sont   ".$T2[0]." ".$T2[1]." <br>");
		//print("le resultat est  ".$T2[2]."<br>");
		//for ($i=0 ; $i < count($T2) ;$i++)
		//print($T2[$i]."<br>");
		//=========il n' y a qu'une operation=============
		if (count ($T1) == 1 ) 
		 {
		 	   $op1 = $T2[0]; $op2 = $T2[1]; $res = $T2[2];
			   $op = $T1[0];
			   
			   if ($T2[2]!="")
			   print ("l'operation est : ".$op1.$op.$op2."=".$res."<br>"); 
			   	  
			 /*========== cas de calcul par différence pour les problèmes de complement===============*/
			 /*=======================================================================================*/
			 //=================colonne10=============
			if ($question == 't')
			{
				if ((($op1.$op.$op2."=".$res) == ($partie1."+".$op2."=".$partie3))||(($op1.$op.$op2."=".$res) == ($partie3."+".$op2."=".$partie1)))
				   {
					 print (" colonne 10 = 1 ");
					 $colonne10 = 1; //addition a trou 
					 $operande1 = $op1; $operande2 = $res; $resultat = $op2;
					 $resultat_comp = calcul($operande2,"-",$operande1);
					 $difference = true ; 
				   }
				  else if (((($op1.$op.$op2."=".$res) == ($partie1."-".$partie3."=".$res))||(($op1.$op.$op2."=".$res) == ($partie3."-".$partie1."=".$res)))&&($op1<=$op2))
					{
					 print ("colonne 10 = 3");
					 $colonne10 = 3;
					 $operande1 = $op1; $operande2 = $op2; $resultat = $res;
					 $resultat_comp = -calcul($operande1,$op,$operande2);
					 $difference = true ; 
					}
				 else if ((($op1.$op.$op2."=".$res) == ($partie1."-".$partie3."=".$res))||(($op1.$op.$op2."=".$res) == ($partie3."-".$partie1."=".$res)))
					{
					 print ("colonne 10 = 2");
					 $colonne10 = 2;
					 $operande1 = $op1; $operande2 = $op2; $resultat = $res;
					 $resultat_comp = calcul($operande1,$op,$operande2);
					 $difference = true ;
					}
				else if ((($op1.$op.$op2."=".$res) == ($partie1."+".$partie3."=".$res))||(($op1.$op.$op2."=".$res) == ($partie3."+".$partie1."=".$res)))
					{
					 print ("colonne 10 = 4");
					 $colonne10 = 4;
					 $operande1 = $op1; $operande2 = $op2; $resultat = $res;
					 $resultat_comp = calcul($operande1,$op,$operande2);
					 $difference = true ; 
					}
				else if ((($op1.$op.$op2."=".$res) == ($partie1."*".$partie3."=".$res))||(($op1.$op.$op2."=".$res) == ($partie3."*".$partie1."=".$res))||(($op1.$op.$op2."=".$res) == ($partie1.":".$partie3."=".$res))||(($op1.$op.$op2."=".$res) == ($partie3.":".$partie1."=".$res)))	
					{
					 print ("colonne 10 = 5");
					 $colonne10 = 5;
					 $operande1 = $op1; $operande2 = $op2; $resultat = $res;
					 $resultat_comp = calcul($operande1,$op,$operande2);
					 $difference = true ;
					}
				else if ((($op1.$op.$op2."=".$res) == ($partie1."-".$op2."=".$partie3))||(($op1.$op.$op2."=".$res) == ($partie3."-".$op2."=".$partie1)))
					{
					 print ("colonne 10 = 6");//n'existe pas dans le codage 
					 $colonne10 = 6 ;
					 $operande1 = $op1; $operande2 = $res; $resultat = $op2;
					 $resultat_comp = calcul($operande1,"-",$operande2);
					 $difference = true ;
					}
				/*else if (in_array ($valdiff,$T3))
				{
					 print ("colonne10 = 0");
					 $colonne10 = 0;
					 $operande1 = ''; $operande2 = ''; $resultat = $valdiff;
					 $difference = true ; 
				}*/
				else 
					{
					 print ("colonne10 =9"); $colonne10 = 9;
					 //$difference = true ;	
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
					 $difference = true ; 
					 break;						
				   }
				 else if (((($op1.$op.$op2."=".$res) == ($tout1."-".$tout2."=".$res))||(($op1.$op.$op2."=".$res) == ($tout2."-".$tout1."=".$res)))&&($op1<=$op2))
					{
					 print ("colonne 10 = 3");
					 $colonne10 = 3;
					 $operande1 = $op1; $operande2 = $op2; $resultat = $res;
					 $resultat_comp = -calcul($operande1,$op,$operande2);
					 print("<br>".$resultat_comp."<br>");
					 $difference = true ; 
					}
				 else if ((($op1.$op.$op2."=".$res) == ($tout1."-".$tout2."=".$res))||(($op1.$op.$op2."=".$res) == ($tout2."-".$tout1."=".$res)))
					{
					 print ("colonne 10 = 2");
					 $colonne10 = 2;
					 $operande1 = $op1; $operande2 = $op2; $resultat = $res;
					 $resultat_comp = calcul($operande1,$op,$operande2);
					 $difference = true ; 
					}
				 else if ((($op1.$op.$op2."=".$res) == ($tout1."+".$tout2."=".$res))||(($op1.$op.$op2."=".$res) == ($tout2."+".$tout1."=".$res)))
					{
					 print ("colonne 10 = 4");
					 $colonne10 = 4;
					 $operande1 = $op1; $operande2 = $op2; $resultat = $res;
					 $resultat_comp = calcul($operande1,$op,$operande2);
					 $difference = true ; 
				    }
				else if ((($op1.$op.$op2."=".$res) == ($tout1."*".$tout2."=".$res))||(($op1.$op.$op2."=".$res) == ($tout2."*".$tout1."=".$res))||(($op1.$op.$op2."=".$res) == ($tout1.":".$tout2."=".$res))||(($op1.$op.$op2."=".$res) == ($tout2.":".$tout1."=".$res)))	
					{
					 print ("colonne 10 = 5");
					 $colonne10 = 5;
					 $operande1 = $op1; $operande2 = $op2; $resultat = $res;
					 $resultat_comp = calcul($operande1,$op,$operande2);
					 $difference = true ; 
					}
				else if ((($op1.$op.$op2."=".$res) == ($tout1."-".$op2."=".$tout2))||(($op1.$op.$op2."=".$res) == ($tout2."-".$op2."=".$tout1)))
					{
					 print ("colonne 10 = 6");//n'existe pas dans le codage 
					 $colonne10 = 6 ;
					 $operande1 = $op1; $operande2 = $res; $resultat = $op2;
					 $resultat_comp = calcul($operande1,"-",$operande2);
					 $difference = true ;
					}
				/*else if (in_array ($valdiff,$T3))
				{
					 print ("colonne10 = 0");
					 $colonne10 = 0;
					 $operande1 = ''; $operande2 = ''; $resultat = $valdiff;
					 $difference = true ; 
				}*/
				else 
					{
					 print ("colonne10 =9"); $colonne10 = 9;
					 //$difference = true ;	
					}
			 }
		    //=================colonne11=============
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
			  //$colonne10 = 9; $colonne11 = 9; $colonne12 = 9; $colonne13 = 9; 
			   //print ( "colonne10 = 9 colonne11 = 9  colonne12 = 9 colonne13 = 9" );
			   //================= colonne2 =============
			   if (($op1.$op.$op2."=".$res) == ($partie1."+".$op2."=".$tout1))
				   {
					 print ("colonne 2 = 1");
					 $colonne2 = 1; //addition a trou 
					 $operande1 = $op1; $operande2 = $res; $resultat = $op2; 
					 $resultat_comp = $partie2;
					 $etape1 = true ; 						
				    }
				else if (($op1.$op.$op2."=".$res) == ($op1."+".$op2."=".$tout1))
				   {
					 print ("colonne 2 = 1");
					 $colonne2 = 1; //addition a trou 
					 $operande1 = $op1; $operande2 = $res; $resultat = $op2;
					 $resultat_comp = calcul($operande2,"-",$operande1);
					 $etape1 = true ;
				   }
				else if (($op1.$op.$op2."=".$res) == ($tout1."-".$op2."=".$partie1))
					{
					 print ("colonne 2 = 6");//n'existe pas dans le codage 
					 $colonne2 = 6 ;
					 $operande1 = $op1; $operande2 = $res; $resultat = $op2;
					 $resultat_comp = calcul($operande1,"-",$operande2);
					 $etape1 = true ;
					}
				else if (($op1.$op.$op2."=".$res) == ($partie1."-".$op2."=".$tout1))
					{
					 print ("colonne 2 = 7");//n'existe pas dans le codage addition a trou erreur dans le signe de l'opperation
					 $colonne2 = 7 ;
					 $operande1 = $op1; $operande2 = $res; $resultat = $op2; 
					 $resultat_comp = calcul($operande1,"-",$operande2);
					 $etape1 = true ;
					}
				else if ((($op1.$op.$op2."=".$res) == ($tout1."-".$partie1."=".$res))||((($op1.$op.$op2."=".$res) == ($tout1."-".$op2."=".$res))&&($tout1>=$op2)) ||((($op1.$op.$op2."=".$res) == ($op1."-".$partie1."=".$res))&&($op1>=$partie1)))
				   {
					 print ("colonne 2 = 2");
					 $colonne2 = 2;
					 $operande1 = $op1; $operande2 = $op2; $resultat = $res;
					 $resultat_comp = calcul($operande1,$op,$operande2);
					 $etape1 = true ;
				   }
				else if (($op1.$op.$op2."=".$res) == ($partie1."-".$tout1."=".$res))
				{
					 print ("colonne 2 = 3");
					 $colonne2 = 3; 
					 $operande1 = $op1; $operande2 = $op2; $resultat = $res;
					 $resultat_comp = $partie2;
					 $etape1 = true ;
				   }
				else if ((($op1.$op.$op2."=".$res) == ($tout1."+".$partie1."=".$res)) || (($op1.$op.$op2."=".$res) == ($partie1."+".$tout1."=".$res)))
					{
					 print ("colonne 2 = 4");
					 $colonne2 = 4;
					 $operande1 = $op1; $operande2 = $op2; $resultat = $res;
					 $resultat_comp = calcul($operande1,$op,$operande2);
					 $etape1 = true ;
					}
				else if ((($op1.$op.$op2."=".$res) == ($tout1."+".$op2."=".$res)) || (($op1.$op.$op2."=".$res) == ($op1."+".$tout1."=".$res)))
					{
					 print ("colonne 2 = 4");
					 $colonne2 = 4;
					 $operande1 = $op1; $operande2 = $op2; $resultat = $res; 
					 $resultat_comp = calcul($operande1,$op,$operande2);
					 $etape1 = true ;
					}
				else if ((($op1.$op.$op2."=".$res) == ($partie1."*".$tout1."=".$res))||(($op1.$op.$op2."=".$res) == ($partie1.":".$tout1."=".$res)))	
					{
					 print ("colonne 2 = 5");
					 $colonne2 = 5; 
					 $operande1 = $op1; $operande2 = $op2; $resultat = $res; 
					 $resultat_comp = calcul($operande1,$op,$operande2);
					 $etape1 = true ; 
					}
				else if ((($op1.$op.$op2."=".$res) == ($tout1."*".$partie1."=".$res))||(($op1.$op.$op2."=".$res) == ($tout1.":".$partie1."=".$res)))	
					{
					 print ("colonne 2 = 5");
					 $colonne2 = 5;
					 $operande1 = $op1; $operande2 = $op2; $resultat = $res; 
					 $resultat_comp = calcul($operande1,$op,$operande2);
					 $etape1 = true ; 
					}
				else if (((in_array ($partie2,$T3)) || (in_array ($c1,$T2)) && (count($tabOperation)==0)))
				{
					 print ("colonne2 = 0");
					 $colonne2 = 0;
					 $operande1 = '';
					 $operande2 = '';
					 $resultat = $c1;
					 $etape1 = true ; 
				}
				}//fin => if($difference = true)
			    else 
					{
					 print ("colonne2 =9");
					 $colonne2 = 9;	
					}
			 //=================colonne3=============
			  if (($colonne2 == 0) and ($resultat!=$partie2))//a revoir 
				{ 
					print(" colonne3 = 8 "); $colonne3=8; 
				}
				else if (($colonne2 == 9)||($colonne2 == 0)) 
				{
					print(" colonne3 = 9 "); $colonne3=9; 
				}
				else if ((($operande1==$tout1)||($operande1==$partie1))&&(($operande2==$tout1)||($operande2==$partie1)))
				{ 
					print(" colonne3 = 0 "); $colonne3=0; 
				}
			   else if ((($operande1==$tout1)||($operande1==$partie1))xor(($operande2==$tout1)||($operande2==$partie1)))
				{ 
					print(" colonne3 = 1 "); $colonne3=1; 
				}
			  
			 //=================colonne4=============
			 if (($colonne2 == 0)||($colonne2 == 9)||($resultat==''))
				{
					print(" colonne4 = 9 "); $colonne4=9; 	
				}
			else if ($colonne3 == 8)
				{
					print(" colonne4 = 8 "); $colonne4=8; 
				}
			else if ($resultat == $resultat_comp)
				{
					print(" colonne4 = 0 "); $colonne4=0; 
				}
			 else if (($resultat == $resultat_comp-1)||($resultat == $resultat_comp+1))
				{
					print(" colonne4 = 1 "); $colonne4=1; 
				}	
			 else if (($resultat < $resultat_comp-1) ||($resultat > $resultat_comp-1))
				{
					print(" colonne4 = 2 "); $colonne4=2; 
				}	
		 }
		 /* fin du ==> if (count ($T1) == 1 )  */
		 //========= il n' y a deux operations =============
		 else if (count ($T1) == 2 ) 
		 {
		 }

//}
}
?>