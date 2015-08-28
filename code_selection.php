<?php
	session_start();
	require_once("ListFunction.php");
	require_once("conn_pdo.php");

	if(isset($_POST['code'])){
		$inputCode = strtoupper($_POST['code']);

		//$idSerie = get_value_BDD('idSerie', 'serie', 'code=?', array($inputCode), $bdd); // Avant, quand les codes étaient liés aux séries
		// $_SESSION['choosePupil'] = array();
		// if($idSerie){
		// 	$_SESSION['choosePupil']['choice'] = True;
		// 	$_SESSION['choosePupil']['idSerie'] = $idSerie;
		// }
		// else{
		// 	$_SESSION['choosePupil']['choice'] = False;
		// }


		$_SESSION['choosePupil'] = array();
		if(exists_in_BDD("serie_eleve", "code=?", array($inputCode), $bdd)){
			
			// on récupère idSerie pour vérifier que l'élève doit bien faire cette série

			$req = $bdd->prepare("SELECT idSerie FROM serie_eleve WHERE code=?");
			$req->execute(array($inputCode));
			$a = $req->fetch();
			$idSerie = $a['idSerie'];

			$_SESSION['choosePupil']['choice'] = True;
			$_SESSION['choosePupil']['idSerie'] = $idSerie;
			$_SESSION['choosePupil']['selectedCode'] = $inputCode;
		}
		else{
			$_SESSION['choosePupil']['choice'] = False;
		}

		
	}
	header("location: eleve.php");
?>