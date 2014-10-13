<?php
session_start();
require_once("conn.php");
$numEleve = $_SESSION["numEleve"];

	if(isset($_GET['precedent']))//pour avoir le dernier enregistrement de la table trace
	{
		$precedent = $_GET['precedent'];
		$numSerie = (int)($_GET['numSerie']);
			if ($precedent == 'oui')
			{
			 $sql2 = "select id, numSerie,numExo,typeExo,questInt,sas,operation1,operande1,operande2,zonetext,resultat from trace where ";
			 $sql2 .= "numEleve = ".$numEleve." and numSerie=".$numSerie." order by id DESC LIMIT 1";
				$result2 = mysql_query($sql2) or die ("Requête incorrecte2".$sql2);
				while ($traceRecord = mysql_fetch_assoc($result2))
					{
					  $numTrace = $traceRecord["id"];
					  $numSerie =  $traceRecord["numSerie"];$_SESSION["numSerie"]=$numSerie;
					  $num = $traceRecord["numExo"];$_SESSION["num"]= $num;
					  $type =  $traceRecord["typeExo"];
					  if($type=='e') 
					  	$type = 'complement';  
					  else if($type=='a')
					  	$type='comparaison';
					  else if($type=='d')
					  	$type='distributivite';
					   else if($type=='changement' || $type=='combinaison' || $type=='comparaison')
					  	$type='etape';
					  $questi = $traceRecord["questInt"];
					  $sas =  $traceRecord["sas"];
					  $operateur = $traceRecord["operation1"];
					  $operande1 = $traceRecord["operande1"];
					  $operande2 = $traceRecord["operande2"];
					  $resultat =  $traceRecord["resultat"];
					  if($operande1==0 and $operande2==0 and $resultat==0)
					  {$operande1=''; $operande2=''; $resultat='';}
					  $zoneTexte =  $traceRecord["zonetext"];
					   $nbExo++;$numExo--;
					}
					
			}
	}
	else
	{
if(isset($_GET["numSerie"])) $_SESSION["numSerie"]=(int)trim($_GET["numSerie"]);
if (isset($_GET["totalExo"])) $_SESSION["totalExo"]=(int)trim($_GET["totalExo"]);
if (isset($_GET["nbExo"])) $nbExo=(int)trim($_GET["nbExo"]);
if (isset($_GET["numExo"])) $numExo=(int)trim($_GET["numExo"]);


$sql1 = "SELECT * FROM serie where numSerie=".$_SESSION["numSerie"];
$result1 = mysql_query($sql1) or die ("Requête incorrecte1");

while ($r1 = mysql_fetch_assoc($result1))
	  {
	  if($numExo<=$_SESSION["totalExo"])
	  	{
		  if ($r1["exo".$numExo]!="0")
			{
				$num=$r1["exo".$numExo];
				
				if ($r1["type".$numExo]=="a")
					$type="comparaison";
				else if ($r1["type".$numExo]=="e")
					$type="complement";
				else if ($r1["type".$numExo]=="d")
					$type="distributivite";
				else if ($r1["type".$numExo]=="et")
					$type="etape";
				$questi=$r1["questi".$numExo];
				
				$_SESSION["num"]= $num;
				$_SESSION["type"]= $type; 
				
				if($type=='e') $type = 'complement'; 
				else if($type=='a') $type='comparaison';
				else if($type=='d') $type='distributivite';
				else if($type=='et') $type='etape';
				
				$_SESSION["questi"]= $questi;
				$_SESSION["terminer"]= false;
			}
   	    }
	  else 
		{
		 $_SESSION["terminer"]= true;
		}
   }
$num = $_SESSION["num"]; $type = $_SESSION["type"]; $questi = $_SESSION["questi"];
if (($_SESSION["terminer"])||($num=='')||($num==0))
{
   	$_SESSION["terminer"]= false;
	?>
	<script type='text/javascript'>window.close();</script>";
	<?php
}}
	?>
<html>
<head>
<title>DIANE</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<SCRIPT language="JavaScript" src="interfaceIE.js"></script>
<link rel="stylesheet" type="text/css" href="interfaceIE.css">
</head>
<body
onLoad="
<?php 
if(isset($_GET["precedent"])) 
echo("initPrecedent('".$operande1."','".$operande2."','".$operateur."','".$resultat."');");
if ($type=="distributivite") 
	 echo("document.info.T1.focus();");
