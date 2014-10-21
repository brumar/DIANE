<?php
session_start();// Utilisez $HTTP_SESSION_VARS avec PHP 4.0.6 ou plus ancien
if (!isset($_SESSION['count'])) 
{    
	$_SESSION['compteur'] = 0;
} 
else {    
	$_SESSION['compteur']++;
}
?>
