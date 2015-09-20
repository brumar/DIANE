<?php
	require_once("verifSessionProf.php");
	require_once("conn_pdo.php");
	require_once("ListFunction.php");		



	if(!(isset($_SESSION['infos']))){
		$_SESSION['infos'] = array();
	}

	if(isset($_POST['element_5'])){
		$_SESSION['infos']['constraints'] = $_POST['element_5'];
	}
	if(isset($_POST['element_6'])){
		$_SESSION['infos']['public'] = $_POST['element_6'];
	}
	if(isset($_POST['element_7'])){
		$_SESSION['infos']['private'] = $_POST['element_7'];
	}


	$tempText='';
	if(isset($_SESSION['infos']['html'])){
		$text = $_SESSION['infos']['html'];
		$tempText=$_SESSION['infos']['html'];
	}
	else{
		$tempText="pas d'enoncé fourni pour le moment";
	}
	
	$target=base64_encode('<h3>enonce</h3><div style="width:360px;padding:10px;margin:10px;border:1px solid black;display:inline-block">'.$tempText.'</div>');
	

	if (isset($_POST['buttonPressed'])){//l'utilisateur a appuyé sur un bouton
			switch($_POST['buttonPressed']){
				case 'text':
					header("Location: enonce_template.php");
					exit();
					break;
				case 'property':
					$_SESSION['target']=$target;
					$_SESSION['sender']= basename($_SERVER['REQUEST_URI']);
					header("Location: properties.php");
					exit();
					break;
				case 'upload':
					header("Location: upload.php");
					exit();
					break;
				case 'validate':

					//print_r($_SESSION['pbm_text_creation_infoclones']); //TODO : Passage $_SESSION...
				 	$tabNombres = array();
				 	foreach($_SESSION['infos']['clones'] as $clone){
				 		//clone est un tableau de tableau, on veut "Nombre" dans $clone[1][0]. 
				 		// On a l'id du Nombre dans $clone[2][0] et on récup la valeur par défaut dans $clone[3][0]
				 		if($clone[1][0]=="Nombre"){
				 			$index = "Nombre".(string)$clone[2][0];
				 			$tabNombres[$index] = (int)$clone[3][0];
				 		}
				 	}
					

					switch(checkNumericConstraints($_SESSION['infos']['constraints'], $tabNombres)) {
						case 'OK':
							$_SESSION['feedback_constraints'] = "Les contraintes sont ok.";
							header("Location: TemplateSaving.php");
							//header("Location: creation_template.php");
							exit();
							break;
						case 'parseError':
							$_SESSION['feedback_constraints'] = "Vos contraintes numériques ne suivent pas le bon format.";
							header("Location: creation_template.php");
							exit();
							break;
						case 'satisfactionError':
							$_SESSION['feedback_constraints'] = "Vos contraintes numériques ne sont pas respectées par les nombres par défaut.";
							header("Location: creation_template.php");
							exit();
							break;
					}
					break;
				case 'edit':
					$_SESSION['infos']['currentQuestion'] = $_POST['questionChosed'];
					header("Location: creer_question.php");
					exit();
			}
		
		}
?>