else echo ("document.info.operande1.focus();");
?>
">

<?php
if ($type=="complement")
print("<form action=\"diag_e.php\" name=\"info\" method=\"post\">");
else if ($type=="comparaison")
print("<form action=\"diag_a.php\" name=\"info\" method=\"post\">");
else if ($type=="distributivite")
print("<form action=\"diag_d.php\" name=\"info\" method=\"post\">");
else if ($type=="etape")
print("<form action=\"diag_etape.php\" name=\"info\" method=\"post\">");


?>
<table width="67%" align="center">
<tr><td colspan="2"><table width="100%"  border="0">
  <tr>
    <td width="25%">
	<?php 
	if(isset($_GET["lienRetour"])) 
	{
	$varLien="interfaceIE.php?precedent=oui&numSerie=".$numSerie."&nbExo=".$nbExo."&numExo=".$numExo;
	echo("<input name=\"ExercicePrecedent\" type=\"button\" class=\"bouton\" value=\"Exercice pr&eacute;c&eacute;dent\" onClick=\"window.open('$varLien','Interface');\">");
	}
	?>
    </td>
    <td width="52%" align="center"><?php print(ucfirst($_SESSION['prenom'])."   ".strtoupper($_SESSION['nom']));?></td>
    <td width="23%">&nbsp;</td>
  </tr>
</table></td></tr>
      <tr>
        <td width="41%" rowspan="3" valign="top"> 
	  <table width="440" border="0" cellspacing="2">
        <tr>
          <td width="434" colspan="2" align="center">
		    
		    <table width="97%" border="0" cellpadding="0" cellspacing="0">
		      <tr>
		      <td height="24" valign="top" class="aide">&nbsp;&nbsp; Exercice N° <?php echo ($_SESSION["totalExo"]-$nbExo+1); ?></td>
	          </tr>
			    
		      <tr>
		  	    <td>
				  <table width="100%" border="2" align="center" cellpadding="2" cellspacing="0">
                  <tr>
                    <td>
