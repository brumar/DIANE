<? require ("conn.php"); ?>
<html>
 <head>
  <title>Construction des séries d'exercices</title>
	<script language="Javascript">
	// Supprimer une ligne dans toute les autres listes de destination
	
	function SupprimerListe(idOrigine)
	{	
		var objOrigine = document.getElementById(idOrigine);
		//alert(document.formulaire.choix_e1.options[document.formulaire.choix_e1.selectedIndex]);
		for(i=1;i<=12;i++)
			{
				if(idOrigine=="choix_e"+i)
				{
					idDestination="choix_e"+(i+1); i++;
				}	
				else
				{
					idDestination="choix_e"+i;
				}
				//alert(idDestination);
				var objDestination = document.getElementById(idDestination);
				VerifValeurDansListe(idDestination, objOrigine.options[objOrigine.options.selectedIndex].value);
					 
			}
	}
	
	// Vérifie la présence de Valeur dans IdListe
	function VerifValeurDansListe(IdListe, Valeur) {
		var objListe = document.getElementById(IdListe);
		for (k=objListe.length-1;k>=0;k--) 
			if (objListe.options[k].value == Valeur) 
				{
					//if (blnAlerte) alert('Déjà présent.'); 
					objListe.options[k]=null; 
				}
	}
	</script>
 </head>
<body>
<p align="center">
<a href="../index.html">Accueil</a> &nbsp;&nbsp;
<a href="admin.php">Admin</a>&nbsp;&nbsp;
<a href="eleve.html">Elève</a>
</p>
<form name="formulaire" action="traitSerie.php" method="post">
  <table width="100%" height="258%" border="2" align="center" cellpadding="4" cellspacing="4" bordercolor="#FF0000">
    <tr align="center" valign="middle" bgcolor="#CCFF99"> 
      <td width="8%" height="18%">Selection des &eacute;nonc&eacute;s</td>
      <td width="11%">Question Intermediaire </td>
      <td width="10%">Ordre de s&eacute;l&eacute;ction</td>
      <td width="64%"> Enoncés compl&eacute;ment</td>
	  <td width="7%">Type</td>
    </tr>
    <?
  $i=1;$j=1;$m=1;
  $sql = "SELECT * FROM complement";
  $result = mysql_query($sql) or die ("Requête incorrecte");
  
  if ($result) { // Si il y'a des résultats// while ($rs = mysql_fetch_array($query)) {
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
      <td height="12%" align="center"><input name="<?php echo ("select_e".$i);?>" type="checkbox" value="<?php echo ($enregistrement["numero"]); ?>"></td>
      <td align="center"><input name="<?php echo ("questi_e".$i); ?>" type="checkbox"></td>
	  <td align="center"><input name="<?php echo ("choix_e".$i); ?>" type="text" size="2" maxlength="2">
		  <?php 
			echo ('<select name="choix_e'.$i.'" id="choix_e'.$i.'">');
			echo ("<option></option>"); 
			for($k=1;$k<=12 ;$k++)
			echo('<option value="'.$k.'">'.$k.'</option>');
			echo ("</select>"); 
		   ?>	  </td>
      <td><?php echo($exo); ?></td>
	  <td align="center"><?php echo($type_exo); ?></td>
    </tr>
    <?
        
	$i++;} // Fin instruction while

     } else { // Pas de résultat trouvé

    echo "Pas de résultat";

      }

  mysql_free_result($result); // Libère la mémoire
