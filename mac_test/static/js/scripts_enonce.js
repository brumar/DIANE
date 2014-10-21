

function addEvent(element, event, func) {
	if (element.addEventListener) { // Si notre élément posséde la méthode addEventListener()
        element.addEventListener(event, func, false);
		} else { // Si notre élément ne posséde pas la méthode addEventListener()
	//alert(element);
        element.attachEvent('on' + event, func);
    }
}
function insertTag(startTag, endTag, textareaId, tagType) {
    var field  = document.getElementById(textareaId); 
    var scroll = field.scrollTop;
    field.focus();
    var spaceBefore="";
    var spaceAfter="";
        
    if (window.ActiveXObject) { // C'est IE
        var textRange = document.selection.createRange();            
        var currentSelection = textRange.text;
        
        if(currentSelection.charAt(0)==" "){ // we detect spaces in the selection in order to put them out
        	spaceBefore=" ";
        	currentSelection=currentSelection.substr(1);
        	}
        if(currentSelection.charAt(currentSelection.length-1)==" "){
        	spaceAfter=" ";
        	currentSelection=currentSelection.substring(0,currentSelection.length-1);
        	}
                
        textRange.text = spaceBefore+ startTag  + currentSelection  + endTag + spaceAfter ;
        textRange.moveStart("character", -endTag.length - currentSelection.length);
        textRange.moveEnd("character", -endTag.length);
        textRange.select();     
    } else { // Ce n'est pas IE
        var startSelection   = field.value.substring(0, field.selectionStart);
        var currentSelection = field.value.substring(field.selectionStart, field.selectionEnd);
       
        if(currentSelection.charAt(0)==" "){ 
        	spaceBefore=" ";
        	currentSelection=currentSelection.substr(1);
        	}
        if(currentSelection.charAt(currentSelection.length-1)==" "){
        	spaceAfter=" ";
        	currentSelection=currentSelection.substring(0,currentSelection.length-1);
        	}

        var endSelection     = field.value.substring(field.selectionEnd);          
        field.value = startSelection + spaceBefore+ startTag  + currentSelection  + endTag + spaceAfter + endSelection;
        field.focus();
        field.setSelectionRange(startSelection.length + startTag.length, startSelection.length + startTag.length + currentSelection.length);
    } 

    field.scrollTop = scroll; // et on redéfinit le scroll.
}

function GoToInsertion(){
	//alert("blabla");
	document.formulaireEnvoi.enonce.value=document.getElementById('textarea').value;
	document.formulaireEnvoi.action.value="Insertions_Perso.php";
	document.formulaireEnvoi.submit();
}
function GoToProblemCreation(){
	document.formulaireEnvoi.enonce.value=document.getElementById('textarea').value;
	document.formulaireEnvoi.action.value="ProblemCreation.php";
	document.formulaireEnvoi.submit();
}
