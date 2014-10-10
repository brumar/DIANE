<?
$host ="localhost";
$user="root";
$password="";
$database="projet";
$table="diagnostic";
$xmlfile="diag.xml";
function db2xml($host,$user,$password,$database,$table,$xml_file)
{

$create_xml = fopen($xml_file,"w");
fwrite($create_xml,"<xml>rn<table>rn");

mysql_connect($host, $user, $password);
$req = mysql_db_query($database, "select * from $table where  numDiag=9");
while($row = mysql_fetch_array($req))
{
    fwrite($create_xml,"<element>rn");
    for($j=0;$test=each($row);$j++)
    {
        if($j%2)
        {
            fwrite($create_xml,"<$test[0]>$test[1]</$test[0]>rn");
        }
    }
    fwrite($create_xml,"</element>rn");
}
fwrite($create_xml,"</table>rn</xml>");
fclose($create_xml);
mysql_free_result($req);
}
?>