<?php

//--------------------------------------------------------------------------------------------------------------------
//								  					Gestion des listes
//--------------------------------------------------------------------------------------------------------------------

function loadList($type, $b){
	$t=array();

	$req = $b->prepare("SELECT * FROM properties where type=?");
	$res = $req->execute(array($type));
	$t = array();
	while ($tab = $req->fetch()) {
		array_push($t, $tab["name"]);
	}
	$req->closeCursor();
	return $t;
}


function updateList($type, $new, $b){
	foreach($new as $new_property){
		if(!(exists_in_BDD('properties', 'name = ?', array($new_property), $b))){
			$req = $b->prepare('INSERT INTO properties(name, tri_prof, type, idCreator) VALUES(?, ?, ?, ?)');
			$req->execute(array($new_property, 'FALSE', 'problem', $_SESSION['id']));
			$req->closeCursor();
		}
	}		
}



//--------------------------------------------------------------------------------------------------------------------
//									  	Fonctions de gestion de la base de données
//--------------------------------------------------------------------------------------------------------------------

function count_BDD($SQL_req, $array_req, $b){
	$r = $b->prepare($SQL_req);
	if($r->execute($array_req)){
		$tmp_variable = $r->fetch();
		$count = $tmp_variable[0];
		$r->closeCursor();
		return($count);
	}
	else{
		die();
	}
}

function exists_in_BDD($table, $where, $array_req, $b){
	/*
	Returns a boolean. True if the WHERE conditions are met in $table, false otherwise
	- $table : name of the table in which to look
	- $where : the different conditions to look for, with "?" for a prepare request
	- $array_req : the array that will be required for the "execute"
	- $b : the database link
	*/

	$SQL_req = 'SELECT count(1) FROM '.$table.' WHERE '.$where;
	$r = $b->prepare($SQL_req);
	if($r->execute($array_req)){
		$isInBase = $r->fetchColumn();
	}
	else{
		die();
	}
	$r->closeCursor();
	return($isInBase);
}

function get_value_BDD($key, $table, $where, $array_req, $b){
	/*
	Returns the value of the column $key from $table 
	
	- $key : the column in the database
	- $table : name of the table in which to look
	- $where : the different conditions to look for, with "?" for a prepare request
	- $array_req : the array that will be required for the "execute"
	- $b : the database link
	*/

	$SQL_req = 'SELECT '.$key.' FROM '.$table.' WHERE '.$where;
	$r = $b->prepare($SQL_req);
	if($r->execute($array_req)){
		return($r->fetchColumn());
	}
	else{
		return(NULL);
	}
}

function update_value_BDD($table, $set, $where, $array_req, $b){
	$SQL_req = 'UPDATE '.$table.' SET '.$set.' WHERE '.$where;
	$r = $b->prepare($SQL_req);
	if($r->execute($array_req)){
		return true;
	}
	else{
		return false;
	}
}


// Fonctions d'affichages. 
	
	/*
	function test_flags($flags) {
	  if ($flags & FLAG_A) echo "A";
	  if ($flags & FLAG_B) echo "B";
	  if ($flags & FLAG_C) echo "C";
	}
	test_flags(FLAG_B | FLAG_C); */


// Flags pour les droits sur les séries
define("SERIE_RIGHTS_SUPPR", 0x1);
define("SERIE_RIGHTS_PROMOTE", 0x2);


define("FLAG_PBMS_CHECKBOX", 0x1);
define("FLAG_PBMS_SUPPR", 0x2);
// Flags sur les features de display problems

