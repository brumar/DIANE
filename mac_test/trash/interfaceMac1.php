<html>
<head>
<title>Interface</title>
<SCRIPT language=JavaScript>
//*******fontion pour masquer les champs operande3 *********
function masquer()
{
document.info.operande1.focus();
if (document.info.R1[1].checked)
	{
	document.getElementById('zoneText').style.visibility = "visible";
	document.getElementById('bouton').style.visibility = "visible";
	}
else if (document.info.R1[0].checked)
	{
	document.getElementById('zoneText').style.visibility = "hidden";
	document.getElementById('bouton').style.visibility = "hidden";
	}
}

//*******fonction pour permettre d'afficher que des entiers***********
function checkIt(evt) {
	evt = (evt) ? evt : window.event
	var charCode = (evt.which) ? evt.which : evt.keyCode
	if ((charCode > 31 && (charCode < 48 || charCode > 57)) && (charCode != 44))
        {
		status = "ce champ accepte que les entiers."
		return false
	}
	status = ""
	return true
}

//******fonction pour sauvegarder les mots dans le text area
function save(mot)
{
document.info.zonetexte.value=document.info.zonetexte.value+mot+" ";
}

//**********choix du signe*********
function operat(val)
{
switch(val)
{
case "+" : document.info.operation.value=" + ";
		   document.info.operation1.value=" + ";
		   break;
case "-" : document.info.operation.value=" - ";
		   document.info.operation1.value=" - ";
		   break;
case "x" : document.info.operation.value=" x ";
		   document.info.operation1.value=" x ";
		   break;
case "/" : document.info.operation.value=" / ";
		   document.info.operation1.value=" / ";
		   break;

}
}

//************choix de la zone de texte****************
function monTour(n)
{
switch(n)
{
case 1 : test="1";
		 break;
case 2 : test="2";
		 break;
case 3 : test="3";
		 break;
default : test ="1";
		  break;
}
}

//************function affichage des nombre dans les operandes********
function afficher(x)
{
switch(test)
{
case "1" : document.info.operande1.value=document.info.operande1.value+x;
		   document.info.operande1.focus();
		   break;
case "2" : document.info.operande2.value=document.info.operande2.value+x;
		   document.info.operande2.focus();
		   break;
case "3" : document.info.operande3.value=document.info.operande3.value+x;
		   document.info.operande3.focus();
		   break;
default :  document.info.operande1.value=document.info.operande1.value+x;
		   document.info.operande1.focus();
		   break;

}
}
//alert(test);
//if (document.info.operation.value=="")
//	document.info.operande1.value=document.info.operande1.value+x;
//else
	//document.info.operande2.value=document.info.operande2.value+x;
//}

//********fonction qui evalue le resultat de l'operation
function resultat() {
	if ((document.info.operande1.value == "") || (document.info.operande2.value == ""))
	alert ("remplissez tous les champs\n avant de faire une operation");

switch(document.info.operation.value)
{
case " + " : conc = document.info.operande1.value + "+" + document.info.operande2.value;
		   break;
case " - " : conc = document.info.operande1.value + "-" + document.info.operande2.value;
            if (eval(conc)<0)
			{
			alert ("tu as inverser ta soustraction\natention la prochaine fois");
			y = document.info.operande1.value;
			document.info.operande1.value =document.info.operande2.value;
			document.info.operande2.value = y;
			conc = document.info.operande1.value + "-" + document.info.operande2.value;
			}
            break;
case " x " : conc = document.info.operande1.value + "*" + document.info.operande2.value;
		   break;
case " / " : conc = document.info.operande1.value + "/" + document.info.operande2.value;
		   break;
}
var x=0;
var x = 0;
    x = eval(conc);
    window.document.info.resultat1.value = x;
//if (document.info.operation.value == "x")
//		conc=document.info.operande1.value+"*"+document.info.operande2.value;
//	else
//		if document
//conc=document.info.operande1.value+document.info.operation.value+document.info.operande2.value;
//  	var x = 0;
//  	x = eval(conc);
//    window.document.info.resultat1.value = x;
 }

