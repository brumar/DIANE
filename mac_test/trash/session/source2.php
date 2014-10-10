<?
  session_start();
  $session_login=$_POST['login'];
  session_register("session_login");
?>
<html>
<head>
<title>verification de session</title>
</head>
<body>
verification de la session
<?
echo ("login transmis : ".$_SESSION['session_login']) ;
?>
 <a href="source3.php">passer à la page suivante
</body>
</html>

