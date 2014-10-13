<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Bulletin d'inscription</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
<!--
function validate() {
   
	var noBdate = ' ';  
	var bday = document.form1.birthDay.selectedIndex;
	var bmonth = document.form1.birthMonth.selectedIndex;
	var byear = document.form1.birthYear.selectedIndex;
    var selectedBday = document.form1.birthDay.options[bday].value;
    var selectedBmonth = document.form1.birthMonth.options[bmonth].value;
    var selectedByear = document.form1.birthYear.options[byear].value;	    
	var leap = 0; if ((byear%4)==0) leap=1;
// if any of the birthdate elements have been set, validate the date

	if (document.form1.nom.value.length < 1) {
		document.form1.nom.focus();
		alert("veuillez entrer votre Nom.");
		return false;
	}
		    
	if (document.form1.prenom.value.length < 1) {
		document.form1.prenom.focus();
		alert("veuillez entrer votre Prenom.");
		return false;
	}
	
	if (selectedByear==noBdate)
	{
	alert('Veuillez entrer votre année de naissance.');
	return false;
	}

	if (selectedBmonth==noBdate)
	{
	alert('Veuillez entrer votre mois de naissance.');
	return false;
	}

	if (selectedBday==noBdate)
	{
	alert('Veuillez entrer votre jour de naissance.');
	return false;
	}
		
	if (((bmonth==4) || (bmonth==6) || (bmonth==9) || (bmonth==11)) && bday==31)
	{
	 alert("Date Naissance: Ce mois ne contient pas 31 jours. veuillez selectionner le jour entre  1 et 30.");
	 return false;
	 }
	
	if ((bmonth==2) && (bday>(28+leap))) 
	{
     alert('Date Naissance : Il y a que '+(28+leap)+' jour en mois de Fevrier en '+(byear+1900)+'.\nveuillez selectionner un jour entre 1 et '+(28+leap)+'.');
	 return false;
    }

    
	    
	
	if ((!document.form1.cotisation[0].checked) && (!document.form1.cotisation[1].checked) && (!document.form1.cotisation[2].checked) && (!document.form1.cotisation[3].checked) )
	 {
		alert("Veuillez sélectionner la case de cotisation vous correspondant");
		return false;
	}
	return true;		    
}
// -->	
</script>

</head>

