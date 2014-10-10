<?

// ------------------------------------------------------------------------- //
// EXEMPLE                                                                   //
// ------------------------------------------------------------------------- //
// Ensuite pour proteger les pages il suffit de faire un require de la       //
// librairie avant toute autre commande, d'ouvrir une connexion avec la base //
// de données puis d'appeler la fonction authUser() avec la connexion        //
// ouverte.                                                                  //
// ------------------------------------------------------------------------- //

require 'lib_auth.php';
  
$conAdmin = mysql_connect( 'localhost', 'root', '' );
$test = mysql_select_db( 'auth' , $conAdmin );
$result = authUser( $conAdmin );

// la suite ...

?> 