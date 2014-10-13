<?php 
		require_once("conn.php");
		$numTrace = $_POST['numTrace'];
		//$nom=$_POST['nom'];
		//$prenom=$_POST['prenom'];
		/*$nom='hakem';
		$prenom='lkhider';
		$sql1 = "select numEleve from eleve where nom='".$nom."' and prenom = '".$prenom."'";
		$result1 = mysql_query($sql1) or die("Erreur de S&eacute;lection dans la base : ". $sql1 .'<br />'. mysql_error());
		while ($r = mysql_fetch_assoc($result1))
			{
			$numEleve = $r["numEleve"];
			}*/
		$sql ="select * from trace where id =".$numTrace;
		$result = mysql_query($sql) or die("Erreur de S&eacute;lection dans la base : ". $sql .'<br />'. mysql_error());
		while ($r = mysql_fetch_assoc($result))
			{
			  $zonetext =  $r["zonetext"];
			  if ($r["typeExo"]=='a')
			  	$type = 'comparaison';
			  else if ($r["typeExo"]=='e')
			  	$type = 'complement';
			  $num = $r["numExo"]; 
			  $questi = $r["questInt"];
			  $sas =$r["sas"];
			  $choix = $r["choix"];
			  $oper1 = $r["operation1"];
			  $oper2 = $r["operation2"];
			  $op1 = $r["operande1"];
			  $op2 = $r["operande2"];
			  $op3 = $r["operande3"];
			  $resultat=  $r["resultat"];
			}
		
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Interface</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<SCRIPT language=JavaScript>
function masquer()
{
if (document.info.R1[0].checked)
	{
	//document.info.operande1.focus();
	document.getElementById('zoneText').style.visibility = "hidden";
	document.getElementById('bouton').style.visibility = "hidden";
	document.getElementById('groupe1').style.visibility = "visible";
	document.getElementById('groupe2').style.visibility = "hidden";
	document.getElementById('groupe3').style.visibility = "hidden";
	document.getElementById('efface').style.visibility = "hidden";

	}
else if (document.info.R1[1].checked)
	{
	
	document.getElementById('zoneText').style.visibility = "visible";
	document.getElementById('bouton').style.visibility = "visible";
	//document.info.operande3.focus();
	document.getElementById('groupe1').style.visibility = "hidden";
	document.getElementById('groupe2').style.visibility = "visible";
	document.getElementById('groupe3').style.visibility = "visible";
	document.getElementById('efface').style.visibility = "visible";
	//document.info.operation.value = '  ';
	//document.info.operation1.value = '  ';
	}
}
</script>
</head>
<body onload="masquer()">
<?php 
if ($type=="complement")
print("<form action=\"diag_e.php\" name=\"info\" method=\"post\">");
else if ($type=="comparaison")
print("<form action=\"diag_a.php\" name=\"info\" method=\"post\">");
?>
  
<table align="center">
  <tr> 
    <td width="405" height="559" valign="top"> 
      <table border="0" cellspacing="5">
        <tr> 
          <td width="434" height="45" valign="top"> <table width="100%" border="2" cellpadding="5" cellspacing="0" bordercolor="#000000">
              <tr> 
                <td> 
                  <?php 
			$Requete_SQL2 = "SELECT * FROM $type where numero=$num";
			$result = mysql_query($Requete_SQL2) or die("Erreur de S&eacute;lection dans la base : ". $Requete_SQL2 .'<br />'. mysql_error());
			$nombreExemple = 1;
			//while ($enregistrement = mysql_fetch_array($result))
			//while ($enregistrement = mysql_fetch_object($result))
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
			for($piece = strtok($text1, " "), $i=0 ; $piece != "" ; $piece = strtok(" "))
				{
				  $piece1 = $piece;
				  $piece = str_replace("\\","",$piece);
				  print($piece." ");
				   if (($piece == ".") || (($piece == ",") && ($i>9)))
				  {
					  $i=0;
					  print ("<br>");
				  }
				  $i++;
				}
 				print("<Br>");
