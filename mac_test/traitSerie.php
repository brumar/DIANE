 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php 
$i=$_POST['i'];//nombre d'exercice de complement existant
$j=$_POST['j'];//nombre d'exercice de comparaison existant
$m=$_POST['m'];//nombre d'exercice de distributivite existant
$u=$_POST['k'];//nombre d'exercice etape existant
$t=$_POST['t'];//nombre d'exercice génériques existant

/* initialisation des compteurs nb_a et nb_e et nb_d*/
$nb_a=0; 
$nb_e=0;
$nb_d=0;
$nb_etape=0;
$nbExo=0;
$nb_pbm=0;
for($k=1;$k<=$i;$k++)
{
switch($_POST["choix_e".$k])
	{
	case "1" ://print("exo1_e <br>");
			  $exo1 = $_POST["select_e".$k];
			  $type1 = 'e'; $nb_e++;
			  if (isset($_POST["questi_e".$k]) and $_POST["questi_e".$k]=="on")
				$questi1='1';
			  else
				$questi1='0';
			  break;
	
	case "2" ://print("exo2_e <br>");
			  $exo2 = $_POST["select_e".$k];
			  $type2 = 'e';$nb_e++;
			  if (isset($_POST["questi_e".$k]) and $_POST["questi_e".$k]=="on")
				$questi2='1';
			  else
				$questi2='0';
			  break;
	case "3" ://print("exo3_e <br>");
			  $exo3 = $_POST["select_e".$k];
			  $type3 = 'e';$nb_e++;
			  if (isset($_POST["questi_e".$k]) and $_POST["questi_e".$k]=="on")
				$questi3='1';
			  else
				$questi3='0';
			  break;
	case "4" ://print("exo4_e <br>");
			  $exo4 = $_POST["select_e".$k];
			  $type4 = 'e';$nb_e++;
			  if (isset($_POST["questi_e".$k]) and $_POST["questi_e".$k]=="on")
				$questi4='1';
			  else
				$questi4='0';
			  break;
	case "5" ://print("exo5_e <br>");
			 $exo5 = $_POST["select_e".$k];
			  $type5 = 'e';$nb_e++;
			  if (isset($_POST["questi_e".$k]) and $_POST["questi_e".$k]=="on")
				$questi5='1';
			  else
				$questi5='0';
			  break;
	case "6" ://print("exo6_e <br>");
			  $exo6 = $_POST["select_e".$k];
			  $type6 = 'e';$nb_e++;
			  if (isset($_POST["questi_e".$k]) and $_POST["questi_e".$k]=="on")
				$questi6='1';
			  else
				$questi6='0';
			  break;
	case "7" ://print("exo7_e <br>");
			  $exo7 = $_POST["select_e".$k];
			  $type7 = 'e';$nb_e++;
			  if (isset($_POST["questi_e".$k]) and $_POST["questi_e".$k]=="on")
				$questi7='1';
			  else
				$questi7='0';
			  break;
	case "8" ://print("exo8_e <br>");
			  $exo8 = $_POST["select_e".$k];
			  $type8 = 'e';$nb_e++;
			  if (isset($_POST["questi_e".$k]) and $_POST["questi_e".$k]=="on")
				$questi8='1';
			  else
				$questi8='0';
			  break;
	case "9" ://print("exo9_e <br>");
			  $exo9 = $_POST["select_e".$k];
			  $type9 = 'e';$nb_e++;
			  if (isset($_POST["questi_e".$k]) and $_POST["questi_e".$k]=="on")
				$questi9='1';
			  else
				$questi9='0';
			  break;
	case "10" ://print("exo10_e <br>");
			  $exo10 = $_POST["select_e".$k];
			  $type10 = 'e';$nb_e++;
			  if (isset($_POST["questi_e".$k]) and $_POST["questi_e".$k]=="on")
				$questi10='1';
			  else
				$questi10='0';
			  break;
	case "11" ://print("exo11_e <br>");
			  $exo11 = $_POST["select_e".$k];
			  $type11 = 'e';$nb_e++;
			  if (isset($_POST["questi_e".$k]) and $_POST["questi_e".$k]=="on")
				$questi11='1';
			  else
				$questi11='0';
			  break;
	case "12" ://print("exo12_e <br>");
			  $exo12 = $_POST["select_e".$k];
			  $type12 = 'e';$nb_e++;
			  if (isset($_POST["questi_e".$k]) and $_POST["questi_e".$k]=="on")
				$questi12='1';
			  else
				$questi12='0';
			  break;
	case "13" ://print("exo13_e <br>");
			  $exo13 = $_POST["select_e".$k];
			  $type13 = 'e';$nb_e++;
			  if (isset($_POST["questi_e".$k]) and $_POST["questi_e".$k]=="on")
				$questi13='1';
			  else
				$questi13='0';
			  break;
	case "14" ://print("exo14_e <br>");
				$exo14 = $_POST["select_e".$k];
			  $type14 = 'e';$nb_e++;
			  if (isset($_POST["questi_e".$k]) and $_POST["questi_e".$k]=="on")
				$questi14='1';
			  else
				$questi14='0';
			  break;
	case "15" ://print("exo15_e <br>");
				$exo15 = $_POST["select_e".$k];
			  $type15 = 'e';$nb_e++;
			  if (isset($_POST["questi_e".$k]) and $_POST["questi_e".$k]=="on")
				$questi15='1';
			  else
				$questi15='0';
			  break;
	case "16" ://print("exo16_e <br>");
			  $exo16 = $_POST["select_e".$k];
			  $type16 = 'e';$nb_e++;
			  if (isset($_POST["questi_e".$k]) and $_POST["questi_e".$k]=="on")
				$questi16='1';
			  else
				$questi16='0';
			  break;
	case "17" ://print("exo17_e <br>");
			  $exo17 = $_POST["select_e".$k];
			  $type17 = 'e';$nb_e++;
			  if (isset($_POST["questi_e".$k]) and $_POST["questi_e".$k]=="on")
				$questi17='1';
			  else
				$questi17='0';
			  break;
	case "18" ://print("exo18_e <br>");
			   $exo18 = $_POST["select_e".$k];
			  $type18 = 'e';$nb_e++;
			  if (isset($_POST["questi_e".$k]) and $_POST["questi_e".$k]=="on")
				$questi18='1';
			  else
				$questi18='0';
			  break;
	case "19" ://print("exo19_e <br>");
			   $exo19 = $_POST["select_e".$k];
			  $type19 = 'e';$nb_e++;
			  if (isset($_POST["questi_e".$k]) and $_POST["questi_e".$k]=="on")
				$questi19='1';
			  else
				$questi19='0';
			  break;
	case "20" ://print("exo20_e <br>");
			  $exo20 = $_POST["select_e".$k];
			  $type20 = 'e';$nb_e++;
			  if (isset($_POST["questi_e".$k]) and $_POST["questi_e".$k]=="on")
				$questi20='1';
			  else
				$questi20='0';
			  break;
	case "21" ://print("exo21_e <br>");
			  $exo21 = $_POST["select_e".$k];
			  $type21 = 'e';$nb_e++;
			  if (isset($_POST["questi_e".$k]) and $_POST["questi_e".$k]=="on")
				$questi21='1';
			  else
				$questi21='0';
			  break;
	case "22" ://print("exo22_e <br>");
			  $exo22 = $_POST["select_e".$k];
			  $type22 = 'e';$nb_e++;
			  if (isset($_POST["questi_e".$k]) and $_POST["questi_e".$k]=="on")
				$questi22='1';
			  else
				$questi22='0';
			  break;
	case "23" ://print("exo23_e <br>");
			  $exo23 = $_POST["select_e".$k];
			  $type23 = 'e';$nb_e++;
			  if (isset($_POST["questi_e".$k]) and $_POST["questi_e".$k]=="on")
				$questi23='1';
			  else
				$questi23='0';
			  break;
	case "24" ://print("exo24_e <br>");
			  $exo24 = $_POST["select_e".$k];
			  $type24 = 'e';$nb_e++;
			  if (isset($_POST["questi_e".$k]) and $_POST["questi_e".$k]=="on")
				$questi24='1';
			  else
				$questi24='0';
			  break;
	}
}

