<?php

// Fonctions pour les listes

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



//BDD Functions

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


?>
