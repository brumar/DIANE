<?php

function flat($arrays){//merge multiple arrays (input is an array of arrays)
	$output=array();
	foreach($arrays as $array){
		$output=array_merge($output,$array);
	}
	return $output;
}

function delPattern($word,$rec,$list,$index){ // create a list of regex matching $word with $rec number of missing character												//$index and $list are used for the good behavior of this recursive function 
	if($rec==0){return array($word);}
	$output=array();
	for ($i = $index+1; $i < strlen($word)-1; $i++) {
		$mot2=substr($word,0,$i).substr($word,$i+1,strlen($word)-1);//generate regex with $i'th char missing
		if($rec>1){
			$output[$i]=delPattern($mot2,$rec-1,$list,$i-1);//if there is still a reccurence level, then continue to generate regex
		}
		else{
			$list[]=$mot2;
		}
	}
	if($rec>1){
		return(flat($output));//merge all the arrays
	}
	return $list;	
}
function adPattern($word,$rec,$list,$index){// create a list of regex matching $word with $rec number of extra character
	if($rec==0){return array($word);}
	$output=array();
	for ($i = $index+1; $i < strlen($word); $i++) {
		$mot2=substr($word,0,$i).'.?'.substr($word,$i,strlen($word)-1);
		if($rec>1){
			//echo($mot2);
			$output[$i]=adPattern($mot2,$rec-1,$list,$i+1);
		}
		else{
			$list[]=$mot2;
		}
	}
	if($rec>1){
		return(flat($output));
	}
	return $list;
}

function GeneratePattern($pattern,$subnumber,$addnumber){ // generate array of regex looking for $pattern with $subnumber missing char 
	//and $ addnumber extra char
	$voidlist=array();
	$outputlist=array();
	$sublist=delPattern($pattern,$subnumber,$voidlist,0);
	foreach($sublist as $pattern){
		$outputlist=array_merge($outputlist,adPattern($pattern,$addnumber,$voidlist,0));
	}
	return $outputlist;
}

function BindPatterns($Patternlist){ //turn an array of patterns into a single one (OR operator)
	$middlePart="";
	foreach($Patternlist as $pattern){
		$middlePart.=substr($pattern,1,strlen($pattern)-2)."|";
	}
	$middlePart=substr($middlePart, 0,-1);
	return ('#'.$middlePart.'#i');
	
}
function FindBestPattern($word,$pattern,$initial_word){ //gradually increase the level of mistakes to find least degradated pattern matching an initial word
	for($recsub=0;$recsub<=2;$recsub++){
		for($recadd=0;$recadd<=2;$recadd++){
			if(preg_match(BindPatterns(GeneratePattern($pattern,$recsub,$recadd)),$word,$matches, PREG_OFFSET_CAPTURE)){	
				return array("found"=>true,"sub"=>$recsub,"add"=>$recadd,"length"=>strlen($matches[0][0]),"pos_end"=>$matches[0][1]+strlen($matches[0][0])-1,"pos_start"=>$matches[0][1],"word"=>$matches[0][0],"initial word"=>$initial_word);
				//returns an array providing the integrality of relevant informations about matching process, usefull to rate further	
			}
		}
	}
	return array("found"=>false,"initial word"=>$initial_word);
}
function findWords($text,$words){//find words in a text (with spelling mistakes) and output detailed informations about the mistakes 
	$output=array();
	foreach ($words as $word){
		$pattern="#". preg_quote($word)."#";
		$Wordoutput=FindBestPattern($text,$pattern,$word);
		$output[$word]=$Wordoutput;
	}	
	return $output;
}

