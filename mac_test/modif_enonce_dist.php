<?php 
require_once("conn.php");
$numExo=$_GET["numExo"];
$requeteSQL="select * from distributivite where numero=".$numExo;
$result = mysql_query($requeteSQL) or die ("Requ&ecirc;te incorrecte");
 while ($enregistrement = mysql_fetch_assoc($result))
		{
		  $enonce =  stripslashes($enregistrement["enonce"]);
		  $question =  stripslashes($enregistrement["question"]);
		  $facteur =  $enregistrement["facteur"];
		  $varFacteur = $enregistrement["varFacteur"];
     	  $varFactorise = $enregistrement["varFactorise"];
		  $element=$enregistrement["element"];
		  $element_str=$enregistrement["element_str"];
		  $strategie = $enregistrement["strategie"];
		  $suggestions = $enregistrement["suggestions"];
		  $descripteur = $enregistrement["descripteur"];

		}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Formulaire de saisie des énoncés de distributivité</title>
<SCRIPT LANGUAGE="JavaScript">
/* On crée une fonction de verification */
function verifForm(formulaire)
{
    
    x=formulaire.enonce.value;
    for (i=0 ;i<= x.length-1 ;i++)
    {
     if ((x.charAt(i)==",") || (x.charAt(i)=="-") || (x.charAt(i)=="?") || (x.charAt(i)==".") || (x.charAt(i)==""))//||(x.charAt(i)=="'"))
     {
         if (x.charAt(i-1) != " ")
         {
             x = x.substring(0,i) +" " + x.charAt(i) + x.substring (i+1,x.length);
         }
     }
    }
    for (i=0 ;i<= x.length-1;i++)
    {
     if ((x.charAt(i)==",") || (x.charAt(i)=="-") || (x.charAt(i)=="?") || (x.charAt(i)==".") || (x.charAt(i)==""))
      {
        if (x.charAt(i+1) != " ")
         {
             x = x.substring(0,i) + x.charAt(i)+ " " + x.substring (i+1,x.length);
         }
      }
    }
    formulaire.enonce.value=x;
    x=formulaire.question.value;
    for (i=0 ;i<= x.length-1 ;i++)
    {
     if ((x.charAt(i)==",") || (x.charAt(i)=="-") || (x.charAt(i)=="?") || (x.charAt(i)=="."))//||(x.charAt(i)=="\'"))
     {
         if (x.charAt(i-1) != " ")
         {
             x = x.substring(0,i) +" " + x.charAt(i) + x.substring (i+1,x.length);
         }
     }
    }
    for (i=0 ;i<= x.length-1;i++)
    {
     if ((x.charAt(i)==",") || (x.charAt(i)=="-") || (x.charAt(i)=="?") || (x.charAt(i)=="."))//||(x.charAt(i)=="\'"))
      {
        if (x.charAt(i+1) != " ")
         {
             x = x.substring(0,i) + x.charAt(i)+ " " + x.substring (i+1,x.length);
         }
      }
    }
    formulaire.question.value=x;
 
	if(formulaire.enonce.value == "") /* on detecte si enonce1 est vide */
		{
		alert('Remplissez le champs de l\'enoncé !!'); /* dans ce cas on lance un message d'alerte */
		 }
	else if(formulaire.question.value == "") /* on detecte si enonce1 est vide */
		alert('Remplissez le champs de la question !!'); /* dans ce cas on lance un message d'alerte */
	else
	    formulaire.submit(); /* sinon on envoi le formulaire */
}

function cacher(arg) {
        if (arg==1) 
			{
            document.getElementById('element_structurant').style.visibility='visible';
			document.getElementById('el2').checked=true;
			}
        else 
			{
            document.getElementById('element_structurant').style.visibility='hidden'; 
			document.getElementById('el1').checked=true;
			}
      }
</SCRIPT>
<style type="text/css">
<!--
.tableau1 {
	border-width:1px;
	border-style:solid;
	border-color:black;
	width:30%;
	margin: 5px;
	padding: 1px;
	}
table {
	border-width:1px;
	border-style:solid;
	border-color:black;
	width:45%;
	margin: 3px;
	padding: 3px;
 }
span {
	text-align: left;
	white-space: normal;
	font-weight: bold;
}
-->
</style>

</head>