?>
    <tr align="center" valign="middle" bgcolor="#CCFF99"> 
      <td width="8%" height="25%">Selection des &eacute;nonc&eacute;s</td>
      <td width="11%"> Question Intermediaire</td>
      <td width="10%"> Ordre de s&eacute;l&eacute;ction</td>
      <td width="64%"> Enonc&eacute;s comparaison</td>
	  <td>Type</td>
    </tr>
    <?
  $sql = "SELECT * FROM comparaison";
  $result = mysql_query($sql) or die ("Requête incorrecte");
  if ($result) { // Si il y'a des résultats
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
      <td height="12%" align="center"><input name="<?php echo ("select_a".$j);?>" type="checkbox" value="<?php echo ($enregistrement["numero"]); ?>"></td>
      <td align="center"><input name="<?php echo ("questi_a".$j); ?>" type="checkbox"></td>
      <td align="center"><input name="<?php echo ("choix_a".$j); ?>" type="text" size="2" maxlength="2">
	  		<?php 
			echo ('<select name="choix_a'.$j.'" id="choix_a'.$j.'">');
			echo ("<option></option>"); 
			for($l=1;$l<=12 ;$l++)
			echo('<option value="'.$l.'">'.$l.'</option>');
			echo ("</select>"); 
		   ?>	  </td>
      <td><?php echo($exo); ?></td>
	  <td align="center"><?php echo($type_exo); ?></td>
    </tr>
	    <?
		$j++;} // Fin instruction while
			  } else { // Pas de résultat trouvé
			echo "Pas de résultat";
			  }
		  mysql_free_result($result); // Libère la mémoire
		?>
	<tr align="center" bgcolor="#CCFF99"> 
      <td height="18%" colspan="2" valign="middle">Selection des &eacute;nonc&eacute;s</td>
      <td width="10%"> Ordre de s&eacute;l&eacute;ction</td>
      <td width="64%"> Enoncés Distributivit&eacute; </td>
	  <td>Type</td>
    </tr>
    <?
  $sql3 = "SELECT * FROM distributivite";
  $result3 = mysql_query($sql3) or die ("Requête incorrecte Dist");
  if ($result3) { // Si il y'a des résultats
 // while ($rs = mysql_fetch_array($query)) {
  while ($enregistrement = mysql_fetch_assoc($result3))
		{
		  $text1 =  $enregistrement["enonce"];
		  $text2 =  $enregistrement["question"];
		 
		  $exo = $text1."<br>".$text2;
		  $var = $enregistrement["variable"];
		  //$question = $enregistrement["question"];
		  
		  $type_exo = "D".$var;
?>
    <tr> 
      <td height="15%" colspan="2" align="center">
	  <input name="<?php echo ("select_d".$m);?>" type="checkbox" value="<?php echo ($enregistrement["numero"]); ?>">	  </td>
      <td align="center">
	     <input name="<?php echo ("choix_d".$m); ?>" type="text" size="2" maxlength="2">
	 	 <?php 
			echo ('<select name="choix_a'.$j.'" id="choix_a'.$j.'">');
			echo ("<option></option>"); 
			for($l=1;$l<=12 ;$l++)
			echo('<option value="'.$l.'">'.$l.'</option>');
			echo ("</select>"); 
		   ?>      </td>
      <td><?php echo($exo); ?></td>
	  <td align="center"><?php echo($type_exo); ?></td>
    </tr>
    <?
        
$m++;} // Fin instruction while

      } else { // Pas de résultat trouvé

    echo "Pas de résultat";

      }

  mysql_free_result($result3); // Libère la mémoire
  mysql_close(); // Ferme la connexion
?>
	<input type="hidden" name="i" value="<?php echo ($i-1); ?>" >
	<input type="hidden" name="j" value="<?php echo ($j-1); ?>" >
  </table>

</table>
<table align="center" cellpadding="4" cellspacing="4" bordercolor="#FF0000">
    <!--DWLayoutTable-->
    <tr>
      <td width="221" align="right"><strong>Donnez un nom &agrave; la s&eacute;rie</strong></td>
      <td width="679"><input name="nomSerie" type="text"></td>
    </tr>
    <tr>
      <td align="right"><strong>Commentaire</strong></td>
      <td><textarea name="commentaire" cols="80" rows="2"></textarea></td>
    </tr>
  </table>
  <p align="center"><input name="enregistrer" type="submit" value="Enregistrer"></p>

</form>
</body>
</html>