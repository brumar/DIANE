<?php 
/* colonne 14 à 18 la solution finale*/
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
$nombreInv = array_reverse($nombre);
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
$op1 = $T2[0]; $op2 = $T2[1]; $res = $T2[2];
$op = $T1[0]; 
print ("le resultat intermediaire est :".$resultat);
//=========colonne 14 et 15=============
 if (($op1.$op.$op2."=".$res) == ($resultat."+".$op2."=".$tout2))
		   {
			 print ("colonne 14 = 1  colonne15 = 1");
			 $colonne14 = 1; $colonne15 = 1;//addition a trou 
			 $operande1 = $op1; $operande2 = $res; $resultatf = $op2; 
			 $resultat_compf = calcul($operande2,"-",$operande1);
			 $etape2 = true ; 						
			}
	  else if (($op1.$op.$op2."=".$res) == ($tout2."-".$resultat."=".$res))
		   {
			 print (" colonne 14 = 1  colonne15 = 1 ");
			 $colonne14 = 1; $colonne15 = 2;
			 $operande1 = $op1; $operande2 = $op2; $resultatf = $res;
			 $resultat_compf = calcul($operande1,$op,$operande2);
			 $etape2 = true ;
		   }
	  else if (($op1.$op.$op2."=".$res) == ($resultat."-".$tout2."=".$res))
		   {
			 print (" colonne 14 = 1  colonne15 = 3 ");
			 $colonne14 = 1; $colonne15 = 3;
			 $operande1 = $op1; $operande2 = $op2; $resultatf = $res;
			 $resultat_compf = $partie3;
			 $etape2 = true ;
		   }
	  else if ((($op1.$op.$op2."=".$res) == ($resultat."+".$partie3."=".$res)) || (($op1.$op.$op2."=".$res) == ($partie3."+".$resultat."=".$res)))
			{
			 print (" colonne 14 = 2  colonne15 = 4 ");
			 $colonne14 = 2; $colonne15 = 4;
			 $operande1 = $op1; $operande2 = $op2; $resultatf = $res;
			 $resultat_compf = calcul($operande1,$op,$operande2);
			 $etape1 = true ;
			}
	 else if ((($op1.$op.$op2."=".$res) == ($resultat."*".$tout2."=".$res))||(($op1.$op.$op2."=".$res) == ($resultat.":".$tout2."=".$res))||
			  (($op1.$op.$op2."=".$res) == ($tout2."*".$resultat."=".$res))||(($op1.$op.$op2."=".$res) == ($tout2.":".$resultat."=".$res)))	
			{
			 print (" colonne 14 = 5  colonne15 = 6 ");
			 $colonne14 = 2; $colonne15 = 4;
			 $operande1 = $op1; $operande2 = $op2; $resultAat = $res; 
			 $resultat_compf = calcul($operande1,$op,$operande2);
			 $etape2 = true ; 
			}
	 else if ((($op1.$op.$op2."=".$res) == ($resultat."*".$partie3."=".$res))||(($op1.$op.$op2."=".$res) == ($resultat3.":".$partie3."=".$res))||
			  (($op1.$op.$op2."=".$res) == ($partie3."*".$resultat."=".$res))||(($op1.$op.$op2."=".$res) == ($partie3.":".$resultat3."=".$res)))	
			{
			 print (" colonne 14 = 5  colonne15 = 6 ");
			 $colonne14 = 2; $colonne15 = 4;
			 $operande1 = $op1; $operande2 = $op2; $resultat = $res; 
			 $resultat_compf = calcul($operande1,$op,$operande2);
			 $etape2 = true ; 
			}
	 /*else if (($tabOperation==1) and (in_array($tabImp[0],$tabOperande))
	 		{
				if ($tabImp[0]==
			}*/

 /*================= colonne 16 pertinence des données de l'operation ==============*/
 
	if (($colonne14 == 9)||($colonne14 == 0????Ð?	?????)) 
		{
			print(" colonne16 = 9 "); $colonne16=9; 
		}
	   else if (($colonne4 == 1)||($colonne8 == 1)||($colonne12 == 1))
		{ 
			print(" colonne16 = 2 "); $colonne16=2; 
		}
	  else if ((($operande1==$tout2)||($operande1==$resultat))&&(($operande2==$tout2)||($operande2==$partie3)||($operande2==$resultat)))
		{
			print(" colonne16 = 0 "); $colonne16=0; 
		}
	   else if ((($operande1==$tout2)||($operande1==$partie3)||($operande1==$resultat))xor(($operande2==$tout2)||($operande2==$partie3)||($operande2==$resultat)))
		{ 
			print(" colonne16 = 2 "); $colonne16=2; 
		}
	 
	  else if (($colonne4 == 2)||($colonne8 == 2)||($colonne12 == 2))
		{ 
			print(" colonne16 = 3 "); $colonne16=3; 
		}
	
	/*=============== colonne 17 exactitude du resultat du calcul =================*/
 
	if (($colonne15 == 9)||($resultatf==''))
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
	 else if (($resultatf < $Aresultat_compf-1) ||($resultatf > $resultat_compf-1))
		{
			print(" colonne17 = 2 "); $colonne17=2; 
		}
?>