<body onload="cacher(0);">
<p align="center">
<a href="../index.html">Accueil</a> &nbsp;&nbsp;
<a href="admin.php">Admin</a>&nbsp;&nbsp;
<a href="eleve.html">Elève</a>
</p>
<form method="post" action="traitFormDist.php">
  <div align="center">
    <table class="tableau1">
      <tr>
        <td align="center" bgcolor="#F0F7FA"><span>Probl&egrave;me de Distributivit&eacute;</span></td>
      </tr>
    </table>
  </div>
 
  <div align="center">
    <table class="tableau1">
      <tr>
        <td align="left"><span>Facteur</span></td>
        <?php 
		if($facteur=="debut")
		 {
			 echo('<td><input type="radio" name="facteur" value="debut" checked="checked"/>Premi&egrave;re valeur </td>');
        	 echo('<td><input type="radio" name="facteur" value="fin"/>Deuxi&egrave;me valeur </td>');
		 }
		else if($facteur=="fin")
		 {
			 echo('<td><input type="radio" name="facteur" value="debut"/>Premi&egrave;re valeur </td>');
        	 echo('<td><input type="radio" name="facteur" value="fin" checked="checked"/>Deuxi&egrave;me valeur </td>');
		 }
		?>
        
      </tr>
    </table>
  </div>
  <div align="center">
      <table class="tableau1">
        <tr>
          <td align="left"><span>Type de variable du facteur</span></td>
          <td>
             <select size="1" name="varFacteur">
               <?php 
			switch ($varFacteur)
			{
				case "x" :  echo("<option value=\"x\" selected>Effectifs</option>");
							echo ("<option value=\"y\">Prix</option>");
							echo ("<option value=\"z\">Ages</option>");
							echo ("<option value=\"h\">Taille</option>");
							echo ("<option value=\"p\">Poids</option>");
							echo ("<option value=\"d\">Dur&eacute;e</option>");
							break;
							
				case "y" :  echo("<option value=\"x\">Effectifs</option>");
							echo ("<option value=\"y\" selected>Prix</option>");
							echo ("<option value=\"z\">Ages</option>");
							echo ("<option value=\"h\">Taille</option>");
							echo ("<option value=\"p\">Poids</option>");
							echo ("<option value=\"d\">Dur&eacute;e</option>");
							break;
				case "z" : echo("<option value=\"x\">Effectifs</option>");
							echo ("<option value=\"y\">Prix</option>");
							echo ("<option value=\"z\" selected>Ages</option>");
							echo ("<option value=\"h\">Taille</option>");
							echo ("<option value=\"p\">Poids</option>");
							echo ("<option value=\"d\">Dur&eacute;e</option>");
							break;
				case "h" : echo("<option value=\"x\">Effectifs</option>");
							echo ("<option value=\"y\">Prix</option>");
							echo ("<option value=\"z\">Ages</option>");
							echo ("<option value=\"h\" selected>Taille</option>");
							echo ("<option value=\"p\">Poids</option>");
							echo ("<option value=\"d\">Dur&eacute;e</option>");
							break;
				case "p" : echo("<option value=\"x\">Effectifs</option>");
							echo ("<option value=\"y\">Prix</option>");
							echo ("<option value=\"z\">Ages</option>");
							echo ("<option value=\"h\">Taille</option>");
							echo ("<option value=\"p\" selected>Poids</option>");
							echo ("<option value=\"d\">Dur&eacute;e</option>");
							break;
				case "d" : echo("<option value=\"x\">Effectifs</option>");
							echo ("<option value=\"y\">Prix</option>");
							echo ("<option value=\"z\">Ages</option>");
							echo ("<option value=\"h\">Taille</option>");
							echo ("<option value=\"p\">Poids</option>");
							echo ("<option value=\"d\"  selected>Dur&eacute;e</option>");
							break;
			}
			?>
              </select>		</td>
        </tr>
       </table>
  </div>
