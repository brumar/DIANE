<?php
	require_once("verifSessionProf.php");
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Création de problème</title>
		<link rel="stylesheet" type="text/css" href="static/css/view.css" media="all">
		<script type="text/javascript" src="static/js/view.js"></script>
		<script type="text/javascript" src="static/js/userscript.js"></script>
	</head>
	

	<body id="main_body" >
		<?php include("headerEnseignant.php"); ?>
		<img id="top" src="static/images/top.png" alt="">
		<div id="form_container">
		<h1><a>Untitled Form</a></h1>
		<form name="form1" id="form1" class="appnitro" method="post" action="SpecificProblemSaving.php" onsubmit="return verifEnonce();">
				<h2>Enregistrez votre énoncé </h2>
				<h3>Zone d'écriture</h3>
				<ul>
					<li id="li_1" >

					<div><textarea id="enonce" name="enonce" class="element textarea medium"  ><?php if (isset($textBrut)){echo($textBrut);}?></textarea>
					</div><p class="guidelines" id="guide_1"><small>Cette zone de texte vous permet de rentrer votre énoncé. Il sera presenté tel quel à l'élève.
					</small></p>
				<input type="hidden" name="id" value="">
				<input type="hidden" name="replacements" value="">
				<input type="submit" value="valider">
				</ul>
		
		<script type="text/javascript">
			verifEnonce = function(){
				var f_enonce = document.getElementById("enonce");
				if(f_enonce.value == ""){
					alert("Il faut écrire un énoncé pour créer un problème.");
					return false;
				}
				return true;

			}
		</script>
	</body>

</html>
