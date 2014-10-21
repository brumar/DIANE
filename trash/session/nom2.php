<?
$nom = $_POST['nom'];
if($nom=="")
{
print("Vous devez entrer un nom.<p>");
require("nom.php");
exit();
}
session_start();
session_register("nom");
print("Clickez <a href=\"nom.php\">ici</a> pour voir votre nom.");
?>