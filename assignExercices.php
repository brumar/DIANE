<?php
	require_once("verifSessionProf.php");
	require_once("ListFunction.php");

	$pbm_encountered = false;
	$_SESSION['feedback_assignExercices'] = "Un problème s'est produit... vos élèves ne verront pas la série d'exercices. Si le problème persiste, merci de contacter le webmaster.";

	if (isset($_POST)){
		require_once("conn_pdo.php");

		if(isset($_POST['classe'])){
			if($_POST['classe'] == "-1"){
				$_SESSION['feedback_assignExercices'] = "Merci de sélectionner une classe.";
				$pbm_encountered = true;
				header("Location: gestion_classe.php");
				exit();
			}
			// On vérifie que le prof a bien le droit d'accéder à cette classe
			$idCreatorClasse = get_value_BDD("idCreator", "classe", "idClasse =?", array($_POST['classe']), $bdd);
			if($idCreatorClasse != $_SESSION['id']){ //Cela ne devrait arriver que si l'utilisateur lance une attaque en modifiant l'ID dans le formulaire POST
				header("Location: gestion_classe.php");
				exit();
			}
			$classe = $_POST['classe'];
		}
		else{ //A priori il n'y a qu'une seule classe possible
			$idClasse = get_value_BDD("idClasse", "classe", "idCreator =?", array($_SESSION['id']), $bdd);
			if($idClasse){
				$classe = $idClasse;		
			}
			else{ //Bug ou attaque
				header("Location: gestion_classe.php");
				exit();
			}
		}

		if($_POST['serie'] == "-1"){
			$_SESSION['feedback_assignExercices'] = "Merci de sélectionner une série.";
			$pbm_encountered = true;
			header("Location: gestion_classe.php");
			exit();
		}

		// On vérifie maintenant que la série existe. 
		if(exists_in_BDD("serie", "idSerie = ?", array($_POST['serie']), $bdd)){
			//Si la série existe bien, on donne à chaque élève de la classe l'exercice à faire. On récupère tous les élèves.

			// On génère le code
			$keep_going = true;
			$inc = 0;
			while($keep_going){
				$gen_code = generer_code();
				if(!(exists_in_BDD('serie_eleve', 'code = ?', array($gen_code), $bdd))) {
					$keep_going = false;
				}
				else{
					$inc++;
					if($inc>=1000){
						die("Problème lors de la génération du code de la série.");
					}
				}
			}
	
			$req = $bdd->query("SELECT idEleve FROM classe_eleve WHERE idClasse=".$classe);
			while ($eleve = $req->fetch()){
				//Il faut vérifier au préalable que l'exercice n'est pas déjà assigné
				if(exists_in_BDD('serie_eleve', '(idSerie = ? AND idEleve = ?)' , array($_POST['serie'], $eleve['idEleve']), $bdd)){
					$pbm_encountered = true;
					$_SESSION['feedback_assignExercices'] = "Vous avez déjà assigné ces exercices à votre classe.";
				}
				else{
					$reqInsert = $bdd->prepare("INSERT INTO serie_eleve(idSerie, idEleve, statut, code) VALUES (:idSerie, :idEleve, :statut, :code)");
					$reqInsert->execute(array(
						'idSerie' => $_POST['serie'], 
						'idEleve' => $eleve['idEleve'], 
						'statut' => 'untouched',
						'code' => $gen_code));
					$reqInsert->closeCursor();
				}
			}
			$req->closeCursor();
		}
		else{ //Bug ou attaque
			header("Location: gestion_classe.php");
			exit();
		}
		//Si on arrive ici, tout s'est bien passé
		$className = get_value_BDD("nom", "classe", "idClasse =?", array($classe), $bdd);

		if(!($pbm_encountered)){
			//$_SESSION['feedback_assignExercices'] = "C'est enregistré, vos élèves de la classe ".$className." verront cette série d'exercices s'ils se connectent avec leur nom et prénom. Le plus simple est de fournir à vos élèves le code <strong>".$gen_code."</strong>.";
			$_SESSION['feedback_assignExercices'] = "C'est enregistré. Partagez le code <strong>".$gen_code."</strong> avec vos élèves de la classe ".$className." pour qu'ils puissent y accéder.";
		}
	}

	header("Location: gestion_classe.php");
?>