


/*******fonction pour quitter********/
function abandonner()
{
	self.close();
}

/*******fonction qui annule la dernière action de la zone de texte********/
function annulerAction()
{
	document.execCommand('Undo');//document.execCommand('Undo');
	document.info.zonetexte.value = document.info.zonetexte.value.replace('%~%','');
	curseurFin('zonetexte');
}

/*******Donne la couleur pour les zones de saisie********/
function colorFocus(nom)
{
	document.getElementById(nom).style.backgroundColor="yellow";
}
function colorBlur(nom)
{
	document.getElementById(nom).style.backgroundColor="#8C8CFF";
}

/*******Type de navigateur********/
var ns4=document.layers;
var ie4=document.all;
var ns6=document.getElementById&&!document.all;
var isMozilla = (navigator.userAgent.toLowerCase().indexOf('gecko')!=-1) ? true : false;

/*******fonction qui permet de verifier les champs du formulaire avant de l'envoyer********/
/*** permet aussi de remplacer qlqs element dans la zone de texte comme la multiplication ****/
function verifForm()
{
	//document.info.oper1.value=document.info.operateur1.options[document.info.operateur1.selectedIndex].value;
	//document.info.oper2.value=document.info.operateur2.options[document.info.operateur2.selectedIndex].value;
	ExpReg1 = /\d/;//ExpReg1 = /\d\s*/;//ExpReg2 = /\s*\d/;
	ExpReg2 = /\d/;
	ExpReg3 = /[a-zA-Z]/;
	ExpReg = /\d+\s*x\s*\d+/;
	j = 1;
	bool = true;
    x=document.info.zonetexte.value;
	for (i=0 ;i<= x.length-1 ;i++)
	{
		if (x.charAt(i)==",")
		{
		 if ((!ExpReg1.test(x.charAt(i-1))) || (!ExpReg2.test(x.charAt(i+1))))
		  {
			 x = x.substring(0,i) + " " + x.substring (i+1,x.length);
		  }
		}
	}
	for (i=0 ;i<= x.length-1 ;i++)
    {
		switch(x.charAt(i))
		{
			case "x" : for (j=1; j <= i ;j++)
						{
							if ((ExpReg1.test(x.charAt(i-j))) || (ExpReg2.test(x.charAt(i+j))))
							{ 		
								x = x.substring(0,i)+ " * " + x.substring (i+1,x.length);
								break;							
							} 
							else if ((ExpReg3.test(x.charAt(i-j))) || (ExpReg3.test(x.charAt(i+j))))
							{
							break;
							}
						}
					  	break;
			case "-" : if ((ExpReg1.test(x.charAt(i-1))) || (ExpReg2.test(x.charAt(i+1))))
							{ 		
								x = x.substring(0,i)+ " - " + x.substring (i+1,x.length);							
							}  
						else 
						{
						//for (j=1; j <= i ;j++){
						//if ((ExpReg3.test(x.charAt(i-j))) || (ExpReg3.test(x.charAt(i+j))))
							//{
								//x = x.substring(0,i)+ " " + x.substring (i+1,x.length);
							//}
						//}
						}
						break;
			case "+" :  if ((ExpReg1.test(x.charAt(i-1))) || (ExpReg2.test(x.charAt(i+1))))
       					  {
							 x = x.substring(0,i) + " + " + x.substring (i+1,x.length);
						  }
						 break;
			case ":" :  if ((ExpReg1.test(x.charAt(i-1))) || (ExpReg2.test(x.charAt(i+1))))
       					  {
							 x = x.substring(0,i) + " : " + x.substring (i+1,x.length);
						  }
						 break;
		    case "=" :  if ((ExpReg1.test(x.charAt(i-1))) || (ExpReg2.test(x.charAt(i+1))))
       					  {
							 x = x.substring(0,i) + " = " + x.substring (i+1,x.length);
						  }
						 break;
		 }
	}
	document.info.zonetexte.value = x;
	if (document.info.zonetexte.value=='' )
	{
	alert('Tu dois écrire ta réponse dans la feuille');
	}
	else
	{
	//masquer();
	document.info.submit();
	}
}

//******************fontion pour masquer les champs operande3 *******************
function masquer()
{ 
	document.info.operande1.focus();
}

