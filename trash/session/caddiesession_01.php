<?php
    // Dans ce script nous utilisons les sessions
    session_start();

    // Chargement du caddie
    if (isset($_SESSION["caddie"])) {
        $caddie = $_SESSION["caddie"];
    } else {
        $caddie = array();
    }     
    
    if ($_GET["action"]=="destroy") {
        // on a demander à tout supprimer
        session_destroy();
        header("Location: ".$_SERVER["PHP_SELF"]);
        die();
    }

    if (isset($_GET["raz"])) {
        // On a demandé à reinitialiser une valeur
        switch ($_GET["raz"]) {
            case "pomme":
                unset($caddie["pommes"]);
                break;
            case "poire":
                unset($caddie["poires"]);
                break;
            case "banane":
                unset($caddie["bananes"]);
                break;
            }
        // "sauvegarde" des modifications    
        $_SESSION["caddie"] = $caddie;    
        header("Location: ".$_SERVER["PHP_SELF"]);
        die();
    }
    
    if (isset($_GET["achat"])) {
        // On a demandé à incrémenter une valeur    
        switch ($_GET["achat"]) {
            case "pomme":
                $caddie["pommes"]++;
                 break;
            case "poire":
                $caddie["poires"]++;
                 break;
            case "banane":
                $caddie["bananes"]++;
                 break;
        }
        // "sauvegarde" des modifications    
        $_SESSION["caddie"] = $caddie;
        header("Location: ".$_SERVER["PHP_SELF"]);
        die();
   }     
?>
Nb Pommes:<?php echo $caddie["pommes"];?><br />
<a href="<?php echo $_SERVER["PHP_SELF"];?>?achat=pomme">Acheter une pomme</a>
<a href="<?php echo $_SERVER["PHP_SELF"];?>?raz=pomme">RAZ</a><br />

Nb Poires:<?php echo $caddie["poires"];?><br />
<a href="<?php echo $_SERVER["PHP_SELF"];?>?achat=poire">Acheter une poire</a>
<a href="<?php echo $_SERVER["PHP_SELF"];?>?raz=poire">RAZ</a><br />

Nb Bananes:<?php echo $caddie["bananes"];?><br />
<a href="<?php echo $_SERVER["PHP_SELF"];?>?achat=banane">Acheter une banane</a>
<a href="<?php echo $_SERVER["PHP_SELF"];?>?raz=banane">RAZ</a><br />

<br/>
<a href="<?php echo $_SERVER["file:///G|/Documents%20and%20Settings/hk/Bureau/PHP_SELF"];?>?action=destroy">Détruire la session</a><br/>

         