//********fonction qui affiche l'operation dans le textarea*************
function afficheCal()
{
ligne ="-"
op1="  "+document.info.operande1.value+"\n";
n1=op1.length;
op2="  "+document.info.operande2.value+"\n";
n2=op2.length;
result=document.info.resultat1.value+"\n";
op = document.info.operation.value+"\n";
if (n1 < n2)
{
	n3=n2-n1;
	for(i=0 ; i< n3 ;i++)
		op1=" "+op1;
}
else if(n2 < n1)
{
	n3=n1-n2;
	for(i=0 ; i< n3 ;i++)
		op2=" "+op2;
}
for (i=0; i < op1.length-1 ;i++)
	ligne = ligne+"-";
x = "\n"+op1+op+op2+ligne+"\n"+"= "+ result;
document.info.zonetexte.value=document.info.zonetexte.value+x;
}
</SCRIPT>
<script LANGUAGE="JavaScript">
//*********fonction qui enregiste les caractere pour IE dans le textarea**********
function storeCaret (textEl)
{
if (textEl.createTextRange)
textEl.caretPos = document.selection.createRange().duplicate();
}
function insertAtCaret (textEl, text)
{
if (textEl.createTextRange && textEl.caretPos)
{
var caretPos = textEl.caretPos;
caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ?
text + ' ' : text;
}
else
textEl.value  = text;
}
</script>
</head>
<form name="info">
<body onload="masquer()">
<table border="0" cellpadding="0" cellspacing="0"
style="border-collapse: collapse" align="center" bordercolor="#111111" id="AutoNumber1">
  <tr height="456">
    <td width="513" height="456" valign="top">
  <table border="0" cellpadding="0" cellspacing="5" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber2" height="457">
  <tr height="98">
    <td align="center" width="100%" height="98" valign="top">
    <div align="left">
    <?php
require_once("conn.php");

