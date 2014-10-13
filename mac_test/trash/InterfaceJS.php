<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Interface</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<SCRIPT language=JavaScript>
//**********************************fontion pour masquer les champs operande3 *******************************
//*******************************************************************************************************************
function masquer()
{
if (document.info.R1[1].checked)
	{
	
	document.getElementById('zoneText').style.visibility = "visible";
	document.getElementById('bouton').style.visibility = "visible";
	document.getElementById('groupe1').style.visibility = "hidden";
	document.getElementById('groupe2').style.visibility = "visible";
	document.getElementById('groupe3').style.visibility = "visible";
	document.getElementById('efface').style.visibility = "visible";
	document.info.operande3.focus();
	document.info.operation.value = '  ';
	document.info.operation1.value = '  ';
	}
else if (document.info.R1[0].checked)
	{
	document.info.operande1.focus();
	document.info.operation.value = '  ';
	document.getElementById('zoneText').style.visibility = "hidden";
	document.getElementById('bouton').style.visibility = "hidden";
	document.getElementById('groupe1').style.visibility = "visible";
	document.getElementById('groupe2').style.visibility = "hidden";
	document.getElementById('groupe3').style.visibility = "hidden";
	document.getElementById('efface').style.visibility = "hidden";

	}
}
//***********************fontion qui limite les nombre apres la virgule ************************
//***********************************************************************************************
			var max = 10;
			function count(e,oper) {
				
				if (!e.which) keyCode = event.keyCode; // ie5+ op5+
				else keyCode = e.which; // nn6+
				switch(oper)
				{
				case 1 :  if (document.info.operande1.value.length<max+1) 
							{
								x = document.info.operande1.value;
								n = x.indexOf(',');
								if (n != -1)
								{
									document.info.operande1.value = document.info.operande1.value.substring(0,n+3);
								}
							}
							else {
								document.info.operande1.value = document.info.operande1.value.substring(0,max);
								x = document.info.operande1.value;
								n = x.indexOf(',');
								if (n != -1)
								{
									document.info.operande1.value = document.info.operande1.value.substring(0,n+3);
								}

							}
		   					break;
				case 2 : if (document.info.operande2.value.length<max+1) 
							{
								x = document.info.operande2.value;
								n = x.indexOf(',');
								if (n != -1)
								{
									document.info.operande2.value = document.info.operande2.value.substring(0,n+3);
								}
							}
							else {
								document.info.operande2.value = document.info.operande2.value.substring(0,max);
								x = document.info.operande2.value;
								n = x.indexOf(',');
								if (n != -1)
								{
									document.info.operande2.value = document.info.operande2.value.substring(0,n+3);
								}

							}
		   					break;
		  			case 3 : if (document.info.operande3.value.length<max+1) 
							{
								x = document.info.operande3.value;
								n = x.indexOf(',');
								if (n != -1)
								{
									document.info.operande3	.value = document.info.operande3.value.substring(0,n+3);
								}
							}
							else {
								document.info.operande3.value = document.info.operande3.value.substring(0,max);
								x = document.info.operande1.value;
								n = x.indexOf(',');
								if (n != -1)
								{
									document.info.operande3.value = document.info.operande3.value.substring(0,n+3);
								}

							}
		   					break;
				case 4 : if (document.info.resultat1.value.length<max+1) 
							{
								x = document.info.resultat1.value;
								n = x.indexOf(',');
								if (n != -1)
								{
									document.info.resultat1.value = document.info.resultat1.value.substring(0,n+3);
								}
							}
							else {
								document.info.resultat1.value = document.info.resultat1.value.substring(0,max);
								x = document.info.resultat1.value;
								n = x.indexOf(',');
								if (n != -1)
								{
									document.info.resultat1.value = document.info.resultat1.value.substring(0,n+3);
								}

							}
		   					break;
				}
			}


//************************fonction pour permettre d'afficher que des entiers*******************************
//*********************************************************************************************************

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

//**********************fonction pour sauvegarder les mots dans le text area**********************************
//************************************************************************************************************
function save(mot)
{
document.info.zonetexte.value=document.info.zonetexte.value+mot+" ";
}

