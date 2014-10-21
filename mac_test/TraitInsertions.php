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
<?php

if(isset($_POST["element_999"])) {
$name=$_POST["element_999"];
$values=$_POST["element_998"];
}


if(isset($_POST["identifiant"])){
	
	$id=$_POST["identifiant"];
	 require_once("conn.php");
    
 	$sql1 = "SELECT * FROM lists WHERE type='insertions' and id=\"$id\"";
 

  $result = mysql_query($sql1); //or die ("RequÃªte incorrecte");
  $t=0;
  while ($enregistrement = mysql_fetch_assoc($result))
		{
			$t++;
		  $values =  $enregistrement["values"];
		  $name= $enregistrement["name"];
		  $id=$enregistrement["id"];
?>
	 <form action="TraitInsertionsSave.php" method="post" class="appnitro"><br>
	<h3>Modifier ce type</h3>
	<input type="hidden" id="identifiant" name="operation" value="update"/> 
	<input type="hidden"  name="infos" value="<?php if (isset($_POST["infos"])){echo($_POST["infos"]);}?>"/>
	<input type="hidden" id="identifiant" name="identifiant" value="<?php  echo($id);?>"/> 
		<li id="li_999" >
			<label class="description" for="element_999">Nom de votre liste</label>
			<div>
			<input id="element_999" name="element_999" class="element text large" type="text" maxlength="255" value="<?php  echo($name);?>"/> 
			</div><p class="guidelines" id="guide_999"><small>Exemples : animaux de la ferme </small></p> 
					
					
		</li>
		<li id="li_998" >
					<label class="description" for="element_998">elements de cette liste </label>
					<div>
						<textarea id="element_998" name="element_998" class="element textarea small"><?php  echo($values);?></textarea>
					</div><p class="guidelines" id="guide_998"><small>Exemples : vaches; lapins; poules </small></p> 
				</li>

</ul>	
<input type="submit" value="enregistrer ces modifications">
</form>
  <p>
   <?php 
  mysql_close(); // Ferme la connexion
 ?>
<?php }}
?>
</div>
  

<img id="bottom" src="static/images/bottom.png" alt="">
</body>
</html>