$Requete_SQL2 = "SELECT * FROM comparaison where numero=9";
$result = mysql_query($Requete_SQL2) or die("Erreur de S&eacute;lection
dans la base : ". $Requete_SQL2 .'<br />'. mysql_error());

$nombreExemple = 1;
//while ($enregistrement = mysql_fetch_array($result))
//while ($enregistrement = mysql_fetch_object($result))
while ($enregistrement = mysql_fetch_assoc($result))
{
      $text1 =  $enregistrement["enonce1"];
      $text2 =  $enregistrement["question2"];
      $text3 =  $enregistrement["enonce2"];
      $text4 =  $enregistrement["question2"];
}


  for($piece = strtok($text1, " "); $piece != "" ; $piece = strtok(" "))
  {
      $piece1 = $piece;
      if ($piece == "'")
      $piece1 = "\'";
      print("<a href=\"javascript:;\"
onClick=\"document.info.T1.value='".$piece1."'\">".$piece."</a>"." ");
  }
  print("<Br>");

  for($piece = strtok($text2, " "); $piece != "" ; $piece = strtok(" "))
  {
      $piece1 = $piece;
      if ($piece == "'")
      $piece1 = "\'";
      print("<a href=\"javascript:;\" onClick=\"document.info.T1.value='".$piece1."'\">".$piece."</a>"." ");
  }
  print("<Br>");

  for($piece = strtok($text3, " "); $piece != "" ; $piece = strtok(" "))
  {
      $piece1 = $piece;
      if ($piece == "'")
      $piece1 = "\'";
      print("<a href=\"javascript:;\" onClick=\"document.info.T1.value='".$piece1."'\">".$piece."</a>"." ");
  }
  print("<Br>");

  for($piece = strtok($text4, " "); $piece != "" ; $piece = strtok(" "))
  {
      $piece1 = $piece;
      if ($piece == "'")
      $piece1 = "\'";
      print("<a href=\"javascript:;\" onClick=\"document.info.T1.value='".$piece1."'\">".$piece."</a>"." ");
  }
  print("<Br>");
  mysql_close();
?>
  	</div>
	    </td>
      </tr>
      <tr height="58">
      	<td width="105%" height="58">
			 <div align="center">
				<input type="text" name="T1" size="24" rows="1" cols="20">
				<input type="button" value="Ajouter"onclick="save(this.form.T1.value);">
			</div>
	    </td>
      </tr>
      <tr height="34">
        <td width="63%" valign="top" height="34" align="center">
       	<p align="left">
       	<input type="radio" value="1" checked name="R1" onclick="masquer();">Une opération
       	<input type="radio" name="R1" value="2" onclick="masquer();">Deux opération
       	</td>
      </tr>
      <tr height="24">
        <td width="63%" valign="top" height="1" align="center">
        <input type="button" value="  1  " name="un" onclick="afficher(1);">
        <input type="button" value="  2  " name="deux" onclick="afficher(2);">
        <input type="button" value="  3  " name="trois" onclick="afficher(3);">
        <input type="button" value="  4  " name="quatre" onclick="afficher(4);">
        <input type="button" value="  5  " name="cinq" onclick="afficher(5);">
        <input type="button" value="  6  " name="six" onclick="afficher(6);">
        <input type="button" value="  7  " name="sept" onclick="afficher(7);">
        <input type="button" value="  8  " name="huit" onclick="afficher(8);">
        <input type="button" value="  9  " name="neuf" onclick="afficher(9);">
        <input type="button" value="  0  " name="zero" onclick="afficher(0);">
        </td>
      </tr>

      <tr height="24">
        <td width="63%" valign="top" height="46" align="center">
        <input type="button" value="+" name="plus" onclick="operat(document.info.plus.value);">
        <input type="button" value="-" name="moin" onclick="operat(document.info.moin.value);">
        <input type="button" value="x" name="mult" onclick="operat(document.info.mult.value);">
        <input type="button" value="/" name="div"  onclick="operat(document.info.div.value);">
        </td>
      </tr>

      <tr height="189">
        <td align="center" width="100%" height="219">
        <table width="45%" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" id="AutoNumber3" height="158">
          <tr height="159">
            <td width="48%" height="158">
              <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" id="AutoNumber4" width="123">
                <tr>
                  <td align="center" width="77">&nbsp;</td>
                  <td align="center" width="37">&nbsp;</td>
                  <td width="74">&nbsp;</td>
                  <td width="98">
                      <span id="zoneText">
                            <input type="text" name="operande3" size="10" onkeypress="return checkIt(event)" onselect="this.value=''" onfocus="monTour(3)">
                      </span>
                  </td>
                  <td width="99">&nbsp;</td>
                  <td width="179">&nbsp;</td>
                </tr>
                <tr>
                  <td align="center" width="77">&nbsp;</td>
                  <td align="center" width="37">
                      <span id="bouton">
                            <input type="button" name="operation1" size="1">
                      </span>
                  </td>
                  <td width="74">&nbsp;</td>
                  <td width="98">&nbsp;</td>
                  <td width="99">&nbsp;</td>
                  <td width="179">&nbsp;</td>
                </tr>
                <tr>
                  <td align="center" width="77">&nbsp;</td>
                  <td align="center" width="37">&nbsp;</td>
                  <td width="74">&nbsp;</td>
                  <td width="98">
                      <input type="text" name="operande1" size="10" onkeypress="return checkIt(event)" onfocus="monTour(1)" onselect="this.value=''">
                  </td>
                  <td width="99">&nbsp;</td>
                  <td width="179">&nbsp;</td>
                </tr>
                <tr>
                  <td align="center" width="77">&nbsp;</td>
                  <td align="center" width="37">
                      <input type="button" name="operation" size="1" onclick="document.info.operande2.focus()">
                  </td>
                  <td width="74">&nbsp;</td>
                  <td width="98">&nbsp;</td>
                  <td width="99">&nbsp;</td>
                  <td width="179">&nbsp;</td>
                </tr>
                <tr>
                  <td align="center" width="77">&nbsp;</td>
                  <td align="center" width="37">&nbsp;</td>
                  <td width="74">&nbsp;</td>
                  <td width="98">
                      <input type="text" name="operande2" size="10" onkeypress="return checkIt(event)" onfocus="monTour(2)" onselect="this.value=''">
                  </td>
                  <td width="99">&nbsp;</td>
                  <td width="179">&nbsp;</td>
                </tr>
                <tr>
                  <td align="center" width="77">&nbsp;</td>
                  <td align="center" width="37">&nbsp;</td>
                  <td width="74">&nbsp;</td>
                  <td width="98">&nbsp;</td>
                  <td width="99">&nbsp;</td>
                  <td width="179">&nbsp;</td>
                </tr>
                <tr>
                  <td align="center" width="77">&nbsp;</td>
                  <td align="center" width="37">
                      <input type="button" name="egale1" size="1" value=" = " onclick="resultat();">
                  </td>
                  <td width="74">&nbsp;</td>
                  <td width="98">
                      <input type="text" name="resultat1" size="10" onkeypress="return checkIt(event)">
                  </td>
                  <td width="99">&nbsp;</td>
                  <td width="179">&nbsp;</td>
                </tr>
              </table>
              </center>
            </td>
          </tr>
        </table>
		<p>
		<input type="button" name="B2" value="Ecrire le calcule dans la zone de texte" onclick="afficheCal()">
      </td>

     </tr>

    </table>
    </td>
    <td width="351" height="456" valign="top">
	  <div align="center">
		 <textarea rows="31" name="zonetexte" cols="53" tabindex="1"
             onmouseover="this.focus();"
              onselect="storeCaret(this);"
             onclick="storeCaret(this);"
             onkeyup="storeCaret(this);"
             onchange="storeCaret(this);"></textarea>
         <input type="button" value="Valider la solution">
      </div>
	</td>

  </tr>
</table>

</form>
</body>

</html>
