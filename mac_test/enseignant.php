<?php
 	$name = $_POST['nom'];
    $password = $_POST['pass'];
     // connect to mysql
    require_once("conn.php");
	//$mysql = mysql_connect( 'sql.free.fr ', 'hakem.lkhider', 'kahina' );
    /* if(!$mysql)
    {
      echo 'Vous ne pouvez vous connecter a la basse de donnée.';
      exit;
    }
    // select the appropriate database
    $mysql = mysql_select_db( 'hakem_lkhider' );
    if(!$mysql)
    {
      echo 'vous ne pouvez entrer dans la base de donnée Projet.';
      exit();
    } */

    // query the database to see if there is a record which matches
    $query = "select count(*) from enseignant where login = '$name' and pass = '$password'";
    $result = mysql_query( $query );
    if(!$result)
    {
      echo 'la requète ne peut pas s\'executer.';
      exit();
    }

    $count = mysql_result( $result, 0, 0 );
    if ( $count > 0 )
    {
      header("Location: admin.php");
    }
    else
    {
      echo " Vous n'avez pas d'autorisation pour visualiser cette page";
    }
?>

