// JavaScript Document
<!-- Begin
function verifyNumber(sText) 
{
   var ValidChars = "0123456789.";
   var IsNumber=true;
   var Char;

   for (i = 0; i < sText.value.length && IsNumber == true; i++) 
   { 
      Char = sText.value.charAt(i); 
      if (ValidChars.indexOf(Char) == -1) 
      {
         IsNumber = false;
      }
   }
   
   if( IsNumber == false )
   {
	   alert("Please enter a dollar amount with no dollar sign.");
   }
}
// End -->