<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Création de template</title>
		<link rel="stylesheet" type="text/css" href="static/css/view.css" media="all">
		<script type="text/javascript" src="static/js/view.js"></script>
		<script type="text/javascript">

			function submitquestion(number){
				questionChosed = document.getElementById("questionChosedId");
				questionChosed.value = number;
				buttonPressed = document.getElementById("buttonPressedId");
				buttonPressed.value = "edit";
				document.mainform.submit();
			}
			function submitmainform(action){
				buttonPressed = document.getElementById("buttonPressedId");
				buttonPressed.value = action;
				document.mainform.submit();
			}

			function escapeHtml(unsafe) {
				  return unsafe
				      .replace(/&/g, "&amp;")
				      .replace(/</g, "&lt;")
				      .replace(/>/g, "&gt;")
				      .replace(/"/g, "&quot;")
				      .replace(/'/g, "&#039;");
			}
		</script>
	</head>
	<body id="main_body" >
	<?php require_once("headerEnseignant.php"); ?>
	<?php 

	$constraints='';
	$public='';
	$private='';
	//$infos=array();
	if ((isset($_SESSION['infos']))&&(!(empty($_SESSION['infos'])))){
		
		
		if (isset($infos['html'])){$text=$infos['html'];}

		if (isset($_POST['properties'])){ // On revient de properties.php
			$TabProperties=$_POST['properties'];
			//$infos["temp"]["CurrentAnswer"]
			$_SESSION['infos']['properties']=$TabProperties;
			updateList('problem', $_POST['properties'],$bdd);//si la liste de propriétés contient des éléments nouveaux, alors on rajoute ces éléments
		}
		
		if (isset($_SESSION['infos']['constraints'])){
			$constraints=$_SESSION['infos']['constraints'];
		}
		if (isset($_SESSION['infos']['public'])){
			$public=$_SESSION['infos']['public'];
		}
		if (isset($_SESSION['infos']['private'])){
			$private=$_SESSION['infos']['private'];
		}
		//if (isset($infos['texteBrut'])){echo($infos['texteBrut']);}
	}


	?>	
	<img id="top" src="static/images/top.png" alt="">
	<div id="form_container">
	
		<h1><a>Untitled Form</a></h1>
	
		<form id="form_470585" class="appnitro" name="mainform" method="POST" action="creation_template.php">
				
					<div class="form_description">
					<h2>Creation d'énoncé</h2>
					<?php 
						if(isset($_SESSION['feedback_constraints'])){ 
							print($_SESSION['feedback_constraints']);
							unset($_SESSION['feedback_constraints']);
						}
						?>
					<h3>Prévisualisation</h3>
			<div style="width:360px;padding:10px;margin:10px;border:1px solid black;display:inline-block">
				<?php if (isset($text)){echo($text);}else{echo('<font color="grey"><small>aucun énoncé fourni, cliquez sur éditer pour entrer un énoncé</small></font>');}?>
			</div>
			
			<div style="width:150px;height:100px;padding:5px;margin:5px;display:inline-block;">
				<?php //if (isset($text)) echo("<img src=static/images/legend.png>");?>
			</div><br>

					<input type="hidden" name="buttonPressed" id="buttonPressedId">
					<input type="hidden" name="questionChosed" id="questionChosedId">
					<input type="button" value="Editer" id="editEnonce" onclick="submitmainform(&quot;text&quot;);"/>
			<!--  	<input type="hidden" name="TexteBrut" value="<?php // if (isset($infos['texteBrut'])){echo($infos['texteBrut']);}?>"/>	-->	
				
			
			<!--  <p>This is your form description. Click here to edit.</p>-->
		</div>	
			


			<!--  IL faudra gérer les propriétés des questions à un moment-->
			<ul>	
				<h3>Questions détectées</h3>
					<?php 

						$compteurQuestion=0;
						while (isset($_SESSION['infos']['questions'][$compteurQuestion][3][0])){
						
						echo(htmlspecialchars($_SESSION['infos']['questions'][$compteurQuestion][3][0]));
						echo('  <span id='.$compteurQuestion.'><input type="button" value="associer des propriétés à cette question" id="edit" onclick="submitquestion(&quot;'.$compteurQuestion.'&quot;);"/></span><br><br>');
						$compteurQuestion++;
						}
						if($compteurQuestion==0){
							echo('<font color="grey"><small>Aucune question detectée, éditez votre énoncé pour faire apparaître une question</small></font>');
						}
						
						if(!(isset($text))){
							echo('<font color="grey"><small>Entrez un énoncé d\'abord</small></font><br><br>');
						}
					?>
			</ul> 


		<ul>		<li id="li_5" >
		<label class="description" for="element_5">contraintes numériques </label>
		<div>
			<textarea id="element_5" name="element_5" class="element textarea small"><?php if(isset($constraints)){echo($constraints);}?></textarea> 
		</div><p class="guidelines" id="guide_5"><small>Séparez les contraintes numériques par des '<b>;</b>'.<br>Exemple : Nombre1>Nombre2+4 ; Nombre1>10 ; Nombre1<20</small></p> 
		</li>		<li id="li_6" >
		<label class="description" for="element_6">Description du problème (public) </label>
		<div>
			<textarea id="element_6" name="element_6" class="element textarea small"><?php if(isset($public)){echo($public);}?></textarea> 
		</div><p class="guidelines" id="guide_6"><small>Cette description apparaîtra partout où elle sera recquise. </small></p> 
		</li>		<li id="li_7" >
		<label class="description" for="element_7">Notes de l'auteur (privé) </label>
		<div>
			<textarea id="element_7" name="element_7" class="element textarea small"><?php if(isset($private)){echo($private);}?></textarea> 
		</div> <p class="guidelines" id="guide_6"><small>Ces notes n'apparaitront que lors de la modification/suppression de ce problème </small></p> 
		</li>		<li id="li_8" >

			
					<li class="buttons">
			    <input type="hidden" name="form_id" value="470585" />
			    <div id="property_div">
			    	<input id="property" type="button" name="prop" value="propriétés de ce problème" onclick="submitmainform(&quot;property&quot;);"/>
			    </div>
			    <!-- <div id="upload">
			    	<input id="upload" type="button" name="audio" value="ajouter de l'audio au problème" onclick="submitmainform(&quot;upload&quot;);"/>
			    </div> -->
			    <div id="validate_div">
				<input id="saveForm" class="button_text" type="button" name="sub" value="Enregistrer" onclick="submitmainform(&quot;validate&quot;);" /></div>
		</li>
			</ul>
		</form>	
	</div>
	<img id="bottom" src="static/images/bottom.png" alt="">
	

	</body>
</html>