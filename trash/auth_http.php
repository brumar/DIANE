<?php
  /* if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Texte utilisé si le visiteur utilise le bouton d\'annulation';
    exit;
  } 
  else if (($_SERVER['PHP_AUTH_USER']=="khider") and ($_SERVER['PHP_AUTH_PW']=="kahina"))
  {
    echo "<p>Bonjour, {$_SERVER['PHP_AUTH_USER']}.</p>";
    echo "<p>Votre mot de passe est {$_SERVER['PHP_AUTH_PW']}.</p>";
  }
  else 
	{
	    echo 'mot de passe incorecte';
	}
	 */
	 if ( !isset($_SERVER['PHP_AUTH_USER']) ) { 
           header('WWW-Authenticate: Basic realm="My Realm"'); 
           header('HTTP/1.0 401 Unauthorized'); 
           echo 'Texte utilisé si le visiteur utilise le bouton d\'annulation';

           exit(); 
    }   
     
     
    else { 
         
           include("conn.php"); 
           $query="SELECT pass from enseignant WHERE login='".$_SERVER['PHP_AUTH_USER']."'" ; 
           $ker=mysql_query($query); 
           $k=mysql_fetch_array($ker); 
             
         
              if( $k[0] != $_SERVER['PHP_AUTH_PW'] )
			  { 
                  unset($_SERVER['PHP_AUTH_PW']);
				  unset($_SERVER['PHP_AUTH_USER']);
				  echo 'mot de passe incorecte'; 
              } 
			  else if( $k[0] == $_SERVER['PHP_AUTH_PW'] )
			  {
			  header("Location: affichageText.php");
			  exit();
			  }
           
         
    } 
     
    print 'on affiche le reste de la page'; 
?>

