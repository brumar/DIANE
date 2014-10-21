<?php 
session_start();
$num = (int) ($_SESSION['num']);//$_GET['num'];(int) trim($_POST[numero]);
$type = $_SESSION['type'];//$_GET['type'];trim($_POST[typepb]);
$questi = $_SESSION['questi'];//$_GET['questi'];
//print("le numero d'exercice ".$num."<br>le type : ".$type);exit();
session_register('questi');
if (($_SESSION['terminer'])||($num=='')||($num==0))
{
$terminer=false;
session_register('terminer');
?>	
<script type='text/javascript'>
//alert("La série d'exercice est terminée");
window.close();
</script>";
<?php 
	}
?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Interface</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css" media="all">
	/* Ce style CSS ne dois pas être enlevé, sinon les divs ne se cacherons pas ... */
	.cachediv {
		visibility: hidden;
		overflow: hidden;
		height: 1px;
		margin-top: -1px;
		position: absolute;
	}
</style>
<script language="JavaScript" src="static/js/interfaceMac.js"></script>
</head>
<body onload="DivStatus(">
<h3 align="center"><font color="#0000CC"><?php print(strtoupper($_SESSION['prenom'])."   ".strtoupper($_SESSION['nom']));?></font></h3>
<?php
if ($type=="complement")
print("<form action=\"diag_e.php\" name=\"info\" method=\"post\">");
else if ($type=="comparaison")
print("<form action=\"diag_a.php\" name=\"info\" method=\"post\">");
?>

<table align="center">
  <tr>
    <td width="405" height="637" rowspan="2" valign="top"> <table border="0" cellspacing="5">
        <tr>
          <td width="434" height="45" valign="top"> <table width="100%" border="2" cellpadding="5" cellspacing="0" bordercolor="#000000">
              <tr>
                <td>
                  <?php
			require_once("conn.php");

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
				  
				  print("<a href=\"javascript:;\" onClick=\"document.info.T1.value='".$piece1."' ; document.info.T1.focus(); \" style=\"text-decoration: none;\">".$piece."</a>"." ");
				   if (($piece == ".") || (($piece == ",") && ($i>9)))
				  {
					  $i=0;
					  print ("<br>");
				  }
				  /*else if ($i==10)
				  	  {
						  $i=0;
						  print ("<br>");
					  }*/
				  $i++;
				}
 				print("<Br>");
