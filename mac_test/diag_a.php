<?php
 session_start();
 //$_SESSION["numExo"]++;
   $nbExo=$_POST['nbExo']; 
   $nbExo--;
 
 $numExo=$_POST["numExo"];
 $numExo++;
 $questi = $_SESSION['questi'];
 $n = (int) $_SESSION['num'];
 $t = $_SESSION['type'];
 $text = $_POST['zonetexte'];
 $sas = addslashes($_POST['T1']);
 //$choix = $_POST['R1'];
 $oper1 = trim($_POST['oper1']); $oper_1=$oper1;
 $oper2 = trim($_POST['oper2']); $oper_2=$oper2;
 $op1 = $_POST['operande1']; $op_1 = $op1;
 //$op2 = $_POST['operande2']; $op_2 = $op2;
 //$op3 = $_POST['operande3']; $op_3 = $op3;
 $resultat =$_POST['resultat1'];
 $numSerie = $_SESSION["numSerie"];
 $aujourdhui = getdate(); $mois = $aujourdhui['mon']; $jour = $aujourdhui['mday']; $annee = $aujourdhui['year'];
 $heur = $aujourdhui['hours']; $minute = $aujourdhui['minutes']; $seconde = $aujourdhui['seconds'];
 $date = $annee.":".$mois.":".$jour." ".$heur.":".$minute.":".$seconde;
 
 if( (isset($_GET['Trace'])))  {
$trace=$_GET['Trace'];
/*$BD_host  = "localhost";
$BD_port  = "";
$BD_login = "root"; // identifiant
$BD_pass  = ""; // mot de passe
$BD_base  = "dewplayer";
$BD_link = mysql_connect("${'BD_host'}${'BD_port'}", $BD_login, $BD_pass) or die("Connexion de la base impossible : ". mysql_error());
$db=mysql_select_db($BD_base, $BD_link) or die("S&eacute;lection de la base impossible : ". mysql_error());
//echo($db);
//$req="INSERT INTO trace_parcours` (`id`, `numEleve`, `numExo`, `Trace`) VALUES (NULL, \'4\', \'4\', \'dadada\');";
//$numEleve=$_SESSION['numEleve'];
$req="INSERT INTO dewplayer.trace_parcours (id,numEleve,numExo,Trace) VALUES (NULL, 5, 5, '$trace')";
$ok=mysql_query($req);
echo("aaaaaaaaaaaaaaaaa");
mysql_close($BD_link);*/
}
 
 
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

 if (!isset($text)||$text=='')
 {
	 print ("vous n'avez rien saisie");
	 print(" colonne1 = 9 "); $colonne1=9;
	 //exit() ;
 }
 //initialisation des variable
 //supprime les traits d'union
	$text = ereg_replace ('([a-zA-Z]) *- *([a-zA-Z])','\1 \2',$text);

 //suprime tous caractere different de [^\d+-=:*]
 $calcules = trim(eregi_replace ('[^0-9|,|+|*|=|-]', " ",$text));//supprimer la division :
//print($calcules);
 $tabCal =  preg_split ("/[\s]+/", $calcules);
/*  for ($i=0; $i < count($tabCal) ; $i++)
	{
	switch ($tabCal[$i])
		{
		case "+" : if (($tabCal[$i+2]=="=") and (($tabCal[$i-2]=="") || (ereg("[^-\+]",$tabCal[$i-2]))))
					 {
						 $tabOperation[]=$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
					 }
				   else if (($tabCal[$i+2]=="=")and(($tabCal[$i-2]=="+")||($tabCal[$i-2]=="-"))and(($tabCal[$i-4]=="+")||($tabCal[$i-4]=="-"))and(($tabCal[$i-6]=="+")||($tabCal[$i-6]=="-")))
						 {
							 $tabOperation[] =$tabCal[$i-7].$tabCal[$i-6].$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
							 $tabOperation2[]=$tabCal[$i-7].$tabCal[$i-6].$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
						 }
				   else if (($tabCal[$i+2]=="=")and(($tabCal[$i-2]=="+")||($tabCal[$i-2]=="-"))and(($tabCal[$i-4]=="+")||($tabCal[$i-4]=="-")))
						 {
							 $tabOperation[] =$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
							 $tabOperation2[]=$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
						 }
				   else if (($tabCal[$i+2]=="=")and(($tabCal[$i-2]=="+")||($tabCal[$i-2]=="-")))
						 {
							 $tabOperation[] =$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
							 $tabOperation2[]=$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
						 }
				   else if (ereg("[0-9]",$tabCal[$i+2])|| $tabCal[$i+2]=="")
								$tabOperation[] =$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1];
				 break;
		case "-" :if (($tabCal[$i+2]=="=") && ((ereg("[^\+\-]",$tabCal[$i-2]))||($tabCal[$i-2]=="")))
					 {
						 $tabOperation[] = $tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
					 }
				    else if (($tabCal[$i+2]=="=")and(($tabCal[$i-2]=="+")||($tabCal[$i-2]=="-"))and(($tabCal[$i-4]=="+")||($tabCal[$i-4]=="-"))and(($tabCal[$i-6]=="+")||($tabCal[$i-6]=="-")))
						 {
							 $tabOperation[] =$tabCal[$i-7].$tabCal[$i-6].$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
							 $tabOperation2[]=$tabCal[$i-7].$tabCal[$i-6].$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
						 }
				   else if (($tabCal[$i+2]=="=")and(($tabCal[$i-2]=="+")||($tabCal[$i-2]=="-"))and(($tabCal[$i-4]=="+")||($tabCal[$i-4]=="-")))
						 {
							 $tabOperation[] =$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
							 $tabOperation2[]=$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
						 }
				   else if (($tabCal[$i+2]=="=")and(($tabCal[$i-2]=="+")||($tabCal[$i-2]=="-")))
						 {
							 $tabOperation[] =$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
							 $tabOperation2[]=$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
						 }
				   else if (ereg("[0-9]",$tabCal[$i+2])|| $tabCal[$i+2]=="")
								$tabOperation[] =$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1];
					 break;
		case "*" :if (($tabCal[$i+2]=="=") && ((ereg("[^\*\:]",$tabCal[$i-2]))||($tabCal[$i-2]=="")))
					 {
						 $tabOperation[] = $tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
					 }
				    else if (($tabCal[$i+2]=="=")and(($tabCal[$i-2]=="*")||($tabCal[$i-2]==":"))and(($tabCal[$i-4]=="*")||($tabCal[$i-4]==":"))and(($tabCal[$i-6]=="*")||($tabCal[$i-6]==":")))
						 {
							 $tabOperation[] =$tabCal[$i-7].$tabCal[$i-6].$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
							 $tabOperation2[]=$tabCal[$i-7].$tabCal[$i-6].$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
						 }
				   else if (($tabCal[$i+2]=="=")and(($tabCal[$i-2]=="*")||($tabCal[$i-2]==":"))and(($tabCal[$i-4]=="*")||($tabCal[$i-4]==":")))
						 {
							 $tabOperation[] =$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
							 $tabOperation2[]=$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
						 }
				   else if (($tabCal[$i+2]=="=")and(($tabCal[$i-2]=="*")||($tabCal[$i-2]==":")))
						 {
							 $tabOperation[] =$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
							 $tabOperation2[]=$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
						 }
				   else if (ereg("[0-9]",$tabCal[$i+2])|| $tabCal[$i+2]=="")
								$tabOperation[] =$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1];
				   break;

		case ":" : if (($tabCal[$i+2]=="=") && ((ereg("[^\*\:]",$tabCal[$i-2]))||($tabCal[$i-2]=="")))
					 {
						 $tabOperation[] = $tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
					 }
				   else if (($tabCal[$i+2]=="=")and(($tabCal[$i-2]=="*")||($tabCal[$i-2]==":"))and(($tabCal[$i-4]=="*")||($tabCal[$i-4]==":"))and(($tabCal[$i-6]=="*")||($tabCal[$i-6]==":")))
						 {
							 $tabOperation[] =$tabCal[$i-7].$tabCal[$i-6].$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
							 $tabOperation2[]=$tabCal[$i-7].$tabCal[$i-6].$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
						 }
				   else if (($tabCal[$i+2]=="=")and(($tabCal[$i-2]=="*")||($tabCal[$i-2]==":"))and(($tabCal[$i-4]=="*")||($tabCal[$i-4]==":")))
						 {
							 $tabOperation[] =$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
							 $tabOperation2[]=$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
						 }
				   else if (($tabCal[$i+2]=="=")and(($tabCal[$i-2]=="*")||($tabCal[$i-2]==":")))
						 {
							 $tabOperation[] =$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
							 $tabOperation2[]=$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
						 }
				   else if (ereg("[0-9]",$tabCal[$i+2])|| $tabCal[$i+2]=="")
								$tabOperation[] =$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1];
					 break;
		}
} */
		 $reponse = $text;
		 $reponse = ereg_replace ('([a-zA-Z]) *- *([a-zA-Z])','\1 \2',$reponse);
		//suprime tous caractere different de [^\d+-=:*]
		$reponse = trim(eregi_replace ('[^0-9|,|+|*|=|-]', " ",$reponse));// (supprimer la division :)
				   
		$pattern = "/(((?:\d+\s*[\+\-\*\/x]\s*)+\d+\s*)=?\s*(\d*))/"; //(?:) parenthèse non capturante (supprimer la division :)
		preg_match_all($pattern,$reponse,$tab);
		
		//tableau des opération utilisées dans la réponse de l'apprenant ==> tabOperation
		$tabOperation = $tab[0];
		$tabOperation2 = $tabOperation;
		$tabSR = $tab[2];
		$tabR = $tab[3];



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
print ("les nombres que le texte contient sont");*/
$nombre=array();
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
	print($nombre[$i]." ");*/
$tabNombre = $nombre;
//====================================================
 require_once("conn.php");
 
 //======================================
//trouver les nombres écrit en lettre
if(count($nombre)==0)
{
	$Requete_SQL0 = "SELECT * FROM nombre";
 	$result = mysql_query($Requete_SQL0) or die("Erreur de S&eacute;lection dans la base : ". $Requete_SQL0 .'<br />'. mysql_error());
	while($valNb=mysql_fetch_array($result))
	{
		$tab_nb[]=$valNb["nombre"];		
		$tab_nb_lettre[]=$valNb["nombre_lettre"];
		if($valNb["erreur1"]!='')
			$tab_nb_err1[]=$valNb["erreur1"];
		if($valNb["erreur2"]!='')
			$tab_nb_err2[]=$valNb["erreur2"];
		$tab_nb_err3[]=$valNb["erreur3"];
	}
	
	//cas 1 : nombre ecrit correctement
		$pat_nb_lettre = implode (' ?| ?',$tab_nb_lettre);
		$pattern1 = "/".$pat_nb_lettre."/"; 
		preg_match_all($pattern1,$text,$tab_nb_ext);
		//print_r($tab_nb_ext[0]);
		$tab_nb_ext=$tab_nb_ext[0];
	//cas 2 : nombre ecrit avec des erreurs erreur1
		$pat_nb_err1= implode (' ?| ?',$tab_nb_err1);
		$pattern2 = "/".$pat_nb_err1."/"; 
		preg_match_all($pattern2,$text,$tab_nb_ext1);
		//print_r($tab_nb_ext1[0]);
		$tab_nb_ext1=$tab_nb_ext1[0];
	//cas 3 : nombre ecrit avec des erreurs erreur3
		$pat_nb_err2= implode (' ?| ?',$tab_nb_err2);
		$pattern3 = "/".$pat_nb_err2."/"; 
		print_r($tab_nb_ext2[0]);
		preg_match_all($pattern3,$text,$tab_nb_ext2);
		//print_r($tab_nb_ext2[0]);
		$tab_nb_ext2=$tab_nb_ext2[0];
		
	if(count($tab_nb_ext)>0)
		{
			for($i=0;$i<count($tab_nb_ext);$i++)
			{
				for($j=0;$j<=100;$j++)	
				{
					if(trim($tab_nb_lettre[$j])==trim($tab_nb_ext[$i]))
					{
						$nombre[]=$j;
						//echo($tab_nb_lettre[$j]."==".$tab_nb_ext[$i]);
						break;
					}
					
				}		
			}
		}
	if(count($tab_nb_ext1)>0)
		{
			for($i=0;$i<count($tab_nb_ext1);$i++)
			{
				for($j=0;$j<=100;$j++)	
				{
					if(trim($tab_nb_err1[$j])==trim($tab_nb_ext1[$i]))
					{
						$nombre[]=$j;
						//echo($tab_nb_err1[$j]."==".$tab_nb_ext1[$i]);
						break;
					}
					
				}		
			}
		}
	if(count($tab_nb_ext2)>0)
		{
			for($i=0;$i<count($tab_nb_ext2);$i++)
			{
				for($j=0;$j<=100;$j++)	
				{
					if(trim($tab_nb_err2[$j])==trim($tab_nb_ext2[$i]))
					{
						$nombre[]=$j;
						//echo($tab_nb_err2[$j]."==".$tab_nb_ext2[$i]);
						break;
					}
					
				}		
			}
		}
	if(isset($nombre))  $nombre=array_unique($nombre);
	$tabNombre=$nombre;
	if(count($tab_nb_ext)==0 and count($tab_nb_ext1)==0 and count($tab_nb_ext2)==0)
	{
		for($i=1;$i<=18;$i++)
		{
			${'colonne'.$i}=9;
		}
		unset($tabNombre,$nombre);
	}
	

}
//fin de la recherche des nombre ecris en lettre
//==============================================

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
$chaineOp = implode (' ',$tabOperation);
$chaineOper = trim(eregi_replace ('[^0-9|,]', " ",$chaineOp));
$tabOperande= array_values(preg_split ("/[\s]+/", $chaineOper));
//print ("le tableau des operations :  ");print_r($tabOperation);print ("<br>");
//print ("le tableau d'operande :  ");print_r($tabOperande);print ("<br>");
//print ("le tableau des nombres :  ");print_r($nombre);print ("<br>");
//$nombre_bis=$nombre;
//$tabDiff = array_diff($nombre,$tabOperande);print_r($tabDiff);//montre si il y a des valeurs qui sont dans le tableau 1 et pas au 2 ou vis versa
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
$tabImp=array();
for ($i=0 ; $i < count($nombre) ;$i++)
		if ($nombre[$i]!='')
		  $tabImp[] = $nombre[$i];

