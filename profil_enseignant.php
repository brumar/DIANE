<?php
	require_once("verifSessionProf.php");
?>

<!DOCTYPE html>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Interface Enseignant</title>
		<link rel="stylesheet" type="text/css" href="static/css/view.css" media="all">
		<script type="text/javascript" src="static/js/view.js"></script>
	</head>
	<body id="main_body">
		<?php require_once("headerEnseignant.php"); ?>
			<div id="form_container">
			<h1><a>Untitled Form</a></h1>
				<div style="width:400px;display:inline-block">

						
					<div class="form_description"></div>
					<div class="form_description">
						<h3>Interface Enseignant</h3>
					</div>			
		
					<form id="form_470585" class="appnitro"  method="post" action="">

			
						<ul>
							<li>
								<h3>Vos classes</h3>
								<a href="gestion_classe.php">Accéder à la gestion de vos classes</a>				
							</li>
							<li id="li_1">
								<h3>Problèmes</h3>
								<li><a href="creation_exercice.php">Créer un nouvel exercice</a><br></li>
								<li><a href="gerer_exercices.php"><?php if($_SESSION['accountType'] == 'chercheur'){echo "Gérer";}else{echo "Visualiser";} ?> les exercices</a><br></li>

							</li>
							<li id="li_2" >
							
								<h3>Séries d'exercices</h3>
								<ul>
								<li><a href="creer_serie.php">Créer une série d'exercices</a></li>
								<li><a href="gerer_series.php"><?php if($_SESSION['accountType'] == 'chercheur'){echo "Gérer";}else{echo "Visualiser";} ?> les séries d'exercices</a></li>
								</ul>
							</li>
						</ul>
						<!-- <div style="display:none">	
							Fournir une lecture d'énoncé (documents audio)
							<a href="audio_comparaison.php">Comparaison</a>&nbsp;|&nbsp; 
							<a href="audio_complement.php">Complément</a>&nbsp;|&nbsp;
							<a href="audio_distributivite.php">Distributivité</a> | 
							<a href="audio_etape.php">Etape</a>
						</div> -->

						<?php if($_SESSION['accountType'] == 'chercheur'){?>
							<ul>
								<li id="li_3">
								<h3>Résultats et analyses</h3>	
									<ul>
										<li><a href="diagnostic.php">Diagnostiquer</a></li>
									</ul>
								</li>
							</ul>
						<?php }?>
						
				  </form>
			</div>
		<div  style="width:200px;display:inline-block;vertical-align:top">
		<br><br><br><br><br><br>
		<img src="static/images/pbm.png" width="50%"  height="50%">
		<br><br><br><br>
		<img src="static/images/series.png" width="50%"  height="50%">
		<br><br><br><br><br><br>
		<img src="static/images/diag.png" width="50%"  height="50%">

		</div>
		<img id="bottom" src="static/images/bottom.png" alt="">
	</body>
</html>
