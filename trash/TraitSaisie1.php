<!doctype html public "-//W3C//DTD HTML 4.0 //EN"> <html><head>
<title>Traitement Formulaire</title></head><body>
<?php
     $c1 = $_POST[enonce1];
     $c2 = $_POST[enonce2];
     echo$c1;
     echo $c2;
     //extraction des mot du text, scinde la phrase grace aux virgules et espacements
     // ce qui inclus les " ", \r, \t, \n et \f

     $tabMot = preg_split ("/[\s,.,-]+/", $c1);
     $tabMot2 = preg_split ("/[\s,.,-]+/", $c2);
     //recherche les nombre dans le tableau tabMot
     $res = preg_grep("/\d/", $tabMot);
     $res2 = preg_grep("/\d/", $tabMot2);
     //trie du tableau  $res
     sort($res);
     sort($res2);
     $partie1= $res[0];
     $tout1= $res[1];
     //$partie2= $res[1]-$res[0];
     $partie2= $tout1-$partie1;
     if ($_POST[typePB]=="e")
     {
         if ($_POST[question]=="p")
           {
             $tout2=$res2[0];
             $partie3=$tout2-$partie2;
             //ou bien $partie3=$tout2-$tout1+$partie1;
           }
         elseif ($_POST[question]=="t")
            {
              $partie3=$res2[0];
              $tout2=$partie2+$partie3;
              //ou bien $tout2=$tout1+($partir3-$partie1);
            }
      }
      elseif ($_POST[typePB]=="a")
      {
          if ($_POST[question]=="p")
             {
               $valdiff = $res2[0];
               $tout2 = $tout1-$valdiff;
               $partie3 = $tout2-$partie2;
               //ou bien $partie3 = $partie1-$valdiff;
             }
          elseif ($_POST[question]=="t")
             {
               $partie3=$res2[0];
               $tout2=$partie2+$partie3;
               //ou bien $tout2 = $tout1-$valdiff;
             }
      }
?>
<table border="1">
<tr>
    <td>Enoncé1</td>
    <td>question1</td>
    <td>Enoncé2</td>
    <td>Question2</td>
    <td>Partie1</td>
    <td>Partie2</td>
    <td>Tout1</td>
    <td>partie3</td>
    <td>Tout2</td>
    <td>Variable</td>
    <td>Type de probleme</td>
    <td>Question</td>
    <?php
    if ($_POST[typePB]=="a")
    {
    echo "<th>valeur de la difference</th>";
    }
    ?>
</tr>
<tr>
    <td><?php echo $c1; ?></td>
    <td><?php echo $_POST[question1]; ?></td>
    <td><?php echo $c2; ?></td>
    <td><?php echo $_POST[question2]; ?></td>
    <td><?php echo $partie1;?></td>
    <td><?php echo $partie2; ?></td>
    <td><?php echo $tout1; ?></td>
    <td><?php echo $partie3; ?></td>
    <td><?php echo $tout2; ?></td>
    <td><?php echo $_POST[variable]; ?></td>
    <td><?php echo $_POST[typePB]; ?></td>
    <td><?php echo $_POST[question];?></td>
    <?php
    if ($_POST[typePB]=="a")
    {
    echo "<th>".$valdiff."</th>";
    }
    ?>
</tr>
</table>
</body>
</html>


