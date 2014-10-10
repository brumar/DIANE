<?php echo '<?xml version="1.0" encoding="iso-8859-15"?>'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title>AJAX : Exemple de client</title>
<script type="text/javascript" src="exemple_1.js"></script>
</head>
<body>
<p>
<a href="" onclick="gestionClic(); return false;">Cliquez ici !</a>
(Nombre de clics : <span id="nbr_clics">
<?php
    $str = @file_get_contents('exemple_1.data');
    if($str !== FALSE)
        echo unserialize($str);
    else
        echo 0;
?>
</span>)
</p>
</body>
</html>
