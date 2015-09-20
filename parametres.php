<?php
	require_once("verifSessionProf.php");
	require_once("conn_pdo.php");
	require_once("ListFunction.php");

	$current_email = get_value_BDD("email", "account", "idAccount = ?", array($_SESSION['id']), $bdd);
	$feedback = "";
	if(isset($_SESSION['feedback'])){
		$feedback = $_SESSION['feedback'];
		unset($_SESSION['feedback']);
	}
?>

<!DOCTYPE html>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Paramètres de votre compte</title>
		<link rel="stylesheet" type="text/css" href="static/css/view.css" media="all">
		<script type="text/javascript" src="static/js/view.js"></script>
	</head>
	<body id="main_body">
		<?php include("headerEnseignant.php"); ?>
			<div id="form_container">
			<h1><a>Untitled Form</a></h1>
				<div style="width:400px;display:inline-block">

						
					<div class="form_description"></div>
					<div class="form_description">
						<h3>Votre compte</h3>
					</div>			

					<form id="form_470214" class="appnitro"  method="post" action="checkModifyPassword.php">
						<ul>
							<li id="li_2" >
								<h3>Adresse email</h3>
								<p>
									<label for="change_email_current">Adresse e-mail actuelle</label>
	                            	<input type="email" id="change_email_current" name="change_email_current" class="inputformEmail" disabled="disabled" value=<?php echo "\"".$current_email."\"" ?> />
            					</p>
            					<p>
	            					<label for="change_email_new">Nouvel e-mail</label>
	                            	<input type="email" id="change_email_new" name="change_email_new" class="inputformEmail" required="required" />
	            				</p>

								<input type="submit" value="Envoyer" name="email_validation_button" />
							</li>
						</ul>
				  </form>

					<form id="form_470213" class="appnitro"  method="post" action="checkModifyPassword.php">			
						<ul>
							<li id="li_1">
								<h3>Changer votre mot de passe</h3>
								<p id="feedback"><?php echo $feedback;?></p>

								<p>
                                	<label for="changePassword_password">Mot de passe actuel</label>
                                	<input type="password" id="changePassword_password" name="changePassword_password" required="required"/>
                                </p>
                                <p>
                           			<label for="changePassword_newPassword_first">Nouveau mot de passe</label>
					            	<input type="password" id="changePassword_newPassword_first" name="changePassword_newPassword_first" required="required"/>
					            </p>
					            <p>
					            	<label for="changePassword_newPassword_second">Réécrire nouveau mot de passe</label>
					            	<input type="password" id="changePassword_newPassword_second" name="changePassword_newPassword_second" required="required"/>
					            </p>
								<input type="submit" value="Envoyer" name="password_validation_button" onclick="return checkPass()"/>

							</li>
						</ul>
					</form>
					
			</div>
		<img id="bottom" src="static/images/bottom.png" alt="">

		<script type="text/javascript"> 

		function checkPass() {
			var min_size_password = 6;
		    var pass1 = document.getElementById("changePassword_newPassword_first").value;
		    var pass2 = document.getElementById("changePassword_newPassword_second").value;
		    var ok = true;
		    if(pass1.length < min_size_password){
		    	alert("Votre nouveau mot de passe doit faire au minimum 6 caractères.")
		    	document.getElementById("changePassword_newPassword_first").style.borderColor = "#E34234";
			    document.getElementById("changePassword_newPassword_second").style.borderColor = "#E34234";
		    	ok = false;
		    }
		    else{
			    if (pass1 != pass2) {
			        alert("Les mots de passe ne sont pas identiques");
			        document.getElementById("changePassword_newPassword_first").value = "";
			        document.getElementById("changePassword_newPassword_second").value = "";
			        document.getElementById("changePassword_newPassword_first").style.borderColor = "#E34234";
			        document.getElementById("changePassword_newPassword_second").style.borderColor = "#E34234";
			        ok = false;
			    }
		    }
		    return ok;
		}		
		</script>
	</body>
</html>
