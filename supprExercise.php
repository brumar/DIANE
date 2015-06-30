<?php
	require_once("verifSessionProf.php");
	require_once("ListFunction.php");
	require_once("conn_pdo.php");

	if($_POST){
		if(isset($_POST['idToSuppr'])){
			if(is_numeric($_POST['idToSuppr'])){
				$idToSuppr = (int)$_POST['idToSuppr'];
				// On vérifie que l'account a le droit de supprimer la série en question //TODO : add admin rights

				$req = $bdd->query('SELECT idCreator from pbm WHERE idPbm = '.$idToSuppr);
				$res = $req->fetch();
				
				if($_SESSION['id'] != $res['idCreator']){ // Ne devrait pas arriver dans une utilisation normale... A priori, sauf erreur, ça veut dire qu'il a forgé la requête POST
					//BAH NON est ce qu'on permet de suppr les pbm des autres
					$_SESSION['feedback_supprExercise']= "Vous n'avez pas les droits pour supprimer ce problème...";
				}
				else{
					// D'abord, on vérifie s'il y a une trace pour ce problème
					if(exists_in_BDD('trace', 'pbm =?', array($idToSuppr), $bdd)){
						$bdd->query('UPDATE pbm SET visible = "false" WHERE idPbm = '.$idToSuppr);
						$_SESSION['feedback_supprExercise']= "Le problème a déjà été résolu au moins une fois. Par conséquent, il n'a été que masqué, et pas réellement supprimé. Ainsi, les données ne sont pas perdues, et les élèves peuvent toujours passer ce problème s'il leur a été assigné.";
					}
					else{
						// Suppression du problème
						$bdd->query('DELETE FROM pbm where idPbm = '.$idToSuppr);
						$_SESSION['feedback_supprExercise'] = "Problème correctement supprimé.";
					}
				}

				$req->closeCursor();
			}
		}
	}
	header("Location: gerer_exercices.php");
?>