//*-------------initialisation de la calculette après precedent--------------*//
function initPrecedent(op1,op2,oper,res)
{	
	switch(oper)
	{
		case "+" : document.info.operateur1.selectedIndex=1;
				   break;
		case "-" : document.info.operateur1.selectedIndex=2;
				   break;
		case "x" : document.info.operateur1.selectedIndex=3;
				   break;
		case ":" : document.info.operateur1.selectedIndex=4;
				   break;
	}
	document.info.operande2.value=op2;
	document.info.operande1.value=op1;
	document.info.resultat1.value=res;
}

/***********************fontion qui limite les nombres apres la virgule *****************/
var max = 100;
function count(e,oper) {
	if(ie4 && !e.which) keyCode = event.keyCode ;// ie5+ op5+
	else keyCode = e.which; // nn6+
	switch(oper)
	{
	case 1 :  if (document.info.operande1.value.length<max+1) 
				{
					x = document.info.operande1.value;
					n = x.indexOf(',');
					if (n != -1)
					{
						document.info.operande1.value = document.info.operande1.value.substring(0,n+3);
					}
				}
				else {
					document.info.operande1.value = document.info.operande1.value.substring(0,max);
					x = document.info.operande1.value;
					n = x.indexOf(',');
					if (n != -1)
					{
						document.info.operande1.value = document.info.operande1.value.substring(0,n+3);
					}
				}
				break;
	case 2 : if (document.info.operande2.value.lengthmax+1) 
				{
					x = document.info.operande2.value;
					n = x.indexOf(',');
					if (n != -1)
					{
						document.info.operande2.value = document.info.operande2.value.substring(0,n+3);
					}
				}
				else 
				{
					document.info.operande2.value = document.info.operande2.value.substring(0,max);
					x = document.info.operande2.value;
					n = x.indexOf(',');
					if (n != -1)
					{
						document.info.operande2.value = document.info.operande2.value.substring(0,n+3);
					}
				}
				break;
	case 4 : if (document.info.resultat1.value.lengthmax+1) 
				{
					x = document.info.resultat1.value;
					n = x.indexOf(',');
					if (n != -1)
					{
						document.info.resultat1.value = document.info.resultat1.value.substring(0,n+3);
					}
				}
				else {
					document.info.resultat1.value = document.info.resultat1.value.substring(0,max);
					x = document.info.resultat1.value;
					n = x.indexOf(',');
					if (n != -1)
					{
						document.info.resultat1.value = document.info.resultat1.value.substring(0,n+3);
					}
				}
				break;
	}
}
/*********************fonction qui permet d'afficher que des entiers***********************/
function checkIt(evt) {
	evt = (evt) ? evt : window.event;
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if (((charCode > 31 && (charCode < 48 || charCode > 57)) && (charCode != 44))&&(tester==4))
    {
		status = "ce champ accepte que les entiers.";
		return false;
	}
	else if (((charCode > 31 && (charCode < 40 || charCode > 57)) && (charCode != 32)&& (charCode != 58) && (charCode != 88) && (charCode != 120))&&(tester==1))
	 {
		status = "ce champ accepte que les entiers.";
		return false;
	}
	status = "";
	return true;
}
//************** fonction pour sauvegarder les mots dans le text area* ******************/
function save(mot)
{
	if (mot=="-")
	{
		mot = "";
		document.info.zonetexte.value=document.info.zonetexte.value+mot;
	}
	else if (mot=="\n")
		document.info.zonetexte.value=document.info.zonetexte.value+mot;
	else
		document.info.zonetexte.value=document.info.zonetexte.value+mot+" ";
}

/*************************** choix du signe (operateur aritmétique) ********************/
function operat(val)
{ 
	switch(val)
	{
		case "+" : document.info.operateur1.selectedIndex=1;
					if (tester != 5) document.info.operande2.focus();
				   break;
		case "-" : document.info.operateur1.selectedIndex=2;
					if (tester != 5) document.info.operande2.focus();
				   break;
		case "x" : document.info.operateur1.selectedIndex=3;
					if (tester != 5) document.info.operande2.focus();
				   break;
		case ":" : document.info.operateur1.selectedIndex=4;
					if (tester != 5) document.info.operande2.focus();
					break;
	}
}

