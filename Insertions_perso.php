<?php
	require_once("verifSessionProf.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Choix des pbms</title>
<link rel="stylesheet" type="text/css" href="static/css/view.css" media="all">
<script>
var names=new Array();
function updateMessage(name,id){
	var message="Les types que vous pouvez utiliser sont : ";
	var implodeMessage="";
	var virgule='';
	var separateur='';
	var b=true;
	if(	(	names.indexOf(name)!=-1	)	)//si il existe on l'enlève
		{
		b=false;
		names.splice(names.indexOf(name),1);
		}
	if(	(	names.indexOf(name)==-1	)&&(b)	)//sinon on l'ajoute
		{
		names.push(name);
		}
	for(var Indname in names){
		if(Indname==1){virgule=' , ';separateur='||';}
		message+=virgule+names[Indname];	
		implodeMessage+=separateur+names[Indname];
	}
	message+=".   Vous pouvez les utiliser comme les types déjà enregistrés";
	document.form2text.message.value=message;
	document.form2text.TabExtras.value=implodeMessage;
	
}
</script>
</head>

<body id="main_body" >
	<?php include("headerEnseignant.php"); ?>


	<img id="top" src="static/images/top.png" alt="">
	<div id="form_container">
	<h1><a>Untitled Form</a></h1>
	<h2>Choisissez vos types </h2>
	
	
    <ul>
    <?php
	    $self=$_SERVER['PHP_SELF'];
	    require_once("conn_pdo.php");
	    
	 	$sql1 = "SELECT * FROM lists WHERE type='insertions'";
		$result = $bdd->query($sql1); //or die ("Requête incorrecte");
		$t=0;
		while ($enregistrement = $result->fetch())
		{
			$t++;
			$values =  $enregistrement["values"];
			$name= $enregistrement["name"];
			$id=$enregistrement["id"];
	?>
	<form name="form__<?php echo($t);?>" action="TraitInsertions.php" method="post" class="appnitro">
	<input type="hidden"  name="infos" value="<?php if (isset($_POST["infos"])){echo($_POST["infos"]);}?>"/>
		 <li id="li_<?php echo($t);?>">
				<div class="commandWrap">
				<input type="hidden" name="identifiant" value="<?php echo($id);?>">
					<div style="width:10px;display:inline-block;margin:0 5px 0px 0px;vertical-align:middle">
						<input type=checkbox id="id<?php echo($t);?>" name="id<?php echo($t);?>" value="<?php echo($t);?>" onclick=updateMessage("<?php echo($name);?>","id<?php echo($t);?>");>
					</div>
					<div style="width:120px;display:inline-block;margin:0 0 5px 10px;padding:10px;border:1px solid black"> 
						  <?php echo(($name)); ?>
					</div>
					<div style="width:140px;display:inline-block;margin:0 0 5px 10px;padding:10px;border:1px solid black"> 
						  <?php echo($values); ?>
					</div>
						<input type=submit name="modif" value="modifier" onclick=modify();>
				</div>	
		 </li>
		
		 </form>
	    <?php
	    	$result->closeCursor();
	        } // Fin instruction while



	      
	?> 
	<form name="form2text" action="ProblemTextCreation.php" method="post" class="appnitro">
		<input type=submit name="modif" value="valider">
		<input type=hidden name="message" value="">
		<input type=hidden name="TabExtras" value="">
		<input type="hidden"  name="infos" value="<?php if (isset($_POST["infos"])){echo($_POST["infos"]);}?>"/>
	</form>

	</ul><form action="TraitInsertionsSave.php" method="post" class="appnitro"><br>
	<input type="hidden"  name="infos" value="<?php if (isset($_POST["infos"])){echo($_POST["infos"]);}?>"/>

		<input type="hidden" id="identifiant" name="operation" value="insert"/>
		<h3>Ajoutez votre type d'insertion personnalisée</h3>
			<li id="li_999" >
				<label class="description" for="element_999">Nom de votre liste</label>
				<div>
				<input id="element_999" name="element_999" class="element text large" type="text" maxlength="255" value=""/> 
				</div><p class="guidelines" id="guide_999"><small>Exemples : animaux de la ferme </small></p> 
						
						
			</li>
			<li id="li_998" >
						<label class="description" for="element_998">elements de cette liste </label>
						<div>
							<textarea id="element_998" name="element_998" class="element textarea small"></textarea>
						</div><p class="guidelines" id="guide_998"><small>Exemples : vaches ; lapins ; poules </small><br> Utilisez les ';' comme séparateurs</p> 
					</li>

	</ul>	
	<input type="submit" value="ajouter cette liste">

	  </form>
	</div>
	  

	<img id="bottom" src="static/images/bottom.png" alt="">
	</body>
</html>
