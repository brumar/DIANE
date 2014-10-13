<?php
$text = "12.5+2.5=31.509 le ;2-5 re-sulat est 3 \n 12*2=12 la! so.lu.tion. est 12?";
print($text.'<br>');
$calcules = trim(preg_replace('/[a-zA-Z](\s)*-(\s)*[a-zA-Z]|[^+*:=\d+)]/', " ",$text));
print($calcules."<br>");
 $tabCal =  preg_split ("/[\s]+/", $calcules);
 for ($i=0; $i < count($tabCal) ; $i++)
	{
	switch ($tabCal[$i])
		{
		case "+" : if (($tabCal[$i+2]=="=") and (($tabCal[$i-2]=="") || (ereg("[^-\+]",$tabCal[$i-2]))))
					 {
						 $tabOperation[]=$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
					 }
				   else if (($tabCal[$i+2]=="=")and(($tabCal[$i-2]=="+")||($tabCal[$i-2]=="-"))and(($tabCal[$i-4]=="+")||($tabCal[$i-4]=="-"))and(($tabCal[$i-6]=="+")||($tabCal[$i-6]=="-")))
						 {
							 $tabOperation[] =$tabCal[$i-7].$tabCal[$i-6].$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
							 $tabOperation2[]=$tabCal[$i-7].$tabCal[$i-6].$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
						 }
				   else if (($tabCal[$i+2]=="=")and(($tabCal[$i-2]=="+")||($tabCal[$i-2]=="-"))and(($tabCal[$i-4]=="+")||($tabCal[$i-4]=="-")))
						 {
							 $tabOperation[] =$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
							 $tabOperation2[]=$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
						 }
				   else if (($tabCal[$i+2]=="=")and(($tabCal[$i-2]=="+")||($tabCal[$i-2]=="-")))
						 {
							 $tabOperation[] =$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
							 $tabOperation2[]=$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
						 }
				   else if (ereg("[0-9]",$tabCal[$i+2])|| $tabCal[$i+2]=="")
								$tabOperation[] =$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1];
				 break;
		case "-" :if (($tabCal[$i+2]=="=") && ((ereg("[^\+\-]",$tabCal[$i-2]))||($tabCal[$i-2]=="")))
					 {
						 $tabOperation[] = $tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
					 }
				    else if (($tabCal[$i+2]=="=")and(($tabCal[$i-2]=="+")||($tabCal[$i-2]=="-"))and(($tabCal[$i-4]=="+")||($tabCal[$i-4]=="-"))and(($tabCal[$i-6]=="+")||($tabCal[$i-6]=="-")))
						 {
							 $tabOperation[] =$tabCal[$i-7].$tabCal[$i-6].$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
							 $tabOperation2[]=$tabCal[$i-7].$tabCal[$i-6].$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
						 }
				   else if (($tabCal[$i+2]=="=")and(($tabCal[$i-2]=="+")||($tabCal[$i-2]=="-"))and(($tabCal[$i-4]=="+")||($tabCal[$i-4]=="-")))
						 {
							 $tabOperation[] =$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
							 $tabOperation2[]=$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
						 }
				   else if (($tabCal[$i+2]=="=")and(($tabCal[$i-2]=="+")||($tabCal[$i-2]=="-")))
						 {
							 $tabOperation[] =$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
							 $tabOperation2[]=$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
						 }
				   else if (ereg("[0-9]",$tabCal[$i+2])|| $tabCal[$i+2]=="")
								$tabOperation[] =$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1];
					 break;
		case "*" :if (($tabCal[$i+2]=="=") && ((ereg("[^\*\:]",$tabCal[$i-2]))||($tabCal[$i-2]=="")))
					 {
						 $tabOperation[] = $tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
					 }
				    else if (($tabCal[$i+2]=="=")and(($tabCal[$i-2]=="*")||($tabCal[$i-2]==":"))and(($tabCal[$i-4]=="*")||($tabCal[$i-4]==":"))and(($tabCal[$i-6]=="*")||($tabCal[$i-6]==":")))
						 {
							 $tabOperation[] =$tabCal[$i-7].$tabCal[$i-6].$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
							 $tabOperation2[]=$tabCal[$i-7].$tabCal[$i-6].$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
						 }
				   else if (($tabCal[$i+2]=="=")and(($tabCal[$i-2]=="*")||($tabCal[$i-2]==":"))and(($tabCal[$i-4]=="*")||($tabCal[$i-4]==":")))
						 {
							 $tabOperation[] =$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
							 $tabOperation2[]=$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
						 }
				   else if (($tabCal[$i+2]=="=")and(($tabCal[$i-2]=="*")||($tabCal[$i-2]==":")))
						 {
							 $tabOperation[] =$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
							 $tabOperation2[]=$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
						 }
				   else if (ereg("[0-9]",$tabCal[$i+2])|| $tabCal[$i+2]=="")
								$tabOperation[] =$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1];
				   break;

		case ":" : if (($tabCal[$i+2]=="=") && ((ereg("[^\*\:]",$tabCal[$i-2]))||($tabCal[$i-2]=="")))
					 {
						 $tabOperation[] = $tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
					 }
				   else if (($tabCal[$i+2]=="=")and(($tabCal[$i-2]=="*")||($tabCal[$i-2]==":"))and(($tabCal[$i-4]=="*")||($tabCal[$i-4]==":"))and(($tabCal[$i-6]=="*")||($tabCal[$i-6]==":")))
						 {
							 $tabOperation[] =$tabCal[$i-7].$tabCal[$i-6].$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
							 $tabOperation2[]=$tabCal[$i-7].$tabCal[$i-6].$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
						 }
				   else if (($tabCal[$i+2]=="=")and(($tabCal[$i-2]=="*")||($tabCal[$i-2]==":"))and(($tabCal[$i-4]=="*")||($tabCal[$i-4]==":")))
						 {
							 $tabOperation[] =$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
							 $tabOperation2[]=$tabCal[$i-5].$tabCal[$i-4].$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
						 }
				   else if (($tabCal[$i+2]=="=")and(($tabCal[$i-2]=="*")||($tabCal[$i-2]==":")))
						 {
							 $tabOperation[] =$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
							 $tabOperation2[]=$tabCal[$i-3].$tabCal[$i-2].$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1].$tabCal[$i+2].$tabCal[$i+3];
						 }
				   else if (ereg("[0-9]",$tabCal[$i+2])|| $tabCal[$i+2]=="")
								$tabOperation[] =$tabCal[$i-1].$tabCal[$i].$tabCal[$i+1];
					 break;
		}

}

print("<br><br>les opérations qui ont été saisie sont : <br>");

print_r($tabOperation); print("<br>");
print_r($tabOperation2); print("<br>");

?>