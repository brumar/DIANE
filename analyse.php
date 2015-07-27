<?php
	require_once("verifSessionProf.php");
	require_once("conn_pdo.php");
	require_once("ListFunction.php");

	if($_POST){
		if(isset($_POST['fanalyse_demande'])) {
			
			$_SESSION['f_analyse'] = array();
			$_SESSION['f_analyse']['demande'] = $_POST['fanalyse_demande'];
			$_SESSION['f_analyse']['numSerie'] = $_POST['fanalyse_numSerie'];

			if(isset($_POST['fanalyse_numEleve'])){
				$_SESSION['f_analyse']['numEleve'] = $_POST['fanalyse_numEleve'];
			}
			if(isset($_POST['fanalyse_numClasse'])){
				$_SESSION['f_analyse']['numClasse'] = $_POST['fanalyse_numClasse'];
			}
			
			header("Location: " . $_SERVER['REQUEST_URI']);
			exit();
		}
	}

	if(isset($_SESSION['f_analyse'])){

		$demande = $_SESSION['f_analyse']['demande'];
		$numSerie = $_SESSION['f_analyse']['numSerie'];

		if(isset($_SESSION['f_analyse']['numEleve'])){
			$numEleve = $_SESSION['f_analyse']['numEleve'];	
		}
	
		if(isset($_SESSION['f_analyse']['numClasse'])){
			$numClasse = $_SESSION['f_analyse']['numClasse'];	
		}

		//unset($_SESSION['f_analyse']);
	}

	function get_duree_resolution($actions){

		$expl = explode("***", $actions);
		$last_elt = end((array_values($expl))); //should contain something of the format "XXXX//button";
		$expl2 = explode("//", $last_elt);
		$nb_milliseconds = (int)$expl2[0];

		if($nb_milliseconds < 60000){
			$nb_seconds = (int)($nb_milliseconds/1000); 
			return $nb_seconds." secondes.";
		}
		else{
			$nb_minutes = (int)($nb_milliseconds/60000);
			$nb_seconds = (int)(($nb_milliseconds%60000)/1000);

			if($nb_minutes==1){
				return "1 minute et ".$nb_seconds." secondes.";
			}
			else{
				return $nb_minutes." minutes et ".$nb_seconds." secondes.";
			}
		}
	}

?>

