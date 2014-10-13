<html>
<head>
<title>Diagnostique</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<p align="center">
<a href="../index.html">Accueil</a> &nbsp;&nbsp;
<a href="admin.php">Admin</a>&nbsp;&nbsp;
<a href="eleve.html">Elève</a>
</p>
<h4><em>Choix de l'&eacute;nonc&eacute; : </em></h4>
<form name="form1" method="get" action="Interface.php" >
  <p align="left"><strong>Type</strong> 
    <select name="type" id="type">
      <option value="comparaison">Comparaison</option>
      <option value="complement">Complement</option>
    </select>
    <strong>Numero Enonc&eacute;</strong> 
    <input name="num" type="text" size="3" maxlength="3">
  </p>
  <p align="left"><strong>Question Intermediaire </strong> 
    <input type="radio" name="questi" value="1" checked>
    <strong>Oui</strong> 
    <input type="radio" name="questi" value="1">
    <strong> Non </strong></p>
	<p align="left">
	  <input name="envoyer" type="submit" value="Visualiser">	
    </p>
</form>
</body>
</html>
