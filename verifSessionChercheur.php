<?php
	header('Content-type: text/html; charset=utf-8');
	session_start();

	if(!(isset($_SESSION['id']))) { //Peut être pas la bonne condition..
		header("Location: enseignant.php");
		exit();
	}
	else{
		if($_SESSION['accountType']!='chercheur'){
			header("Location: profil_enseignant.php");
			exit();
		}
	}
	session_regenerate_id(true); // Pas sûr
?>