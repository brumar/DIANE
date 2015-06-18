<?php
	require_once("conn_pdo.php");
	session_start();
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
			unset($_SESSION['passation']);
			header("Location: profil_eleve.php"); // TODO : mieux rediriger quand la session est finie
		}
		else{
			header("Location: interface.php");
		}
	}
	else{
		header("Location: interface.php"); //TODO : PAS SUR DU TOUT
	}
?>