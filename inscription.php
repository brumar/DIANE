<!DOCTYPE html>

<?php
	//Ouvre la connexion avec la BDD
 	require_once("conn_pdo.php");

 	if ($_POST){
 		

 		$hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
 		$prenom = strtolower($_POST['reg_prenom']);
 		$nom = strtolower($_POST['reg_nom']);
 		$email = $_POST['reg_email'];

 		$login = $prenom[0] . '.' . $nom;
 		// VERIFIER QUE CE LOGIN N'EXISTE PAS DEJA. SI C'EST LE CAS, LE MODIFIER...

		echo "il y a un post<br/>";

		$key = openssl_random_pseudo_bytes(32);


	 	$req = $bdd->prepare('INSERT INTO account(accountType, prenom, nom, email, login, password, cle) VALUES(:accountType, :prenom, :nom, :email, :login, :password, :cle)');
		$req->execute(array(
			'accountType' => 'enseignant',
			'prenom' => $prenom,
			'nom' => $nom,
			'email' => $email,
			'login' => $login,
			'password' => $hashed_password,
			'cle' => $key
			));

		echo "Votre compte a été créé. Vous allez recevoir un email avec un lien de confirmation.";
	

		// Envoie du mail de confirmation
		
		$sujet = "Activer votre compte sur DIANE" ;
		//$entete = "From: inscription@votresite.com" ;

		// Le lien d'activation est composé du login(log) et de la clé(cle)
		$message = 'Bonjour,
		 
		Pour activer votre compte sur DIANE, veuillez cliquer sur le lien ci dessous
		ou copier/coller dans votre navigateur internet.

		Votre login est :'. $login .'
		 
		http://diane-eiah.com/activation.php?log='.urlencode($login).'&cle='.urlencode($key).'
		 
		 
		---------------
		Ceci est un mail automatique, Merci de ne pas y répondre.';
		 
		echo $message;
		//mail($email, $sujet, $message, $entete) ; // Envoi du mail

	}
	 
	//...	
	// Fermeture de la connexion à la BDD

?>

<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="static/css/default.css" />
		<title>Inscription</title>
	</head>

	<body>
	</body>
</html>
