<?php
$dossier2 = ".\\audio\\complement\\exo21\\";//prendre les caracteristiques de l'enoncé 
		if (is_dir($dossier2)){
		$dir = opendir($dossier2); 
			while($file = readdir($dir)) {
				if(($file!='.')&&($file!='..')){
				unlink($dossier2.$file);}
			}
		closedir($dir);
		rmdir($dossier2);
		}
		
$dossier2 = ".\\audio\\complement\\exo19\\";//prendre les caracteristiques de l'enoncé 
		if (is_dir($dossier2)){
		$dir = opendir($dossier2); 
			while($file = readdir($dir)) {
				if(($file!='.')&&($file!='..')){
				unlink($dossier2.$file);}
			}
		closedir($dir);
		rmdir($dossier2);
		}
unlink(".\audio\complement\exo20\part7.mp3");
unlink(".\audio\complement\exo20\part4-QI.mp3");
unlink(".\audio\complement\exo20\part1.mp3");
unlink(".\audio\complement\exo20\part2.mp3");
unlink(".\audio\complement\exo19\part1.mp3");
unlink(".\audio\complement\exo19\part4-QI.mp3");		
		


 ?>