<?php
	require_once("verifSessionProf.php");
	if(isset($_SESSION['infos'])){ //On supprime les éventuels reste d'une création d'exercice antérieure
		unset($_SESSION['infos']);
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Problem Creation Interface</title>
<link rel="stylesheet" type="text/css" href="static/css/view.css" media="all">
<script type="text/javascript" src="static/js/view.js"></script>

</head>
<body id="main_body" >
	<?php include("headerEnseignant.php"); ?>
	<img id="top" src="static/images/top.png" alt="">
	<div id="form_container">
	
		<h1><a>Untitled Form</a></h1>				
					<div class="form_description" style="display:inline-block">
			<form id="form_470585" class="appnitro" name="mainform" method="post" action="">
		<h3>Créer un problème le plus simplement possible</h3>
			<ul>		<li id="li_4" >
		<label class="description" for="element_4">Ecriture d'un énoncé</label>	
		<div>	<!-- <input id="property" type="button" name="prop" value="OK" onClick="parent.location='creation_template.php'"/> -->
		</div>
		<a  href="ecriture_enonce.php"><img src="static/images/pbm.png" heigth=40px width=52px style="cursor:hand;"></a>
		<p class="guidelines" id="guide"><small>Choisissez cette option pour construire rapidement un nouveau problème</small></p>
		</li>	</ul>	
		
		<h3>Créer un problème avec des propriétés avancées</h3>


		<?php
		if($_SESSION['accountType'] == 'chercheur'){
			echo '<li id="li_5" >';
			echo '<label class="description" for="element_5">Création d\'un nouveau template </label>';
			echo '	<div>	<!--<input id="property" type="button" name="prop" value="OK" onClick="parent.location=\'creation_template.php\'"/>-->';
			echo '</div>';
			echo '<a  href="creation_template.php"><img src="static/images/template.png" heigth=40px width=52px style="cursor:hand;"></a>';
			echo '<p class="guidelines" id="guide_5"><small>Choisissez cette option pour construire un type de problème à partir de 0</small></p>';
			echo '</li>';
			echo '<li id="li_6" >';
			echo '<label class="description" for="element_6">Partir d\'un template existant pour créer un nouvea template</label>';
			echo '<div>';
			echo '<!-- <input id="t" type="button" name="prop" value="OK" onClick="parent.location=\'affichage.php\'"/>  -->';
			echo '</div>';
			echo '<a  href="copier_template.php"><img src="static/images/template_modif.png" heigth=38px width=100px style="cursor:hand;"></a>';
			echo '<p class="guidelines" id="guide_6"><small>Choisissez cette option pour construire un type de problème à partir d\'un autre type de problème</small></p>';
			echo '</li>';
		}
		?>

		<li id="li_7" >
			<label class="description" for="element_7">Utiliser un template pour générer un problème </label>
			<div><!-- <input id="pt" type="button" name="prop" value="OK" onClick="parent.location='choix_template.php'"/>-->
			</div> 
			<a  href="choix_template.php"><img src="static/images/template_instanciate.png" heigth=80px width=50px style="cursor:hand;"></a>
			<p class="guidelines" id="guide_6"><small>Générer un problème à partir d'un modèle (ou template). Permet un diagnostic des réponses de l'élève. </small></p> 
		</li>		</ul>
		</form>	
	
	</div>
	</div>
	<img id="bottom" src="static/images/bottom.png" alt="">
	</body>
</html>