<body>
<form name="form1" method="post" action="afficheForm.php" onSubmit="return validate();">
  <table width="70%" align="center" cellspacing="10" bgcolor="#99FF66">
    <tr> 
      <td height="41" colspan="2"> <h1 align="center">Bulletin d'adh&eacute;sion</h1>
        <p align="right"><?php echo date("d")."/".date("m")."/".date("Y") ?></p></td>
    </tr>
    <tr> 
      <td height="78" colspan="2"><b>Association Djem&acirc;a Saharidj</b><br>
        Chez SI YOUCEF Tahar<br>
        117, rue du Faubourg Poissonni&egrave;re<br>
        75009 Paris </td>
    </tr>
    <tr> 
      <td width="15%" height="151">&nbsp;</td>
      <td width="85%"> <table>
          <tr> 
            <td width="43%" align="right">Nom </td>
            <td width="57%"><input name="nom" type="text" id="nom" size="40"></td>
          </tr>
          <tr> 
            <td align="right">Pr&eacute;nom </td>
            <td><input name="prenom" type="text" id="prenom" size="40"></td>
          </tr>
          <tr> 
            <td height="28" align="right">Date Naissance </td>
            <td> <select  name="birthDay">
                <option value=" " selected>(Jour)</option>
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21">21</option>
                <option value="22">22</option>
                <option value="23">23</option>
                <option value="24">24</option>
                <option value="25">25</option>
                <option value="26">26</option>
                <option value="27">27</option>
                <option value="28">28</option>
                <option value="29">29</option>
                <option value="30">30</option>
                <option value="31">31</option>
              </select> <select name="birthMonth">
                <option value=" " selected>(Mois)</option>
                <option value="01"   >Janvier</option>
                <option value="02"   >Fevrier</option>
                <option value="03"   >Mars</option>
                <option value="04"   >Avril</option>
                <option value="05"   >Mai</option>
                <option value="06"   >Juin</option>
                <option value="07"   >Juillet</option>
                <option value="08"   >Août</option>
                <option value="09"   >Septembre</option>
                <option value="10"   >Octobre</option>
                <option value="11"   >Novembre</option>
                <option value="12"   >Decembre</option>
              </select> <select name="birthYear">
                <option value=" " selected>(Année)</option>
                <?php 
				$annee = date("Y");
				for($i=1;$i<($annee-1900);$i++)
				{
					$x=1900+$i;
					print("<option value=".$x.">".$x."</option>");
				}
				
				?>
              </select></td>
          </tr>
          <tr> 
            <td height="26" align="right">T&eacute;l </td>
            <td><input name="tel" type="text" id="tel2" size="40"></td>
          </tr>
          <tr> 
            <td align="right">Email </td>
            <td><input name="mail" type="text" id="mail" size="40"></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="78" colspan="2"><p align="left"> Je m'engage par ce pr&eacute;sent 
          bulletin &agrave; adh&eacute;rer pour l'ann&eacute;e <?php echo date("Y") ?> 
          &agrave; l'association Djem&acirc;a sahaidj et avoir pris connaissance 
          du statut de l'association ainsi que son r&eacute;glement int&eacute;rieur.<br>
        </p></td>
    </tr>
    <tr> 
      <td height="203" colspan="2"> <p>Veuillez cocher ci-apr&egrave;s la case 
          vous concernant. Merci de joindre le r&egrave;glement vous correspondant 
          &agrave; l'ordre de l'association.</p>
        <table align="center" cellspacing="10">
          <tr> 
            <td width="6%"><input type="radio" name="cotisation" value="couple"></td>
            <td width="94%">Cotisation <strong>Couple</strong> (40&euro;)</td>
          </tr>
          <tr> 
            <td><input type="radio" name="cotisation" value="salarie"></td>
            <td>Cotisation <strong>Salari&eacute; / Retrait&eacute;</strong> individuelle 
              (25&euro;)</td>
          </tr>
          <tr> 
            <td><input type="radio" name="cotisation" value="etudiant"></td>
            <td>Cotisation<strong> Etudiant</strong> ou <strong>Ch&ocirc;meur</strong> 
              (15&euro;)</td>
          </tr>
          <tr> 
            <td><input type="radio" name="cotisation" value="nouveau"></td>
            <td>Cotisation <strong>Nouvel adh&egrave;rant</strong> (80&euro;)</td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="78" colspan="2"><strong>Enfants &agrave; charges</strong> <table width="541" align="center">
          <tr> 
            <td width="33%" height="33" align="center"><strong>Nom</strong></td>
            <td width="33%" align="center"><strong>Pr&eacute;nom</strong></td>
            <td width="34%" align="center"><strong>Date Naissance </strong>(jj/mm/aaaa)</td>
          </tr>
          <tr> 
            <td align="center"> <input name="nom_e1" type="text" id="nom_e13"></td>
            <td align="center"> <input name="prenom_e1" type="text" id="prenom_e13"></td>
            <td align="center"> <input name="date1" type="text" id="date16"></td>
          </tr>
          <tr> 
            <td align="center"> <input name="nom_e2" type="text" id="nom_e23"></td>
            <td align="center"> <input name="prenom_e2" type="text" id="prenom_e23"></td>
            <td align="center"> <input name="date2" type="text" id="date22"></td>
          </tr>
          <tr> 
            <td align="center"> <input name="nom_e3" type="text" id="nom_e33"></td>
            <td align="center"> <input name="prenom_e3" type="text" id="prenom_e33"></td>
            <td align="center"> <input name="date3" type="text" id="date32"></td>
          </tr>
          <tr> 
            <td align="center"> <input name="nom_e4" type="text" id="nom_e43"></td>
            <td align="center"> <input name="prenom_e4" type="text" id="prenom_e43"></td>
            <td align="center"> <input name="date4" type="text" id="date42"></td>
          </tr>
        </table></td>
    </tr>
    <tr align="center"> 
      <td height="78" colspan="2"> <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p> 
          <input type="submit" name="envoyer" value="visualiser">&nbsp;&nbsp;&nbsp;
          <input name="Input" type="reset" value="Effacer les champs">
        </p></td>
    </tr>
  </table>
</form>
<p align="left">&nbsp;</p>
</body>
</html>