<?php
$Requete_SQL2 = "SELECT * FROM $type where numero=$num";
$result = mysql_query($Requete_SQL2) or die("Erreur de S&eacute;lection dans la base : ". $Requete_SQL2 .'<br />'. mysql_error());
$nombreExemple = 1;
if($type=="distributivite")
{
	while ($enregistrement = mysql_fetch_assoc($result))
		{
		  $text1 =  $enregistrement["enonce"];
		  $text1 = str_replace("'","\'",$text1);
		  $text2 =  $enregistrement["question"];
		  $text2 = str_replace("'","\'",$text2);
		}
	//Enoncé de distributivite
	for($piece = strtok($text1, " "), $i=1 ; $piece != "" ; $piece = strtok(" "))
	{
		  $piece1 = $piece;  
		  $piece = str_replace("\\","",$piece);
		  if($piece1==".") $i=0;
		  print("<a href=\"javascript:;\" id=\"".$i."\" onClick=\"insererSas('".$piece1." "."','".$i."');\" class=\"enonce\">".$piece."</a>"." ");
		  $i++;
	}
	print("<Br>");
	//Question de l'énoncé de distributivité
	 for($piece = strtok($text2, " "), $i=1; $piece != "" ; $piece = strtok(" "))
	 {
		  $piece1 = $piece; 
		  $piece = str_replace("\\","",$piece);
		  if($piece1==".") $i=0;
		  print("<a href=\"javascript:;\" id=\"".$i."\" onClick=\"insererSas('".$piece1." "."','".$i."');\" class=\"enonce\">".$piece."</a>"." ");
		  $i++;
	 }
}
else if($type=="etape")
{
	while ($enregistrement = mysql_fetch_assoc($result))
		{
		  $text1 =  $enregistrement["enonce"];
		  $text1 = str_replace("'","\'",$text1);
		  $text2 =  $enregistrement["question"];
		  $text2 = str_replace("'","\'",$text2);
		}
	//Enoncé de distributivite
	for($piece = strtok($text1, " "), $i=1 ; $piece != "" ; $piece = strtok(" "))
	{
		  $piece1 = $piece;  
		  $piece = str_replace("\\","",$piece);
		  if($piece1==".") $i=0;
		  print("<a href=\"javascript:;\" id=\"".$i."\" onClick=\"insererSas('".$piece1." "."','".$i."');\" class=\"enonce\">".$piece."</a>"." ");
		  $i++;
	}
	print("<Br>");
	//Question de l'énoncé de distributivité
	 for($piece = strtok($text2, " "), $i=1; $piece != "" ; $piece = strtok(" "))
	 {
		  $piece1 = $piece; 
		  $piece = str_replace("\\","",$piece);
		  if($piece1==".") $i=0;
		  print("<a href=\"javascript:;\" id=\"".$i."\" onClick=\"insererSas('".$piece1." "."','".$i."');\" class=\"enonce\">".$piece."</a>"." ");
		  $i++;
	 }
}
else
{
	while ($enregistrement = mysql_fetch_assoc($result))
		{
		  $text1 =  $enregistrement["enonce1"];
		  $text1 = str_replace("'","\'",$text1);
		  $text2 =  $enregistrement["question1"];
		  $text2 = str_replace("'","\'",$text2);
		  $text3 =  $enregistrement["enonce2"];
		  $text3 = str_replace("'","\'",$text3);
		  $text4 =  $enregistrement["question2"];
		  $text4 = str_replace("'","\'",$text4);
		}
	//Première partie de l'énoncé
	for($piece = strtok($text1, " "), $i=1 ; $piece != "" ; $piece = strtok(" "))
		{
		  $piece1 = $piece;
		  $piece = str_replace("\\","",$piece);
		  if($piece1==".") $i=0;
		  print("<a href=\"javascript:;\" id=\"".$i."\" onClick=\"insererSas('".$piece1." "."','".$i."');\" class=\"enonce\">".$piece."</a>"." ");
		  $i++;
		}
		print("<Br>");
	//Question intermédiaire
	if ($questi=="1")
	   {
		 for($piece = strtok($text2, " "), $i=1; $piece != "" ; $piece = strtok(" "))
			 {
			  $piece1 = $piece;
			  $piece = str_replace("\\","",$piece);
			  if($piece1==".") $i=0;
			  print("<a href=\"javascript:;\" id=\"".$i."\" onClick=\"insererSas('".$piece1." "."','".$i."');\" class=\"enonce\">".$piece."</a>"." ");
			  $i++;
			 } 
		 print("<Br>");
	  }
	//Deuxième partie de l'énoncé.  
	for($piece = strtok($text3, " "), $i=1 ; $piece != "" ; $piece = strtok(" "))
	   {
		  $piece1 = $piece;
		  $piece = str_replace("\\","",$piece);
		  if($piece1==".") $i=0;
		  print("<a href=\"javascript:;\"  id=\"".$i."\" onClick=\"insererSas('".$piece1." "."','".$i."');\" class=\"enonce\">".$piece."</a>"." ");
		  $i++;
	   }
	   print("<Br>");
	//Question finale
	for($piece = strtok($text4, " "),$i=1; $piece != "" ; $piece = strtok(" "))
	  {
		  $piece1 = $piece;
		  $piece = str_replace("\\","",$piece);
		  if($piece1==".") $i=0;
		  print("<a href=\"javascript:;\"  id=\"".$i."\" onClick=\"insererSas('".$piece1." "."','".$i."');\" class=\"enonce\">".$piece."</a>"." ");
		  $i++;
	  }
}
mysql_close();
?>                    </td>
                  </tr>
                </table>				</td>
		      </tr>
              <tr>
                <td height="27" valign="middle" class="aide">Pour &eacute;crire, tu peux cliquer sur les mots de l'&eacute;nonc&eacute;</td>
              </tr>
          </table>	      </td>
        </tr>
        <tr>
          <td width="434"   align="center">             
            <table width="100%"  border="0">
              <tr>
                <td align="center"><input name="T1" type="text" size="65" style="font-size:10pt;"  <?php if (isset($precedent)) echo('value="'.$sas.'"'); else echo('value=""');?> class="champText" id="sas"
			  onFocus="monTour(5);colorFocus('sas');" 
			  onBlur="colorBlur('sas');"></td>
              </tr>
          </table>          </td>
        </tr>   
	     <tr>
	       <td height="45" colspan="2" align="center">
	       <table width="100%"  border="0">
             <tr>
               <td width="28%" align="left"><input name="efface5" type="button" class="bouton"  onClick="document.info.T1.value='';document.info.T1.focus();" value="Effacer tout" style="width:110"></td>
               <td width="24%" align="center"><input type="button" class="bouton" name="annuler2" value="Annuler" onClick="annulerSas();" style="width:70">                </td>
               <td width="48%" align="right"><input name="button2" type="button" class="bouton"  onClick="inserer(document.info.T1.value);" 
		   value="Ecrire dans la feuille" style="width:200"
		   ></td>
             </tr>
           </table></td> 
        </tr>
        <tr>
          <td colspan="2" align="center"><span class="aide">Tu peux faire tes calculs ici </span></td>
        </tr>
        <tr>
          <td colspan="2" align="center"> 
		  <?php if ($type=="distributivite") {?><?php }?>
		  <table border="0" align="center">
                <tr>
                  <td align="center"><input name="operande1" type="text" size="45" class="champText" id="op1" style="text-align:right"
							onFocus="monTour(1); count(event,1);colorFocus('op1');document.info.resultat1.value=''"
							onChange="document.info.resultat1.value='';" 
							onBlur="colorBlur('op1');" 
							onKeyPress="return checkIt(event);" 
							onKeyUp="count(event,1);"></td>
                  <td width="27" align="center">
				  
				  <input name="egale1" type="button" class="Boutcal" onClick="if (tester == 5) {calculSas();} else {resultat();}"  value=" = "> </td> 
                  <td width="61" align="center">
                    <div align="left">
                      <input name="resultat1" type="text" size="10" class="champText" id="res"
				  onFocus="monTour(4); count(event,4);colorFocus('res');" 
				  onBlur="colorBlur('res')"  
				  onSelect="this.value=''" 
				  onKeyPress="return checkIt(event);" 
				  onKeyUp="count(event,4)">
                    </div></td>
                </tr>
            </table> 
			<table width="442" height="44" border="0" align="center">
                <tr>
                  <td width="130" align="left">
                      <input name="effacetout" type="button" class="bouton" id="effacetout3"
					onClick="document.info.resultat1.value=''; 
							 document.info.operande1.value='';
							 document.info.operande1.focus();" 
					value="Effacer l'op&eacute;ration"
					style="width:130">                    </td>
                  <td width="98" align="center"><input name="annuler3" type="button" class="bouton" id="annuler3" onClick="annulerOper();" value="Annuler" style="width:70">                  </td>
                  <td width="200" align="right">
				  <input name="B2" type="button"
			  value="Ecrire le calcul dans la feuille" class="bouton" 
		  			onClick="verifCal(); 
		  		   document.info.resultat1.value=''; 
				   document.info.operande1.value='';document.info.operande1.focus();" 
				   style="width:200"></td>
                </tr>
            </table>
			<table width="151" height="153" align="center">
