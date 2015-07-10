<?php
	require_once("verifSessionProf.php");
	require_once("ListFunction.php");
	require_once("conn_pdo.php");
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Untitled Form</title>
		<link rel="stylesheet" type="text/css" href="static/css/view.css" media="all">
		<script type="text/javascript" src="static/js/view.js"></script>
		<script type="text/javascript">
		    function addItem()
		    {     
		        var text=document.getElementById("element_8").value;
		        var opt = document.createElement("option");      
		        opt.text = text;
		        opt.value = text;
		        opt.selected="selected";
		        document.getElementById("element_1").options.add(opt);
		               
		    }
		</script>
	</head>
	<body id="main_body" >
		<?php 
		include("headerEnseignant.php");
	
		if (isset($_POST["target"])){
		//echo($_POST["type"]);
		}

		$name='';
		if (isset($_POST["sender"])){

			$infos= unserialize(base64_decode($_POST["infos"]));

			$sender=$_POST["sender"];
			
			switch ($sender){
			case "QuestionCreation.php" :
				$name="answer";
				$currentQ=$infos['temp']['currentQuestion'];
				$currentA=$infos['temp']['CurrentAnswer'];
				//$tp=$infos['Qinfos']['properties'][$currentQ][$currentA];
				//if(isset($_POST["properties"])){$tp["properties"]=$_POST["properties"];}
				$previouslist=isset($infos['Qinfos']['properties'][$currentQ][$currentA]) ? $infos['Qinfos']['properties'][$currentQ][$currentA] : null;//on selectionne le tableau des propriétés déjà enregistrées pour ce problème	
				//echo("question : $currentQ  réponse : $currentA");
				//print_r($previouslist);
				break;
			case "creation_template.php" :
				$previouslist=isset($infos['properties']) ? $infos['properties'] : null;
				$name="pbm";
				break;
			}
			//print_r($previouslist);
		
			//$infos['properties']=$TabProperties;

		$options=loadList('problem', $bdd);	
		$p2='" >';
		$p3='</option>';
		
	}
	?>


		<img id="top" src="static/images/top.png" alt="">
		<div id="form_container">
		
			<h1><a>Untitled Form</a></h1>
			<form id="form_470585" class="appnitro"  method="post" action="<?php if (isset($_POST["sender"])){echo($_POST["sender"]); }?>">
				<div class="form_description">
					<h2>Modifications des propriétés</h2>
					
						<?php 
							if (isset($_POST["target"])){
								echo(base64_decode($_POST["target"]));
							}
						?>
					
					<h3>Cliquez sur les propriétés désirées</h3>
				
				</div>						
				<ul>
					<li id="li_1" >
						<label class="description" for="element_1">Propriétés </label>
						<div>
							<select class="element select large" id="element_1" name="properties[]" multiple="multiple" size="25">
								<?php 
								foreach($options as $option){
									$p1='<option value="';
									if(isset($previouslist)){if(in_array($option,$previouslist)){$p1='<option selected="selected" value="';}}		
									echo($p1.$option.$p2.$option.$p3); //<option value="First option" >First option</option> etc...
									//selected="selected"
								}
								?>
							</select>
						</div><p class="guidelines" id="guide_1"><small>Ctrl+click pour choisir plusieurs propriétés.</small></p> 
					</li>
					<li>	
						<label class="description" >Ajoutez une propriété à la liste</label>
						<input id="element_8" name="element_8" class="element text medium" type="text" maxlength="255" value=""/> 
						<input id="saveForm" class="button_text" type="button" name="ajout" value="ajout"  onclick="addItem();" />
					</li>
					<li class="buttons">
					    <input type="hidden" name="form_id" value="470585" />
					    <input type="hidden" name="infos" value="<?php if (isset($_POST["infos"])){echo(htmlspecialchars($_POST["infos"])); }?>"/>
						<input id="saveForm" class="button_text" type="submit" name="submit" value="OK" />
					</li>
				</ul>
			</form>	
		</div>
		<img id="bottom" src="static/images/bottom.png" alt="">
	</body>
</html>