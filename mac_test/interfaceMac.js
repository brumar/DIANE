// JavaScript Document
//fonction qui permet de reconaitre un operande
function verifForm()
{
    document.info.oper1.value=document.info.operation.value;
    document.info.oper2.value=document.info.operation1.value;

	//ExpReg1 = /\d\s*/;
	//ExpReg2 = /\s*\d/;
	ExpReg1 = /\d/;
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
	alert('Veuillez saisir votre solution');
	}
	else
	{
	masquer();
	document.info.submit();
	}
}
//**********************************fontion pour masquer les champs operande3 *******************************
//*******************************************************************************************************************
function masquer()
{
if (document.info.R1[0].checked)
	{
	document.info.operande1.focus();
	//document.info.operation.value = '  ';
	document.getElementById('zoneText').style.visibility = "hidden";
	document.getElementById('bouton').style.visibility = "hidden";
	document.getElementById('groupe1').style.visibility = "visible";
	document.getElementById('groupe2').style.visibility = "hidden";
	document.getElementById('groupe3').style.visibility = "hidden";
	document.getElementById('efface').style.visibility = "hidden";

	}
else if (document.info.R1[1].checked)
	{
	
	document.getElementById('zoneText').style.visibility = "visible";
	document.getElementById('bouton').style.visibility = "visible";
	document.info.operande3.focus();
	document.getElementById('groupe1').style.visibility = "hidden";
	document.getElementById('groupe2').style.visibility = "visible";
	document.getElementById('groupe3').style.visibility = "visible";
	document.getElementById('efface').style.visibility = "visible";
	document.info.operation.value = '   ';
	document.info.operation1.value = '   ';
	}
}
//***********************fontion qui limite les nombre apres la virgule ************************
//***********************************************************************************************
var max = 10;
function count(e,oper) {
	
	if (!e.which) keyCode = event.keyCode; // ie5+ op5+
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
		case 3 : if (document.info.operande3.value.length<max+1) 
				{
					x = document.info.operande3.value;
					n = x.indexOf(',');
					if (n != -1)
					{
						document.info.operande3	.value = document.info.operande3.value.substring(0,n+3);
					}
				}
				else {
					document.info.operande3.value = document.info.operande3.value.substring(0,max);
					x = document.info.operande1.value;
					n = x.indexOf(',');
					if (n != -1)
					{
						document.info.operande3.value = document.info.operande3.value.substring(0,n+3);
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
//************************fonction pour permettre d'afficher que des entiers*******************************
//*********************************************************************************************************
function checkIt(evt) {
	evt = (evt) ? evt : window.event
	var charCode = (evt.which) ? evt.which : evt.keyCode
	if ((charCode > 31 && (charCode < 48 || charCode > 57)) && (charCode != 44))
        {
		status = "ce champ accepte que les entiers."
		return false
	}
	status = ""
	return true
}
//**********************fonction pour sauvegarder les mots dans le text area**********************************
//************************************************************************************************************
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
//****************************choix du signe*****************************
//**********************************************************************************************
function operat(val)
{
	switch(val)
	{
		case "+" : document.info.operation.value=" + ";
				   break;
		case "-" : document.info.operation.value=" - ";
				   break;
		case "x" : document.info.operation.value=" x ";
				   break;
		case ":" : document.info.operation.value=" : ";
				   break;
	}
}
//************choix de la zone de texte****************
//*****************************************************
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
//*******************function affichage des nombre dans les operandes************************
//********************************************************************************************

function afficher(x)
{	
	reChar =/[^0-9]+/;
	sas = document.info.T1.value;
	if(reChar.test(sas))
	document.info.T1.value = '';
	
	switch(tester)
	{
		case "1" : if ((sas=='+') || (sas=='-') || (sas=='x') || (sas==':')|| (sas=='='))
				   		document.info.T1.value='';
				   document.info.T1.value=document.info.T1.value+x;
				   document.info.operande1.value=document.info.operande1.value+x;
				   document.info.operande1.focus();
				   break;
		case "2" : if ((sas=='+') || (sas=='-') || (sas=='x') || (sas==':')|| (sas=='='))
				   		document.info.T1.value='';
				   document.info.T1.value=document.info.T1.value+x;
				   document.info.operande2.value=document.info.operande2.value+x;
				   document.info.operande2.focus();
				   break;
		case "3" : if ((sas=='+') || (sas=='-') || (sas=='x') || (sas==':')|| (sas=='='))
				  		 document.info.T1.value='';
				   document.info.T1.value=document.info.T1.value+x;
				   document.info.operande3.value=document.info.operande3.value+x;
				   document.info.operande3.focus();
				   break;
		case "4" : if ((sas=='+') || (sas=='-') || (sas=='x') || (sas==':')|| (sas=='='))
				   		document.info.T1.value='';
				   document.info.T1.value=document.info.T1.value+x;
				   document.info.resultat1.value=document.info.resultat1.value+x;
				   document.info.resultat1.focus();
				   break;
		case "5" : if ((sas=='+') || (sas=='-') || (sas=='x') || (sas==':')|| (sas=='='))
				   		document.info.T1.value='';
				   document.info.T1.value=document.info.T1.value+x;
				   document.info.T1.focus();
				   break;
		//default :  document.info.operande1.value=document.info.operande1.value+x;
			//	   document.info.operande1.focus();
				//   break;
	}
}
//*************************fonction qui evalue le resultat de l'operation********************************************
function resultat2()
{
	if ((document.info.operande1.value != "") && (document.info.operande2.value != "") && (document.info.operation.value != "   "))
		resultat();
}
//*******************************************************************************************************************
function resultat() 
{
	if (document.info.R1[0].checked)
		{
			if ((document.info.operande1.value == "") || (document.info.operande2.value == "")|| (document.info.operation.value == "   "))
			{
				alert ("remplissez tous les champs\n avant de faire une operation");
				
			}
			var x =0;
			//alert(document.info.operande1.value.replace(',','.'));
			switch(document.info.operation.value)
				{
					case " + " : conc = document.info.operande1.value.replace(',','.') + "+" + document.info.operande2.value.replace(',','.');
								 x = eval(conc);
								 x = x.toString();
								 window.document.info.resultat1.value = x.replace('.',',');
								 break;
		
					case " - " : conc = document.info.operande1.value.replace(',','.') + "-" + document.info.operande2.value.replace(',','.');
								if (eval(conc) < 0)
								{
									alert ("tu as inversé ta soustraction\natention la prochaine fois");
									y = document.info.operande1.value;
									document.info.operande1.value = document.info.operande2.value;
									document.info.operande2.value = y;
									conc = document.info.operande1.value.replace(',','.') + "-" + document.info.operande2.value.replace(',','.');
								}
								x = eval(conc);
								x = x.toString();
								window.document.info.resultat1.value = x.replace('.',',');
								break;
				   case " x " : conc = document.info.operande1.value.replace(',','.') + "*" + document.info.operande2.value.replace(',','.');
								x = eval(conc);
								x = x.toString();
								window.document.info.resultat1.value = x.replace('.',',');
								break;
				   case " : " : if (document.info.operande2.value == 0)
									{
									alert("La division par zero est impossible");
									break;
									}
								conc = document.info.operande1.value.replace(',','.') + "/" + document.info.operande2.value.replace(',','.');
								x = eval(conc);
								x = x.toString();
								window.document.info.resultat1.value = x.replace('.',',');
								break;
				}
		}
	else if (document.info.R1[1].checked)
		{
			if ((document.info.operande1.value == "") || (document.info.operande2.value == "")||(document.info.operande3.value == ""))
			{
				alert ("remplissez tous les champs\n avant de faire un calcul");
			}
			var x =0;
			switch(document.info.operation1.value)
				{
					case " + " : switch(document.info.operation.value)
								{
								 case " + " : conc = document.info.operande3.value.replace(',','.') + "+" + document.info.operande1.value.replace(',','.') + "+" + document.info.operande2.value.replace(',','.');
											  x = eval(conc);
											  x = x.toString();
											  window.document.info.resultat1.value = x.replace('.',',');
											  break;
								 case " - " : conc = document.info.operande3.value.replace(',','.') + "+" + document.info.operande1.value.replace(',','.') + "-" + document.info.operande2.value.replace(',','.');
											  x = eval(conc);
											  x = x.toString();
											  window.document.info.resultat1.value = x.replace('.',',');
											  break;
								}
								break;
					case " - " :switch(document.info.operation.value)
								{
								 case " + " : conc = document.info.operande3.value.replace(',','.') + "-" + document.info.operande1.value.replace(',','.') + "+" + document.info.operande2.value.replace(',','.');
											  x = eval(conc);
											  x = x.toString();
											  window.document.info.resultat1.value = x.replace('.',',');
											  break;
								 case " - " : conc = document.info.operande3.value.replace(',','.') + "-" + document.info.operande1.value.replace(',','.') + "-" + document.info.operande2.value.replace(',','.');
											  x = eval(conc);
											  x = x.toString();
											  window.document.info.resultat1.value = x.replace('.',',');
											  break;
								}	
								break;
				}
		}
	
}

//******************fonction qui affiche l'operation dans le textarea****************************
//***********************************************************************************************
function verifCal()
{
		if(((document.info.operande1.value=='')||(document.info.operande2.value=='')||(document.info.operation.value=='   ')||(document.info.resultat1.value==''))&&(document.info.R1[0].checked))
			{
				alert("Ton opération n'est pas complète");
				document.info.operande1.focus();
			}
	    else if(((document.info.operande1.value=='')||(document.info.operande2.value=='')||(document.info.operande3.value=='')||(document.info.operation.value=='   ')||(document.info.operation1.value=='   ')||(document.info.resultat1.value==''))&&(document.info.R1[1].checked))
			{
				alert("Ton opération n'est pas complète");
				document.info.operande3.focus();
			}
		else 
			{
				afficheCal();
				//document.info.zonetexte.focus();
			}
}
function afficheCal()
{
	ligne ="_";
	op1="  "+document.info.operande1.value+"\n";
	n1=op1.length;
	op2="  "+document.info.operande2.value+"\n";
	n2=op2.length;
	
	result=document.info.resultat1.value+"\n";
	op = document.info.operation.value+"\n";
	opp = document.info.operation1.value+"\n";
	if (document.info.R1[0].checked)
		{
		if (n1 < n2)
			{
			n3=n2-n1;
			for(i=0 ; i< n3 ;i++)
			op1=" "+op1;
			}
		else if(n2 < n1)
				{
				n3=n1-n2;
				for(i=0 ; i< n3 ;i++)
					op2=" "+op2;
				}
		for (i=0; i < op1.length ;i++)
			ligne = ligne+"_";
		x = "\n"+op1+op+op2+ligne+"\n"+"= "+ result;
		document.info.zonetexte.value=document.info.zonetexte.value+x;
		}
	else if (document.info.R1[1].checked)
		{
		op4="  "+document.info.operande3.value+"\n";
		n4=op4.length;
		if (n1 < n2)
		{
			if (n2 < n4)
				{
					n5=n4-n1;
					n6=n4-n2;
					for(i=0 ; i< n5 ;i++)
					op1=" "+op1;
					for(i=0 ; i< n6 ;i++)
					op2=" "+op2;
				}
				else if (n1 < n4)
					{
						n5=n2-n1;
						n6=n2-n4;
						for(i=0 ; i< n5 ;i++)
						op1=" "+op1;
						for(i=0 ; i< n6 ;i++)
						op4=" "+op4;
					}
					else 
						{
							n5=n2-n1;
							n6=n2-n4;
							for(i=0 ; i< n5 ;i++)
							op1=" "+op1;
							for(i=0 ; i< n6 ;i++)
							op4=" "+op4;
						}
		 }		
	else 
		 {
				if (n1 < n4)
				{
					n5=n4-n1;
					n6=n4-n2;
					for(i=0 ; i< n5 ;i++)
					op1=" "+op1;
					for(i=0 ; i< n6 ;i++)
					op2=" "+op2;
				}
				else if(n2 < n4)
					 {
						n5=n1-n4;
						n6=n1-n2;
						for(i=0 ; i< n5 ;i++)
						op4=" "+op4;
						for(i=0 ; i< n6 ;i++)
						op2=" "+op2;
					 }
					 else 
						  {
							n5=n1-n2;
							n6=n1-n4;
							for(i=0 ; i< n5 ;i++)
								op2=" "+op2;
							for(i=0 ; i< n6 ;i++)
								op4=" "+op4;
						  }
		}
	for (i=0; i < op1.length ;i++)
	ligne = ligne+"_";
	x = "\n"+op4+opp+op1+op+op2+ligne+"\n"+"= "+ result;
	document.info.zonetexte.value=document.info.zonetexte.value+x;
	//document.info.zonetexte.focus();
		}
}
//*********fonction qui enregiste les caractere pour IE dans le textarea**************
//************************************************************************************
function emoticon(strEmoticon) 
 {
	  var objMailForm = document.forms['info']
	  var objEl = objMailForm.elements['zonetexte']
	  insertAtCaret(strEmoticon)
	  //document.info.zonetexte.focus();
 }

function storeCaret()
 {
	  var objMailForm = document.forms['info']
	  var objEl = objMailForm.elements['zonetexte']
	  if (objEl.createTextRange)
	  {
	   objEl.caretPos = document.selection.createRange().duplicate();
	  }
 }


function insertAtCaret(text)
	{
	  var objMailForm = document.forms['info']
	  var objEl = objMailForm.elements['zonetexte']
	  if (objEl.createTextRange && objEl.caretPos)
	  {
	   var caretPos = objEl.caretPos;
	   caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? text + ' ' : text;
	  }
	  else
	  {
	   objEl.value += text;
	  }
	 }

function VoirSelection (textEl, text)
{
	if (textEl.createTextRange && textEl.caretPos)
		{
			sel = document.selection.createRange().text;
			longSel = sel.length;
			if (longSel>0)
			alert(longSel);
			else document.info.zonetexte.value='';
		}
}
//function storeCaret (textEl)
//{
	//if (textEl.createTextRange)
	//textEl.caretPos = document.selection.createRange().duplicate();
//}
//function insertAtCaret (textEl, text)
//{
	//if (textEl.createTextRange && textEl.caretPos)
	//{
		//var caretPos = textEl.caretPos;
		//caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? text + ' ' : text;
	//}
	//else
	//textEl.value  = textEl.value+text;
//}
