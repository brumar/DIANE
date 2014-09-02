<html>
<head>
<title>Document sans titre</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>

<?
  if(!isset($_POST['nom'])&&!isset($_POST['prenom']))
  {
    //l'enfant doit entrer son nom et son prenom
?>
<h4 align="center">Ecris ton nom et ton pr&eacute;nom</h4>
<form name="form1" method="post" action="eleve.php">
  <table border="0" align="center" cellspacing="0">
    <!--DWLayoutTable-->
    <tr>
      <td align="right">Nom &nbsp; &nbsp;</td>
      <td><input type="text" name="nom"></td>
    </tr>
    <tr>
      <td align="right">Pr&eacute;nom &nbsp; &nbsp;</td>
      <td><input type="text" name="prenom"></td>
    </tr>
  </table>
  <p></p>
  <p align="center">
    <input type="submit" name="Submit" value="Continuer">
    &nbsp;&nbsp;&nbsp;<input type="reset" name="effacer" value="Effacer tout">
  </p>
</form>
<div align="center">Si tu n'as pas de compte, <a href="formeleve.php">inscris toi ici </a></div>
  <?
  }
  else
  {
	 require_once("conn.php");
    $query = "select count(*) from eleve where nom = '".$_POST['nom']."' and prenom = '".$_POST['prenom']."'";
	$result = mysql_query( $query );

    if(!$result)
    {
      echo 'la requète ne peut pas s\'executer.';
      exit;
    }
    $count = mysql_result( $result, 0, 0 );
    if ( $count > 0 )
    {
        session_start();
		// Détruit toutes les variables de session
		session_unset();
		// Finalement, détruit la session
		session_destroy();


		$sql = "select * from eleve where nom = '".$_POST['nom']."' and prenom = '".$_POST['prenom']."'";
        $result1=mysql_query( $sql );
		$enregistrement = mysql_fetch_assoc($result1);

        session_start();
        $_SESSION['numEleve']=$enregistrement["numEleve"];
		$_SESSION['nom']=$enregistrement["nom"];
	    $_SESSION['prenom']=$enregistrement["prenom"];
		header("Location: serie.php");
    }
    else
    {
      // visitor's name and password combination are not correct
	  echo('<h3 align="center"><font color="#0000CC">'.$_POST['nom'].' '.$_POST['prenom'].'</font></h3>'); 
      echo "<br><h4 align=\"center\">Si tu as fait une faute de frappe retourne à <a href=\"eleve.php\"> l'accueil</a><br>";
	  echo "sinon <a href=\"formeleve.php?nom=".$_POST['nom']."&prenom=".$_POST['prenom']."\">inscris toi ici</a><h4>";
	  
    }
  }
?>

</body>

</html>