<tr valign="middle">
  <td colspan="4" align="center"><input name="egale2" type="button" class="Boutegal" onClick="if (tester == 5) {calculSas();} else {resultat();}" value=" = "></td>
  </tr>
<tr>
  <td width="35" align="center" valign="middle"><input name="un" type="button" class="Boutcal" onClick="if (tester == 5) {insererSas('1');} else {afficher(1);}" value="1"></td>
  <td width="27" align="center" valign="middle"><input name="deux" type="button" class="Boutcal" onClick="if (tester == 5) {insererSas('2');} else {afficher(2);}" value="2"></td>
  <td width="27" align="center" valign="middle"><input name="trois" type="button" class="Boutcal" onClick="if (tester == 5) {insererSas('3');} else {afficher(3);}" value="3"></td>
<td width="35" align="center" valign="middle">			
  <input name="plus" type="button" class="Boutcal" onClick="if (tester == 5) {insererSas(' + ');} else if (tester == 1){afficher(' + ');};" value=" + "></td>
</tr>
<tr>
  <td align="center" valign="middle"><input name="quatre" type="button" class="Boutcal" onClick="if (tester == 5) {insererSas('4');} else {afficher(4);}" value="4"></td>
  <td align="center" valign="middle"><input name="cinq" type="button" class="Boutcal" onClick="if (tester == 5) {insererSas('5');} else {afficher(5);}" value="5"></td>
  <td align="center" valign="middle"><input name="six" type="button" class="Boutcal" onClick="if (tester == 5) {insererSas('6');} else {afficher(6);}" value="6"></td>
  <td align="center" valign="middle"><input name="moin" type="button" class="Boutcal" onClick="if (tester == 5) {insererSas(' - ');} else if (tester == 1){afficher(' - ');};" value=" - "></td>
