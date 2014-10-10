<?php
		$reponse = preg_replace ('/([a-zA-Z]) *- *([a-zA-Z])/','\1 \2',$text);
		//echo $reponse;
		echo "<br/>"; 
	
		//suprime tous caractere different de [^\d+-=:*]
		$reponse = trim(preg_replace ('/[^0-9|,|(|)|+|*|=|-]/i', " ",$reponse));//supprimer la division
		//echo $reponse;
		echo "<br/>"; 
		/* echo $reponse;
		echo "<br/>"; */
		
		//tabNombre contient  tous les nombres que contient la r�ponse de l'apprenant
		$tabNombre = preg_split ("/[\s]+/", $reponse);

		$tabNombre = array_values (preg_grep("/\d/", $tabNombre));
		
		$pattern = "#(" // [0] capture the whole operation
						."("// [1] capture the first part of the operation........... 5 + x + y + .... lastDigit
							."(?:" // non-capturing bracket
								."\d+" //digits (1 or more).......................5
								."\s*"//blank space (none or multiple)
								."[\+\-\*\/x]"//operator.......................5 +
								."\s*"//blank space (none or multiple)
							.")+"	//to capture multiple occurence of the last sequence ........ 5 + x + y +
							."\d+"//last digit..........................................5 + x + y + .... lastDigit
							."\s*"//last blank space
						.")"// THE capturing bracket
							."=?"// presence (or not) of the equal operator 5 + x + y = 
							."\s*"//blank space (none or multiple)
							."(\d*)"// [2] the result, and capture the result ...............5 + x + y = result
					.")#"; // capture the whole operation
		//echo($pattern);
		preg_match_all($pattern,$reponse,$tab);
		var_dump($tab);
		$tabOperation = $tab[0];
		$tabSR = $tab[2];
		$tabR = $tab[3];
		
		for($i=0;$i<count($tabOperation); $i++)
		 {
		 	$tabOp[$i]=trim(preg_replace('/\s*/','',$tabOperation[$i]));

			$tabSR[$i]=trim(preg_replace('/\s*/','',$tabSR[$i]));
		 }
		$pattern_final='#(';
		if (count($tabOperation)!=0){
		foreach ($tabOp as $pattern){
		$pattern=quotemeta($pattern);
		$pattern_final=$pattern_final.$pattern.'|';
		}
		$pattern_final = substr($pattern_final,0,strlen($pattern_final)-1);  //permet d'enlever le dernier |' en trop
		$pattern_final=$pattern_final.')#';
		$text=preg_replace($pattern_final,'',$text);}
		
		

		
		

?>