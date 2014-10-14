<?php require ("conn.php"); ?>
<html>
<script type="text/javascript" language="javascript">
  var texte = "Voulez-vous réellement supprimer cet énoncé ?"
  function supprimer(num)
  {
  	if(confirm(texte))
	{
	  document.location.href = "supprimer_enonce.php?numExo="+num+"&typeExo=distributivite";
	}
	else
	{
		//alert("supprimer_enonce.php?numExo="+num+"&typeExo=comparaison");
	}
  }
</script>

 <head>
 <meta http-equiv="Content-Type" content="text/html; charset=Latin-1">
  <title>Enoncés distributivité</title>
 </head>
<body>
<p align="center">
<a href="../index.html">Accueil</a> &nbsp;&nbsp;
<a href="admin.php">Admin</a>&nbsp;&nbsp;
<a href="eleve.html">Elève</a>
</p>
<form action="selection.php" method="post">
  <table width="664" border="2" align="center" cellpadding="4" cellspacing="4" bordercolor="#FF0000">
    <tr align="center" bgcolor="#F0F7FA"> 
	<td>&nbsp;</td>
	<td width="642" height="29">      Enoncés distributivité</td>
    <td >&nbsp;</td>
    </tr>
    <?php
  // initialisation
	$nb=4;
	if(empty($page)) $page = 1;
	if(empty($total)){ // nombre total de résultats
 	$sql1 = "select count(*) as qte from distributivite";
 	$p = @mysql_query($sql1,$BD_link);
 	$total = @mysql_result($p,"0","qte");
	}

	// on determine debut du limit
	$debut = ($page - 1) * $nb;

  $sql = "SELECT * FROM distributivite order by numero desc LIMIT $debut,$nb";

  $result = mysql_query($sql) or die ("Requète incorrecte");
  // = mysql_numrows($query);
  if ($result) { // Si il y'a des résultats
 // while ($rs = mysql_fetch_array($query)) {
  while ($enregistrement = mysql_fetch_assoc($result))
		{
		  $text1 =  $enregistrement["enonce"];
		  $text2 =  $enregistrement["question"];
		  $exo = $text1."<br>".$text2;
		  $num = $enregistrement["numero"];
		  $exo= stripslashes($exo);
?>
    <tr> 
      <td height="27"><h4><?php //echo($num); ?></h4><?php echo ("<a href=\"modif_enonce_dist.php?numExo=$num\">"); ?>Modifier</a></td>
	  <td height="27"><?php echo($exo); ?></td>
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
  mysql_free_result($result); // Libére la mémoire
  mysql_close(); // Ferme la connexion
 ?>
  </p>
<p><a href="formDist.html">Créer un nouvel exercice</a></p></div>
  
</form>
</body>
</html>
