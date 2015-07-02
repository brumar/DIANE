<?php
	require_once("verifSessionEleve.php");
	require_once("conn_pdo.php");
	require_once("ListFunction.php");

	if($_POST){
		if (isset($_POST['serie'])){ //On vient d'arriver sur la page depuis profil_eleve => Initialisation de la série d'exercices dans des variables $_SESSION
			// On créé les variables de session $_SESSION['passation']
			creerSessionPassation($_SESSION['numEleve'], $_POST['serie'], $bdd, "NOM"); 
		}
	}
	
	// On vérifie que les variables de session existent, sinon on redirige
	if(isset($_SESSION['passation'])){
		$problems = $_SESSION['passation']['allProblems'];
		$numSerie = $_SESSION['passation']['numSerie'];
		$nbExo = $_SESSION['passation']['nbExo']; //! à ne pas confondre avec numExo (id de l'exo). nbExo est le numéro dans l'ordre

		// On récupère l'exercice à utiliser maintenant
		$req = $bdd->prepare('SELECT * FROM pbm WHERE idPbm=?');

		if($req->execute(array($problems[$nbExo-1]))) { //On récupère l'id du problème et l'énoncé
			$enregistrement = $req->fetch();
			$numExo = $enregistrement['idPbm'];
			$enonce = $enregistrement['enonce'];
			//$type Problem ???
		}
		else{
			die("Erreur de Sélection du problème dans la base");
		}
		$req->closeCursor();

		// Variable pour savoir si presence audio ou pas
		$dirname = './audio/pbm_instancied/exo'.$numExo.'/';
		$audio=is_dir($dirname);
	}
	else{ //Pas de $_SESSION['passation']
		header("Location: profil_eleve.php");
		exit();
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>DIANE</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<script language="JavaScript" src="static/js/interface.js"></script>
		<link rel="stylesheet" type="text/css" href="static/css/interface.css">
	</head>
	<body>
	
		<form action="createTrace.php" name="info" method="post" onsubmit="return verifForm()" autocomplete="off">
			<table width="67%" align="center">
			<tr><td colspan="2"><table width="100%"  border="0">
			  <tr>
			    <td width="25%">
				<?php 
				/*if(isset($_GET["lienRetour"])) 
				{
				
				$varLien="interface.php?precedent=oui&numSerie=".$numSerie."&nbExo=".$nbExo."&numExo=".$numExo;
				echo("<input name=\"ExercicePrecedent\" type=\"button\" class=\"bouton\" value=\"Exercice pr&eacute;c&eacute;dent\" onClick=\"window.open('$varLien','Interface');\">");
				}*/
				?>
			    </td>
			    <td width="52%" align="center"><?php print(ucfirst($_SESSION['prenom'])."   ".strtoupper($_SESSION['nom']));?></td>
			    <td width="23%">&nbsp;</td>
			  </tr>
			</table></td></tr>
			      <tr>
			        <td width="41%" rowspan="3" valign="top"> 
				  <table width="440" border="0" cellspacing="2">
			        <tr>
				        <td width="434" colspan="2" align="center">
						    
						    <table width="97%" border="0" cellpadding="0" cellspacing="0">
						    	<tr>
						    		<td height="24" valign="top" class="aide">&nbsp;&nbsp; Exercice N°<?php echo ($nbExo); ?></td>
					        	</tr>
								  
						    	<tr>
							  	    <td>
										<table width="100%" border="2" align="center" cellpadding="2" cellspacing="0">
						                  <tr>
						                    <td>
											<?php
												$i=1;
												$id=0;
												$PUNCT_CHARS = "\n.?!;,\t\r\0\x0B";

												foreach(explode("\n", $enonce) as $line){
													foreach(explode(" ", $line) as $piece){
														$id++;
														$punctuation = strpbrk($piece, $PUNCT_CHARS);
														if($punctuation){ // Il y a un ou plusieurs signes de ponctuation
															$piece = trim($piece, $PUNCT_CHARS);
															if($a= strpos($piece, "\n")){
																print($a);
															}
															$punct = mb_substr($punctuation, 0, 1, 'utf-8');
														}
														else{
															$punct="";
														}

														print("<a href=\"javascript:;\" id=\"".$id."\" onClick=\"insererSas('".$piece." "."','".$i."');\" class=\"enonce\">".$piece."</a>".$punct." ");
														$i++;
													}
													echo("<br/>");
												}


											?>          
											</td>
						                  </tr>
						                </table>
									</td>
						     	</tr>

				             	<tr>
				                	<td height="27" valign="middle" class="aide">Pour &eacute;crire, tu peux cliquer sur les mots de l'&eacute;nonc&eacute;</td>
				            	</tr>
				          	</table>	      
				        </td>
			        </tr>
			        <tr>
			          <td width="434"   align="center">             
			            <table width="100%"  border="0">
			              <tr>
			                <td align="center"><input name="T1" type="text" size="65" style="font-size:10pt;"  <?php if (isset($precedent)) echo('value="'.$sas.'"'); else echo('value=""');?> class="champText" id="sas"
						  onFocus="monTour(5);colorFocus('sas');" 
						  onBlur="colorBlur('sas');"></td>
			              </tr>
			          </table>          </td>
			        </tr>   
				     <tr>
				       <td height="45" colspan="2" align="center">
				       <table width="100%"  border="0">
			             <tr>
			               <td width="28%" align="left"><input name="efface5" type="button" class="bouton"  onClick="document.info.T1.value='';document.info.T1.focus();" value="Effacer tout" style="width:110"></td>
			               <td width="24%" align="center"><input type="button" class="bouton" name="annuler2" value="Annuler" onClick="annulerSas();" style="width:70">                </td>
			               <td width="48%" align="right"><input name="button2" type="button" class="bouton"  onClick="inserer(document.info.T1.value);" 
					   value="Ecrire dans la feuille" style="width:200"
					   ></td>
			             </tr>
			           </table></td> 
			        </tr>
			       
			        <tr>
			          <td colspan="2" align="center"> 
					  <table width="151" height="153" align="<?php echo (($audio ? 'left' : 'center')); ?>">
			  <tr valign="middle">
			  <td colspan="4" align="center">
			  <span class="aide">Tu peux &eacute;crire tes calculs ici </span>
			  </td>
			  </tr>
			  <tr valign="middle">
			  <td colspan="4" align="center"><input name="egale2" type="button" class="Boutegal" onClick="if (tester == 5) {calculSas();} else {resultat();}" value=" = "></td>
			  </tr>
			<tr>
			  <td width="35" align="center" valign="middle"><input name="un" type="button" class="Boutcal" onClick="if (tester == 5) {insererSas('1');} else {afficher(1);}" value="1"></td>
			  <td width="27" align="center" valign="middle"><input name="deux" type="button" class="Boutcal" onClick="if (tester == 5) {insererSas('2');} else {afficher(2);}" value="2"></td>
			  <td width="27" align="center" valign="middle"><input name="trois" type="button" class="Boutcal" onClick="if (tester == 5) {insererSas('3');} else {afficher(3);}" value="3"></td>
			<td width="35" align="center" valign="middle">			
			  <input name="plus" type="button" class="Boutcal" onClick="if (tester == 5) {insererSas(' + ');} else if (tester == 1){afficher(' + ');};" value=" + "></td>
			</tr>
			<tr>
			  <td align="center" valign="middle"><input name="quatre" type="button" class="Boutcal" onClick="if (tester == 5) {insererSas('4');} else {afficher(4);}" value="4"></td>
			  <td align="center" valign="middle"><input name="cinq" type="button" class="Boutcal" onClick="if (tester == 5) {insererSas('5');} else {afficher(5);}" value="5"></td>
			  <td align="center" valign="middle"><input name="six" type="button" class="Boutcal" onClick="if (tester == 5) {insererSas('6');} else {afficher(6);}" value="6"></td>
			  <td align="center" valign="middle"><input name="moin" type="button" class="Boutcal" onClick="if (tester == 5) {insererSas(' - ');} else if (tester == 1){afficher(' - ');};" value=" - "></td>
			</tr>
			<tr>
			  <td align="center" valign="middle"><input name="sept" type="button" class="Boutcal" onClick="if (tester == 5) {insererSas('7');} else {afficher(7);}" value="7"></td>
			  <td align="center" valign="middle"><input name="huit" type="button" class="Boutcal" onClick="if (tester == 5) {insererSas('8');} else {afficher(8);}" value="8"></td>
			  <td align="center" valign="middle"><input name="neuf" type="button" class="Boutcal" onClick="if (tester == 5) {insererSas('9');} else {afficher(9);}" value="9"></td>
			  <td align="center" valign="middle"><input name="div" type="button" class="Boutcal"  id="div" onClick="if (tester == 5) {insererSas(' : ');} else if (tester == 1){afficher(' : ');};" value=" : "></td>
			</tr>
			<tr>
			  <td align="center" valign="middle"><input name="zero" type="button" class="Boutcal" onClick="if (tester == 5) {insererSas('0');} else {afficher(0);}" value="0"></td>
			  <td align="center" valign="middle"><input name="paro" type="button" class="Boutcal" onClick="if (tester == 5) {insererSas(' ( ');} else if (tester == 1){afficher(' ( ');};" value=" ( "></td>
			  <td align="center" valign="middle"><input name="parf" type="button" class="Boutcal" onClick="if (tester == 5) {insererSas(' ) ');} else if (tester == 1){afficher(' ) ');};" value=" ) "></td>
			  <td align="center" valign="middle"><input name="mult" type="button" class="Boutcal" id="mult" onClick="if (tester == 5) {insererSas(' x ');} else if (tester == 1){afficher(' x ');};" value=" x "></td>
			</tr>
			</table>

			<?php

				if($audio){
				$dir = opendir($dirname); 

				while($file = readdir($dir)) {
					if($file != '.' && $file != '..' && !is_dir($dirname.$file))
					{
						if(!preg_match("/QI/", $file))//cette condition permet d'enlever la question intermédiaire si elle n'est pas demandée //MMM ça risque de ne plus marcher j'ai de toute façon viré $questi
							{
							//echo '<a href="'.$dirname.$file.'">'.$file.'</a>';
							$filelist[] = $dirname.$file;
							}
					}
				}
				closedir($dir);
				sort($filelist);

				foreach ($filelist as $key=>$value) {
					$p1='<object data="dewplayer.swf" width="1" height="1" name="dewplayer" id="dewplayer'.$key.'"type="application/x-shockwave-flash">
					<param name="movie" value="dewplayer.swf" />
					<param name="flashvars" value="mp3=';
					$p2='&javascript=on" />
					<param name="wmode" value="transparent" />
					</object>';  
					echo ("$p1$value$p2");
				}
				echo('<table width="255" height="153" align="left">
				  <tr valign="middle">
					<td colspan="4" align="center"><span class="aide">Tu peux &eacutecouter les phrases en cliquant sur les images </span></td>
				  </tr>
				  <tr>
				  <div id="lecteurs">');
				foreach ($filelist as $key=>$value) {
					$p1='<tr><td align="right" valign="bottom"><p>partie '.($key+1).'<p></td>
						<td align="left" valign="top"><p><img style="cursor:pointer" id="player'.$key.'" src="static/images/play.png" />';
					$p2='</td></tr>';  
					   echo ("$p1$p2");
				}
				echo('</div>
				  </tr>
				  </table></div>');
				  }
			?>


			</td>



			        </tr>
			        </table></td>
			        <td width="59%" align="center" valign="top"><table width="100%"  border="0">
			          <tr>
			            <td height="22" colspan="3" class="aide">&Eacute;cris tes calculs et ta r&eacute;ponse dans cette feuille</td>
			          </tr>
			          <tr>
			            <td align="center"><input name="effacer" type="button" class="bouton" id="effacer2"
				  	onClick="document.info.zonetexte.value='';document.info.zonetexte.focus();" value="Effacer toute la feuille" style="width:150">            </td>
			            <td align="center"><input name="retour" type="button" class="bouton" onClick="inserer('\n');document.info.zonetexte.focus();" value="Passer &agrave; la ligne" style="width:115"></td>
			            <td align="center"><input name="annuler" type="button" class="bouton" id="annuler" 
				  		onClick="if (feuille.isContentEditable==true) annulerAction();" value="Annuler"></td>
			          </tr>
			          <tr align="center">
			            <td colspan="3" valign="middle"><textarea name="zonetexte" cols="45" rows="24" class="champText" id="feuille"
						 onFocus="colorFocus('feuille');" 
						 onBlur="colorBlur('feuille');"><?php if(isset($precedent)) echo($zoneTexte);?></textarea></td>
			          </tr>
			        </table></td>
			      </tr>
			  <tr>
			    <td align="center">
				  <p>
					<input name="button" type="submit" class="bouton" 
					style="width:240;" value="Exercice termin&eacute;">
				  </p>
				</td>
			  </tr>
			  <tr>
			    <td align="center" class="aide"><?php 
			$reste = $_SESSION['passation']['totalExo']-$nbExo;
			if($reste > 1){
			 echo ("Il te reste ".$reste." exercices.");
			}
			else if($reste == 1){
			 echo ("Il te reste ".$reste." exercice.");
			}
			else if($reste == 0){
			 echo ("C'est le dernier exercice."); 
			}
			?>  
			  <tr align="center">
			    <td height="21" colspan="2" valign="top"><a href="javascript:;" onClick="abandonner();">Quitter </a></td>
			</table>
			<input  name="Trace" type="hidden" id="formulaire">
			<input name="oper1" type="hidden">
			<input name="oper2" type="hidden">

			<script>
			//On supprime l'effet du retour arrière
			function suppressBackspace(evt) {
			    evt = evt || window.event;
			    var target = evt.target || evt.srcElement;

			    if (evt.keyCode == 8 && !/input|textarea/i.test(target.nodeName)) {
			        return false;
			    }
			}

			document.onkeydown = suppressBackspace;
			document.onkeypress = suppressBackspace;

			/*******PARTIE PERMETTANT L ENREGISTREMENT DES ACTIONS********        DEBUT*/
				
				var formulaire = document.getElementById('formulaire');
				var lecteurs = document.getElementsByTagName('img');
				var inputs = document.getElementsByTagName('input');
				
				//on fait une liste des mots du texte
				var k=0;
				var TabWords = new Array();
				while(k<<?php echo($id); ?>){
				if(document.getElementById(k)!=null){
				TabWords.push(document.getElementById(k));}
				k++;
			}


			for (var i = 0, c = lecteurs.length ; i < c ; i++) {
			//on ajoute à toutes les images une fonction qui mémorise le temps des clics dessus
			   addEvent(lecteurs[i], 'click', function(e) {
			   
			   time=((new Date).getTime()-date_init);
			   var target = (e.srcElement || e.target);
				
				//target.dewplay();
				var id=target.id;
				
				var string='***'+time+'//'+id;
				trace_utilisateur+=string;
				document.getElementById('formulaire').value=trace_utilisateur;
				var playerid="dew"+id;
				document.getElementById(playerid).dewplay();
			    });
			}

			for (var i = 0, c = inputs.length ; i < c ; i++) {//on ajoute à tous les boutons une fonction qui mémorise le temps des clics dessus
			   //objects
			   
				addEvent(inputs[i], 'click', function(e) {
			    time=((new Date).getTime()-date_init);
				var target = e.srcElement || e.target;
				var string='***'+time+'//'+target.name;//cette fois ci on prend le name
				trace_utilisateur+=string;
				formulaire.value=trace_utilisateur;
			    });
			}

			for (var i = 0, c = TabWords.length ; i < c ; i++) {//on ajoute à tous les mots une fonction qui mémorise le temps des clics dessus
			   //objects
			   addEvent(TabWords[i], 'click', function(e) {
			   time=((new Date).getTime()-date_init);
			   var target = e.srcElement || e.target;
				var string='***'+time+'//'+target.id;//cette fois ci on prend l id
				trace_utilisateur+=string;
				formulaire.value=trace_utilisateur;
			    });
			}
			
			window.onload = function WindowLoad() {
				 trace_utilisateur='';
				 tester = 5;
				 date_init=(new Date).getTime();
			}
			</script>

		</form>
	</body>
</html>