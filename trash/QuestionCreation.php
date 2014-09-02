
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Questions</title>
<link rel="stylesheet" type="text/css" href="view.css" media="all">
<script type="text/javascript" src="view.js"></script>
<script type="text/javascript" src="userscript.js"></script>

</head>
<body id="main_body" >
	<img id="top" src="top.png" alt="">
	<div id="form_container">
	<span id="formPlace"></span>
	
		<h1><a>Untitled Form</a></h1>
		<form id="form_470585" class="appnitro"  method="post" action="" name="formulaire">
					<div class="form_description">
			<h2>Decrivez votre question ainsi que les réponses attendues</h2>
			<!-- <p>This is your form description. Click here to edit.</p> -->
		</div>						
			<ul >
			
					<li id="li_3" >
		<label class="description" for="element_3">type de question </label>
		<span>
			<input id="element_3_1" name="element_3" class="element radio" type="radio" value="1" checked="checked"  />
<label class="choice" for="element_3_1"   >quantitative (ex : combien  [...] ? )</label>
<input id="element_3_2" name="element_3" class="element radio" type="radio" value="2"   />

<label class="choice" for="element_3_2">qualitative (ex : qui [...]  ? )</label>
		<br><br>
		</span><p class="guidelines" id="guide_3"><small>choisissez le type de question</small></p> 
		</li>
		
		<label class="description" for="element_3">Réponses attendues </label>
		
		<div id="questQualBlock" style="display:none">
			<div class="question" id="questQual">
				<li id="li_4" >
					<label class="description" for="element_4">mots clefs </label>
					<div>
						<input id="element_4" name="element_4" class="element text large" type="text" maxlength="255" value=""/> 
					</div><p class="guidelines" id="guide_4"><small>choisir les mots de l'énoncé (y compris les mots en bleu) qui permettront de détecter la réponse 1</small></p> 
				</li>		
				<li id="li_10" >
					<label class="description" for="element_10">qualité de la réponse </label>
					<span>
								<input id="element_10_1" name="element_10" class="element radio" type="radio" value="1" checked="checked"/>
					<label class="choice" for="element_10_1">juste</label>
					<input id="element_10_2" name="element_10" class="element radio" type="radio" value="2" />
					<label class="choice" for="element_10_2">fausse</label>
			
					</span> 
				</li>		
				<li id="li_5" >
					
					<label class="description" for="element_5">commentaire associé à ce type de réponse attendue</label>
					<div>
						<textarea id="element_5" name="element_5" class="element textarea small"></textarea> 
					</div><p class="guidelines" id="guide_5"><small>ce paragraphe sera affiché dans le diagnostic lorsque ce type de réponse aura été détecte.</small></p> 
				</li>
				<li id="li_11" >	
					<img id="bla" src="del.png" style="cursor: pointer; cursor: hand;" onClick="supress(this);">
					<br>
					<span style="display:inline">supprimer ce type de réponse attendu</span>
				</li>			
			</div>
		<span id="writeplaceQual"></span>
		<img align="middle" src="add.png" style="cursor: pointer; cursor: hand;" onClick="PlusFields('Qual');">
		<span>Ajouter un type de réponse attendue</span>
		</div>		
			
		<div id="questQuantBlock">
			<div class="question" id="questQuant">	
						<li id="li_6" >
					<label class="description" for="element_6">variable </label>
					<div>
						<input id="element_6" name="element_6" class="element text small" type="text" maxlength="255" value=""/> 
					</div><p class="guidelines" id="guide_6"><small>Exemples : <br>N1<br>N1+N2<br>N1-N2 </small></p> 
					</li>		<li id="li_7" >
					<label class="description" for="element_7">mots clefs associés à cette variable </label>
					<div>
						<input id="element_7" name="element_7" class="element text medium" type="text" maxlength="255" value=""/> 
					</div> 
				</li>		<li id="li_8" >
				<label class="description" for="element_8">relations numériques (ne rien noter si la variable n'est pas inconnue) </label>
				<div>
					<input id="element_8" name="element_8" class="element text medium" type="text" maxlength="255" value=""/> 
				</div> 
			
				<img  src="del.png" style="cursor: pointer; cursor: hand;" onClick="supress(this);">
				<br>
				<span style="display:inline">supprimer ce type de réponse attendue</span>
			</div>
			<span id="writeplaceQuant"></span>
			
				<img align="middle" src="add.png" style="cursor: pointer; cursor: hand;" onClick="PlusFields('Quant');"><span>Ajouter un type de réponse attendue</span>
					
		</div>	
			</li>	<li id="li_9" >
			<label class="description" for="element_9">autres contraintes numériques sur le problème </label>

			<div>
				<input id="element_9" name="element_9" class="element text large" type="text" maxlength="255" value=""/> 
		</li>
			
					<li class="buttons">
			    <input type="hidden" name="form_id" value="470585" />
			    
				<input id="saveForm" class="button_text" type="submit" name="submit" value="Submit" />
		</li>
			</ul>
			
		</form>	
		<div id="footer">
			Generated by <a href="http://www.phpform.org">pForm</a>
		</div>
	</div>
	<img id="bottom" src="bottom.png" alt="">
	<script> 
	var Qqual=document.getElementById('questQualBlock');
	var Qquant=document.getElementById('questQuantBlock');
	
	var quanti=document.formulaire.element_3[0];
	var quali=document.formulaire.element_3[1]; 
	

	
	
	addEvent(quanti, 'click', function(e) {
		  Qquant.style.display="block";
		  Qqual.style.display="none";
		  //:"none"
		})
	
	addEvent(quali, 'click', function(e) {
		  Qquant.style.display="none";
		  Qqual.style.display="block";
		})
		
	/*
	var inputs=document.getElementsByTagName('input');
	for(var input in inputs){
		var divpart=(input.parentNode);
		if (divpart!=null )divpart=divpart.parentNode;
		if (divpart!=null )
		addEvent(divpart, 'blur', function(e) {
			liste.className="highlighted";
			})
			
	}
		
	*/
		</script> 
	</body>
</html>