<?php 
  session_start();
  // Détruit toutes les variables de session
  session_unset();
  // Finalement, détruit la session
  session_destroy();
  $nom = strtolower(trim($_POST['nom']));
  $prenom = strtolower(trim($_POST['prenom']));
  $jour = strtolower(trim($_POST['birthDay']));
  $mois = strtolower(trim($_POST['birthMonth']));
  $annee= strtolower(trim($_POST['birthYear']));
  $dateNais = $annee."-".$mois."-".$jour;
  $classe = strtolower(trim($_POST['classe']));
  $sexe = strtolower(trim($_POST['sexe']));
  $numClasse = strtolower(trim($_POST['numClasse']));
  $ecole = strtolower(trim($_POST['ecole']));
  $ville = strtolower(trim($_POST['ville']));
  
  require_once("conn.php");
  $query = mysql_query("SELECT * FROM eleve WHERE nom='$nom' and prenom='$prenom'"); 
  $result = mysql_fetch_row($query); 
  if($result >= 1) 
  { 
       print("votre nom existe deja");
  } 
  else 
  {   
	  $Requete_SQL = "INSERT INTO eleve (nom, prenom, dateNais,classe,numClasse,ecole,ville,sexe) VALUES ('".$nom."','".$prenom."','".$dateNais."','".$classe."','".$numClasse."','".$ecole."','".$ville."','".$sexe."')";
	  $result = mysql_query($Requete_SQL) or die("Erreur d'Insertion dans la base : ". $Requete_SQL .'<br />'. mysql_error());
	  /* $sql = "select numEleve,nom,prenom from eleve where nom = '$nom' and prenom = '$prenom'";
	  $result1=mysql_query( $sql );
	  $enregistrement = mysql_fetch_assoc($result1);
	  $numEleve = $enregistrement["numEleve"];
	  $nom = $enregistrement["nom"];
	  $prenom = $enregistrement["prenom"];  */
	  $compteur = 0;
		$sql = "select numEleve,nom,prenom from eleve where nom = '".$nom."' and prenom = '".$prenom."'";
        $result1=mysql_query( $sql );
		$enregistrement = mysql_fetch_assoc($result1);
      
        session_start();
        $_SESSION['numEleve']=$enregistrement['numEleve'];
		$_SESSION['nom']= $enregistrement["nom"];
	    $_SESSION['prenom']= $enregistrement["prenom"];
		//print($_SESSION['nom']."   ".$_SESSION['prenom']);exit();
		header("Location: serie.php");
  } 

  
?>