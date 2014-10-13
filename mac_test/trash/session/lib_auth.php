<?

// ------------------------------------------------------------------------- //
// Protection avec HTTP-BASIC et données dans MySQL.                         //
// ------------------------------------------------------------------------- //
// Auteur: Perrich                                                           //
// Email:  perrich@netsolution.fr                                            //
// Web: http://www.frshop.net/                                               //
// ------------------------------------------------------------------------- //
// lib_auth.php : cette librairie est à appeler sur chaque page              //
// ------------------------------------------------------------------------- //

function headerDefine() {
  header( 'WWW-Authenticate: basic realm="Protection du site"' ); 
  header( 'HTTP/1.0 401 Unauthorized'); 
  print( '<html><body>Acc&egrave;s non autoris&eacute;.\n</body></html>' ); 
  exit();
}

function authUser( $con ) { 
  
  global $PHP_AUTH_USER, $PHP_AUTH_PW; 

  if ( empty( $PHP_AUTH_USER) || ($PHP_AUTH_USER=="") ) {
    // rien n'a été saisi, on demande le login et le mot de passe
    headerDefine();
  } else { 
    // on recherche l'utilisateur saisi dans la fenetre
    $requete  = "SELECT ID, DROITS ";
    $requete .= "FROM ADMIN ";
    $requete .= "WHERE LOGIN='$PHP_AUTH_USER' ";
    $requete .= "AND PASSWORD=PASSWORD('$PHP_AUTH_PW')";
    $query = mysql_query( $requete, $con );
    if ( mysql_num_rows( $query ) == 0 )
      headerDefine(); // aucune reponse, on repose la question
    $result = mysql_fetch_row($query);
    return $result[0]."|".$result[1];
  }
}
?>