//print ("le tableau tabImp \"Implicite\"");
//if (isset($tabImp))
//print_r($tabImp);

for ($i=0; $i<count($tabOperation);$i++)
{
	${'tab'.$i}=$tabOperation[$i];
	${'chaineOper'.$i} = trim(eregi_replace ('[^0-9|,]', " ",${'tab'.$i}));
	${'tabOperande'.$i}= array_values(preg_split ("/[\s]+/", ${'chaineOper'.$i}));
   //	print_r(${'tabOperande'.$i});print("<BR>");
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
		//Recherche les opérations utlisées dans le texte
 		$pattern = "/(((?:\d+\s*[\+\-\*\/x:]\s*)+\d+\s*)=?\s*(\d+))/"; //(?:) parenthèse non capturante 
		preg_match_all($pattern,$calcules,$tableau);
		//tableau des opération utilisées dans la réponse de l'apprenant ==> tabOperation
		$tabOperation3 = $tableau[0];
		$tabSR = $tableau[2];
		$tabR = $tableau[3];
		//echo("<br>les oprétions utilisées sont :");print_r($tabOperation);

/*======ajouter le signe egale a l'operation s'il n'existe pas=======*/

for ($i=0,$k=0; $i < count($tabOperation);$i++)
{
	if(!strstr($tabOperation[$i],'='))
	{
	$tabOperation[$i]=$tabOperation[$i]."=".$tabImp[$k];
	}
	$k++;
}
//print ("le tableau des operations si le signe egale est absent :  ");print_r($tabOperation);print ("<br>");

/*-------fin difference entre les deux tableaux-----------*/
//$bool=false;
/* verifier si l'operation est implicite ou pas */


if (isset($tabImp))
{
	if ((count($tabOperation)==0) and (count($tabImp)==1))
	{
		if ($tabImp[0]==$partie2 )
		 {
		  $colonne2=0;$colonne3=9;$colonne4=0;
		  $etape1=true;$etape=true;  $imp1=true;
		 }
		else if ((($question=='t') and ($tabImp[0]==$partie3))||(($question=='p') and ($tabImp[0]==$tout2)))
		 {
		  $colonne6=0;$colonne7=9;$colonne8=0;
		  $etape2=true;  $etape_2=true; $imp2=true;
		 }
	   else if ((($question=='t') and ($tabImp[0]==$tout2))||(($question=='p') and ($tabImp[0]==$partie3)))
		 {
		  $colonne14=0; $colonne15=0; $colonne16=9; $colonne17=0 ;
		  $etape3=true; $imp3=true;
		 }
	   else
	   {
	   $colonne1=6;$colonne14=0; $colonne15=0; $colonne16=9; $colonne17=8;
	   }
	}
	else if((count($tabOperation)==0) and (count($tabImp)==2))
	{

		if ((($question=='t') and ($tabImp[0]==$partie2) and ($tabImp[1]==$partie3))||
			(($question=='p') and ($tabImp[0]==$partie2) and ($tabImp[1]==$tout2)))
		{
		$colonne2=0;$colonne3=9;$colonne4=0;$colonne6=0;$colonne7=9;$colonne8=0;
		$etape1=true; $etape=true;$imp1=true;$etape2=true;$etape_2=true; $imp2=true;
		}
		else if ((($question=='t') and ($tabImp[0]==$partie3) and ($tabImp[1]==$partie2))||
			(($question=='p') and ($tabImp[0]==$tout2)and($tabImp[1]==$partie2)  ))
		{
		$colonne2=0;$colonne3=9;$colonne4=0;$colonne6=0;$colonne7=9;$colonne8=0;
		$etape1=true; $etape=true;$imp1=true;$etape2=true;$etape_2=true; $imp2=true;
		}
		else if ((($question=='t') and ($tabImp[0]==$partie2) and ($tabImp[1]==$tout2))||
			(($question=='p') and ($tabImp[0]==$partie2)and ($tabImp[1]==$partie3)))
		{
		$colonne6=0;$colonne7=9;$colonne8=8;
		$colonne2=0;$colonne3=9;$colonne4=0;$colonne14=0; $colonne15=0; $colonne16=9; $colonne17=0 ;
		$etape1=true; $etape=true; $imp1=true;$etape3=true; $imp3=true;
		}
		else if ((($question=='t') and ($tabImp[0]==$partie3) and ($tabImp[1]==$tout2))||
			(($question=='p') and ($tabImp[0]==$tout2)and ($tabImp[1]==$partie3)))
		{
		$colonne2=0;$colonne3=9;$colonne4=8;
		$colonne6=0;$colonne7=9;$colonne8=0;$colonne14=0; $colonne15=0; $colonne16=9; $colonne17=0 ;
		$etape2=true;$etape_2=true; $imp2=true;$etape3=true; $imp3=true;
		}
		else if ((($question=='t') and ($tabImp[0]==$partie3) and ($tabImp[1]!=$tout2))||
			(($question=='p') and ($tabImp[0]==$tout2)and ($tabImp[1]!=$partie3)))
		{
		$colonne6=0;$colonne7=9;$colonne8=0;$colonne14=0; $colonne15=0; $colonne16=9; $colonne17=9 ;
		$etape2=true;$etape_2=true; $imp2=true;$etape3=true; $imp3=true;
		}
		else if ((($question=='t') and ($tabImp[0]==$partie2) and ($tabImp[1]!=$tout2))||
			(($question=='p') and ($tabImp[0]==$partie2)and ($tabImp[1]!=$partie3)))
		{
		$colonne2=0;$colonne3=9;$colonne4=0;$colonne14=0; $colonne15=0; $colonne16=9; $colonne17=9 ;
		$etape1=true; $etape=true; $imp1=true;$etape3=true; $imp3=true;
		}
	}
	else if((count($tabOperation)==0) and (count($tabImp)==3))
	{
		if ((($question=='t') and ($tabImp[0]==$partie2) and ($tabImp[1]==$partie3)and($tabImp[2]==$tout2))||
			(($question=='p') and ($tabImp[0]==$partie2)and($tabImp[1]==$tout2)and ($tabImp[2]==$partie3))||
			(($question=='t') and ($tabImp[1]==$partie2) and ($tabImp[0]==$partie3)and($tabImp[2]==$tout2))||
			(($question=='p') and ($tabImp[1]==$partie2)and($tabImp[0]==$tout2)and ($tabImp[2]==$partie3)))
		{
		$colonne2=0;$colonne3=9;$colonne4=0;$colonne6=0;$colonne7=9;$colonne8=0;$colonne14=0; $colonne15=0; $colonne16=9; $colonne17=0 ;
		$etape1=true;$etape=true; $imp1=true;$etape2=true;$etape_2=true; $imp2=true;$etape3=true; $imp3=true;
		}
		else if ((($question=='t') and ($tabImp[0]==$partie2) and ($tabImp[1]==$partie3)and($tabImp[2]!=$tout2))||
			(($question=='p') and ($tabImp[0]==$partie2)and($tabImp[1]==$tout2)and ($tabImp[2]!=$partie3))||
			(($question=='t') and ($tabImp[1]==$partie2) and ($tabImp[0]==$partie3)and($tabImp[2]!=$tout2))||
			(($question=='p') and ($tabImp[1]==$partie2)and($tabImp[0]==$tout2)and ($tabImp[2]!=$partie3)))
		{
		$colonne2=0;$colonne3=9;$colonne4=0;$colonne6=0;$colonne7=9;$colonne8=0;$colonne14=0; $colonne15=0; $colonne16=9; $colonne17=9;
		$etape1=true;$etape=true; $imp1=true;$etape2=true;$etape_2=true; $imp2=true;$etape3=true; $imp3=true;
		}

	}
	else if ((count($tabOperation)==1)and(count($tabImp)==2))
	{
		$operation_f = $tabOperation[0];
		$oper = trim(eregi_replace ('[^-|+|*|:]', " ",$operation_f));
		$T1 =  array_values(preg_split ("/[\s]+/", $oper));
		$operande = trim(eregi_replace ('[^0-9|,]', " ",$operation_f));
		$T2 = array_values(preg_split ("/[\s]+/", $operande));
		$op1 = $T2[0]; $op2 = $T2[1]; $res = $T2[2]; $op = $T1[0];

		if (($question=='t') and(($op1.$op.$op2."=".$res == $partie2."+".$partie3."=".$res)||($op1.$op.$op2."=".$res == $partie3."+".$partie2."=".$res))and
		   (in_array($partie2,$tabImp))and(in_array($partie3,$tabImp)))
		{
			$colonne2=0;$colonne3=9;$colonne4=0;$colonne6=0;$colonne7=9;$colonne8=0;$colonne14=2; $colonne15=4; $colonne16=0;
			$resultatf=$res ; $etape1=true;$etape=true; $imp1=true;$etape2=true; $etape_2=true;$imp2=true;$etape3=true;
		}
		else if (($question=='p') and($op1.$op.$op2."=".$res == $tout2."-".$partie2."=".$res)and (in_array($tout2,$tabImp))and(in_array($partie2,$tabImp)))
		{
			$colonne2=0;$colonne3=9;$colonne4=0;$colonne6=0;$colonne7=9;$colonne8=0;$colonne14=1; $colonne15=2; $colonne16=0;
			$resultatf=$res ; $etape1=true; $etape=true;$imp1=true;$etape2=true; $etape_2=true;$imp2=true;$etape3=true;
		}
		else if (($question=='t'||$question=='p') and($op1.$op.$op2."=".$res == $tout1."-".$partie1."=".$res)and
		   (in_array($partie3,$tabImp))and(in_array($tout2,$tabImp)))
		{
			$colonne2=2;$colonne3=0;$colonne4=0;$colonne6=0;$colonne7=9;$colonne8=0;$colonne14=0; $colonne15=0; $colonne16=9; $colonne17=0;
			$etape1=true; $etape=true;$imp2=true;$etape2=true;$etape_2=true; $imp3=true;$etape3=true;
		}
		else if ((($question=='p')and($op1.$op.$op2."=".$res == $tout1."-".$valdiff."=".$res)and (in_array($partie2,$tabImp))and(in_array($partie3,$tabImp)))
				||(($question=='t') and($op1.$op.$op2."=".$res == $partie1."-".$valdiff."=".$res)and (in_array($partie2,$tabImp))and(in_array($tout2,$tabImp))))
		{
			$colonne2=0;$colonne3=9;$colonne4=0;$colonne6=2;$colonne7=0;$colonne14=0; $colonne15=0; $colonne16=9; $colonne17=0;
			$etape1=true; $etape=true;$imp1=true;$etape2=true;$etape_2=true; $imp3=true;$etape3=true;
		}
	}
	else if ((count($tabOperation)>=1)and(count($tabImp)>=1))
	{
		if($tabImp[0]==$partie2)
		{
			$colonne2=0;$colonne3=9;$colonne4=0;
			$resultat=$tabImp[0] ; $etape1=true;$etape=true; $imp1=true;
		}
		else if((($question=='t')and(end($tabImp)==$tout2))||(($question=='p')and(end($tabImp)==$partie3)))
		{
			$colonne14=0;$colonne15=0;$colonne16=9;$colonne17=0;
			$resultatf=end($tabImp) ; $etape3=true; $imp3=true;
		}
		else if(((($question=='t')and(end($tabImp)!=$tout2))||(($question=='p')and(end($tabImp)!=$partie3)))and(end($tabImp)==end($tabNombre)))
		{
			$colonne14=0;$colonne15=0;$colonne16=9;$colonne17=9;
			$etape3=true; $imp3=true;
			$resultatf=end($tabImp) ;
		}
		else if($tabImp[0]!=$partie2)
		{
			$colonne2=0;$colonne3=9;$colonne4=9;
			$resultat=$tabImp[0] ; $etape1=true;$etape=true; $imp1=true;
		}
	}
}/* fin (isset($tabImp)) de la verification */
	
	/*________________   Debut de la boucle   _________________*/
		//initialisation
		$verrou1=false;
		$verrou2=false;
	if (count($tabOperation)==1)
		$bool=true;
	else $bool=false;

for ($k=0; (($k<=count($tabOperation)-1)||($bool)); $k++)
{
	//print(end($tabOperation));print($tabOperation[$k]."<br>");
	//print("le nombre d'operarion saisie est : ".count($tabOperation)."<br>");
	$etape1=false; $etape2=false;  $difference=false; $bool=false;
	$operation1 = $tabOperation[$k];
	//suprime tous caractere different de [^+-:*] , les resultats dans un tableau T1
	 $oper = trim(eregi_replace ('[^-|+|*|:]', " ",$operation1));
	 $T1 =  array_values(preg_split ("/[\s]+/", $oper));
	//suprime tous caractere different des operandes , les resultats dans un tableau T2
	$operande = trim(eregi_replace ('[^0-9|,]', " ",$operation1));
	$T2 = array_values(preg_split ("/[\s]+/", $operande));
	/*print("le tableau T2 contient :  ");print_r($T2);print ("<br>");
	print("le tableau T2 contient ". count($T2). "elements");print ("<br>");
	print("le tableau T1 contient :  ");print_r($T1);print ("<br>");
	print("le tableau T1 contient ". count($T1). "elements");print ("<br>");*/
	//=========il n' y a qu'une operation=============
	if (count ($T1) == 1 )
		 {
			   $op1 = $T2[0]; $op2 = $T2[1]; $res = $T2[2];
			   $op = $T1[0];
	/*========== cas de calcul par différence pour les problèmes de comparaison ===============*/
	//=================  colonne14 & 15 & 16  =============
			
			if (($question == 't') and (end($tabOperation)==$tabOperation[$k]))
			{
				 if (($op1.$op.$op2."=".$res) == ($valdiff."+".$op2."=".$tout1))
				   {//addition a trou
					 $colonne14=3; $colonne15=1;$colonne16=0;
					 $operande1 = $op1; $operande2 = $res; $resultatf = $op2;
					 $resultat_comp = calcul($operande2,"-",$operande1);
					 $difference = true ;$diff=true;
				   }
				 else if (($op1.$op.$op2."=".$res) == ($tout1."-".$valdiff."=".$res))
					{
					 $colonne14=3; $colonne15 = 2; $colonne16=0;
					 $operande1 = $op1; $operande2 = $op2; $resultatf = $res;
					 $resultat_comp = calcul($operande1,$op,$operande2);
					 $difference = true ; $diff=true;
					}
			}
			else if (($question == 'p') and (end($tabOperation)==$tabOperation[$k]))
			{
				 if (($op1.$op.$op2."=".$res) == ($valdiff."+".$op2."=".$partie1))
				   {//addition a trou
					 $colonne14=3; $colonne15=1; $colonne16=0;
					 $operande1=$op1; $operande2=$res; $resultatf=$op2;
					 $resultat_comp = calcul($operande2,"-",$operande1);
					 $difference = true ;$diff=true;
				   }
				  else if (($op1.$op.$op2."=".$res) == ($partie1."-".$valdiff."=".$res))
					{
					 $colonne14=3; $colonne15=2; $colonne16=0;
					 $operande1=$op1; $operande2=$op2; $resultatf=$res;
					 $resultat_comp=calcul($operande1,$op,$operande2);
					 $difference = true ; $diff=true;
					}
			 }
			  
	//================= colonne 17 cas difference =============
		 if ($difference)
		   {
			   if ($resultatf == $resultat_comp)
				{
					$colonne17=0;
				}
			   else if (($resultatf == $resultat_comp-1)||($resultatf == $resultat_comp+1))
				{
					$colonne17=1;
				}
			   else if (($resultatf < $resultat_comp-1) ||($resultatf > $resultat_comp-1))
				{
					$colonne17=2;
				}
		  }
		
  	 
	/*============== strategie par etape ====================== */
	//================= colonne2 =============
	  //$colonne2='';
	  if ($difference != true)
			{

			   if (($op1.$op.$op2."=".$res) == ($partie1."+".$op2."=".$tout1))
				   {
					 $colonne2=1; //addition a trou
					 $operande1 = $op1; $operande2 = $res; $resultat = $op2;
					 $resultat_comp = $partie2;
					 $etape1 = true ; $etape=true;$verrou1=true;$NonPertinent=false;
					}
				 else if (($op1.$op.$op2."=".$res) == ($op1."+".$partie1."=".$tout1))
				   {
					 //print ("colonne 2 = 1");
					 $colonne2=1; //addition a trou (?+partie2=tout1)
					 $operande1 = $op2; $operande2 = $res; $resultat = $op1;
					 $resultat_comp = $partie2;
					 $etape1 = true ;$etape=true;$verrou1=true;$NonPertinent=false;
				   } 

				else if (($op1.$op.$op2."=".$res) == ($partie1."-".$op2."=".$tout1))
					{
					 //print ("colonne 2 = 8");//n'existe pas dans le codage addition a trou erreur dans le signe de l'opperation
					 $colonne2 = 8 ;
					 $operande1 = $op1; $operande2 = $res; $resultat = $op2;
					 $resultat_comp = calcul($operande1,"-",$operande2);
					 $etape1 = true ;$etape=true;$verrou1=true;$NonPertinent=false;
					}
				else if (($op1.$op.$op2."=".$res) == ($tout1."-".$partie1."=".$res))//||((($op1.$op.$op2."=".$res) == ($op1."-".$partie1."=".$res))&&($op1>=$partie1)))
				   {
					 //print ("colonne 2 = 2");
					 $colonne2=2;
					 $operande1 = $op1; $operande2 = $op2; $resultat = $res;
					 $resultat_comp = calcul($operande1,$op,$operande2);
					 $etape1 = true ;$etape=true;$verrou1=true;$NonPertinent=false;
				   }
				else if (($op1.$op.$op2."=".$res) == ($partie1."-".$tout1."=".$res))
				  {
					 //print ("colonne 2 = 3");
					 $colonne2 = 3;
					 $operande1 = $op1; $operande2 = $op2; $resultat = $res;
					 $resultat_comp = $partie2;
					 $etape1 = true ;$etape=true;$verrou1=true;$NonPertinent=false;
				   }
				else if ((!$verrou1)and((($op1.$op.$op2."=".$res) == ($tout1."+".$partie1."=".$res)) || (($op1.$op.$op2."=".$res) == ($partie1."+".$tout1."=".$res))))
					{
					 //print ("colonne 2 = 4");
					 $colonne2=4;
					 $operande1 = $op1; $operande2 = $op2; $resultat = $res;
					 $resultat_comp = calcul($operande1,$op,$operande2);
					 $etape1 = true ;$etape=true;//$verrou1=true;
					 $NonPertinent=true;
					}
				else if ((!$verrou1)and((($op1.$op.$op2."=".$res) == ($op1."+".$partie1."=".$res) and $op1!=$valdiff) || (($op1.$op.$op2."=".$res) == ($partie1."+".$op2."=".$res) and $op2!=$valdiff)))
					{
					 //print ("colonne 2 = 4");
					 $colonne2=4;
					 $operande1 = $op1; $operande2 = $op2; $resultat = $res;
					 $resultat_comp = calcul($operande1,$op,$operande2);
					 $etape1 = true ;$etape=true;//$verrou1=true;
					 $NonPertinent=true;
					}
				/* else if ((($op1.$op.$op2."=".$res) == ($tout1."+".$op2."=".$res)) || (($op1.$op.$op2."=".$res) == ($op1."+".$tout1."=".$res)))
					{
					 print ("colonne 2 = 4");
					 $colonne2=4;
					 $operande1 = $op1; $operande2 = $op2; $resultat = $res;
					 $resultat_comp = calcul($operande1,$op,$operande2);
					 $etape1 = true ;$etape=true;$verrou1=true;
					} */
				else if (($etape != true) and ((($op1.$op.$op2."=".$res) == ($op1."*".$op2."=".$res))||(($op1.$op.$op2."=".$res) == ($op1.":".$op2."=".$res))))
					{
					// print ("colonne 2 = 5");
					 $colonne2=5;
					 $operande1 = $op1; $operande2 = $op2; $resultat = $res;
					 $resultat_comp = calcul($operande1,$op,$operande2);
					 $etape1 = true ; $etape=false;//$NonPertinent=true;$verrou1=true;
					}
				else if (($op1.$op.$op2."=".$res) == ($tout1."-".$op2."=".$partie1))
					{
					 //print ("colonne 2 = 7");//n'existe pas dans le codage
					 $colonne2 = 7 ;
					 $operande1 = $op1; $operande2 = $res; $resultat = $op2;
					 $resultat_comp = calcul($operande1,"-",$operande2);
					 $etape1 = true ;$etape=true;$verrou1=true;$NonPertinent=false;
					}
				else if (($op1.$op.$op2."=".$res)==($op1."-".$tout1."=".$res) and !in_array($op1,array($partie1,$partie2,$partie3,$tout2)))
					{
					 $colonne2=2; $colonne3=1;
					 $operande1 = $op1; $operande2 = $op2; $resultat = $res;
					 $resultat_comp = calcul($operande1,"-",$operande2);
					 $etape1 = true ; $etape=false;
					 $verrou1=true;$NonPertinent=true;
					}
			    /* else if ($op1.$op.$op2."=".$res)
				{
				print ("colonne2 =6");
					 $colonne2 = 6;
				} */
				else if (!(ereg("[0-7]",$colonne2)))
					{
					 //print ("colonne2 =9");
					 $colonne2 = 9;
					}
			
			 //=================colonne3=============
			  if (($colonne2 == 0) and ($resultat!=$partie2) and ($etape1))
				{
					//print(" colonne3 = 9");
                    $colonne3=9;
				}
				else if ($colonne2 == 9)
				{
					//print(" colonne3 = 9");
                    $colonne3=9;
				}
				else if (((($operande1==$tout1)||($operande1==$partie1))&&(($operande2==$tout1)||($operande2==$partie1)))and ($etape1))
				{
					//print(" colonne3 = 0 ");
                     $colonne3=0;
				}
			   else if (((($operande1==$tout1)||($operande1==$partie1))xor(($operande2==$tout1)||($operande2==$partie1)))and ($etape1))
				{
					//print(" colonne3 = 1 ");
                    $colonne3=1;
    				$NonPertinent=true;
				}

			 //=================colonne4=============
			 if (($colonne3 == 9)and($colonne2==0)and($etape1))
				{
					//print(" colonne4 = 8 ");
                    $colonne4=8;
				}
			else if (((($colonne2 == 0)||($resultat==''))and ($etape1))||($colonne2 == 9))
				{
					//print(" colonne4 = 9 ");
                    $colonne4=9;
				}

			else if (($resultat == $resultat_comp)and ($etape1))
				{
					//print(" colonne4 = 0 ");
                    $colonne4=0;
				}
			 else if ((($resultat == $resultat_comp-1)||($resultat == $resultat_comp+1))and ($etape1))
				{
					//print(" colonne4 = 1 ");
                    $colonne4=1;
				}
			 else if ((($resultat < $resultat_comp-1) ||($resultat > $resultat_comp-1))and ($etape1))
				{
					//print(" colonne4 = 2 ");
                    $colonne4=2;
				}
		 }//fin => if($difference = true)
	/*=================colonne 6 à 8 terme de la comparaison==================*/
	if ((!$etape1 || !$difference) and (!$verrou2))
	{
	//$colonne6='';
		   if ((($question=="t")and(($op1.$op.$op2."=".$res) == ($valdiff."+".$op2."=".$partie1)))||
			  (($question=="p")and(($op1.$op.$op2."=".$res) == ($valdiff."+".$op2."=".$tout1))))
			   {
				 $colonne6=1; //addition a trou
				 $operande1 = $op1; $operande2 = $res; $resultatc = $op2;
				 $resultat_comp = calcul($operande2,"-",$operande1);
				 $etape2 = true ; $etape_2=true;$verrou2=true;$finc=$k;
				}
			else if ((($question=="t") and (($op1.$op.$op2."=".$res) == ($partie1."+".$valdiff."=".$partie3)))||
			  (($question=="p") and (($op1.$op.$op2."=".$res) == ($tout1."+".$valdiff."=".$tout2))))
			   {
				 $colonne6=21; //erreur de signe n'existe pas dans le codage
				 $operande1 = $op1; $operande2 = $op2; $resultatc = $res;
				 $resultat_comp = calcul($operande1,"-",$operande2);
				 $etape2=true; $etape_2=true; $verrou2=true;$finc=$k;
				}
			else if ((($question=="t")and(($op1.$op.$op2."=".$res) == ($partie1."-".$op2."=".$valdiff)))||
					 (($question=="p")and(($op1.$op.$op2."=".$res) == ($tout1."-".$op2."=".$valdiff))))
				{//n'existe pas dans le codage
				 $colonne6=7;
				 $operande1 = $op1; $operande2 = $res; $resultatc = $op2;
				 $resultat_comp = calcul($operande1,"-",$operande2);
				 $etape2 = true ;$etape_2=true;$verrou2=true;$finc=$k;
				}
			else if ((($question=="t")and(($op1.$op.$op2."=".$res) == ($valdiff."-".$op2."=".$partie1)))||
					 (($question=="p")and(($op1.$op.$op2."=".$res) == ($valdiff."-".$op2."=".$tout1))))
				{ //n'existe pas dans le codage addition a trou erreur dans le signe de l'oppération
				 $colonne6 = 6 ;
				 $operande1 = $op1; $operande2 = $res; $resultatc = $op2;
				 $resultat_comp = calcul($operande1,"-",$operande2);
				 $etape2 = true ;$etape_2=true;$verrou2=true;$finc=$k;
				}
			else if ((($question=="t")and(($op1.$op.$op2."=".$res) == ($partie1."-".$valdiff."=".$res)))||
					 (($question=="p")and(($op1.$op.$op2."=".$res) == ($tout1."-".$valdiff."=".$res))))
			   {
				 if(isset($diffErr) and $diffErr==true)
				 	 $colonne6=20;
				 else
				 	 $colonne6=2; 
				 $operande1 = $op1; $operande2 = $op2; $resultatc = $res;
				 $resultat_comp = calcul($operande1,$op,$operande2);
				 $etape2=true;$etape_2=true;$verrou2=true;$finc=$k;
			   }
			else if (
					   (
						 (($question=="p")and(($op1.$op.$op2."=".$res) == ($partie1."-".$valdiff."=".$res)))
						 ||
						 (($question=="t")and(($op1.$op.$op2."=".$res) == ($tout1."-".$valdiff."=".$res)))
					   )
					 and 
					 	(!$difference)
					 )
			   {
				 $diffErr=true; //erreur dans le calcul de la différence, elle n'est pas à la bonne place
				 $colonne6=2;$colonne7=1;$etape_2=false;//colonne7==11 Pour déceler une erreur dans l’étape de la comparaison
				 $operande1 = $op1; $operande2 = $op2; $resultatc = $res;
				 $resultat_comp = calcul($operande1,$op,$operande2);
				 $etape2=true; $finc=$k;  //$verrou2=true;	$k++;

			   }
			else if (($op1.$op.$op2."=".$res)==($op1."-".$valdiff."=".$res) and (!$difference))
			   {
				 if($op1==$partie2 and count($tabOperation)==1) //calcul intermédiaire implicite
				 {
					$colonne2=0;$colonne3=9;$colonne4=0;$etape=true;		
			 	 }
				 else 
				 {
				 	$colonne6=2;$colonne7=1;$etape_2=false;//colonne7==11 Pour déceler une erreur dans l’étape de la comparaison
				 	$operande1 = $op1; $operande2 = $op2; $resultatc = $res;
					$resultat_comp = calcul($operande1,$op,$operande2);
				 	$etape2 = true; $finc=$k; $k++; //$verrou2=true;
				 }
			   }
			else if ((($question=="t")and(($op1.$op.$op2."=".$res) == ($valdiff."-".$partie1."=".$res)))||
					 (($question=="p")and(($op1.$op.$op2."=".$res) == ($valdiff."-".$tout1."=".$res))))
			  {
				 $colonne6 = 3;
				 $operande1 = $op1; $operande2 = $op2; $resultatc = $res;
				 $resultat_comp = $partie2;
				 $etape2 = true ;$etape_2=true;$verrou2=true;$finc=$k;
			   }
			else if ((($question=="t")and((($op1.$op.$op2."=".$res) == ($partie1."+".$valdiff."=".$res)) || (($op1.$op.$op2."=".$res) == ($valdiff."+".$partie1."=".$res))))||
					 (($question=="p")and((($op1.$op.$op2."=".$res) == ($tout1."+".$valdiff."=".$res)) || (($op1.$op.$op2."=".$res) == ($valdiff."+".$tout1."=".$res)))))
				{
				 $colonne6 = 4;
				 $NonPertinent=true;
				 $operande1 = $op1; $operande2 = $op2; $resultatc = $res;
				 $resultat_comp = calcul($operande1,$op,$operande2);
				 $etape2 = true ;$verrou2=true;$finc=$k;//$etape_2=true;
				}
			else if ((($question=="t")and((($op1.$op.$op2."=".$res) == ($partie1."*".$valdiff."=".$res))||(($op1.$op.$op2."=".$res) == ($partie1.":".$valdiff."=".$res))))||
					 (($question=="p")and((($op1.$op.$op2."=".$res) == ($tout1."*".$valdiff."=".$res))||(($op1.$op.$op2."=".$res) == ($tout1.":".$valdiff."=".$res)))))
				{
				 $colonne6 = 5;
				 $operande1 = $op1; $operande2 = $op2; $resultatc = $res;
				 $resultat_comp = calcul($operande1,$op,$operande2);
				 $etape2 = true ; $etape_2=true;$verrou2=true;$finc=$k;
				}
			else if ((($question=="t")and((($op1.$op.$op2."=".$res) == ($valdiff."*".$partie1."=".$res))||(($op1.$op.$op2."=".$res) == ($valdiff.":".$partie1."=".$res))))||
					 (($question=="p")and((($op1.$op.$op2."=".$res) == ($valdiff."*".$tout1."=".$res))||(($op1.$op.$op2."=".$res) == ($valdiff.":".$tout1."=".$res)))))
				{
				 $colonne6 = 5;
				 $operande1 = $op1; $operande2 = $op2; $resultatc = $res;
				 $resultat_comp = calcul($operande1,$op,$operande2);
				 $etape2 = true ; $etape_2=true;$verrou2=true;$finc=$k;
				}
			else if (!(ereg("[0-7]",$colonne6)))
				{
				 $colonne6 = 9;
				}
			
			//print("colonne6=".$colonne6);
	/*______________________ colonne 7 pertinence des données ___________________*/
	if (($colonne6 == 0)and ($etape2) and ((($question == 't')and($resultatc!=$partie3))||(($question == 'p')and($resultatc!=$tout2))) )
		{
			$colonne7=9;
		}
		else if ($colonne6 == 9)
		{
			$colonne7=9;
		}
		else if (($question=="t")and ($etape2)and(((($operande1==$partie1)||($operande1==$valdiff))&&(($operande2==$partie1)||($operande2==$valdiff)))))
		{
			$colonne7=0;
		}
		else if (($question=="p")and ($etape2)and(((($operande1==$tout1)||($operande1==$valdiff))&&(($operande2==$tout1)||($operande2==$valdiff)))))
		{
			$colonne7=0;
		}
	   else if (($question=="t")and ($etape2)and((($operande1==$partie1)||($operande1==$valdiff))xor(($operande2==$partie1)||($operande2==$valdiff))))
		{
			$colonne7=1;$etape_2=false;
		}
	   else if (($question=="p")and ($etape2)and((($operande1==$tout1)||($operande1==$valdiff))xor(($operande2==$tout1)||($operande2==$valdiff))))
		{
			$colonne7=1;$etape_2=false;
		}
				//print(" colonne7=".$colonne7);
	/*_______________________ colonne8 ___________________*/
	//$colonne8='';
			if (($colonne7 == 9)and($colonne6==0)and($etape2))
				{
				$colonne8=8;
				}
			else if (((($colonne6 == 0)||($resultatc==''))and ($etape2))||($colonne6 == 9))
				{
				$colonne8=9;
				}

			else if (($resultatc == $resultat_comp)and ($etape2))
				{
				$colonne8=0;
				}
			 else if ((($resultatc == $resultat_comp-1)||($resultatc == $resultat_comp+1))and ($etape2))
				{
				$colonne8=1;
				}
			 else if ((($resultatc < $resultat_comp-1) ||($resultatc > $resultat_comp-1))and ($etape2))
				{
				$colonne8=2;
				}
	   	//print(" colonne8=".$colonne8);
	/*________________________________________________________*/
	}//fin => if(($difference != true)and($etape1=!true))
	}//fin if (count ($T1) == 1 )

	else if ((count ($T1) == 2) and (count($tabOperation)>1))
	{
	$colonne15=8;
	}
	else if (count($T1)==3 || count($T1)==4)
	{
	 $colonne2 = 6; $colonne3 =1; $resultat = end($T2);
	 if ($T1[0]=="+")  $resultat_comp = $T2[0] + $T2[1];  else if($T1[0]=="-") $resultat_comp = $T2[0]- $T2[1];
	 if ($T1[1]=="+")  $resultat_comp =  $resultat_comp + $T2[2]; else if($T1[1]=="-") $resultat_comp =  $resultat_comp- $T2[2];
	 if ($T1[2]=="+")  $resultat_comp =  $resultat_comp + $T2[3]; else if($T1[2]=="-") $resultat_comp =  $resultat_comp - $T2[3];
	 if ($T1[3]=="+")  $resultat_comp =  $resultat_comp + $T2[4]; else if($T1[3]=="-") $resultat_comp =  $resultat_comp - $T2[4];

	if ($resultat == $resultat_comp)  $colonne4=0;
	else if (($resultat == $resultat_comp-1)||($resultat == $resultat_comp+1)) 	$colonne4=1;
	else if (($resultat < $resultat_comp-1) ||($resultat > $resultat_comp-1))  $colonne4=2;
	}


}

//fin du for
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

$op1 = $T2[0]; $op = $T1[0]; $op2 = $T2[1]; $res = $T2[2];
	/*========== cas de calcul par différence pour les problèmes de comparaison ===============*/
	//=================  colonne14 & 15 & 16  =============
			
			if (($question == 't') and (count($tabOperation)>=1))
			{
				 if (($op1.$op.$op2."=".$res) == ($valdiff."+".$op2."=".$tout1))
				   {//addition a trou
					 $colonne14=3; $colonne15=1;$colonne16=0;
					 $operande1 = $op1; $operande2 = $res; $resultatf = $op2;
					 $resultat_compf = calcul($operande2,"-",$operande1);
					 $difference = true ;$diff=true;
				   }
				 else if (($op1.$op.$op2."=".$res) == ($tout1."-".$valdiff."=".$res))
					{
					 $colonne14=3; $colonne15 = 2; $colonne16=0;
					 $operande1 = $op1; $operande2 = $op2; $resultatf = $res;
					 $resultat_compf = calcul($operande1,$op,$operande2);
					 $difference = true ; $diff=true;
					}
			}
			else if (($question == 'p') and (count($tabOperation)>=1))
			{
				 if (($op1.$op.$op2."=".$res) == ($valdiff."+".$op2."=".$partie1))
				   {//addition a trou
					 $colonne14=3; $colonne15=1;$colonne16=0;
					 $operande1 = $op1; $operande2 = $res; $resultatf = $op2;
					 $resultat_compf = calcul($operande2,"-",$operande1);
					 $difference = true ;$diff=true;
				   }
				  else if (($op1.$op.$op2."=".$res) == ($partie1."-".$valdiff."=".$res))
					{
					 $colonne14=3; $colonne15 = 2;$colonne16=0;
					 $operande1 = $op1; $operande2 = $op2; $resultatf = $res;
					 $resultat_compf = calcul($operande1,$op,$operande2);
					 $difference = true ; $diff=true;
					}
			 }

/*---------------traitement des cas implicite----------------------*/
if (isset($colonne2) and ereg("[0-7]",$colonne2) and isset($colonne6) and ereg("[0-7]",$colonne6))
{
}
else
{/* debut else implicite */
		if((!$etape)and($etape_2)and(($op1==$tabImp[0])||($op2==$tabImp[0])))
		{
		 $colonne2=0;$colonne3=9;$etape=true;
		 $resultat=$tabImp[0];
		 if ($resultat==$partie2)
			$colonne4=0;
		 else if ($resultat==$partie2-1)
			$colonne4=1;
		 else if (($resultat<$partie2-1)||($resultat>$partie2-1))
			$colonne4=2;
		 else
			$colonne4=9;
		}
		else if(($etape)and(!$etape_2)and(($op1==$tabImp[0])||($op2==$tabImp[0])))
		{
		 echo($operation_f);
		 $colonne6=0;$colonne7=9;$etape_2=true;
		 $resultatc=$tabImp[0];
			 if ((($question=="t")and($resultatc==$partie3))||(($question=="p")and($resultatc==$tout2)))
					$colonne8=0;
			 else if ((($question=="t")and(($resultatc<$partie3-1)||($resultatc>$partie3-1)))||(($question=="p")and(($resultatc<$tout2-1)||($resultatc>$tout2-1))))
				$colonne8=9;
			 else
				$colonne8=9;
		}
		else if(($etape)and(!$etape_2)and((($question=="p")and(end($tabImp)==$tout2))||(($question=="t")and(end($tabImp)==$partie3))))
		{
			 $colonne14=3;$colonne15=0;$colonne16=9; $colonne17=8;
		}
		else if((!$etape)and(!$etape_2)and
		(($question=='t')and(($op1.$op.$op2."=".$res)==($partie3."+".$partie2."=".$res)||($op1.$op.$op2."=".$res)==($partie2."+".$partie3."=".$res))))
		{

			 $colonne2=0;$colonne3 = 9;$colonne4 = 0;$colonne6 = 0; $colonne7 = 9;$colonne8 = 0;
			 $colonne14=2;$colonne15=4;$colonne16=0;
			 $operande1 = $op1; $operande2 = $op2; $resultatf =$res ;
			 $resultat_compf = calcul($operande1,"+",$operande2);
			 $etape=true; $etape_2=true; $etape3 = true ;
		}
		else if(($question=='p')and($verrou1)and(!$verrou2)and(($op1.$op.$op2."=".$res)==($tout2."-".$resultat."=".$res)))
		{
			 $colonne6 = 0; $colonne7 = 9;$colonne8 = 0;
			 $colonne14=1;$colonne15 = 2;$colonne16=0;
			 $resultatc=$tout2;
			 $operande1 = $op1; $operande2 =$op2 ; $resultatf = $res;
			 $resultat_compf = abs(calcul($operande1,"-",$operande2));
			 $etape3 = true ;
		}
		else if(($question=='p')and(!$verrou1)and($verrou2)and(($op1.$op.$op2."=".$res)==($resultatc."-".$partie2."=".$res)))
		{
			 $colonne2=0; $colonne3 = 9;$colonne4 = 0;$etape=true;
			 $colonne14=1;$colonne15 = 2;$colonne16=0;
			 $resultat=$partie2;
			 $operande1 = $op1; $operande2 =$op2 ; $resultatf = $res;
			 $resultat_compf = abs(calcul($operande1,"-",$operande2));
			 $etape3 = true ;
		}
		else if(($question=='t')and($verrou1)and(!$verrou2)and(($op1.$op.$op2."=".$res)==($partie3."+".$resultat."=".$res)||($op1.$op.$op2."=".$res)==($resultat."+".$partie3."=".$res)))
		{
			 $colonne6 = 0; $colonne7 = 9;$colonne8 = 0;$etape2=true;$etape_2=true;
			 $colonne14=2;$colonne15=4;$colonne16=0;
			 $resultatc=$partie3;
			 $operande1 = $op1; $operande2 =$op2 ; $resultatf = $res;
			 $resultat_compf = abs(calcul($operande1,"-",$operande2));
			 $etape3 = true ;
		}
		else if(($question=='t')and(!$verrou1)and($verrou2)and(($op1.$op.$op2."=".$res)==($resultatc."+".$partie2."=".$res)||($op1.$op.$op2."=".$res)==($partie2."+".$resultatc."=".$res)))
		{
			 $colonne2=0; $colonne3 = 9;$colonne4 = 0;$etape=true;$etape1=true;
			 $colonne14=2;$colonne15=4;$colonne16=0;
			 $resultat=$partie2;
			 $operande1 = $op1; $operande2 =$op2 ; $resultatf = $res;
			 $resultat_compf = abs(calcul($operande1,"-",$operande2));
			 $etape3 = true ;
			 
		}
		else if(($question=='p')and(!$verrou1)and(!$verrou2)and(($op1.$op.$op2."=".$res)==($tout2."-".$partie2."=".$res)))
		{
			 $colonne2=0;$colonne3 = 9;$colonne4 = 0;$colonne6 = 0; $colonne7 = 9;$colonne8 = 0;$etape=true;$etape_2=true;
			 $colonne14=1;$colonne15 = 2;$colonne16=0;
			 $resultat=$partie2;$resultatc=$tout2;
			 $operande1 = $op1; $operande2 = $op2; $resultatf = $res;
			 $resultat_compf = abs(calcul($operande1,"-",$operande2));
			 $etape3 = true ;
		}
		else if(isset($tabImp) and (!$etape)and(!$etape_2)and((($op1==$tabImp[0])||($op2==$tabImp[0]))and(($op1==$tabImp[1])||($op2==$tabImp[1]))))
		{

			 if ((($op1>=$op2)and($question=='p'))||(($op1<$op2)and($question=='t')))
			 {
			 $resultatc=$op1;$resultat=$op2;
			 }
			 else if ((($op1<$op2)and($question=='p'))||(($op1>=$op2)and($question=='t')))
			 {
			 $resultat=$op1;$resultatc=$op2;
			 }
			$colonne2=0;$colonne3=9;
			 if ($resultat==$partie2)
				$colonne4=0;
			 else if ($resultat==$partie2-1)
				$colonne4=1;
			 else if (($resultat<$partie2-1)||($resultat>$partie2-1))
				$colonne4=2;
			 else
				$colonne4=9;
				
			$colonne6 = 0; $colonne7 = 9;
			if ((($question="t")and($resultatc==$partie3))||(($question="p")and($resultatc==$tout2)))
				$colonne8=0;
			 else if ((($question="t")and(($resultatc<$partie3-1)||($resultatc>$partie3-1)))||(($question="p")and(($resultatc<$tout2-1)||($resultatc>$tout2-1))))
				$colonne8=9;
			 else
				$colonne8=9;
		}
		else if (($question=='p')and(($etape)and(!$etape_2))and(($op1.$op.$op2."=".$res)==($tout2."-".$op2."=".$res)))
		   {
		   	 $colonne6 = 0; $colonne7 = 9;$colonne8 = 0;$etape_2=true;
		     $resultatc = $tout2;
		   }
		else if (($question=='t')and(($etape)and(!$etape_2))and(($op1.$op.$op2."=".$res)==($partie3."+".$op2."=".$res)||($op1.$op.$op2."=".$res)==($op2."+".$partie3."=".$res)))
		   {
		   	 $colonne6 = 0; $colonne7 = 9;$colonne8 = 0;$etape_2=true;
		     $resultatc = $partie3;
		   }
		else if (($question=='p')and((!$etape)and($etape_2))and(($op1.$op.$op2."=".$res)==($op1."-".$partie2."=".$res)))
		   {
		   	 $colonne2=0; $colonne3 = 9;$colonne4 = 0;$etape=true;
		     $resultat = $partie2;
		   }
		else if (($question=='t')and((!$etape)and($etape_2))and(($op1.$op.$op2."=".$res)==($partie2."+".$resultatc."=".$res)||($op1.$op.$op2."=".$res)==($resultatc."+".$partie2."=".$res)))
		   {
		   	 $colonne2=0; $colonne3 = 9;$colonne4 = 0;$etape=true;
		     $resultat = $partie2;
		   }
		   
}/* fin else implicite exit($colonne6."  ".$colonne7."  ".$colonne8); */
								/*-----------------------------------------------------------*/
											//=========colonne 14 et 15=============
	 if (($question=='p')and(($op1.$op.$op2."=".$res)==($resultat."+".$op2."=".$resultatc)||($op1.$op.$op2."=".$res)==($partie2."+".$op2."=".$tout2)))
		   {
		   	 $colonne14=1; $colonne15=1;//addition a trou
			 $operande1 = $op1; $operande2 = $res; $resultatf = $op2;
			 $resultat_compf = calcul($operande2,"-",$operande1);
			 $etape3 = true ;
		   }
	  else if (($question=='p')and(($op1.$op.$op2."=".$res)==($tout2."-".$partie2."=".$res)))
		   {
			 $colonne14=1; $colonne15 = 2;
			 $operande1=$op1; $operande2=$op2; $resultatf=$res;
			 $resultat_compf = calcul($operande1,$op,$operande2);
			 $etape3 = true ;
		   }
	  else if (($question=='p')and(($op1.$op.$op2."=".$res) == ($partie2."-".$tout2."=".$res)))
		   {
			 $colonne14=1; $colonne15 = 3;
			 $operande1 = $op1; $operande2 = $op2; $resultatf = $res;
			 $resultat_compf = $partie3;
			 $etape3 = true ;
		   }
	  else if (($question=='t')and
	  		  ((($op1.$op.$op2."=".$res) == ($partie2."+".$partie3."=".$res))||
	  		   (($op1.$op.$op2."=".$res) == ($partie3."+".$partie2."=".$res))))
			{
			 $colonne14=2; $colonne15=4; 
			 $operande1 = $op1; $operande2 = $op2; $resultatf = $res;
			 $resultat_compf = calcul($operande1,$op,$operande2);
			 $etape3 = true ;
			}
	  else if (($question=='t')and ($etape)and(($op1.$op.$op2."=".$res) == ($partie1."-".$valdiff."=".$res))and(end($tabImp)==$res))
			{/* revoir le  end($tabImp)==$res pkoi $res et pas partie3*/
			 if (count($tabOperation)==$finc+1)
			 {
			 $colonne6 = 9; $colonne7 = 9;$colonne8=9; $arretc=true;
			 }
			 $colonne14=3; $colonne15 = 2;$colonne16=4;$diff=true;
			 $operande1 = $op1; $operande2 = $op2; $resultatf = $res;
			 $resultat_compf = calcul($operande1,$op,$operande2);
			 $etape3 = true ;
			}
	  else if (($question=='t')and(!$imp3)and(end($tabImp)!=$tout2)and(($op1.$op.$op2."=".$res) == ($partie1."-".$valdiff."=".$res)))
			{
			 if (count($tabOperation)==$finc+1)
			 {
			 $colonne6 = 9; $colonne7 = 9;$colonne8=9; $arretc=true;							
			 }
			 $colonne14=3; $colonne15 = 2;$colonne16=4;$diff=true;
			 $operande1 = $op1; $operande2 = $op2; $resultatf = $res;
			 $resultat_compf = calcul($operande1,$op,$operande2);
			 $etape3 = true ;
			}
	  else if (($question=='p')and ($etape)and(($op1.$op.$op2."=".$res) == ($tout1."-".$valdiff."=".$res))and(end($tabImp)==$res))
			{
			 if (count($tabOperation)==$finc+1)
			 {
			 $colonne6 = 9; $colonne7 = 9;$colonne8=9; $arretc=true;
			 }
			 $colonne14=3; $colonne15 = 2;$colonne16=4;$diff=true;
			 $operande1 = $op1; $operande2 = $op2; $resultatf = $res;
			 $resultat_compf = calcul($operande1,$op,$operande2);
			 $etape3 = true ;
			}
	else if (($question=='p') and(end($tabImp)!=$partie3)and(($op1.$op.$op2."=".$res) == ($tout1."-".$valdiff."=".$res)))
			{
			if (count($tabOperation)==$finc+1)
			 {
			 $colonne6 = 9; $colonne7 = 9;$colonne8=9; $arretc=true;
			 }
			 $colonne14=3; $colonne15=2;$colonne16=4;$diff=true;
			 $operande1 = $op1; $operande2 = $op2; $resultatf = $res;
			 $resultat_compf = calcul($operande1,$op,$operande2);
			 $etape3 = true ;
			}
	 else if (($question=='t')and ($etape)and($etape_2)and(end($tabImp)==($resultat+$resultatc)||end($tabImp)==($resultatc+$resultat)))
			{/*implicite*/
			 $colonne14 = 0; $colonne15 = 0;$colonne16=9;
			 $resultat_compf = $resultat+$resultatc ;
			 $resultatf=$tout2;
			 $etape3 = true ;
			}
	else if (($question=='p')and ($etape)and($etape_2)and(end($tabImp)==($resultatc-$resultat)))
			{/*implicite*/
			 $colonne14 = 0; $colonne15 = 0;$colonne16=9;
			 $resultat_compf = $resultatc-$resultat;
			 $resultatf=$partie3;
			 $etape3 = true ;
			}
	  else if (($question=='t')and ($etape)and($etape_2)and(($op1.$op.$op2."=".$res)==($resultat."+".$resultatc."=".$res)||
	                                                        ($op1.$op.$op2."=".$res)==($resultatc."+".$resultat."=".$res)))
			{
			 $colonne14=2; $colonne15=4;
			 $operande1=$op1; $operande2=$op2; $resultatf = $res;
			 $resultat_compf = calcul($operande1,$op,$operande2);
			 $etape3 = true ;
			}
	else if (($question=='p')and ($etape)and($etape_2)and(($op1.$op.$op2."=".$res)==($resultat."-".$resultatc."=".$res)||
																($op1.$op.$op2."=".$res)==($resultatc."-".$resultat."=".$res)))
			{
			 $colonne14=1; 
			 $operande1=$op1; $operande2=$op2; $resultatf = $res;
			 $resultat_compf = calcul($operande1,$op,$operande2);
				 if ($resultat_compf<0)
				 {
					$colonne15=3;
					$resultat_compf=abs($resultat_compf);
				 }
				else
				 {
					$colonne15=2;
				 }
			 $etape3 = true ;
			}
	else if (($question=='p')and ($etape)and($etape_2)and($op1.$op.$op2."=".$res)==($resultat."-".$res."=".$resultatc))
			{
			 $colonne14=1; $colonne15=71;
			 $operande1=$op1; $operande2=$res; $resultatf = $op2; 
			 $resultat_compf = calcul($operande1,$op,$operande2);
			 $etape3 = true ;
			}
	else if (($question =='p' and !$addTrou)and((($op1.$op.$op2."=".$res) == ($resultat."+".$resultatc."=".$res))||(($op1.$op.$op2."=".$res) == ($resultatc."+".$resultat."=".$res))))
	 		{
			 if($etape and $colonne2=='1')
			 {$colonne2=9;$colonne3=9;$colonne4=9;$etape=false;$etape1=false;}
			 $colonne14=41;//calcul d'un tout : soustratction des deux resultats intermédiaire au lieu de les additionner
			 $colonne15=4;
			 $operande1 = $op1; $operande2 = $op2; $resultatf = $res;
			 $resultat_compf = abs(calcul($operande1,$op,$operande2));
			 $etape3=true;
			 }
	else if (($question =='t' and !$addTrou and ($colonne3==1 or $colonne7==1))and((($op1.$op.$op2."=".$res) == ($resultat."+".$resultatc."=".$res))||(($op1.$op.$op2."=".$res) == ($resultatc."+".$resultat."=".$res))))
	 		{
			 $colonne14=41;//calcul d'un tout : soustratction des deux resultats intermédiaire au lieu de les additionner
			 $colonne15=4;
			 $operande1 = $op1; $operande2 = $op2; $resultatf = $res;
			 $resultat_compf = abs(calcul($operande1,$op,$operande2));
			 $etape3=true;
			 }
	else if ((($op1.$op.$op2."=".$res) == ($resultat."-".$valdiff."=".$res))||(($op1.$op.$op2."=".$res) == ($resultat."+".$valdiff."=".$res)||($op1.$op.$op2."=".$res) == ($valdiff."+".$resultat."=".$res)))
	 		{
			 if (count($tabOperation)==$finc+1)
			 {
			 	$colonne6 = 9; $colonne7 = 9;$colonne8=9;$etape_2=false ;
			 }
			 $colonne14=4;
			 if($op=="-")
				 $colonne15 = 2;
			 else if($op=="+" and $addTrou)
			 	$colonne15=1;
			 else if($op=="+")
			 	$colonne15=4;
			 $operande1 = $op1; $operande2 = $op2; $resultatf = $res;
			 $resultat_compf = abs(calcul($operande1,$op,$operande2));
			 $etape3=true;

			 }
	else if (($question =='t')and((($op1.$op.$op2."=".$res) == ($resultatc."-".$resultat."=".$res))||(($op1.$op.$op2."=".$res) == ($resultat."-".$resultatc."=".$res))))
	 		{
				 if (count($tabOperation)==$finc+1)
				 {
					$colonne6 = 9; $colonne7 = 9;$colonne8=9;$etape_2=false ;
				 }
				 $operande1 = $op1; $operande2 = $op2; $resultatf = $res;
				 if ($operande1 >= $operande2)
					$colonne15 = 2;
				 else if ($operande1 < $operande2)
					$colonne15 = 3;
				 $colonne14=42;//calcul d'un tout : soustratction des deux resultats intermédiaire au lieu de les additionner
				 $resultat_compf = abs(calcul($operande1,$op,$operande2));
				 $etape3=true;
			 }
	else if ((($op1.$op.$op2."=".$res) == ($resultatc."-".$valdiff."=".$res))||(($op1.$op.$op2."=".$res) == ($resultatc."+".$valdiff."=".$res)||($op1.$op.$op2."=".$res) == ($valdiff."+".$resultatc."=".$res)))
	 		{
			 $colonne14=4;
			 if($op=="-")
				 $colonne15 = 2;
			 else if($op=="+" and $addTrou)
			 	$colonne15=1;
			 else if($op=="+")
			 	$colonne15=4;
			 $operande1 = $op1; $operande2 = $op2; $resultatf = $res;
			 $resultat_compf = abs(calcul($operande1,$op,$operande2));
			 $etape3=true;

			 }
	 else if (((($op1.$op.$op2."=".$res) == ($resultatc."*".$resultat."=".$res))||(($op1.$op.$op2."=".$res) == ($resultatc.":".$resultat."=".$res))|| 
	 (($op1.$op.$op2."=".$res) == ($resultat."*".$resultatc."=".$res))||(($op1.$op.$op2."=".$res) == ($resultat.":".$resultatc."=".$res))) and ($etape))
			{
			 $colonne14=5; $colonne15=8;
			 $operande1 = $op1; $operande2 = $op2; $resultatf = $res;
			 $resultat_compf = calcul($operande1,$op,$operande2);
			 $etape3 = true ;
			}

	else if (($NonPertinent)and((($op1.$op.$op2."=".$res) == ($partie1."+".$tout1."=".$res))||(($op1.$op.$op2."=".$res) == ($tout1."+".$partie1."=".$res))))
	{
			 if (count($tabOperation)==1)
			 {
			  	$colonne2= 9; $colonne3 = 9;$colonne4=9;
			 }
			 $colonne14=5; $colonne15=4;$colonne16=1;
			 $operande1 = $op1; $operande2 = $op2; $resultatf = $res;
			 $resultat_compf = calcul($operande1,$op,$operande2);
			 $etape3 = true ; 
	}
   else if (($NonPertinent)and((($question=="t")and((($op1.$op.$op2."=".$res) == ($partie1."+".$valdiff."=".$res)) || (($op1.$op.$op2."=".$res) == ($valdiff."+".$partie1."=".$res))))||
				 (($question=="p")and((($op1.$op.$op2."=".$res) == ($tout1."+".$valdiff."=".$res)) || (($op1.$op.$op2."=".$res) == ($valdiff."+".$tout1."=".$res))))))
			{
			 $colonne14=5; $colonne15=4;$colonne16=4; 
			 if($etape) $NonPertinent=false;
			 $operande1 = $op1; $operande2 = $op2; $resultatf = $res;
			 if (count($tabOperation)==$finc+1)
			 {
			 $colonne6 = 9; $colonne7 = 9;$colonne8=9;
			 }			 
			 $resultat_compf = calcul($operande1,$op,$operande2);
			 $etape3 = true ;
			}
   else if (($etape)and($etape_2)and(!$etape3)and($finc==count($tabOperation)-1)and(($colonne6==1)||($colonne6==2)||($colonne6==3)||($colonne6==4)))
			{/* pas d'operation final codage uniquement de l'operation2  */
			 if ($colonne6==1)
			 	$colonne15=1;
			 else if($colonne6==2)
			 	$colonne15 = 2;
			 else if($colonne6==3)
			 	$colonne15 = 3;
			 else if($colonne6==4)
			 	$colonne15=4;
			 $colonne16=4;
			 $colonne6 = 9; $colonne7 = 9;$colonne8=9;
			 if (count($tabOperation)==$finc+1)
			 {
			 $colonne6 = 9; $colonne7 = 9;$colonne8=9;
			 }
			 $colonne14=3; $operande1 = $op1; $operande2 = $op2; $resultatf = $res;
			 $resultat_compf = calcul($operande1,$op,$operande2);
			 $etape3 = true ;
			}

   else if (($etape) and (count($tabOperation)==1) and (!isset($imp3)) and ($colonne2==2||$colonne2==3|| 
  (($colonne2==1 or $colonne2==7) and end($tabNombre)==$op2)))
	{
		$colonne17=$colonne4;
		  if ($question=='t')
			$colonne14=1;
		  else if ($question=='p')
			$colonne14=1;
		if ($colonne2==1) {$colonne15=1;}
		else if (($colonne2==2)||($colonne2==7)) $colonne15=2;
		else if ($colonne2==3) $colonne15=3;
		$colonne16=1;$NonPertinent=true;
		$colonne2=9;$colonne3=9;$colonne4=9;$etape=false;$etape1=false;
	}
	else if(($op1.$op.$op2."=".$res == $resultat."-".$op2."=".$valdiff) and (end($tabNombre)==$op2))
			{
			 $colonne14=4;$colonne15=71; $colonne16=1; 
			 $operande1 = $op1; $operande2 = $res; $resultatf = $op2;
			 $resultat_compf = abs(calcul($operande1,$op,$operande2));
			} 
	else if(($op1.$op.$op2."=".$res == $resultat."-".$op2."=".$valdiff) and (end($tabNombre)==$op2))
			{
			 $colonne14=4;$colonne15=71; $colonne16=1; 
			 $operande1 = $op1; $operande2 = $res; $resultatf = $op2;
			 $resultat_compf = abs(calcul($operande1,$op,$operande2));
			} 
	else if(($op1.$op.$op2."=".$res == $op1."-".$op2."=".$valdiff) and (end($tabNombre)==$op2))
			{
			 $colonne14=5;$colonne15=71; $colonne16=1; 
			 $operande1 = $op1; $operande2 = $res; $resultatf = $op2;
			 $resultat_compf = abs(calcul($operande1,$op,$operande2));
			} 
	 
	 else if (($op1.$op.$op2."=".$res)and(!$difference) and (!$imp3) and (count($tabOperation)==1)and(count($T1)==1) and !$etape1 and !$etape2)
   		   {
			 $colonne14=5;
				 if ($op == '+')
					$colonne15=4;
				 else if (($op == '-')and($op1<$op2))
					 $colonne15=3;
				 else if ($op == '-')
					 $colonne15=2; 
				 else 
					$colonne15=7;
						 
			 $operande1 = $op1; $operande2 = $op2; $resultatf = $res;
				 if(($operande1==$partie2 || $operande2==$partie2))
				 {
				   $colonne2=0;$colonne3=9;$colonne4=0;$etape1=true;$etape=true;
				 }
				 if(($question='t')and(!$etape1)and($operande1==$partie3 || $operande2==$partie3))
				 {
				   $colonne6=0;$colonne7=9;$colonne8=0;$etape2=true;$etape_2=true;
				 }
				 else if(($question='p')and($operande1==$tout2))
				 {
				   $colonne6=0;$colonne7=9;$colonne8=0;$etape2=true;$etape_2=true;
				 }


			 $resultat_compf = abs(calcul($operande1,$op,$operande2));
			 $etape3 = true ;$colonne16=1;
			}
  else if (($op1.$op.$op2."=".$res)and(!$difference) and (count($tabOperation)>1)and(count($T1)==1)and(!isset($tabImp)))
   		   {
			 $colonne14=5;
				 if ($colonne15==8)
				 	$colonne15=8;
				 else if (($op == '+') and ($addTrou))
					{
						$colonne15=1; 
						if (($op1.$op.$op2."=".$res)==($op1."+".$valdiff."=".$res)) 
						 	{ 
							  $colonne14=3;
							  if($etape_2) $colonne1=7 ;
							}
					}
				 else if ($op == '+')
				 {
					$colonne15=4;
				 	if($etape1 and $etape_2 and $colonne2==4 and $colonne3==1)
					{
						$colonne2=9;$colonne3=9;$colonne4=9;
					}
				 }
				 else if (($op == '-')and($op1<$op2))
					 $colonne15=3; 
				 else if ($op == '-')
					 {
					 $colonne15=2;
					 if (count($tabOperation)==$finc+1)
						 {
							$colonne6=9; $colonne7=9; $colonne8=9; $etape_2=false ;
						 }
					 }
				 
			 $operande1 = $op1; $operande2 = $op2; $resultatf = $res;
			 $resultat_compf = abs(calcul($operande1,$op,$operande2));
			 $etape3 = true ;
			 if (($operande1==$partie1 and $operande2==$valdiff) || ($operande1==$valdiff and $operande2==$partie1))
				 $colonne16=4;
			 else $colonne16=1;
			}
	else if (($op1.$op.$op2."=".$res) and ($op == '-')and($op1<$op2))
	{
	 $colonne14=5; $colonne15=3;
	 $operande1 = $op1; $operande2 = $op2; $resultatf = $res;
	 $resultat_compf = abs(calcul($operande1,$op,$operande2));
	 $etape3 = true ; $colonne16=1;$NonPertinent=true;
	}
 else if (isset($tabImp) and (count($tabImp)!=0)and(count($tabOperation)==0)and(!ereg("$partie2|$partie3|$tout2",end($tabImp))))
 		{
		 $colonne14=0;$colonne15=0;$colonne16=8; $colonne17 = 8; $imp3=true; $colonne1=6;
		}
 else if ((count($tabOperation)==1)and(($resultat!=end($tabNombre) and $etape) and !ereg("1|7|8",$colonne2)||($resultatc!=end($tabNombre) and $etape2  and !ereg("1|7|8",$colonne6))))
 		{
		 //print_r($tabImp);
		 $colonne14=0;$colonne15=0;
		 if(($question=="t" and end($tabImp)==$tout2)||($question=="p" and end($tabImp)==$partie3))
		 {  
		 	if(!$etape1 and $tabImp[0]!=$partie2)
			{
				$etape=true; 
				$colonne2=0;$colonne3=9;$colonne4=1;
			}
			$colonne16=9; $colonne17=0; 
		}
		 else
		{
		 $tabImp[]=end($tabNombre); $colonne16=8; $colonne17=8;
		}
	}

//print("<br>colonne14=".$colonne14."  colonne15=".$colonne15."  colonne16=".$colonne16."  colonne17=".$colonne17."<br>");

 /*================= colonne 16 pertinence des données de l'operation ==============*/
	 if (isset($colonne16) and $colonne16==4)
	 	{$colonne16=4;}
	 else if (isset($colonne16) and $colonne16==8)
	 	{$colonne16=8;}
	 else if (isset($colonne16) and $colonne16==9 and $colonne14==0)
		 {$colonne16=9;}
	 else if (isset($colonne16) and $colonne16==1)
	 	{$colonne16=1;}
	 else if (isset($colonne16) and $colonne16==0)
	 	{$colonne16=0;}
	 else if ($colonne7==1)
	 {
		 $colonne16=5;
	 }
	 else if ((($colonne4 == 1)||($colonne8 == 1)||($colonne12 == 1))and(!$imp3))
	  {
		 $colonne16=2;
	  }
	 else if ((($colonne4==2)||($colonne8==2)||($colonne12==2))and(!$imp3))
	  {
		$colonne16=3;
	  }

	 else if (($colonne14 == 9)||($colonne14 == 0))
	  {
		$colonne16=9;
	  }
	 else if (($etape3 and $question =="t" )and((($operande1==$partie2)and($operande2==$partie3))||(($operande1==$partie3)and($operande2==$partie2))))
	  {
	  	$colonne16=0;
	  }
	  else if (($etape3 and $question =="p" )and((($operande1==$tout2)and($operande2==$partie2))||(($operande1==$partie2)and($operande2==$tout2))))
	  {
	  	$colonne16=0;
	  }
	 else if (($partie3)and
	 ((($operande1==$resultatc)xor($operande2==$resultat))||(($operande1==$resultat)xor($operande2==$resultatc))))
	  {
	  	$colonne16=1;
	  }
	else if ($partie3 and $resultatc and $resultatc)
	  {
	  	$colonne16=1;
	  }

/* --------------  cas d'une opartation a trois operande -----------------------*/
if (count($tabOperation2 >= 1))
{
if (count ($T1) == 2 )
{

	$op1 = $T2[0]; $op2 = $T2[1]; $op3 = $T2[2] ; $res = $T2[3];
	$op = $T1[0];$oper = $T1[1];
	if ($T2[3]!="")
	//print ("<br>l'operation est : ".$op1.$op.$op2.$oper.$op3."=".$res."<br>"); /* revoir ce cas pour les OR */
	if (($T1[0]=="+")and($T1[1]=="+")and((in_array($partie1,$T2))and(in_array($tout1,$T2))and(in_array($valdiff,$T2))))
	{
	 $colonne1=4; $colonne14=5; $colonne15 = 5; $colonne16=1;
	 //$etape=false; $etape1=false; $difference=false; $etape2 = false ;$etape3=false;
	 $operande1 = $op1; $operande2 = $op2; $operande3 = $op3; $resultatf = $res;
	 $resultat_compf = $op1+$op2+$op3;$NonPertinent=true;
	}
	else if
	(($T1[0]=="+")and($T1[1]=="+"))
	{
	 //print (" colonne 14 = 5  colonne15 = 5 ");
	 $colonne1=4;$colonne2=9;$colonne3=9;$colonne4=9;$colonne5=9;$colonne6=9;$colonne7=9;
	 $colonne8=9;$colonne9=9;$colonne10=9;$colonne11=9;$colonne12=9;$colonne13=9;
	 $colonne14=5; $colonne15=8;$colonne16=1;
		 if(in_array($partie2,$T2))
		 {$colonne2=0;$colonne3=9;$colonne4=0;$etape=true;$etape1=true;}
		 else if(((in_array($partie3,$T2))and($question=='t'))||((in_array($tout2,$T2))and($question=='p')))
		 {$colonne6=0;$colonne3=7;$colonne8=0;$etape2=true;$etape_2=true;}
	 $operande1 = $op1; $operande2 = $op2; $operande3 = $op3; $resultatf = $res;
	 $resultat_compf = $op1+$op2+$op3;
	}
	else if ((($question=='t')and(($T1[0]=="*")and($T1[1]=="*")and(in_array($partie1,$T2))and(in_array($tout1,$T2))and(in_array($valdiff,$T2))))||
	(($question=='p')and(($T1[0]=="*")and($T1[1]=="*")and(in_array($partie1,$T2))and(in_array($tout1,$T2))and(in_array($valdiff,$T2)))))
	{
	 //print (" colonne 14 = 5  colonne15 = 5 ");
	 $colonne1=4;$colonne2=9;$colonne3=9;$colonne4=9;$colonne5=9;$colonne6=9;$colonne7=9;
	 $colonne8=9;$colonne9=9;
	 $colonne14=5; $colonne15=6;$colonne16=1;$NonPertinent=true;
	 $operande1 = $op1; $operande2 = $op2; $operande3 = $op3; $resultatf = $res;
	 $resultat_compf = $op1*$op2*$op3;
	}
	else if ((($question='t')and(($op1.$op.$op2.$oper.$op3."=".$res) == ($partie1."-".$valdiff."+".$resultat."=".$res)||
								 ($op1.$op.$op2.$oper.$op3."=".$res) == ($partie1."-".$valdiff."+".$partie2."=".$res)||
								 ($op1.$op.$op2.$oper.$op3."=".$res) == ($resultat."+".$partie1."-".$valdiff."=".$res)||
								 ($op1.$op.$op2.$oper.$op3."=".$res) == ($partie2."+".$partie1."-".$valdiff."=".$res)))
		   ||(($question='p')and(($op1.$op.$op2.$oper.$op3."=".$res) == ($tout1."-".$valdiff."-".$resultat."=".$res)||
		   						 ($op1.$op.$op2.$oper.$op3."=".$res) == ($tout1."-".$valdiff."-".$partie2."=".$res))))
	{
	 $colonne1=1;$colonne6=2;$colonne7=0;$colonne8=9;$colonne14=5;$colonne15=6;$colonne16=0;
	 $etape=false; $etape1=true; $difference=false; $etape2 = true ;
	 $operande1 = $op1; $operande2 = $op2; $operande3 = $op3; $resultatf = $res;
	 switch($op)
		 {
		 case "+" : if($oper=="-")
						$resultat_compf = $op1+$op2-$op3;
					break;
		 case "-" : if($oper=="+")
						$resultat_compf = $op1-$op2+$op3;
					else if($oper=="-")
						$resultat_compf = $op1-$op2-$op3;
					break;
		 }
	}
	
	else if (($T1[0]=="-")and($T1[1]=="-")and((in_array($partie1,$T2))and (in_array($tout1,$T2))and(in_array($valdiff,$T2))))
	{
	 $colonne1=4; $colonne14=5; $colonne15=52; $colonne16=0;//soustraction de tous les termes de l'énoncé
	 $etape=false; $etape1=false; $difference=false; $etape2 = false ;$etape3=false;$NonPertinent=true;
	 $operande1 = $op1; $operande2 = $op2; $operande3 = $op3; $resultatf = $res;
	 $resultat_compf = $op1-$op2-$op3;
	}
	
	else if (($T1[0]=="+")and($T1[1]=="-")and((in_array($partie1,$T2))and (in_array($tout1,$T2))and(in_array($valdiff,$T2))))
	{
	 $colonne1=4; $colonne14=5; $colonne15=6; $colonne16=0;
	 $etape=false; $etape1=false; $difference=false; $etape2 = false ;$etape3=false;$NonPertinent=true;
	 $operande1 = $op1; $operande2 = $op2; $operande3 = $op3; $resultatf = $res;
	 $resultat_compf = $op1+$op2-$op3;
	}
}
else if ((count($T1)==3 || count($T1)==4)and(end($tabOperation2)==$operation_f))
	{
	 $colonne1=4; $colonne2=9; $colonne3=9; $colonne4=9; $colonne14=5; $colonne15=8; $colonne16=1;
	 $etape=false; $etape1=false; $difference=false; $etape2 = false ;$etape3=false;$NonPertinent=true;
	 $resultatf = end($T2);
     if ($T1[0]=="+")  $resultat_compf = $T2[0] + $T2[1];  else if($T1[0]=="-") $resultat_compf = $T2[0]- $T2[1];
	 if ($T1[1]=="+")  $resultat_compf =  $resultat_compf + $T2[2];	 else if($T1[1]=="-") $resultat_compf =  $resultat_compf- $T2[2];
	 if ($T1[2]=="+")  $resultat_compf =  $resultat_compf + $T2[3];	 else if($T1[2]=="-") $resultat_compf =  $resultat_compf - $T2[3];
	 if ($T1[3]=="+")  $resultat_compf =  $resultat_compf + $T2[4];  else if($T1[3]=="-") $resultat_compf =  $resultat_compf - $T2[4];
	}

	if (count($tabOperation)>=2 and count($tabOperation2)==1)
	{
		if (isset($colonne14) and ereg("[1-7]",$colonne14))
		{
			if (end($tabOperation2)==$tabOperation[0])
				{
					$str=$tabSR[0];
					$res=$tabR[0];
					$pat1 = "/\d+/";$pat2 = "/\+|-|\*|:]/";
					
					//tableau des opérandes : uniquement l'opération finale
					preg_match_all($pat1,$str,$tabOperande);
					$tabOper = $tabOperande[0];
					preg_match_all($pat2,$str,$tabOperateur);
					$tabOperateur = $tabOperateur[0];
					//print_r($tabOper);print_r($tabOperateur);
					$resOp = calcul2($tabOperateur,$tabOper);
					if ($resOp==$res) 
						$colonne4=0;
					else if ($resOp!=$res)   
						$colonne4=1;
					if (in_array($partie1, $tabOper) and in_array($tout1, $tabOper) and in_array($valdiff, $tabOper))
					{
						$colonne2=61; $colonne3=2;	
					}
					else 
						{
							$colonne2=61; $colonne3=2;	
						}
				}
		}
	}
}
/*--------------------------fin if (count($tabOperation2 >= 1))---------------------------*/
/*=============== colonne 17 exactitude du resultat du calcul =================*/

if ((!$diff)and(!$imp3))
{
	if (((($colonne15 == 9)and($colonne14!=0))||($resultatf==''))and (!(ereg("[0-8]",$colonne17))))
		{
			//print(" colonne17 = 9 ");
			$colonne17=9;
		}
	else if ($colonne17==8)
		{
			$colonne17=8;
		}
	else if (isset($resultatf) and ($resultatf == $resultat_compf))
		{
			$colonne17=0;
		}
	 else if (isset($resultatf) and (($resultatf == $resultat_compf-1)||($resultatf == $resultat_compf+1)))
		{
			//print(" colonne17 = 1 ");
			$colonne17=1;
		}
	 else if (isset($resultatf) and (($resultatf < $resultat_compf-1) ||($resultatf > $resultat_compf-1)))
		{
			//print(" colonne17 = 2 ");
			$colonne17=2;
		}
} 
else if ($diff and  isset($resultatf))
{
	if ($resultatf == $resultat_compf)
		{
			//print(" colonne17 = 0 ");
			$colonne17=0;
		}
	 else if (($resultatf == $resultat_compf-1)||($resultatf == $resultat_compf+1))
		{
			//print(" colonne17 = 1 ");
			$colonne17=1;
		}
	 else if (($resultatf < $resultat_compf-1) ||($resultatf > $resultat_compf-1))
		{
			//print(" colonne17 = 2 ");
			$colonne17=2;
		}
}
//cas ou il y a plusieurs opérations qui n'ont pas de place dans le codage colonne14=51
 if(($colonne14=='5') and (ereg("[1-7]",$colonne2)) and (ereg("[1-7]",$colonne6)) and (count($tabOperation)-1>2)) 
{
$colonne14=51;
}
else if(($colonne14=='5') and (ereg("[1-7]",$colonne2)) and (!ereg("[1-7]",$colonne6)) and ((count($tabOperation)-1)==2)) 
{
$colonne14=51;
}
else if(($colonne14=='5') and (!ereg("[1-7]",$colonne2))and (ereg("[1-7]",$colonne6)) and (count($tabOperation)-1==2)) 
{
$colonne14=51;
}

/*----------------- coder la stategie colonne 1 -----------------------*/
if (!isset($imp1)) $imp1=false;
if (!isset($imp2)) $imp2=false;
if (!isset($imp3)) $imp3=false;
if (!isset($arretc)) $arretc=false;
if((!$etape)and($etape_2)and($etape3)and(($colonne1=='7')||($colonne14=='4')||(($colonne14=='5'||$colonne14=='51')||(ereg("[5-8]",$colonne15)))))
{
	//print(" colonne1 = 7 ");
    $colonne1=7;
}
else if ((($imp1 and $imp2 and $imp3) ||(!($etape) and $imp2 and $imp3 )||(!($etape) and !($imp2) and ($imp3 and $etape3)))and (count($tabOperation)==0))//||($imp1 and !($imp2) and $imp3)
{
	//print(" colonne1 = 5 ");
	$colonne1=1;	
    if(($question=='t' and $tabImp[0]==$tout2)||($question=='p' and $tabImp[0]==$partie3))
	{
		$colonne1=5;
	}
}
else if ($colonne1==6)
{
	$colonne1=6;
}
else if (($etape) and ($diff) and (!$arretc))
{
	//print(" colonne1 = 3 ");
    $colonne1=3;
}
else if ($NonPertinent)
{
	$colonne1=4;
}
else if (($etape)||($etape1))//||($etape_2)||($etape3))
 {
 	//print(" colonne1 = 1 ");
    $colonne1=1;
 }
else if (($diff)and(!$etape))
 {
 	//print(" colonne1 = 2 ");
    $colonne1=2;
 }
else if (count($tabNombre)==0)
{
	//print(" colonne1 = 9 ");
    $colonne1=9;
}
else if (($arretc) and (!$etape))
{
	print(" colonne1 = 4 "); $colonne1=4;
}
else
{
	//print(" colonne1 = 4 ");
    $colonne1=4;
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

if (!isset($colonne1) || !(ereg("[0-7]",$colonne1))) 
{for ($i=1;$i<=18;$i++) ${"colonne".$i}=9;}
if (!isset($colonne2) || !(ereg("[0-8]",$colonne2))) $colonne2=9;
if (!isset($colonne3) || !(ereg("[0-8]",$colonne3))) $colonne3=9;
if (!isset($colonne4) || !(ereg("[0-8]",$colonne4))) $colonne4=9;
if (!isset($colonne5) || !(ereg("[0-7]",$colonne5))) $colonne5=9;
if (!isset($colonne6) || !(ereg("[0-7]",$colonne6))) $colonne6=9;
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
/*print("<br>colonne1=".$colonne1." | colonne2=".$colonne2." | colonne3=".$colonne3.
			 " | colonne4=".$colonne4." | colonne6=".$colonne6." | colonne7=".$colonne7.
			 " | colonne8=".$colonne8." | colonne14=".$colonne14." | colonne15=".$colonne15.
			 " | colonne16=".$colonne16." | colonne17=".$colonne17." | colonne18=".$colonne18."<br>"); */
//exit ("ok");
$typeExo="a";
//$text = str_replace("'","\'",$text);
$text=addslashes($text);
/*_____________________________________________________________________________________*/
$Requete_SQL = "INSERT INTO trace (numEleve,numSerie,numExo,typeExo,questInt,sas ,choix,
				operation1, operation2, operande1, operande2,operande3,zonetext,resultat,actions) VALUES
				('".$_SESSION['numEleve']."','".$numSerie."','".$n."','".$typeExo."','".$questi."','".$sas."','".$choix."',
				'".$oper_1."','".$oper_2."','".$op_1."','".$op_2."','".$op_3."','".$text."','".$_POST['resultat1']."','".$_POST['Trace']."')";
// Execution de la requete SQL.
$result = mysql_query($Requete_SQL) or die("Erreur d'Insertion dans la base : ". $Requete_SQL .'<br />'. mysql_error());
$Requete_SQL3 = "select id from trace order by id desc limit 1";
$result3 = mysql_query($Requete_SQL3) or die("Erreur d'Insertion dans la base : ". $Requete_SQL3 .'<br />'. mysql_error());
while ($r = mysql_fetch_assoc($result3))
			{
			$id = $r["id"];
			}
/* _____________________________________________________________________________________ */

$Requete_SQL2 = "INSERT INTO diagnostic (numSerie,numTrace,numEleve,date,numExo,typeExo,question,var ,questInt,
				colonne1, colonne2, colonne3, colonne4,colonne5,colonne6, colonne7, colonne8, colonne9,colonne10,
				colonne11,colonne12,colonne13,colonne14,colonne15,colonne16,colonne17,colonne18,nbOper) VALUES
				('".$numSerie."','".$id."','".$_SESSION['numEleve']."','".$date."','".$n."','".$typeExo."','".$question."','".$var."','".$questi."',
				$colonne1,$colonne2,$colonne3,$colonne4,$colonne5, $colonne6,$colonne7,$colonne8,$colonne9,$colonne10,
				$colonne11,$colonne12,$colonne13,$colonne14,$colonne15,$colonne16,$colonne17,$colonne18,$nbOper)";
