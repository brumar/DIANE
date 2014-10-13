<html>
<head>
<title>Formulaire d'inscription</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="formeleve.js"></script>
</head>
<body>
<p align="center"><a href="eleve.html">Accueil</a></p>
<h3 align="center">Remplis le formulaire suivant pour t'inscrire </h3>
<br>
<form name="form1" method="post" action="traitEleve.php" onSubmit="return validate();">
  <table border="0" align="center">
    <tr> 
      <td align="right"><strong>Nom  &nbsp;*</strong></td>
      <td><input type="text" size="40" name="nom" <?php if(isset($_GET['nom']) and $_GET['nom'] !='') echo('value="'.$_GET['nom'].'"');?>></td>
    </tr>
    <tr> 
      <td align="right"><strong>Pr&eacute;nom  &nbsp;*</strong></td>
      <td><input type="text" name="prenom" size="40" <?php if(isset($_GET['prenom']) and $_GET['prenom']!='') echo('value="'.$_GET['prenom'].'"');?>></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td align="right"><strong>Date naissance  &nbsp;*</strong></td>
      <td> <select name="birthDay">
          <option value=" " selected> </option>
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
          <option value=" " selected></option>
          <option value="01">Janvier</option>
          <option value="02">Fevrier</option>
          <option value="03">Mars</option>
          <option value="04">Avril</option>
          <option value="05">Mai</option>
          <option value="06">Juin</option>
          <option value="07">Juillet</option>
          <option value="08">Août</option>
          <option value="09">Septembre</option>
          <option value="10">Octobre</option>
          <option value="11">Novembre</option>
          <option value="12">Decembre</option>
        </select> <select name="birthYear">
          <option value=" " selected> </option>
		  <?php 
		 $annee = date("Y")-5; 
	     for ($i=$annee;$i>=1930;$i--)  
  		  { 
			 echo '<option value="'.$i.'">'.$i.'</option>'; 
    	 } 
		?>
        </select>
		
      </td>
    </tr>
	<tr> 
      <td align="right"><strong>Sexe</strong> &nbsp;*</td>
      <td>
	  	<select name="sexe">
	  	  <option value="m">Gar&ccedil;on</option>
          <option value="f">Fille</option>
        </select>
	  </td>
    </tr>
    <tr> 
      <td align="right"><strong>Classe</strong> &nbsp;*</td>
      <td>
	  	<select name="classe">
	  	  <option value=" " selected></option>
          <option value="ce1">CE1</option>
          <option value="ce2">CE2</option>
		  <option value="cm1">CM1</option>
          <option value="cm2">CM2</option>
		  <option value="autre">Autre</option>
        </select>
	  </td>
    </tr>
    <tr> 
      <td align="right"><strong>Numero Classe</strong> &nbsp;&nbsp;</td>
      <td><input name="numClasse" type="text" size="15"></td>
    </tr>
    <tr> 
      <td align="right"><strong>Ecole</strong> &nbsp;&nbsp;</td>
      <td><input type="text" size="40" name="ecole"></td>
    </tr>
    <tr>
      <td align="right"><strong>Ville</strong> &nbsp;&nbsp;</td>
      <td><input name="ville" size="40" type="text"></td>
    </tr>
  </table> 
  <p align="center">* Tu dois obligatoirement remplir ses cases</p>
  <p align="center">
    <input type="submit" name="Submit" value="Continuer">&nbsp;&nbsp;&nbsp;
    <input name="Input" type="button" value="Effacer tout" onClick="effacer();">
  </p>
</form>
</body>
</html>