for($l=1;$l<=$j;$l++)
{
switch($_POST["choix_a".$l])
	{
	case "1" ://print("exo1_a <br>");
			  $exo1 = $_POST["select_a".$l];
			  $type1 = 'a';$nb_a++;
			  if (isset($_POST["questi_a".$l]) and $_POST["questi_a".$l]=="on")
				$questi1='1';
			  else
				$questi1='0';
			  break;
	
	case "2" ://print("exo2_a <br>");
			  $exo2 = $_POST["select_a".$l];
			  $type2 = 'a';$nb_a++;
			  if (isset($_POST["questi_a".$l]) and $_POST["questi_a".$l]=="on")
				$questi2='1';
			  else
				$questi2='0';
			  break;
	case "3" ://print("exo3_a <br>");
			  $exo3 = $_POST["select_a".$l];
			  $type3 = 'a';$nb_a++;
			  if (isset($_POST["questi_a".$l]) and $_POST["questi_a".$l]=="on")
				$questi3='1';
			  else
				$questi3='0';
			  break;
	case "4" ://print("exo4_a <br>");
			  $exo4 = $_POST["select_a".$l];
			  $type4 = 'a'; $nb_a++;
			  if (isset($_POST["questi_a".$l]) and $_POST["questi_a".$l]=="on")
				$questi4='1';
			  else
				$questi4='0';
			  break;
	case "5" ://print("exo5_a <br>");
			 $exo5 = $_POST["select_a".$l];
			  $type5 = 'a'; $nb_a++;
			  if (isset($_POST["questi_a".$l]) and $_POST["questi_a".$l]=="on")
				$questi5='1';
			  else
				$questi5='0';
			  break;
	case "6" ://print("exo6_a <br>");
			  $exo6 = $_POST["select_a".$l];
			  $type6 = 'a'; $nb_a++;
			  if (isset($_POST["questi_a".$l]) and $_POST["questi_a".$l]=="on")
				$questi6='1';
			  else
				$questi6='0';
			  break;
	case "7" ://print("exo7_a <br>");
			  $exo7 = $_POST["select_a".$l];
			  $type7 = 'a'; $nb_a++;
			  if (isset($_POST["questi_a".$l]) and $_POST["questi_a".$l]=="on")
				$questi7='1';
			  else
				$questi7='0';
			  break;
	case "8" ://print("exo8_a <br>");
			  $exo8 = $_POST["select_a".$l];
			  $type8 = 'a'; $nb_a++;
			  if (isset($_POST["questi_a".$l]) and $_POST["questi_a".$l]=="on")
				$questi8='1';
			  else
				$questi8='0';
			  break;
	case "9" ://print("exo9_a <br>");
			  $exo9 = $_POST["select_a".$l];
			  $type9 = 'a'; $nb_a++;
			  if (isset($_POST["questi_a".$l]) and $_POST["questi_a".$l]=="on")
				$questi9='1';
			  else
				$questi9='0';
			  break;
	case "10" ://print("exo10_a <br>");
			  $exo10 = $_POST["select_a".$l];
			  $type10 = 'a'; $nb_a++;
			  if (isset($_POST["questi_a".$l]) and $_POST["questi_a".$l]=="on")
				$questi10='1';
			  else
				$questi10='0';
			  break;
	case "11" ://print("exo11_a <br>");
			  $exo11 = $_POST["select_a".$l];
			  $type11 = 'a'; $nb_a++;
			  if (isset($_POST["questi_a".$l]) and $_POST["questi_a".$l]=="on")
				$questi11='1';
			  else
				$questi11='0';
			  break;
	case "12" ://print("exo12_a <br>");
			  $exo12 = $_POST["select_a".$l];
			  $type12 = 'a'; $nb_a++;
			  if (isset($_POST["questi_a".$l]) and $_POST["questi_a".$l]=="on")
				$questi12='1';
			  else
				$questi12='0';
			  break;
	case "13" ://print("exo13_a <br>");
			  $exo13 = $_POST["select_a".$l];
			  $type13 = 'a'; $nb_a++;
			  if (isset($_POST["questi_a".$l]) and $_POST["questi_a".$l]=="on")
				$questi13='1';
			  else
				$questi13='0';
			  break;
	case "14" ://print("exo14_a <br>");
				$exo14 = $_POST["select_a".$l];
			  $type14 = 'a'; $nb_a++;
			  if (isset($_POST["questi_a".$l]) and $_POST["questi_a".$l]=="on")
				$questi14='1';
			  else
				$questi14='0';
			  break;
	case "15" ://print("exo15_a <br>");
				$exo15 = $_POST["select_a".$l];
			  $type15 = 'a'; $nb_a++;
			  if (isset($_POST["questi_a".$l]) and $_POST["questi_a".$l]=="on")
				$questi15='1';
			  else
				$questi15='0';
			  break;
	case "16" ://print("exo16_a <br>");
			  $exo16 = $_POST["select_a".$l];
			  $type16 = 'a'; $nb_a++;
			  if (isset($_POST["questi_a".$l]) and $_POST["questi_a".$l]=="on")
				$questi16='1';
			  else
				$questi16='0';
			  break;
	case "17" ://print("exo17_a <br>");
			  $exo17 = $_POST["select_a".$l];
			  $type17 = 'a'; $nb_a++;
			  if (isset($_POST["questi_a".$l]) and $_POST["questi_a".$l]=="on")
				$questi17='1';
			  else
				$questi17='0';
			  break;
	case "18" ://print("exo18_a <br>");
			   $exo18 = $_POST["select_a".$l];
			  $type18 = 'a'; $nb_a++;
			  if (isset($_POST["questi_a".$l]) and $_POST["questi_a".$l]=="on")
				$questi18='1';
			  else
				$questi18='0';
			  break;
	case "19" ://print("exo19_a <br>");
			   $exo19 = $_POST["select_a".$l];
			  $type19 = 'a'; $nb_a++;
			  if (isset($_POST["questi_a".$l]) and $_POST["questi_a".$l]=="on")
				$questi19='1';
			  else
				$questi19='0';
			  break;
	case "20" ://print("exo20_a <br>");
			  $exo20 = $_POST["select_a".$l];
			  $type20 = 'a'; $nb_a++;
			  if (isset($_POST["questi_a".$l]) and $_POST["questi_a".$l]=="on")
				$questi20='1';
			  else
				$questi20='0';
			  break;
	case "21" ://print("exo21_a <br>");
			  $exo21 = $_POST["select_a".$l];
			  $type21 = 'a'; $nb_a++;
			  if (isset($_POST["questi_a".$l]) and $_POST["questi_a".$l]=="on")
				$questi21='1';
			  else
				$questi21='0';
			  break;
	case "22" ://print("exo22_a <br>");
			  $exo22 = $_POST["select_a".$l];
			  $type22 = 'a'; $nb_a++;
			  if (isset($_POST["questi_a".$l]) and $_POST["questi_a".$l]=="on")
				$questi22='1';
			  else
				$questi22='0';
			  break;
	case "23" ://print("exo23_a <br>");
			  $exo23 = $_POST["select_a".$l];
			  $type23 = 'a'; $nb_a++;
			  if (isset($_POST["questi_a".$l]) and $_POST["questi_a".$l]=="on")
				$questi23='1';
			  else
				$questi23='0';
			  break;
	case "24" ://print("exo24_a <br>");
			  $exo24 = $_POST["select_a".$l];
			  $type24 = 'a'; $nb_a++;
			  if (isset($_POST["questi_a".$l]) and $_POST["questi_a".$l]=="on")
				$questi24='1';
			  else
				$questi24='0';
			  break;
	}
}

