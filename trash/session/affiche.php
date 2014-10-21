<?
//on démarre la session
session_start();

//on affiche la variable enregistrée précédemment
//print 'votre nom est '.$HTTP_SESSION_VARS[nom];

//vous pouvez l'afficher sous cette forme avec les nouvelle version de php
print '<br>votre nom est '.$_SESSION[a];

// liens page vérifier nommée verif.php

print '<br><a href="verif.php">Vérifier l\'enregistrement</a>'; 

?> 