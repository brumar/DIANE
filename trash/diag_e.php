<?php
 session_start();
 $numExo=$numExo+1;
 session_register('numExo');
 $questi = $_SESSION['questi'];
 $n = (int) $_SESSION['num'];
 $t = $_SESSION['type'];
 $text = $_POST["zonetexte"];
 $sas = $_POST['T1'];
 $choix = $_POST['R1'];
 $oper1 = trim($_POST['oper1']);
 $oper2 = trim($_POST['oper2']);
 $op1 = $_POST['operande1'];
 $op2 = $_POST['operande2'];
 $op3 = $_POST['operande3'];
 $resultat =$_POST['resultat1'];
 $numSerie = $_SESSION["numSerie"];
 $aujourdhui = getdate(); $mois = $aujourdhui['mon']; $jour = $aujourdhui['mday']; $annee = $aujourdhui['year']; 
 $heur = $aujourdhui['hours']; $minute = $aujourdhui['minutes']; $seconde = $aujourdhui['seconds']; 
 $date = $annee.":".$mois.":".$jour." ".$heur.":".$minute.":".$seconde;

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
		case "*" :if (($tabCal[$i+2]=="=") && ((ereg("[^\*\:]",$tabCal[$i-2]))||($tabCal[$i-2]=="")))
					 {
						 $tabOperation[] = $tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
					 }
				   else if (($tabCal[$i+2]=="*")||($tabCal[$i+2]==":"))
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
					 /* if ($tabCal[$i+2]=="=")
					 {
						$tabOperation[] =$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
					 }
					 else if (ereg("[0-9]",$tabCal[$i+2])|| $tabCal[$i+2]=="")
								$tabOperation[] =$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1];
					 break; */
		case ":" : if (($tabCal[$i+2]=="=") && ((ereg("[^\*\:]",$tabCal[$i-2]))||($tabCal[$i-2]=="")))
					 {
						 $tabOperation[] = $tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
					 }
				   else if (($tabCal[$i+2]==":")||($tabCal[$i+2]=="*"))
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
		/* if ($tabCal[$i+2]=="=")
					 {
						$tabOperation[] =$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
					 }
					 else if (ereg("[0-9]",$tabCal[$i+2])|| $tabCal[$i+2]=="")
								$tabOperation[] =$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1];
					 break; */
		}
	
}

/*print("les operation qui ont ete saisie sont : <br>");
for ($i=0; $i < count($tabOperation) ; $i++)
   {
	 print($tabOperation[$i]."<br>");
   }
print ("<br>-------------------------------<br>");*/  

$tabMot = preg_split ("/[\s]+/", $text);
//recherche les nombre dans le tableau tabMot
$numeros = array_values (preg_grep("/\d/", $tabMot));
//echo count($numeros);
/*print("les mots du textes<br>");
for ($i=0 ; $i < count($tabMot) ;$i++)
	print($tabMot[$i]."<br>");
print ("<br>-------------------------------<br>");	
print ("les nombres que le texte contient sont"); */
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
/*  for ($i=0 ; $i < count($nombre) ;$i++)
	print($nombre[$i]." ");*/
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
		$var = $val["variable"];
 	} 
 //printf ("Lignes modifiées : %d\n" ,mysql_affected_rows ()); 
