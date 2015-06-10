<?php
	header('Content-type: text/html; charset=utf-8');
	session_start();
	//faut vérif si la session est ouverte / Include
	$name=$_POST["element_999"];
	$values=$_POST["element_998"];
	$values=str_replace( ' ', '', $values);//suppression des espaces
	$name=str_replace( ' ', '', $name);
	$operation=$_POST["operation"];
	require_once ("conn_pdo.php");

	if ($operation=="update"){
		$id=$_POST["identifiant"];
		//$bdd->query("UPDATE lists SET name='$name' , `values`='$values' WHERE id='$id'");
		$req = $bdd->prepare("UPDATE lists SET name=? , `values`=? WHERE id=?");
		$req->execute(array($name, $values, $id));
		$req->closeCursor();
	}
	if ($operation=="insert"){
		//$sql="INSERT INTO lists (id,type,name,`values`) VALUES ('','insertions','$name' ,'$values' );";
		//mysql_query($sql) or die("error");

		$req = $bdd->prepare("INSERT INTO lists (type,name,`values`) VALUES (?, ?, ?)");
		$req->execute(array('insertions', $name, $values));
		$req->closeCursor();
	}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Choix des pbms</title>
<link rel="stylesheet" type="text/css" href="static/css/view.css" media="all">
</head>

<body id="main_body" >
<img id="top" src="static/images/top.png" alt="">
	<div id="form_container">
	<h1><a>Untitled Form</a></h1>
		<p>Vos modifications ont bien été enregistrées</p>
		<form id="form_470585" class="appnitro"  method="post" action="Insertions_Perso.php">
		<input type="hidden"  name="infos" value="<?php if (isset($_POST["infos"])){echo($_POST["infos"]);}?>"/>
			<input type="submit" value="retour">
		</form>
	</div>