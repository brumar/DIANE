<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Choix des pbms</title>
<link rel="stylesheet" type="text/css" href="static/css/view.css" media="all">
</head>

<body id="main_body" >
	<img id="top" src="static/images/top.png" alt="">
	<div id="form_container">
	<h1><a>Untitled Form</a></h1>
	<h2>Choisissez vos problèmes</h2>
	<form action="TraitSerie_D2.php" method="post" class="appnitro">
	<ul>
<li id="li_999" >
					<label class="description" for="element_999">Nom de la série </label>
					<div>
						<input id="element_999" name="name" class="element text large" type="text" maxlength="255" value="<?php if (isset($name)){echo($keywords);}?>"/> 
					</div><p class="guidelines" id="guide_999"><small>Indiquez le nom de la série pour que vous puissiez la retrouver plus tard </small></p> 
				</li>
				
<li id="li_998" >
					<label class="description" for="element_998">Commentaire associée à la série </label>
					<div>
						<textarea id="textarea" name="comments" class="element textarea small"  ></textarea>
					</div><p class="guidelines" id="guide_998"><small>Indiquez le nom de la série pour que vous puissiez la retrouver plus tard </small></p> 
				</li>
				
</ul>		
    <ul>
    <?php
    $self=$_SERVER['PHP_SELF'];
    require_once("conn.php");
  
    if (isset($_GET['page'])){$page=$_GET['page'];}
    if (isset($_GET['total'])){ $total=$_GET['total'];}
  
    $limText=110;
	$nb=30;
	if(empty($page)) $page = 1;
	if(empty($total)){ // nombre total de résultats
 	$sql1 = "SELECT * FROM pbm_instancied";
 	$total=mysql_num_rows(mysql_query($sql1));
 	//$total = @mysql_result($p,"0","qte");
	}

	// on determine debut du limit
	$debut = ($page - 1) * $nb;

  $sql = "SELECT * FROM pbm_instancied order by numero desc LIMIT $debut,$nb";

  $result = mysql_query($sql) or die ("Requête incorrecte");
  // = mysql_numrows($query);
  if ($result) { // Si il y'a des résultats
 // while ($rs = mysql_fetch_array($query)) {
 $t=0;
  while ($enregistrement = mysql_fetch_assoc($result))
		{
		  $text1 =  $enregistrement["text"];
		  $id= $enregistrement["numero"];
		  if(strlen($text1)>$limText){$text1=substr($text1,0,$limText).'[...]';}
?>
	<li id="li_<?php echo($t);$t++;?>">
			<div class="commandWrap">
				<div style="width:10px;display:inline-block;margin:0 5px 20px 0px;vertical-align:middle">
					<input type=checkbox name="id<?php echo($id);?>" value="<?php echo($id);?>">
				</div>
				<div style="width:280px;display:inline-block;margin:0 0 5px 40px;padding:10px;border:1px solid black"> 
					  <?php echo(( $text1)); ?>
				</div>
			</div>
				
	 </li>
    <?php
        } // Fin instruction while

      } else { // Pas de résultat trouvé

    echo "Pas de résultat";

      }
      
?></ul>
			
<input type="submit" value="valider">
  <p>
    <?php
	// calcul du nombre de pages
 	$nbpages = ceil($total / $nb); // arrondi a l'entier superieur
 	// on affiche les pages
 	for($i = 1;$i <= $nbpages;$i ++)
	{
		if ($i==1){echo("<h4>pages</h4>");}
 	   echo "<a href=\"$self?page=$i&total=$total\">$i</a>";
       if($i < $nbpages) echo " - ";
    }
  mysql_free_result($result); // Libère la mémoire
  mysql_close(); // Ferme la connexion
 ?>
  </p>
  </form>
</div>
  

<img id="bottom" src="static/images/bottom.png" alt="">
</body>
</html>
