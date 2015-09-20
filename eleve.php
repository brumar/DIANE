<?php
	header('Content-type: text/html; charset=utf-8');
	session_start();
	require_once("ListFunction.php");
	require_once("conn_pdo.php");
	$inconnu = False; 
	$noms_mois = array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
	


	function displayPupil($enregistrement){
		echo '<p class="displayPupil">';
		$space = " ";
		$nomEleve = trim(ucfirst($enregistrement['prenom'])).$space.trim(ucfirst($enregistrement['nom']));
		$buttonText = $nomEleve.", ". strtoupper($enregistrement['classe']).", ".$enregistrement['ecole'];
		//echo '<input name="buttonPupil[]" type="button" value ="'.$buttonText.'" onclick=selectPupil('.$enregistrement['numEleve'].','.(string)$nomEleve.')";>';
		echo "<input name=\"buttonPupil[]\" type=\"button\" value =\"".$buttonText."\" onclick=\"selectPupil(".$enregistrement['numEleve'].",&quot;".ucfirst($enregistrement['prenom'])."&quot;);\"/><br/>";
		echo '</p>';
	}

	$choosePupil = False;
	if(isset($_SESSION['choosePupil'])){ //Feedback from code_selection.php
		if($_SESSION['choosePupil']['choice']){
			$choosePupil = True;
			$selectedCode = $_SESSION['choosePupil']['selectedCode'];
			$_SESSION['chosenSerie'] = $_SESSION['choosePupil']['idSerie'];
		}
		else{
			$feedback_choosePupil = "Aucune série n'a été trouvée avec ce code. Tu as peut-être mal écrit le code."; 
			//echo "Aucune série n'a été trouvée avec ce code."; //TODO: régler ça mieux
		}
		unset($_SESSION['choosePupil']);
	}

	$wrongBirthday = false;
	if(isset($_SESSION['wrongBirthday'])){ // Feedback from verifBirthday.php
		$wrongBirthday = true;
		unset($_SESSION['wrongBirthday']);
	}

	if(isset($_POST['nom'])){ //TODO : à faire dans une autre page aussi

		$nom = $_POST['nom'];
		$prenom = $_POST['prenom'];

		// 1) on regarde si le nom et le prénom existent dans "account"
		$count = count_BDD('SELECT COUNT(*) FROM eleve WHERE nom =? AND prenom =?', array($nom, $prenom), $bdd);
	  
		if ($count == 1){ 

			$req = $bdd->prepare('SELECT * FROM eleve WHERE nom =? AND prenom =?');
	        if($req->execute(array($nom, $prenom))){
				$enregistrement = $req->fetch();
				session_unset();
		        $_SESSION['numEleve']=$enregistrement['numEleve'];
				$_SESSION['nom']= ucfirst($enregistrement['nom']);
			    $_SESSION['prenom']= ucfirst($enregistrement['prenom']);
			
				header("Location: profil_eleve.php");
				exit();
			}
			else{
				die();
			}
	    }
	    else if($count == 0)
		{// Nom et/ou Prénom incorecte
			$inconnu = True;
			// echo('<html>');
			// echo('<head>');
			// echo('<meta http-equiv="Content-Type" content="text/html; charset=utf-8">');
			// echo('<title>Erreur dans le Nom et/ou Prénom</title>');
			// echo('</head>');
			// echo('<body>');
			// echo('<p>&nbsp;</p>');
			// echo('<table width="50%"  border="0" align="center">');
			// echo('<tr>');
			// echo(' <td width="42%" align="right">Nom : </td>');
			// echo('<td width="58%"><b style="color: #FF0000;">'. $_POST['nom'].'</b></td>');
			// echo('</tr>');
			// echo('<tr>');
			// echo('<td align="right">Pr&eacute;nom : </td>');
			// echo('<td><b style="color: #FF0000">'.$_POST['prenom'].'</b></td>');
			// echo('</tr>');
			// echo('</table>');
			// echo('<hr align="center" width="30%" />');
			// echo('<table width="50%"  border="0" align="center" cellpadding="5">');
			// echo('<tr align="center">');
			// echo('<td>Je ne trouve pas ton nom.</td>');
			// echo('</tr>');
			// echo('<tr align="center">');
			// echo('<td>Si tu n\'es pas inscrit
			// <a href="formeleve.php?nom='.$_POST['nom'].'&prenom='.$_POST['prenom'].'">inscris-toi ici</a></td>');
			// echo('</tr>');
			// echo('<tr align="center">');
			// echo('<td>Si tu as fait une faute de frappe sur ton nom, <a href="corrEleve.php?nom='.$_POST['nom'].'&prenom='.$_POST['prenom'].'">	  corrige-la</a></td>');
			// echo('</tr>');
			// echo('</table>');
			// echo('</body>');
			// echo('</html>'); 
		}//fin du else
		else{ //plus que 1... AIE
			//TODO : régler ça, at least make sure it cannot happen
			// Rediriger vers une page où on choisit son maître/sa maîtresse
			echo "oups !";
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>DIANE - élève</title>
		<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
		<link rel="stylesheet" href="static/css/view.css" />
	</head>
	<body>
		<?php require_once("headerEleve.php"); ?>

		<div id="form_container">

			<?php
			if(isset($feedback_choosePupil)){
				echo '<p id="feedback_mauvais_code">';
				echo $feedback_choosePupil;
				echo '</p>';
			}

			if($wrongBirthday){
				echo '<p id="feedback_mauvais_anniversaire">';
				echo "La date d'anniversaire choisie n'est pas la bonne.";
				echo '</p>';
			}

			if(!($choosePupil)){// NON faudrait différencier false par défaut et foirage de choix
				if(!(isset($feedback_choosePupil)) and !($wrongBirthday)){
					echo '<p>Bienvenu sur DIANE ! </p>';
				}
				echo '<p>Si ton enseignant t\'as donné un code avec des lettres et des chiffres, il faut l\'écrire ici :</p>';
				echo '<form name="form1" id="formCodeSelection" method="post" action="code_selection.php" autocomplete="off">';
				echo '	 <p><input type="text" size="5" name="code"></p>';
				echo '	 <input type="submit" name="Submit" value="Aller">';
				echo '</form>';
			}
			else{ //(=> $choosePupil == True)

				$req = $bdd->prepare("SELECT idEleve FROM serie_eleve WHERE code = ?");
				$req->execute(array($selectedCode));

				$nb_eleves = $req->rowCount();

				if($nb_eleves == 0){
					echo '<p>Ce code n\'est pas valide.</p>';
					echo '<input type= "button" value="Revenir" onclick="getBackToEleve()"/>';
				}

				else{ 
					echo '<p>Choisis ton nom dans la liste :</p>';
					echo '<ul id="list_pupils">';
					while ($enregistrement = $req->fetch()){
						$current_pupil = $enregistrement['idEleve'];
						$req2 = $bdd->prepare("SELECT * FROM eleve WHERE numEleve = ?");
						$req2->execute(array($current_pupil));
						displayPupil($req2->fetch());
						$req2->closeCursor();
					}
					$req->closeCursor();

					echo '</ul>';
				}
			}
			?>

			<form name="form_birthday" id="form_birthday_eleve" method="post" action="verifBirthday.php">
				<p>Bonjour <span id="nomEleveFormBirthday"></span>, choisis maintenant le jour et le mois de ta naissance pour te connecter.</p>
				
				<label for="day_birthday">Jour</label>
				<select name = "day_birthday">
					<?php
					for($i=1; $i<32;$i++){
						echo '<option value="'.$i.'">'.$i.'</option>';
					}
					?>
				</select>
				<br/>
				<label for="month_birthday">Mois</label>
				<select name = "month_birthday">
					<?php
					for($i=1; $i<13;$i++){
						echo '<option value="'.$i.'">'.$noms_mois[$i-1].'</option>';
					}
					?>
				</select>
				<br/>
				<input type="hidden" name="idPupilHidden" id="idPupilHidden">
				<input type="submit" value="Continuer">
			</form>
		</div>

			<!-- 
			<form name="form2" method="post" id="formNomPrenom" action="eleve.php">
				<p>
					Sinon, si ton maître ou ta maîtresse t'as inscrit(e) sur DIANE, tu peux te connecter avec ton nom et ton prénom.
					<?//php if($inconnu){
						//echo "<br/><span class=\"error\">Je ne te trouve pas.</span>";
					//}
				?></p>
				<table border="0" align="center" cellspacing="0">
					<tr>
						<td >Prénom &nbsp; &nbsp;</td>
						<td><input type="text" size="40" name="prenom" <?php //if($inconnu){echo 'value = '.$_POST['prenom'];}?>>
						</td>
					</tr>
					<tr>
						<td>Nom &nbsp; &nbsp;</td>
			  			<td><input type="text" size="40" name="nom" <?php //if($inconnu){echo 'value = '.$_POST['nom'];}?>>
			  			</td>
					</tr>
					
				</table>
				<p>
					<input type="submit" name="Submit" value="Continuer">
				</p>
			</form> -->

		<script type="text/javascript">
			getBackToEleve = function(){
				location.href = "eleve.php";
			}
			selectPupil= function(idPupil, namePupil){
				var nomEleveFormBirthday = document.getElementById("nomEleveFormBirthday");
				nomEleveFormBirthday.innerText = namePupil;
				var form_birthday = document.getElementById("form_birthday_eleve");
				form_birthday.style.display = "block";
				form_idPupilHidden = document.getElementById("idPupilHidden");
				form_idPupilHidden.value = idPupil;
			}

			<?php
			if($choosePupil){
				echo 'var formNomPrenom = document.getElementById("formNomPrenom");';
				echo 'formNomPrenom.style.display = "none";';
			}
			?>
		</script>
	</body>
</html>