// Execution de la requete SQL.
$result = mysql_query($Requete_SQL2) or die("Erreur d'Insertion dans la base : ". $Requete_SQL2 .'<br />'. mysql_error());

 //mysql_close($BD_link);
?>
<?php
/* ---------------------------------------------------------------------------- */
 define("FORMAT_REEL",   1); // #,##0.00
define("FORMAT_ENTIER", 2); // #,##0
define("FORMAT_TEXTE",  3); // @

$cfg_formats[FORMAT_ENTIER] = "FF0";
$cfg_formats[FORMAT_REEL]   = "FF2";
$cfg_formats[FORMAT_TEXTE]  = "FG0";

// ----------------------------------------------------------------------------

/* $cfg_hote = 'localhost';
$cfg_user = 'root';
$cfg_pass = '';
$cfg_base = 'projet';
 */
// ----------------------------------------------------------------------------

//if (mysql_connect($BD_hote, $BD_user, $BD_pass))
//{
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
      Array( 'typeExo', 'Type EXO', FORMAT_TEXTE,  'L',        10 ),
      Array( 'question',    'Question',   FORMAT_TEXTE,  'L',        10 ),
      Array( 'var',   'Variable',   FORMAT_TEXTE,  'L',        10 ),
	  Array( 'questInt',   'Question Int',   FORMAT_ENTIER,  'L',       10 ),
	  Array( 'colonne1',   'Colonne 1',   FORMAT_ENTIER,  'L',        10 ),
  	  Array( 'colonne2',   'Colonne 2',   FORMAT_ENTIER,  'L',        10 ),
	  Array( 'colonne3',   'Colonne 3',   FORMAT_ENTIER,  'L',        10 ),
	  Array( 'colonne4',   'Colonne 4',   FORMAT_ENTIER,  'L',        10 ),
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


    if ($resultat = mysql_db_query($BD_base, $sql))
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
    //creation du fichier
	$fichier="diag/".$_SESSION['nom'].$_SESSION['numEleve'].".slk";
	$fp = fopen ("$fichier", "w");
	//enregistre les données dans le fichier
	fputs($fp, "$x");
	fclose ($fp);
    mysql_close();
//}
?>
<?php
	echo "<script type='text/javascript'>location.href='interfaceIE.php?lienRetour=oui&numSerie=".$_SESSION['numSerie']."&nbExo=".$nbExo."&numExo=".$numExo."';</script>";
?>