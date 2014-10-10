<?php if(isset($_POST[errnserie])) 
		{ 
			echo 'Erreur, le champ N° de serie est incorrecte'; 
		} 
		else 
		{ 
			foreach($_POST as $key=>$valeur) 
			 { 
			 	echo 'POST $key<==>$valeur<br />'; 
			 } 
		} 
?>

