<?php
	header('Content-type: text/html; charset=utf-8');
?>
<!DOCTYPE html>

<?php
	//Ouvre la connexion avec la BDD
 	require_once("conn_pdo.php");

 	if(isset($_GET['log']) and isset($_GET['cle'])) {
 		$req = $bdd->prepare('SELECT * FROM unvalidated_account WHERE login = ?');
		if($req->execute(array(urldecode($_GET['log'])))) {
			$data = $req->fetch();

			if(urldecode($_GET['cle']) == $data['cle']) {
				
				$reqInsert = $bdd->prepare('INSERT INTO account(accountType, prenom, nom, email, login, password) VALUES(\'enseignant\', ?, ?, ?, ?, ?)');
				
				if($reqInsert->execute(array($data['prenom'], $data['nom'], $data['email'], $data['login'], $data['password']))){
					$reqDelete = $bdd->prepare('DELETE FROM unvalidated_account WHERE login =?');
					$reqDelete->execute(array($data['login']));
					
					$reqDelete->closeCursor();
				}
				$reqInsert->closeCursor();

				echo "Bienvenu ".$data['prenom']. " ". $data['nom'].", votre compte a bien été créé. Cliquez ici pour vous connecter.";
				//TODO CLIQUER
			}
			else{
				echo "<br/><br/>zut";
			}
		}
		$req->closeCursor();

 	}


 	elseif ($_POST){
 		
 		$hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
 		$prenom = strtolower($_POST['reg_prenom']);
 		$nom = strtolower($_POST['reg_nom']);
 		$email = $_POST['reg_email'];

 		$login = $prenom[0] . '.' . $nom;
 		// TODO : VERIFIER QUE CE LOGIN OU MAIL N'EXISTE PAS DEJA (dans ACCOUNT). SI C'EST LE CAS, LE MODIFIER...

		$key = bin2hex(openssl_random_pseudo_bytes(32));
	
		
		// Envoi du mail de confirmation
		
		/*
		$sujet = "Activer votre compte sur DIANE" ;

		// Le lien d'activation est composé du login(log) et de la clé(cle)
		$message = 'Bonjour,
		 
		Pour activer votre compte sur DIANE, veuillez cliquer sur le lien ci dessous
		ou copier/coller dans votre navigateur internet.

		Votre login est :'. $login .'
		 
		http://www.diane-eiah.com/activation.php?log='.urlencode($login).'&cle='.urlencode($key).'
		 
		 
		---------------
		Ceci est un mail automatique, Merci de ne pas y répondre.';



		require 'vendor/phpmailer/phpmailer/PHPMailerAutoload.php';
        $mail = new PHPmailer(); 


        $mail->SMTPDebug = 3;                               // Enable verbose debug output

		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'smtp.numericable.fr';  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'timothee.behra@numericable.fr';                 // SMTP username
		require("pass.php");                           // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 587;                                    // TCP port to connect to

		*/

/* //MARCHE PAS : GMAIL A L'AIR DE PAS KIFFER, EN FAIT...
	
		// problème : peut être faudrait SSL plutôt que "tls" ?

		$mail->SMTPDebug = 2;                               // Enable verbose debug output

		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
		$mail->Port = 587;
		$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted

		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'dodeskadenjk@gmail.com';                 // SMTP username
		require("pass.php");                           // SMTP password

*/

		/*

		$mail->From = 'timothee.behra@numericable.fr';
		$mail->FromName = 'DIANE';
		$mail->addAddress('timotheebehra.etu@gmail.com');     // Add a recipient


		$mail->Subject = $sujet;
		$mail->Body    = $message;
	
		if(!$mail->send()) {
		    echo 'L\'email n\'a pas pu être envoyé.';
		    echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
			echo "Votre compte a été créé, mais il doit encore être confirmé. Vous allez recevoir un email avec un lien de confirmation.";
		}

		*/

        /*
        $mail->IsSMTP(); 
        $mail->Host='sslO.ovh.net'; 
        $mail->From='admin@diane-eiah.fr'; 
        $mail->AddAddress($email); 
        $mail->AddReplyTo('timotheebehra.etu@gmail.com');      
        $mail->Subject=$sujet; 
        $mail->Body=$message; 
        if(!$mail->Send()){ //Teste le return code de la fonction 
          echo $mail->ErrorInfo; //Affiche le message d'erreur (ATTENTION:voir section 7) 
        } 
        else{  //Mail bien envoyé


        	$req = $bdd->prepare('INSERT INTO unvalidated_account(accountType, prenom, nom, email, login, password, cle) VALUES(:accountType, :prenom, :nom, :email, :login, :password, :cle)');   
         	$req->execute(array(
			'accountType' => 'enseignant',
			'prenom' => $prenom,
			'nom' => $nom,
			'email' => $email,
			'login' => $login,
			'password' => $hashed_password,
			'cle' => $key
			));
			$req->closeCursor();

			echo "Votre compte a été créé. Vous allez recevoir un email avec un lien de confirmation.";
		

        } 
        $mail->SmtpClose(); 
        unset($mail); 
        */


        $req = $bdd->prepare('INSERT INTO unvalidated_account(accountType, prenom, nom, email, login, password, cle) VALUES(:accountType, :prenom, :nom, :email, :login, :password, :cle)');   
     	$req->execute(array(
			'accountType' => 'enseignant',
			'prenom' => $prenom,
			'nom' => $nom,
			'email' => $email,
			'login' => $login,
			'password' => $hashed_password,
			'cle' => $key
			));
		$req->closeCursor();
		
        echo "Votre compte a été créé, mais il doit encore être confirmé. Vous allez recevoir un email avec un lien de confirmation.";
		 
	}
	 
	//...	
	// Fermeture de la connexion à la BDD
	unset($bdd);


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
