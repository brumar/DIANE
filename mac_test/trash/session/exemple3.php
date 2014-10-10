<?php

session_start();

echo $login; // il a la valeur de la variable de session correspondante.

// la variable $login présente dans notre page prend une valeur différente de
// celle présente dans la session. La variable de session $login n'a pas été
// modifiée ; elle a toujours la même valeur !

$login="nouveau_login";

echo $login; // Affiche "nouveau_login"

// Met à jour la variable de session $login avec la nouvelle valeur à savoir
// "nouveau_login"

session_register("login");

?> 