<div align="center">
      <table class="tableau1">
        <tr>
          <td align="left"><span>Type de variable des factoris&eacute;s</span></td>
          <td>
            <select size="1" name="varFactorise">
              <?php 
			switch ($varFactorise)
			{
				case "x" :  echo("<option value=\"x\" selected>Effectifs</option>");
							echo ("<option value=\"y\">Prix</option>");
							echo ("<option value=\"z\">Ages</option>");
							echo ("<option value=\"h\">Taille</option>");
							echo ("<option value=\"p\">Poids</option>");
							echo ("<option value=\"d\">Dur&eacute;e</option>");
							break;
							
				case "y" :  echo("<option value=\"x\">Effectifs</option>");
							echo ("<option value=\"y\" selected>Prix</option>");
							echo ("<option value=\"z\">Ages</option>");
							echo ("<option value=\"h\">Taille</option>");
							echo ("<option value=\"p\">Poids</option>");
							echo ("<option value=\"d\">Dur&eacute;e</option>");
							break;
				case "z" : echo("<option value=\"x\">Effectifs</option>");
							echo ("<option value=\"y\">Prix</option>");
							echo ("<option value=\"z\" selected>Ages</option>");
							echo ("<option value=\"h\">Taille</option>");
							echo ("<option value=\"p\">Poids</option>");
							echo ("<option value=\"d\">Dur&eacute;e</option>");
							break;
				case "h" : echo("<option value=\"x\">Effectifs</option>");
							echo ("<option value=\"y\">Prix</option>");
							echo ("<option value=\"z\">Ages</option>");
							echo ("<option value=\"h\" selected>Taille</option>");
							echo ("<option value=\"p\">Poids</option>");
							echo ("<option value=\"d\">Dur&eacute;e</option>");
							break;
				case "p" : echo("<option value=\"x\">Effectifs</option>");
							echo ("<option value=\"y\">Prix</option>");
							echo ("<option value=\"z\">Ages</option>");
							echo ("<option value=\"h\">Taille</option>");
							echo ("<option value=\"p\" selected>Poids</option>");
							echo ("<option value=\"d\">Dur&eacute;e</option>");
							break;
				case "d" : echo("<option value=\"x\">Effectifs</option>");
							echo ("<option value=\"y\">Prix</option>");
							echo ("<option value=\"z\">Ages</option>");
							echo ("<option value=\"h\">Taille</option>");
							echo ("<option value=\"p\">Poids</option>");
							echo ("<option value=\"d\"  selected>Dur&eacute;e</option>");
							break;
			}
			?>
          </select>		</td>
        </tr>
      </table>
    </div>
<div align="center">
 <table class="tableau1">
      <tr>
        <td align="left"><span>El&eacute;ment structurant</span></td>
        <?php 
		if($element=="absent")
		 {
        echo ('<td><input type="radio" name="element" id="el1" value="absent" checked="checked" onclick="cacher(0)"/>Absent</td>');
        echo ('<td><input type="radio" name="element" id="el2" value="present" onclick="cacher(1)"/>Pr&eacute;sent</td>');
		 }
		else if($element=="present")
		 {
        echo ('<td><input type="radio" name="element" id="el1" value="absent" onclick="cacher(0)"/>Absent</td>');
        echo ('<td><input type="radio" name="element" id="el2" value="present" checked="checked" onclick="cacher(1)"/>Pr&eacute;sent</td>');
		 }
		 ?>
      </tr>
    </table>
    </div>
 <div align="center" id="element_structurant">
        <table class="tableau1">
          <tr>
           <td align="center"><textarea name="element_str" cols="40" rows="1" wrap="virtual" id="element_str"><?php echo $element_str ; ?></textarea></td>
          </tr>
        </table>
      </div>
  <div align="center">
    <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" id="AutoNumber3">
      <tr>
        <td width="100%" align="left"><span>Enonc&eacute;</span></td>
      </tr>
      <tr>
        <td width="100%" align="center"><textarea name="enonce" cols="55" rows="10" wrap="virtual"><?php echo $enonce; ?></textarea></td>
      </tr>
      <tr>
        <td width="100%" align="left"><span> Question</span></td>
      </tr>
      <tr>
        <td width="100%" align="center"><textarea name="question" cols="55" rows="2" wrap="virtual"><?php echo $question; ?></textarea></td>
      </tr>
    </table>
  </div>
   <div align="center">
   <table >
<tr>
          <td align="left"><span>Strat&eacute;gie de r&eacute;solution </span></td>
        </tr>
        <tr>
          <td align="center"><textarea name="strategie" cols="55" rows="2" wrap="VIRTUAL" id="strategie"><?php echo $strategie; ?></textarea></td>
        </tr>
       <tr>
         <td align="left"><span>Description du probl&egrave;me</span></td>
       </tr>
       <tr>
         <td align="center"><textarea name="description" cols="55" rows="2" wrap="VIRTUAL"><?php echo $descripteur; ?></textarea></td>
       </tr>
       <tr>
            <td align="left"><span>Suggestions</span></td>
          </tr>
          <tr>
            <td align="center"><textarea name="suggestions" cols="55" rows="2" wrap="virtual" id="suggestions"><?php echo $suggestions; ?></textarea></td>
          </tr>
     </table>
     
   </div>
  <div align="center">
	 <?php echo('<input name="numExo" value="'.$numExo.'" type="hidden">');?>
     <input type="button" value="Envoyer" name="B1" onclick="verifForm(this.form)" />
     <input type="reset" value="Effacer tout" name="B2" />
  </div>
</form>
</body>
</html>
