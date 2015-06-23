<?php
	require_once("verifSessionProf.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body id="main_body" >
<?php include("headerEnseignant.php"); ?>
<form name="form2pbmcreation" method="post" action="ProblemCreation.php">
	<input id="element_8" type="hidden" name="infos" type="text" maxlength="255" value=""/> 
</form>

<?php
if (isset($_GET["id"])){
	
	$id=$_GET["id"];
	include("opening.php");
	if(isset($infos['questions'][0][3][0])){echo("ok");}
	echo("<script type=\"text/javascript\">
	document.form2pbmcreation.infos.value=\"$infosHtmlProtected\";
	document.form2pbmcreation.submit();	
		</script>");
	//print_r($infos);
	
}
?>
</body>