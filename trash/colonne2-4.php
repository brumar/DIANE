<?php 
/* colonne2 à colonne 4 */
if ($difference != true)
	{
		   //differce est different de true donc les colonne :
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
	}//fin => if($difference = true)
			else 
				{
				 print ("colonne2 =9");
				 $colonne2 = 9;	
				}
//=================colonne3=============
		  if (($colonne2 == 0) and ($resultat!=$partie2) and ($etape1))//a revoir 
			{ 
				print(" colonne3 = 8 "); $colonne3=8; 
			}
			else if ((($colonne2 == 9)||($colonne2 == 0))and ($etape1)) 
			{
				print(" colonne3 = 9 "); $colonne3=9; 
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
		 if ((($colonne2 == 0)||($colonne2 == 9)||($resultat==''))and ($etape1))
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
	
?>