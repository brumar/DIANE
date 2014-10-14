<?php require ("conn.php"); ?>
<html>
<script type="text/javascript" language="javascript">
  var texte = "Voulez-vous réellement supprimer cet énoncé ?"
  function supprimer(num)
  {
  	if(confirm(texte))
	{
	  document.location.href = "supprimer_enonce.php?numExo="+num+"&typeExo=etape";
	}
	else
	{
		//alert("supprimer_enonce.php?numExo="+num+"&typeExo=comparaison");
	}
  }
</script>

 <head>
  <title>Problème en une seule étape</title>
 </head>
<body>
<p align="center">
<a href="../index.html">Accueil</a> &nbsp;&nbsp;
<a href="admin.php">Admin</a>&nbsp;&nbsp;
<a href="eleve.html">Elève</a>
</p>
<form action="selection.php" method="post">
  <table width="701" border="2" align="center" cellpadding="4" cellspacing="4" bordercolor="#FF0000">
    <tr align="center" bgcolor="#F0F7FA"> 
	<td width="53">&nbsp;</td>
	<td width="448">Enoncés &agrave; une &eacute;tape </td>
	<td height="29">Type de <br>Probl&egrave;me </td>
    <td bgcolor="#F0F7FA">&nbsp;</td>

    </tr>
    <?php
  // initialisation
	$nb=8;
	if(empty($page)) $page = 1;
	if(empty($total)){ // nombre total de résultats
 	$sql1 = "select count(*) as qte from etape";
 	$p = @mysql_query($sql1,$BD_link);
 	$total = @mysql_result($p,"0","qte");
	}

	// on determine debut du limit
	$debut = ($page - 1) * $nb;

  $sql = "SELECT * FROM etape order by numero desc LIMIT $debut,$nb";

  $result = mysql_query($sql) or die ("Requête incorrecte");
  // = mysql_numrows($query);
  if ($result) { // Si il y'a des résultats
 // while ($rs = mysql_fetch_array($query)) {
  while ($enregistrement = mysql_fetch_assoc($result))
		{
		  $text1 =  $enregistrement["enonce"];
		  $text2 =  $enregistrement["question"];
		  $exo = $text1."<br>".$text2;
		  $num = $enregistrement["numero"];
		  $typePb = $enregistrement["typePb"];
		  $inconnu = $enregistrement["inconnu"];
		  $variable = $enregistrement["variable"];
		  $exercice = $typePb." ".$inconnu." (".$variable.")";
     	  $exo= stripslashes($exo);
?>
    <tr> 
      <td height="27"><h4><?php //echo($num); ?></h4><?php echo ("<a href=\"modif_enonce_etape.php?numExo=$num\">"); ?>Modifier</a></td>
	  <td><?php echo($exo); ?></td>
	  <td height="27"><?php echo($exercice); ?></td>
            <td height="27"><?php echo ("<a href=\"#\" onClick=\"supprimer($num)\">"); ?><img src="static/images/delete.png" width="24" height="24" alt="Supprimer" border="0"></a></td>
    </tr>
    <?php
        } // Fin instruction while

      } else { // Pas de résultat trouvé

    echo "Pas de résultat";

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
  mysql_free_result($result); // Libère la mémoire
  mysql_close(); // Ferme la connexion
 ?>
  </p>
  <p><a href="formEtape.html ">Créer un nouvel exercice</a></p></div>

</div>
  
</form>
</body>
</html>
