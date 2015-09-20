<?php 
require_once("conn.php");
$numExo=$_GET["numExo"];
$typeExo=$_GET["typeExo"];
$requeteSQL="select * from ".$typeExo." where numero=".$numExo;
$result = mysql_query($requeteSQL) or die ("Requ&ecirc;te incorrecte");
 while ($enregistrement = mysql_fetch_assoc($result))
		{
		  $enonce1 =  stripslashes($enregistrement["enonce1"]);
		  $question1 =  stripslashes($enregistrement["question1"]);
		  $enonce2 =  stripslashes($enregistrement["enonce2"]);
		  $question2=  stripslashes($enregistrement["question2"]);
		  $question= $enregistrement["question"];
  		  $variable = $enregistrement["variable"];
		  $natVar = $enregistrement["natVar"];
		  $tendance = $enregistrement["tendance"];
		  $taille_nombre =$enregistrement["taille_nombre"];
		  $ordre_donnees = $enregistrement["ordre_donnees"];
		  $strategie = $enregistrement["strategie"];
		  $suggestions = $enregistrement["suggestions"];
		  $descripteur = $enregistrement["descripteur"];

		}
?>
<!doctype html public "-//W3C//DTD HTML 4.0 //EN"> 
<html>
<title>Formulaire de saisie des ennonc&eacute;s </title>