function displayProblem($enregistrement, $flags = 0){
/*
	Utilisée par :
		- creer_serie.php (avec les checkboxes)
		- gerer_series.php. (sans les checkboxes)
		- gerer_exercices.php
*/

	$limText=300;
	$enonce = $enregistrement['enonce'];
	$id= $enregistrement['idPbm'];
	$visible = $enregistrement['visible'];

	if($visible){
		if (strlen($enonce) > $limText) 
		{
			$enonce=substr($enonce, 0, $limText).'[...]';
		}

		echo "<li>";
			echo "<div class=\"problem_s\">";
				echo "<span class=\"problem_select\">";
				if ($flags & FLAG_PBMS_CHECKBOX){
					echo "<input type=\"checkbox\" class=\"check_pbms\" name=\"check_pb[]\" value=\"".$id."\"></input>";
				}
				echo "</span>";
				echo "<span class=\"problem_text\">";
					echo $enonce;
				echo"</span>";
				if($flags & FLAG_PBMS_SUPPR){
					echo "<span class=\"pbm_delete\">";
					echo "<a id=\"pbm_delete".$id."\" href=\"\" onclick=\"confirmSupprPbm(".$id.");return false;\"><img src=\"static/images/delete.png\" alt=\"supprimer cet exercice\"/></a>";
					echo "</span>";
				}

			echo"</div>";
		echo"</li>";
	}
}

function creerSessionPassation($idEleve, $serie, $b, $type_passation){ 
/*
	Cette fonction créé les variables SESSION relatives à la passation d'une série d'exercices
	
	Utilisé par :
		- interface.php 

	Variables input :
		- $idEleve
		- $serie : id de la série d'exercices
	 	- $b : la connexion à la base de données
		- $type_passation : indique comment l'élève s'est connecté à sa sesssion, 
			soit en entrant un code ($type_passation = "CODE"), soit en entrant ses, nom et prénom ($type_passation = "NOM")
*/

	$_SESSION['passation'] = array();
	$_SESSION['passation']['numSerie'] = $serie;

	if(get_value_BDD('statut', 'serie_eleve', '(idEleve = ? AND idSerie = ?)', array($idEleve, $serie), $b) == "untouched"){
		update_value_BDD('serie_eleve', 'statut = "opened"', 'idEleve = ? AND idSerie = ?', array($idEleve, $serie), $b);
	}

	$_SESSION['passation']['nbExo'] = 1; //VERIF

	$req = $b->prepare('SELECT pbm FROM pbm_serie WHERE serie =? ORDER BY ordre');
	if($req->execute(array($serie))) {
		$problems = array();
		$fetch_problems = $req->fetchAll(); // $problems contient maintenant les id des problèmes de la série
		foreach($fetch_problems as $pb){
			array_push($problems, $pb['pbm']);
		}
		$_SESSION['passation']['allProblems'] = $problems;
	}
	else{
		//TODO gestion erreur requête foire
	}
	$req->closeCursor();			
	$_SESSION['passation']['totalExo'] = count($_SESSION['passation']['allProblems']);
}





//--------------------------------------------------------------------------------------------------------------------
//								  Gestion des classes "Contrainte" et "Opérateur"
//--------------------------------------------------------------------------------------------------------------------


function findComparisonOperator($string){
	$operators_2char = array("<=", ">=");
	foreach($operators_2char as $op){
		if (strpos($string, $op) !== false){
			return $op;
		}
	}
	$operators = array("=", "<", ">");
	foreach($operators as $op){
		if (strpos($string, $op) !== false){
			return $op;
		}
	}
	return null;
}

class Constraint{
	var $l;  //left expression
	var $r;  //right expression
	var $op; // comparison operator
	
	function Constraint($left_expression, $right_expression, $operator){
		$this->l = $left_expression;
		$this->r = $right_expression;
		$this->op = $operator;
	}

	function isSatisfied($args){
		// Args doit être un array de type array("Nombre1" => "3", "Nombre2" => "12", ...); 

		switch($this->op){
			case "=":
				return (int)($this->l->evaluate($args) == $this->r->evaluate($args));
				break;
			case "<":
				return (int)($this->l->evaluate($args) < $this->r->evaluate($args));
				break;
			case ">":
				return (int)($this->l->evaluate($args) > $this->r->evaluate($args));
				break;
			case ">=":
				return (int)($this->l->evaluate($args) >= $this->r->evaluate($args));
				break;
			case "<=":
				return (int)($this->l->evaluate($args) <= $this->r->evaluate($args));
				break;
			default:
				return null;
		}
	}

	function tprint(){
		echo $this->l->eprint()." ".$this->op." ".$this->r->eprint();
	}
}


class Expression{
	var $type;
	var $contenu;

