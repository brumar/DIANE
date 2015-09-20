<?php
	require_once("verifSessionProf.php");
	$self=$_SERVER['PHP_SELF'];
	require_once("conn_pdo.php");		    
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Choix des pbms</title>
		<link rel="stylesheet" type="text/css" href="static/css/view.css" media="all">
		<script type = "text/javascript">
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
					if(Indname==1){virgule=' ,';separateur='||';}
					message+=virgule+names[Indname];	
					implodeMessage+=separateur+names[Indname];
				}
				message+=". Vous pouvez les utiliser comme les types déjà enregistrés.";
				document.form2text.message.value=message;
				document.form2text.TabExtras.value=implodeMessage;	

				//alert(message);
			}


			function modify_list(idList){
				//alert(idList);
			}

			if (typeof String.prototype.trim != 'function') { // detect native implementation
			  String.prototype.trim = function () {
			    return this.replace(/^\s+/, '').replace(/\s+$/, '');
			  };
			} //TODO : MARCHE PAS :(
 
			function verifSubmitList(){
				var f_elements_list = document.getElementById("elements_list");
				var f_nom_list = document.getElementById("nom_list");

				//f_elements_list.value = f_elements_list.value.trim(); //MARCHE PAS
				//f_nom_list.value = f_nom_list.value.trim(); //MARCHE PAS
				return true;
			}
		</script>
	</head>

	<body id="main_body" >
		<?php include("headerEnseignant.php"); ?>


		<img id="top" src="static/images/top.png" alt="">
		<div id="form_container">
			<h1><a>Untitled Form</a></h1>

			<h2>Choisissez vos types </h2>
			<p>Sélectionnez tous les types d'insertions que vous souhaitez utiliser, ou bien crééez-en de nouvelles.</p>
			<ul>
		    <form name="form__<?php echo($t);?>" action="TraitInsertions.php" method="post" class="appnitro">

			    <?php
					$result = $bdd->query('SELECT * FROM lists WHERE type = "insertions"'); //or die ("Requête incorrecte");
					$t=0;
					while ($enregistrement = $result->fetch())
					{
						$t++;
						$values =  $enregistrement["values"];
						$name= $enregistrement["name"];
						$id=$enregistrement["id"];
					
						//echo '<input type="hidden"  name="infos" value="';if (isset($_POST["infos"])){echo($_POST["infos"]);} echo '"/>"';
						echo '<li id="li_'.$t.'>';
							echo '<div class="commandWrap">';
							echo '<input type="hidden" name="identifiant" value="'.$id.'">';
								echo '<div>';
									echo '<input type=checkbox id="id'.$t.'" name="id'.$t.'" value="'.$t.'" onclick=updateMessage("'.$name.'","id'.$t.'")>';
								echo '</div>';
								echo '<div>';
									  echo(($name));
								echo '</div>';
								echo '<div>';
									  echo($values);
								echo '</div>';
									//echo '<input type="button" name="modif" value="modifier" onclick="modify_list('.$id.')";>'; //TODO : faire fonctionner
						echo '</li>';	
					}
					$result->closeCursor();      
					?> 
				
			</form>
			</ul>
		


			<form name="form2text" action="enonce_template.php" method="post" class="appnitro">
				<input type=submit name="modif" value="valider">
				<input type=hidden name="message" value="">
				<input type=hidden name="TabExtras" value="">
				<input type="hidden"  name="infos" value="<?php if (isset($_POST["infos"])){echo($_POST["infos"]);}?>"/>
			</form>

			<ul>

				<form action="TraitInsertionsSave.php" method="post" class="appnitro" onsubmit="return verifSubmitList();"><br>
				<input type="hidden"  name="infos" value="<?php if (isset($_POST["infos"])){echo($_POST["infos"]);}?>"/>

				<input type="hidden" id="identifiant" name="operation" value="insert"/>
				<h3>Ajoutez votre type d'insertion personnalisée</h3>
					<li id="li_999" >
						<label class="description" for="nom_list">Nom de votre liste</label>
						<div>
							<input id="nom_list" name="nom_list" class="element text large" type="text" maxlength="255" value=""/> 
						</div>
						<p class="guidelines" id="guide_999"><small>Exemples : animaux de la ferme </small></p> 
					</li>
					<li id="li_998" >
						<label class="description" for="elements_list">Elements de cette liste </label>
						<div>
							<textarea id="elements_list" name="elements_list" class="element textarea small"></textarea>
						</div>
						<p class="guidelines" id="guide_998"><small>Exemples : vaches ; lapins ; poules </small><br> Utilisez les ';' comme séparateurs</p> 
					</li>

				</ul>	
				<input type="submit" value="ajouter cette liste">
			</form>

		</div>

		<img id="bottom" src="static/images/bottom.png" alt="">
	</body>
</html>
