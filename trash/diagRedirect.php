<?php 
session_start();
if ($_SESSION[type]=="complement")
 {
 //header("Location: diag_e.php");
 print($_SESSION[type]);
 }
 else if ($_SESSION[type]=="comparaison")
 {
 //header("Location: diag_a.php");
 print($_SESSION[type]);
 }*/
?>