function getCompat($tabwords){//find overlapping words (choc may overlap with chocalate) rate how strong this overlatpping is 
	$output=array();
	foreach($tabwords as $i=>$tword1){
		if ($tword1["found"]){
			foreach($tabwords as $j=>$tword2){
				if (($tword2!=-1)&&($j>$i)){
					$end1=$tword1["pos_end"];
					$end2=$tword2["pos_end"];
					$start1=$tword1["pos_start"];
					$start2=$tword2["pos_start"];
					if(($start2<=$end1)&&($end2>=$start1)){//necessary and sufficient condition for overlapping
						$Positions=array($end1,$end2,$start1,$start2);
						sort($Positions);//as we don't exactly know the overlapping pattern, the best way to measure overlapping 
						//is to sort positions, and compute the distance between the second and the third one 
						$overlap=$Positions[2]-$Positions[1]+1;
						$punishment=$overlap/min($tword1["length"],$tword2["length"]);//the punishment value is the % of overlapping char for the shortest word
						//var_dump($tword1["word"],$tword2["word"],$Positions,min($tword1["length"],$tword2["length"]),$overlap,$punishment);
						$output[$tword1["word"]][$tword2["word"]]=$punishment;
					}
				}
			}
		}
	}
	return $output;
}

function getNote($text,$wordsArray,$verbosity){ //quantify the reliability of $wordsArray being in $text
//	var_dump($text,$wordsArray);
	$tabWords=findWords($text, $wordsArray);
//	var_dump($tabWords);
	$compatTable=getCompat($tabWords);
	$note=0;
	$message="<ul>";
	foreach($tabWords as $word){
		$message.="<li>\"";
		$message.=$word["initial word"];
		$message.=" \"";
		if(!$word["found"]){
			$message.=" non trouv&eacute, cout : <strong>-4</strong> <br><br>";
			$note-=4;
		}
		else{
			$note+=8;
			$aug=3*($word["add"]+2*$word["sub"])/(strlen($word["initial word"]));
			$note-=$aug;
			$message.=" trouv&eacute, apport : <strong>+8</strong> <br>";
			$message.=" fautes d'orthographes : <ul>";
			$message.="<li>".$word["add"]." caract&egraveres ajout&eacutes</li>";
			$message.="<li>".$word["sub"]." caract&egraveres supprim&eacutes</li></ul>";
			$message.="cout des fautes d'orthographes = - 3*(2*(nbCarSupr)+nbCarAjout&eacutes)/longueur du mot = ";
			$message.="<strong>-".$aug."</strong><br><br>";
		}
	}
	
	foreach($compatTable as $line){
		foreach($line as $cell){
			$aug=$cell*4;
			echo("punishement=$aug<br>");
			$note+=$aug;
		}
	}	
	$message.="<strong>note finale : $note</strong></li></ul></ul><br>";
	if($verbosity){echo($message);}
	return($note);
	
	//var_dump($tabWords);
	//var_dump($compatTable);
}
function PickBest($text,$wordsArrays,$verbosity){
	if($verbosity){echo("<u>R&eacuteponse analys&eacutee : </u><br><i>$text</i></br>");}
	$min=-INF;
	$output=array();
	$notes=array();
	foreach($wordsArrays as $wordsArray){
		if($verbosity){$keys=implode(' ; ',$wordsArray);echo("<u>Mots clefs propos&eacutes : </u><br><i>$keys</i></br>");}
		echo("<u>Analyse</u>");
		$note=getNote($text,$wordsArray,$verbosity);
		if($note>$min){$min=$note;$output=$wordsArray; }
	}
	return array($min,$output);
}

function createArray ($string){
	if($string==""){return array();}
	$string2 = preg_replace('!\s!','', $string);
	$tab=explode(";",$string2);
	return($tab);
}
//$finalPattern=BindPatterns(GeneratePattern("#pattern#",2,2));
//$note=getNote("marie a maenge trop de chocolat à la men", array("marie","chocolat","menthe","abeille"),true);
//PickBest("marie a maenge trop de chocolat à la men", array(array("marie","chocolat","menthe","abeille"),array("marie","chocolat","menthe")),true);

//FindBestPattern("marie a maeng&eacute trop de chokola","#marie#");

?>
