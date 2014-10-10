/* On crée une fonction de verification */
function verifForm(formulaire)
{
    ExpReg = /\d/;
    x=formulaire.textearea.value;
    for (i=0 ;i<= x.length-1 ;i++)
    {
     if ((x.charAt(i)=="+") || (x.charAt(i)=="-") || (x.charAt(i)==":") || (x.charAt(i)=="x"))
     {
         if ((x.charAt(i-1) != " ") ||(ExpReg.text(x.charAt(i-1))))
         {
             alert(ExpReg.text(x.charAt(i-1)));
			 x = x.substring(0,i) +" " + x.charAt(i) + x.substring (i+1,x.length);
         }
     }
    }
    for (i=0 ;i<= x.length-1;i++)
    {
     if ((x.charAt(i)==",") || (x.charAt(i)=="-") || (x.charAt(i)=="?") || (x.charAt(i)==".")||(x.charAt(i)=="\'"))
      {
        if (x.charAt(i+1) != " ")
         {
             x = x.substring(0,i) + x.charAt(i)+ " " + x.substring (i+1,x.length);
         }
      }
    }
   info.textarea.value=x;
   x=info.textearea.value;
   formulaire.submit(); /* sinon on envoi le formulaire */
}
