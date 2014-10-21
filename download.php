<?
header("Content-type: application/force-download");
//header("Content-Disposition: attachment; filename=".$filename);
//header("Content-Disposition: attachment; filename=fichier.txt");
header("Content-Disposition: attachment; filename=".$nomfichier);
//readfile($chemin.$filename);
//readfile("http://localhost/mac/diag/".$nomfichier);
readfile("diag/".$nomfichier);
?> 