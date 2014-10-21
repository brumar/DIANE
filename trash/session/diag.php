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

 require_once("file:///G|/Documents%20and%20Settings/hk/Bureau/conn.php");
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

if ((count($tabOperation)==1)||(count($tabOperation)==0))
{
		$operation1 = $tabOperation[0];
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
							//unset ($nombre[$j]);
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
		 	   $op1 = $T2[0];
			   $op2 = $T2[1];
			   $op = $T1[0];
			   $res = $T2[2];
			   if ($T2[2]!="")
			   print ($op1.$op.$op2."=".$res."<br>"); 
			  
			   //=================colonne2=============
			   if (($op1.$op.$op2."=".$res) == ($partie1."+".$op2."=".$tout1))
					{
						print ("colonne 2 = 1");
						$colonne2 = 1;
						//$colonne3 = 0;
						$resultat=$op2;
					}
				else if (($op1.$op.$op2."=".$res) == ($op1."+".$op2."=".$tout1))
					{
						print ("colonne 2 = 1");
						$colonne2 = 1;
						$resultat=$op2;
					}
				else if ((($op1.$op.$op2."=".$res) == ($tout1."-".$partie1."=".$res))||(($op1.$op.$op2."=".$res) == ($tout1."-".$op2."=".$res)))
				   {
					 print ("colonne 2 = 2");
					 $colonne2 = 2;
					 $resultat=$res;
				   }
				else if (($op1.$op.$op2."=".$res) == ($partie1."-".$tout1."=".$res))
				   {
					 print ("colonne 2 = 3");
					 $colonne2 = 3;
					 $resultat=$res;
				   }
				else if ((($op1.$op.$op2."=".$res) == ($tout1."+".$partie1."=".$res)) || (($op1.$op.$op2."=".$res) == ($partie1."+".$tout1."=".$res)))
					{
						print ("colonne 2 = 4");
						$colonne2 = 4;
						$resultat = $res;
					}
				else if ((($op1.$op.$op2."=".$res) == ($tout1."+".$op2."=".$res)) || (($op1.$op.$op2."=".$res) == ($op1."+".$tout1."=".$res)))
					{
						print ("colonne 2 = 4");
						$colonne2 = 4;
						$resultat = $res;
					}
				else if ((($op1.$op.$op2."=".$res) == ($partie1."*".$tout1."=".$res))||(($op1.$op.$op2."=".$res) == ($partie1.":".$tout1."=".$res)))	
					{
						print ("colonne 2 = 5");
						$colonne2 = 5;
						$resultat =$res;
					}
					else if ((($op1.$op.$op2."=".$res) == ($tout1."*".$partie1."=".$res))||(($op1.$op.$op2."=".$res) == ($tout1.":".$partie1."=".$res)))	
					{
						print ("colonne 2 = 5");
						$colonne2 = 5;
						$resultat =$res;
					}
				else if (($op1.$op.$op2."=".$res) == ($tout1."-".$op2."=".$partie1))
					{
						print ("colonne 2 = 6");//n'existe pas dans le codage 
						$colonne2 = 6 ;
						$resultat = $op2;
					}
				else if ((in_array ($partie2,$T3)) || (in_array ($c1,$T2)))
				{
					print ("colonne2 = 0");
					$colonne2 = 0;
					$resultat = $c1;
				}
				else 
					{
						print ("colonne2 =9");
						$colonne2 = 9;
					}
				/* ----------- par difference ------------*/
			if ($question == "t")
			{
			//print "tout";
			}
			else if ($question == "p")
			{
			//print "partie";
			}	
			
				
			 //=================colonne3=============
			 if (($colonne2 == 9) || ($colonne2 == 0))
				{
				 print(" colonne3 = 9");
				 $colonne3=9;
				}
				else if ((in_array($partie1,$T2))&&(in_array($tout1,$T2)))
				{ 
					print(" colonne3 = 0");
					$colonne3=0;
				}
			   else if ((in_array($partie1,$T2)) xor (in_array($tout1,$T2)))
				{ 
					print(" colonne3 = 1");
					$colonne3=1;
				}
				
			 //=================colonne4=============
			 if (($colonne2 == 9)||($resultat==''))
				{
						print(" colonne4 = 9");
						$colonne4=9;
				}
			else if ($resultat == $partie2)
				{
					print(" colonne4 = 0");
					$colonne4=0;
				}
			 else if (($resultat == $partie2-1)||($resultat == $partie2+1))
				{
					print(" colonne4 = 1");
					$colonne4=1;
				}	
			 else if (($resultat < $partie2-1) ||($resultat > $partie2-1))
				{
					print(" colonne4 = 2");
					$colonne4=2;
				}
			
	
		 }
		 //========= il n' y a deux operations =============
		 else if (count ($T1) == 2 ) 
		 {
		 
		 
		 }
		 
		
		
	
}
?>