for($n=1;$n<=$m;$n++)
{
	switch($_POST["choix_d".$n])
		{
		case "1" :$exo1 = $_POST["select_d".$n];
				  $type1 = 'd';$nb_d++;
				  break;
		
		case "2" :$exo2 = $_POST["select_d".$n];
				  $type2 = 'd';$nb_d++;
				  break;
		case "3" :$exo3 = $_POST["select_d".$n];
				  $type3 = 'd';$nb_d++;
				  break;
		case "4" : $exo4 = $_POST["select_d".$n];
				  $type4 = 'd'; $nb_d++;
				  break;
		case "5" :$exo5 = $_POST["select_d".$n];
				  $type5 = 'd'; $nb_d++;
				  break;
		case "6" :$exo6 = $_POST["select_d".$n];
				  $type6 = 'd'; $nb_d++;
				  break;
		case "7" :$exo7 = $_POST["select_d".$n];
				  $type7 = 'd'; $nb_d++;
				  break;
		case "8" :$exo8 = $_POST["select_d".$n];
				  $type8 = 'd'; $nb_d++;
				  break;
		case "9" :$exo9 = $_POST["select_d".$n];
				  $type9 = 'd'; $nb_d++;
				  break;
		case "10" :$exo10 = $_POST["select_d".$n];
				  $type10 = 'd'; $nb_d++;
				  break;
		case "11" :$exo11 = $_POST["select_d".$n];
				  $type11 = 'd'; $nb_d++;
				  break;
		case "12" :$exo12 = $_POST["select_d".$n];
				  $type12 = 'd'; $nb_d++;
				  break;
		case "13" :$exo13 = $_POST["select_d".$n];
				  $type13 = 'd'; $nb_d++;
				  break;
		case "14" :$exo14 = $_POST["select_d".$n];
				  $type14 = 'd'; $nb_d++;
				  break;
		case "15" :$exo15 = $_POST["select_d".$n];
				   $type15 = 'd'; $nb_d++;
				   break;
		case "16" :$exo16 = $_POST["select_d".$n];
				  $type16 = 'd'; $nb_d++;
				  break;
		case "17" :$exo17 = $_POST["select_d".$n];
				  $type17 = 'd'; $nb_d++;
				  break;
		case "18" :$exo18 = $_POST["select_d".$n];
				  break;
		case "19" :$exo19 = $_POST["select_d".$n];
				  $type19 = 'd'; $nb_d++;
				  break;
		case "20" :$exo20 = $_POST["select_d".$n];
				  $type20 = 'd'; $nb_d++;
				  break;
		case "21" :$exo21 = $_POST["select_d".$n];
				  $type21 = 'd'; $nb_d++;
				  break;
		case "22" :$exo22 = $_POST["select_d".$n];
				  $type22 = 'd'; $nb_d++;
				  break;
		case "23" :$exo23 = $_POST["select_d".$n];
				  $type23 = 'd'; $nb_d++;
				  break;
		case "24" :$exo24 = $_POST["select_d".$n];
				  $type24 = 'd'; $nb_d++;
				  break;
		}
}

