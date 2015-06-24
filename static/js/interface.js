/*******PARTIE PERMETTANT LES LECTEURS AUDIO    ********/
var swfobject=function(){var Z="undefined",P="object",B="Shockwave Flash",h="ShockwaveFlash.ShockwaveFlash",W="application/x-shockwave-flash",K="SWFObjectExprInst",G=window,g=document,N=navigator,f=[],H=[],Q=null,L=null,T=null,S=false,C=false;var a=function(){var l=typeof g.getElementById!=Z&&typeof g.getElementsByTagName!=Z&&typeof g.createElement!=Z&&typeof g.appendChild!=Z&&typeof g.replaceChild!=Z&&typeof g.removeChild!=Z&&typeof g.cloneNode!=Z,t=[0,0,0],n=null;if(typeof N.plugins!=Z&&typeof N.plugins[B]==P){n=N.plugins[B].description;if(n){n=n.replace(/^.*\s+(\S+\s+\S+$)/,"$1");t[0]=parseInt(n.replace(/^(.*)\..*$/,"$1"),10);t[1]=parseInt(n.replace(/^.*\.(.*)\s.*$/,"$1"),10);t[2]=/r/.test(n)?parseInt(n.replace(/^.*r(.*)$/,"$1"),10):0}}else{if(typeof G.ActiveXObject!=Z){var o=null,s=false;try{o=new ActiveXObject(h+".7")}catch(k){try{o=new ActiveXObject(h+".6");t=[6,0,21];o.AllowScriptAccess="always"}catch(k){if(t[0]==6){s=true}}if(!s){try{o=new ActiveXObject(h)}catch(k){}}}if(!s&&o){try{n=o.GetVariable("$version");if(n){n=n.split(" ")[1].split(",");t=[parseInt(n[0],10),parseInt(n[1],10),parseInt(n[2],10)]}}catch(k){}}}}var v=N.userAgent.toLowerCase(),j=N.platform.toLowerCase(),r=/webkit/.test(v)?parseFloat(v.replace(/^.*webkit\/(\d+(\.\d+)?).*$/,"$1")):false,i=false,q=j?/win/.test(j):/win/.test(v),m=j?/mac/.test(j):/mac/.test(v);/*@cc_on i=true;@if(@_win32)q=true;@elif(@_mac)m=true;@end@*/return{w3cdom:l,pv:t,webkit:r,ie:i,win:q,mac:m}}();var e=function(){if(!a.w3cdom){return }J(I);if(a.ie&&a.win){try{g.write("<script id=__ie_ondomload defer=true src=//:><\/script>");var i=c("__ie_ondomload");if(i){i.onreadystatechange=function(){if(this.readyState=="complete"){this.parentNode.removeChild(this);V()}}}}catch(j){}}if(a.webkit&&typeof g.readyState!=Z){Q=setInterval(function(){if(/loaded|complete/.test(g.readyState)){V()}},10)}if(typeof g.addEventListener!=Z){g.addEventListener("DOMContentLoaded",V,null)}M(V)}();function V(){if(S){return }if(a.ie&&a.win){var m=Y("span");try{var l=g.getElementsByTagName("body")[0].appendChild(m);l.parentNode.removeChild(l)}catch(n){return }}S=true;if(Q){clearInterval(Q);Q=null}var j=f.length;for(var k=0;k<j;k++){f[k]()}}function J(i){if(S){i()}else{f[f.length]=i}}function M(j){if(typeof G.addEventListener!=Z){G.addEventListener("load",j,false)}else{if(typeof g.addEventListener!=Z){g.addEventListener("load",j,false)}else{if(typeof G.attachEvent!=Z){G.attachEvent("onload",j)}else{if(typeof G.onload=="function"){var i=G.onload;G.onload=function(){i();j()}}else{G.onload=j}}}}}function I(){var l=H.length;for(var j=0;j<l;j++){var m=H[j].id;if(a.pv[0]>0){var k=c(m);if(k){H[j].width=k.getAttribute("width")?k.getAttribute("width"):"0";H[j].height=k.getAttribute("height")?k.getAttribute("height"):"0";if(O(H[j].swfVersion)){if(a.webkit&&a.webkit<312){U(k)}X(m,true)}else{if(H[j].expressInstall&&!C&&O("6.0.65")&&(a.win||a.mac)){D(H[j])}else{d(k)}}}}else{X(m,true)}}}function U(m){var k=m.getElementsByTagName(P)[0];if(k){var p=Y("embed"),r=k.attributes;if(r){var o=r.length;for(var n=0;n<o;n++){if(r[n].nodeName.toLowerCase()=="data"){p.setAttribute("src",r[n].nodeValue)}else{p.setAttribute(r[n].nodeName,r[n].nodeValue)}}}var q=k.childNodes;if(q){var s=q.length;for(var l=0;l<s;l++){if(q[l].nodeType==1&&q[l].nodeName.toLowerCase()=="param"){p.setAttribute(q[l].getAttribute("name"),q[l].getAttribute("value"))}}}m.parentNode.replaceChild(p,m)}}function F(i){if(a.ie&&a.win&&O("8.0.0")){G.attachEvent("onunload",function(){var k=c(i);if(k){for(var j in k){if(typeof k[j]=="function"){k[j]=function(){}}}k.parentNode.removeChild(k)}})}}function D(j){C=true;var o=c(j.id);if(o){if(j.altContentId){var l=c(j.altContentId);if(l){L=l;T=j.altContentId}}else{L=b(o)}if(!(/%$/.test(j.width))&&parseInt(j.width,10)<310){j.width="310"}if(!(/%$/.test(j.height))&&parseInt(j.height,10)<137){j.height="137"}g.title=g.title.slice(0,47)+" - Flash Player Installation";var n=a.ie&&a.win?"ActiveX":"PlugIn",k=g.title,m="MMredirectURL="+G.location+"&MMplayerType="+n+"&MMdoctitle="+k,p=j.id;if(a.ie&&a.win&&o.readyState!=4){var i=Y("div");p+="SWFObjectNew";i.setAttribute("id",p);o.parentNode.insertBefore(i,o);o.style.display="none";G.attachEvent("onload",function(){o.parentNode.removeChild(o)})}R({data:j.expressInstall,id:K,width:j.width,height:j.height},{flashvars:m},p)}}function d(j){if(a.ie&&a.win&&j.readyState!=4){var i=Y("div");j.parentNode.insertBefore(i,j);i.parentNode.replaceChild(b(j),i);j.style.display="none";G.attachEvent("onload",function(){j.parentNode.removeChild(j)})}else{j.parentNode.replaceChild(b(j),j)}}function b(n){var m=Y("div");if(a.win&&a.ie){m.innerHTML=n.innerHTML}else{var k=n.getElementsByTagName(P)[0];if(k){var o=k.childNodes;if(o){var j=o.length;for(var l=0;l<j;l++){if(!(o[l].nodeType==1&&o[l].nodeName.toLowerCase()=="param")&&!(o[l].nodeType==8)){m.appendChild(o[l].cloneNode(true))}}}}}return m}function R(AE,AC,q){var p,t=c(q);if(typeof AE.id==Z){AE.id=q}if(a.ie&&a.win){var AD="";for(var z in AE){if(AE[z]!=Object.prototype[z]){if(z=="data"){AC.movie=AE[z]}else{if(z.toLowerCase()=="styleclass"){AD+=' class="'+AE[z]+'"'}else{if(z!="classid"){AD+=" "+z+'="'+AE[z]+'"'}}}}}var AB="";for(var y in AC){if(AC[y]!=Object.prototype[y]){AB+='<param name="'+y+'" value="'+AC[y]+'" />'}}t.outerHTML='<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"'+AD+">"+AB+"</object>";F(AE.id);p=c(AE.id)}else{if(a.webkit&&a.webkit<312){var AA=Y("embed");AA.setAttribute("type",W);for(var x in AE){if(AE[x]!=Object.prototype[x]){if(x=="data"){AA.setAttribute("src",AE[x])}else{if(x.toLowerCase()=="styleclass"){AA.setAttribute("class",AE[x])}else{if(x!="classid"){AA.setAttribute(x,AE[x])}}}}}for(var w in AC){if(AC[w]!=Object.prototype[w]){if(w!="movie"){AA.setAttribute(w,AC[w])}}}t.parentNode.replaceChild(AA,t);p=AA}else{var s=Y(P);s.setAttribute("type",W);for(var v in AE){if(AE[v]!=Object.prototype[v]){if(v.toLowerCase()=="styleclass"){s.setAttribute("class",AE[v])}else{if(v!="classid"){s.setAttribute(v,AE[v])}}}}for(var u in AC){if(AC[u]!=Object.prototype[u]&&u!="movie"){E(s,u,AC[u])}}t.parentNode.replaceChild(s,t);p=s}}return p}function E(k,i,j){var l=Y("param");l.setAttribute("name",i);l.setAttribute("value",j);k.appendChild(l)}function c(i){return g.getElementById(i)}function Y(i){return g.createElement(i)}function O(k){var j=a.pv,i=k.split(".");i[0]=parseInt(i[0],10);i[1]=parseInt(i[1],10);i[2]=parseInt(i[2],10);return(j[0]>i[0]||(j[0]==i[0]&&j[1]>i[1])||(j[0]==i[0]&&j[1]==i[1]&&j[2]>=i[2]))?true:false}function A(m,j){if(a.ie&&a.mac){return }var l=g.getElementsByTagName("head")[0],k=Y("style");k.setAttribute("type","text/css");k.setAttribute("media","screen");if(!(a.ie&&a.win)&&typeof g.createTextNode!=Z){k.appendChild(g.createTextNode(m+" {"+j+"}"))}l.appendChild(k);if(a.ie&&a.win&&typeof g.styleSheets!=Z&&g.styleSheets.length>0){var i=g.styleSheets[g.styleSheets.length-1];if(typeof i.addRule==P){i.addRule(m,j)}}}function X(k,i){var j=i?"visible":"hidden";if(S){c(k).style.visibility=j}else{A("#"+k,"visibility:"+j)}}return{registerObject:function(l,i,k){if(!a.w3cdom||!l||!i){return }var j={};j.id=l;j.swfVersion=i;j.expressInstall=k?k:false;H[H.length]=j;X(l,false)},getObjectById:function(l){var i=null;if(a.w3cdom&&S){var j=c(l);if(j){var k=j.getElementsByTagName(P)[0];if(!k||(k&&typeof j.SetVariable!=Z)){i=j}else{if(typeof k.SetVariable!=Z){i=k}}}}return i},embedSWF:function(n,u,r,t,j,m,k,p,s){if(!a.w3cdom||!n||!u||!r||!t||!j){return }r+="";t+="";if(O(j)){X(u,false);var q=(typeof s==P)?s:{};q.data=n;q.width=r;q.height=t;var o=(typeof p==P)?p:{};if(typeof k==P){for(var l in k){if(k[l]!=Object.prototype[l]){if(typeof o.flashvars!=Z){o.flashvars+="&"+l+"="+k[l]}else{o.flashvars=l+"="+k[l]}}}}J(function(){R(q,o,u);if(q.id==u){X(u,true)}})}else{if(m&&!C&&O("6.0.65")&&(a.win||a.mac)){X(u,false);J(function(){var i={};i.id=i.altContentId=u;i.width=r;i.height=t;i.expressInstall=m;D(i)})}}},getFlashPlayerVersion:function(){return{major:a.pv[0],minor:a.pv[1],release:a.pv[2]}},hasFlashPlayerVersion:O,createSWF:function(k,j,i){if(a.w3cdom&&S){return R(k,j,i)}else{return undefined}},createCSS:function(j,i){if(a.w3cdom){A(j,i)}},addDomLoadEvent:J,addLoadEvent:M,getQueryParamValue:function(m){var l=g.location.search||g.location.hash;if(m==null){return l}if(l){var k=l.substring(1).split("&");for(var j=0;j<k.length;j++){if(k[j].substring(0,k[j].indexOf("="))==m){return k[j].substring((k[j].indexOf("=")+1))}}}return""},expressInstallCallback:function(){if(C&&L){var i=c(K);if(i){i.parentNode.replaceChild(L,i);if(T){X(T,true);if(a.ie&&a.win){L.style.display="block"}}L=null;T=null;C=false}}}}}();
function addEvent(element, event, func) {

    
	if (element.addEventListener) { // Si notre élément possède la méthode addEventListener()
        element.addEventListener(event, func, false);
    } else { // Si notre élément ne possède pas la méthode addEventListener()
	//alert(element);
        element.attachEvent('on' + event, func);
    }

}
/*******PARTIE PERMETTANT A IE de fonctionner    ********/

function addEvent(element, event, func) {

    if (element.addEventListener) { // Si notre élément possède la méthode addEventListener()
        element.addEventListener(event, func, false);
    } else { // Si notre élément ne possède pas la méthode addEventListener()
        element.attachEvent('on' + event, func);
    }

}

/*******fonction pour quitter********/
function abandonner()
{
	document.location.href="profil_eleve.php";
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
	return false;
	}
	else
	{
	//masquer();
	return true;
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
function insererSas(selec,place)
{
	var reNumber =/[0-9]$/;/*chaine qui se termine par un chiffre*/
	var reChar =/[^0-9]/;/*chaine qui ne contient pas de chiffre*/
	var sas = document.forms['info'].elements['T1'].value;
	
	var PLMot = selec.substring(0,1);//Première lettre du mot
	var maj = new RegExp("[A-Z]");//expression regulière qui reconnait les majuscules
	if(maj.test(PLMot) && place>1)
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
