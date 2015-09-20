<?php
	header('Content-type: text/html; charset=utf-8');
	session_start();
	if(!(isset($_SESSION['numEleve']))) { //Peut être pas la bonne condition..
		header("Location: eleve.php");
		exit();
	}
	session_regenerate_id(true); // Pas sûr
?>