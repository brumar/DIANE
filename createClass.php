<?php
	require_once("verifSessionProf.php");

	if (isset($_POST)){

		$_SESSION['class_form'] = array();

		$eleves=$_POST["eleves"];
		$lines=explode("\n",$eleves);
		$students=[];
		foreach ($lines as $line){
			$fields=explode(";",$line);
			if(count($fields)==4){
				$currentStudent=array("prenom"=>trim($fields[0]),"nom"=>trim($fields[1]),"date_naissance"=>trim($fields[2]),"sexe"=>trim($fields[3]));
				$students[]=$currentStudent;
			}
			//TODO: else, il y a un gros soucis
		}

		$_SESSION['class_form']['eleves'] = $students;
		$_SESSION['class_form']['ville'] = $_POST['ville'];
		$_SESSION['class_form']['nom_ecole'] = $_POST['nom_ecole'];
		$_SESSION['class_form']['nom_classe'] = $_POST['nom_classe'];
		$_SESSION['class_form']['remarques'] = $_POST['remarques'];
		$_SESSION['class_form']['niveau'] = $_POST['niveau'];

		require_once("conn_pdo.php");

		// Création de la classe

		$req = $bdd->prepare("INSERT INTO classe VALUES(:idClasse, :niveau, :nomEcole, :ville, :remarques, :idCreator, :nom)");
		$req->execute(array(
			'idClasse' => '',
			'niveau' => $_SESSION['class_form']['niveau'],
			'nomEcole' => $_SESSION['class_form']['nom_ecole'],
			'ville' => $_SESSION['class_form']['ville'],
			'remarques' => $_SESSION['class_form']['remarques'],
			'idCreator' => $_SESSION['id'],
			'nom' => $_SESSION['class_form']['nom_classe']));
			//TODO : gestion d'erreurs...

		$idNouvelleClasse = $bdd->lastInsertId();
		$req->closeCursor();

		// Création des comptes pour chaque élève et du lien élève-classe

		$aujourdhui=getdate(); $mois=$aujourdhui['mon']; $jour=$aujourdhui['mday']; $annee=$aujourdhui['year'];
		$heur=$aujourdhui['hours']; $minute=$aujourdhui['minutes']; $seconde=$aujourdhui['seconds'];
		$date=$annee."-".$mois."-".$jour." ".$heur.":".$minute.":".$seconde;

		foreach($students as $eleve){
			//echo $eleve['nom']." ". $eleve['prenom']." ". $eleve['date_naissance']." ". $eleve['sexe']."<br/>";
			// Il faut convertir la date de naissance au format AAAA-MM-JJ
			$temp = explode("/", $eleve["date_naissance"]);
			if(count($temp)!=3){ //TODO: Fix that with try/catch...
				echo"Un bug s'est produit.";
				exit();
			}
			else{
				$date_nais = $temp[2]."-".$temp[1]."-".$temp[0];
				//echo $date_nais;
			}

			$req = $bdd->prepare("INSERT INTO eleve VALUES(:numEleve, :nom, :prenom, :dateNais, :classe, :numClasse, :ecole, :ville, :sexe, :dateIns)");
			$req->execute(array(
				'numEleve' => '',
				'nom' => $eleve["nom"],
				'prenom' => $eleve["prenom"],
				'dateNais' => $date_nais,
				'classe' => strtolower($_SESSION['class_form']['niveau']),
				'numClasse' => $idNouvelleClasse,
				'ecole' => $_SESSION['class_form']['nom_ecole'],
				'ville' =>  $_SESSION['class_form']['ville'],
				'sexe' => $eleve["sexe"],
				'dateIns' => $date));

			$idNouvelEleve = $bdd->lastInsertId();
			$req->closeCursor();

			$req = $bdd->prepare("INSERT INTO classe_eleve VALUES(:idEleve, :idClasse)");
			$req->execute(array(
				'idEleve' => $idNouvelEleve,
				'idClasse' => $idNouvelleClasse));
			$req->closeCursor();

		}

		unset($_SESSION['class_form']);
		// TODO :  SI TOUT MARCHE, UNSET ($_SESSION['class_form'])
	}

	header("Location: gestion_classe.php");
?>