</tr>
<tr>
  <td align="center" valign="middle"><input name="sept" type="button" class="Boutcal" onClick="if (tester == 5) {insererSas('7');} else {afficher(7);}" value="7"></td>
  <td align="center" valign="middle"><input name="huit" type="button" class="Boutcal" onClick="if (tester == 5) {insererSas('8');} else {afficher(8);}" value="8"></td>
  <td align="center" valign="middle"><input name="neuf" type="button" class="Boutcal" onClick="if (tester == 5) {insererSas('9');} else {afficher(9);}" value="9"></td>
  <td align="center" valign="middle"><input name="div" type="button" class="Boutcal"  id="div" onClick="if (tester == 5) {insererSas(' : ');} else if (tester == 1){afficher(' : ');};" value=" : "></td>
</tr>
<tr>
  <td align="center" valign="middle"><input name="zero" type="button" class="Boutcal" onClick="if (tester == 5) {insererSas('0');} else {afficher(0);}" value="0"></td>
  <td align="center" valign="middle"><input name="paro" type="button" class="Boutcal" onClick="if (tester == 5) {insererSas(' ( ');} else if (tester == 1){afficher(' ( ');};" value=" ( "></td>
  <td align="center" valign="middle"><input name="parf" type="button" class="Boutcal" onClick="if (tester == 5) {insererSas(' ) ');} else if (tester == 1){afficher(' ) ');};" value=" ) "></td>
  <td align="center" valign="middle"><input name="mult" type="button" class="Boutcal" id="mult" onClick="if (tester == 5) {insererSas(' x ');} else if (tester == 1){afficher(' x ');};" value=" x "></td>
</tr>
</table></td>
        </tr>
        </table></td>
        <td width="59%" align="center" valign="top"><table width="100%"  border="0">
          <tr>
            <td height="22" colspan="3" class="aide">&Eacute;cris tes calculs et ta r&eacute;ponse dans cette feuille</td>
          </tr>
          <tr>
            <td align="center"><input name="effacer" type="button" class="bouton" id="effacer2"
	  	onClick="document.info.zonetexte.value='';document.info.zonetexte.focus();" value="Effacer toute la feuille" style="width:150">            </td>
            <td align="center"><input name="retour" type="button" class="bouton" onClick="inserer('\n');document.info.zonetexte.focus();" value="Passer &agrave; la ligne" style="width:115"></td>
            <td align="center"><input name="annuler" type="button" class="bouton" id="annuler" 
	  		onClick="if (feuille.isContentEditable==true) annulerAction();" value="Annuler"></td>
          </tr>
          <tr align="center">
            <td colspan="3" valign="middle"><textarea name="zonetexte" cols="45" rows="24" class="champText" id="feuille"
			 onFocus="colorFocus('feuille');" 
			 onBlur="colorBlur('feuille');"><?php if(isset($precedent)) echo($zoneTexte);?></textarea></td>
          </tr>
        </table></td>
      </tr>
  <tr>
    <td align="center">
	  <p>
		<input name="button" type="button" class="bouton" onClick="verifForm();" 
		style="width:240;" value="Exercice termin&eacute;">
	  </p>
	</td>
  </tr>
  <tr>
    <td align="center" class="aide"><?php 
$reste = $nbExo-1;
if($reste > 1)
 echo ("Il te reste ".$reste." exercices");
else if($nbExo-1 == 1)
 echo ("Il te reste ".$reste." exercice");
else if($reste == 0)
 echo ("c'est le dernier exercice"); 
?>  
  <tr align="center">
    <td height="21" colspan="2" valign="top"><a href="javascript:;" onClick="abandonner();">Quitter </a></td>
</table>

<input name="oper1" type="hidden">
<input name="oper2" type="hidden">
<input name="nbExo"  value="<?php echo($nbExo);?>" type="hidden">
<input name="numExo"  value="<?php echo($numExo);?>" type="hidden">
</form>
</body>
</html>