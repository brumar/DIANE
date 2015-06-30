<?php
	require_once("verifSessionProf.php");
	require_once("conn_pdo.php");
	require_once("ListFunction.php");

	//$current_email = get_value_BDD("email", "account", "idAccount = ?", array($_SESSION['id']), $bdd);
	$_SESSION['feedback'] = "";

	if(isset($_POST['change_email_new'])){
		//TODO: il faut réenvoyer un mail de confirmation à la nouvelle adresse email ...
		$key = bin2hex(openssl_random_pseudo_bytes(32));
	}

	if(isset($_POST['changePassword_password'])){
		$new_password = $_POST['changePassword_newPassword_first'];
		$old_password = $_POST['changePassword_password'];
		$req = $bdd->prepare('SELECT * FROM account WHERE idAccount =?');
		if($req->execute(array($_SESSION['id']))) {
			$data = $req->fetch();
			if(password_verify($old_password, $data['password'])){
				$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
				update_value_BDD('account', 'password = ?', 'idAccount =?', array($hashed_password, $_SESSION['id']), $bdd);
				$_SESSION['feedback'] = "Votre mot de passe a correctement été modifié.";
			}
			else{
				$_SESSION['feedback'] = "Votre mot de passe actuel est incorrect.";
			}
		}
		else{
			$_SESSION['feedback'] = "Zut, un bug s'est produit.";
		}
	}

	header("Location: parametres.php");
	exit();
?>