<?
session_start();
?>

<html>
<head>
<title>enregistrement de session</title>
</head>
<body>
valeur de la variable de session
<?
echo ("login=".$_SESSION['session_login']);
?>

