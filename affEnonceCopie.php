<? require ("conn.php"); ?>
<html>
 <head>
  <title>Construction des séries d'exercices</title>
  <meta http-equiv="Content-Type" content="text/html; charset=Latin-1">
 </head>
<body>
<p align="center">
<a href="../index.html">Accueil</a> &nbsp;&nbsp;
<a href="admin.php">Admin</a>&nbsp;&nbsp;
<a href="eleve.html">Elève</a>
</p>
<form action="traitSerie.php" method="post">
  <table border="2" align="center" cellpadding="4" cellspacing="4" bordercolor="#FF0000">
    <tr align="center"> 
      <td width="77" bgcolor="#00CC66">
<h4>Selection des &eacute;nonc&eacute;s</h4></td>
      <td width="104" bgcolor="#00CC66"><h4>Question Intermediaire </h4></td>
      <td width="104" bgcolor="#00CC66"> <h4>Ordre de s&eacute;l&eacute;ction</h4></td>
      <td width="641" bgcolor="#00CC66"> <h4>Enoncés compl&eacute;ment</h4></td>
	  <td width="" bgcolor="#00CC66"><h4>Type</h4></td>
    </tr>
    <?
  $i=1;$j=1;
  $sql = "SELECT * FROM complement";
  $result = mysql_query($sql) or die ("Requète incorrecte");
  
  if ($result) { // Si il y'a des r�sultats// while ($rs = mysql_fetch_array($query)) {
	  while ($enregistrement = mysql_fetch_assoc($result))
		{
		  $text1 =  $enregistrement["enonce1"];
		  $text2 =  $enregistrement["question1"];
		  $text3 =  $enregistrement["enonce2"];
		  $text4 =  $enregistrement["question2"];
		  $exo = $text1."<br>".$text2."<br>".$text3."<br>".$text4;
		  $var = $enregistrement["variable"];
		  $question = $enregistrement["question"];
		  $type_exo = $var."e".$question;
?>
    <tr> 
      <td align="center"><input name="<?php echo ("select_e".$i);?>" type="checkbox" value="<?php echo ($enregistrement["numero"]); ?>"></td>
      <td align="center"><input name="<?php echo ("questi_e".$i); ?>" type="checkbox"></td>
      <td align="center"> <input name="<?php echo ("choix_e".$i); ?>" type="text" size="2" maxlength="2"></td>
      <td><?php echo($exo); ?></td>
	  <td align="center" valign="middle"><?php echo($type_exo); ?></td>
    </tr>
    <?
        
	$i++;} // Fin instruction while

     } else { // Pas de r�sultat trouv�

    echo "Pas de r�sultat";

      }

  mysql_free_result($result); // Lib�re la m�moire
?>
    <tr align="center"> 
      <td width="77" bgcolor="#00CC66">
<h4>Selection des &eacute;nonc&eacute;s</h4></td>
      <td width="104" bgcolor="#00CC66"><h4> Question Intermediaire</h4></td>
      <td width="104" bgcolor="#00CC66"> <h4>Ordre de s&eacute;l&eacute;ction</h4></td>
      <td width="641" bgcolor="#00CC66"> <h4>Enonc�s comparaison</h4></td>
	  <td width="" bgcolor="#00CC66"><h4>Type</h4></td>
    </tr>
    <?
  $sql = "SELECT * FROM comparaison";
  $result = mysql_query($sql) or die ("Requ�te incorrecte");
  if ($result) { // Si il y'a des r�sultats
 // while ($rs = mysql_fetch_array($query)) {
  while ($enregistrement = mysql_fetch_assoc($result))
		{
		  $text1 =  $enregistrement["enonce1"];
		  $text2 =  $enregistrement["question1"];
		  $text3 =  $enregistrement["enonce2"];
		  $text4 =  $enregistrement["question2"];
		  $exo = $text1."<br>".$text2."<br>".$text3."<br>".$text4;
		  $var = $enregistrement["variable"];
		  $question = $enregistrement["question"];
		  $type_exo = $var."a".$question;
?>
    <tr> 
      <td align="center"><input name="<?php echo ("select_a".$j);?>" type="checkbox" value="<?php echo ($enregistrement["numero"]); ?>"></td>
      <td align="center"><input name="<?php echo ("questi_a".$j); ?>" type="checkbox"></td>
      <td align="center"> <input name="<?php echo ("choix_a".$j); ?>" type="text" size="2" maxlength="2"></td>
      <td><?php echo($exo); ?></td>
	  <td align="center" valign="middle"><?php echo($type_exo); ?></td>
    </tr>
    <?
        
$j++;} // Fin instruction while

      } else { // Pas de r�sultat trouv�

    echo "Pas de r�sultat";

      }

  mysql_free_result($result); // Lib�re la m�moire
  mysql_close(); // Ferme la connexion
?>
	<input type="hidden" name="i" value="<?php echo ($i-1); ?>" >
	<input type="hidden" name="j" value="<?php echo ($j-1); ?>" >

  </table>
<p align="center">
</table>
  <table align="center" cellpadding="4" cellspacing="4" bordercolor="#FF0000">
    <!--DWLayoutTable-->
    <tr>
      <td width="221" align="right"><strong>Donnez un nom � la s�rie</strong></td>
      <td width="679"><input name="nomSerie" type="text"></td>
    </tr>
    <tr>
      <td align="right"><strong>Commentaire</strong></td>
      <td><textarea name="commentaire" cols="80" rows="2"></textarea></td>
    </tr>
  </table>
  <br>
<input name="enregistrer" type="submit" value="Enregistrer">

</p>
</form>
</body>
</html>
