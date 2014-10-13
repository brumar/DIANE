function accessProperties(element){
	
	var idquest=element.parentNode.parentNode.id;
	var idform=idquest.replace('quest', 'form');
	var form=document.getElementById(idform);
	var Number=idform.replace('form','');
	
	var Mainform=document.mainform;
	Mainform.clickedProp.value=Number;//pour faire en sorte de récupérer le numéro du type de réponse attendue par $_POST['clickedProp']
	Mainform.submit();
	/*
	if(Number=='0'){Number='';}
	var target='variable : '+ document.getElementById('element_1'+Number).value+'<br> mots clefs : '+ document.getElementById('element_2'+Number).value;
	alert(f1);
	//form.id=idform.replace('form','');
	var n=form.ident.value;
	form.ident.target;
	//actualiser les valeurs
	//submit
	*/
}

function AnswerTest(){
	
	var Mainform=document.mainform;
	Mainform.clickedProp.value="test";//pour faire en sorte de récupérer le numéro du type de réponse attendue par $_POST['clickedProp']
	Mainform.submit();
	/*
	if(Number=='0'){Number='';}
	var target='variable : '+ document.getElementById('element_1'+Number).value+'<br> mots clefs : '+ document.getElementById('element_2'+Number).value;
	alert(f1);
	//form.id=idform.replace('form','');
	var n=form.ident.value;
	form.ident.target;
	//actualiser les valeurs
	//submit
	*/
}

function addEvent(element, event, func) {

    
	if (element.addEventListener) { // Si notre élément posséde la méthode addEventListener()
        element.addEventListener(event, func, false);
    } else { // Si notre élément ne posséde pas la méthode addEventListener()
	//alert(element);
        element.attachEvent('on' + event, func);
    }

}

function printQuestionForm(){
	alert('ok');//element.name)
	
}


counter=0;


function PlusFields() {
	var identifiant='quest0';
	var writePlace='writeplace';
	counter++;
	var clone = document.getElementById(identifiant).cloneNode(true);
	clone.id = 'quest'+counter;
	clone.style.display = 'block';
	RecurciveIdUpdate(counter,clone);
	var insertHere = document.getElementById(writePlace);
	insertHere.parentNode.insertBefore(clone,insertHere);
	
	
	//creation d'un formulaire d'envoi vers les propriétés
	var form='form'+counter;
	if(!document.getElementById(form)){
		
		myform=document.createElement("form");
		myform.id=form;
		//myform.name='R'+form;
		myform.name=form;
		var insertForm = document.getElementById("formPlace");
		var infos="HereINFOS";//TODO -> MODIFIER
		var target="HereTarget";//TODO -> MODIFIER
			
		myform.action= "properties.php";
		myform.method = "POST";
		//var Element1 = document.createElement("<input name=\"id\" value='"+counter+"' type='hidden'>");
		var Element1 = document.createElement("input");
		Element1.name= "ident"+counter;
		Element1.value=counter;
		Element1.type='hidden';
		myform.appendChild(Element1);
		
		var Element2 = document.createElement("input");
		Element2.name= "infos"+counter;
		Element2.value=counter;
		Element2.type='hidden';
		myform.appendChild(Element2);
		
		var Element3 = document.createElement("input");
		Element3.name= "target"+counter;
		Element3.value=counter;
		Element3.type='hidden';
		myform.appendChild(Element3);
	
		insertForm.parentNode.insertBefore(myform,insertForm);
		
	}
		
		
}

function RecurciveIdUpdate(compteur,element){
	
	var newField = element.childNodes;
	for (var i=0;i<newField.length;i++) {
		var theName = newField[i].name;
		if (theName)
			newField[i].name = theName + compteur;
		var theid = newField[i].id;
		if (theid)
			newField[i].id = theid + compteur;
		RecurciveIdUpdate(compteur,newField[i]);
	}
	
}

function supress(element){
	counter--;
	var parent=element.parentNode;
	var Gparent=parent.parentNode;
	if ((Gparent.id!="quest0"))
		(Gparent.parentNode).removeChild(Gparent);
}