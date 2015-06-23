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
		<?php include("headerEnseignant.php"); ?>
			<div id="form_container">
			<h1><a>Untitled Form</a></h1>
				<div style="width:400px;display:inline-block">

						
						<div class="form_description"></div>
						<div class="form_description">
						<h3>Interface Enseignant</h3>
						</div>			



					<!-- Mon code...-->
					<h3>Gérer votre classe</h3>
					

						
					<form id="form_470585" class="appnitro"  method="post" action="">

			
						<ul>
							<li id="li_1">
								<h3>Problèmes</h3>
								<a href="ProblemCreationInterface.php">Créer un nouveau problème</a><br>
								<div style="display:none">
									<a href="formsaisie.html">Additifs complexes</a><br>
									<a href="formDist.html">Distributivité</a><br>
									<a href="formEtape.html">Une Etape</a><br>
								</div>
							</li>
							<li id="li_2" >
							
								<h3>Séries d'exercices</h3>
								<ul>
								<li><a href="gerer_series.php">Gérer les séries d'exercices</a></li>
								<li><a href="creer_serie.php">Créer une série d'exercices</a></li>
								</ul>
							</li>
						</ul>
						<div style="display:none">	
							Fournir une lecture d'énoncé (documents audio)
							<a href="audio_comparaison.php">Comparaison</a>&nbsp;|&nbsp; 
							<a href="audio_complement.php">Complément</a>&nbsp;|&nbsp;
							<a href="audio_distributivite.php">Distributivité</a> | 
							<a href="audio_etape.php">Etape</a>
						</div>
						<ul>
							<li id="li_3">
							<h3>Résultats et analyses</h3>	
							<h5> Analyse brute</h5>
							<li>Télécharger le fichier de diagnostic au format tableur de <a href="doc_csv.php">tous les élèves</a> </li>
							<li><a href="formTracePDF.php">Télécharger le fichier de trace d'un élève en PDF</a></li>
							<li>
							<h5>Sortie en langage naturel</h5>
						    <li><a href="formDiag.php?type=e">Problèmes additifs complexes</a></li>
						      <li> <a href="formDiag.php?type=d">Problèmes de distributivité</a> </li>
				          	<li> <a href="formDiag.php?type=etape">Problèmes &agrave; une  étape</a></li>
						</ul>
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
