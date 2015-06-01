<?php
	header('Content-type: text/html; charset=utf-8');

	function count_BDD($SQL_req, $array_req, $b){
		$r = $b->prepare($SQL_req);
		if($r->execute($array_req)){
			$tmp_stupid_variable = $r->fetch();
			$count = $tmp_stupid_variable[0];
			$r->closeCursor();
			return($count);
		}
		else{
			die();
		}
	}

	if($_POST){
		$login = $_POST['nom'];
		$mdp = $_POST['pass'];

		// Connexion mysql ($bdd)
		require_once("conn_pdo.php");

		echo $login."<br/><br/>";


		// 1) on regarde si le login existe dans "account"
		$count = count_BDD('SELECT COUNT(*) FROM account WHERE login =?', array($login), $bdd);

		if ($count == 1){  // 1a) le compte existe, on vérifie que le mot de passe est bon
			$req2 = $bdd->prepare('SELECT * FROM account WHERE login =?');
			if($req2->execute(array($login))) {
				$data = $req2->fetch();
				if(password_verify($mdp, $data['password'])){
					echo "Bienvenu".$res2['prenom']. " ". $res2['nom'];
					header("Location: admin.php");
				}
				else{
					echo "Le mot de passe entré est incorrect, merci de réessayer.";
				}
				$req2->closeCursor();
			}
		}

		else{ 
			//le compte n'existe pas dans account
			// 2) on regarde si le login existe dans "unvalidated account"
			
			$count2 = count_BDD('SELECT COUNT(*) FROM unvalidated_account WHERE login =?', array($login), $bdd);
			
			if($count2 == 1){ //il existe bien
				echo "Votre compte n'a pas encore été validé. Merci de cliquer sur le lien de confirmation dans l'email que vous avez reçu, ou cliquez ici pour recevoir un nouvel email.";
				// TODO : ENVOYER NOUVEL EMAIL DE CONFIRMATION
			}
			else{ //le compte n'existe pas => on propose de le créer
				echo "Nous ne trouvons pas de compte à votre nom. Merci de vérifier que vous avez bien entré votre nom d'utilisateur, ou bien créez un nouveau compte.";
			}			
		}
	}//end if($_POST)
	
		/* CODE QUI MARCHE MAIS MOCHE
		// 1) on regarde si le login existe dans "account"
		$req = $bdd->prepare('SELECT COUNT(*) FROM account WHERE login =?');
		
		if($req->execute(array($login))) {//si la requête réussit
			$tmp_stupid_variable = $req->fetch();
			$count = $tmp_stupid_variable[0];
			$req->closeCursor();

			if ($count == 1){  // 1a) le compte existe, on vérifie que le mot de passe est bon
				$req2 = $bdd->prepare('SELECT * FROM account WHERE login =?');

				if($req2->execute(array($login))) {
					
					$data = $req2->fetch();

					if(password_verify($mdp, $data['password'])){
						echo "Bienvenu".$res2['prenom']. " ". $res2['nom'];
						//header("Location: admin.php");
					}
					else{
						echo "Le mot de passe entré est incorrect, merci de réessayer.";
					}
					$req2->closeCursor();
				}
			}

			else{ //le compte n'existe pas dans account
				// 2) on regarde si le login existe dans "unvalidated account"
				$req3 = $bdd->prepare('SELECT COUNT(*) FROM unvalidated_account WHERE login =?');
				
				if($req3->execute(array($login))) {
					$tmp_stupid_variable = $req3->fetch();
					$count2 = $tmp_stupid_variable[0];

					if($count2 == 1){ //il existe bien
						echo "Votre compte n'a pas encore été validé. Merci de cliquer sur le lien de confirmation dans l'email que vous avez reçu, ou cliquez ici pour recevoir un nouvel email.";
						// TODO : ENVOYER NOUVEL EMAIL DE CONFIRMATION
					}
					else{ //le compte n'existe pas => on propose de le créer
						echo "Nous ne trouvons pas de compte à votre nom. Merci de vérifier que vous avez bien entré votre nom d'utilisateur, ou bien créez un nouveau compte.";
					}

					$req3->closeCursor();
				}
				else{
					echo 'Il y a une erreur, la requête ne peut pas s\'executer, veuillez nous en excuser.';
				}
			}
		}
		else{ //erreur..
			echo 'Il y a une erreur, la requête ne peut pas s\'executer, veuillez nous en excuser.';
		}

		*/
?>

