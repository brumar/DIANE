<? require ("conn.php"); ?>
<html>
 <head>
  <title>Afficher plusieurs enregistrements MySQL</title>
 </head>
<body>
<form action="selection.php" method="post">
  <table width="873" border="2" align="center" cellpadding="4" cellspacing="4" bordercolor="#FF0000">
    <tr align="center"> 
    <td width="77" height="46" bgcolor="#00CC66"> <h4>Selection des ennonc&eacute;s</h4></td>
    <td width="104" bgcolor="#00CC66"> <h4>Presence de la Question Intermediaire 
      </h4></td>
	  <td width="642" bgcolor="#00CC66"> <h4>Ennoncé</h4></td>

    </tr>
  <?
  $sql = "SELECT * FROM complement";

  $result = mysql_query($sql) or die ("Requête incorrecte");
  // = mysql_numrows($query);
  if ($result) { // Si il y'a des résultats
 // while ($rs = mysql_fetch_array($query)) {
  while ($enregistrement = mysql_fetch_assoc($result))
		{
		  $text1 =  $enregistrement["enonce1"];
		  $text2 =  $enregistrement["question1"];
		  $text3 =  $enregistrement["enonce2"];
		  $text4 =  $enregistrement["question2"];
		  $exo = $text1."<br>".$text2."<br>".$text3."<br>".$text4;
?>
  <tr> 
    <td height="27" align="center"><input name="choix" type="checkbox" value="<?php echo ($enregistrement["numero"]); ?>"></td>
    <td align="center"> <input name="questi" type="checkbox" value="<?php echo ($enregistrement["numero"]); ?>"></td>
	<td><?php echo($exo); ?></td>
  </tr>
  <?
        } // Fin instruction while

      } else { // Pas de résultat trouvé

    echo "Pas de résultat";

      }

  mysql_free_result($query); // Libère la mémoire
  mysql_close(); // Ferme la connexion
?>
</table>
<input name="enregistrer" type="submit" value="Enregistrer">
</form>
</body>
</html>