	function Expression($t, $c){
		if($t == "variable" || $t == "value"){
			$this->type = $t;
			if(is_numeric($c)){
				$this->contenu = $c;
			}
			else{
				$this->contenu = null;
			}
		}
		elseif($t == "addition"){
			$this->type = $t;
			$this->contenu = $c;
		}
		else{
			$this->type = null; //suremnet pas ce que je veux
		}
	}

	function evaluate($args = null){
		// return an int, args sent fill the variables.
		if($this->type == "value"){
			return $this->contenu;
		}
		elseif($this->type == "variable"){
			$index = "Nombre".(string) $this->contenu;
			return $args[$index]; //TODO : try catch here

		}
		elseif($this->type == "addition"){
			$sum = 0;

			for($i=0; $i<count($this->contenu["types"]); $i++){
				if ($this->contenu["types"][$i] == "add_value"){
					$sum = $sum + $this->contenu["contenus"][$i];
				}
				elseif ($this->contenu["types"][$i] == "add_variable"){
					$index = "Nombre".$this->contenu["contenus"][$i];
					$sum = $sum + $args[$index];
				}
				else{
					return null;
				}
			}
			return $sum;
		}
	}

	function eprint(){ // affiche l'expression.
		if($this->type == "variable"){
			return "Nombre".$this->contenu;
		}
		elseif($this->type == "value"){
			return (string)$this->contenu;	
		}
		elseif($this->type == "addition"){
			$concat = "";
			$first_iteration = true;
			for($i = 0; $i<count($this->contenu["types"]); $i++){
				if($first_iteration){
					$first_iteration = false;
				}
				else{
					$concat = $concat."+";
				}
				if ($this->contenu["types"][$i] == "add_value"){
					$concat = $concat.(string)$this->contenu["contenus"][$i];
				}
				elseif ($this->contenu["types"][$i] == "add_variable"){
					$concat = $concat."Nombre".$this->contenu["contenus"][$i] ;
				}
				else{
					return null;
				}
			}
			return $concat;
		}
	}
}

function evalExpression($string){
	// Créer une instance de la classe Expression à partir d'une chaine de caractères
	
	// Tout d'abord, on refuse l'expression si elle contient un caractère interdit

	$forbiddenChars = array("/", "-", "*", "=", "<", ">", ">=", "<=");
	foreach($forbiddenChars as $ch){
		if (strpos($string, $ch) !== false){
			return null;
		}
	} 

	/* L'expression peut être soit : 
		- une variable => type "variable"
		- un nombre => type "value"
		- une expression avec un ou plusieurs "+" => type "addition" */

	if(strpos($string, "+") !== false){ // Addition
		// Dans ce cas, je veux que expression renvoie : type = "addition", contenu = array(types, contenus)
		$regex_variable =  '#^n(ombre)?[1-9]$#i';
		$tmp = explode("+", $string);
		$typeTab = [];
		$contentTab = [];
		foreach($tmp as $elem){
			if(!($elem)) {
				return null;
			}
			elseif(is_numeric($elem)){
				$curType = "add_value";
				$curContent = (int)$elem;
			}
			else{
				if(preg_match($regex_variable, $elem)){
					$curType = "add_variable";
					$curContent = (int)mb_substr($elem, -1); //On récupère le chiffre, qui est le dernier caractère
				}
				else{
					return null;
				}
			}
			$typeTab[] = $curType;
			$contentTab[] = $curContent;
		}
		$totalContent = array("types" => $typeTab, "contenus" => $contentTab);
		$expr = new Expression('addition', $totalContent);	
	}
	elseif(is_numeric($string)){ //Nombre
		$expr = new Expression('value', (int)$string);	
	}
	else{ //Variable au format "NombreX"
		$regex_variable =  '#^n(ombre)?[1-9]$#i'; // Pour l'instant, on accepte uniquement Nombre1, nombre1, NOMBRE1, n1, N1...
		if(preg_match($regex_variable, $string)){
			$var_number = mb_substr($string, -1); //On récupère le chiffre, qui est le dernier caractère
			$expr = new Expression('variable', (int)$var_number);
		}
		else{
			return null;
		}
	}
	return $expr;
}

