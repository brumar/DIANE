<?php
	require_once("verifSessionProf.php");
	require_once("ListFunction.php");

	$textBrut='';
	$text='';
	$listesInit=array("Quest","Nombre","Variable","homme","femme" );//liste par défaut
	$liste=$listesInit;


	$initcompteur='var compteur = { "Quest" : 1, "Nombre" : 1, "homme" : 1,"femme" : 1};';
	$startcompteur='var startcompteur = { "Quest" : 1, "Nombre" : 1, "homme" : 1,"femme" : 1};';

	$compteursExtra=array();

	if(isset($_POST['TabExtras'])){
		$mess2=$_POST['TabExtras'];
		if($mess2!=""){
			$compteursExtra=explode('||',$mess2);
		}
		//print_r($compteursExtra);
	}



	if(isset($_SESSION['infos']['texteBrut'])){
		$textBrut=$_SESSION['infos']['texteBrut'];
	}
	if(isset($_POST['enonce'])){//priorité à enoncé
		$textBrut=$_POST['enonce'];
	}
	if(isset($_SESSION['infos']['html'])){
		$text=$_SESSION['infos']['html'];
	}
	if(isset($_SESSION['infos']['compteurs'])){
		$compteurs=$_SESSION['infos']['compteurs'];
		$listes=array();
		$initcompteur='var compteur = { ';
		$virgule='';
		$needVirgule=false;//variable permettant de mettre des virgules là ou c'est necessaire
		
		//var_dump(unserialize($compteurs));
		foreach($compteurs as $k=>$compteur){
			if($needVirgule){
				$virgule=', ';
			}
			$listes[]=$k;
			$initcompteur.=$virgule.'"'.$k.'" : ';
			$initcompteur.=$compteur;
			$needVirgule=true;
		}
		//$compteursExtra
		
		$needVirgule=false;//variable permettant de mettre des virgules là ou c'est necessaire
		
		foreach($compteursExtra as $e=>$CompteurExtra ){

			if($needVirgule){
				$virgule=', ';
			}

			$listes[]=$CompteurExtra;
			$initcompteur.=$virgule.'"'.$CompteurExtra.'" : ';
			$initcompteur.="1";
			$needVirgule=true;
		}
			
		$initcompteur.='};';
			//echo($initcompteur);
	}
	if((empty($compteursExtra))&&(isset($_SESSION['infos']['compteurs']))){//permet de remettre les boutons si on vient de ProblemTextCreation
		$compteursExtra=array_diff($listes,$listesInit);
	//print_r($compteursExtra);
	//echo("<br>compteurs");print_r($listes);
	//echo("<br>listInit");print_r($listesInit);
	//echo("<br>difference");print_r($compteursExtra);
	
		//print_r($listes);
	/*	print_r($infos['compteurs']);
		print_r($listes);
		
		print_r($compteursExtra);*/
	//}
	}

	
	if (isset($_POST['enonce'])){
		
		$enonce=($_POST['enonce']);
		
		$clones_start='<';
		$clones_end='>';
		$questions_start='[';
		$questions_end=']';
		
		$tab_clones_start=search_expression($clones_start,$enonce);//contiennent les tableaux de la position des séparateurs
		$tab_clones_end=search_expression($clones_end,$enonce);
		$tab_questions_start=search_expression($questions_start,$enonce);
		$tab_questions_end=search_expression($questions_end,$enonce);
		
		//on rechercher les erreurs syntaxiques, c'est à dire des caractère ouvrant '<<' suivis par des caractères "intrus" précédant le caractère 
		$erreur=false;
		$erreur=SyntaxicVerification($tab_clones_start,$tab_clones_end,"<<",">>",$tab_questions_start,"[[");//on effectue des vérification de syntaxes
		$erreur=SyntaxicVerification($tab_clones_start,$tab_clones_end,"<<",">>",$tab_questions_end,"]]");
		$erreur=SyntaxicVerification($tab_clones_start,$tab_clones_end,"<<",">>",$tab_questions_start,"<<");
		$erreur=SyntaxicVerification($tab_questions_start,$tab_questions_end,"[[","]]",$tab_questions_start,"[[");
		

		
		$tabTemp=array();

		if(!$erreur){
			$copieEnonce=$enonce;
			$informations_clones=array();
			foreach ($tab_clones_start as $c=> $PstartClone){//on parcourt l'ensemble des clones
				$PendClone=$tab_clones_end[$c];
				$start=$PstartClone+2;
				$end=$PendClone;
				$length=$end-$start;
				$content=substr($copieEnonce,$start,$length);//on récupère le contenu de l'expression
				$tabTemp=getInformations($content,$erreur);//on récupère dans un tableau les informations liées aux clones, on récupère aussi les erreurs s'il y en a
				if($tabTemp!=null){
					$tabTemp["start"]=$PstartClone;
					$tabTemp["end"]=$PendClone;//on rajoute dans ce tableau les informations concernant la position du clone
					$informations_clones[$c]=$tabTemp;//on récupère l'ensemble de ces informations dans un tableau général
				}
				//print_r($informations_clones);
			}

			$text=cloner($informations_clones,$copieEnonce);//ON utilise ce tableau général pour cloner l'ensemble
		}
		if(!$erreur){//même fonctionnement que predemment
			$copieEnonce=$enonce;
			$informations_questions=array();
			foreach ($tab_questions_start as $c=> $Pstartquestion){//
				$Pendquestion=$tab_questions_end[$c];
				$start=$Pstartquestion+2;
				$end=$Pendquestion;
				$length=$end-$start;
				$content=substr($copieEnonce,$start,$length);
				$tt=htmlspecialchars($content);
				//echo($tt);
				//echo('compteur :'.$c.'');
				$tabTemp=getInformations($content,$erreur);
				if($tabTemp!=null){
					$tabTemp["start"]=$Pstartquestion;
					$tabTemp["end"]=$Pendquestion;
					$informations_questions[$c]=$tabTemp;
				}
				$text=soulignerQuestions($tabTemp,$text);
			}
			//$text=soulignerQuestions($informations_questions,$text);
		}
		// RECUPERATION DES COMPTEURS -  DEBUT
		
		$cptrs=array();
		foreach($_POST as $key => $var){
			//echo($key);
			$temp=$key;
			$radical=substr($temp,0,9);
			if($radical=="compteur_"){
				$idcompteur=str_replace($radical,'',$key);
				$cptrs[$idcompteur]=$var;
			}
		}
		
		// RECUPERATION DES COMPTEURS -  FIN
		
		$_SESSION['infos']['compteurs']=$cptrs;
		$_SESSION['infos']['html']=$text;
		$_SESSION['infos']['questions']=$informations_questions;
		$_SESSION['infos']['texteBrut']=$enonce;
		$_SESSION['infos']['clones']=$informations_clones;
		

		
		if(isset($_POST['envoi'])){ // NON : il faut d'abord revenir sur cette même page pour enregistrer "$text" ???
			$action=$_POST['action'];
			header('Location: '.$action);
			exit();
		}
	}		
