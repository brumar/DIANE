<?php
	header('Content-type: text/html; charset=utf-8');
	require_once("ListFunction.php");
?>
<!DOCTYPE html>

<?php
	$_mail_support = "admin@diane-eiah.fr";
	//Ouvre la connexion avec la BDD
 	require_once("conn_pdo.php");

 	if(isset($_GET['email']) and isset($_GET['cle'])) {
 		$req = $bdd->prepare('SELECT * FROM unvalidated_account WHERE email = ?');
		if($req->execute(array(urldecode($_GET['email'])))) {
			$data = $req->fetch();

			if(urldecode($_GET['cle']) == $data['cle']) {
				$reqInsert = $bdd->prepare('INSERT INTO account(accountType, prenom, nom, email, password) VALUES(\'enseignant\', ?, ?, ?, ?)');
				
				if($reqInsert->execute(array($data['prenom'], $data['nom'], $data['email'], $data['password']))){
					$reqDelete = $bdd->prepare('DELETE FROM unvalidated_account WHERE email =?');
					$reqDelete->execute(array($data['email']));
					
					$reqDelete->closeCursor();
				}
				$reqInsert->closeCursor();

				echo "Bienvenu ".$data['prenom']. " ". $data['nom'].", votre compte a bien été créé sur DIANE. Pour vous connecter, votre adresse mail ".$data['email']." vous sera demandée. Cliquez <a href = \"enseignant.php\">ici</a> pour vous connecter à votre profil.";
				//TODO CLIQUER
			}
			else{
				echo "Il y a un soucis, votre compte a peut-être déjà été validé. Si ce n''est pas le cas, faites une nouvelle demande d'inscription, ou bien contactez le webmaster à l'adresse ".$_mail_support.".";
			}
		}
		$req->closeCursor();

 	}


 	elseif ($_POST){
 		
 		$hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
 		$prenom = strtolower($_POST['reg_prenom']);
 		$nom = strtolower($_POST['reg_nom']);
 		$email = $_POST['reg_email'];

 		// TODO : VERIFIER QUE CE MAIL N'EXISTE PAS DEJA (dans ACCOUNT).
 		if(exists_in_BDD('account', 'email = ?', array($email), $bdd)) {
 			echo "Un compte a déjà été créé avec cette adresse email. Si vous rencontrez des problèmes pour créer votre compte, vous pouvez contacter le webmaster à l'adresse ".$_mail_support.".";  //TODO : "Si vous avez perdu votre mot de passe pour vous connecter à DIANE, vous pouvez cliquer ici pour vous renvoyer un mot de passe"
 		}

 		

 		else {
			$key = bin2hex(openssl_random_pseudo_bytes(32));
		
			
			// Envoi du mail de confirmation
			
			/*
			$sujet = "Activer votre compte sur DIANE" ;

			// Le lien d'activation est composé de l'email et de la clé(cle)
			$message = 'Bonjour,
			 
			Pour activer votre compte sur DIANE, veuillez cliquer sur le lien ci dessous
			ou copier/coller dans votre navigateur internet.

			 
			http://www.diane-eiah.com/activation.php?email='.urlencode($email).'&cle='.urlencode($key).'
			 
			 
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


	        	$req = $bdd->prepare('INSERT INTO unvalidated_account(accountType, prenom, nom, email, password, cle) VALUES(:accountType, :prenom, :nom, :email, :password, :cle)');   
	         	$req->execute(array(
				'accountType' => 'enseignant',
				'prenom' => $prenom,
				'nom' => $nom,
				'email' => $email,
				'password' => $hashed_password,
				'cle' => $key
				));
				$req->closeCursor();

				echo "Votre compte a été créé. Vous allez recevoir un email avec un lien de confirmation.";
			

	        } 
	        $mail->SmtpClose(); 
	        unset($mail); 
	        */

	        if (exists_in_BDD('unvalidated_account', 'email = ?', array($email), $bdd)){
	        	echo "Votre compte existe mais il n'a pas encore été validé."; //Un nouvel email de confirmation vient de vous être envoyé.";
	        	//TODO : find what to do
	        }

	        else {
		        $req = $bdd->prepare('INSERT INTO unvalidated_account(accountType, prenom, nom, email, password, cle) VALUES(:accountType, :prenom, :nom, :email, :password, :cle)');   
		     	$req->execute(array(
					'accountType' => 'enseignant',
					'prenom' => $prenom,
					'nom' => $nom,
					'email' => $email,
					'password' => $hashed_password,
					'cle' => $key
					));
				$req->closeCursor();
				
		        echo "Votre compte a été créé, mais il doit encore être confirmé. Vous allez recevoir un email avec un lien de confirmation.";
	    	}
		}
	}
	 
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
