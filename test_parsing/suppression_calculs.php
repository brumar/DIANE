<?php
		$reponse = ereg_replace ('([a-zA-Z]) *- *([a-zA-Z])','\1 \2',$text);
		//echo $reponse;
		echo "<br/>"; 
	
		//suprime tous caractere different de [^\d+-=:*]
		$reponse = trim(eregi_replace ('[^0-9|,|(|)|+|*|=|-]', " ",$reponse));//supprimer la division
		//echo $reponse;
		echo "<br/>"; 
		/* echo $reponse;
		echo "<br/>"; */
		
		//tabNombre contient  tous les nombres que contient la réponse de l'apprenant
		$tabNombre = preg_split ("/[\s]+/", $reponse);

		$tabNombre = array_values (preg_grep("/\d/", $tabNombre));
		
		$pattern = "/(((?:\d+\s*[\+\-\*\/x]\s*)+\d+\s*)=?\s*(\d*))/"; //(?:) parenthèse non capturante (supprimer la division :)
		preg_match_all($pattern,$reponse,$tab);
		
		$tabOperation = $tab[0];
		$tabSR = $tab[2];
		$tabR = $tab[3];
		
		for($i=0;$i<count($tabOperation); $i++)
		 {
		 	$tabOp[$i]=trim(ereg_replace('\s*','',$tabOperation[$i]));

			$tabSR[$i]=trim(ereg_replace('\s*','',$tabSR[$i]));
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