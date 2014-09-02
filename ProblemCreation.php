<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Problème</title>
<link rel="stylesheet" type="text/css" href="view.css" media="all">
<script type="text/javascript" src="view.js"></script>
<script type="text/javascript">
function submitmainform(element){

document.mainform.currentQuestion.value=(element.parentNode.id);
//alert(document.mainform.currentQuestion.value);
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
<?php 

$self=$_SERVER['PHP_SELF'];
$constraints='';
$public='';
$private='';
//$infos=array();
if ((isset($_POST['infos']))&&(!(empty($_POST['infos'])))){
	
	
	
	$infos=$_POST['infos'];
	$infos=unserialize(base64_decode($infos));
	
	//temp
	//if(isset($infos['temp']['AUDIO'])){echo($infos['temp']['AUDIO']);}

	//print_r($infos);
	
	if (isset($infos['html'])){$text=$infos['html'];}
	if (isset($_POST["properties"])){
	
		$TabProperties=$_POST["properties"];
	
		//$infos["temp"]["CurrentAnswer"]
		$infos['properties']=$TabProperties;
		include("ListFunction.php");
		updateList('property','pbm',$_POST["properties"]);//si la liste de propriétés contient des éléments nouveaux, alors on rajoute ces éléments
		
		//echo("here properties");
		//print_r($infos['properties']);
	}
	
	$SerializedHtmlprotectedInfo=htmlspecialchars(base64_encode(serialize($infos)));
	if (isset($infos['constraints'])){$constraints=$infos['constraints'];}
	if (isset($infos['public'])){$public=$infos['public'];}
	if (isset($infos['private'])){$private=$infos['private'];}
	//if (isset($infos['texteBrut'])){echo($infos['texteBrut']);}
}


?>	
	<img id="top" src="static/images/top.png" alt="">
	<div id="form_container">
	
		<h1><a>Untitled Form</a></h1>
		<form name="realform" method="post"><input type="hidden"  name="infos"/>
		<input type="hidden" name="sender" value="<?php echo(basename($_SERVER['REQUEST_URI']));?>"/>				
		<input type="hidden" name="type" value="Problem"/>
		<input type="hidden"  name="currentQuestion"/>
		<input type="hidden"  name="target"/>
		</form>
		<form id="form_470585" class="appnitro" name="mainform" method="post" action="ProblemCreation.php">
				
					<div class="form_description">
					<h2>Creation d'énoncé</h2>
					<h3>Prévisualisation</h3>
			<div style="width:360px;padding:10px;margin:10px;border:1px solid black;display:inline-block">
				<?php if (isset($text)){echo($text);}else{echo('<font color="grey"><small>aucun énoncé fourni, cliquez sur éditer pour entrer un énoncé</small></font>');}?>
			</div>
			
			<div style="width:150px;height:100px;padding:5px;margin:5px;display:inline-block;">
				<?php if (isset($text)) echo("<img src=static/images/legend.png>");?>
			</div><br><div id="text">
					<input type="hidden" name="currentQuestion">
					<input type="hidden"  name="infos" value="<?php if (isset($SerializedHtmlprotectedInfo)){echo($SerializedHtmlprotectedInfo);}?>"/>
					 <input type="button" value="Editer" id="edit" onclick="submitmainform(this);"/></div>
			<!--  	<input type="hidden" name="TexteBrut" value="<?php // if (isset($infos['texteBrut'])){echo($infos['texteBrut']);}?>"/>	-->	
				
			
			<!--  <p>This is your form description. Click here to edit.</p>-->
		</div>	
	<ul><h3>    Questions détectées</h3>
					<?php if (isset($infos)){
					$SerializedHtmlprotectedInfo=htmlspecialchars(base64_encode(serialize($infos)));
					$compteurQuestion=0;
					while (isset($infos['questions'][$compteurQuestion][3][0])){
					
						echo(htmlspecialchars($infos['questions'][$compteurQuestion][3][0]));
						echo('  <span id='.$compteurQuestion.'><input type="button" value="associer des propriétés à cette question" id="edit" onclick="submitmainform(this);"/></span><br><br>');
						$compteurQuestion++;
						}
						if($compteurQuestion==0){
							echo('<font color="grey"><small>Aucune question detectée, éditez votre énoncé pour faire apparaître une question</small></font>');
						}
				}else{echo('<font color="grey"><small>Entrez un énoncé d\'abord</small></font><br><br>');}
				
				
				?></ul>


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
			    <div id="property">
			    	<input id="property" type="button" name="prop" value="propriétés de ce problème" onclick="submitmainform(this);"/>
			    </div>
			    <div id="upload">
			    	<input id="upload" type="button" name="audio" value="ajouter de l'audio au problème" onclick="submitmainform(this);"/>
			    </div>
			    <div id="validate">
				<input id="saveForm" class="button_text" type="button" name="sub" value="Enregistrer" onclick="submitmainform(this);" /></div>
		</li>
			</ul>
		</form>	
		<div id="footer">
			Generated by <a href="http://www.phpform.org">pForm</a>
		</div>
	</div>
	<img id="bottom" src="static/images/bottom.png" alt="">
	<?php if (isset($_POST['currentQuestion'])){//l'utilisateur a appuyé sur un bouton
	
	$c=$_POST['currentQuestion'];
	$infos=$_POST['infos'];//par voie de fait $_POST infos existe, mais il peut être vide
	$infos=unserialize(base64_decode($infos));
	if(empty($infos)){
	$infos=array();
}
	$tempText='';
	if(isset($infos['html'])){$tempText=($infos['html']);}else{$tempText="pas d'enoncé fourni pour le moment";}
	//$tempText=base64_encode($tempText);
	$target=base64_encode('<h3>enonce</h3><div style="width:360px;padding:10px;margin:10px;border:1px solid black;display:inline-block">'.$tempText.'</div>');
	$infos['constraints']=$_POST['element_5'];
	$infos['public']=$_POST['element_6'];
	$infos['private']=$_POST['element_7'];
	//actualisation de $infos
	$infosHtmlProtected=htmlspecialchars(base64_encode(serialize($infos)));
	//$test=unserialize($infosHtmlProtected);
	
	//2 cas se présentent, soit l'utilisateur a cliqué sur 'editer' soit il a cliqué sur 'propriétés
	//echo($c);
	//echo($tempText);
	//$target="<h3>enonce</h3><div style=\"width:360px\;padding:10px\;margin:10px\;border:1px solid black\;display:inline-block\"> dada </div><br>";
	switch ($c) {
		case 'text':
			echo("<script type=\"text/javascript\">
			document.realform.action=\"ProblemTextCreation.php\";
			document.realform.infos.value=\"$infosHtmlProtected\";
			document.realform.submit();
			</script>");
			break;
		case 'property':

			echo("<script type=\"text/javascript\">
			document.realform.action=\"properties.php\";
			document.realform.infos.value=\"$infosHtmlProtected\";
			document.realform.target.value=\"$target\";
			document.realform.submit();
			</script>");
			break;
		case 'upload':
			echo("<script type=\"text/javascript\">
			document.realform.action=\"upload.php\";
			document.realform.infos.value=\"$infosHtmlProtected\";
			document.realform.submit();
			</script>");
			break;
		case 'validate':
			echo("aaaaaaaaaa");
			echo("<script type=\"text/javascript\">
			document.realform.action=\"PbmSaving.php\";
			document.realform.infos.value=\"$infosHtmlProtected\";
			document.realform.submit();
			</script>");
			break;
			default:
			echo("<script type=\"text/javascript\">
			document.realform.action=\"QuestionCreation.php\";
			document.realform.infos.value=\"$infosHtmlProtected\";
			document.realform.currentQuestion.value=\"$c\";
			document.realform.submit();
				</script>");
	}
	
}	
		
		

	
	//$text=$infos['html'];
	//$SerializedHtmlprotectedInfo=htmlspecialchars(serialize($infos));
		

	
	
	?>
	
	</body>
</html>