//****************************choix du signe*****************************
//**********************************************************************************************
function operat(val)
{
switch(val)
{
case "+" : document.info.operation.value=" + ";
		   break;
case "-" : document.info.operation.value=" - ";
		   break;
case "x" : document.info.operation.value=" x ";
		   break;
case ":" : document.info.operation.value=" : ";
		   break;
}
}

//************choix de la zone de texte****************
//*****************************************************
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
case 4 : test="4";
		 break;
default : test ="1";
		  break;
}
}

//*******************function affichage des nombre dans les operandes************************
//********************************************************************************************

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
case "4" : document.info.resultat1.value=document.info.resultat1.value+x;
		   document.info.resultat1.focus();
		   break;
default :  document.info.operande1.value=document.info.operande1.value+x;
		   document.info.operande1.focus();
		   break;

}
}


//*************************fonction qui evalue le resultat de l'operation********************************************
//*******************************************************************************************************************
function resultat() {
if (document.info.R1[0].checked)
	{
	if ((document.info.operande1.value == "") || (document.info.operande2.value == "")|| document.info.operation.value == "   ")
	{
		alert ("remplissez tous les champs\n avant de faire une operation");
	}
	var x =0;
	//alert(document.info.operande1.value.replace(',','.'));
	switch(document.info.operation.value)
		{
			case " + " : conc = document.info.operande1.value.replace(',','.') + "+" + document.info.operande2.value.replace(',','.');
		  				 x = eval(conc);
						 x = x.toString();
						 window.document.info.resultat1.value = x.replace('.',',');
		  				 break;

			case " - " : conc = document.info.operande1.value.replace(',','.') + "-" + document.info.operande2.value.replace(',','.');
            			if (eval(conc) < 0)
						{
							alert ("tu as inverser ta soustraction\natention la prochaine fois");
							y = document.info.operande1.value;
							document.info.operande1.value = document.info.operande2.value;
							document.info.operande2.value = y;
							conc = document.info.operande1.value.replace(',','.') + "-" + document.info.operande2.value.replace(',','.');
						}
						x = eval(conc);
						x = x.toString();
    	   				window.document.info.resultat1.value = x.replace('.',',');
           				break;
		   case " x " : conc = document.info.operande1.value.replace(',','.') + "*" + document.info.operande2.value.replace(',','.');
					    x = eval(conc);
						x = x.toString();
		   			    window.document.info.resultat1.value = x.replace('.',',');
		   			    break;
		   case " : " : if (document.info.operande2.value == 0)
		   					{
		   					alert("La division par zero est impossible");
		   					break;
		   					}
		   				conc = document.info.operande1.value.replace(',','.') + "/" + document.info.operande2.value.replace(',','.');
     				    x = eval(conc);
						x = x.toString();
		   			    window.document.info.resultat1.value = x.replace('.',',');
		   			    break;
		}


	}
else if (document.info.R1[1].checked)
	{
	if ((document.info.operande1.value == "") || (document.info.operande2.value == "")||(document.info.operande3.value == ""))
	{
		alert ("remplissez tous les champs\n avant de faire un calcul");
	}
	var x =0;
	switch(document.info.operation1.value)
		{
			case " + " : switch(document.info.operation.value)
						{
						 case " + " : conc = document.info.operande3.value.replace(',','.') + "+" + document.info.operande1.value.replace(',','.') + "+" + document.info.operande2.value.replace(',','.');
		  				 			  x = eval(conc);
									  x = x.toString();
		   				 			  window.document.info.resultat1.value = x.replace('.',',');
		  				 			  break;
		  				 case " - " : conc = document.info.operande3.value.replace(',','.') + "+" + document.info.operande1.value.replace(',','.') + "-" + document.info.operande2.value.replace(',','.');
		  				 			  x = eval(conc);
									  x = x.toString();
		   				 			  window.document.info.resultat1.value = x.replace('.',',');
		  				 			  break;
						}
						break;
			case " - " :switch(document.info.operation.value)
						{
						 case " + " : conc = document.info.operande3.value.replace(',','.') + "-" + document.info.operande1.value.replace(',','.') + "+" + document.info.operande2.value.replace(',','.');
		  				 			  x = eval(conc);
									  x = x.toString();
		   				 			  window.document.info.resultat1.value = x.replace('.',',');
		  				 			  break;
		  				 case " - " : conc = document.info.operande3.value.replace(',','.') + "-" + document.info.operande1.value.replace(',','.') + "-" + document.info.operande2.value.replace(',','.');
		  				 			  x = eval(conc);
									  x = x.toString();
		   				 			  window.document.info.resultat1.value = x.replace('.',',');
		  				 			  break;
						}	
						break;

		}


	}
	
}

