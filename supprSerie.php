<?php
	require_once("verifSessionProf.php");
	require_once("conn_pdo.php");
	require_once("ListFunction.php");


	if(isset($_POST['idToSuppr'])){
		if(is_numeric($_POST['idToSuppr'])){
			$idToSuppr = (int)$_POST['idToSuppr'];
			// On vérifie que l'account a le droit de supprimer la série en question //TODO : add admin rights

			$req = $bdd->query('SELECT idCreator from serie WHERE idSerie = '.$idToSuppr);
			$res = $req->fetch();
			
			if($_SESSION['id'] != $res['idCreator']){ // Ne devrait pas arriver dans une utilisation normale... J'ai l'impression que ça veut dire qu'il a forgé la requête POST
				$req->closeCursor();
				$_SESSION['feedbackSuppr'] = "Vous n'avez pas les droits pour supprimer cette série...";
				header("Location: gerer_series.php");
				exit();
			}
			else{

				// Toutes les tables potentiellement impliquées par la suppression d'une série : serie_eleve, pbm_serie, trace
				 //TODO : on vérifie qu'il n'y a aucune trace avec la série, ni aucune présence dans "serie_eleve"...

				if(exists_in_BDD('trace', 'serie = ?', array($idToSuppr), $bdd)){
					//Un élève a déjà résolu cette série : on ne la supprime pas ?
					$_SESSION['feedbackSuppr'] = "Un élève a résolu cette série, elle ne peut pas être supprimée.";
				}
				elseif(exists_in_BDD('serie_eleve', 'idSerie = ?', array($idToSuppr), $bdd)){
					//Un prof a assigné cette série à des élèves : on ne la supprime pas ?
					$_SESSION['feedbackSuppr'] = "Un prof a assigné cette série d'exercices à une classe d'élèves, elle ne peut pas être supprimée.";
				}
				else{ // A priori pas de soucis
					// Step 1 : Suppression des dépendances dans serie_pbm
					$bdd->query('DELETE FROM pbm_serie where serie = '.$idToSuppr);// Si step 1 marche et pas step 2 ... ARGH

					//Suppression de la série
					$bdd->query('DELETE FROM serie where idSerie = '.$idToSuppr);

					$_SESSION['feedbackSuppr'] = "La série a correctement été supprimée.";

				}
			}
			$req->closeCursor();
		}
	}
	header("Location: gerer_series.php");
	exit();
?>