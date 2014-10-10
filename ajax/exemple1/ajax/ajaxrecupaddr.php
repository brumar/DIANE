<?php
include('connexion.php'); // connexion à la base, non expliqué ici

$req = mysql_query("SELECT nom,adresse,cdpost FROM clients
WHERE cdcl = '".mysql_real_escape_string($_POST[cdcl])."'");
while($res = mysql_fetch_array($req))
 {
  // Concatenation des resultats dans une chaine
  // Utilisation d'un caractere séparateur ( £ ) que nous avons peu
  // de chance de retrouver dans une chaine de caracteres francais.
  echo "$res[nom]£$res[adresse]£$res[cdpost]";
 }
?>