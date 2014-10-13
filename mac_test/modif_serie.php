<?php 
	$numSerie=$_GET["num"];
	$nom=$_GET["nom"];
	$commentaire=$_GET["commentaire"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Modification du nom de la s&eacute;rie</title>
</head>

<body>
<h3 align="center">Modification du nom de la srie</h3>
<form action="traitement_modif_serie.php" method="post">
<p>&nbsp;</p>
<table border="1" align="center" bordercolor="windowtext;" cellpadding="5" class="tableau">	 
        <tr>
          <td align="right"><div class="exo">Donnez un nom &agrave; la s&eacute;rie</div></td>
        <td><div class="exo"><input name="nomSerie" type="text" value="<?php echo ($nom); ?>"></div></td>
  </tr>
        <tr>
          <td align="right"><div class="exo">Commentaire</div></td>
        <td><div class="exo"><textarea name="commentaire" cols="50" rows="2"><?php echo ($commentaire); ?></textarea></div></td>
      </tr>
</table>
<p>
  <input type="hidden" name="numSerie" id="numSerie" value="<?php echo ($numSerie); ?>"/>
</p>
<div align="center">
  <input name="enregistrer" type="submit" value="Enregistrer" />
</div>
</form>
</body>
</html>