?>


<!DOCTYPE html>
<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Créer un énoncé</title>
	<link rel="stylesheet" type="text/css" href="static/css/view.css" media="all">
	<script type="text/javascript" src="static/js/view.js"></script>
	<script type="text/javascript" src="static/js/userscript.js"></script>
	<script type="text/javascript" src="static/js/scripts_enonce.js"></script>
	

	</head>
	<body id="main_body" >
	<?php include("headerEnseignant.php"); ?>
		<img id="top" src="static/images/top.png" alt="">
		<div id="form_container">
		<h1><a>Untitled Form</a></h1>

		<form name="form1" id="form1" class="appnitro" method="post"> <!-- action="<?php //echo($self); ?>" -->
				<input name="action" type="hidden" value="creation_template.php">
				<h2>Ecrivez votre énoncé </h2>
							<h3>Zone d'écriture</h3>
				<ul>
					<li id="li_1" >

					<div><textarea id="textarea" name="enonce" class="element textarea medium"  ><?php if (isset($textBrut)){echo($textBrut);}?></textarea>
					</div><p class="guidelines" id="guide_1"><small>Cette zone de texte vous permet de rentrer votre énoncé. 
					Les commandes d'insertions sont reservées aux utilisateurs formés voulant utiliser les fonctionnalités avancées de DIANE. </small></p>
				
				
				</ul>
		
			<div class="commandWrap">
				<h3>commandes</h3>
					<div style="width:100px;display:inline-block;margin:0 0 5px 40px">
						<h4>Insertions</h4><input type="button" value="question" id="Quest"/>
						<input type="button" value="nombre" id="Nombre"/>
						<!--  <input type="button" value="variable" id="Variable"/>-->
						<input type="button" value="prénom masculin" id="homme"/>
						<input type="button" value="prénom féminin" id="femme"/><br><br>
					</div>
					<div style="width:100px;display:inline-block;vertical-align:top;margin:0 0 5px 40px">		
						<h4>Général</h4>
						<!--<input type="submit" value="PARSE ME"> -->
						<input type="button" value="réinitialiser" id="reinit"/>
						<input type="submit" value="visualisation" id="visualisation"/>
						<input type="button" value="valider l'énoncé" id="validation_enonce" onclick="GoToProblemCreation();"/>
						<br>
					</div>
					<div style="width:100px;vertical-align:top;margin:0 0 5px 40px">		
						<h4>Insertions personalisées</h4>
						<input type="button" value="ajouter" id="perso2" onclick="GoToInsertion();"/>
						<?php foreach($compteursExtra as $compteur){
						echo("<input type=\"button\" value=\"$compteur\" id=\"$compteur\"/>");
						}?>
		
		</form>

		<form  id="form2" name="formulaireEnvoi" method="post" action="enonce_template.php">
			<input type="hidden" name="action" value="creation_template.php">
			<input type="hidden" name="envoi" value="true" >
			<input type="hidden" name="enonce" > <!--     si l'utilisateur appuie sur envoyer, les données sont traitées avant d'envoyer les infos sur creation_template.php -->
		</form>	
					
				
		
		<h3>Visualisation</h3>
		<div id="viz" style="width:360px;padding:10px;margin:10px;border:1px solid black">
			<?php if (isset($text)){echo($text);}else{echo('<font color="grey"><small>aucun énoncé fourni</small></font>');}?>
		</div>



		</body>



		<script type="text/javascript">

		var Quest = document.getElementById('Quest');
		
		<?php echo($initcompteur);?>//contient quelque chose comme : var compteur={ "Quest" : 1, "Nombre" : 1, "Variable" : 1, "homme" : 1,"femme" : 1}
		<?php echo($startcompteur);?>
		<?php echo 'var compteursExtras = ', js_array($compteursExtra), ';';?>
		
		for(var i in compteur){//gestion des clicks sur commandes
			//alert(i);
			element=document.getElementById(i);		

			//ajout des champs - DEBUT
			
			document.getElementById('form2').innerHTML += "<input type='hidden' name='compteur_"+i+"' id='IDcompteur_"+i+"'value='"+compteur[i]+"' />";
			
			//ajout des champs - FIN
			
			if(((compteursExtras.length!=0 && compteursExtras.indexOf(i.toString())!=-1))
					||(startcompteur.hasOwnProperty(i.toString()))){
				
				addEvent(element, 'click', function(e) {
					var target = (e.srcElement || e.target);
					var id=target.id;
						
					if(id=="Quest"){
						var separateur_start="[[";
						var separateur_end="]]";
						}
					else{
						var separateur_start="<<";
						var separateur_end=">>";
					}
					startTag=separateur_start+id+"("+compteur[id]+")=";
					endTag=separateur_end;
					
					
					insertTag(startTag, endTag, "textarea", "");
					compteur[id]+=1;
			
					var name_compteur="IDcompteur_"+id;
					document.formulaireEnvoi[name_compteur].value=compteur[id];
					});
			}
		}
		
		var reinit=document.getElementById("reinit");
		addEvent(reinit, 'click', function(e) {
			document.getElementById("textarea").value="";
			compteur = { "Quest" : 1, "Nombre" : 1, "Variable" : 1, "homme" : 1,"femme" : 1};
			document.getElementById("viz").innerHTML="";
			
			for(var t in compteur){
				element=document.getElementById(t);	
				
				var id=element.id;
				
				var name_compteur="IDcompteur_"+id;
				//alert(name_compteur);
				document.formulaireEnvoi[name_compteur].value=1;
			}
		});
		
		
		</script>

	</body>

</html>