/************fonction qui done le choix de la  zone active pour l'ecriture *************/
function monTour(n)
{
	switch(n)
	{
		case 1 : tester="1"; break;
		case 2 : tester="2"; break;
		case 3 : tester="3"; break;
		case 4 : tester="4"; break;
	    case 5 : tester="5"; break;
		default : tester="1"; break;
	}
}
/*************function affichage des nombre dans les operandes************/
function afficher(x)
{	
	switch(tester)
	{
		case "1" : document.info.operande1.value=document.info.operande1.value+x;
				   document.info.operande1.focus();
				   colorFocus('op1');
				   break;
				   
		case "2" : document.info.operande2.value=document.info.operande2.value+x;
				   document.info.operande2.focus();
				   colorFocus('op2');
				   break;
		case "4" : document.info.resultat1.value=document.info.resultat1.value+x;
				   document.info.resultat1.focus(); colorFocus('res');
				   break;
		case "5" :  colorFocus('T1'); 
				   break;
		//default :  document.info.operande1.value=document.info.operande1.value+x;
			//	   document.info.operande1.focus();
				//   break;
	}
}

/************************fonction qui evalue le resultat de l'operation************************/
function resultat() 
{
		var operation=document.info.operande1.value;
		operation = operation.replace(/x/g,'*');
		operation = operation.replace(/X/g,'*');
		operation = operation.replace(/:/g,'/');
		result = eval(operation);
		
		if (result < 0)
		{
			alert ("Attention !!!\nTu as inversé ta soustraction");
		}
		else
		document.info.resultat1.value = Math.round(result);
		document.info.resultat1.focus();
}
/***************fonction qui verifie l'operation en colonne*********************/
function verifCal()
{
	if(document.info.operande1.value=='')
		{
			alert("Ton opération n'est pas complète");
			document.info.operande1.focus();
		}
	else if(document.info.resultat1.value=='')
		{
			resultat();
			operation = document.info.operande1.value + " = " + document.info.resultat1.value +"\n";
			insererCal(operation);
			//document.info.zonetexte.focus();
		}
	else 
		{
			operation = document.info.operande1.value + " = " + document.info.resultat1.value +"\n";
			insererCal(operation);
			//document.info.zonetexte.focus();
		}
}
/**** Afficher le calcul dans la feuille de réponse ****/
function insererCal(selec)
{
	EROper2 = /^(\d+\s*[\+\-\*\/x:]\s*)*(\(\s*(\d+\s*[\+\-\*\/x:]\s*)+\d+\s*\)\s*[\+\-\*\/x:]?\s*)*\d*\s*=?\d*\s*$/;
	EROper3 = /\s*=\s*\d*\s*$/;
	if(EROper2.test(selec))
	{
		operation = selec;
		operation = operation.replace(/x/g,'*');
		operation = operation.replace(/X/g,'*');
		operation = operation.replace(/:/g,'/');
		operation = operation.replace(EROper3,'');
		//sas = sas.replace(EROper3,'');
		//result = eval(operation);
		var resultat = eval(operation);
		resultat = Math.round(resultat);
		if(EROper3.test(operation))
			selec = selec + resultat;
		else
			selec = selec + " = " + resultat;
	}	
	
	if (isMozilla) 
	{
	// Si on est sur Mozilla
		oField = document.forms['info'].elements['zonetexte'];
		objectValue = oField.value;
		deb = oField.selectionStart;
		fin = oField.selectionEnd;
		objectValueDeb = objectValue.substring( 0 , oField.selectionStart );
		objectValueFin = objectValue.substring( oField.selectionEnd , oField.textLength );
		objectSelected = objectValue.substring( oField.selectionStart ,oField.selectionEnd );
		oField.value = objectValueDeb + selec +  objectValueFin;
		oField.focus();
		oField.selectionStart = objectValueDeb.length;//strlen(objectValueDeb);
		oField.selectionEnd = objectValueDeb.length + selec.length ;//strlen(objectValueDeb +  selec );
		oField.setSelectionRange(objectValueDeb.length + selec.length , objectValueDeb.length + selec.length );
	}
	else
	{
	// Si on est sur IE
		oField = document.forms['info'].elements['zonetexte'];
		var str = document.selection.createRange().text;
		if (str.length>0)
		{
		// Si on a selectionné du texte
			var sel = document.selection.createRange();
			sel.text =  selec ;
			sel.collapse();
			sel.select();
		}
		else
		{
			oField.focus(oField.caretPos);
			oField.focus(oField.value.length);
			oField.caretPos = document.selection.createRange().duplicate();
			var bidon = "%~%";
			var orig = oField.value;
			oField.caretPos.text = bidon;
			var i = oField.value.search(bidon);
			if (i==0)
			oField.value = orig.substr(i, oField.value.length)+selec ;
			else
			oField.value = orig.substr(0,i) +  selec  + orig.substr(i, oField.value.length);
			if (i==0)
				pos = oField.value.length;
			else 
				pos = i + selec.length ;
	        //placer(document.forms['info'].elements['zonetexte'], pos);
			var r = oField.createTextRange();
			r.moveStart('character', pos);
			r.collapse();
			r.select();
		}
	}
	
}

