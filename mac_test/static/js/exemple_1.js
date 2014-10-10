var http; // Notre objet XMLHttpRequest

function createRequestObject()
{
    var http;
    if(window.XMLHttpRequest)
    { // Mozilla, Safari, ...
        http = new XMLHttpRequest();
    }
    else if(window.ActiveXObject)
    { // Internet Explorer
        http = new ActiveXObject("Microsoft.XMLHTTP");
    }
    return http;
}

function gestionClic(v1,v2,v3)
{
   // document.getElementById('nbr_clics').innerHTML = '<em>Chargement...</em>';
    http = createRequestObject();
    http.open('get', 'traitement_recup_exo.php?numEleve='+v1+'&id='+v2+'&numSerie='+v3, true);
    http.onreadystatechange = handleAJAXReturn;
    http.send(null);
}

function handleAJAXReturn()
{
    if(http.readyState == 4)
    {
        if(http.status == 200)
        {
            //document.getElementById('nbr_clics').innerHTML = http.responseText;
			//document.getElementById('serie1').value= http.responseText;
			window.open(http.responseText,'Interface','fullscreen,toolbar=no,location=no,directories=no,menuBar=no,scrollbars=no,resizable=no,status=no');
        }
        else
        {
            document.getElementById('nbr_clics').innerHTML = "<strong>N/A</strong>";
        }
    }
}
function rafrechir()
{
window.location.replace("../ajax/traitement_recup_exo.php");
}