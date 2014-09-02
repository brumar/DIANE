<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Choix des pbms</title>
<link rel="stylesheet" type="text/css" href="view.css" media="all">
</head>

<body id="main_body" >
<img id="top" src="static/images/top.png" alt="">
	<div id="form_container">
	<h1><a>Untitled Form</a></h1>
<?php

$name=$_POST["element_999"];
$values=$_POST["element_998"];
$values=str_replace( ' ', '', $values);//suppression des espaces
$name=str_replace( ' ', '', $name);
$operation=$_POST["operation"];
require_once ("conn.php");

if ($operation=="update"){
	$id=$_POST["identifiant"];
	$sql="UPDATE lists SET name='$name' , `values`='$values' WHERE id='$id' ;";
	mysql_query($sql) or die("error");
	
}
if ($operation=="insert"){
	$sql="INSERT INTO lists (id,type,name,`values`) VALUES ('','insertions','$name' ,'$values' );";
	mysql_query($sql) or die("error");
}
?>
		
		<p>Vos modifications ont bien été enregistrées</p>
		<form id="form_470585" class="appnitro"  method="post" action="Insertions_Perso.php">
		<input type="hidden"  name="infos" value="<?php if (isset($_POST["infos"])){echo($_POST["infos"]);}?>"/>
			<input type="submit" value="retour">
		</form>
	</div>