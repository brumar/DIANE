<?php
function KeywordDetection($liste_MOTS,$text) {
	$count=0;
	$detections=array();
	foreach ($liste_MOTS as $index => $pattern){
		$count=$count+1;
		$detections[$count]=preg_match('#'.$pattern.'#',$text);
	}
	return $detections;
}

function GetallTheNumbers($text) {
	$pattern = "#" // [0] capture the whole operation
					."\d+" //digits (1 or more).......................5
				."#"; // capture the whole operation
	preg_match_all($pattern,$text,$tab);
	return $tab[0];
	
}

function isRegularOperation($tab){
	return(count(GetallTheNumbers($tab["leftPart"]))==2)&&((count(GetallTheNumbers($tab["result"]))==1));
}

function intvalFromArray($ar){
	$output=array();
	for ($i = 0; $i < count($ar); $i++) {
		$output[$i]=intval($ar[$i]);
	}
	return $output;
}

function completeInformations($formula){
//"whole","leftPart","operand","result"
$output=array();
$output["numbers"]=intvalFromArray(GetallTheNumbers($formula["whole"]));
$output["leftOperands"]=intvalFromArray(GetallTheNumbers($formula["leftPart"]));
$output["resultNumber"]=intval($formula["result"]);
$output["operation"]=$formula["operation"];
$output["validity"]=getOperationValidity($output["numbers"],$output["operation"]);
var_dump($output);


}

function getOperationValidity($operands,$operation){
	if (($operation=="+")||($operation=="-")){
		$min1=min($operands);
		unset($operands[array_search($min1,$operands)]);
		$min2=min($operands);
		unset($operands[array_search($min2,$operands)]);
		$remainingValues=array_values($operands);
		$max=$remainingValues[0];
		$error=abs($min1+$min2-$max);
		switch($error){
			case 0: 
        	return "perfect";
			case  1:
        	return "1 missing";
			default:
			return "error";
	}
	}
	elseif  (($operation=="x")||($operation=="/")||(($operation==":"))){
		$min1=min($operands);
		unset($operands[array_search($min1,$operands)]);
		$min2=min($operands);
		unset($operands[array_search($min2,$operands)]);
		$remainingValues=array_values($operands);
		$max=$remainingValues[0];
		$error=abs($min1*$min2-$max);
		switch($error){
			case 0: 
        	return "perfect";
			default:
			return "error";
	}
	}
}


function GetOperations($text) {
	var_dump($text);
	$pattern = "#" // [0] capture the whole operation
					."("// [1] capture the first part of the operation........... 5 + x + y + .... lastDigit
						."(?:" // non-capturing bracket
							."\d+" //digits (1 or more).......................5
							."\s*"//blank space (none or multiple)
							."([\:\+\-\*\/x])"//operation.......................5 +
							."\s*"//blank space (none or multiple)
						.")+"	//to capture multiple occurence of the last sequence ........ 5 + x + y +
						."\d+"//last digit..........................................5 + x + y + .... lastDigit
						."\s*"//last blank space
					.")"// THE capturing bracket
						."=?"// presence (or not) of the equal operation 5 + x + y = 
						."\s*"//blank space (none or multiple)
						."(\d*)"// [2] the result, and capture the result ...............5 + x + y = result
				."#"; // capture the whole operation
	preg_match_all($pattern,$text,$tab);
	var_dump($tab);
	$numbers=GetallTheNumbers($text);
	$tab = array_combine(array("whole","leftPart","operation","result"), array_values($tab));	
	$c=count($tab["whole"]);
	$formulas=array();
	for ($i = 0; $i < $c; $i++) {
		$formulas[$i]=array_combine(array("whole","leftPart","operation","result"),array($tab["whole"][$i],$tab["leftPart"][$i],$tab["operation"][$i],$tab["result"][$i]));
	}
	var_dump($formulas);
	return $formulas;
}

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

function GeneratePattern($pattern,$subnumber,$addnumber){ // generate array of regex looking for $pattern with 
	//$subnumber missing char
	//and $ addnumber extra char
	$voidlist=array();
	$outputlist=array();
	$sublist=delPattern($pattern,$subnumber,$voidlist,0);
	foreach($sublist as $pattern){
		$outputlist=array_merge($outputlist,adPattern($pattern,$addnumber,$voidlist,0));
	}
	return $outputlist;
}

function BindPatterns($Patternlist){ //turn an array of patterns into a single one (OR operation)
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
$formulas=GetOperations("83+25=107  dadada 4*8=32");
foreach($formulas as $formula){
var_dump(isRegularOperation($formula));
if(isRegularOperation($formula)){
	$richformulas=completeInformations($formula);
}}
?>