function parseNumericConstraints($string){
	// Renvoie un tableau de contraintes à partir d'une chaine de caractères
	$constraints = array();

	// Format d'une contrainte :  EXPRESSION1 COMPARISON_OPERATOR EXPRESSION2
	// EXPRESSION : VAR, ou VAR+VAR
	// VAR : (VALUE) OU (NombreX where X = VALUE, with VALUE <= $compteur_nombre)
	// VALUE doit être un int
	// COMPARISON_OPERATOR : <, >, =, >=, <=

	foreach(explode(";",$string) as $constraint){
		$constraint = str_replace(" ", "", $constraint); // On supprime tous les espaces de la string
		$constraint = trim($constraint);
		if ($constraint != ""){
			$comparison_operator = findComparisonOperator($constraint);
			if($comparison_operator){
				$tmp = explode($comparison_operator, $constraint);
				if(count($tmp)==2){
					if(!($left = evalExpression($tmp[0]))) {
						return null;
					}
					if(!($right = evalExpression($tmp[1]))) {
						return null;
					}
				}
				else{ // L'opérateur de comparaison est présent deux fois
					return null;
				}
			}
			else{ // Pas d'opérateur de comparaison
				return null;
			}
			$constraints[] = new Constraint($left, $right, $comparison_operator);
		}
	}
	return $constraints;
}


function checkNumericConstraints($numConstraints, $numbers){
	//On vérifie que les contraintes numériques sont bien écrites et qu'elles sont 
	// satisfaites avec les valeurs par défaut du problème avant de valider
	if($numConstraints == ""){ //Pas de contrainte
		return 'OK';
	}
	if(!($c = parseNumericConstraints($numConstraints))){
		return 'parseError';
	}
	else{
		foreach($c as $constraint){
			if(!($constraint->isSatisfied($numbers))){
				return 'satisfactionError';
			}
		}
	}
	return 'OK';

}



//--------------------------------------------------------------------------------------------------------------------
//								  Fonctions utilisées par ProblemTextCreation.php
//--------------------------------------------------------------------------------------------------------------------



