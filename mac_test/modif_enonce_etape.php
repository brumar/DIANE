<?php 
	require_once("conn.php");
	$numExo=$_GET["numExo"];
	$requeteSQL="select * from etape where numero=".$numExo;
	$result = mysql_query($requeteSQL) or die ("Requ&ecirc;te incorrecte");
	while ($enregistrement = mysql_fetch_assoc($result))
		{
		  $enonce =  stripslashes($enregistrement["enonce"]);
		  $question =  stripslashes($enregistrement["question"]);
		  $variable = $enregistrement["variable"];
		  $typePb = $enregistrement["typePb"];
		  $inconnu = $enregistrement["inconnu"];
		  $strategie = $enregistrement["strategie"];
		  $suggestions = $enregistrement["suggestions"];
		  $descripteur = $enregistrement["descripteur"];		
		  $charge_cognitive = $enregistrement["charge_cognitive"];		 
		 }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Formulaire de saisie des énoncés de distributivité</title>
<style>
    .infoBox {
      border: solid 1px #BBCCDD;
      width: 18em;
    }
    .infoBoxHeader {
      /*background: #DAEAF0;*/
      cursor: pointer;
      text-align: left;
	  text-decoration:underline;
      /*font-weight: bold;*/
    }
    .infoBoxBody {
      background: #F0F7FA;
	  text-align:justify;
    }
	.tableau1 {
	border-width:1px;
	border-style:solid;
	border-color:black;
	width:32%;
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
    </style>
<SCRIPT LANGUAGE="JavaScript">
/* On crée une fonction de verification */
function verifForm(formulaire)
{
    x=formulaire.enonce.value;
    for (i=0 ;i<= x.length-1 ;i++)
    {
     if ((x.charAt(i)==",") || (x.charAt(i)=="-") || (x.charAt(i)=="?") || (x.charAt(i)==".") || (x.charAt(i)=="€"))//||(x.charAt(i)=="'"))
     {
         if (x.charAt(i-1) != " ")
         {
             x = x.substring(0,i) +" " + x.charAt(i) + x.substring (i+1,x.length);
         }
     }
    }
    for (i=0 ;i<= x.length-1;i++)
    {
     if ((x.charAt(i)==",") || (x.charAt(i)=="-") || (x.charAt(i)=="?") || (x.charAt(i)==".") || (x.charAt(i)=="€"))
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
 
	if(formulaire.typePb.value == "") /* on detecte si enonce est vide */
		{
		alert('Choisissez  le type de problème !!'); /* dans ce cas on lance un message d'alerte */
		formulaire.typePb.focus();
		 }
	else if(formulaire.enonce.value == "") /* on detecte si enonce est vide */
		{
		alert('Remplissez le champs de l\'enoncé !!'); /* dans ce cas on lance un message d'alerte */
		formulaire.enonce.focus();
		 }
	else if(formulaire.question.value == "") /* on detecte si question est vide */
		{
		alert('Remplissez le champs de la question !!'); /* dans ce cas on lance un message d'alerte */
		formulaire.question.focus();
		}
	else
	    formulaire.submit(); /* sinon on envoi le formulaire */
}
// listes déroulantes liées 
function Choix(form) {
i = form.typePb.selectedIndex;
//form.inconnu.selectedIndex = 0;
switch (i) {
case 1 : var txt = new Array ('Etat Initital avec perte','Etat Initital avec ajout','Etat Final avec Perte', 'Etat Final avec Ajout', 'Transformation avec Perte', 'Transformation avec Ajout');
	     var txt1 = new Array ('EIP','EIA','EFP', 'EFA', 'TrP', 'TrA');
 		 break;
case 2 : var txt = new Array ('Partie','Tout'); 
		 var txt1 = new Array ('partie','tout'); 
			break;
case 3 : var txt = new Array ('Différence','Tout'); 
		 var txt1 = new Array ('diff','tout'); 
		 break;
case 4 : var txt = new Array ('Total-->multiplication','Multiplicateur-->Division quotition','Taille du groupe-->Division partition'); 		 var txt1 = new Array ('mult','divq','divp'); 
		 break;
case 0 : var txt = new Array (' ',' ',' ',' ',' ',' '); 
		 var txt1 = new Array (' ',' ',' ',' ',' ',' '); 
		 break;
}
for (i=0;i<txt.length;i++) 
	{
		nouvel_element = new Option(txt[i],txt1[i]);
		//alert('element'+i);
		document.formEtape.inconnu.options[i] = nouvel_element;
	}
	document.formEtape.inconnu.options[i] = null;
} 
function effacer()
{
	for(i=0;i<=document.formEtape.inconnu.length;i++)
		{
			document.formEtape.inconnu.options[i] = null;
		}

}
</SCRIPT>
<script>
// Affiche ou masque les details d’une zone
// idDetail : id de l'element contenant le detail
function toggle(idDetail) {
  var style = document.getElementById(idDetail).style;
  style.display = (style.display == "none") ? "" : "none";
}
</script>
<script language="javascript">
function afficherTexte()
{
var inconnu = document.formEtape.inconnu.value;
var typePb = document.formEtape.typePb.value;
switch (inconnu) {
	case 'EFA' : var txt = "X avait 3 billes. Puis Y lui a donné 5 billes.<br/> Combien de billes a maintenant X ?";
			 break;
	case 'EFP' : var txt = "X avait 8 billes. Puis il a donné 5 billes à Y.<br/> Combien de billes a maintenant X ?";
			 break;
	case 'TrA' : var txt = "X avait 3 billes. Y lui en a donné. X a maintenant 8 billes. <br/>Combien de billes Y a - t - il donné à X ?";
			 break;
	case 'TrP' : var txt = "X avait 8 billes. Il en a donné à Y. Maintenant X a 3 billes. <br/>Combien X a - t - il donné de billes à Y ?";
			 break;
	case 'EIA' : var txt = "X avait des billes. Y lui en a donné 5 de plus. Maintenant X a 8 billes. <br/>Combien X avait t - il de billes ?";
			 break;
	case 'EIP' : var txt = "X avait des billes. Il en a donné 5 à Y. Maintenant X a 3 billes. <br/>Combien X avait t - il de billes ?";
			 break;
	case 'partie' : var txt = "X a 8 billes. Y a 5 billes. <br/>Combien X a - il de billes  de plus que Y ?";
			 break;
	case 'diff' : var txt = "X a 8 billes. Il a 5 billes de plus que Y. <br/>Combien Y a - il de billes ?";
			 break;
	case 'tout' : if(typePb='combinaison')
					var txt = "X a 3 billes. Y a 5 billes. <br/>Combien X et Y ont - il de billes ensemble ?";
				  else  if(typePb='comparaison')
					var txt = "X a 3 billes. Il a 5 billes de moins que Y. <br/>Combien Y a - il de billes ?";
				  break;
	case 'mult' : var txt = "Dans une boîte, il y a 10 bonbons. Combien de bonbons faut-il pour remplir 4 boîtes ?";
				break;
	case 'divq' : var txt = "Dans une boîte, il y a 10 bonbons. Si X a 40 bonbons, combien de boîtes pourra-t-il remplir ?";
				break;
	case 'divp' : var txt = "X a 40 bonbons, il les distribue entre 4 boîtes pour que toutes en aient la même quantité. Dans chaque boîte, combien de bonbons y aura-t-il?";
				break;

	default: var txt=''; break;
}
//document.write(txt);
// obtain a reference to the <div> element on the page
myDiv = document.getElementById("details");
// add content to the <div> element
myDiv.innerHTML = txt;
}

</script>


</head>

<body>
<p align="center">
<a href="../index.html">Accueil</a> &nbsp;&nbsp;
<a href="admin.php">Admin</a>&nbsp;&nbsp;
<a href="eleve.html">Elève</a>
</p>
<form action="traitFormEtape.php" method="post" name="formEtape" id="formEtape">
  <div align="center">
    <table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
      <tr>
        <td height="23" align="center" class="infoBoxBody"><div align="center">Probl&egrave;me a une &eacute;tape </div></td>
      </tr>
    </table>
  </div>
<br />
  <div align="center">
    <table width="539" height="133" border="0" cellpadding="0" cellspacing="5" class="tableau1" id="AutoNumber2" style="border-collapse: collapse">
      <tr>
        <td width="240" align="left"><span>&nbsp;Type du probl&egrave;me </span></td>
        <td width="299" align="left">
        <select size="1" name="typePb" onchange='effacer();Choix(this.form);afficherTexte();'>
          <option></option>
			<?php
				switch ($typePb)
				{
					case "changement" : echo ("<option value=\"changement\" selected>Changement</option>");
										echo ("<option value=\"combinaison\">Combinaison</option>");
										echo ("<option value=\"comparaison\">Comparaison</option>");
										echo ("<option value=\"groupement\">Groupement</option>");
										break;
					case "combinaison" :echo ("<option value=\"changement\" >Changement</option>");
										echo ("<option value=\"combinaison\" selected>Combinaison</option>");
										echo ("<option value=\"comparaison\">Comparaison</option>");
										echo ("<option value=\"groupement\">Groupement</option>");
										break;
					case "comparaison" :echo ("<option value=\"changement\" >Changement</option>");
										echo ("<option value=\"combinaison\">Combinaison</option>");
										echo ("<option value=\"comparaison\" selected>Comparaison</option>");
										echo ("<option value=\"groupement\">Groupement</option>");
										break;
					case "groupement" :echo ("<option value=\"changement\" >Changement</option>");
										echo ("<option value=\"combinaison\">Combinaison</option>");
										echo ("<option value=\"comparaison\">Comparaison</option>");
										echo ("<option value=\"groupement\" selected>Groupement</option>");
										break;
				}
            ?>
          
        </select></td>
      </tr>
	  <tr>
        <td align="left"> <span>&nbsp;Nature de l'inconnu </span> </td>
        <td align="left">
        <select size="1" name="inconnu" id="inconnu" onchange="afficherTexte();">
<?php         
switch ($inconnu) 
{
	case 'EFA' : echo ("<option value=\"EFA\" selected>Etat Final avec ajout</option>"); break;
			
	case 'EFP' : echo ("<option value=\"EFP\" selected>Etat Final avec Perte</option>"); break;
			
	case 'TrA' : echo ("<option value=\"TrA\" selected>Transformation avec Ajout</option>");break;
			 
	case 'TrP' : echo ("<option value=\"TrA\" selected>Transformation avec Perte</option>");break;
			 
	case 'EIA' :echo ("<option value=\"EIA\" selected>Etat Initital avec Ajout</option>");break;
			 
	case 'EIP' :echo ("<option value=\"EIP\" selected>Etat Initital avec Pert</option>"); break;
			
	case 'partie' : echo ("<option value=\"partie\" selected>Partie</option>");break;
			 
	case 'diff' : echo ("<option value=\"diff\" selected>Différence</option>");break;
			 
	case 'tout' : echo ("<option value=\"tout\" selected>Tout</option>");break;
			
	case 'mult' : echo ("<option value=\"multiplication\" selected>Total-->multiplication</option>");break;
				
	case 'divq' : echo ("<option value=\"divq\" selected>Multiplicateur-->Division quotition</option>");break;
				
	case 'divp' : echo ("<option value=\"divp\" selected>Taille du groupe-->Division partition</option>");break;
	
}
?>
        
        </select>
        </td>
      </tr>
	  <tr>
	    <td colspan="2" align="center">
		<div class="infoBox">
      <div class="infoBoxHeader" onclick="toggle('details')"> Exemple </div>
      <div id="details" class="infoBoxBody" style="display:none"/>
    </div>		</td>
      </tr>
	  <tr>
	    <td align="left"><span>&nbsp;Type de variable</span></td>
	    <td align="left">
        <select size="1" name="variable">
          <?php 
		  switch ($variable)
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
		  
        </select></td>
      </tr>
    </table>
    
  </div>
  <br/>
  <div align="center">
    <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" id="AutoNumber3">
      <tr>
        <td width="100%" align="left"><span>Enonc&eacute;</span></td>
      </tr>
      <tr>
        <td width="100%" align="center"><textarea name="enonce" cols="55" rows="10" wrap="virtual"><?php echo $enonce; ?></textarea></td>
      </tr>
      <tr>
        <td width="100%" align="left"><span>Question</span></td>
      </tr>
      <tr>
        <td width="100%" align="center"><textarea name="question" cols="55" rows="2" wrap="virtual"><?php echo $question; ?></textarea></td>
        </tr>
        </table>
</div>
<div align="center">
	<table>
      <tr>
        <td align="left"><span>Charge cognitive </span></td>
        <?php 
		  switch ($charge_cognitive)
			{
				case "neutre" :  echo('<td><input type="radio" name="charge_cognitive" value="neutre" checked>Neutre</td></td>
									   <td><input type="radio" name="charge_cognitive" value="concordante">Concordante</td>
									   <td><input type="radio" name="charge_cognitive" value="discordante">Discordante</td>');
								break;
				case "concordante" :  echo('<td><input type="radio" name="charge_cognitive" value="neutre">Neutre</td></td>
									   <td><input type="radio" name="charge_cognitive" value="concordante" checked>Concordante</td>
									   <td><input type="radio" name="charge_cognitive" value="discordante">Discordante</td>');
								break;
				case "discordante" :  echo('<td><input type="radio" name="charge_cognitive" value="neutre">Neutre</td></td>
									   <td><input type="radio" name="charge_cognitive" value="concordante">Concordante</td>
									   <td><input type="radio" name="charge_cognitive" value="discordante" checked>Discordante</td>');
								break;
			}
		?>
      	</tr>
    </table>
</div>
<div align="center">
        <table>
      </tr>
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