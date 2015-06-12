<?php
	header('Content-type: text/html; charset=utf-8');
	session_start();

	$tab_id = [];
	if(isset($_POST)){
		
		foreach($_POST['check_pb'] as $checked_id)
		{
			array_push($tab_id, $checked_id);
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" charset="utf-8">
		<title>Création d'une série</title>
		<link rel="stylesheet" type="text/css" href="static/css/view.css">
	</head>

	<body id="main_body" >
		<img id="top" src="static/images/top.png" alt="">
		<div id="form_container">
			<h1><a>Untitled Form</a></h1>
			<h2>Choix de l'ordre</h2>
			<p>Choisissez maintenant l'ordre dans lequel les exercices seront présentés à l'élève.</p>
			<form action="ordonner_serie.php" method="post" class="appnitro">
				<ul>
				
				</ul>		
				
			
			<input type="submit" value="Créer la série">
			</form>
	</div>


		<img id="bottom" src="static/images/bottom.png" alt="">
	</body>
</html>