if ($questi=="1")
 		 {
		 for($piece = strtok($text2, " "); $piece != "" ; $piece = strtok(" "))
				 {
				  $piece1 = $piece;
				  $piece = str_replace("\\","",$piece);
				  print($piece." ");
				}
  				print("<Br><Br>");
		}
  		for($piece = strtok($text3, " "), $i=0 ; $piece != "" ; $piece = strtok(" "))
			   {
				  $piece1 = $piece;
				  $piece = str_replace("\\","",$piece);
				  print($piece." ");				 
				  if (($piece == ".") || (($piece == ",") && ($i>9)))
				  {
					  $i=0;
					  print ("<br>");
				  }
				  
		    	  $i++;
			   }
  			   print("<Br>");
				
		for($piece = strtok($text4, " "); $piece != "" ; $piece = strtok(" "))
			  {
				  $piece1 = $piece;
				  $piece = str_replace("\\","",$piece);
				  print($piece." ");
			  }
  			  print("<Br>");
  			  mysql_close();
		?>
                </td>
              </tr>
            </table></td>
        </tr>
        <tr> 
          <td height="39"> <div align="center"> 
              <input type="text" name="T1" size="24" rows="1" cols="20" value="<?php echo $sas ?>" disabled>
              <INPUT TYPE="button" VALUE="Ajouter">
            </div></td>
        </tr>
        <tr> 
          <td height="28"> 
            <?php if ($choix=="1") 
			  {
			  print("<input type=\"radio\" value=\"1\" name=\"R1\" checked disabled>");
			  print("Une opération");
			  print("<input type=\"radio\" value=\"2\" name=\"R1\" disabled>");
			  print("Deux opération </td>");
			  }
		  else if ($choix=="2")
		  {
			  print("<input type=\"radio\" value=\"1\" name=\"R1\" disabled>");
			  print("Une opération");
			  print("<input type=\"radio\" value=\"2\" name=\"R1\" checked disabled>");
			  print("Deux opération </td>");
		  }	 
		  ?>
        </tr>
        <tr> 
          <td align="center"> 
		    <input type="button" value="  1  " name="un"> 
            <input type="button" value="  2  " name="deux"> <input type="button" value="  3  " name="trois"> 
            <input type="button" value="  4  " name="quatre"> <input type="button" value="  5  " name="cinq"> 
            <input type="button" value="  6  " name="six"> <input type="button" value="  7  " name="sept"> 
            <input type="button" value="  8  " name="huit"> <input type="button" value="  9  " name="neuf"> 
            <input type="button" value="  0  " name="zero"> <input type="button" value="  ,  " name="zero"> 
          </td>
        </tr>
        <tr> 
          <td align="center"> <div id="groupe1"> 
              <input type="button" value=" + " name="plus" >
              <input type="button" value=" - " name="moin" >
              <input type="button" value=" x " name="mult" >
              <input type="button" value=" : " name="div" >
              <input type="button" value=" = " name="egale">
            </div></td>
        </tr>
        <tr> 
          <td valign="top"> <table width="75%" border="0" cellspacing="0">
              <!--DWLayoutTable-->
              <tr> 
                <td width="92">&nbsp;</td>
                <td width="26">&nbsp;</td>
                <td width="32">&nbsp;</td>
                <td width="77"> <span id="zoneText"> 
                  <input name="operande3" type="text" size="12" maxlength="10" value="<?php echo ($op3); ?>" disabled>
                  </span> </td>
                <td width="28">&nbsp;</td>
                <td width="59"> <div id="efface"> 
                    <input type="button" value="Effacer" name="efface1" style="font-size: 8pt">
                  </div></td>
              </tr>
              <tr> 
                <td align="right"> <div id="groupe2"> 
                    <input type="button" value=" + " name="plus">
                    <input type="button" value=" - " name="moin">
                  </div></td>
                <td>&nbsp;</td>
                <td align="right"> <span id="bouton"> 
                  <input type="button" name="operation1" size="1" value="<?php echo ($oper2); ?>">
                  </span> </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr> 
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td> <input name="operande1" type="text" size="12" disabled maxlength="10" value="<?php echo ($op1); ?>"> 
                </td>
                <td>&nbsp;</td>
                <td> <input type="button" value="Effacer" name="efface2" style="font-size: 8pt"> 
                </td>
              </tr>
              <tr> 
                <td align="right"> <div id="groupe3"> 
                    <input type="button" value=" + " name="plus">
                    <input type="button" value=" - " name="moin">
                  </div></td>
                <td>&nbsp;</td>
                <td align="right"> <input type="button" name="operation" size="1" value="<?php echo ($oper1); ?>"></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr> 
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td> <input name="operande2" type="text" size="12" maxlength="10" value="<?php echo($op2); ?>" disabled> 
                </td>
                <td>&nbsp;</td>
                <td> <input type="button" value="Effacer" name="efface3" style="font-size: 8pt"> 
                </td>
              </tr>
              <tr> 
                <td><div align="right"> 
                    <input name="effacetout" type="button" id="effacetout3" style="font-size: 8pt" value="Effacer Tout">
                  </div></td>
                <td>&nbsp;</td>
                <td colspan="2"><hr align="left" color="#000000"> </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr> 
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="right"> <input type="button" name="egale1" size="1" value=" = "> 
                </td>
                <td> <input name="resultat1" type="text" size="12" maxlength="10" value="<?php echo ($resultat); ?>" disabled> 
                </td>
                <td>&nbsp;</td>
                <td> <input type="button" value="Effacer" name="efface4" style="font-size: 8pt" onclick="document.info.resultat1.value='';document.info.resultat1.focus();"> 
                </td>
              </tr>
            </table></td>
        </tr>
        <tr> 
          <td height="30" align="center"> <input type="button" name="B2" value="Ecrire le calcul dans la feuille"></td>
        </tr>
      </table></td>
    <td width="56" valign="top"></td>
    <td width="335" height="559" valign="top"> 
      <h3 align="left">Ecris tes calculs et ta r&eacute;ponse ici</h3>
      <input name="retour" type="button" value="Retour a la ligne"> 
      <input name="effacer" type="button" id="effacer2" value="Effacer Tout"> 
      <textarea name="zonetexte" cols="50" rows="28" wrap="hard" tabindex="1" disabled><?php echo ($zonetext); ?></textarea> 
      <input name="button" type="button" value="                 Exercice Termin&eacute;                 ">
    </td>
  </tr>
</table>
<input name="oper1" type="hidden">
<input name="oper2" type="hidden">
</form>
<div align="center"><a href="javascript:;" onClick="window.close();">Fermer</a></div> 

</body>
</html>
		