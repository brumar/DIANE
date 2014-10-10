<?php 
require_once("conn.php");
$requete = "select nom from eleve order by nom";
$resultat = mysql_query($requete) or die("Erreur de S&eacute;lection dans la base : ". $requete .'<br />'. mysql_error());
/* affichage du composant HTML */
echo "<select name='nom'>";
echo "<option value='Choisir'>";
while ($ligne = mysql_fetch_object($resultat)) {
   echo "<option>";
   echo $ligne->nom;
}
echo"</select>";
/* pour libérer la mémoire */
mysql_free_result($resultat);
?>