for($p=1;$p<=$u;$p++)
{
	switch($_POST["choix_etape".$p])
		{
		case "1" :$exo1 = $_POST["select_etape".$p];
				  $type1 = 'et';$nb_etape++;
				  break;
		
		case "2" :$exo2 = $_POST["select_etape".$p];
				  $type2 = 'et';$nb_etape++;
				  break;
		case "3" :$exo3 = $_POST["select_etape".$p];
				  $type3 = 'et';$nb_etape++;
				  break;
		case "4" : $exo4 = $_POST["select_etape".$p];
				  $type4 = 'et'; $nb_etape++;
				  break;
		case "5" :$exo5 = $_POST["select_etape".$p];
				  $type5 = 'et'; $nb_etape++;
				  break;
		case "6" :$exo6 = $_POST["select_etape".$p];
				  $type6 = 'et'; $nb_etape++;
				  break;
		case "7" :$exo7 = $_POST["select_etape".$p];
				  $type7 = 'et'; $nb_etape++;
				  break;
		case "8" :$exo8 = $_POST["select_etape".$p];
				  $type8 = 'et'; $nb_etape++;
				  break;
		case "9" :$exo9 = $_POST["select_etape".$p];
				  $type9 = 'et'; $nb_etape++;
				  break;
		case "10" :$exo10 = $_POST["select_etape".$p];
				  $type10 = 'et'; $nb_etape++;
				  break;
		case "11" :$exo11 = $_POST["select_etape".$p];
				  $type11 = 'et'; $nb_etape++;
				  break;
		case "12" :$exo12 = $_POST["select_etape".$p];
				  $type12 = 'et'; $nb_etape++;
				  break;
		case "13" :$exo13 = $_POST["select_etape".$p];
				  $type13 = 'et'; $nb_etape++;
				  break;
		case "14" :$exo14 = $_POST["select_etape".$p];
				  $type14 = 'et'; $nb_etape++;
				  break;
		case "15" :$exo15 = $_POST["select_etape".$p];
				   $type15 = 'et'; $nb_etape++;
				   break;
		case "16" :$exo16 = $_POST["select_etape".$p];
				  $type16 = 'et'; $nb_etape++;
				  break;
		case "17" :$exo17 = $_POST["select_etape".$p];
				  $type17 = 'et'; $nb_etape++;
				  break;
		case "18" :$exo18 = $_POST["select_etape".$p];
				  break;
		case "19" :$exo19 = $_POST["select_etape".$p];
				  $type19 = 'et'; $nb_etape++;
				  break;
		case "20" :$exo20 = $_POST["select_etape".$p];
				  $type20 = 'et'; $nb_etape++;
				  break;
		case "21" :$exo21 = $_POST["select_etape".$p];
				  $type21 = 'et'; $nb_etape++;
				  break;
		case "22" :$exo22 = $_POST["select_etape".$p];
				  $type22 = 'et'; $nb_etape++;
				  break;
		case "23" :$exo23 = $_POST["select_etape".$p];
				  $type23 = 'et'; $nb_etape++;
				  break;
		case "24" :$exo24 = $_POST["select_etape".$p];
				  $type24 = 'et'; $nb_etape++;
				  break;
		}
}
echo($t);
for($p=1;$p<=$t;$p++)
{
	switch($_POST["choix_pbm".$p])
	{
		case "1" :$exo1 = $_POST["select_pbm".$p];
		$type1 = 'Gpbm';$nb_pbm++;
		
		break;

		case "2" :$exo2 = $_POST["select_pbm".$p];
		$type2 = 'Gpbm';$nb_pbm++;
		break;
		case "3" :$exo3 = $_POST["select_pbm".$p];
		$type3 = 'Gpbm';$nb_pbm++;
		break;
		case "4" : $exo4 = $_POST["select_pbm".$p];
		$type4 = 'Gpbm'; $nb_pbm++;
		break;
		case "5" :$exo5 = $_POST["select_pbm".$p];
		$type5 = 'Gpbm'; $nb_pbm++;
		break;
		case "6" :$exo6 = $_POST["select_pbm".$p];
		$type6 = 'Gpbm'; $nb_pbm++;
		break;
		case "7" :$exo7 = $_POST["select_pbm".$p];
		$type7 = 'Gpbm'; $nb_pbm++;
		break;
		case "8" :$exo8 = $_POST["select_pbm".$p];
		$type8 = 'Gpbm'; $nb_pbm++;
		break;
		case "9" :$exo9 = $_POST["select_pbm".$p];
		$type9 = 'Gpbm'; $nb_pbm++;
		break;
		case "10" :$exo10 = $_POST["select_pbm".$p];
		$type10 = 'Gpbm'; $nb_pbm++;
		break;
		case "11" :$exo11 = $_POST["select_pbm".$p];
		$type11 = 'Gpbm'; $nb_pbm++;
		break;
		case "12" :$exo12 = $_POST["select_pbm".$p];
		$type12 = 'Gpbm'; $nb_pbm++;
		break;
		case "13" :$exo13 = $_POST["select_pbm".$p];
		$type13 = 'Gpbm'; $nb_pbm++;
		break;
		case "14" :$exo14 = $_POST["select_pbm".$p];
		$type14 = 'Gpbm'; $nb_pbm++;
		break;
		case "15" :$exo15 = $_POST["select_pbm".$p];
		$type15 = 'Gpbm'; $nb_pbm++;
		break;
		case "16" :$exo16 = $_POST["select_pbm".$p];
		$type16 = 'Gpbm'; $nb_pbm++;
		break;
		case "17" :$exo17 = $_POST["select_pbm".$p];
		$type17 = 'Gpbm'; $nb_pbm++;
		break;
		case "18" :$exo18 = $_POST["select_pbm".$p];
		break;
		case "19" :$exo19 = $_POST["select_pbm".$p];
		$type19 = 'Gpbm'; $nb_pbm++;
		break;
		case "20" :$exo20 = $_POST["select_pbm".$p];
		$type20 = 'Gpbm'; $nb_pbm++;
		break;
		case "21" :$exo21 = $_POST["select_pbm".$p];
		$type21 = 'Gpbm'; $nb_pbm++;
		break;
		case "22" :$exo22 = $_POST["select_pbm".$p];
		$type22 = 'Gpbm'; $nb_pbm++;
		break;
		case "23" :$exo23 = $_POST["select_pbm".$p];
		$type23 = 'Gpbm'; $nb_pbm++;
		break;
		case "24" :$exo24 = $_POST["select_pbm".$p];
		$type24 = 'Gpbm'; $nb_pbm++;
		break;
	}
}