/********  la fonction inserer dans la feuille    ********/
function inserer(selec)
{
	var sas = document.forms['info'].elements['T1'].value;
	EROper2 = /^(\d+\s*[\+\-\*\/x:]\s*)*(\(\s*(\d+\s*[\+\-\*\/x:]\s*)+\d+\s*\)\s*[\+\-\*\/x:]?\s*)*\d*\s*=?\d*\s*$/;
	//pattern = /^((?:\d+\s*[\+\-\*\/x:]\s*)*(?:\(?\s*(?:\d+\s*[\+\-\*\/x:]\s*)+\d+\s*\)?\s*[\+\-\*\/x:]?\s*)*\d*\s*)=?(\s*\d+)$/;
	EROper3 = /\s*=\s*\d*\s*$/;
	//if(pattern.test(selec)) alert(selec);
	
	if((EROper2.test(selec))&&(sas!=''))
	{
		operation = sas;
		operation = operation.replace(/x/g,'*');
		operation = operation.replace(/X/g,'*');
		operation = operation.replace(/:/g,'/');
		operation = operation.replace(EROper3,'');
		sas = sas.replace(EROper3,'');
		result = eval(operation);//evaluation de l'expression arithmétique
		result = Math.round(result);//arrondi à l'entier le plus proche

		var resultat = eval(operation);
		resultat = Math.round(resultat);

		/*if(EROper3.test(operation))
			{
				selec = sas + resultat;
			}
			
		else
			{
				selec = sas + " = " + resultat;
			}
		sas = selec	;*/
		
	}

	if(selec==sas)
	{
		document.forms['info'].elements['T1'].value='';
	}

	tabSas = sas.split(/[ ]+/);
	if(tabSas.length > 1)
	{
		sas = tabSas.join(" ");
		sas = sas + "\n";
		selec=sas;
	}
	
	
	if (isMozilla) 
	{
	// Si on est sur Mozilla
		oField = document.forms['info'].elements['zonetexte'];
		objectValue = oField.value;
		deb = oField.selectionStart;
		fin = oField.selectionEnd;
		objectValueDeb = objectValue.substring( 0 , oField.selectionStart );
		objectValueFin = objectValue.substring( oField.selectionEnd , oField.textLength );
		objectSelected = objectValue.substring( oField.selectionStart ,oField.selectionEnd );
		oField.value = objectValueDeb + selec +  objectValueFin;
		oField.focus();
		oField.selectionStart = objectValueDeb.length;//strlen(objectValueDeb);
		oField.selectionEnd = objectValueDeb.length + selec.length ;//strlen(objectValueDeb +  selec );
		oField.setSelectionRange(objectValueDeb.length + selec.length , objectValueDeb.length + selec.length );
	}
	else
	{
	// Si on est sur IE
		oField = document.forms['info'].elements['zonetexte'];
		var str = document.selection.createRange().text;
		if (str.length>0)
		{
		// Si on a selectionné du texte
			var sel = document.selection.createRange();
			sel.text =  selec ;
			sel.collapse();
			sel.select();
		}
		else
		{
			oField.focus(oField.caretPos);
			oField.focus(oField.value.length);
			oField.caretPos = document.selection.createRange().duplicate();
			var bidon = "%~%";
			var orig = oField.value;
			oField.caretPos.text = bidon;
			var i = oField.value.search(bidon);
			if (i==0)
			oField.value = orig.substr(i, oField.value.length)+selec ;
			else
			oField.value = orig.substr(0,i) +  selec  + orig.substr(i, oField.value.length);
			if (i==0)
				pos = oField.value.length;
			else 
				pos = i + selec.length ;
	        //placer(document.forms['info'].elements['zonetexte'], pos);
			var r = oField.createTextRange();
			r.moveStart('character', pos);
			r.collapse();
			r.select();
		}
	}
	
}
		/********  la fonction inserer dans le sas    ********/
