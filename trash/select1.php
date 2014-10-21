
<?php

// ------------------------------------------------------------------------- //
// Génère une zone de liste HTML à partir d'une requête MySQL.               //
// ------------------------------------------------------------------------- //
// Auteur: C. Chassagneux                                                    //
// Web:    http://www.the-phoenix.org                                        //
// Email:  cchassagneux@voonoo.net                                           //
// ------------------------------------------------------------------------- //

function Select($Select, $name, $Db_Host, $Db_User, $Db_User_Pass,$Database, $Db_Table) 
{
	  $String_Order = " order by ".$Select." asc";
	  $Tmp_Select = " - à Sélectionner - ";
	
	  $link = mysql_connect ($Db_Host, $Db_User, $Db_User_Pass) or die ("Pb de connection");
	
		  if (!mysql_select_db($Database)) 
		  {
			echo "Base Non Selectionée";
		  }
	
	  $QString_Valid = "select ".$Select." from ".$Db_Table." ".$String_Order; 
	
	  $Res_Valid = mysql_query($QString_Valid) or die ("Erreur ds Qstring_Valid : ".$QString_Valid);
	
	  $Select_String = "<select name='".$name."'>";
	  $Select_End = "</select>";
	
	  while ($Row_Select = mysql_fetch_array($Res_Valid)) {
		if (!($Tmp_Select == $Row_Select[0])) {
		  $Select_String .= "<option value=\"".stripslashes($Tmp_Select)."\" >";
		  $Select_String .= stripslashes($Tmp_Select)."</option>"; 
		  $Tmp_Select = $Row_Select[0];
		}
	  }
	
	  $Select_String = $Select_String.$Select_End;
	
	  mysql_close($link);
	  return $Select_String;
}
print(Select('nom','nom','localhost','root','','projet','eleve'));
?> 