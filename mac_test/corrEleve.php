<html>
<head>
<title>Identification de l'élève</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<p></p><p></p>
<h4 align="center">Ecris ton nom et ton pr&eacute;nom</h4>
<form name="form1" method="post" action="eleve.php">
  <table border="0" align="center" cellspacing="0">
    <!--DWLayoutTable-->
    <tr>
      <td align="right">Nom &nbsp; &nbsp;</td>
      <td><input type="text" size="40" name="nom" <?php if(isset($_GET['nom']) and $_GET['nom'] !='') echo('value="'.$_GET['nom'].'"');?>></td>
    </tr>
    <tr>
      <td align="right">Pr&eacute;nom &nbsp; &nbsp;</td>
      <td><input type="text" size="40" name="prenom" <?php if(isset($_GET['prenom']) and $_GET['prenom']!='') echo('value="'.$_GET['prenom'].'"');?>></td>
    </tr>
  </table>
  <p align="center">
    <input type="submit" name="Submit" value="Continuer">
  </p>
</form>

</body>
</html>