<?
//on démarre la session
session_start();
//on enregistre la variable nom dans la session ouverte
session_register(nom);

header('location: affiche.php');

?> 
