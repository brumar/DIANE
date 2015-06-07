<?php
	header('Content-type: text/html; charset=utf-8');
	session_start();

	function count_BDD($SQL_req, $array_req, $b){
		$r = $b->prepare($SQL_req);
		if($r->execute($array_req)){
			$tmp_variable = $r->fetch();
			$count = $tmp_variable[0];
			$r->closeCursor();
			return($count);
		}
		else{
			die();
		}
	}
	$inconnu = False; 

	if($_POST){

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
		        $_SESSION['numEleve']=$enregistrement['numEleve'];
				$_SESSION['nom']=$enregistrement['nom'];
			    $_SESSION['prenom']=$enregistrement['prenom'];
			
				header("Location: profil_eleve.php");
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
			echo "oups !";
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>DIANE - élève</title>
		<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
		<link rel="stylesheet" href="static/css/default.css" />
	</head>
	<body>


		<p>
			Bonjour et bienvenu sur DIANE ! Si ton enseignant t'as donné un 
			code avec des lettres et des chiffres, il faut le rentrer ici :
		</p>

		<p>
			Sinon, si tu es déjà inscris sur DIANE, tu peux te connecter avec ton nom et ton prénom.
			<?php if($inconnu){
				echo "Je ne te trouve pas.";
			}
			else{
				echo "Pour te connecter, écris ton nom et ton prénom";
			}?></p>

		<form name="form1" method="post" action="eleve.php">
			<table border="0" align="center" cellspacing="0">
				<!--DWLayoutTable-->
				<tr>
					<td>Nom &nbsp; &nbsp;</td>
		  			<td><input type="text" size="40" name="nom">
		  				<?php if($inconnu){
							echo $_POST['nom'];
						}?>
		  			</td>
				</tr>
				<tr>
					<td >Prénom &nbsp; &nbsp;</td>
					<td><input type="text" size="40" name="prenom">
						<?php if($inconnu){
							echo $_POST['prenom'];
						}?>
					</td>
				</tr>
			</table>
			<p>
				<input type="submit" name="Submit" value="Continuer">
			</p>
		</form>
	</body>
</html>