//******************fonction qui affiche l'operation dans le textarea****************************
//***********************************************************************************************
function afficheCal()
{
ligne ="-";
op1="  "+document.info.operande1.value+"\n";
n1=op1.length;
op2="  "+document.info.operande2.value+"\n";
n2=op2.length;

result=document.info.resultat1.value+"\n";
op = document.info.operation.value+"\n";
opp = document.info.operation1.value+"\n";
if (document.info.R1[0].checked)
	{
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
else if (document.info.R1[1].checked)
	{
	op4="  "+document.info.operande3.value+"\n";
	n4=op4.length;
	if (n1 < n2)
	{
		if (n2 < n4)
			{
				n5=n4-n1;
				n6=n4-n2;
				for(i=0 ; i< n5 ;i++)
				op1=" "+op1;
			    for(i=0 ; i< n6 ;i++)
				op2=" "+op2;
			}
			else if (n1 < n4)
				{
					n5=n2-n1;
					n6=n2-n4;
					for(i=0 ; i< n5 ;i++)
					op1=" "+op1;
					for(i=0 ; i< n6 ;i++)
					op4=" "+op4;
				}
				else 
					{
						n5=n2-n1;
						n6=n2-n4;
						for(i=0 ; i< n5 ;i++)
						op1=" "+op1;
						for(i=0 ; i< n6 ;i++)
						op4=" "+op4;
					}
	 }		
else 
	 {
			if (n1 < n4)
			{
				n5=n4-n1;
				n6=n4-n2;
				for(i=0 ; i< n5 ;i++)
				op1=" "+op1;
			    for(i=0 ; i< n6 ;i++)
				op2=" "+op2;
			}
		 	else if(n2 < n4)
				 {
					n5=n1-n4;
					n6=n1-n2;
					for(i=0 ; i< n5 ;i++)
					op4=" "+op4;
					for(i=0 ; i< n6 ;i++)
					op2=" "+op2;
				 }
				 else 
					  {
						n5=n1-n2;
						n6=n1-n4;
						for(i=0 ; i< n5 ;i++)
							op2=" "+op2;
						for(i=0 ; i< n6 ;i++)
							op4=" "+op;
					  }
	}
for (i=0; i < op1.length-1 ;i++)
ligne = ligne+"-";
x = "\n"+op4+opp+op1+op+op2+ligne+"\n"+"= "+ result;
document.info.zonetexte.value=document.info.zonetexte.value+x;
	}
}
</SCRIPT>
<script language="JavaScript">
//*********fonction qui enregiste les caractere pour IE dans le textarea**************
//************************************************************************************
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
<body onload="masquer()">
<form name="info">
<table width="95%" height="289" border="1" align="center" cellpadding="5" cellspacing="5">
  <tr>
    <td width="58%" valign="top"> 
      <table width="100%" border="0" cellspacing="5">
          <tr>
          <td>
		    <?php 
			require_once("conn.php");
			$Requete_SQL2 = "SELECT * FROM comparaison where numero=9";
			$result = mysql_query($Requete_SQL2) or die("Erreur de S&eacute;lection dans la base : ". $Requete_SQL2 .'<br />'. mysql_error());
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
				  print("<a href=\"javascript:;\" onClick=\"document.info.T1.value='".$piece1."'\">".$piece."</a>"." ");
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
		  </td>
        </tr>
        <tr>
          <td>
		  	<div align="center">
				<input type="text" name="T1" size="24" rows="1" cols="20">
                <INPUT TYPE="button" VALUE="Ajouter" ONCLICK="insertAtCaret(this.form.zonetexte,this.form.T1.value+' ');">
			</div>
		  </td>
        </tr>
        <tr>
            <td height="41"> 
              <input type="radio" value="1" checked name="R1" onclick="masquer();">Une opération
              <input type="radio" name="R1" value="2" onclick="masquer();">Deux opération
        </tr>
        <tr>
          <td align="center"> 
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
			  <input type="button" value="  ,  " name="zero" onclick="afficher(',');"> 
		  </td>
        </tr>
        <tr>
          <td align="center"> 
            <div id="groupe1"> 
				<input type="button" value=" + " name="plus" onclick="operat('+');">
				<input type="button" value=" - " name="moin" onclick="operat('-');">
				<input type="button" value=" x " name="mult" onclick="operat('x');">
				<input type="button" value=" : " name="div"  onclick="operat(':');">
			  </div>
		  </td>
        </tr>
        <tr>
          <td height="186" valign="top"> 
            <table width="80%" border="0" align="center" cellspacing="0">
              <tr>
                <td width="21%">&nbsp;</td>
                <td width="6%">&nbsp;</td>
                <td width="11%">&nbsp;</td>
                <td width="16%">
				<span id="zoneText"> 
                    <input type="text" name="operande3" size="10" onkeypress="return checkIt(event)" onkeyup="count(event,3)" onselect="this.value=''" onfocus="monTour(3); count(event,3);">
                </span> 
				</td>
                <td width="9%">&nbsp;</td>
                <td width="37%">
				<div id="efface">
						<input type="button" value="Effacer" name="efface1" style="font-size: 8pt" onclick="document.info.operande3.value=''">
				</div>
				</td>
              </tr>
              <tr>
                <td>
				<div id="groupe2"> 
                      <input type="button" value=" + " name="plus" onclick="document.info.operation1.value=' + ';">
                      <input type="button" value=" - " name="moin" onclick="document.info.operation1.value=' - ';">
                </div>
				</td>
                <td>&nbsp;</td>
                <td>
				<span id="bouton"> 
					<input type="button" name="operation1" onclick="document.info.operande1.focus()" size="1" value="   ">
				</span> 
				 </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td> 
					<input type="text" name="operande1" size="10" onkeypress="return checkIt(event)" onkeyup="count(event,1)" onfocus="monTour(1); count(event,1);" onselect="this.value=''"> 
				</td>
                <td>&nbsp;</td>
                <td>
					<input type="button" value="Effacer" name="efface2" style="font-size: 8pt" onclick="document.info.operande1.value=''">
				</td>
              </tr>
              <tr>
                <td>
				<div id="groupe3"> 
                     <input type="button" value=" + " name="plus" onclick="document.info.operation.value=' + ';">
                     <input type="button" value=" - " name="moin" onclick="document.info.operation.value=' - ';">
                </div>
				</td>
                <td>&nbsp;</td>
                <td>
					<input type="button" name="operation" size="1" onclick="document.info.operande2.focus()" value="   ">
				</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>
					<input type="text" name="operande2" size="10" onkeypress="return checkIt(event)" onkeyup="count(event,2)" onfocus="monTour(2); count(event,2);" onselect="this.value=''">
				</td>
                <td>&nbsp;</td>
                <td>
					<input type="button" value="Effacer" name="efface3" style="font-size: 8pt" onclick="document.info.operande2.value=''">
				</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><hr color="#000000"></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>
					<input type="button" name="egale1" size="1" value=" = " onclick="resultat();count(event,4);">
				</td>
                <td>
					<input type="text" name="resultat1" size="10" onselect="this.value=''" onkeypress="return checkIt(event)" onkeyup="count(event,4)" onfocus="monTour(4); count(event,4);">
				</td>
                <td>&nbsp;</td>
                <td>
					<input type="button" value="Effacer" name="efface4" style="font-size: 8pt" onclick="document.info.resultat1.value=''">
				</td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td align="center"> 
            <input type="button" name="B2" value="Ecrire le calcule dans la zone de texte" onclick="afficheCal()">
          </td>
        </tr>
      </table></td>
    <td width="42%" valign="top">
	<p>
        <textarea rows="31" name="zonetexte" cols="53" tabindex="1"
             onmouseover="this.focus();"
             onselect="storeCaret(this);"
             onclick="storeCaret(this);"
             onkeyup="storeCaret(this);"
             onchange="storeCaret(this);"></textarea>
      </p>
      <p>
        <input name="button" type="button" value="Valider la solution">
      </p></td>
  </tr>
</table>
</form>
</body>
</html>