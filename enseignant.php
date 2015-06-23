<?php
	header('Content-type: text/html; charset=utf-8');
	session_start();

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

		// 1) on regarde si le login existe dans "account"
		$count = count_BDD('SELECT COUNT(*) FROM account WHERE login =?', array($login), $bdd);

		if ($count == 1){  // 1a) le compte existe, on vérifie que le mot de passe est bon
			$req2 = $bdd->prepare('SELECT * FROM account WHERE login =?');
			if($req2->execute(array($login))) {
				$data = $req2->fetch();
				if(password_verify($mdp, $data['password'])){
					session_unset();
					$_SESSION['login'] = $login;
					$_SESSION['accountType'] = 'enseignant';
					$_SESSION['id'] = $data['idAccount'];
					header("Location: profil_enseignant.php");
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
	}
?>

<!DOCTYPE html>

<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="static/css/default.css" />
		<title> DIANE enseignant </title>
	</head>

	<body>
		<p> <a href="index.html">Accueil</a></p>    
		<h3>Veuillez vous identifier pour continuer</h3>
		<form method="post" action="enseignant.php">

			<table cellspacing="0">
				<tr>
					<td>Nom d'utilisateur : &nbsp; &nbsp;</td>
					<td> <input name = "nom" type = text id="nom"> </td>
				</tr>
				<tr>
					<td> Mot de passe :&nbsp; &nbsp; </td>
					<td> <input name = "pass" type = password id="pass"> </td>
				</tr>
				<tr>
					<td height="32" colspan =2 align = center> 
						<input type = submit value = "valider">
					</td>
				</tr>
			</table>
		</form>
		

		<h3>Vous n'avez pas d'identifiant ?</h3>
		<p>Créez un compte en remplissant ce formulaire</p>

		<form method="post" action="inscription.php">

			<table>
			<tr>
			 	<td>
                	Prénom :&nbsp; &nbsp;
            	</td>
            	<td>
                	<input type="text" name="reg_prenom" required="required"/>
                </td>
            </tr>
        	<tr>
        		<td>
        			Nom :&nbsp; &nbsp;
        		</td>
        		<td>
        			<input type="text" name="reg_nom" required="required"/>
        		</td>
        	</tr>
        	<tr>
        		<td>
        			Adresse email :&nbsp; &nbsp;
        		</td>
        		
        		<td>
        			<input type="email" name="reg_email" required="required"/>
        		</td>
        	</tr>
        	<tr>
        		<td>
        			Choisissez un mot de passe :&nbsp; &nbsp;
        		</td>
        		
        		<td>
        			<input type="password" name="password" id="pass1">
        		</td>
        	</tr>
        	<tr>
        		<td>
        			Confirmer le mot de passe :&nbsp; &nbsp;
        		</td>
        		<td>
        			<input type="password" name="confirmPass" id="pass2">
        		</td>
        	</tr>
        </table>
        	<p>
                <em>
                    Un lien de confirmation va vous être envoyé sur l'adresse email que vous avez indiqué.
                </em>
            </p>
            <input type="submit" value="Submit" name="submitBtn" onclick="return checkPass()">S&#039;inscrire</input> <!--//onclick="this.disabled=true;" this.form.submit(); après true-->
		</form>

		<script type="text/javascript"> 

		function checkPass() {
			var min_size_password = 6;
		    var pass1 = document.getElementById("pass1").value;
		    var pass2 = document.getElementById("pass2").value;
		    var ok = true;
		    if(pass1.length < min_size_password){
		    	alert("Votre mot de passe doit faire au minimum 6 caractères.")
		    	document.getElementById("pass1").style.borderColor = "#E34234";
			    document.getElementById("pass2").style.borderColor = "#E34234";
		    	ok = false;
		    }
		    else{
			    if (pass1 != pass2) {
			        alert("Les mots de passe ne sont pas identiques");
			        document.getElementById("pass1").value = "";
			        document.getElementById("pass2").value = "";
			        document.getElementById("pass1").style.borderColor = "#E34234";
			        document.getElementById("pass2").style.borderColor = "#E34234";
			        ok = false;
			    }
		    }
		    return ok;
		}		
		</script>

	</body>
</html>




