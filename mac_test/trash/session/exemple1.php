<?php

session_start(); // Démarre la session. Spécifie une id de session.

$login="nom"; // On définit la variable classique $login

$password="mot de passe"; // On définit la variable classique $password

session_register("login"); // On enregistre $login dans la session

session_register("password"); // On enregistre $password dans la session

header("Location: exemple2.php?".session_name()."=".session_id());

exit(); // Redirection. On en reparle dans le II.3.

?>  
 


