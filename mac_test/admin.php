<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Admin</title>
<link rel="stylesheet" type="text/css" href="view.css" media="all">
<script type="text/javascript" src="view.js"></script>
</head>
<body id="main_body">
	
	<img id="top" src="static/images/top.png" alt="">
	<div id="form_container">
	<h1><a>Untitled Form</a></h1>
		<div style="width:400px;display:inline-block">
				<a href="../index.html">Accueil</a> &nbsp;&nbsp;
				<a href="eleve.html">Elève</a><br><br>
				
				<div class="form_description"></div>
				<div class="form_description">
				<h3>Interface Professeur</h3>
				</div>				
					
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
						
							<li><a href="affEnonce-D2.php">Créer une série d'exercices</a></li>
							<li><a href="supSerie.php">Supprimer une série d'exercices</a></li>
							<li><a href="choixSerie.php">Choix des séries d'exercices</a></li>
							<li><a href="affichage_e.php"></a></li>
					
	
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
			   <li><a href="../formDiag.php?type=e">Problèmes additifs complexes</a></li>
			      <li> <a href="../formDiag.php?type=d">Problèmes de distributivité</a> </li>
		          <li> <a href="../formDiag.php?type=etape">Problèmes &agrave; une  étape</a></li>
		   
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
