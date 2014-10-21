<?php 
/* colonne 10 a 13 starategie par difference */
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
			else if (colonne10==0)
			{
				 //print ("colonne10 = 0");
				 $colonne10 = 0;
				 $operande1 = ''; $operande2 = ''; $resultat = $valdiff;
				 $difference = true ; 
			}
			else 
				{
				 print ("colonne10 =9"); $colonne10 = 9;
				 //$difference = true ;	
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
?>