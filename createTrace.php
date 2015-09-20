<?php
	require_once("verifSessionEleve.php");
	require_once("conn_pdo.php");
	require_once("ListFunction.php");
	
	if (isset($_POST['zonetexte'])){
		$aujourdhui=getdate(); $mois=$aujourdhui['mon']; $jour=$aujourdhui['mday']; $annee=$aujourdhui['year'];
		$heur=$aujourdhui['hours']; $minute=$aujourdhui['minutes']; $seconde=$aujourdhui['seconds'];
		$date=$annee."-".$mois."-".$jour." ".$heur.":".$minute.":".$seconde;
		
		$tmp = $_SESSION['passation']['allProblems'];
		$id_probleme = $tmp[$_SESSION['passation']['nbExo']-1];

		$req = $bdd->prepare("INSERT INTO trace(eleve, serie, ordreSerie, pbm, sas, zonetext, actions, datetime) 
								VALUES (:eleve, :serie, :ordreSerie, :pbm, :sas, :zonetext, :actions, :datetime)");
		$req->execute(array(
				'eleve' => $_SESSION['numEleve'],
				'serie' => $_SESSION['passation']['numSerie'],
				'ordreSerie' => $_SESSION['passation']['nbExo'],
				'pbm' => $id_probleme,
				'sas' => $_POST['T1'],
				'zonetext' => $_POST['zonetexte'], 
				'actions' => $_POST['Trace'],
				'datetime' => $date));
		//TODO : gestion d'erreur ici...


		// On passe à l'exercice suivant/vérifie si la série est terminée
		$_SESSION['passation']['nbExo'] = $_SESSION['passation']['nbExo']+1;
		if ($_SESSION['passation']['nbExo'] > $_SESSION['passation']['totalExo']){ // Tous les exercices ont été résolus
			if(get_value_BDD('statut', 'serie_eleve', '(idEleve = ? AND idSerie = ?)', array($_SESSION['numEleve'], $_SESSION['passation']['numSerie']), $bdd) == "opened"){
				update_value_BDD('serie_eleve', 'statut = "finishedOnce"', 'idEleve = ? AND idSerie = ?', array($_SESSION['numEleve'], $_SESSION['passation']['numSerie']), $bdd);
			}
			else{
				if(get_value_BDD('statut', 'serie_eleve', '(idEleve = ? AND idSerie = ?)', array($_SESSION['numEleve'], $_SESSION['passation']['numSerie']), $bdd) == "finishedOnce"){
					update_value_BDD('serie_eleve', 'statut = "finishedMultipleTimes"', 'idEleve = ? AND idSerie = ?', array($_SESSION['numEleve'], $_SESSION['passation']['numSerie']), $bdd);
				}
			}

			if(isset($_SESSION['passation']['type'])){
				if($_SESSION['passation']['type'] == "CODE"){
					unset($_SESSION['passation']);
					// TODO : rajouter un message de feedback à la fin
					header("Location: fin_session.php");
				}
				elseif($_SESSION['passation']['type'] == "NOM"){
					unset($_SESSION['passation']);
					header("Location: profil_eleve.php");
				}
				else{
					unset($_SESSION['passation']);
					header("Location: fin_session.php");
				}
			}
			else{
				unset($_SESSION['passation']);
				header("Location: fin_session.php");
			}
		}
		else{
			header("Location: interface.php");
		}
	}
	else{
		header("Location: interface.php"); //TODO : PAS SUR DU TOUT
	}
?>