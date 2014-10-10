<?php

// Ici $login et $password ne sont pas définis

session_start();

// Ils sont définis à partir d'ici.

echo $login;

echo $password;

if($login!="nom") session_destroy(); // destruction de la session

?> 