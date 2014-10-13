<html>
<head>
<title>Affichage du formulaire</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<?php 
$nom = strtoupper($_POST["nom"]);
$prenom = strtoupper($_POST["prenom"]);
$date_n = $_POST["birthDay"]."/".$_POST["birthMonth"]."/".$_POST["birthYear"];
$tel= $_POST["tel"];
$mail = $_POST["mail"];
$cotisation = $_POST["cotisation"];
//print ($nom." ".$prenom." ".$date_n." ".$cotisation);
$nom_e1 = strtoupper($_POST["nom_e1"]); $prenom_e1 = strtoupper($_POST["prenom_e1"]); $date1 = $_POST["date1"];
$nom_e2 = strtoupper($_POST["nom_e2"]); $prenom_e2 = strtoupper($_POST["prenom_e2"]); $date2 = $_POST["date2"];
$nom_e3 = strtoupper($_POST["nom_e3"]); $prenom_e3 = strtoupper($_POST["prenom_e3"]); $date3 = $_POST["date3"];
$nom_e4 = strtoupper($_POST["nom_e4"]); $prenom_e4 = strtoupper($_POST["prenom_e4"]); $date4 = $_POST["date4"];
?>
<body>
<table width="70%" border="2" align="center" bordercolor="#000000">
  <tr> 
    <td bordercolor="#000000">
	<table width="90%" align="center">
        <tr> 
          <td height="41" colspan="2"> <h1 align="center">Bulletin d'adh&eacute;sion</h1>
            <p align="right"><?php echo date("d")."/".date("m")."/".date("Y") ?></p></td>
        </tr>
        <tr> 
          <td height="78" colspan="2"><b>Association Djem&acirc;a Saharidj</b><br>
            Chez SI YOUCEF Tahar<br>
            117, rue du Faubourg Poissonni&egrave;re<br>
            75009 Paris <br>
          </td>
        </tr>
        <tr> 
          <td width="9%" height="137">&nbsp;</td>
          <td width="91%"> <table width="53%">
              <tr> 
                <td width="47%">Nom :&nbsp;<?php echo ($nom); ?></td>
              </tr>
              <tr> 
                <td>Pr&eacute;nom :&nbsp;<?php echo ($prenom); ?></td>
              </tr>
              <tr> 
                <td height="28">Date Naissance :&nbsp;<?php echo ($date_n); ?></td>
              </tr>
              <tr> 
                <td height="26">T&eacute;l :&nbsp;<?php echo ($tel); ?></td>
              </tr>
              <tr> 
                <td>Email :&nbsp;<?php echo ($mail); ?></td>
              </tr>
            </table></td>
        </tr>
        <tr valign="top"> 
          <td height="52" colspan="2"> <p align="left"> Je m'engage par ce pr&eacute;sent 
              bulletin &agrave; adh&eacute;rer pour l'ann&eacute;e <?php echo date("Y") ?> 
              &agrave; l'association Djem&acirc;a sahaidj et avoir pris connaissance 
              du statut de l'association ainsi que son r&eacute;glement int&eacute;rieur.<br>
            </p></td>
        </tr>
        <tr> 
          <td height="203" colspan="2"> <p>Veuillez cocher ci-apr&egrave;s la 
              case vous concernant. Merci de joindre le r&egrave;glement vous 
              correspondant &agrave; l'ordre de l'association.</p>
            <table align="center" cellspacing="10">
              <tr> 
                <td width="6%"><input type="radio" name="cotisation" value="couple" <?php if($cotisation=="couple") echo ("checked"); ?> disabled></td>
                <td width="94%">Cotisation <strong>Couple</strong> (40&euro;)</td>
              </tr>
              <tr> 
                <td><input type="radio" name="cotisation" value="salarie" <?php if($cotisation=="salarie") echo ("checked"); ?> disabled></td>
                <td>Cotisation <strong>Salari&eacute; / Retrait&eacute;</strong> individuelle (25&euro;)</td>
              </tr>
              <tr> 
                <td><input type="radio" name="cotisation" value="etudiant" <?php if($cotisation=="etudiant") echo ("checked"); ?> disabled></td>
                <td>Cotisation<strong> Etudiant</strong> ou <strong>Ch&ocirc;meur</strong> 
                  (15&euro;)</td>
              </tr>
              <tr> 
                <td><input type="radio" name="cotisation" value="nouveau" <?php if($cotisation=="nouveau") echo ("checked"); ?> disabled></td>
                <td>Cotisation <strong>Nouvel adh&egrave;rant</strong> (80&euro;)</td>
              </tr>
            </table></td>
        </tr>
        <tr> 
          <td height="78" colspan="2"><strong>Enfants &agrave; charges</strong> 
            <table width="65%" align="center" cellpadding="1">
              <tr> 
                <td width="33%" height="33"><strong>Nom</strong></td>
                <td width="33%"><strong>Pr&eacute;nom</strong></td>
                <td width="34%"><strong>Date Naissance </strong></td>
              </tr>
              <tr> 
                <td><?php echo $nom_e1 ?> </td>
                <td><?php echo $prenom_e1 ?> </td>
                <td><?php echo $date1 ?></td>
              </tr>
              <tr> 
                <td> <?php echo $nom_e2 ?></td>
                <td><?php echo $prenom_e2 ?></td>
                <td><?php echo $date2 ?></td>
              </tr>
              <tr> 
                <td><?php echo $nom_e3 ?></td>
                <td><?php echo $prenom_e3 ?></td>
                <td><?php echo $date3 ?></td>
              </tr>
              <tr> 
                <td><?php echo $nom_e4 ?></td>
                <td><?php echo $prenom_e4 ?></td>
                <td><?php echo $date4 ?></td>
              </tr>
            </table></td>
        </tr>
        <tr align="center"> 
          <td height="78" colspan="2"> <p>&nbsp;</p>
            
            
            <p> 
			<form name="form1" method="post" action="association.php">
              <p>
                <input name="nom" type="hidden" value="<?php echo $nom ?>">
                <input name="prenom" type="hidden" value="<?php echo $prenom ?>">
                <input name="date_n" type="hidden" value="<?php echo $date_n ?>">
                <input name="tel" type="hidden" value="<?php echo $tel ?>">
                <input name="mail" type="hidden" value="<?php echo $mail ?>">
                <input name="cotisation" type="hidden" value="<?php echo $cotisation ?>">
                <input name="nom_e1" type="hidden" value="<?php echo $nom_e1 ?>">
                <input name="prenom_e1" type="hidden" value="<?php echo $prenom_e1 ?>">
                <input name="date1" type="hidden" value="<?php echo $date1 ?>">
                <input name="nom_e2" type="hidden" value="<?php echo $nom_e2 ?>">
                <input name="prenom_e2" type="hidden" value="<?php echo $prenom_e2 ?>">
                <input name="date2" type="hidden" value="<?php echo $date2 ?>">
                <input name="nom_e3" type="hidden" value="<?php echo $nom_e3 ?>">
                <input name="prenom_e3" type="hidden" value="<?php echo $prenom_e3 ?>">
                <input name="date3" type="hidden" value="<?php echo $date3 ?>">
                <input name="nom_e4" type="hidden" value="<?php echo $nom_e4 ?>">
                <input name="prenom_e4" type="hidden" value="<?php echo $prenom_e4 ?>">
                <input name="date4" type="hidden" value="<?php echo $date4 ?>">
              </p>
              <p> 
                <input type="submit" name="envoyer" value="Télécharger le Formulaire en pdf">
              </p>
            </form>&nbsp;&nbsp;&nbsp; </p></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