/*  print ("<P>Construction du tableau des données :</P>\n");
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
printf ("</TABLE></P>\n\n"); */
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
/*  print ("le tableau des operations :  ");print_r($tabOperation);print ("<br>");
print ("le tableau d'operande :  ");print_r($tabOperande);print ("<br>");
print ("le tableau des nombres :  ");print_r($nombre);print ("<br>");*/

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
$bool=false;
/* verifier si l'operation est implicite ou pas */
if ((count($tabOperation)==0) and ((count($tabImp)==1)||(count($tabImp)==2)))
{
	if ($tabImp[0]==$partie2 ) 
	 {
	  $resultat=$partie2;  $colonne2=0;$colonne3=9;$colonne4=0; 
	  /*  print("colonne2=0 colonne3=9 colonne4=0");*/
	  $etape1=true; $etape=true;
	 }
	else if ($tabImp[0]==$valdiff) 
	 {
	  //$resultat=$valdiff; 
	  $resultatd=$valdiff;  $colonne10=0; $colonne11=9; $colonne12=0; 
	  /*  print("colonne10=0 colonne11=9 colonne12=0");*/
	  $difference=true;$diff=true;
	 }
	 else if (($tabImp[0]=$partie2+1)||($tabImp[0]=$partie2-1))
	 {
	  $resultat=$tabImp[0];
	  $colonne2=0;$colonne3=8;$colonne4=8; 
	  /*  print("colonne2=0 colonne3=9 colonne4=8");*/
	  $etape1=true;$etape=true;
	 }
	else if (($tabImp[0]==$valdiff+1)||($tabImp[0]==$valdiff-1))
	 {
	  //$resultat=$valdiff; 
	  $resultatd=$valdiff; $colonne10=0;$colonne11=8;$colonne12=8; 
	  /*  print("colonne10=0 colonne11=9 colonne12=0");*/
	  $difference=true; $diff=true;
	 }
	switch ($question)
	{
	case 't':if (($tabImp[0]==$tout2) and (count($tabImp)==1))
				{
				//$resultatf=$tout2;
	  			$colonne14=0; $colonne15=0; $colonne16=9; $colonne17=0 ; 
				/*  print("colonne14=0 colonne15=0 colonne16=9 colonne17=0"); */
				$varImp=true;
				}
			  else if (($tabImp[1]==$tout2)and (count($tabImp)==2))
				{
				//$resultat=$tout2;
	  			$colonne14=0; $colonne15=0;$colonne16=9; $colonne17=0 ; 
				/* print("colonne14=0 colonne15=0 colonne16=9 colonne17=0");  */
				$varImp=true;
				}
			else if (($tabImp[0]!=$tout2) and (count($tabImp)==1))
				{
				//$resultat=$tout2;
	  			$colonne14=0; $colonne15=0; $colonne16=8; $colonne17 = 8 ; 
				/*  print("colonne14=0 colonne15=0 colonne16=9 colonne17=8"); */
				$varImp=true;$colonne1=1;
				}
			  else if (($tabImp[1]!=$tout2)and (count($tabImp)==2))
				{
				//$resultat=$tout2;
	  			$colonne14=0; $colonne15=0;$colonne16=8; $colonne17 = 8 ; $colonne1=1;
				/* print("colonne14=0 colonne15=0 colonne16=9 colonne17=8");  */
				$varImp=true;
				}
				break;
	case 'p':if (($tabImp[0]==$partie3)and (count($tabImp)==1))
				{
				//$resultat=$partie3;
	  			$colonne14=0; $colonne15=0;$colonne16=9; $colonne17 = 0 ;
				/* print("colonne14=0 colonne15=0 colonne16=9 colonne17=0");  */ 
				$varImp=true;
				} 
			  else if (($tabImp[1]==$partie3)and (count($tabImp)==2))
				{
				//$resultat=$partie3;
	  			$colonne14=0; $colonne15=0;$colonne16=9; $colonne17 = 0 ;
				/*  print("colonne14=0 colonne15=0 colonne16=9 colonne17=0");*/
				$varImp=true; 
				} 
			 else if (($tabImp[0]!=$partie3)and (count($tabImp)==1))
				{
				//$resultat=$partie3;
	  			$colonne14=0; $colonne15=0;$colonne16=8; $colonne17 = 8 ;$colonne1=1;
				/* print("colonne14=0 colonne15=0 colonne16=9 colonne17=8");  */ 
				$varImp=true;
				} 
			 else if (($tabImp[1]!=$partie3)and (count($tabImp)==2))
				{
				//$resultat=$partie3;
	  			$colonne14=0; $colonne15=0;$colonne16=8; $colonne17 = 8 ;$colonne1=1;
				/*  print("colonne14=0 colonne15=0 colonne16=9 colonne17=8");*/
				$varImp=true; 
				} 
			break; 
	}
}
else if (count($tabOperation)==1)
{
    if (((($question=='t')and(count($tabImp)==1) and($tabImp[0]==$tout2)))
	||((($question=='p')and(count($tabImp)==1) and($tabImp[0]==$partie3))))
	{
	$colonne14=0;$colonne15=0;$colonne16=9;$colonne17=0;
	}
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
		$resultat = $tabImp[0]; $resultatd =$tabImp[0];
		/*  print("<br>resultat intermediaire".$resultat."<br>");*/
	}
	else if (count($tabImp)==2)
	{
		$resultat_f = $tabImp[1]; $resultat =$tabImp[0]; $resultatd =$tabImp[0];
		
		/* print("<br>resultat final".$resultat_f."<br>");
		print("<br>resultat intermediaire".$resultat."<br>"); */
	}
	$implicite=true;
	$bool=true;
}
//print("<br>======================<br>");
/* fin de la verification */
if (count($tabOperation)==1)
{
$bool=true;
}
/* ****************************************************************************** */
/* ****************************************************************************** */
/* ****************************************************************************** */
for ($k = 0 ; (($k < count($tabOperation)-1)||($bool==true)); $k++)
{
	$bool=false; $etape1=false; $difference=false;/* Initialisation */
	$operation1 = $tabOperation[$k];
	//suprime tous caractere different de [^+-:*] , les resultats dans un tableau T1
	 $oper = trim(eregi_replace ('[^-|+|*|:]', " ",$operation1));
	 $T1 =  array_values(preg_split ("/[\s]+/", $oper));
	//suprime tous caractere different des operandes , les resultats dans un tableau T2
	$operande = trim(eregi_replace ('[^0-9|,]', " ",$operation1));
	$T2 = array_values(preg_split ("/[\s]+/", $operande));
	//print("le tableau T2 contient :  ");print_r($T2);print ("<br>");
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
		 
	//print("<br>les nombres restant apres elimination des operandes  : ");
	for ($i=0 ; $i < count($nombre) ;$i++)
	{
		if ($nombre[$i]!='')
		 {
		 $T3[] = $nombre[$i];
		 }
	}
	//print_r($T3); print("<br>");
//=========il n' y a qu'une operation=============
	if (count ($T1) == 1 ) 
	 {
		   $op1 = $T2[0]; $op2 = $T2[1]; $res = $T2[2];
		   $op = $T1[0];
		   
		  // if ($T2[2]!="")
		   //print ("<br>l'operation est : ".$op1.$op.$op2."=".$res."<br>"); 
			  
/*========== cas de calcul par différence pour les problèmes de complement===============*/
//=================  colonne10  =============
		if ($question == 't')
		{
			if ((($op1.$op.$op2."=".$res) == ($partie1."+".$op2."=".$partie3))||(($op1.$op.$op2."=".$res) == ($partie3."+".$op2."=".$partie1)))
			   {
				 //if ($colonne10 ==9 || $colonne10=='')
				 //print (" colonne 10 = 1 ");
				 $colonne10 = 1; //addition a trou 
				 $operande1 = $op1; $operande2 = $res; $resultat = $op2;$resultatd = $op2;
				 $resultat_comp = calcul($operande2,"-",$operande1);
				 $difference = true ; $diff=true;
				 if (count($tabOperation==1))
				 {
				 $colonne14=3;$colonne15=1;$colonne16=4;$colonne17=0;
			     $NonPertinent=true;
				 }
			   }
			  else if (((($op1.$op.$op2."=".$res) == ($partie1."-".$partie3."=".$res))||(($op1.$op.$op2."=".$res) == ($partie3."-".$partie1."=".$res)))&&($op1<=$op2))
				{
				 //print ("colonne 10 = 3");
				 $colonne10 = 3;
				 $operande1 = $op1; $operande2 = $op2; $resultat = $res;$resultatd = $res;
				 $resultat_comp = -calcul($operande1,$op,$operande2);
				 $difference = true ; $diff=true;
				}
			 else if ((($op1.$op.$op2."=".$res) == ($partie1."-".$partie3."=".$res))||(($op1.$op.$op2."=".$res) == ($partie3."-".$partie1."=".$res)))
				{
				 //print ("colonne 10 = 2");
				 $colonne10 = 2;
				 $operande1 = $op1; $operande2 = $op2; $resultat = $res; $resultatd = $res;
				 $resultat_comp = calcul($operande1,$op,$operande2);
				 $difference = true ;$diff=true;
				}
			else if (((($op1.$op.$op2."=".$res) == ($partie1."+".$partie3."=".$res))||(($op1.$op.$op2."=".$res) == ($partie3."+".$partie1."=".$res)))and($etape))
				{
				 //print ("colonne 10 = 4");
				 $colonne10 = 4;
				 $operande1 = $op1; $operande2 = $op2; $resultat = $res; $resultatd = $res;
				 $resultat_comp = calcul($operande1,$op,$operande2);
				 $difference = true ; $diff=true;
				}
			else if ((($op1.$op.$op2."=".$res) == ($partie1."*".$partie3."=".$res))||(($op1.$op.$op2."=".$res) == ($partie3."*".$partie1."=".$res))||(($op1.$op.$op2."=".$res) == ($partie1.":".$partie3."=".$res))||(($op1.$op.$op2."=".$res) == ($partie3.":".$partie1."=".$res)))	
				{
				 //print ("colonne 10 = 5");
				 $colonne10 = 5;
				 $operande1 = $op1; $operande2 = $op2; $resultat = $res; $resultatd = $res;
				 $resultat_comp = calcul($operande1,$op,$operande2);
				 $difference = true ;$diff=true;
				}
			else if ((($op1.$op.$op2."=".$res) == ($partie1."-".$op2."=".$partie3))||(($op1.$op.$op2."=".$res) == ($partie3."-".$op2."=".$partie1)))
				{
				 //print ("colonne 10 = 6");//n'existe pas dans le codage 
				 $colonne10 = 6 ;
				 $operande1 = $op1; $operande2 = $res; $resultat = $op2; $resultatd = $op2;
				 $resultat_comp = calcul($operande1,"-",$operande2);
				 $difference = true ;$diff=true;
				}
			else if (!(ereg("[0-6]",$colonne10)))
				{
				 //print ("colonne10 =9"); 
				 $colonne10 = 9;
				}
		}
		else if ($question == 'p')
		{
			if ((($op1.$op.$op2."=".$res) == ($tout1."+".$op2."=".$tout2))||(($op1.$op.$op2."=".$res) == ($tout2."+".$op2."=".$tout1)))
			   {
				 //print (" colonne 10 = 1 ");
				 if (count($tabOperation==1))
				 {
				 $colonne10 =9;$colonne14=3;$colonne15=1;$colonne16=4;$colonne17=0;
			     $NonPertinent=true;
				 }
				 else 
				 {
				 $colonne10 = 1; //addition a trou 
				 $operande1 = $op1; $operande2 = $res; $resultat = $op2;$resultatd = $op2;
				 $resultat_comp = calcul($operande2,"-",$operande1);
				 }
				 $difference = true ; $diff=true;						
			   }
			 else if (((($op1.$op.$op2."=".$res) == ($tout1."-".$tout2."=".$res))||(($op1.$op.$op2."=".$res) == ($tout2."-".$tout1."=".$res)))&&($op1<=$op2))
				{
				 //print ("colonne 10 = 3");
				 $colonne10 = 3;
				 $operande1 = $op1; $operande2 = $op2; $resultat = $res; $resultatd = $res;
				 $resultat_comp = -calcul($operande1,$op,$operande2);
				 //print("<br>".$resultat_comp."<br>");
				 $difference = true ; $diff=true;
				}
			 else if ((($op1.$op.$op2."=".$res) == ($tout1."-".$tout2."=".$res))||(($op1.$op.$op2."=".$res) == ($tout2."-".$tout1."=".$res)))
				{
				 //print ("colonne 10 = 2");
				 $colonne10 = 2;
				 $operande1 = $op1; $operande2 = $op2; $resultat = $res; $resultatd = $res;
				 $resultat_comp = calcul($operande1,$op,$operande2);
				 $difference = true ; $diff=true;
				}
			 else if ((($op1.$op.$op2."=".$res) == ($tout1."+".$tout2."=".$res))||(($op1.$op.$op2."=".$res) == ($tout2."+".$tout1."=".$res)))
				{
				 //print ("colonne 10 = 4");
				 $colonne10 = 4;
				 $operande1 = $op1; $operande2 = $op2; $resultat = $res; $resultatd = $res;
				 $resultat_comp = calcul($operande1,$op,$operande2);
				 $difference = true ; $diff=true;
				}
			else if ((($op1.$op.$op2."=".$res) == ($tout1."*".$tout2."=".$res))||(($op1.$op.$op2."=".$res) == ($tout2."*".$tout1."=".$res))||(($op1.$op.$op2."=".$res) == ($tout1.":".$tout2."=".$res))||(($op1.$op.$op2."=".$res) == ($tout2.":".$tout1."=".$res)))	
				{
				 //print ("colonne 10 = 5");
				 $colonne10 = 5;
				 $operande1 = $op1; $operande2 = $op2; $resultat = $res; $resultatd = $res;
				 $resultat_comp = calcul($operande1,$op,$operande2);
				 $difference = true ; $diff=true;
				}
			else if ((($op1.$op.$op2."=".$res) == ($tout1."-".$op2."=".$tout2))||(($op1.$op.$op2."=".$res) == ($tout2."-".$op2."=".$tout1)))
				{
				 //print ("colonne 10 = 6");//n'existe pas dans le codage 
				 $colonne10 = 6 ;
				 $operande1 = $op1; $operande2 = $res; $resultat = $op2; $resultatd = $op2;
				 $resultat_comp = calcul($operande1,"-",$operande2);
				 $difference = true ; $diff=true;
				}
			/*  else if (($implicite)and(($resultat == $valdiff )||($resultat == $valdiff+1 )||($resultat == $valdiff-1 )))
				{
					 //print ("colonne10 = 0");
					 $colonne10 = 0;
					 $operande1 = ''; $operande2 = ''; $resultat = $valdiff; $resultatd = $valdiff;
					 $difference = true ; $diff=true;
					 $resultat_comp= $resultat; exit("ok");
				} */
			else if (!(ereg("[0-6]",$colonne10)))
				{
					 //print ("colonne10 =9"); 
					 $colonne10 = 9;
				}
		 }
//================= colonne11  ====================
	$exclusion=false;
	if (($difference)||($colonne10 ==9))	 
		{
		  if (($colonne10 == 9)||($colonne10 == 0))
			{
			  $colonne11=9;//print(" colonne11 = 9 ");
			  //$exclusion=true;
				 
			}
			else if (($question == 'p') and ((($operande1==$tout1)||($operande1==$tout2))&&(($operande2==$tout2)||($operande2==$tout1))))
			{ 
				$colonne11=0; //print(" colonne11 = 0 "); 
				$exclusion=true;
			}
			else if (($question == 't') and ((($operande1==$partie1)||($operande1==$partie3))&&(($operande2==$partie3)||($operande2==$partie1))))
			{ 
				 $colonne11=0; //print(" colonne11 = 0 ");
				 $exclusion=true;
			}
		   else if (($question == 'p') and ((($operande1==$tout1)||($operande1==$tout2))xor(($operande2==$tout1)||($operande2==$tout2))))
			{ 
				$colonne11=1; //print(" colonne11 = 1 "); 
				$exclusion=true;
			}
		   else if (($question == 't') and ((($operande1==$partie1)||($operande1==$partie3))xor(($operande2==$partie1)||($operande2==$partie3))))
			{ 
				 $colonne11=1;//print(" colonne11 = 1 ");
				 $exclusion=true;
			}
			else if (($colonne10 == 0)and($resultat!=$valdiff))
			{ 
				 $colonne11=8;//print(" colonne11 = 8 ");
				 $exclusion=true;
			}
			
//================= colonne 12 =============
		 if (($colonne10 == 9)||($colonne10 == 0)||($resultat==''))
			{
					$colonne12=9; //print(" colonne12 = 9 "); 	
			}
		  else if ($colonne11 == 8)
			{
				$colonne12=8; //print(" colonne12 = 8 "); 
			}
		  else if ($resultat == $resultat_comp)
			{
				 $colonne12=0; //print(" colonne12 = 0 ");
			}
		  else if (($resultat == $resultat_comp-1)||($resultat == $resultat_comp+1))
			{
				 $colonne12=1;//print(" colonne12 = 1 ");
			}	
		  else if (($resultat < $resultat_comp-1) ||($resultat > $resultat_comp-1))
			{
				 $colonne12=2; //print(" colonne12 = 2 ");
			}
	}//fin du if ($difference)

/*============== strategie par etape ====================== */
	  if ($difference != true)
		{
//================= colonne2 =============
		   if (($op1.$op.$op2."=".$res) == ($partie1."+".$op2."=".$tout1))
			   {
				 //print ("colonne 2 = 1");
				 $colonne2 = 1; //addition a trou 
				 $operande1 = $op1; $operande2 = $res; $resultat = $op2; 
				 $resultat_comp = $partie2;
				 $etape1 = true ; $etape=true;						
				}
			else if (($op1.$op.$op2."=".$res) == ($op1."+".$partie1."=".$tout1))
			   {
				 //print ("colonne 2 = 1");
				 $colonne2 = 1; //addition a trou 
				 $operande1 = $res; $operande2 =$op2 ; $resultat = $op1; 
				 $resultat_comp = $partie2;
				 $etape1 = true ; $etape=true;						
				}
			else if (($op1.$op.$op2."=".$res) == ($op1."+".$op2."=".$tout1))
			   {
				 //print ("colonne 2 = 1");
				 $colonne2 = 1; //addition a trou 
				 $operande1 = $op1; $operande2 = $res; $resultat = $op2;
				 $resultat_comp = calcul($operande2,"-",$operande1);
				 $etape1 = true ;$etape=true;
			   }
			else if (($op1.$op.$op2."=".$res) == ($tout1."-".$op2."=".$partie1))
				{
				 //print ("colonne 2 = 6");//n'existe pas dans le codage 
				 $colonne2 = 6 ;
				 $operande1 = $op1; $operande2 = $res; $resultat = $op2;
				 $resultat_comp = calcul($operande1,"-",$operande2);
				 $etape1 = true ;$etape=true;
				}
			else if (($op1.$op.$op2."=".$res) == ($partie1."-".$op2."=".$tout1))
				{
				 //print ("colonne 2 = 7");//n'existe pas dans le codage addition a trou erreur dans le signe de l'opperation
				 $colonne2 = 7 ;
				 $operande1 = $op1; $operande2 = $res; $resultat = $op2; 
				 $resultat_comp = calcul($operande1,"-",$operande2);
				 $etape1 = true ;$etape=true;
				}
			else if (($op1.$op.$op2."=".$res) == ($tout1."-".$partie1."=".$res))//||(($op1.$op.$op2."=".$res) == ($tout1."-".$op2."=".$res)&&($tout1>=$op2)))
			   {
				 //print ("colonne 2 = 2");
				 $colonne2 = 2;
				 $operande1 = $op1; $operande2 = $op2; $resultat = $res;
				 $resultat_comp = calcul($operande1,$op,$operande2);
				 $etape1 = true ;$etape=true;
			   }
			else if (($op1.$op.$op2."=".$res) == ($partie1."-".$tout1."=".$res))
		      {
				// print ("colonne 2 = 3");
				 $colonne2 = 3; 
				 $operande1 = $op1; $operande2 = $op2; $resultat = $res;
				 $resultat_comp = $partie2;
				 $etape1 = true ;$etape=true;
			   }
			else if ((($op1.$op.$op2."=".$res) == ($tout1."+".$partie1."=".$res)) || (($op1.$op.$op2."=".$res) == ($partie1."+".$tout1."=".$res)))
				{
				 //print ("colonne 2 = 4");
				 $colonne2 = 4;
				 $operande1 = $op1; $operande2 = $op2; $resultat = $res;
				 $resultat_comp = calcul($operande1,$op,$operande2);
				 $etape1 = true ;$etape=true;
				 $NonPertinent =true;
				}
			
			else if ((($op1.$op.$op2."=".$res) == ($op1."+".$op2."=".$partie2)) || (($op1.$op.$op2."=".$res) == ($op1."+".$op2."=".$partie2)))
				{
				 
				 //print ("colonne 2 = 4");
				 $colonne2 = 4;$colonne3=1;
				 $operande1 = $op1; $operande2 = $op2; $resultat = $res; 
				 $resultat_comp = calcul($operande1,$op,$operande2);
				 $etape1 = true ;$etape=true;
				}
			else if ((($op1.$op.$op2."=".$res) == ($partie1."*".$tout1."=".$res))||(($op1.$op.$op2."=".$res) == ($partie1.":".$tout1."=".$res)))	
				{
				 //print ("colonne 2 = 5");
				 $colonne2 = 5; 
				 $operande1 = $op1; $operande2 = $op2; $resultat = $res; 
				 $resultat_comp = calcul($operande1,$op,$operande2);
				 $colonne1 = 4;
				 $etape1 = true ; //$etape=true; 
				}
			else if ((($op1.$op.$op2."=".$res) == ($tout1."*".$partie1."=".$res))||(($op1.$op.$op2."=".$res) == ($tout1.":".$partie1."=".$res)))	
				{
				 //print ("colonne 2 = 5");
				 $colonne2 = 5;
				 $operande1 = $op1; $operande2 = $op2; $resultat = $res; 
				 $resultat_comp = calcul($operande1,$op,$operande2);
 				 $colonne1 = 4;
				 $etape1 = true ; //$etape=true;
				}
		  }//fin => if($difference = true)
			else if (!(ereg("[0-7]",$colonne2)))
				{
				 //print ("colonne2 =9");
				 $colonne2 = 9;
				}
		 //=================colonne3=============
		 $exclusion1=false;/* initialisation */
		  if (($colonne2 == 0) and ($resultat!=$partie2) and ($etape1))
			{ 
				$colonne3=9; //print(" colonne3 = 9"); 
			}
			else if ($colonne2 == 9) 
			{
				$colonne3=9; //print(" colonne3 = 9"); 
				$exclusion1=true;
			}
			else if (((($operande1==$tout1)and($operande2==$partie1))||(($operande2==$tout1)and($operande1==$partie1)))and ($etape1))
			{ 
				 $colonne3=0;//print(" colonne3 = 0 "); 
				 $exclusion1=true;
			}
		   else if (((($operande1==$tout1)||($operande1==$partie1))xor(($operande2==$tout1)||($operande2==$partie1)))and ($etape1))
			{ 
				 $colonne3=1; //print(" colonne3 = 1 ");
				 $exclusion1=true;
			}
		  
		 //=================colonne4=============
		 if (((($colonne2 == 0)||($resultat==''))and ($etape1))||($colonne2 == 9))
			{
				$colonne4=9; //print(" colonne4 = 9 "); 	
			}
		else if (($colonne3 == 8)and ($etape1))
			{
				$colonne4=8; //print(" colonne4 = 8 "); 
			}
		else if (($resultat == $resultat_comp)and ($etape1))
			{
				$colonne4=0; //print(" colonne4 = 0 "); 
			}
		 else if ((($resultat == $resultat_comp-1)||($resultat == $resultat_comp+1))and ($etape1))
			{
				 $colonne4=1; //print(" colonne4 = 1 ");
			}	
		 else if ((($resultat < $resultat_comp-1) ||($resultat > $resultat_comp-1))and ($etape1))
			{
				$colonne4=2;//print(" colonne4 = 2 ");  
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

//print("<br>la derniere operation que l'enfant a saisie est : ".$operation_f."<br>");
/*suprime tous caractere different de [^+-:*] , les resultats dans un tableau T1*/
$oper = trim(eregi_replace ('[^-|+|*|:]', " ",$operation_f));
$T1 =  array_values(preg_split ("/[\s]+/", $oper));
//suprime tous caractere different des operandes , les resultats dans un tableau T2
$operande = trim(eregi_replace ('[^0-9|,]', " ",$operation_f));
$T2 = array_values(preg_split ("/[\s]+/", $operande));
//print("le tableau T2 contient :  ");
//for ($i=0 ; $i < count($T2) ;$i++)
//print($T2[$i]." ");
//print ("<br>");
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
			 
//print("<br>les nombres restant apres elimination des operandes  : ");
for ($i=0 ; $i < count($nombreInv) ;$i++)
{
	if ($nombreInv[$i]!='')
	 {
	 $T3[] = $nombreInv[$i];
	 }
}
/*for ($i=0 ; $i < count($nombreInv) ;$i++)
{
	print($T3[$i]."  "); 
}*/
$op1 = $T2[0]; $op = $T1[0]; $op2 = $T2[1]; $res = $T2[2];

/*-----------------------------------------------------------*/
if ((count($tabOperation)>=1) and ($question=='t'))
{
	//$etape=false;$etape1=false; $difference=false;
	if (((($op1.$op.$op2."=".$res) == ($tout1."+".$partie3."=".$res))||(($op1.$op.$op2."=".$res) == ($partie3."+".$tout1."=".$res)))
	and (count($tabOperation)==1))
	{
		$operande1 = $op1; $operande2 = $op2; $resultatf = $res; 
		$colonne1 =4; $colonne2=9;$colonne3=9;$colonne4=9;$colonne5=9;$colonne6=9;$colonne7=9;
		$colonne8=9;$colonne9=9;$colonne10=9;$colonne11=9;$colonne12=9;$colonne13=9;
		$colonne14=5;$colonne15=4;
		$resultat_compf = calcul($operande1,"+",$operande2);$etape1=false;  
	}
   else if ((($op1.$op.$op2."=".$res) == ($op1."+".$partie3."=".$res))and($op1!=$tout1)and(!etape)and(!$exclusion1))
	{
		if ($op1==$partie2)	
		{
		$resultat = $op1; 
		}
		$operande1 = $op1; $operande2 = $partie3; $resultatf = $res; 
		$colonne2 = 0; $etape1=true;
		$colonne10=9;$colonne11=9;$colonne12=9;
		$resultat_compf = calcul($operande1,"+",$operande2);
	
	}
	else if ((($op1.$op.$op2."=".$res) == ($partie3."+".$op2."=".$res))and($op2!=$tout1)and(!$exclusion1))
	{
		if ($op2==$partie2)	
		{
		$resultat = $op2; 
		}
		$operande1 = $partie3; $operande2 = $op2; $resultatf = $res; 
		$colonne2 = 0; $etape1=true;
		$colonne10=9;$colonne11=9;$colonne12=9;
		$resultat_compf = calcul($operande1,"+",$operande2);
	}
	
   else if ((($op1.$op.$op2."=".$res) == ($op1."+".$tout1."=".$res))and($op1!=$partie3)and(!$exclusion))
	{
		if ($op1==$valdiff)	
		{
		$resultat = $op1; 
		}
		$operande1 = $op1; $operande2 = $tout1; $resultatf = $res; 
		$colonne10 = 0; //$colonne2=9;$colonne3=9;$colonne4=9;
		$resultat_compf = calcul($operande1,$op,$operande2);
		$diff=true; $difference=true;
	}
	else if ((($op1.$op.$op2."=".$res) == ($tout1."+".$op2."=".$res))and($op1!=$partie3)and(!$exclusion))
	{
		if ($op2==$valdiff)	
		$resultat = $op2; 
		//$resultat = $op2; 
		$operande1 = $tout1; $operande2 = $op2; $resultatf = $res; 
		$colonne10 = 0; //$colonne2=9;$colonne3=9;$colonne4=9;
		$resultat_compf = calcul($operande1,$op,$operande2);
		$diff=true; $difference=true;//print("colonne2=".$colonne2);exit();
	}
		
   if (($resultat == $partie2) and (($etape1) and ($colonne2==0)))
	{
		$colonne3=9; $colonne4=0; //print(" colonne 2 = 0 colonne3 = 9 colonne4 = 0 "); 
	}
	/* else if ((($resultat == $partie2-1)||($resultat == $partie2+1))and (($etape1)and($colonne2==0)))
	{
		$colonne3 =9 ; $colonne4=1;//print(" colonne 2 = 0 colonne3 = 9 colonne4 = 1 ");  
	} */
	else if ((($resultat > $partie2-1)||($resultat < $partie2-1))and(($etape1)and($colonne2==0)))
	{
		//print (" colonne 2 = 0 colonne 3 = 8 colonne 4 = 8 ");
		$colonne3=8;$colonne4=8;
	} 

	if (($resultat == $valdiff) and (($difference) and ($colonne10==0)))
	{
		$colonne11=9; $colonne12=0;//print(" colonne 10 = 0 colonne11 = 9 colonne12 = 0 "); 
	}
	/* else if ((($resultat == $valdiff-1)||($resultat == $valdiff+1))and (($diff)and($colonne10==0)))
	{
		$colonne3 =11 ; $colonne12=1; //print(" colonne 10 = 0 colonne11 = 9 colonne12 = 1 "); 
	} */
	else if ((($resultat > $valdiff-1)||($resultat < $valdiff-1))and(($difference)and($colonne10==0)))
	{
		//print (" colonne 10 = 0 colonne 11 = 8 colonne 12 = 8 ");
		$colonne11=8;$colonne12=8;
	} 

	//$etape2 = true ;	
}
else if ((count($tabOperation)==1) and ($question=='p'))
{
  if ((($op1.$op.$op2."=".$res) == ($tout1."+".$tout2."=".$res))||(($op1.$op.$op2."=".$res) == ($tout2."+".$tout1."=".$res)))
	{
		$operande1 = $op1; $operande2 = $op2; $resultatf = $res; 
		$colonne1 =4; $colonne2=9;$colonne3=9;$colonne4=9;$colonne5=9;$colonne6=9;$colonne7=9;
		$colonne8=9;$colonne9=9;$colonne10=9;$colonne11=9;$colonne12=9;$colonne13=9;
		$colonne14=5;$colonne15=7;
		$resultat_compf = calcul($operande1,"+",$operande2);$etape1=false;  
	}
  else if ((($op1.$op.$op2."=".$res) == ($tout2."-".$op2."=".$res))and($op2!=$partie1))
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
		$colonne3=9; $colonne4=0; //print(" colonne 2 = 0 colonne3 = 9 colonne4 = 0 "); 
	}
	/* else if ((($resultat == $partie2-1)||($resultat == $partie2+1))and (($etape1)and($colonne2==0)))
	{
		$colonne3 =9 ; $colonne4=1;//print(" colonne 2 = 0 colonne3 = 9 colonne4 = 1 ");  
	} */
	else if ((($resultat > $partie2-1)||($resultat < $partie2-1))and(($colonne2==0) and ($colonne2!='')and($etape1)))
	{
		//print (" colonne 2 = 0 colonne 3 = 8 colonne 4 = 8 ");
		$colonne3=8;$colonne4=8;
	}
}
//=========colonne 14 et 15=============

	 if (($question=='p')and($etape1) and(($op1.$op.$op2."=".$res)==($resultat."+".$op2."=".$tout2)))
		   {
		   	 //print ("colonne 14 = 1  colonne15 = 1");
			 $colonne14 = 1; $colonne15 = 1;//addition a trou 
			 $operande1 = $op1; $operande2 = $res; $resultatf = $op2; 
			 $resultat_compf = calcul($operande2,"-",$operande1);
			 $etape2 = true ; 						
		   }
	  else if (($question=='p')and ($etape1)and(($op1.$op.$op2."=".$res) == ($tout2."-".$resultat."=".$res)))
		   {
			 //print (" colonne 14 = 1  colonne15 = 2 ");
			 $colonne14 = 1; $colonne15 = 2;
			 $operande1 = $op1; $operande2 = $op2; $resultatf = $res;
			 $resultat_compf = calcul($operande1,$op,$operande2);
			 $etape2 = true ;
		   }
	  else if (($question=='p')and ($etape1)and(($op1.$op.$op2."=".$res) == ($resultat."-".$tout2."=".$res)))
		   {
			 //print (" colonne 14 = 1  colonne15 = 3 ");
			 $colonne14 = 1; $colonne15 = 3;
			 $operande1 = $op1; $operande2 = $op2; $resultatf = $res;
			 $resultat_compf = $partie3;
			 $etape2 = true ;
		   }
	  else if (($question=='t')and ($etape1) and ($resultat!=$tout1) and((($op1.$op.$op2."=".$res) == ($resultat."+".$partie3."=".$res)) || 
	  		   (($op1.$op.$op2."=".$res) == ($partie3."+".$resultat."=".$res))))
			{
			 //print (" colonne 14 = 2  colonne15 = 4 ");
			 $colonne14 = 2; $colonne15 = 4;
			 $operande1 = $op1; $operande2 = $op2; $resultatf = $res;
			 $resultat_compf = calcul($operande1,$op,$operande2);
			 $etape2 = true ;
			}
/* ------------------- cas par difference --------------------- */			
	 else if ((($question =='t')and($difference)) and ((($op1.$op.$op2."=".$res) == ($resultat."+".$partie1."=".$res))
	 		 ||(($op1.$op.$op2."=".$res) == ($partie1."+".$resultat."=".$res))))
	 		{
			 //print (" colonne 14 = 3  colonne15 = 4 ");
			 $colonne14 = 3; $colonne15 = 4;
			 $operande1 = $op1; $operande2 = $op2; $resultatf = $res; 
			 $resultat_compf = calcul($operande1,$op,$operande2);
			 $difference2 = true ; //$etape=false;$etape1=false;
			}
	else if ((($question =='p')and($difference)) and ((($op1.$op.$op2."=".$res) == ($partie1."-".$resultat."=".$res))))
	 		{
			 //print (" colonne 14 = 3  colonne15 = 2 ");
			 $colonne14 = 3; $colonne15 = 2;
			 $operande1 = $op1; $operande2 = $op2; $resultatf = $res; 
			 $resultat_compf = calcul($operande1,$op,$operande2);
			 $difference2 = true ; //$etape=false;$etape1=false;
			}
	else if ((($question =='t')and($difference)and($partie3>$partie1)) and (($op1.$op.$op2."=".$res) == ($resultat."+".$tout1."=".$res)
	 		 ||($op1.$op.$op2."=".$res) == ($tout1."+".$resultat."=".$res)))
	 		{
			$colonne14 = 3; $colonne15 = 4;
			 $operande1 = $op1; $operande2 = $op2; $resultatf = $res; 
			 $resultat_compf = calcul($operande1,$op,$operande2);
			 $difference2 = true ; //$etape=false;$etape1=false;
			}
	else if ((($question =='t')and($difference)and($partie3<$partie1)) and (($op1.$op.$op2."=".$res) == ($resultat."-".$tout1."=".$res)
	 		 ||($op1.$op.$op2."=".$res) == ($tout1."-".$resultat."=".$res)))
	 		{
			 //print (" colonne 14 = 3  colonne15 = 2 ");
			 $colonne14 = 3; $colonne15 = 2;
			 $operande1 = $op1; $operande2 = $op2; $resultatf = $res; 
			 $resultat_compf = calcul($operande1,$op,$operande2);
			 $difference2 = true ; //$etape=false;$etape1=false;
			}
	
	else if (((($question =='t')and($partie3<$partie1)) and (($op1.$op.$op2."=".$res) == ($valdiff."-".$tout1."=".$res)
			 ||($op1.$op.$op2."=".$res) == ($tout1."-".$valdiff."=".$res)))and(count($tabOperation)==1))
			{
			 //print (" colonne 14 = 3  colonne15 = 2 ");
			 $colonne10=0;$colonne11=9;$colonne12=0;$diff=true;$difference=true;$resultatd=$valdiff;
			 $colonne14 = 3; $colonne15 = 2;
			 $operande1 = $op1; $operande2 = $op2; $resultatf = $res; 
			 $resultat_compf = calcul($operande1,$op,$operande2);
			 $difference2 = true ; //$etape=false;$etape1=false;
			}
	else if ((($question =='t')and ((($op1.$op.$op2."=".$res) == ($valdiff."+".$partie1."=".$res))
			 ||(($op1.$op.$op2."=".$res) == ($partie1."+".$valdiff."=".$res))))and(count($tabOperation)==1))
			{
			 //print (" colonne 14 = 3  colonne15 = 4 ");
			 $colonne10=0;$colonne11=9;$colonne12=0;$diff=true;$difference=true;$resultatd=$valdiff;
			 $colonne14 = 3; $colonne15 = 4;
			 $operande1 = $op1; $operande2 = $op2; $resultatf = $res; 
			 $resultat_compf = calcul($operande1,$op,$operande2);
			 $difference2 = true ; //$etape=false;$etape1=false;
			}
	else if ((($question =='p') and ((($op1.$op.$op2."=".$res) == ($partie1."-".$valdiff."=".$res))))and(count($tabOperation)==1))
			{
			 //print (" colonne 14 = 3  colonne15 = 2 ");
			 $colonne10=0;$colonne11=9;$colonne12=0;$diff=true;$difference=true;$resultatd=$valdiff;
			 $colonne14 = 3; $colonne15 = 2;
			 $operande1 = $op1; $operande2 = $op2; $resultatf = $res; 
			 $resultat_compf = calcul($operande1,$op,$operande2);
			 $difference2 = true ; //$etape=false;$etape1=false;
			}
		
/* ------------------- fin  difference --------------------- */
	 else if (($question =='p')and((($op1.$op.$op2."=".$res) == ($resultat."+".$tout2."=".$res))||(($op1.$op.$op2."=".$res) == ($tout2."+".$resultat."=".$res)))) 
	 		{
			 //print (" colonne 14 = 4  colonne15 = 4 ");
			 $colonne14 = 4; $colonne15 = 4;
			 $operande1 = $op1; $operande2 = $op2; $resultatf = $res; 
			 $resultat_compf = abs(calcul($operande1,$op,$operande2));
			 $difference2 = true ; 
			 }
	else if (($question =='t')and((($op1.$op.$op2."=".$res) == ($resultat."-".$partie3."=".$res))||(($op1.$op.$op2."=".$res) == ($partie3."-".$resultat."=".$res))))
	 		{
			 //print (" colonne 14 = 4  colonne15 = 3 ");
			 $operande1 = $op1; $operande2 = $op2; $resultatf = $res; 
			 if ($operande1 >= $operande2)
			 	$colonne15 = 2;
			 else if ($operande1 < $operande2)
			 	$colonne15 = 3;
			 $colonne14 = 4; 
			 $resultat_compf = abs(calcul($operande1,$op,$operande2));
			 $difference2 = true ; 
			 }
	 else if (($NonPertinent)and((($op1.$op.$op2."=".$res) == ($partie1."+".$tout1."=".$res))||(($op1.$op.$op2."=".$res) == ($tout1."+".$partie1."=".$res))))
	{
			 $colonne14 = 5; $colonne15 = 4;$colonne16=1;
			 $operande1 = $op1; $operande2 = $op2; $resultatf = $res; 
			 $resultat_compf = calcul($operande1,$op,$operande2);
			 $etape2 = true ; 
	}
	 else if (((($op1.$op.$op2."=".$res) == ($resultat."*".$tout2."=".$res))||(($op1.$op.$op2."=".$res) == ($resultat.":".$tout2."=".$res))||
			  (($op1.$op.$op2."=".$res) == ($tout2."*".$resultat."=".$res))||(($op1.$op.$op2."=".$res) == ($tout2.":".$resultat."=".$res))) and ($etape1))	
			{
			// print (" colonne 14 = 5  colonne15 = 8 ");
			 $colonne14 = 5; $colonne15 = 8;
			 $operande1 = $op1; $operande2 = $op2; $resultatf = $res; 
			 $resultat_compf = calcul($operande1,$op,$operande2);
			 $etape2 = true ; 
			}
	
	 else if ((($op1.$op.$op2."=".$res) == ($resultat."*".$partie3."=".$res))||(($op1.$op.$op2."=".$res) == ($resultat.":".$partie3."=".$res))||
			  (($op1.$op.$op2."=".$res) == ($partie3."*".$resultat."=".$res))||(($op1.$op.$op2."=".$res) == ($partie3.":".$resultat."=".$res)))	
			{
			 //print (" colonne 14 = 5  colonne15 = 8 ");
			 $colonne14 = 5; $colonne15 = 8;$etape=false;
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
			 //print (" colonne 14 = 5  colonne15 = 4 ");
			 $NonPertinent = true; $colonne14 = 5; $colonne15 = 4;//41;
			 $operande1 = $op1; $operande2 = $op2; $resultatf = $res; 
			 $resultat_compf = abs(calcul($operande1,$op,$operande2)); 
			}
            /* else if (($question =='t')and(($op1.$op.$op2."=".$res) == ($resultat."+".$op2."=".$res)))
	 		{
			 //print (" colonne 14 = 5 colonne15 = 1 ");
			 $colonne14 = 5; $colonne15 = 1;
			 $operande1 = $res; $operande2 = $op1; $resultatf = $op2; 
			 $resultat_compf = abs(calcul($operande1,"-",$operande2));
			 $etape3 = true ; 
			 } */
	else if (($op1.$op.$op2."=".$res) and(!$NonPertinent) and (count($tabOperation)!=0))
   		   {
		   	 $colonne14 = 5; 
				 if ($op == '+')
					$colonne15=4;
				 else if ($op == '-')
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
			 $operande1 = $op1; $operande2 = $op2; $resultatf = $res; 
			 $resultat_compf = calcul($operande1,$op,$operande2);
			 $etape2 = true ; $colonne16=1;
			}
	else if ((count($tabImp)!=0)and(count($tabOperation)==0)and
			 ((($question=="t")and(!ereg("$partie2|$valdiff|$tout2",$tabImp[0])))||(($question=="p")and(!ereg("$partie2|$valdiff|$partie3",end($tabImp))))))
 		{
		 $colonne14=0;$colonne15=0;$colonne16=8; $colonne17 = 8; $colonne1=6;
		}

	/*================= colonne 16 pertinence des données de l'operation ==============*/
	 if ($colonne16==4)
	 {$colonne16=4;}
	 else if (
	 /* 			 (($operande1==$tout2)and($operande2==$resultat)and(($colonne4 == 1)||($colonne8 == 1)||($colonne12 == 1)))||
				 (($operande1==$resultat)and($operande2==$tout2)and(($colonne4 == 1)||($colonne8 == 1)||($colonne12 == 1)))||
				 (($operande1==$partie3)and($operande2==$resultat)and(($colonne4 == 1)||($colonne8 == 1)||($colonne12 == 1)))||
				 (($operande1==$resultat)and($operande2==$partie3)and(($colonne4 == 1)||($colonne8 == 1)||($colonne12 == 1)))||
				 (($operande1==$tout1)and($operande2==$resultatd)and(($colonne4 == 1)||($colonne8 == 1)||($colonne12 == 1)))||
				 (($operande1==$resultatd)and($operande2==$tout1)and(($colonne4 == 1)||($colonne8 == 1)||($colonne12 == 1)))||
				 (($operande1==$partie1)and($operande2==$resultatd)and(($colonne4 == 1)||($colonne8 == 1)||($colonne12 == 1)))||
				 (($operande1==$resultatd)and($operande2==$partie1)and(($colonne4 == 1)||($colonne8 == 1)||($colonne12 == 1)))
			 */
			($colonne4 == 1)||($colonne8 == 1)||($colonne12 == 1) 
			 
		)
	  {
	  	$colonne16=2; //print(" colonne16 = 2 "); 
	  }	
	 else  if (
				 /* (($operande1==$tout2)and($operande2==$resultat)and(($colonne4 == 2)||($colonne8 == 2)||($colonne12 == 2)))||
				 (($operande1==$resultat)and($operande2==$tout2)and(($colonne4 == 2)||($colonne8 == 2)||($colonne12 == 2)))||
				 (($operande1==$partie3)and($operande2==$resultat)and(($colonne4 == 2)||($colonne8 == 2)||($colonne12 == 2)))||
				 (($operande1==$resultat)and($operande2==$partie3)and(($colonne4 == 2)||($colonne8 == 2)||($colonne12 == 2)))||
			     
				 (($operande1==$tout1)and($operande2==$resultatd)and(($colonne4 == 2)||($colonne8 == 2)||($colonne12 == 2)))||
				 (($operande1==$resultatd)and($operande2==$tout1)and(($colonne4 == 2)||($colonne8 == 2)||($colonne12 == 2)))||
				 (($operande1==$partie1)and($operande2==$resultatd)and(($colonne4 == 2)||($colonne8 == 2)||($colonne12 == 2)))||
				 (($operande1==$resultatd)and($operande2==$partie1)and(($colonne4 == 2)||($colonne8 == 2)||($colonne12 == 2))) */
				($colonne4 == 2)||($colonne8 == 2)||($colonne12 == 2)
			 )
	  {
	  $colonne16=3; //print(" colonne16 = 3"); 
	  }	
	 else if (
	 
				 (($operande1==$tout2)and($operande2==$resultat)and($colonne2!=5))||
				 (($operande1==$resultat)and($operande2==$tout2)and($colonne2!=5))||
				 (($operande1==$partie3)and($operande2==$resultat)and($colonne2!=5))||
				 (($operande1==$resultat)and($operande2==$partie3)and($colonne2!=5))||
				  
				 (($operande1==$tout1)and($operande2==$resultatd)and($colonne2!=5))||
				 (($operande1==$resultatd)and($operande2==$tout1)and($colonne2!=5))||
				 (($operande1==$partie1)and($operande2==$resultatd)and($colonne2!=5))||
				 (($operande1==$resultatd)and($operande2==$partie1)and($colonne2!=5))||
				 
				 (($operande1==$tout1)and($operande2==$resultat)and($colonne2!=5))||
				 (($operande1==$resultat)and($operande2==$tout1)and($colonne2!=5))||
				 (($operande1==$partie1)and($operande2==$resultat)and($colonne2!=5))||
				 (($operande1==$resultat)and($operande2==$partie1)and($colonne2!=5))
				
			 )
	  {
	  	$colonne16=0; //print(" colonne16 = 0 "); 
	  }								
	
	 else if ((($question=='t')and (($operande1==$tout1)and($operande2==$partie3)) || (($operande2==$partie3)and($operande2==$tout1))) 
	         ||((($question=='p')and($difference2))and (($operande1==$tout1)xor($operande2==$resultatd)) || (($operande2==$resultatd)xor($operande2==$tout1))))
	  {
	  	$colonne16=1; //print(" colonne16 = 1 "); 
	  }
	  else if (((($question=='t')and($difference2))and (($operande1==$partie1)xor($operande2==$resultatd)) || (($operande2==$resultatd)xor($operande2==$partie1))) 
	         ||((($question=='p')and($difference2))and (($operande1==$tout1)xor($operande2==$resultatd)) || (($operande2==$resultatd)xor($operande2==$tout1))))
	  {
	  	$colonne16=1; //print(" colonne16 = 1 "); 
	  }
	 else if ((($question=='t')and (($operande1==$partie3)xor($operande2==$resultat)) || (($operande2==$resultat)xor($operande2==$partie3))) 
	         ||(($question=='p')and (($operande1==$tout2)xor($operande2==$resultat)) || (($operande2==$resultat)xor($operande2==$tout2))))
	  {
	  	  //print("ok");exit();
	
		$colonne16=1; //print(" colonne16 = 1 "); 
	  }
	 else if ((($colonne14 == 9)||($colonne14 == 0)) and (!(ereg("[0-8]",$colonne17))))
		{
			$colonne16=9; //print(" colonne16 = 9 "); 
		}
	 else if ((($operande1==$tout2)||($operande1==$resultat)||($operande1==$partie3))&&(($operande2==$tout2)||($operande2==$partie3)||($operande2==$resultat)))
	  	{
			$colonne16=0; //print(" colonne16 = 0 "); 
		}
	 else if (($colonne4 == 1)||($colonne8 == 1)||($colonne12 == 1))
		{ 
			$colonne16=2;//print(" colonne16 = 2 ");  
		}
	 
	 /*else if ((($operande1==$tout2)xor($operande2==$resultat))||(($operande2==$tout2)xor($operande1==$resultat))||
	          (($operande1==$partie3)xor($operande2==$resultat))||(($operande2==$partie3)xor($operande2==$resultat)))
		{ 
			 $colonne16=2; //print(" colonne16 = 2 ");
		} else if (($colonne4==2)||($colonne8==2)||($colonne12==2))
		{ 
			 $colonne16=3; //print(" colonne16 = 3 ");
		}*/	
/* --------------  cas d'une opartation a trois operande -----------------------*/
if (count($tabOperation2 >= 1))
{
if (count ($T1) == 2 ) 
{
	$op1 = $T2[0]; $op2 = $T2[1]; $op3 = $T2[2] ; $res = $T2[3];
	$op = $T1[0];$oper = $T1[1];
	//if ($T2[3]!="")
	//print ("<br>l'operation est : ".$op1.$op.$op2.$oper.$op3."=".$res."<br>"); 
	if ((($question=='t')and(($T1[0]=="+")and($T1[1]=="+")and(in_array($partie1,$T2))and(in_array($tout1,$T2))and(in_array($partie3,$T2))))||
	(($question=='p')and(($T1[0]=="+")and($T1[1]=="+")and(in_array($partie1,$T2))and(in_array($tout1,$T2))and(in_array($tout2,$T2)))))
	{
	 //print (" colonne 14 = 5  colonne15 = 5 ");
	
	 $colonne1=4;$colonne2=9;$colonne3=9;$colonne4=9;$colonne5=9;$colonne6=9;$colonne7=9;
	 $colonne8=9;$colonne9=9;$colonne10=9;$colonne11=9;$colonne12=9;$colonne13=9;
	 $colonne14 = 5; $colonne15 = 5;$colonne16=1;
	 $etape=false; $etape1=false; $difference=false; $difference1=false;$etape2 = false ; 
	 $operande1 = $op1; $operande2 = $op2; $operande3 = $op3; $resultatf = $res; 
	 $resultat_compf = $op1+$op2+$op3;
	}
	if ((($question=='t')and(($T1[0]=="*")and($T1[1]=="*")and(in_array($partie1,$T2))and(in_array($tout1,$T2))and(in_array($partie3,$T2))))||
	(($question=='p')and(($T1[0]=="*")and($T1[1]=="*")and(in_array($partie1,$T2))and(in_array($tout1,$T2))and(in_array($tout2,$T2)))))
	{
	 //print (" colonne 14 = 5  colonne15 = 5 ");
	 $colonne1=4;$colonne2=9;$colonne3=9;$colonne4=9;$colonne5=9;$colonne6=9;$colonne7=9;
	 $colonne8=9;$colonne9=9;$colonne10=9;$colonne11=9;$colonne12=9;$colonne13=9;
	 $colonne14 = 5; $colonne15 = 6;$colonne16=1;
	 $etape=false; $etape1=false; $difference=false; $difference1=false;$etape2 = false ; 
	 $operande1 = $op1; $operande2 = $op2; $operande3 = $op3; $resultatf = $res; 
	 $resultat_compf = $op1*$op2*$op3;
	}
	if ((($question=='t')and(($T1[0]==":")and($T1[1]==":")and(in_array($partie1,$T2))and(in_array($tout1,$T2))and(in_array($partie3,$T2))))||
	(($question=='p')and(($T1[0]==":")and($T1[1]==":")and(in_array($partie1,$T2))and(in_array($tout1,$T2))and(in_array($tout2,$T2)))))
	{
	 //print (" colonne 14 = 5  colonne15 = 5 ");
	 $colonne1=4;$colonne2=9;$colonne3=9;$colonne4=9;$colonne5=9;$colonne6=9;$colonne7=9;
	 $colonne8=9;$colonne9=9;$colonne10=9;$colonne11=9;$colonne12=9;$colonne13=9;
	 $colonne14 = 5; $colonne15 = 6;$colonne16=1;
	 $etape=false; $etape1=false; $difference=false; $difference1=false;$etape2 = false ; 
	 $operande1 = $op1; $operande2 = $op2; $operande3 = $op3; $resultatf = $res; 
	 $resultat_compf = $op1/$op2/$op3;
	}
	else if ((($question=='t')and((($op1.$op.$op2.$oper.$op3."=".$res) == ($tout1."+".$partie3."-".$partie1."=".$res))||
	(($op1.$op.$op2.$oper.$op3."=".$res) == ($partie3."+".$tout1."-".$partie1."=".$res)))))
	{
	 $colonne1=2;$colonne2=9;$colonne3=9;$colonne4=9;$colonne6=9;$colonne7=9;
	 $colonne8=9;$colonne9=9;$colonne10=2;$colonne11=0;$colonne12=9;$colonne13=9;
	 $colonne14 = 3; $colonne15 = 4;$colonne16=0;
	 $etape=false; $etape1=false; $difference=true; $difference1=true; $diff=true;$etape2 = false ; 
	 $operande1 = $op1; $operande2 = $op2; $operande3 = $op3; $resultatf = $res; 
	 $resultat_compf = $op1+$op2-$op3;
	}
	else if (($question=='t')and(($op1.$op.$op2.$oper.$op3."=".$res) == ($tout1."-".$partie1."+".$partie3."=".$res)))
	{
	 $colonne1=1;$colonne2=2;$colonne3=0;$colonne4=9;$colonne6=9;$colonne7=9;
	 $colonne8=9;$colonne9=9;$colonne10=9;$colonne11=9;$colonne12=9;$colonne13=9;
	 $colonne14 = 2; $colonne15 = 4;$colonne16=0;
	 $etape=true; $etape1=true; $difference=false; $difference1=false;$etape2 = true ; 
	 $operande1 = $op1; $operande2 = $op2; $operande3 = $op3; $resultatf = $res; 
	 $resultat_compf = $op1-$op2+$op3; 
	}
  	else if ((($question=='t')and($partie3>$partie1))and((($op1.$op.$op2.$oper.$op3."=".$res) == ($partie3."-".$partie1."+".$tou1."=".$res))
	||(($op1.$op.$op2.$oper.$op3."=".$res) == ($tou1."+".$partie3."-".$partie1."=".$res))))
	{
	 $colonne1=2;$colonne2=9;$colonne3=9;$colonne4=9;$colonne6=9;$colonne7=9;
	 $colonne8=9;$colonne9=9;$colonne10=2;$colonne11=0;$colonne12=9;$colonne13=9;
	 $colonne14 = 3; $colonne15 = 4;$colonne16=0;
	 $etape=false; $etape1=false; $difference=true; $difference1=true;$diff=true;$etape2 = false; 
	 $operande1 = $partie3; $operande2 = $partie1; $operande3 = $tout1; $resultatf = $res; 
	 $resultat_compf = $op1-$op2+$op3; 
	}
	else if ((($question=='t')and($partie3<$partie1))and((($op1.$op.$op2.$oper.$op3."=".$res) == ($partie1."-".$partie3."+".$tou1."=".$res))
	||(($op1.$op.$op2.$oper.$op3."=".$res)==($tou1."+".$partie1."-".$partie3."=".$res))))
	{
	 $colonne1=2;$colonne2=9;$colonne3=9;$colonne4=9;$colonne6=9;$colonne7=9;
	 $colonne8=9;$colonne9=9;$colonne10=2;$colonne11=0;$colonne12=9;
	 $colonne14 = 3; $colonne15 = 4;$colonne16=0;
	 $etape=false; $etape1=false; $difference=true; $difference1=true;$diff=true;$etape2 = false; 
	 $operande1 = $partie1; $operande2 = $partie3; $operande3 = $tout1; $resultatf = $res; 
	 $resultat_compf = $op1-$op2+$op3; 
	}
	else if ((($question=='p')and($tout2>$tout1))and((($op1.$op.$op2.$oper.$op3."=".$res) ==($tout2."-".$tout1."+".$partie1."=".$res))
	||(($op1.$op.$op2.$oper.$op3."=".$res)==($partie1."+".$tout2."-".$tout1."=".$res))))
	{
	 $colonne1=2;$colonne2=9;$colonne3=9;$colonne4=9;$colonne6=9;$colonne7=9;
	 $colonne8=9;$colonne9=9;$colonne10=2;$colonne11=0;$colonne12=9;
	$colonne14 = 3; $colonne15 = 4;$colonne16=0;
	 $etape=false; $etape1=false; $difference=true; $difference1=true; $diff=true;$etape2 = false; 
	 $operande1 = $tout2; $operande2 = $tout1; $operande3 = $partie1; $resultatf = $res; 
	 $resultat_compf = $op1-$op2+$op3; 
	}
	else if ((($question=='p')and($tout2<$tout1))and((($op1.$op.$op2.$oper.$op3."=".$res) == ($tout1."-".$tout2."+".$partie1."=".$res))
	||(($op1.$op.$op2.$oper.$op3."=".$res)==($partie1."+".$tout1."-".$tout2."=".$res))))
	{
	 $colonne1=2;$colonne2=9;$colonne3=9;$colonne4=9;$colonne6=9;$colonne7=9;
	 $colonne8=9;$colonne9=9;$colonne10=2;$colonne11=0;$colonne12=9;
	 $colonne14 = 3; $colonne15 = 4;$colonne16=0;
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
	 $resultat_compf = $op1+$op2-$op3;
	}
}
}
/*----------------------------- fin if (count($tabOperation2 >= 1))---------------------------------*/	
/*=============== colonne 17 exactitude du resultat du calcul =================*/
 if ($colonne17==8) 
	{
	    $colonne17=8;
	}
else if ((($colonne15 == 9)||($resultatf==''))and (!(ereg("[0-8]",$colonne17))))
	{
	     $colonne17=9; //	print(" colonne17 = 9 "); 	
	}
else if ($resultatf == $resultat_compf)
	{
		 $colonne17=0; //print(" colonne17 = 0 ");
	}
else if (($resultatf == $resultat_compf-1)||($resultatf == $resultat_compf+1))
	{
		$colonne17=1; //print(" colonne17 = 1 "); 
	}	
else if (($resultatf < $resultat_compf-1) ||($resultatf > $resultat_compf-1))
	{
		 $colonne17=2; //print(" colonne17 = 2 ");
	}
/*----------------- coder la stategie colonne 1 -----------------------*/
if (($colonne1==4)||($NonPertinent))
{
$colonne1=4;
}
else if ($colonne1==6)
{$colonne1=6;}
else if (($etape) and ($diff))
{
	$colonne1=3; //print(" colonne1 = 3 "); 
}   
else if ((($etape1)and($etape2))||($etape))
 {
  $colonne1=1; //print(" colonne1 = 1 ");	
 }
else if (($difference)and($difference2))//||($difference)||($diff))
 {
  $colonne1=2; //print(" colonne1 = 2 ");	
 }

else if ($varImp || $implicite)
{
	$colonne1=5;//print(" colonne1 = 5 "); 
}
else if (count($tabNombre)==0)
{
	$colonne1=9;//print(" colonne1 = 9 "); 
}
else 
{
	$colonne1=4;//print(" colonne1 = 4 "); 
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
if (!(ereg("[0-7]",$colonne1))) $colonne1=9;
if (!(ereg("[0-7]",$colonne2))) $colonne2=9;
if (!(ereg("[0-8]",$colonne3))) $colonne3=9;
if (!(ereg("[0-8]",$colonne4))) $colonne4=9;
if (!(ereg("[0-7]",$colonne5))) $colonne5=9;
if (!(ereg("[0-5]",$colonne6))) $colonne6=9;
if (!(ereg("[0-8]",$colonne7))) $colonne7=9;
if (!(ereg("[0-8]",$colonne8))) $colonne8=9;
if (!(ereg("[0-5]",$colonne9))) $colonne9=9;
if (!(ereg("[0-5]",$colonne10))) $colonne10=9;
if (!(ereg("[0-8]",$colonne11))) $colonne11=9;
if (!(ereg("[0-8]",$colonne12))) $colonne12=9;
if (!(ereg("[0-5]",$colonne13))) $colonne13=9;
if (!(ereg("[0-5]",$colonne14))) $colonne14=9;
if (!(ereg("[0-8]",$colonne15))) $colonne15=9;
if (!(ereg("[0-8]",$colonne16))) $colonne16=9;
if (!(ereg("[0-8]",$colonne17))) $colonne17=9;
if (!(ereg("[0-8]",$colonne18))) $colonne18=9;
$typeExo="e";
/*_____________________________________________________________________________________*/
$Requete_SQL = "INSERT INTO trace (numEleve,numExo,typeExo,questInt,sas ,choix,
				operation1, operation2, operande1, operande2,operande3,zonetext,resultat) VALUES 
				('".$_SESSION['numEleve']."','".$n."','".$typeExo."','".$questi."','".$sas."','".$choix."',
				'".$oper1."','".$oper2."','".$op1."','".$op2."','".$op3."','".$text."','".$resultat."')";
// Execution de la requete SQL.
$result = mysql_query($Requete_SQL) or die("Erreur d'Insertion dans la base : ". $Requete_SQL .'<br />'. mysql_error());
$Requete_SQL3 = "select id from trace order by id desc limit 1";
$result3 = mysql_query($Requete_SQL3) or die("Erreur d'Insertion dans la base : ". $Requete_SQL3 .'<br />'. mysql_error());
while ($r = mysql_fetch_assoc($result3))
			{
			$id = $r["id"];
			}
/* -------------------------------------------------------------------------------------*/
print("<br><br>colonne1 = ".$colonne1." colonne2 = ".$colonne2." colonne3 = ".$colonne3.
		 " colonne4 = ".$colonne4." colonne10 = ".$colonne10." colonne11 = ".$colonne11." colonne12 = ".$colonne12.
		 " colonne14 = ".$colonne14." colonne15 = ".$colonne15." colonne16 = ".$colonne16." colonne17 = ".$colonne17
		 ." colonne18 = ".$colonne18);
exit();
$Requete_SQL1 = "INSERT INTO diagnostic (numSerie,numTrace,numEleve,date,numExo,typeExo,question,var ,questInt,
				colonne1, colonne2, colonne3, colonne4,colonne5,colonne6, colonne7, colonne8, colonne9,colonne10,
				colonne11,colonne12,colonne13,colonne14,colonne15,colonne16,colonne17,colonne18) VALUES 
				('".$numSerie."','".$id."','".$_SESSION['numEleve']."','".$date."','".$n."','".$typeExo."','".$question."','".$var."','".$questi."',
				$colonne1,$colonne2,$colonne3,$colonne4,$colonne5, $colonne6,$colonne7,$colonne8,$colonne9,$colonne10,
				$colonne11,$colonne12,$colonne13,$colonne14,$colonne15,$colonne16,$colonne17,$colonne18)";

$result = mysql_query($Requete_SQL1) or die("Erreur d'Insertion dans la base : ". $Requete_SQL1 .'<br />'. mysql_error());
// Execution de la requete SQL.

mysql_close();

mysql_close();
?>
<?php
// ----------------------------------------------------------------------------
define("FORMAT_REEL",   1); // #,##0.00
define("FORMAT_ENTIER", 2); // #,##0
define("FORMAT_TEXTE",  3); // @

$cfg_formats[FORMAT_ENTIER] = "FF0";
$cfg_formats[FORMAT_REEL]   = "FF2";
$cfg_formats[FORMAT_TEXTE]  = "FG0";

// ----------------------------------------------------------------------------

$cfg_hote = 'localhost';
$cfg_user = 'root';
$cfg_pass = '';
$cfg_base = 'projet';

// ----------------------------------------------------------------------------

if (mysql_connect($cfg_hote, $cfg_user, $cfg_pass))
{
    // construction de la requête
    // ------------------------------------------------------------------------
    $sql  = "SELECT numSerie,numTrace,numEleve,date,numExo,typeExo,question,var ,questInt,colonne1, colonne2, colonne3, colonne4,colonne5,colonne6, colonne7, colonne8, colonne9,colonne10,colonne11,colonne12,colonne13,colonne14,colonne15,colonne16,colonne17,colonne18 ";
    $sql .= "FROM diagnostic ";
    $sql .= "WHERE numEleve=".$_SESSION['numEleve'] ;
    

    // définition des différentes colonnes de données
    // ------------------------------------------------------------------------
    $champs = Array(
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


    if ($resultat = mysql_db_query($cfg_base, $sql))
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
		$x=$x.";X".($nbcol = mysql_num_fields($resultat))."\n";
		$x=$x."\n";

        // récupération des infos de formatage des colonnes
        // --------------------------------------------------------------------
		for ($cpt = 0; $cpt < $nbcol; $cpt++)
        {
            $num_format[$cpt] = $champs[$cpt][2];
            $format[$cpt] = $cfg_formats[$num_format[$cpt]].$champs[$cpt][3];
        }

        // largeurs des colonnes
        // --------------------------------------------------------------------
        for ($cpt = 1; $cpt <= $nbcol; $cpt++)
        {
            // F;Wcoldeb colfin largeur
			$x=$x."F;W".$cpt." ".$cpt." ".$champs[$cpt-1][4]."\n";
        }
		$x=$x."F;W".$cpt." 256 8\n"; // F;Wcoldeb colfin largeur
		$x=$x."\n";

        // en-tête des colonnes (en gras --> SDM4)
        // --------------------------------------------------------------------
		for ($cpt = 1; $cpt <= $nbcol; $cpt++)
        {
			$x=$x."F;SDM4;FG0C;".($cpt == 1 ? "Y1;" : "")."X".$cpt."\n";
			$x=$x."C;N;K\"".$champs[$cpt-1][1]."\"\n";
        }
		$x=$x."\n";

        // données utiles
        // --------------------------------------------------------------------
        $ligne = 2;
        while ($enr = mysql_fetch_array($resultat))
        {
            // parcours des champs
            for ($cpt = 0; $cpt < $nbcol; $cpt++)
            {
                // format
				$x=$x."F;P".$num_format[$cpt].";".$format[$cpt];
				$x=$x.($cpt == 0 ? ";Y".$ligne : "").";X".($cpt+1)."\n";
                // valeur
                if ($num_format[$cpt] == FORMAT_TEXTE)
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
	$fichier="diag\\".$_SESSION['nom'].$_SESSION['numEleve'].".slk";
	$fp = fopen ("$fichier", "w");
	//enregistre les données dans le fichier
	fputs($fp, "$x");
	fclose ($fp);
    mysql_close();
}

?>
<?php 
echo "<script type='text/javascript'>location.href='redirectionNav.php?numSerie=".$_SESSION['numSerie']."';</script>"; 
?> 
