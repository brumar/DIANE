<?php
  require_once("verifSessionProf.php");
  require_once("ListFunction.php");
  require_once("conn_pdo.php");
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
		<title>Choix d'un problème</title>
		<link rel="stylesheet" type="text/css" href="static/css/view.css" media="all">
	</head>

	<body id="main_body" >
		<?php include("headerEnseignant.php"); ?>
		<img id="top" src="static/images/top.png" alt="">
		<div id="form_container">
		<h1><a>Untitled Form</a></h1>
		<h2>Liste des énoncés</h2>
			<div>
				Montrer les exercices qui ont la propriété :
				<select name="sort_property" id="sort_property" onchange="propertySort()">
					<option value="none">...</option>
					<?php
						// $exoProperties = $bdd->query('SELECT id, name FROM properties WHERE tri_prof = 1 ORDER BY id');

						if($_SESSION['accountType'] == "enseignant"){
							$exoProperties = $bdd->query('SELECT id, name FROM properties WHERE tri_prof = 1 AND type = "problem" ORDER BY id');	
						}
						elseif($_SESSION['accountType'] == "chercheur"){
							$exoProperties = $bdd->query('SELECT id, name FROM properties WHERE type = "problem" ORDER BY id');
						}
						
						foreach($exoProperties->fetchall() as $property){
							echo "<option value =\"".$property['id']."\">".$property['name']."</option>";
						}

					?>
				</select>
			</div>


		<form action="selection.php" method="post" class="appnitro">
			<ul>
			<?php
			$self=$_SERVER['PHP_SELF'];
			require_once("conn_pdo.php");


			/*
			// Gestin des pages
			if (isset($_GET['page'])){$page=$_GET['page'];}
			if (isset($_GET['total'])){ $total=$_GET['total'];
			$nb=6;
			if(empty($page)) $page = 1;
			if(empty($total)){ // nombre total de résultats
				$res = $bdd->query("SELECT * FROM pbm_template");
				$total = $res->rowCount();
				//$total = @mysql_result($p,"0","qte");
			}
			// on determine debut du limit
			$debut = ($page - 1) * $nb;
			$result = $bdd->query("SELECT * FROM pbm_template order by id desc LIMIT ".$debut.", ".$nb);
			*/


			$result = $bdd->query("SELECT * FROM pbm_template WHERE visible=1 order by id desc");
				
			if ($result) { // Si il y'a des résultats
			// while ($rs = mysql_fetch_array($query)) {
				$t=0;
				while ($enregistrement = $result->fetch())
				{
					// On récupère les propriétés du template

					$listPropertiesId = null;
					$properties = get_value_BDD('properties', 'pbm_template', 'id = ?', array($enregistrement['id']), $bdd);

					if($properties != null){
						$prop_names = explode("|||", $properties);

						foreach($prop_names as $name){
							$propId = get_value_BDD('id', 'properties', 'name=?', array($name), $bdd);
							$listPropertiesId[] = $propId;
						}
					}


					$template_description = $enregistrement["public_notes"];
					$text1 =  $enregistrement["Text_html"];
					$id= $enregistrement["id"];
					
					echo "<li id=\"li_".$t."\" class=\"templateDisplayed";
					$t++;

					if($listPropertiesId != null){
						foreach($listPropertiesId as $propId){
							echo " t_".(string)$propId;
						}
					}
					echo "\">";
					?>


						<div>
							<span class="template_description">
							<?php echo $template_description;?>
							</span>
						</div>
						<div style="width:350px;display:inline-block;margin:0 0 5px 40px;padding:10px;border:1px solid black"> 
							<?php echo( $text1); ?>
						</div>
						<div style="width:70px;display:inline-block;margin:0 0 5px 40px">
							<input type="button" value="utiliser ce modèle" id="Quest" onClick="parent.location='generer_probleme.php?id=<?php echo($id);?>'"/>
						</div>
					</li>
					<?php
					} // Fin instruction while

				} else { // Pas de résultat trouvé
					echo "Pas de résultat";
			}
			?></ul>
			
			<p>
				<?php
					/*					
						// calcul du nombre de pages
						$nbpages = ceil($total / $nb); // arrondi a l'entier superieur
						// on affiche les pages
						for($i = 1;$i <= $nbpages;$i ++)
						{
							if ($i==1){echo("<h4>pages</h4>");}
								echo "<a href=\"$self?page=$i&total=$total\">$i</a>";
							if($i < $nbpages) echo " - ";
						}
						$result->closeCursor();
					*/
				?>
			</p>
			<p><a href="creation_template.php">Créer un nouvel exercice</a></p>
			<p><a href="creation_template.php">Retour</a></p>
			</div>

		</form>

		<script type="text/javascript">
			function propertySort(){
				var sort_property = document.getElementById("sort_property");				
				var templatesDisplayed = document.getElementsByClassName('templateDisplayed');


				if(sort_property.value == "none"){
					for (index = 0; index < templatesDisplayed.length; ++index) {
						templatesDisplayed[index].style.display = "block";
					}
				}
				else{
					for (index = 0; index < templatesDisplayed.length; ++index) {

						var all_class = (templatesDisplayed[index]).className;
						var lookFor = "t_"+String(sort_property.value);
						
						if (all_class.indexOf(lookFor) > -1){
							templatesDisplayed[index].style.display = "block";
						}
						else{
							templatesDisplayed[index].style.display = "none";	
						}
					}
				}
			}
		</script>
	</body>
</html>