/****************************************************************************/
var regexp = new RegExp("[\r]","gi");
function insererSas(selec,id)
{
	var reNumber =/[0-9]$/;/*chaine qui se termine par un chiffre*/
	var reChar =/[^0-9]/;/*chaine qui ne contient pas de chiffre*/
	var sas = document.forms['info'].elements['T1'].value;
	
	var PLMot = selec.substring(0,1);//Première lettre du mot
	var maj = new RegExp("[A-Z]");//expression regulière qui reconnait les majuscules
	if(maj.test(PLMot) && id>1)
	{	
		NomPropre=true;
	}
	else
	{
		//met tous les mots en miniscule
		selec=selec.toLowerCase();
	}
	//met un espace après un chiffre si c'est un mot.	
	if(reChar.test(selec) && reNumber.test(sas))
	{selec= ' '+selec;}

	if (isMozilla) 
	{
		// Si on est sur Mozilla
		oField = document.forms['info'].elements['T1'];
		objectValue = oField.value;
		deb = oField.selectionStart;
		fin = oField.selectionEnd;
		objectValueDeb = objectValue.substring( 0 , oField.selectionStart );
		objectValueFin = objectValue.substring( oField.selectionEnd , oField.textLength );
		objectSelected = objectValue.substring( oField.selectionStart ,oField.selectionEnd );
		oField.value = objectValueDeb + selec +  objectValueFin;
		oField.focus();
		oField.selectionStart = objectValueDeb.length;
		oField.selectionEnd = objectValueDeb.length + selec.length ;
		oField.setSelectionRange(objectValueDeb.length + selec.length , objectValueDeb.length + selec.length );
	}
	else
	{
		// Si on est sur IE
		oField = document.forms['info'].elements['T1'];
		var str = document.selection.createRange().text;
		if (str.length>0)
		{
		   //Si on a selectionné du texte
		   var sel = document.selection.createRange();
		   sel.text =  selec ;
		   sel.collapse();
		   sel.select();
		}
		else
		{
			oField.focus(oField.caretPos);
			oField.focus(oField.value.length);
			oField.caretPos = document.selection.createRange().duplicate();
			var bidon = "%~%";
			var orig = oField.value;
			oField.caretPos.text = bidon;
			var i = oField.value.search(bidon);
			if(i==0)
				oField.value = orig.substr(i, oField.value.length)+selec ;
			else
				oField.value = orig.substr(0,i) +  selec  + orig.substr(i, oField.value.length);
			var r = 0 ;
			for (n = 0; n < i; n++)
			{
				if(regexp.test(oField.value.substr(n,2))==true)
					{r++;}
			}
			if (i==0)
			pos = oField.value.length;
			else 
			pos = i + selec.length - r;
	        //placer(document.forms['info'].elements['T1'], pos);
			var r = oField.createTextRange();
			r.moveStart('character', pos);
			r.collapse();
			r.select();
		}
	}
	/**** Met la première lettre de chaque phrase en majuscule ****/
		
			sas =document.forms['info'].elements['T1'].value;
			tabSas = sas.split(/[ ]+/);
			tabSas[0] = tabSas[0].substring(0,1).toUpperCase()+tabSas[0].substring(1,tabSas[0].length);
			
			for(i=0; i<=tabSas.length-1;i++)
			{
				if(tabSas[i-1]=="." || tabSas[i-1]=="?")
				tabSas[i] = tabSas[i].substring(0,1).toUpperCase()+tabSas[i].substring(1,tabSas[i].length);
			}
			sas = tabSas.join(" ");
			if(reNumber.test(sas))
				document.forms['info'].elements['T1'].value = tabSas.join(" ");
			else
				document.forms['info'].elements['T1'].value = tabSas.join(" ")+" ";
		
}
/*********fonction qui calcule dans le sas ***********/
function calculSas()
{
	var sas = document.forms['info'].elements['T1'].value;
	ExpReg3 = /[a-zA-Z]/;
	EROper1 = /^(\d+\s*[\+\-\*\/x:]\s*)+\d+\s*=?/;
	EROper2 = /^(\d+\s*[\+\-\*\/x:]\s*)*(\(\s*(\d+\s*[\+\-\*\/x:]\s*)+\d+\s*\)\s*[\+\-\*\/x:]?\s*)*\d*\s*=?\d*\s*$/;
	EROper3 = /\s*=\s*\d*\s*$/;
	selec = " = ";
	if((EROper2.test(sas))&&(sas!=''))
	{
		//ExpReg1 = /\d/;//ExpReg1 = /\d\s*/;//ExpReg2 = /\s*\d/;
		/*ExpReg2 = /\d/;
		j = 1;
		x = sas ;
		y=sas;
		for (i=0 ;i<= x.length-1 ;i++)
   		{
			//alert(x.charAt(i));
			switch(x.charAt(i))
				{
					case "x" : for (j=1; j <= i ;j++)
								{
									
									if ((ExpReg1.test(x.charAt(i-j))) || (ExpReg2.test(x.charAt(i+j))))
									{ 	
										//alert(ExpReg1.test(x.charAt(i-j)));alert(ExpReg2.test(x.charAt(i+j)));
										x = x.substring(0,i)+ " * " + x.substring (i+1,x.length);
										//alert(x.substring(0,i));alert( x.substring (i+1,x.length));
										break;
									} 
								}
								break;
					case ":" :  for (j=1; j <= i ;j++)
								{
									if ((ExpReg1.test(x.charAt(i-j))) || (ExpReg2.test(x.charAt(i+j))))
									  {
										x = x.substring(0,i) + " / " + x.substring (i+1,x.length);
										 break;
									  }
								}
								 break;
					case "=" :  for (j=1; j <= i ;j++)
								{
								 	if ((ExpReg1.test(x.charAt(i-j))) || (ExpReg2.test(x.charAt(i+j))))
									  {
										 x = x.substring(0,i) + " " + x.substring (i+1,x.length);
										 document.forms['info'].elements['T1'].value = x;
										 break;
									  }
								}
								 break;
				 }//fin du switch
		}//fin de la boucle for*/
		operation = sas;
		operation = operation.replace(/x/g,'*');
		operation = operation.replace(/X/g,'*');
		operation = operation.replace(/:/g,'/');
		operation = operation.replace(EROper3,'');
		sas = sas.replace(EROper3,'');document.forms['info'].elements['T1'].value=sas;
		result = eval(operation);
		result = Math.round(result);
		var resultat = eval(operation);
			resultat = Math.round(resultat);

		/*if(EROper3.test(operation))
			selec = resultat;
		else
			selec = selec + resultat;*/
	}
	//fin du  if(selec == ' = ')
	insererSas(selec);
}
/********* met le curseur à la fin de phrase **********/
function curseurFin(element)
{
		oField = document.forms['info'].elements[element];
		var r = oField.createTextRange();
		r.moveStart('character', oField.value.length);
		r.collapse();
		r.select();
}

/*** fonction annuler dans le sas ***/
function annulerSas()
{
	var sas = document.forms['info'].elements['T1'].value;
	tabSas = sas.split(/[ ]+/);//le séparateur est un ensemble de blanc
	elementSupp = tabSas.pop();//supprime le dernier element du tableau
	document.forms['info'].elements['T1'].value = tabSas.join(" ");
	if (tabSas.length != 0)
	document.forms['info'].elements['T1'].value = document.forms['info'].elements['T1'].value + " ";
	curseurFin('T1');
}
/**** fonction annuler l'operaation ****/
function annulerOper()
{
	var op = document.forms['info'].elements['operande1'].value;
	tabOp = op.split(/[ ]+/);//le séparateur est un ensemble de blanc
	elementSupp = tabOp.pop();//supprime le dernier element du tableau
	document.forms['info'].elements['operande1'].value = tabOp.join(" ");
	if (tabOp.length != 0)
	document.forms['info'].elements['operande1'].value = document.forms['info'].elements['operande1'].value + " ";
	curseurFin('operande1');
}

