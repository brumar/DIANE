<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Creation de problème</title>
<link rel="stylesheet" type="text/css" href="view.css" media="all">
</head>

<body id="main_body" >
	<img id="top" src="static/images/top.png" alt="">
	<div id="form_container">
	<h1><a>Untitled Form</a></h1>
	<h2>Liste des énoncés</h2>
	<form action="selection.php" method="post" class="appnitro">
    <ul>
    <?php
    include("ListFunction.php");
   
    $self=$_SERVER['PHP_SELF'];
    require_once("conn.php");
  
    if (isset($_GET['page'])){$page=$_GET['page'];}
    if (isset($_GET['total'])){ $total=$_GET['total'];}
  
  
	$nb=6;
	if(empty($page)) $page = 1;
	if(empty($total)){ // nombre total de résultats
 	$sql1 = "SELECT * FROM pbm_globalcontent";
 	$total=mysql_num_rows(mysql_query($sql1));
 	//$total = @mysql_result($p,"0","qte");
	}

	// on determine debut du limit
	$debut = ($page - 1) * $nb;

  $sql = "SELECT * FROM pbm_globalcontent order by id desc LIMIT $debut,$nb";

  $result = mysql_query($sql) or die ("Requête incorrecte");
  // = mysql_numrows($query);
  if ($result) { // Si il y'a des résultats
 // while ($rs = mysql_fetch_array($query)) {
 $t=0;
  while ($enregistrement = mysql_fetch_assoc($result))
		{
		  $text1 =  $enregistrement["Text_html"];
		  $id= $enregistrement["id"];
?>
	<li id="li_<?php echo($t);$t++;?>">
	<div style="width:350px;display:inline-block;margin:0 0 5px 40px;padding:10px;border:1px solid black"> 
	  <?php echo( $text1); ?>
	 </div>
	 <div style="width:70px;display:inline-block;margin:0 0 5px 40px">
	 <input type="button" value="copier ce modèle" id="Quest" onClick="parent.location='openPbm.php?id=<?php echo($id);?>'"/>
	 </div></li>
    <?php
        } // Fin instruction while

      } else { // Pas de résultat trouvé

    echo "Pas de résultat";

      }
?></ul>
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
  <p><a href="ProblemCreation.php">Créer un nouvel exercice</a></p>
  <p><a href="ProblemCreation.php">Retour</a></p>
</div>
  
</form>
<img id="bottom" src="static/images/bottom.png" alt="">
</body>
</html>