<!DOCTYPE html>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Réponse des élèves</title>
		<link rel="stylesheet" type="text/css" href="static/css/view.css" media="all">
		<script type="text/javascript" src="static/js/view.js"></script>
	</head>
	<body id="main_body">
		<?php require_once("headerEnseignant.php"); ?>
			<div id="form_container">
			<h1><a>Untitled Form</a></h1>

					<?
						switch($demande){
							case "eleve_serie":

								$req = $bdd->prepare("SELECT * FROM trace WHERE eleve = ? AND serie = ?");
								$req->execute(array($numEleve, $numSerie));

								if($req){
									
									$prenomEleve = get_value_BDD('prenom', 'eleve', 'numEleve=?', array($numEleve), $bdd);
									$nomEleve = get_value_BDD('nom', 'eleve', 'numEleve=?', array($numEleve), $bdd);
									$nomSerie = get_value_BDD('nomSerie', 'serie', 'idSerie=?', array($numSerie), $bdd);

									echo "<h2> Réponses de ".$prenomEleve." ".$nomEleve." pour la série ".$nomSerie."</h2>";

									while($solved_pbm = $req->fetch()){

										echo "<div class=\"solved_pbm\">";
											echo "<div class=\"solved_pbm_date\">";
												echo "Exercice n°".(string)$solved_pbm['ordreSerie']."<br/>";
												echo "Date et heure : ".$solved_pbm['datetime']."<br/>";
												echo "Durée : ".get_duree_resolution($solved_pbm['actions']);
											echo "</div>";
											echo "<table>";
												echo "<tr>";
													echo "<th>Énoncé : </th>";
													echo "<th>Reponse de ".$prenomEleve." :</th>";
												echo "</tr>";
												echo "<tr>";
													echo "<td class=\"solved_pbm_enonce\">".toHTMLbreak(get_value_BDD('enonce', 'pbm', 'idPbm=?', array($solved_pbm['pbm']), $bdd))."</td>";
													echo "<td class=\"solved_pbm_reponse\">".toHTMLbreak($solved_pbm['zonetext'])."</td>";
												echo "</tr>";
												// echo "<div class=\"solved_pbm_enonce\">";
												// 	echo "Énoncé : <br><br>";
												// 	echo toHTMLbreak(get_value_BDD('enonce', 'pbm', 'idPbm=?', array($solved_pbm['pbm']), $bdd));
												// echo "</div>";
												// echo "<div class=\"solved_pbm_reponse\">";
												// 	echo "Reponse de ".$prenomEleve." :<br><br>";
												// 	echo toHTMLbreak($solved_pbm['zonetext']);
												// echo "</div>";
											echo "</table>";
										echo "</div>";
									}
								}
								else{
									echo "Il y a une erreur... Désolé !"; // TODO : ajouter "merci de contacter l'administrateur"
								}
								break;


							case "classe_serie":

								$nomClasse = get_value_BDD('nom', 'classe', 'idClasse=?', array($numClasse), $bdd);
								$nomSerie = get_value_BDD('nomSerie', 'serie', 'idSerie=?', array($numSerie), $bdd);

								echo "<h2> Réponses des élèves la classe ".$nomClasse." pour la série ".$nomSerie."</h2>";

								$eleves = $bdd->query("SELECT idEleve FROM classe_eleve WHERE idClasse =".$numClasse);

								while($eleve = $eleves->fetch()){
									$numEleve = $eleve['idEleve'];
									$state = get_value_BDD('statut', 'serie_eleve', 'idSerie=? AND idEleve=?', array($numSerie, $eleve['idEleve']), $bdd);

									$prenomEleve = get_value_BDD('prenom', 'eleve', 'numEleve=?', array($numEleve), $bdd);
									$nomEleve = get_value_BDD('nom', 'eleve', 'numEleve=?', array($numEleve), $bdd);
									$complete_name = $prenomEleve." ".$nomEleve;

									if($state == "untouched"){
											echo "<div>";
												echo $complete_name." n'a pas encore essayé de résoudre cette série d'exercices.";
											echo "</div>";
									}
									else{
										
										$req = $bdd->prepare("SELECT * FROM trace WHERE eleve = ? AND serie = ?");
										$req->execute(array($numEleve, $numSerie));

										if($req){
											
											echo "<h3> Réponses de ".$complete_name." pour la série ".$nomSerie."</h2>";

											while($solved_pbm = $req->fetch()){

												echo "<div class=\"solved_pbm\">";
													echo "<div class=\"solved_pbm_date\">";
														echo "Exercice n°".(string)$solved_pbm['ordreSerie']."<br/>";
														echo "Date et heure : ".$solved_pbm['datetime']."<br/>";
														echo "Durée : ".get_duree_resolution($solved_pbm['actions']);
													echo "</div>";
													echo "<table>";
														echo "<tr>";
															echo "<th>Énoncé : </th>";
															echo "<th>Reponse de ".$prenomEleve." :</th>";
														echo "</tr>";
														echo "<tr>";
															echo "<td class=\"solved_pbm_enonce\">".toHTMLbreak(get_value_BDD('enonce', 'pbm', 'idPbm=?', array($solved_pbm['pbm']), $bdd))."</td>";
															echo "<td class=\"solved_pbm_reponse\">".toHTMLbreak($solved_pbm['zonetext'])."</td>";
														echo "</tr>";
													echo "</table>";
												echo "</div>";
											}
										}
									}

								}

								break;

							default:
								break;
						}
					?>	

			</div>

		<img id="bottom" src="static/images/bottom.png" alt="">
	</body>
</html>