for($i=1;$i<=24;$i++)
{
	if (!isset(${"questi".$i}))
	{
		${"questi".$i}='';
	}
}

for($i=1;$i<=24;$i++)
{
	if (!isset(${"exo".$i}))
	{
		${"exo".$i}='';${"type".$i}="";${"questi".$i}='';
	}
}
$nbExo= $nb_a + $nb_e + $nb_d + $nb_etape + $nb_pbm;
require_once("conn.php");
$nomSerie = addslashes($_POST["nomSerie"]);
$commentaire = addslashes($_POST["commentaire"]);
echo($type1);
$Requete_SQL = "INSERT INTO serie (`nomSerie`, `commentaire`,nbExo, `exo1`, `type1`, `questi1`, `exo2`, `type2`, `questi2`, `exo3`, `type3`, `questi3`,
 `exo4`, `type4`, `questi4`, `exo5`, `type5`, `questi5`, `exo6`, `type6`, `questi6`, `exo7`, `type7`, `questi7`, 
 `exo8`, `type8`, `questi8`, `exo9`, `type9`, `questi9`, `exo10`, `type10`, `questi10`, `exo11`, `type11`, `questi11`, 
 `exo12`, `type12`, `questi12`, `exo13`, `type13`, `questi13`, `exo14`, `type14`, `questi14`, `exo15`, `type15`, `questi15`,
 `exo16`, `type16`, `questi16`, `exo17`, `type17`, `questi17`, `exo18`, `type18`, `questi18`, `questi19`, `exo19`, `type19`,
 `exo20`, `type20`, `questi20`, `exo21`, `type21`, `questi21`, `exo22`, `type22`, `questi22`, `exo23`, `type23`, `questi23`, 
 `exo24`, `type24`, `questi24`) VALUES 
 ('".$nomSerie."','".$commentaire."','".$nbExo."','".$exo1."', '".$type1."','".$questi1."' ,'".$exo2."' , '".$type2."', '".$questi2."', '".$exo3."', '".$type3."', '".$questi3."', 
 '".$exo4."', '".$type4."','".$questi4."' ,'".$exo5."' ,'".$type5."' ,'".$questi5."','".$exo6."' ,'".$type6."', '".$questi6."',
 '".$exo7."' , '".$type7."', '".$questi7."', '".$exo8."', '".$type8."', '".$questi8."', '".$exo9."', '".$type9."', '".$questi9."',
 '".$exo10."' , '".$type10."', '".$questi10."', '".$exo11."', '".$type11."', '".$questi11."','".$exo12."' , '".$type12."', '".$questi12."',
 '".$exo13."', '".$type13."', '".$questi13."', '".$exo14."', '".$type14."', '".$questi14."', '".$exo15."', '".$type15."', '".$questi15."', 
 '".$exo16."', '".$type16."', '".$questi16."', '".$exo17."', '".$type17."', '".$questi17."', '".$exo18."', '".$type18."', '".$questi18."', 
 '".$questi19."', '".$exo19."', '".$type19."', '".$exo20."', '".$type20."', '".$questi20."', '".$exo21."', '".$type21."', '".$questi21."', 
 '".$exo22."', '".$type22."', '".$questi22."', '".$exo23."', '".$type23."', '".$questi23."', '".$exo24."', '".$type24."', '".$questi24."')"; 

$result = mysql_query($Requete_SQL) or die("Erreur d'Insertion dans la base : ". $Requete_SQL .'<br />'. mysql_error());
 //echo( $Requete_SQL);
 ?>
<html>
<head>
<title>Exercices de la serie</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<p align="center">
<a href="../index.html">Accueil</a> &nbsp;&nbsp;
<a href="admin.php">Admin</a>&nbsp;&nbsp;
<a href="eleve.html">El�ve</a>
</p>
<p align="center">&nbsp;</p>
<h3 align="center">La s�rie <?php echo ('"'.$_POST["nomSerie"].'"'); ?> est cr��e avec succ�s</h3>
<p align="center">&nbsp;</p>
<p align="center"><a href="affEnonce.php">Cr�er une nouvelle s�rie</a></p>
</body>
</html>
