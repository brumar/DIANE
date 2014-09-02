<html>
<head>
<title>Ajouter du texte au milieu d'un textarea</title>
</head>
<body>
<form name="poster"
   onSubmit="alert('Script by iubito\nhttp://iubito.free.fr\niubito@asp-php.net');return false;">
<p>Mise en forme du texte :
   <a href="javascript:AddText('[url]','URL','[/url]');">URL</a>
   | <a href="javascript:AddText('[email]','email@email.fr','[/email]');">Email</a>
   | <a href="javascript:AddText('[b]','Texte en gras','[/b]');">Gras</a>
   | <a href="javascript:AddText('[i]','Texte en italique','[/i]');">Italique</a>
   | <a href="javascript:AddText('[u]','Texte souligné','[/u]');">Souligné</a>...
<br>
Smileys :
   <a href="javascript:AddText('',':)','');">Content</a>
   | <a href="javascript:AddText('',':(','');">Pas content</a>
   | <a href="javascript:AddText('','8o)','');">Faire le clown</a>
   | <a href="javascript:AddText('',';-D','');">LOL</a>...
</p>
<script language="JavaScript" type="text/javascript">
function storeCaret(text)
{ // voided
}

function AddText(startTag,defaultText,endTag)
{
 if (document.poster.message.createTextRange)
 {
 //	alert(document.poster.message.focus(document.poster.message.caretPos));
  var text;
  document.poster.message.focus(document.poster.message.caretPos);
  document.poster.message.caretPos = document.selection.createRange().duplicate();
//alert(document.poster.message.caretPos.text.length); 
  if(document.poster.message.caretPos.text.length>0)
  {
	   alert(document.poster.message.caretPos.text); 
	   document.poster.message.caretPos.text = startTag + document.poster.message.caretPos.text + endTag;
  }
  else
  {
	  alert(document.poster.message.caretPos.text.length); 
	  document.poster.message.caretPos.text = startTag+defaultText+endTag;
  }
 }
 else document.poster.message.value += startTag+defaultText+endTag;
}
</script>

<textarea
   rows='8'
   cols='30'
   name=message
   wrap=virtual
   onmouseover="this.focus();"
   onkeyup="javascript:storeCaret(this);"
   onclick="javascript:storeCaret(this);"
   onchange="javascript:storeCaret(this);">
</textarea><br>
<input type="submit" name="soumettre" value="envoyer">
</form>
</body>
</html>
