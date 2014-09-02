
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>énoncé</title>
<link rel="stylesheet" type="text/css" href="view.css" media="all">
<script type="text/javascript" src="view.js"></script>
<script type="text/javascript" src="userscript.js"></script>
</head>
<body id="main_body" >
	<img id="top" src="static/images/top.png" alt="">
	<div id="form_container">
	<h1><a>Untitled Form</a></h1>
	<form name="form1" id="form1" class="appnitro" method="post" action="SpecificProblemSaving.php">
			<h2>Enregistrez votre &eacutenonc&eacute </h2>
						<h3>Zone d'écriture</h3>
			<ul>
				<li id="li_1" >

				<div><textarea id="textarea" name="text" class="element textarea medium"  ><?php if (isset($textBrut)){echo($textBrut);}?></textarea>
				</div><p class="guidelines" id="guide_1"><small>Cette zone de texte vous permet de rentrer votre énoncé. Il sera presenté tel quel à l'élève.
				</small></p>
			<input type="hidden" name="id" value="">
			<input type="hidden" name="replacements" value="">
			<input type="submit" value="valider">
	
</body>

</html>
