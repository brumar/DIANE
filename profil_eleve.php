<?php
	require_once("verifSessionEleve.php");
	require_once("conn_pdo.php");
?>
<!DOCTYPE html>


<html>
	<head>
		<title>DIANE - élève</title>
		<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
		<link rel="stylesheet" href="static/css/default.css" />
		<script language="javascript"> 
			function redirectJS(idSerie){
				var c = document.getElementById('choix_serie');
				c.value = idSerie;
				var myform = document.getElementById('form_choix_serie');
				myform.submit();
			}
		</script>
	</head>
	<body>
		<div>
			<?php 
				echo "Bonjour ".$_SESSION['prenom']." ".$_SESSION['nom']. "!<br/>";
				echo "Choisis une série de problèmes :<br/>";?>

			<div>
				<?php
				if($rep = $bdd->query('SELECT nomSerie, idSerie FROM serie ORDER BY ordrePres')){
					while ($r = $rep->fetch()){
						echo "<input type=\"button\" class=\"serie_choice\" value=\"".$r['nomSerie']."\""." onclick=\"redirectJS(".$r['idSerie'].")\"/><br/>";
					}
				}
			?>
			<form action="interface.php" method="post" id="form_choix_serie">
				<input type="hidden" id="choix_serie" name="serie" value="-1">
			</form>
			</div>
		</div>
	</body>
</html>