if ($questi=="1")
 		 {
		 for($piece = strtok($text2, " "); $piece != "" ; $piece = strtok(" "))
				 {
				  $piece1 = $piece;
				  $piece = str_replace("\\","",$piece);
				  print("<a href=\"javascript:;\" onClick=\"document.info.T1.value='".$piece1."' ; document.info.T1.focus(); \" style=\"text-decoration: none;\">".$piece."</a>"." ");
				}
  				print("<Br><Br>");
		}
  		for($piece = strtok($text3, " "), $i=0 ; $piece != "" ; $piece = strtok(" "))
			   {
				  $piece1 = $piece;
				  $piece = str_replace("\\","",$piece);
				  print("<a href=\"javascript:;\" onClick=\"document.info.T1.value='".$piece1."' ; document.info.T1.focus();\" style=\"text-decoration: none;\">".$piece."</a>"." ");
				  if (($piece == ".") || (($piece == ",") && ($i>9)))
				  {
					  $i=0;
					  print ("<br>");
				  }
				  /*else if ($i==10)
				  	  {
						  $i=0;
						  print ("<br>");
					  }*/

				  $i++;
			   }
  			   print("<Br>");

		for($piece = strtok($text4, " "); $piece != "" ; $piece = strtok(" "))
			  {
				  $piece1 = $piece;
				  $piece = str_replace("\\","",$piece);
				  print("<a href=\"javascript:;\" onClick=\"document.info.T1.value='".$piece1."' ; document.info.T1.focus();\" style=\"text-decoration: none;\">".$piece."</a>"." ");
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
		      <input type="button" value="Effacer" name="efface5" style="font-size: 8pt" onclick="document.info.T1.value='';document.info.T1.focus();">
              <input type="text" name="T1" size="24" rows="1" cols="20" onFocus="monTour(5)" onSelect="this.value=''">
              <input name="button2" type="button" style="font-size: 8pt" onClick="save(document.info.T1.value);" value="Ecrire dans la feuille">
			  
            </div></td>
        </tr>
        <tr>
          <td height="28"> <input type="radio" value="1" name="R1" checked  onclick="masquer();">
            Une opération
            <input type="radio" value="2" name="R1"  onclick="masquer();">
            Deux opérations </td>
        </tr>
        <tr>
          <td align="center">
		    <input type="button" value=" 1 " name="un" onclick="afficher(1); ">
            <input type="button" value=" 2 " name="deux" onclick="afficher(2);">
            <input type="button" value=" 3 " name="trois" onclick="afficher(3);">
            <input type="button" value=" 4 " name="quatre" onclick="afficher(4);">
            <input type="button" value=" 5 " name="cinq" onclick="afficher(5);">
            <input type="button" value=" 6 " name="six" onclick="afficher(6);">
            <input type="button" value=" 7 " name="sept" onclick="afficher(7);">
            <input type="button" value=" 8 " name="huit" onclick="afficher(8);">
            <input type="button" value=" 9 " name="neuf" onclick="afficher(9);">
            <input type="button" value=" 0 " name="zero" onclick="afficher(0);">
            <input type="button" value=" , " name="zero" onclick="afficher(',');">
          </td>
        </tr>
      
		<tr>
		   <td align="center">  
		   <div id="groupe1">
              <input type="button" value=" + " name="plus" onclick="operat('+'); document.info.T1.value ='+'; document.info.operande2.value = '';document.info.operande2.focus();  ">
              <input type="button" value=" - " name="moin" onclick="operat('-'); document.info.T1.value ='-'; document.info.operande2.value = '';document.info.operande2.focus();">
              <input type="button" value=" x " name="mult" onclick="operat('x'); document.info.T1.value ='x'; document.info.operande2.value = '';document.info.operande2.focus();">
              <input type="button" value=" : " name="div"  onclick="operat(':'); document.info.T1.value =':'; document.info.operande2.value = '';document.info.operande2.focus();">
			  <input type="button" value=" = " name="egale"  onclick="resultat2(); document.info.T1.value ='=';monTour(4);">
             </div></td>
        </tr>
     
       <tr>
          <td valign="top"> <table width="75%" border="0" cellspacing="0">
              <!--DWLayoutTable-->
              <tr>
                <td width="92">&nbsp;</td>
                <td width="26">&nbsp;</td>
                <td width="32">&nbsp;</td>
                <td width="77"> 
				<div id="operande3">
                  <input name="operande3" type="text" onfocus="monTour(3); count(event,3);" onselect="this.value=''" onkeypress="return checkIt(event)" onkeyup="count(event,3)" size="12" maxlength="10">
                </div> 
				</td>
                <td width="28">&nbsp;</td>
                <td width="59"> 
				   <div id="efface">
                      <input type="button" value="Effacer" name="efface1" style="font-size: 8pt" onclick="document.info.operande3.value='';document.info.operande3.focus();">
                  </div></td>
              </tr>
              <tr>
                <td align="right"> 
				  <div id="groupe2">
                    <input type="button" value=" + " name="plus" onclick="document.info.operation1.value=' + '; document.info.operande1.focus();">
                    <input type="button" value=" - " name="moin" onclick="document.info.operation1.value=' - '; document.info.operande1.focus();">
                  </div>
				 </td>
                <td>&nbsp;</td>
                <td align="right"> 
				<div id="bouton">
                  <input type="button" name="operation1" onclick="document.info.operande1.value='';document.info.operande1.focus();" size="1" value="   ">
                </div> 
				  </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td> <input name="operande1" type="text" onfocus="monTour(1); count(event,1);" onselect="this.value=''" onkeypress="return checkIt(event)" onkeyup="count(event,1)" size="12" maxlength="10">
                </td>
                <td>&nbsp;</td>
                <td> <input type="button" value="Effacer" name="efface2" style="font-size: 8pt" onclick="document.info.operande1.value='';document.info.operande1.focus();">
                </td>
              </tr>
              <tr>
                <td align="right">
				  <div id="groupe3">
                    <input type="button" value=" + " name="plus" onclick="document.info.operation.value=' + '; document.info.operande2.focus();">
                    <input type="button" value=" - " name="moin" onclick="document.info.operation.value=' - '; document.info.operande2.focus();">
                  </div>
				 </td>
                <td>&nbsp;</td>
                <td align="right">
				<input type="button" name="operation" size="1" value="   " onClick="document.info.operande2.value='';document.info.operande2.focus();" >
                </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td> <input name="operande2" type="text" onfocus="monTour(2); count(event,2);" onselect="this.value=''" onkeypress="return checkIt(event)" onkeyup="count(event,2)" size="12" maxlength="10">
                </td>
                <td>&nbsp;</td>
                <td> <input type="button" value="Effacer" name="efface3" style="font-size: 8pt" onclick="document.info.operande2.value='';document.info.operande2.focus();">
                </td>
              </tr>
              <tr>
                <td><div align="right">
                    <input name="effacetout" type="button" id="effacetout3" style="font-size: 8pt"
					onClick="document.info.resultat1.value=''; document.info.operande1.value='';
							 document.info.operande2.value=''; document.info.operande3.value='';
							 document.info.operation1.value='   '; document.info.operation.value='   ';
							 document.info.operande1.focus();" value="Effacer l'op&eacute;ration">
                  </div></td>
                <td>&nbsp;</td>
                <td colspan="2"><hr align="left" color="#000000"> </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="right"> <input type="button" name="egale1" size="1" value=" = " onclick="resultat();count(event,4);monTour(4);">
                </td>
                <td> <input name="resultat1" type="text" onfocus="monTour(4); count(event,4);" onselect="this.value=''" onkeypress="return checkIt(event)" onkeyup="count(event,4)" size="12" maxlength="10">
                </td>
                <td>&nbsp;</td>
                <td> <input type="button" value="Effacer" name="efface4" style="font-size: 8pt" onclick="document.info.resultat1.value='';document.info.resultat1.focus();">
                </td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td height="30" align="center"> <input type="button" name="B2" value="Ecrire le calcul dans la feuille" onClick="verifCal();"></td>
        </tr>
      </table></td>
    <td width="56" rowspan="2" valign="top"></td>
    <td width="335" height="537" valign="top">
	<h4 align="left">Ecris tes calculs et ta r&eacute;ponse dans cette feuille</h4>
	  <input name="retour" type="button" value="Passer &agrave; la ligne" onClick="emoticon('\n');document.info.zonetexte.focus();">
      <input name="effacer" type="button" id="effacer2" value="Effacer la feuille"
	  	onClick="document.info.zonetexte.value='';document.info.zonetexte.focus();">
      <textarea name="zonetexte" cols="50" rows="28" wrap="hard" tabindex="1"
             onSelect="storeCaret(this);"
             onChange="storeCaret(this);"
			 onMouseOver=""
             onClick="storeCaret(this);"
             onKeyUp="storeCaret(this);"></textarea> </td>
  </tr>
  <tr>
    <td align="center" valign="top">
<input name="button" type="button" value="                 Exercice termin&eacute                " onClick="verifForm(); " tabindex="2">
    </td>
  </tr>
</table>
<input name="oper1" type="hidden">
<input name="oper2" type="hidden">
</form>
<div align="center"><a href="javascript:;" onClick="window.close();">Abandonner</a></div>

</body>
</html>