<SCRIPT LANGUAGE="JavaScript">
/* On cr&eacute;e une fonction de verification */
function verifForm(formulaire)
{
    
    x=formulaire.enonce1.value;
    for (i=0 ;i<= x.length-1 ;i++)
    {
     if ((x.charAt(i)==",") || (x.charAt(i)=="-") || (x.charAt(i)=="?") || (x.charAt(i)=="."))//||(x.charAt(i)=="'"))
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
    formulaire.enonce1.value=x;
    x=formulaire.question1.value;
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
    formulaire.question1.value=x;
    x=formulaire.enonce2.value;
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
    formulaire.enonce2.value=x;
    x=formulaire.question2.value;
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
    formulaire.question2.value=x;
    
if(formulaire.enonce1.value == "") /* on detecte si enonce1 est vide */
    {
    alert('Remplissez le champs de enonc&eacute;1 !!'); /* dans ce cas on lance un message d'alerte */
     }
 /* else if(formulaire.question1.value == "")on detecte si enonce1 est vide */
        /*alert('Remplissez le champs de la question1 !!');  dans ce cas on lance un message d'alerte */
     else if(formulaire.enonce2.value == "") /* on detecte si enonce1 est vide */
            alert('Remplissez le champs de enonc&eacute;2 !!'); /* dans ce cas on lance un message d'alerte */
          else if(formulaire.question2.value == "") /* on detecte si enonce1 est vide */
                 alert('Remplissez le champs de question2 !!'); /* dans ce cas on lance un message d'alerte */
             else
			 formulaire.submit(); /* sinon on envoi le formulaire */
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


</head>

<body>
<p align="center">
<a href="index.php">Accueil</a> &nbsp;&nbsp;
<a href="profil_enseignant.php">Interface Enseignant</a>&nbsp;&nbsp;
<a href="eleve.html">El&egrave;ve</a>
</p>
<form method="POST" action="traitementSaisie.php">
  <div align="center">
    <table class="tableau1">
      <tr>
        <td align="left"><span>Type de probl&egrave;me </span></td> 
		<?php 
			if($typeExo=="complement")
			{   
				echo ("<td align=\"left\"><input type=\"radio\" name=\"typePB\" value=\"e\" checked>Compl&eacute;ment </td>");
				echo ("<td align=\"left\"><input type=\"radio\" name=\"typePB\" value=\"a\">Comparaison </td>");
			}
			if($typeExo=="comparaison")
			{   
				echo ("<td align=\"left\"><input type=\"radio\" name=\"typePB\" value=\"e\">Compl&eacute;ment </td>");
				echo ("<td align=\"left\"><input type=\"radio\" name=\"typePB\" value=\"a\" checked>Comparaison </td>");
			}
        ?>
      </tr>
   	</table>
  </div>
  <div align="center">
    <table class="tableau1">
      <tr>
        <td width="51%" align="left"><span>La question porte sur  </span></td>
        <td width="26%" align="left"> 
		<?php 
			if ($question=="t")
			{
				echo ("<input type=\"radio\" name=\"question\" value=\"t\" checked>Tout</td>");
				echo ("<td width=\"23%\" align=\"left\">");
				echo ("<input type=\"radio\" name=\"question\" value=\"p\">Partie</td>");
			}
			else if ($question=="p")
			{
				echo ("<input type=\"radio\" name=\"question\" value=\"t\">Tout</td>");
				echo ("<td width=\"23%\" align=\"left\">");
				echo ("<input type=\"radio\" name=\"question\" value=\"p\" checked>Partie</td>");
			}

		 ?>
      	</tr>
    </table>
  </div>
  <div align="center">
    <table class="tableau1" >
      <tr>
        <td align="left"><span>Type de variable </span></td>
        <td> 
         <select size="1" name="variable">
		<?php 
			switch ($variable)
			{
				case "x" :  echo("<option value=\"x\" selected>Effectifs --&gt; (Personnes ou Objets) </option>");
							echo ("<option value=\"y\">Prix</option>");
							echo ("<option value=\"z\">Ages</option>");
							echo ("<option value=\"h\">Taille</option>");
							echo ("<option value=\"p\">Poids</option>");
							echo ("<option value=\"d\">Dur&eacute;e</option>");
							break;
							
				case "y" :  echo("<option value=\"x\">Effectifs --&gt; (Personnes ou Objets) </option>");
							echo ("<option value=\"y\" selected>Prix</option>");
							echo ("<option value=\"z\">Ages</option>");
							echo ("<option value=\"h\">Taille</option>");
							echo ("<option value=\"p\">Poids</option>");
							echo ("<option value=\"d\">Dur&eacute;e</option>");
							break;
				case "z" : echo("<option value=\"x\">Effectifs --&gt; (Personnes ou Objets) </option>");
							echo ("<option value=\"y\">Prix</option>");
							echo ("<option value=\"z\" selected>Ages</option>");
							echo ("<option value=\"h\">Taille</option>");
							echo ("<option value=\"p\">Poids</option>");
							echo ("<option value=\"d\">Dur&eacute;e</option>");
							break;
				case "h" : echo("<option value=\"x\">Effectifs --&gt; (Personnes ou Objets) </option>");
							echo ("<option value=\"y\">Prix</option>");
							echo ("<option value=\"z\">Ages</option>");
							echo ("<option value=\"h\" selected>Taille</option>");
							echo ("<option value=\"p\">Poids</option>");
							echo ("<option value=\"d\">Dur&eacute;e</option>");
							break;
				case "p" : echo("<option value=\"x\">Effectifs --&gt; (Personnes ou Objets) </option>");
							echo ("<option value=\"y\">Prix</option>");
							echo ("<option value=\"z\">Ages</option>");
							echo ("<option value=\"h\">Taille</option>");
							echo ("<option value=\"p\" selected>Poids</option>");
							echo ("<option value=\"d\">Dur&eacute;e</option>");
							break;
				case "d" : echo("<option value=\"x\">Effectifs --&gt; (Personnes ou Objets) </option>");
							echo ("<option value=\"y\">Prix</option>");
							echo ("<option value=\"z\">Ages</option>");
							echo ("<option value=\"h\">Taille</option>");
							echo ("<option value=\"p\">Poids</option>");
							echo ("<option value=\"d\"  selected>Dur&eacute;e</option>");
							break;
			}
			?>
            </select></td>
     </table>
  </div>
  <div align="center">
    <table class="tableau1">
      <tr>
        <td align="left"><span>Tendance </span></td>
        <?php 
			switch ($tendance)
			{
				case "neutre" : echo('<td><input type="radio" name="tendance" value="neutre" checked>Neutre</td></td>');
								echo('<td><input type="radio" name="tendance" value="difference">Diff&eacute;rence</td>');
								echo('<td><input type="radio" name="tendance" value="detape">Etape</td>');
								break;
				case "difference" : echo('<td><input type="radio" name="tendance" value="neutre">Neutre</td></td>');
								echo('<td><input type="radio" name="tendance" value="difference">Diff&eacute;rence</td>');
								echo('<td><input type="radio" name="tendance" value="detape" checked>Etape</td>');
								break;
				case "etape" :  echo('<td><input type="radio" name="tendance" value="neutre">Neutre</td></td>');
								echo('<td><input type="radio" name="tendance" value="difference">Diff&eacute;rence</td>');
								echo('<td><input type="radio" name="tendance" value="detape" checked>Etape</td>');
								break;
			}

		?>
          
   	  </tr>
    </table>
  </div>
  <div align="center">
    <table class="tableau1">
      <tr>
        <td width="45%" align="left"><span>Taille de Nombre</span></td>
        <td width="55%"><input type="text" name="taille_nombre" id="taille_nombre" value="<?php echo ($taille_nombre); ?>"></td>
        
   	  </tr>
      <tr>
        <td align="left"><span>Ordre des donn&eacute;es</span> </td>
          <td><input name="ordre_donnees" type="text" id="ordre_donnees" value="<?php echo ($ordre_donnees); ?>"></td>
      </tr>
    </table>
  </div>
  <div align="center">
     
   <table >
       <tr>
         <td align="left"><span>Enonc&eacute; 1</span></td>
       </tr>
       <tr>
         <td align="center"><textarea name="enonce1" cols="55" rows="4" wrap="VIRTUAL"><?php echo $enonce1; ?></textarea></td>
       </tr>
       <tr>
         <td align="left"><span>Question interm&eacute;diaire</span></td>
       </tr>
       <tr>
         <td align="center"><textarea name="question1" cols="55" rows="2" wrap="VIRTUAL"><?php echo $question1; ?></textarea></td>
       </tr>
       <tr>
         <td align="left"><span>Enonc&eacute; 2</span></td>
       </tr>
       <tr>
         <td align="center"><textarea name="enonce2" cols="55" rows="4" wrap="VIRTUAL"><?php echo $enonce2; ?></textarea></td>
       </tr>
       <tr>
         <td align="left"><span>Question Finale</span></td>
       </tr>
       <tr>
         <td align="center"> <textarea name="question2" cols="55" rows="2" wrap="VIRTUAL"><?php echo $question2; ?></textarea></td>
       </tr>
     </table>
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
  </div>
  <div align="center">
  		<?php echo('<input name="numExo" value="'.$numExo.'" type="hidden">');?>
  		<?php echo('<input name="typeExo" value="'.$typeExo.'" type="hidden">');?>

   		<input type="button" value="Enregistrer" name="B1" onClick="verifForm(this.form)"></td>
  		 <input type="reset" value="Effacer tout" name="B2"></td>
  </div>
</form>

</body>

</html>
