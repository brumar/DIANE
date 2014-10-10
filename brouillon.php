<?php 


			$_xml .="<colonne1 sexe=\"".$sexe."\" intitule=\"strategie\" q=\"".$q."\" nbOper=\"".$nbOper."\" code=\"".$r["colonne1"]."\" col2=\"".$r["colonne2"]."\" col16=\"".$r["colonne16"]."\" type=\"".$r["typeExo"]."\">\r\n"; 
				switch ($r["colonne1"])
				{
					case "1" : $_xml .= "Etape";
								break;
					case "2" : $_xml .= "Différence\r\n";
							   if($r["question"]=="p") {
							   			$_xml .="<partie1>".$partie1."</partie1>\r\n";
										$_xml .="<partie3>".$partie3."</partie3>\r\n";
										$_xml .="<tout1>".$tout1."</tout1>\r\n";
										$_xml .="<tout2>".$tout2."</tout2>\r\n";
										$_xml .="<valdiff>".$valdiff."</valdiff>\r\n";
									}
							   else if($r["question"]=="t") {
							   			$_xml .="<tout1>".$tout1."</tout1>\r\n";
										$_xml .="<tout2>".$tout2."</tout2>\r\n";
										$_xml .="<partie1>".$partie1."</partie1>\r\n";
										$_xml .="<partie3>".$partie3."</partie3>\r\n";
										$_xml .="<valdiff>".$valdiff."</valdiff>\r\n";										
									}
								break;
					case "3" : $_xml .= "Etape et difference\r\n";

					case "4" : $_xml .= "Non pertinent";
								break;
					case "5" : $_xml .= "Non identifiable menant à une solution correcte";
								break;
					case "6" : $_xml .= "Non identifiable mais la solution est incorrecte";
								break;
					case "7" : $_xml .= "résultat de la difference comme résultat final Erreur";
								break;
					case "9" : $_xml .= "absence";
								break;
				}
				$_xml .="</colonne1>\r\n"; 
			if(!($r["colonne2"]=='9' and $r["colonne3"]=='9' and $r["colonne4"]=='9'))
			{
				$_xml .="<colonne2 sexe=\"".$sexe."\" intitule=\"calcule du résultat intermédiaire\" nbOper=\"".$nbOper."\" code=\"" . $r["colonne2"] . "\">\r\n"; 
				switch ($r["colonne2"])
				{ 
					case "0" : $_xml .= "implicite ";
							   //$_xml .="<res>(".$partie2.")</res>\r\n";
								break;
					case "1" : $_xml .= "addition à trou ";
					          if($r["colonne3"]==0 and $r["colonne4"]==0) 
							  			$_xml .="<op>(".$partie1."+ ? =".$tout1.")</op>\r\n";//resultat correct
							  else if($r["colonne3"]==0 and $r["colonne4"]==1 or $r["colonne4"]==2) 
							  			$_xml .="<op>(".$partie1."+ ? =".$tout1.")</op>\r\n"; //erreur compt
							  break;
					case "2" : $_xml .= "soustraction ";
					          if($r["colonne3"]==0 and $r["colonne4"]==0) 
							  			$_xml .="<op>(".$tout1."-".$partie1.")</op>\r\n"; 
							  else if($r["colonne3"]==0 and ($r["colonne4"]==1 or $r["colonne4"]==2)) 
							  			$_xml .="<op>(".$tout1."-".$partie1.")</op>\r\n"; 
							  else if($r["colonne3"]==1 and ($nbOper==1)) 
							  			$_xml .="<op>(".$tabSR[0].")</op>\r\n";

								break;
					case "3" : $_xml .= "soustraction inversée ";
					          if($r["colonne3"]==0 and $r["colonne4"]==0) 
							  			$_xml .="<op>(".$partie1."-".$tout1.")</op>\r\n";
							  else if($r["colonne3"]==0 and ($r["colonne4"]==1 or $r["colonne4"]==2)) 
							  			$_xml .="<op>(".$partie1."-".$tout1.")</op>\r\n";
								break;
					case "4" : $_xml .= "addition ";
					          if($r["colonne3"]==0) 
							  			$_xml .="<op>(".$tout1."+".$partie1.")</op>\r\n"; 
							  else if($r["colonne3"]==1 and $r["colonne4"]==0 and $nbOper>=2) 
							  			$_xml .="<op>(".$tabSR[0].")</op>\r\n"; 
							  break;
					case "5" : $_xml .= "autre opération ";
									$_xml .="<op>(".$tabOperation[0].")</op>\r\n"; 
								break;
					case "6" : $_xml .= "plusieurs opération ";
								break;
					case "61" : $_xml .= "opération non pertinente sur toutes les données de l'énoncé ";
									$_xml .="<op>(".$tabSR[0].")</op>\r\n";
								break;
					case "62" : $_xml .= "opération non pertinente ";
									$_xml .="<op>(".$tabSR[0].")</op>\r\n";
								break;
					case "7" : $_xml .= "soustraction à trou ";
					          if($r["colonne3"]==0 and $r["colonne4"]==0) 
							  			$_xml .="<op>(".$tout1."- ? =".$partie1.")</op>\r\n"; 
							  else if($r["colonne3"]==0 and $r["colonne4"]==1 or $r["colonne4"]==2) 
							  		$_xml .="<op>(".$tout1."- ? =".$partie1.")</op>\r\n"; 
								break;
					case "9" : $_xml .= "absence";
								break;
				}
				$_xml .="</colonne2>\r\n"; 
			  
			   	$_xml .="<colonne4 sexe=\"".$sexe."\" intitule=\"résultat de calcul\" code=\"" . $r["colonne4"] . "\">\r\n"; 
				switch ($r["colonne4"])
				{  
					case "0" :  if($r["colonne2"]<4 and $r["colonne3"]==0)
								{
									$_xml .= "correct ";
									$_xml .="<res>(".$partie2.")</res>\r\n";
								}
								else if($r["colonne2"]==4 and $r["colonne3"]==0)
								{
									$operation=$partie1+$tout1;
									$_xml .= "correct ";
									$_xml .="<res>(".$operation.")</res>\r\n";
								}
								else if($r["colonne2"]==4 and $r["colonne3"]==1)
								{
									$_xml .= "correct ";
									$_xml .="<res>(".$tabR[0].")</res>\r\n";
								}
								else if($r["colonne2"]==0 and $r["colonne3"]==9)
								{
									$_xml .="<res>(".$partie2.")</res>\r\n";
								}
								else if($r["colonne2"]==61 or $r["colonne3"]==62)
								{
									$_xml .="<res>(".$tabR[0].")</res>\r\n";
								}
								else if($r["colonne2"]<4 and $r["colonne3"]==1)
								{
									$_xml .="<res>(".$tabR[0].")</res>\r\n";
								}
								else
								{
									$_xml .= "correct ";
								}
								break;
					case "1" : $_xml .= "erreur ";//petite erreur  de calcul
								if($r["colonne2"]!=0)
								$_xml .="<res>(".$tabR[0].")</res>\r\n";
								break;
					case "2" : $_xml .= "erreur ";//grosse erreur de calcul
								if($r["colonne2"]!=0)
								$_xml .="<res>(".$tabR[0].")</res>\r\n";
								break;
					case "9" : $_xml .= "résultat absent";
								break;
				}
				$_xml .="</colonne4>\r\n"; 
				
				$_xml .="<colonne3 sexe=\"".$sexe."\" intitule=\"pertinence des données de l'opération\" col1=\"".$r["colonne1"]."\" col2=\"".$r["colonne2"]."\" code=\"" . $r["colonne3"] . "\">\r\n"; 
				switch ($r["colonne3"])
				{ 
					case "0" : $_xml .= "correcte";
								break;
					case "1" : $_xml .= "incorectes (au moins une des données est incorrecte)";
								break;
					case "9" : $_xml .= "pas d'opération posée";
								break;
				}
				$_xml .="</colonne3>\r\n";
				 
			   	
		    }/****fin du if(!($r["colonne2"]='9' and $r["colonne3"]='9' and $r["colonne4"]='9'))****/
		
			if ($r["typeExo"]=="a") 
			{
				if (!($r["colonne6"]=='9' and $r["colonne7"]=='9' and $r["colonne8"]=='9'))
				{
			      $_xml .="<colonne6 sexe=\"".$sexe."\" intitule=\"calcul comparaison\" code=\"".$r["colonne6"]."\" col7=\"".$r["colonne7"]."\" nbOper=\"".$nbOper."\" col14=\"".$r["colonne14"]."\" str=\"".$r["colonne1"]."\">\r\n"; 
					switch ($r["colonne6"])
					{ 
					case "0" : $_xml .= "implicite";
									break;
					case "1" : $_xml .= "addition à trou ";
					          if(($r["colonne7"]==0) and ($r["question"]=="t")) 
							 	 $_xml .="<op>(".$valdiff."+ ? =".$partie1.")</op>\r\n"; 
							  else if(($r["colonne7"]==0) and ($r["question"]=="p")) 
							 	 $_xml .="<op>(".$valdiff."+ ? =".$tout1.")</op>\r\n"; 
							  break;
					case "2" : $_xml .= "soustraction ";
					         if(($r["colonne7"]==0) and ($r["question"]=="t")) 
							 	 $_xml .="<op>(".$partie1."-".$valdiff.")</op>\r\n"; 
							  else if(($r["colonne7"]==0) and ($r["question"]=="p")) 
							 	 $_xml .="<op>(".$tout1."-".$valdiff.")</op>\r\n"; 
							  else if(($r["colonne7"]==1) and ($r["colonne8"]=="0")) 
							 	 $_xml .="<op>(".$tabSR[1].")</op>\r\n"; 	 
								break;
					case "21" : $_xml .= "soustraction avec une erreur de signe ";
					         if(($r["colonne7"]==0) and ($r["question"]=="t")) 
							 	 $_xml .="<op>(".$partie1."+".$valdiff.")</op>\r\n"; 
							  else if(($r["colonne7"]==0) and ($r["question"]=="p")) 
							 	 $_xml .="<op>(".$tout1."+".$valdiff.")</op>\r\n"; 
							  else if(($r["colonne7"]==1) and ($r["colonne8"]=="0")) 
							 	 $_xml .="<op>(".$tabSR[1].")</op>\r\n"; 	 
								break;
					case "3" : $_xml .= "soustraction inversée ";
					           if(($r["colonne7"]==0) and ($r["question"]=="t")) 
							 	 $_xml .="<op>(".$valdiff."-".$partie1.")</op>\r\n"; 
							  else if(($r["colonne7"]==0) and ($r["question"]=="p")) 
							 	 $_xml .="<op>(".$valdiff."-".$tout1.")</op>\r\n"; 
								break;
					case "4" : $_xml .= "addition ";
					           if(($r["colonne7"]==0) and ($r["question"]=="t")) 
							 	 $_xml .="<op>(".$partie1."+".$valdiff.")</op>\r\n"; 
							  else if(($r["colonne7"]==0) and ($r["question"]=="p")) 
							 	 $_xml .="<op>(".$tout1."+".$valdiff.")</op>\r\n"; 
								break;
					case "5" : $_xml .= "autre opération";
								break;
					case "6" : $_xml .= "plusieurs opération";
								break;
					case "7" : $_xml .= "soustraction à trou ";
					          if($r["colonne7"]==0 and $r["question"]=="t") 
							 	 $_xml .="<op>(".$partie1."- ? =".$valdiff.")</op>\r\n"; 
							  else if($r["colonne7"]==0 and $r["question"]=="p") 
							 	 $_xml .="<op>(".$tout1."- ? =".$valdiff.")</op>\r\n"; 
								break;
					case "9" : $_xml .= "absence";
								break;
					}
				$_xml .="</colonne6>\r\n"; 
				 $_xml .="<colonne7 sexe=\"".$sexe."\" intitule=\"pertinence des données de l'opération\" code=\"" . $r["colonne7"] . "\">\r\n"; 
				switch ($r["colonne7"])
				{ 
					case "0" : $_xml .= "implicite";
								break;
					case "1" : $_xml .= "au moins une des données est incorrecte sans être le résultat d'une erreur de calcul";
								break;
					case "2" : $_xml .= "au moins une des données est incorrecte du fait d'une erreur de calcul";//petite
								break;
					case "3" : $_xml .= "au moins une des données est incorrecte du fait d'une erreur de calcul";//grosse
								break;
					case "9" : $_xml .= "pas d'opération posée";
								break;
				}
				$_xml .="</colonne7>\r\n"; 
				 $_xml .="<colonne8 sexe=\"".$sexe."\" intitule=\"résultat de calcul\" col14=\"".$r["colonne14"]."\" code=\"" . $r["colonne8"] . "\">\r\n"; 
					switch ($r["colonne8"])
					{  
						case "0" : $_xml .= "correct ";
									if($r["question"]=="t" and ($r["colonne7"]==0 || $r["colonne7"]==9) and ereg("[0-3]|7",$r["colonne6"])) 
							 	         $_xml .="<res>(".$partie3.")</res>\r\n";
							  		else if($r["question"]=="p" and ($r["colonne7"]==0 || $r["colonne7"]==9)  and ereg("[0-3]|7",$r["colonne6"]))  
										$_xml .="<res>(".$tout2.")</res>\r\n";
									else if(($r["colonne7"]==1) and ($r["colonne6"]=="2")) 
							 	 		 $_xml .="<res>(".$tabR[1].")</res>\r\n";	
									break;
						case "1" : $_xml .= "erreur";//petite erreur  de calcul
								break;
						case "2" : $_xml .= "erreur";//grosse erreur de calcul
								break;
						case "9" : $_xml .= "résultat absent";
									break;
					}
					$_xml .="</colonne8>\r\n"; 
				}//fin du if(!($r["colonne6"]='9' and $r["colonne7"]='9' and $r["colonne8"]='9')))
		    }//fin du if ($r["typeExo"]=="a") 
			else if ($r["typeExo"]=="e")
		    {
				if (!($r["colonne10"]=='9' and $r["colonne11"]=='9' and $r["colonne12"]=='9'))
				{
					$_xml .="<colonne10 sexe=\"".$sexe."\" intitule=\"calcule de la différence\" code=\"" . $r["colonne10"] . "\">\r\n"; 
					switch ($r["colonne10"])
					{ 
						case "0" : $_xml .= "implicite";
										break;
						case "1" : $_xml .= "addition à trou ";
								  if(($r["colonne11"]==0) and ($r["question"]=="t")) 
									 {
									   if($partie2 >= $partie1)				
									   		$_xml .="<op>(".$partie1."+ ? =".$partie2.")</op>\r\n"; 
									   else if($partie1 >= $partie2)
									   		$_xml .="<op>(".$partie2."+ ? =".$partie1.")</op>\r\n"; 
									 }
								 else if(($r["colonne11"]==0) and ($r["question"]=="p")) 
								   {
									   if ($tout2>=$tout1) 
											$_xml .="<op>(".$tout1."+ ? =".$tout2.")</op>\r\n";
									   else if ($tout1>=$tout2)
										 	$_xml .="<op>(".$tout2."+ ? =".$tout1.")</op>\r\n";
								    }
									break;
						case "2" : $_xml .= "soustraction ";
								 if(($r["colonne11"]==0) and ($r["question"]=="t")) 
									 {
									   if($partie2 >= $partie1)				
									   $_xml .="<op>(".$partie2."-".$partie1.")</op>\r\n"; 
									   else if($partie1 >= $partie2)
									   $_xml .="<op>(".$partie1."-".$partie2.")</op>\r\n";
									 }
								 else if(($r["colonne11"]==0) and ($r["question"]=="p")) 
								   {
									   if ($tout2>=$tout1) 
										$_xml .="<op>(".$tout2."-".$tout1.")</op>\r\n";
									   else if ($tout1>=$tout2)
										 $_xml .="<op>(".$tout1."-".$tout2.")</op>\r\n";
								    }
									break;
						case "9" : $_xml .= "absence";
									break;
					}
					$_xml .="</colonne10>\r\n"; 
					$_xml .="<colonne11 sexe=\"".$sexe."\" intitule=\"pertinence des données de l'opération\" code=\"" . $r["colonne11"] . "\">\r\n"; 
					switch ($r["colonne11"])
					{ 
						case "0" : $_xml .= "implicite";
									break;
						case "1" : $_xml .= "au moins une des données est incorrecte";
									break;
						case "9" : $_xml .= "pas d'opération posée";
									break;
					}
					$_xml .="</colonne11>\r\n"; 
					$_xml .="<colonne12 sexe=\"".$sexe."\" intitule=\"résultat\" code=\"" . $r["colonne12"] . "\">\r\n"; 
					switch ($r["colonne12"])
					{ 
						case "0" : $_xml .= "correcte ";
								   $_xml .="<res>(".$valdiff.")</res>\r\n";
								    break;
						case "1" : $_xml .= "erreur";
									break;
						case "2" : $_xml .= "erreur";
									break;
						case "9" : $_xml .= "résultat absent";
									break;
					}
					$_xml .="</colonne12>\r\n"; 
				}//fin du if(!($r["colonne10"]='9' and $r["colonne11"]='9' and $r["colonne12"]='9'))			
		    }//fin du  if ($r["typeExo"]=="e") 
			
			$_xml .="<colonne14 sexe=\"".$sexe."\" intitule=\"nature de ce qui est calculé\" nbOper=\"".$nbOper."\" str=\"".$r["colonne1"]."\" code=\"".$r["colonne14"]."\" q=\"".$q."\" col1=\"".$r["colonne1"]."\" col15=\"".$r["colonne15"]."\" col16=\"".$r["colonne16"]."\" type=\"".$r["typeExo"]."\">\r\n"; 
				switch ($r["colonne14"])
				{ 
					case "0" : $_xml .= "implicite";
								if($r["question"]=="p" and $r["colonne17"]==0)
									$_xml .="<res>".$partie3."</res>\r\n";
								else if($r["question"]=="t" and $r["colonne17"]==0)
									$_xml .="<res>".$tout2."</res>\r\n";
								else if($r["colonne14"]==0 and ($r["colonne17"]==9 || $r["colonne17"]==8))
									$_xml .="<res>".end($tabNombre)."</res>\r\n";
								break;
					case "1" : $_xml .= "une partie";
								break;
					case "2" : $_xml .= "un tout";
								break;
					case "3" : if($r["typeExo"]=="e" and $r["colonne11"]==0 and $r["colonne11"]==0)
								$_xml .= "Pour le calcul final, il a utilisé l'écart calculé précedement ($valdiff). ";
								else if($r["typeExo"]=="a")
								$_xml .= "";
								else
							    $_xml .= "un des terme de la comparaison à partir de l'autre terme de la différence";
								if ($r["colonne1"]=="3")
								{
									if($r["question"]=="p") {
											$_xml .="<partie1>".$partie1."</partie1>\r\n";
											$_xml .="<partie2>".$partie2."</partie2>\r\n";
											$_xml .="<tout1>".$tout1."</tout1>\r\n";
											$_xml .="<tout2>".$tout2."</tout2>\r\n";
											$_xml .="<valdiff>".$valdiff."</valdiff>\r\n";
										}
								   else if($r["question"]=="t") {
											$_xml .="<tout1>".$tout1."</tout1>\r\n";
											$_xml .="<tout2>".$tout2."</tout2>\r\n";
											$_xml .="<partie1>".$partie1."</partie1>\r\n";
											$_xml .="<partie2>".$partie2."</partie2>\r\n";
											$_xml .="<valdiff>".$valdiff."</valdiff>\r\n";										
										}
								}
								break;

					case "4" : $_xml .= "le résultat précédent et la dernière donnée de l'énoncé";
								break;
					case "41" : $_xml .= "addition des deux resultats précédent";
								break;
					case "42" : $_xml .= "soustraction des deux resultats précédent";
										break;
					case "43" : $_xml .= "soustraction de  deux données de l'énoncé";
										break;
					case "5" : $_xml .= "autre";
								break;
					case "9" : $_xml .= "absence";

								break;
				}
			$_xml .="</colonne14>\r\n"; 

			$_xml .="<colonne15 sexe=\"".$sexe."\" intitule=\"calcule du résultat final\" col14=\"".$r["colonne14"]."\" code=\"" . $r["colonne15"] . "\">\r\n"; 
				switch ($r["colonne15"])
				{ 
					case "0" : $_xml .= "implicite";
								break;
					case "1" : $_xml .= "addition à trou ";
							   $_xml .="<op>(".$tabOper[0]." + ? =".$tabOper[2].")</op>\r\n";
							   $resFin=$tabOper[1];
								break;
					case "2" : $_xml .= "soustraction ";
								$_xml .="<op>(".chop($opFinSR).")</op>\r\n";
								break;
					case "3" : $_xml .= "soustraction inversée ";
								$_xml .="<op>(".chop($opFinSR).")</op>\r\n";
								break;
					case "4" : $_xml .= "addition ";
								$_xml .="<op>(".chop($opFinSR).")</op>\r\n";
								break;
					case "5" : $_xml .= "addition de tous les termes de l'énoncé ";
								$_xml .="<op>(".chop($opFinSR).")</op>\r\n";
								break;
					case "6" : $_xml .= "autre opération sur tous les termes de l'énoncé";
								break;
					case "7" : $_xml .= "opération non pertinente sur 2 des termes de l'énoncé";
								$_xml .="<op>(".chop($opFinSR).")</op>\r\n";
								break;
					case "71" : $_xml .= "soustraction à trou";
								$_xml .="<op>(".$tabOper[0]." - ? =".$tabOper[2].")</op>\r\n";
							   $resFin=$tabOper[1];
								break;
					case "72" : $_xml .= "soustraction inverser ";
								$_xml .="<op>(".$opFinSR.")</op>\r\n";
								break;
					case "8" : $_xml .= "autre ";
								$_xml .="<op>(".chop($opFinSR).")</op>\r\n";
								break;
					case "9" : $_xml .= "absence ";
								break;
				}
			$_xml .="</colonne15>\r\n"; 
			
			$_xml .="<colonne17 sexe=\"".$sexe."\" intitule=\"résultat du calcul final\" nbOper=\"".$nbOper."\" sol=\"".$sol."\" 
					   str=\"".$r["colonne1"]."\" col14=\"".$r["colonne14"]."\" col15=\"".$r["colonne15"]."\" code=\"".$r["colonne17"]."\">\r\n"; 
				switch ($r["colonne17"])
				{  
					case "0" :  $_xml .= "correct";
							    $_xml .= "<res>(".$resFin.")</res>";
								break;
					case "1" :  $_xml .= "erreur";
							    $_xml .= "<res>(".$resFin.")</res>";
								break;
					case "2" : $_xml .= "erreur";
							    $_xml .= "<res>(".$resFin.")</res>";
					case "8" : $_xml .= "erreur";
							    $_xml .= "<res>(".$resFin.")</res>";
								break;
					case "9" : $_xml .= "résultat absent";
								$_xml .= "<res>(".$resFin.")</res>";
								break;
				}
				$_xml .="</colonne17>\r\n";
				
			$_xml .="<colonne16 sexe=\"".$sexe."\" intitule=\"pertinence des données de l'opération\" code=\"".$r["colonne16"]."\" col14=\"".$r["colonne14"]."\" nbOper=\"".$nbOper."\" str=\"".$r["colonne1"]."\">\r\n"; 
				switch ($r["colonne16"])
				{ 
					case "0" : $_xml .= "correctes";
								break;
					//case "1" : $_xml .= "Au moins une des données est incorrecte sans être le résultat d'une erreur de calcul";
					case "1" : $_xml .= "L'échec à cette dernière opération repose sur un choix incorrect des valeurs";
								break;
					case "2" : $_xml .= "Au moins une des données est incorrecte du fait d'une erreur de calcul au cours du calcul précédent";
								break;
					case "3" : $_xml .= "Au moins une des données est incorrecte du fait d'une erreur de calcul au cours du calcul précédent";
								break;
					case "4" : if($nbOper==1 and $r["typeExo"]=="a")
								$_xml .= "Le choix des données est correct pour une autre comparaison mais pas pour répondre à la question";
								else 
								$_xml .= "Le choix des données est correct pour la comparaison mais pas pour répondre à la question";

								break;
					case "5" : $_xml .= "L’erreur au calcul final est due à l’erreur commise au calcul précédent";
								break;
					case "8" : $_xml .= "erreur";
								break;
					case "9" : $_xml .= "pas d'opération posée";
								break;
				}
			$_xml .="</colonne16>\r\n"; 
		
			$_xml .="<commentaire sol=\"".$sol."\" sexe=\"".$sexe."\" type=\"".$r["typeExo"]."\" q=\"".$q."\" qi=\"".$r["questInt"]."\" 
			col2=\"".$r["colonne2"]."\" col3=\"".$r["colonne3"]."\" col4=\"".$r["colonne4"]."\"
			col6=\"".$r["colonne6"]."\" col7=\"".$r["colonne7"]."\" col8=\"".$r["colonne8"]."\"
			col10=\"".$r["colonne10"]."\" col11=\"".$r["colonne11"]."\" col12=\"".$r["colonne12"]."\"
			col14=\"".$r["colonne14"]."\" col15=\"".$r["colonne15"]."\" col16=\"".$r["colonne16"]."\" col17=\"".$r["colonne17"]."\" nbOper=\"".$nbOper."\" str=\"".$r["colonne1"]."\">\r\n"; 
			
			if($r["colonne6"]==20)
			{
				if ($q=="p")
				{
					$cal_diff=$partie1."-".$valdiff;
				}
				else if ($q=="t")
				{
					$cal_diff=$tout1."-".$valdiff;
				}
				
				$key=array_search($tabSR,$cal_diff);
				if(isset($key)) 
				{
				$cal_diff=$cal_diff."=".$tabR[$key];
				$_xml .= "<op>(".$cal_diff.")</op>";
				}
			}
			$_xml .="</commentaire>\r\n"; 

?>
