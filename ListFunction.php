<?php
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
?>
