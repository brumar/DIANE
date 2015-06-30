<?php

// Fonctions pour les listes

function loadList($type,$name){
	$t=array();
	require_once('conn_pdo.php');

	$req = $bdd->prepare("SELECT * FROM lists where type=? and name=?");
	$res = $req->execute(array($type, $name));
	while ($tab = $res->fetch()) {
		$t=explode("||",utf8_encode($tab['values']));
	}
	$req->closeCursor();
	return $t;
}

function newList($type,$name,$values){
	require_once('conn_pdo.php');
	$req = $bdd->prepare(" INSERT INTO `lists` (`type`, `name`, `values`) VALUES (?, ?, ?)");
	$res = $req->execute(array($type, $name, $values));
	$req->closeCursor();
}

function updateList($type,$name,$new){
	require_once('conn_pdo.php');
	$old=loadList($type,$name);
	$delta=array_diff($new,$old);
	if(!(empty($delta))){
		$update=array_merge($old,$delta);
		$StringUpdate=implode("||",$update);
		//echo($StringUpdate);
		$req = $bdd->prepare("UPDATE `lists` SET `values`=? WHERE `type`=? and `name`=?");
		$req->execute(array($StringUpdate, $type, $name));
		$req->closeCursor();
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

?>
