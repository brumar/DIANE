<?php
	require_once("verifSessionProf.php");
	require_once("ListFunction.php");
	require_once("conn_pdo.php");

	// sert quand on clique sur "associer des propriétés". Faudrait sans doute mettre cette ligne ailleurs pour que ce soit plus propre...
	$_SESSION['sender'] = basename($_SERVER['REQUEST_URI']); 	
	
	if (isset($_SESSION['infos']['currentQuestion'])){ 
		
		$current=$_SESSION['infos']['currentQuestion'];
		$question=htmlentities($_SESSION['infos']['questions'][$current][3][0]);

		if (isset($_POST["properties"])){ // On revient de properties.php
			updateList('answer', $_POST["properties"], $bdd);//si la liste de propriétés contient des éléments nouveaux, alors on rajoute ces éléments 


			$currentAnswer=$_SESSION['infos']['temp']['CurrentAnswer'];
			$_SESSION['infos']['Qinfos']["properties"][$current][$currentAnswer]=$_POST["properties"]; // Do I need that ?
		}

		if (isset($_SESSION['infos']['html'])){$text=$_SESSION['infos']['html'];}
		if (isset($_SESSION['infos']['variable'])){$variable=$_SESSION['infos']['variable'];}
		if (isset($_SESSION['infos']['keywords'])){$keywords=$_SESSION['infos']['keywords'];}
		if (isset($_SESSION['infos']['comments'])){$comments=$_SESSION['infos']['comments'];}
		if (isset($_SESSION['infos']['good_answer'])){$good_answers=$_SESSION['infos']['good_answer'];}
		if (isset($_SESSION['infos']['intermediary_computation'])){$intermediary_computation=$_SESSION['infos']['intermediary_computation'];}
	}
	else{ // TODO : verifier que c'est ça...
		header("Location: creation_template.php");
		exit();
	}

?>

<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Questions</title>
	<link rel="stylesheet" type="text/css" href="static/css/view.css" media="all">
	<script type="text/javascript" src="static/js/view.js"></script>
	<script type="text/javascript" src="static/js/userscript.js"></script>