function js_str($s) //functions to turn php array into js array
	{
		return '"' . addcslashes($s, "\0..\37\"\\") . '"';
	}

	function js_array($array)
	{
		$temp = array_map('js_str', $array);
		return '[' . implode(',', $temp) . ']';
	}
	function cloner($informations_clones,$copieEnonce){
		$defaultValue=true;
		$liste_clones_parcourus=array();
		foreach ($informations_clones as $i => $infoClone){//on effectue un double parcours pour identifier les répétitions
			$listeRepetition=array();
			$listeRepetition[]=$infoClone;
			$type=$infoClone[1][0];
			//echo($i." pour ".$type."<br>");
			if(!in_array($type,$liste_clones_parcourus)){//on verifie que le clône n'est pas déjà traité
				$liste_clones_parcourus[] = $type;
				//on construit un tableau qui va contenir les répétitions
				for ($j = $i+1; $j <= count($informations_clones)-1; $j++) {//on effectue un double parcours pour identifier les doubles
					$infoClone2=$informations_clones[$j];
					$typeClone2=$infoClone2[1][0];
					if($typeClone2==$type){
						if($infoClone[2][0]==$infoClone2[2][0]){
							//echo("same number");
							$listeRepetition[]=$infoClone2;
						}
						else{
							$clone=findClone($type);

							//echo("replaceByClone[".$copieEnonce.",".$clone.",".$infoClone[0][0]."]<br>");
							$copieEnonce=replaceByClone($copieEnonce,$clone,$infoClone2);//si le clone n'a pas le même numéro on effectue le remplacement tout de suite
							
						}
					}
				}
				$clone=findClone($type);//on utilise le même clone pour les clones avec le même numero, cette liste contient au moins infoClone
				foreach ($listeRepetition as $i => $infoClone){
					//echo("replaceByClone[".$copieEnonce.",".$clone.",".$infoClone[0][0]."]<br>");
					$copieEnonce=replaceByClone($copieEnonce,$clone,$infoClone);
					
				}		
			}
		}
		//$r=htmlspecialchars($copieEnonce);
		//echo($r);
		return($copieEnonce);
	}
	function findClone($type){
		if($type=="Nombre"){
			return rand(1,20);
		}
		else{
			return "exemplaire".$type;
		}
	}

	function getInformations($content,$erreur){
		//echo($content);
		$pattern= '#(^[a-zA-Zéèàç_]*)\(([0-9]*)\)=(.*)#';//les parenthèses capturantes récupèrent l'essentiel de informations de l'élément
		$c=preg_match_all($pattern,$content, $Inf);
		if($c==0){
			echo("erreur : '".$content."' n'est pas reconnu");//permet de vérifier que l'interieur du clone est syntaxiquement correct
			$erreur=$content."' n'est pas reconnu";
			return null;
		}
		//echo($Inf[3][0]);
		return($Inf);
	}


	function replaceByClone($copieEnonce,$clone,$infoClone){
		//echo($clone." par ");

		$rep="<<".$infoClone[0][0].">>";
		//$r=htmlspecialchars($rep);
		//echo($r."<br>");
		
		
		//$r=htmlspecialchars($copieEnonce);
		$r=htmlspecialchars($copieEnonce);
		$htmlpart='<font color="grey">'.$infoClone[3][0].'</font><font color="blue"> ('.$infoClone[1][0].$infoClone[2][0].')</font>';//<span style="color:green;">';('.$infoClone[3][0]
		$copieEnonce=str_replace($rep,$htmlpart,$copieEnonce);
		//echo($r);
		return($copieEnonce);
		//echo($copieEnonce);
	}

	function soulignerQuestions($informations_questions,$copieEnonce){
		//print_r($informations_questions);
		//$rep="[[".$informations_questions[0][0]."]]";
		$element1="[[".str_replace($informations_questions[3][0],'',$informations_questions[0][0]);
		//echo($element1);//à remplacer par <br><u><i>
		$replacement_1="<br><u><i>";
		$element2="]]";//à remplacer par </i></u>
		$replacement_2="</i></u>";
		//$r=htmlspecialchars($copieEnonce);
		//$htmlpart='<br><u><i>'.$informations_questions[3][0].'</i></u>';//font><font color="blue"> ('.$infoClone[1][0].$infoClone[2][0].')</font>';//<span style="color:green;">';('.$infoClone[3][0]
		$copieEnonce=str_replace($element1,$replacement_1,$copieEnonce);
		$copieEnonce=str_replace($element2,$replacement_2,$copieEnonce);
		//echo($r);
		return($copieEnonce);	
	}
	                         
	function SyntaxicVerification($tStart,$tEnd,$start,$end,$tIntrus,$intrus){
		$erreur=false;
		if((count($tStart))!=(count($tEnd))){
			$mess="erreur : pas autant de caractere ' ".$start." ' que de caractère ' ".$end." '";
			$erreur=true;
			$mess=htmlspecialchars($mess);
			echo($mess."<br>");
			return false;
			//print($mess);
			}
			else{
				foreach ($tStart as $c => $positionStart){
					$positionEnd=$tEnd[$c];//permet de connaitre la position du prochain caractère fermant correspondant
					foreach ($tIntrus as $i => $positionIntru){
						if(($positionIntru>$positionStart)&&($positionIntru<$positionEnd)){
							$postru=strval($positionIntru);
							$mess="Erreur : ' ".$intrus." ' entre ' ".$start." ' et ' ".$end." ' à la position ".$postru;
							$erreur=true;
							$mess=htmlspecialchars($mess);
							echo($mess."<br>");
						}
					}

				}
			}
		return $erreur;
	}

	function search_expression($separateur,$expression){
		$SepPositions=array();
		$k=0;
		$tab= str_split($expression);
		foreach ($tab as $key => $c){
			if($c==$separateur){
				if((!empty($tab[$key+1]))&&($tab[$key+1]==$separateur)){
					//$message=$separateur.'  @  '.$key;
					//echo($message);
					//echo('<br>');
					$SepPositions[$k]=$key;
					$k++;
				}
			}
		}
		return $SepPositions;
	}




//--------------------------------------------------------------------------------------------------------------------
//								  Fonctions qui utilisent javascript en PHP...
//--------------------------------------------------------------------------------------------------------------------

function alertPHP($message){
	echo "<script type=\"text/javascript\">
		window.onload=function(){
		alert(\"".$message."\");
		}
		</script>";
}






?>
