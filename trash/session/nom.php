<?
session_start();
if(!session_is_registered("nom"))
{
print ("<form method=\"post\" action=\"nom2.php\">Nom:<input type=\"text\" name=\"nom\" size=12><br><input type=\"submit\" value=\"Ok\"></form>");
}
else
{
$nom = $_SESSION['nom'];
print ("Salut $nom<br><a href=\"delog.php\">Changer de nom</a>");
}
?>

//nom2.php
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

//delog.php
<?
session_unregister("nom");
print("<img src=\"carre.gif\">");
session_unset();
print("<img src=\"carre.gif\">");
session_destroy();
print("<img src=\"carre.gif\">");
print("Vous êtes bien délogé.<p>Clickez <a href=\"nom.php\">ici</a> pour entrer votre nom.");
?> 
