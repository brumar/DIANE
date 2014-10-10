<?php
function loadList($type,$name){
	$t=array();
	require_once('conn.php');
	$sql1 = "SELECT * FROM lists where type='$type' and name='$name'";
	$res=(mysql_query($sql1));
	while (($res)&&($tab = mysql_fetch_assoc($res))){
		$t=explode("||",utf8_encode($tab['values']));
	}
	//mysql_close($BD_link);
	return $t;
}

function newList($type,$name,$values){
	require_once('conn.php');
	$sql1 =" INSERT INTO `lists` (`id`, `type`, `name`, `values`) VALUES (NULL, '$type', '$name', '$values');";
	echo($sql1);
	$bool=mysql_query($sql1);
	echo($bool);
	mysql_close($BD_link);
}

function updateList($type,$name,$new){
	require_once('conn.php');
	$old=loadList($type,$name);
	$delta=array_diff($new,$old);
	if(!(empty($delta))){
		$update=array_merge($old,$delta);
		$StringUpdate=implode("||",$update);
		//echo($StringUpdate);
		$sql1 = "UPDATE `lists` SET `values`='$StringUpdate' WHERE `type`='$type' and `name`='$name'";
	//	echo($sql1);
		mysql_query($sql1);
	}
	
	mysql_close($BD_link);
}
?>
