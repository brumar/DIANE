// JavaScript Document
function validate() {
	var noBdate = " ";  
	var bday = document.form1.birthDay.selectedIndex;
	var bmonth = document.form1.birthMonth.selectedIndex;
	if (document.form1.birthYear.selectedIndex==0) 
	{
		var byear = document.form1.birthYear.selectedIndex;
	}
	else 
	{
		var byear = document.form1.birthYear.selectedIndex-1;
	}

    var selectedBday = document.form1.birthDay.options[bday].value;
    var selectedBmonth = document.form1.birthMonth.options[bmonth].value;
    var selectedByear = document.form1.birthYear.value;	    
	var leap = 0; 
	if ((byear%4)==0) 
	{
		leap=1;
	}
// if any of the birthdate elements have been set, validate the date
	if (document.form1.nom.value.length < 1) 
	{
		document.form1.nom.focus();
		alert("veuillez entrer votre Nom.");
		return false;
	}
		    
	if (document.form1.prenom.value.length < 1) 
	{
		document.form1.prenom.focus();
		alert("veuillez entrer votre Prenom.");
		return false;
	} 
	
	if (selectedBday==noBdate)
	{
		alert('Veuillez entrer votre jour de naissance.');
		return false;
	}

	if (selectedBmonth==noBdate)
	{
		alert('Veuillez entrer votre mois de naissance.');
		return false;
	}
	
	if (((bmonth==4) || (bmonth==6) || (bmonth==9) || (bmonth==11)) && bday==31)
	{
		 alert("Date Naissance: Ce mois ne contient pas 31 jours. veuillez selectionner le jour entre  1 et 30.");
		 return false;
	 }
	
	//if ((bmonth==2) && (bday>(28+leap))) 
	//{
		// alert('Date Naissance : Il y a que '+(28+leap)+' jour en mois de Fevrier en '+(byear+1930)+'.\nveuillez selectionner un jour entre 1 et '+(28+leap)+'.');
		// return false;
    //}
	
	if (selectedByear==noBdate)
	{
		alert('Veuillez entrer votre année de naissance.');
		return false;
	}
	
	if(document.form1.classe.value==" ")
	{
		alert('Veuillez entrer la classe');
		return false;
	}
	
	return true;		    
}
