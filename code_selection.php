<?php
	session_start();
	require_once("ListFunction.php");
	require_once("conn_pdo.php");

	if(isset($_POST['code'])){
		$inputCode = strtoupper($_POST['code']);

		$idSerie = get_value_BDD('idSerie', 'serie', 'code=?', array($inputCode), $bdd);
		$_SESSION['choosePupil'] = array();
		if($idSerie){
			$_SESSION['choosePupil']['choice'] = True;
			$_SESSION['choosePupil']['idSerie'] = $idSerie;
		}
		else{
			$_SESSION['choosePupil']['choice'] = False;
		}
	}
	header("location: eleve.php");
?>