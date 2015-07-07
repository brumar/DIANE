<?php
	require_once("verifSessionProf.php");


	function format_birthday_date($dateString){
		// Either "JJ/MM/AAAA" or "AAAA-MM-JJ" are acceptable. We seek to convert to AAAA-MM-JJ if it's not already the case		

		if (strpos($dateString, '/') !== FALSE){
			$temp = explode("/", $dateString);
			if(count($temp)!=3){ //TODO: Fix that with try/catch...
				echo"Un bug s'est produit.";
				exit();
			}
			else{
				$date_nais = $temp[2]."-".$temp[1]."-".$temp[0];
				return $date_nais;
			}

		}
		else{
			return $dateString; //TODO : be sure it's ok...
		}
	}

	if (isset($_POST)){

		$_SESSION['class_form'] = array();

		$_SESSION['class_form']['ville'] = $_POST['ville'];
		$_SESSION['class_form']['nom_ecole'] = $_POST['nom_ecole'];
		$_SESSION['class_form']['nom_classe'] = $_POST['nom_classe'];
		$_SESSION['class_form']['remarques'] = $_POST['remarques'];
		$_SESSION['class_form']['niveau'] = $_POST['niveau'];


		/* Ancienne gestion des élèves */
		// $eleves=$_POST["eleves"];
		// $lines=explode("\n",$eleves);
		// $students=[];
		// foreach ($lines as $line){
		// 	$fields=explode(";",$line);
		// 	if(count($fields)==4){
		// 		$currentStudent=array("prenom"=>trim($fields[0]),"nom"=>trim($fields[1]),"date_naissance"=>trim($fields[2]),"sexe"=>trim($fields[3]));
		// 		$students[]=$currentStudent;
		// 	}
		// 	//TODO: else, il y a un gros soucis
		// }

		// $_SESSION['class_form']['eleves'] = $students;


		// -- -- -- -- -- -- -- -- -- -- LOAD STUDENTS -- -- -- -- -- -- -- -- -- --
		
		// $_SESSION['class_form']['students'] = array();

		// $_SESSION['class_form']['students']['firstname'] = $_POST['add_student_firstname'];
		// $_SESSION['class_form']['students']['name'] = $_POST['add_student_name'];
		// $_SESSION['class_form']['students']['birthday'] = $_POST['add_student_birthday'];
		// $_SESSION['class_form']['students']['sex'] = $_POST['add_student_sex'];
		// $_SESSION['class_form']['students']['remark'] = $_POST['add_student_remark'];

		$students=[];
		$verif_i = 0;
		
		$n_max_student = $_SESSION['n_max_student'];
		while($verif_i < $n_max_student){
			$curr_stud_prenom = $_POST['add_student_firstname'][$verif_i];
			$curr_stud_nom = $_POST['add_student_name'][$verif_i];

			if (($curr_stud_prenom != "") && ($curr_stud_nom != "")){
				$curr_stud_date_naissance = format_birthday_date($_POST['add_student_birthday'][$verif_i]);
				$curr_stud_remarque = $_POST['add_student_remark'][$verif_i];
				$curr_stud_sexe = $_POST['add_student_sex'][$verif_i];

				$currentStudent=array(
						"prenom"=>trim($curr_stud_prenom),
						"nom"=>trim($curr_stud_nom),
						"date_naissance"=>trim($curr_stud_date_naissance),
						"sexe"=>trim($curr_stud_sexe), 
						"remarque"=>trim($curr_stud_remarque));
				
				$students[]=$currentStudent;
			}

			$verif_i++;
		}


		// -- -- -- -- -- -- -- -- -- -- END OF LOAD STUDENTS -- -- -- -- -- -- -- -- -- --


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

			$req = $bdd->prepare("INSERT INTO eleve VALUES(:numEleve, :nom, :prenom, :dateNais, :classe, :numClasse, :ecole, :ville, :sexe, :dateIns, :remarque)");
			$req->execute(array(
				'numEleve' => '',
				'nom' => $eleve["nom"],
				'prenom' => $eleve["prenom"],
				'dateNais' => $eleve["date_naissance"],
				'classe' => strtolower($_SESSION['class_form']['niveau']),
				'numClasse' => $idNouvelleClasse,
				'ecole' => $_SESSION['class_form']['nom_ecole'],
				'ville' =>  $_SESSION['class_form']['ville'],
				'sexe' => $eleve["sexe"],
				'dateIns' => $date,
				'remarque' => $eleve["remarque"]));

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