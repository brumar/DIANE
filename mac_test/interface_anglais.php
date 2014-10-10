<?php
session_start();
require_once("conn.php");
$numEleve = $_SESSION["numEleve"];
	if(isset($_GET['precedent']))//pour avoir le dernier enregistrement de la table trace
	{
		$precedent = $_GET['precedent'];
			if ($precedent == 'oui')
			{
				$sql2 = "select id, numSerie,numExo,typeExo,questInt,sas,operation1,operande1,operande2,zonetext,resultat from trace where ";
				$sql2 .= "numEleve = ".$numEleve." order by id DESC LIMIT 1";
				$result2 = mysql_query($sql2) or die ("Requête incorrecte2");
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
				$questi=$r1["questi".$numExo];
				
				$_SESSION["num"]= $num;
				$_SESSION["type"]= $type; 
				
				if($type=='e') $type = 'complement'; 
				else if($type=='a') $type='comparaison';
				else if($type=='d') $type='distributivite';
				
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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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

?>
<table width="67%" align="center">
<tr><td colspan="2"><table width="100%"  border="0">
  <tr>
    <td width="25%">
	<?php 
	if(isset($_GET["lienRetour"])) 
	{
	$varLien="interfaceIE.php?precedent=oui&nbExo=".$nbExo."&numExo=".$numExo;
	echo("<input name=\"ExercicePrecedent\" type=\"button\" class=\"bouton\" value=\"Preceding exercise\" onClick=\"window.open('$varLien','Interface');\">");
	}
	?>
    </td>
    <td width="52%" align="center"><?php print(ucfirst($_SESSION['prenom'])."   ".strtoupper($_SESSION['nom']));?></td>
    <td width="23%">&nbsp;</td>
  </tr>
</table></td></tr>
      <tr>
        <td width="41%" rowspan="3" valign="top"> 
	  <table width="462" border="0" cellspacing="2">
        <tr>
          <td width="456" colspan="2" align="center">
		    
		    <table width="100%" border="0" cellpadding="0" cellspacing="0">
		      <tr>
		      <td height="24" valign="top" class="aide">&nbsp;&nbsp; Exercise N° <?php echo ($_SESSION["totalExo"]-$nbExo+1); ?></td>
	          </tr>
			    <tr>
		        <td height="24" valign="top" class="aide">&nbsp;</td>
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
                <td height="27" valign="middle" class="aide">For writing in the answer sheet, you can click on the words</td>
              </tr>
            </table>	      </td>
        </tr>
        <tr>
          <td width="456"   align="center">             
            <table width="100%"  border="0">
              <tr>
                <td align="center"><input name="T1" type="text" size="60" style="font-size:10pt;"  <?php if (isset($precedent)) echo('value="'.$sas.'"'); else echo('value=""');?> class="champText" id="sas"
			  onFocus="monTour(5);colorFocus('sas');" 
			  onBlur="colorBlur('sas');"></td>
              </tr>
            </table>          </td>
        </tr>   
	     <tr>
	       <td height="45" colspan="2" align="center">
	       <table width="100%"  border="0">
             <tr>
               <td width="33%" align="center"><input name="efface5" type="button" class="bouton"  onClick="document.info.T1.value='';document.info.T1.focus();" value="Delete everything" style="width:120"></td>
               <td width="39%" align="center"><input name="button2" type="button" class="bouton"  onClick="inserer(document.info.T1.value);" 
		   value="Type in the answer sheet" style="width:200"
		   ></td>
               <td width="28%" align="center">
			   <input type="button" class="bouton" name="annuler2" value="Cancel" onClick="annulerSas();" style="width:70"></td>
             </tr>
           </table></td> 
        </tr>
        <tr>
          <td colspan="2" align="center">
	        <input name="un" type="button" class="Boutcal" onClick="if (tester == 5) {insererSas('1');} else {afficher(1);}" value="1">
            <input name="deux" type="button" class="Boutcal" onClick="if (tester == 5) {insererSas('2');} else {afficher(2);}" value="2">            
            <input name="trois" type="button" class="Boutcal" onClick="if (tester == 5) {insererSas('3');} else {afficher(3);}" value="3">
            <input name="quatre" type="button" class="Boutcal" onClick="if (tester == 5) {insererSas('4');} else {afficher(4);}" value="4">
            <input name="cinq" type="button" class="Boutcal" onClick="if (tester == 5) {insererSas('5');} else {afficher(5);}" value="5">
            <input name="six" type="button" class="Boutcal" onClick="if (tester == 5) {insererSas('6');} else {afficher(6);}" value="6">
            <input name="sept" type="button" class="Boutcal" onClick="if (tester == 5) {insererSas('7');} else {afficher(7);}" value="7">
            <input name="huit" type="button" class="Boutcal" onClick="if (tester == 5) {insererSas('8');} else {afficher(8);}" value="8">
            <input name="neuf" type="button" class="Boutcal" onClick="if (tester == 5) {insererSas('9');} else {afficher(9);}" value="9">
            <input name="zero" type="button" class="Boutcal" onClick="if (tester == 5) {insererSas('0');} else {afficher(0);}" value="0">          </td>
        </tr>
        <tr>
          <td colspan="2" align="center"> 
              <input name="plus" type="button" class="Boutcal" onClick="if (tester == 5) {insererSas(' + ');} else if (tester == 1){afficher(' + ');};" value=" + ">
              <input name="moin" type="button" class="Boutcal" onClick="if (tester == 5) {insererSas(' - ');} else if (tester == 1){afficher(' - ');};" value=" - ">
              <input name="mult" type="button" class="Boutcal" id="mult" onClick="if (tester == 5) {insererSas(' x ');} else if (tester == 1){afficher(' x ');};" value=" x ">
              <input name="div" type="button" class="Boutcal"  id="div" onClick="if (tester == 5) {insererSas(' : ');} else if (tester == 1){afficher(' : ');};" value=" : ">
		      <input name="egale" type="button" class="Boutcal" onClick="if (tester == 5) {calculSas();} else {resultat();}" value=" = ">
			  <?php if ($type=="distributivite") {?>
			  <input name="paro" type="button" class="Boutcal" onClick="if (tester == 5) {insererSas(' ( ');} else if (tester == 1){afficher(' ( ');};" value=" ( ">
              <input name="parf" type="button" class="Boutcal" onClick="if (tester == 5) {insererSas(' ) ');} else if (tester == 1){afficher(' ) ');};" value=" ) ">         
			  <?php }?>			  </td>
        </tr>
	    <tr>
        <td colspan="2" align="center" class="aide">You can make your calculations here	    </tr>
           
        <tr align="center">
          <td colspan="2" >
		  <table cellspacing="0" align="center">
            <tr>
              <td><table align="center">
                    <tr>
                    <td align="center" valign="top"><input name="operande1" type="text" size="45" class="champText" id="op1" style="text-align:right"
							onFocus="monTour(1); count(event,1);colorFocus('op1');document.info.resultat1.value=''"
							onChange="document.info.resultat1.value='';" 
							onBlur="colorBlur('op1');" 
							onKeyPress="return checkIt(event);" 
							onKeyUp="count(event,1);"></td>
                    <td align="center" valign="top">
					<input name="egale1" type="button" class="Boutcal" onClick="resultat();count(event,4);monTour(4);" value=" = " size="1"></td>
                    <td align="center" valign="top"><input name="resultat1" type="text" size="10" class="champText" id="res"
				  onFocus="monTour(4); count(event,4);colorFocus('res');" 
				  onBlur="colorBlur('res')"  
				  onSelect="this.value=''" 
				  onKeyPress="return checkIt(event);" 
				  onKeyUp="count(event,4)"></td>
                  </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td colspan="2" align="center"><table width="100%" border="0">
            <tr>
              <td align="right">
			  <input name="effacetout" type="button" class="bouton" id="effacetout3"
					onClick="document.info.resultat1.value=''; 
							 document.info.operande1.value='';
							 document.info.operande1.focus();" 
					value="Delete the calculation"
					style="width:135"></td>
              <td align="center">
			  <input name="B2" type="button" 
			  value="Type in your calculation" class="bouton" 
		  onClick="verifCal(); 
		  		   document.info.resultat1.value=''; 
				   document.info.operande1.value='';document.info.operande1.focus();" 
				   style="width:200"></td>
              <td align="left">
			  <input name="annuler3" type="button" class="bouton" id="annuler3" onClick="annulerOper();" value="Cancel" style="width:70">			  </td>
            </tr>
          </table></td>
        </tr>
        </table></td>
        <td width="59%" align="center" valign="top"><table width="87%"  border="0">
          <tr>
            <td height="22" colspan="3" class="aide">Type in your calculations and answers</td>
          </tr>
          <tr>
            <td align="center"><input name="retour" type="button" class="bouton" onClick="inserer('\n');document.info.zonetexte.focus();" value="Start a new line" style="width:115"></td>
            <td align="center"><input name="annuler" type="button" class="bouton" id="annuler" 
	  		onClick="if (feuille.isContentEditable==true) annulerAction();" value="Cancel"></td>
            <td align="center"><input name="effacer" type="button" class="bouton" id="effacer2"
	  	onClick="document.info.zonetexte.value='';document.info.zonetexte.focus();" value="Delete everything" style="width:150"></td>
          </tr>
          <tr align="center">
            <td colspan="3"><textarea name="zonetexte" cols="45" rows="24" class="champText" id="feuille"
			 onFocus="colorFocus('feuille');" 
			 onBlur="colorBlur('feuille');"><?php if(isset($precedent)) echo($zoneTexte);?></textarea></td>
          </tr>
        </table></td>
      </tr>
  <tr>
    <td align="center">
	  <p>
		<input name="button" type="button" class="bouton" onClick="verifForm();" 
		style="width:240;" value="Exercise finished">
	  </p>
	</td>
  </tr>
  <tr>
    <td align="center" class="aide"><?php 
$reste = $nbExo-1;
if($reste > 1)
 echo ($reste." exercise remains");
else if($nbExo-1 == 1)
 echo ($reste." exercise remains");
else if($reste == 0)
 echo ("It is the last exercise"); 
?>  
  <tr align="center">
    <td height="21" colspan="2" valign="top"><a href="javascript:;" onClick="abandonner();">Give up</a></td>
</table>

<input name="oper1" type="hidden">
<input name="oper2" type="hidden">
<input name="nbExo"  value="<?php echo($nbExo);?>" type="hidden">
<input name="numExo"  value="<?php echo($numExo);?>" type="hidden">
</form>
</body>
</html>