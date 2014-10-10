<?php require ("conn.php"); ?>
<html>
<script type="text/javascript" language="javascript">
  var texte = "Voulez-vous r�ellement supprimer cet �nonc� ?"
  function supprimer(num)
  {
  	if(confirm(texte))
	{
	  document.location.href = "supprimer_enonce.php?numExo="+num+"&typeExo=comparaison";
	}
	else
	{
		//alert("supprimer_enonce.php?numExo="+num+"&typeExo=comparaison");
	}
  }
</script>
 <head>
 <meta http-equiv="Content-Type" content="text/html; charset=Latin-1">
  <title>Enonc� comparaison</title>
 </head>
<body>
<p align="center">
<a href="../index.html">Accueil</a> &nbsp;&nbsp;
<a href="admin.php">Admin</a>&nbsp;&nbsp;
<a href="eleve.html">El�ve</a>
</p>
<form action="selection.php" method="post">
  <table width="664" border="2" align="center" cellpadding="4" cellspacing="4" bordercolor="#FF0000">
    <tr align="center" bgcolor="#99FF99"> 
	<td bgcolor="#F0F7FA">&nbsp;</td>
	<td width="642" height="29" bgcolor="#F0F7FA">Enonc�s Comparaison</td>
    <td bgcolor="#F0F7FA">&nbsp;</td>
    </tr>
    <?php
  // initialisation
	$nb=4;
	if(empty($page)) $page = 1;
	if(empty($total)){ // nombre total de r�sultats
 	$sql1 = "select count(*) as qte from comparaison";
 	$p = @mysql_query($sql1,$BD_link);
 	$total = @mysql_result($p,"0","qte");
	}

	// on determine debut du limit
	$debut = ($page - 1) * $nb;

  $sql = "SELECT * FROM comparaison order by numero desc LIMIT $debut,$nb";

  $result = mysql_query($sql) or die ("Requ�te incorrecte");
  // = mysql_numrows($query);
  if ($result) { // Si il y'a des r�sultats
 // while ($rs = mysql_fetch_array($query)) {
  while ($enregistrement = mysql_fetch_assoc($result))
		{
		  $text1 =  $enregistrement["enonce1"];
		  $text2 =  $enregistrement["question1"];
		  $text3 =  $enregistrement["enonce2"];
		  $text4 =  $enregistrement["question2"];
		  $exo = $text1."<br>".$text2."<br>".$text3."<br>".$text4;
		  $num = $enregistrement["numero"];
		   $exo= stripslashes($exo);
?>
    <tr> 
      <td height="27"><h4><?php //echo($num); ?></h4><?php echo ("<a href=\"modif_enonce.php?numExo=$num&typeExo=comparaison\">"); ?>Modifier</a></td>
	  <td height="27"><?php echo($exo); ?></td>
      <td height="27"><?php echo ("<a href=\"#\" onClick=\"supprimer($num)\">"); ?><img src="../images/delete.png" width="24" height="24" alt="Supprimer" border="0"></a></td>
    </tr>
    <?php
        } // Fin instruction while

      } else { // Pas de r�sultat trouv�

    echo "Pas de r�sultat";

      }
?>
  </table>
<div align="center">
  <p>
    <?php
	// calcul du nombre de pages
 	$nbpages = ceil($total / $nb); // arrondi a l'entier superieur
 	// on affiche les pages
 	for($i = 1;$i <= $nbpages;$i ++)
	{
 	   echo "<a href=\"$PHP_SELF?page=$i&total=$total\">page$i</a>";
       if($i < $nbpages) echo " - ";
    }
  mysql_free_result($result); // Lib�re la m�moire
  mysql_close(); // Ferme la connexion
 ?>
  </p>
  <p><a href="formsaisie.html">Cr�er un nouvel exercice</a></p>
</div>
  
</form>
</body>
</html>
