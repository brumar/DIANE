<?php
	header('Content-type: text/html; charset=utf-8');
	session_start();
	require_once("ListFunction.php");
	$inconnu = False; 
	$noms_mois = array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
	$choosePupil = False;


	function displayPupil($enregistrement){
		echo '<li class="displayPupil">';
		$space = " ";
		$nomEleve = ucfirst($enregistrement['prenom']).$space.ucfirst($enregistrement['nom']);
		$buttonText = $nomEleve.", ". strtoupper($enregistrement['classe']).", ".$enregistrement['ecole'];
		//echo '<input name="buttonPupil[]" type="button" value ="'.$buttonText.'" onclick=selectPupil('.$enregistrement['numEleve'].','.(string)$nomEleve.')";>';
		echo '<input name="buttonPupil[]" type="button" value ="'.$buttonText.'" onclick=selectPupil('.$enregistrement['numEleve'].',"'.$nomEleve.'");><br/>';
		echo '</li>';
	}

	if(isset($_POST['code'])){
		require_once("conn_pdo.php");
		$inputCode = strtoupper($_POST['code']);

		$idSerie = get_value_BDD('idSerie', 'serie', 'code=?', array($inputCode), $bdd);
		if($idSerie){
			$choosePupil = True;
			// Solution temporaire de gestion des "élèves anonymes" : on leur créé un nouveau profil avec les informations qu'ils donnent
				// $_SESSION['numEleve']=1;
				// $_SESSION['nom']=" ";
			 //    $_SESSION['prenom']=" ";
			 //    $_SESSION['eleve_anonyme_serie'] = $idSerie;
				//$_SESSION['numSerie'] = $idSerie;
				//$_SESSION['nbExo'] = 0;
				// header("Location: interface.php"); //INCOHERENCE : l'élève n'a pas encore de $_SESSION, et interface.php le kick. De plus interface.php n'attend pas ça.

			// On affiche la liste des élèves a qui cette série a été assignée
		}
		else{
			echo "Aucune série n'a été trouvée avec ce code.";
		}
	}

	if(isset($_POST['nom'])){

		$nom = $_POST['nom'];
		$prenom = $_POST['prenom'];

		// Connexion mysql ($bdd)
		require_once("conn_pdo.php");

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


		<?php
		if(!($choosePupil)){
			echo '<p>';
			echo '	Bonjour et bienvenu sur DIANE ! Si ton enseignant t\'as donné un code avec des lettres et des chiffres, il faut l\'écrire ici :';
			echo '</p>';
			echo '<form name="form1" method="post" action="eleve.php" autocomplete="off">';
			echo '	<table>';
			echo '	<tr>';
			echo '		<td>';
			echo '			<input type="text" size="5" name="code">';
			echo '		</td>';
			echo '	</tr>';
			echo '	<tr>';
			echo '		<td>';
			echo '			<input type="submit" name="Submit" value="Aller">';
			echo '		</td>';
			echo '	</tr>';
			echo '	</table>';
			echo '</form>';
		}
		else{

			echo '<ul id="list_pupils">';

			$req = $bdd->prepare("SELECT idEleve FROM serie_eleve WHERE idSerie = ?");
			$req->execute(array($idSerie));

			// IL faut un rowcount, et faire quelque chose si c'est trop élevé...

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
		?>

		<form name="form_birthday" id="form_birthday_eleve" methode="post" action="verifBirthday.php">
			<p>Bonjour <span id="nomEleveFormBirthday"></span>, choisis maintenant le jour et le mois de ta naissance.</p>
			
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
			<input type="submit" value="Continuer">
		</form>


		<p>
			Sinon, si ton maître ou ta maîtresse t'as inscrit(e) sur DIANE, tu peux te connecter avec ton nom et ton prénom.
			<?php if($inconnu){
				echo "<br/><span class=\"error\">Je ne te trouve pas.</span>";
			}
			?></p>

		<form name="form2" method="post" action="eleve.php">
			<table border="0" align="center" cellspacing="0">
				<!--DWLayoutTable-->
				<tr>
					<td >Prénom &nbsp; &nbsp;</td>
					<td><input type="text" size="40" name="prenom" <?php if($inconnu){echo 'value = '.$_POST['prenom'];}?>>
					</td>
				</tr>
				<tr>
					<td>Nom &nbsp; &nbsp;</td>
		  			<td><input type="text" size="40" name="nom" <?php if($inconnu){echo 'value = '.$_POST['nom'];}?>>
		  			</td>
				</tr>
				
			</table>
			<p>
				<input type="submit" name="Submit" value="Continuer">
			</p>
		</form>

		<script type="text/javascript">
			selectPupil= function(idPupil, namePupil){
				var nomEleveFormBirthday = document.getElementById("nomEleveFormBirthday");
				nomEleveFormBirthday.innerText = namePupil;
				var form_birthday = document.getElementById("form_birthday_eleve");
				form_birthday.style.display = "block";
			}
		</script>
	</body>
</html>