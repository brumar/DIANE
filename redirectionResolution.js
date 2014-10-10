// JavaScript Document
//fonction de redirection selon la resolution de l'ecran
function redirect_resolution()
{
	if(screen.width < 800) // 640 et -		window.location.href='votre_page_640.html';
			ecran='interface640.css';
	else if(screen.width < 1024) // 800		window.location.href='votre_page_800.html';
		ecran='interface800.css';
	else if(screen.width == 1024) // 1024		window.location.href='votre_page_1024.html';
		ecran='interface1024.css';
	else if(screen.width > 1024) // + de 1280 et +
		ecran='interfaceIE.css';
	return ecran;
}
