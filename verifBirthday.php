<?php
	session_start();
	require_once("ListFunction.php");
	require_once("conn_pdo.php");
	if(isset($_POST['idPupilHidden'])){
		if(isset($_SESSION['chosenSerie'])){
			$serie_choisie = $_SESSION['chosenSerie'];
			//D'abord, on vérifie que l'élève doit effectivement faire la série (le contraire ne devrait pas arriver dans une utilisation normale)
			if(exists_in_BDD('serie_eleve', 'idEleve = ? AND idSerie = ?', array($_POST['idPupilHidden'], $serie_choisie), $bdd)){
				$posted_day = $_POST['day_birthday'];
				$posted_month = $_POST['month_birthday'];

				$req = $bdd->prepare('SELECT DATE_FORMAT(dateNais, "%e") AS jour, DATE_FORMAT(dateNais, "%c") AS mois FROM eleve WHERE numEleve = ?');
				if($req->execute(array($_POST['idPupilHidden']))){
					$res = $req->fetch();

					if($res['jour'] != $posted_day || $res['mois'] != $posted_month){
						$_SESSION['wrongBirthday'] = true;
						header('location: eleve.php');
						exit();
					}
					else{ // L'élève a bien rentré sa date de naissance
						$req = $bdd->prepare('SELECT * FROM eleve WHERE numEleve =?');
			        	
			        	if($req->execute(array($_POST['idPupilHidden']))){
							$enregistrement = $req->fetch();
							session_unset(); //Suppression d'une éventuelle autre session présente

							//SESSION de l'élève
					        $_SESSION['numEleve']=$enregistrement['numEleve']; 
							$_SESSION['nom']= ucfirst($enregistrement['nom']);
						    $_SESSION['prenom']= ucfirst($enregistrement['prenom']);

						    //Données de passation
						    creerSessionPassation($_SESSION['numEleve'], $serie_choisie, $bdd, "CODE");
							header("location: interface.php"); //NOPE, faut l'envoyer directement sur INTERFACE... ... ...
							exit();
						}
					}
				}
			}
			else{ // l'élève en question n'est pas censé faire cet exercice///
				//TODO: find what to do..
			}
		}
	}
	header("location: eleve.php");
	exit();
?>