</head>
<body id="main_body" >
	<?php include("headerEnseignant.php"); ?>
	<img id="top" src="static/images/top.png" alt="">
	<div id="form_container">
	
		<h1><a>Untitled Form</a></h1>
		<h3>Enoncé</h3>
		<div style="width:360px;padding:10px;margin:10px;border:1px solid black">
			<?php if (isset($text)){echo($text);}else{echo('<font color="grey"><small>aucun énoncé fourni</small></font>');}?>
		</div><h3>Question : </h3>
		<?php if(isset($question)){echo($question);}?>
		<form id="form_470585" name="mainform" class="appnitro"  method="post" action="<?php echo(basename($_SERVER['REQUEST_URI']));?>" name="formulaire">
			<input type="hidden" name="clickedProp" value="">
			<input type="hidden" name="infos" value="">
			
			<div class="form_description">				
		
				<h2>Decrivez les réponses attendues à votre question</h2>
			</div>						
			<ul>
		
				<label class="description" for="element_3">Réponses attendues </label>
		
				<div id="questBlock">
					<div class="question" id="quest0">	
						<li id="li_1" >
							<label class="description" for="element_1">variable <br><small>Laisser vide si la réponse est qualitative</small><br><small>Mettre une relation si la variable est issue d'un calcul</small>
							</label>
							<div>
								<input id="element_1" name="element_1" class="element text large" type="text" maxlength="255" value="<?php if (isset($variable)){echo($variable);}?>"/> 
							</div><p class="guidelines" id="guide_1"><small>Exemples : <br>Nombre1<br>Nombre1+Nombre2<br>Nombre1-Nombre2 </small></p> 
						</li>
						<li id="li_2" >
							<label class="description" for="element_2">mots clefs associés à cette variable </label>
							<div>
								<input id="element_2" name="element_2" class="element text large" type="text" maxlength="255" value="<?php if (isset($keywords)){echo($keywords);}?>"/> 
							</div><p class="guidelines" id="guide_2"><small>Exemples : billes, perdue, Anna </small></p> 
						</li>
						<li id="li_3" >
							<label class="description" for="element_3">commentaire associé à ce type de réponse attendue</label>
							<div>
								<textarea id="element_3" name="element_3" class="element textarea small"><?php if (isset($comments)){echo($comments);}?></textarea> 
							</div><p class="guidelines" id="guide_3"><small>ce paragraphe sera affiché dans le diagnostic lorsque ce type de réponse aura été détecte.</small></p> 
						</li>
						<li id="li_4" >	Est-ce une bonne réponse ?
							<?php 
								if(isset($good_answers)){
									if($good_answers=="oui"){
										?>
										<input type="radio" name="bonne_reponse" id="bonne_reponse_oui" checked value="oui">Oui
										<input type="radio" name="bonne_reponse" id="bonne_reponse_non" value="non">Non
										<?php
									}
									else if($good_answers=="non"){
										?>
										<input type="radio" name="bonne_reponse" id="bonne_reponse_oui" value="oui">Oui
										<input type="radio" name="bonne_reponse" id="bonne_reponse_non" checked value="non">Non
										<?php
									}
									else{?>
										<input type="radio" name="bonne_reponse" id="bonne_reponse_oui" value="oui">Oui
										<input type="radio" name="bonne_reponse" id="bonne_reponse_non" value="non">Non
										<?php
									}
								}
								else{?>
									<input type="radio" name="bonne_reponse" id="bonne_reponse_oui" value="oui">Oui
									<input type="radio" name="bonne_reponse" id="bonne_reponse_non" value="non">Non
								<?php
								}?>
						</li>
						
						<li id="li_4" >	Est-ce un calcul intermédiaire ?
							<?php 
								if(isset($intermediary_computation)){
									if($intermediary_computation=="oui"){
										?>
										<input type="radio" name="calcul_interm" id="calcul_interm_oui" checked value="oui">Oui
										<input type="radio" name="calcul_interm" id="calcul_interm_non" value="non">Non
										<?php
									}
									else if($intermediary_computation=="non"){
										?>
										<input type="radio" name="calcul_interm" id="calcul_interm_oui" value="oui">Oui
										<input type="radio" name="calcul_interm" id="calcul_interm_non" checked value="non">Non
										<?php
									}
									else{?>
										<input type="radio" name="calcul_interm" id="calcul_interm_oui" value="oui">Oui
										<input type="radio" name="calcul_interm" id="calcul_interm_non" value="non">Non
										<?php
									}
								}
								else{?>
									<input type="radio" name="calcul_interm" id="calcul_interm_oui" value="oui">Oui
									<input type="radio" name="calcul_interm" id="calcul_interm_non" value="non">Non
								<?php
								}?>
						</li>
						<li id="li_12" >	
							<input type="button"  value="associer à des propriétés" onClick="accessProperties(this);">
						</li><br>
						<li id="li_11" >	
							<img id="del_property" src="static/images/del.png" style="cursor: pointer; cursor: hand; float:left;" onClick="supress(this);">
							<span style="display:inline">supprimer ce type de réponse attendue</span>
						</li>
			
					</div>
						<span id="writeplace"></span>
						<img align="middle" src="static/images/add.png" style="cursor: pointer; cursor: hand;" onClick="PlusFields();"><span>Ajouter un type de réponse attendue</span>					
				</div>	

				<li class="buttons">
				    <input type="hidden" name="form_id" value="470585" />
				    <!-- <input type="button"  value="tester" onClick="AnswerTest();"> -->
					<input id="saveForm" class="button_text" type="submit" name="envoi" value="valider" />
				</li>
			</ul>
		</form>	
		
	</div>
	<img id="bottom" src="static/images/bottom.png" alt="">
		<form id="form0" name="form0" action="properties.php" method="post">
		<input name="ident" type="hidden" value="1">
		<input name="target" type="hidden" value="1">
	</form>
	<span id="formPlace"></span>
		<form id="form_prop"  method="post" action="properties.php" name="form2properties">
			<input type="hidden" name="target" value="HereAtarget"/>
			<input type="hidden" name="infos" value="HereTheInformations"/>			
			<input type="hidden" name="type" value="Answers"/>
		</form>
		
		<!-- <form id="form_prop"  method="post" action="AnswerTester.php" name="form2tester">
			<input type="hidden" name="target" value="HereAtarget"/>
			<input type="hidden" name="infos" value="HereTheInformations"/>			
		</form> -->

		<form id="form_pbm_creation"  method="post" action="creation_template.php" name="form2pbmcreation">
			<input type="hidden" name="infos" value="HereTheInformations"/>			
		</form>
			

	
	<?php 

		//on parcourt les réponses attendues

		if(isset($_SESSION['infos']['Qinfos']['description'][$current])){
				
			$tab=$_SESSION['infos']['Qinfos']['description'][$current];

			foreach ($tab as $q => $Rattendue ){
				$formcounter=$q;
				if($formcounter==0){$formcounter="";}
				if($q!=0){echo("<script type=\"text/javascript\">PlusFields();</script>");}
				$v=$Rattendue['variable'];
				$m=$Rattendue['keywords'];
				$c=$Rattendue['comments'];

				$ga = $Rattendue['good_answer'];
				$ca = $Rattendue['intermediary_computation'];

				echo("<script type=\"text/javascript\">
						document.mainform.element_1$formcounter.value=\"$v\";
						document.mainform.element_2$formcounter.value=\"$m\";
						document.mainform.element_3$formcounter.value=\"$c\";
						document.mainform.bonne_reponse$formcounter.value=\"$ga\";
						document.mainform.calcul_interm$formcounter.value=\"$ca\";
						</script>");
			}
		}
			
	


if (isset($_POST['clickedProp'])){//SI ENVOI FORMULAIRE (propriétés ou submit)

	//********************Actualisation de $INFOS DEBUT

	$c="";
	$compteur=0;
	$Qinfo=array();
	$currentQuestion=$_SESSION['infos']['currentQuestion'];
	while(isset($_POST["element_1$c"])){
		$a=array();
		$a['variable']=$_POST["element_1$c"];
		$a['keywords']=$_POST["element_2$c"];
		$a['comments']=$_POST["element_3$c"];
		$a['good_answer']=$_POST["bonne_reponse$c"];
		$a['intermediary_computation']=$_POST["calcul_interm$c"];
		$Qinfo[$compteur]=$a;	
		$compteur++;
		$c=$compteur;	
	}
	$_SESSION['infos']['Qinfos']['description'][$currentQuestion]=$Qinfo;
	echo("<script type=\"text/javascript\">alert(\"I did it\")\;</script>");
//	echo("<script type=\"text/javascript\">var Mainform=document.mainform;Mainform.infos.value=\"$infosHtmlProtected\";</script>");//place $_POST['infos'] dans le formulaire de base

	//********************Actualisation de $INFOS - FIN

	if ($_POST['clickedProp']!=''){//SI L'utilisateur a appuyé sur "propriétés"
		if($_POST['clickedProp']=='test'){
			$target=base64_encode('<h3>enonce</h3><div style="width:360px;padding:10px;margin:10px;border:1px solid black;display:inline-block">'.$text.'</div>');
			echo("<script type=\"text/javascript\">
					document.form2tester.target.value=\"$target\";
					document.form2tester.submit();
					</script>");//TODO : remplacer cet echo
		}
		else{
			
				
			$IdProp=$_POST['clickedProp'];
			$_SESSION['infos']["temp"]["CurrentAnswer"]=$IdProp;
			//$infosHtmlProtected=htmlspecialchars(base64_encode(serialize($infos)));
			if($IdProp=="0"){$IdProp="";}
			$var=$_POST['element_1'.$IdProp];
			$mclefs=$_POST['element_2'.$IdProp];
			$target=base64_encode('<h3>enonce</h3><div style="width:360px;padding:10px;margin:10px;border:1px solid black;display:inline-block">'.$text.'</div><br> variable : '.$var.' <br>Mots clefs : '.$mclefs);
			


			// echo("<script type=\"text/javascript\">
			// document.form2properties.infos.value=\"$infosHtmlProtected\";
			// var Number=\"$IdProp\";
			// document.form2properties.target.value=\"$target\";
			// document.form2properties.submit();
			// </script>");

			echo("<script type=\"text/javascript\">
			var Number=\"$IdProp\";
			document.form2properties.target.value=\"$target\";
			document.form2properties.submit();
			</script>");//TODO : celui là aussi
		}
	//
	}
	else{//SI L'utilisateur n'a pas appuyé sur "propriétés", cela implique qu'il a appuyé sur envoyer

		//on submit alors le formulaire contenant $info, qu'on envoie à problemCreation
		
		echo("<script type=\"text/javascript\">
			document.form2pbmcreation.submit();	
				</script>");

	}
}


// if(isset($_POST['currentQuestion'])){
	
// 		//Si on accede à cette page autrement que par l'envoi d'un formulaire cela implique
// 		//Qu'on y arrive par la page de création d'énoncé ce qui implique qu'on doit recontruire cette page
// 		//En suivant les données prises dans $Infos
	
// 	$current=$_POST['currentQuestion'];//on récupère l'index de la question courante par le biais de 'currentQuestion'
// 	$_SESSION['infos']['temp']['currentQuestion']=$current;// On place cette information dans $Infos

	
// 	//on parcourt les réponses attendues
// 	//attention il faut certainement prendre la valeur numérique de $current
// 	if(isset($_SESSION['infos']['Qinfos']['description'][$current])){
// 		$tab=$_SESSION['infos']['Qinfos']['description'][$current];
		
// 		foreach ($tab as $q => $Rattendue ){
// 			$formcounter=$q;
// 			if($formcounter==0){$formcounter="";}
// 			if($q!=0){echo("<script type=\"text/javascript\">PlusFields();</script>");}
// 			$v=$Rattendue['variable'];
// 			$m=$Rattendue['keywords'];
// 			$c=$Rattendue['comments'];
// 			echo("<script type=\"text/javascript\">
// 					document.mainform.element_1$formcounter.value=\"$v\";
// 					document.mainform.element_2$formcounter.value=\"$m\";
// 					document.mainform.element_3$formcounter.value=\"$c\";
// 					</script>
// 					");	
// 		}
	
// 	}
// 	// echo("<script type=\"text/javascript\">
// 	// document.mainform.infos.value=\"$infosHtmlProtected\";
// 	// </script>");
	
// }


// if(isset($_POST['AnswerTester'])){//on accede à cette page par le biais de l'answer tester
// 	$infosHtmlProtected=htmlspecialchars(base64_encode(serialize($infos)));
// 	if(isset($_SESSION['infos']['Qinfos']['description'][$current])){
// 		$tab=$_SESSION['infos']['Qinfos']['description'][$current];
// 		foreach ($tab as $q => $Rattendue ){
// 			$formcounter=$q;
// 			if($formcounter==0){$formcounter="";}
// 			if($q!=0){echo("<script type=\"text/javascript\">PlusFields();</script>");}
// 			$v=$Rattendue['variable'];
// 			$m=$Rattendue['keywords'];
// 			$c=$Rattendue['comments'];
// 			echo("<script type=\"text/javascript\">
// 					document.mainform.element_1$formcounter.value=\"$v\";
// 					document.mainform.element_2$formcounter.value=\"$m\";
// 					document.mainform.element_3$formcounter.value=\"$c\";
// 					</script>
// 					");
// 		}

// 	}
// 	// echo("<script type=\"text/javascript\">
// 	// 		document.mainform.infos.value=\"$infosHtmlProtected\";
// 	// 		</script>");

// }



?>
	
	</body>
</html>