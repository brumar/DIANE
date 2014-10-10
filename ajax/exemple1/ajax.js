var xhr = null;

//Créons une fonction de création d'objet XMLHttRequest
function get_Xhr()
 {
  if(window.XMLHttpRequest)
   {
    xhr = new XMLHttpRequest();
   }
  else if(window.ActiveXOject)
   {
    try
     {
      xhr = new ActiveXObject("Msxml2.XMLHTTP");
     }
    catch(e)
     {
      try
       {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
       }
      catch(el)
       {
        xhr = null;
       }
     }
   }
  else
   {
    alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest\nVeuillez le mettre à jour");
   }
  return xhr;
 
 }
 
 function ajaxiris(fam)
 {
  // Creation de l'objet XMLHttpRequest
  get_Xhr();
  xhr.onreadystatechange = function()
   {
    if(xhr.readyState == 4 && xhr.status == 200)
     {
      // Que fera AJAX si tout se passe bien, il va inserer dans le div "iris" le resultat de la page appellée
      document.getElementById('iris').innerHTML = xhr.responseText;
     }
   }
  // Nous allons interroger ajaxiris.php pour recuperer la reponse
  xhr.open("POST",'ajax/ajaxiris.php',true);
  xhr.setRequestHeader('Content-Type','x-www-form-urlencoded');
  // Nous envoyons à ajaxiris.php la valeur du radio
  xhr.send("type="+fam);
 }
 function verifnserie()
 {
  get_Xhr();
  xhr.onreadystatechange = function()
   {
    if(xhr.readyState == 4 && xhr.status == 200)
     {
      document.getElementById('affnserie').innerHTML = xhr.responseText;
     }
   }
  xhr.open("POST",'ajax/verifnserie.php',true);
  xhr.setRequestHeader('Content-Type','x-www-form-urlencoded');
  // Nous recuperons la valeur du input nserie et du input fournisseur
  valnserie = document.getElementById('nserie').value;
  fourn = document.getElementById('fournisseur').value;
  // Et on l'envoie à verifnserie.php
  xhr.send("nserie="+valnserie+"fournis="+fourn);
 }

function ajaxcdcl
 {
  get_Xhr();
  xhr.onreadystatechange = function()
   {
    if(xhr.readyState == 4 && xhr.status == 200)
     {
      // Ce coup ci on ne travaille pas sur la requete mais sur la reponse
      // Du coup on n'affiche pas directement le resultat mais on le recupere dans une variable
      var chaine = xhr.ResponseText;
      // On decoupe la chaine pour recuperer les valeurs
      var tableau = chaine.split('£');
      // Nous appliquons les valeurs récupérées aux elements correspondants
      document.getElementById('revendeur').value = tableau[0];
      document.getElementById('adresserev').value = tableau[1];
      document.getElementById('coderev').value = tableau[2];     
     }
   }
  xhr.open("POST",'ajax/ajaxrecupaddr.php',true);
  xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
  cdcl = document.getElementById('cdcl').value;
  xhr.send("cdcl="+cdcl);
 }