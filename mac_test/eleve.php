<?php
	require_once("conn.php");
    $query = "select count(*) from eleve where nom = '".$_POST['nom']."' and prenom = '".$_POST['prenom']."'";
	$result = mysql_query($query);
    if(!$result)
    {
      echo 'la requète ne peut pas s\'executer.';
      exit;
    }
    $count = mysql_result($result, 0, 0 );
    if ( $count > 0 )
    {
        //session_start();
		//session_unset();		// Détruit toutes les variables de session
		//session_destroy();		// Finalement, détruit la session

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
{// Nom et/ou Prénom incorecte
	echo('<html>');
	echo('<head>');
	echo('<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">');
	echo('<title>Erreur dans le Nom et/ou Prénom</title>');
	echo('</head>');
	echo('<body>');
	echo('<p>&nbsp;</p>');
	echo('<table width="50%"  border="0" align="center">');
	echo('<tr>');
	echo(' <td width="42%" align="right">Nom : </td>');
	echo('<td width="58%"><b style="color: #FF0000;">'. $_POST['nom'].'</b></td>');
	echo('</tr>');
	echo('<tr>');
	echo('<td align="right">Pr&eacute;nom : </td>');
	echo('<td><b style="color: #FF0000">'.$_POST['prenom'].'</b></td>');
	echo('</tr>');
	echo('</table>');
	echo('<hr align="center" width="30%" />');
	echo('<table width="50%"  border="0" align="center" cellpadding="5">');
	echo('<tr align="center">');
	echo('<td>Je ne trouve pas ton nom.</td>');
	echo('</tr>');
	echo('<tr align="center">');
	echo('<td>Si tu n\'es pas inscrit
	<a href="formeleve.php?nom='.$_POST['nom'].'&prenom='.$_POST['prenom'].'">inscris-toi ici</a></td>');
	echo('</tr>');
	echo('<tr align="center">');
	echo('<td>Si tu as fait une faute de frappe sur ton nom, <a href="corrEleve.php?nom='.$_POST['nom'].'&prenom='.$_POST['prenom'].'">	  corrige-la</a></td>');
	echo('</tr>');
	echo('</table>');
	echo('</body>');
	echo('</html>'); 
}//fin du else
?>
