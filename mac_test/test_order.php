<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>None</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script type="text/javascript">

	var listOrder = "id1,id2,id3";

	function init(){

		var nList = document.getElementsByTagName('ul')[0];
		var nEntry = nList.getElementsByTagName('li');	
		var nEntryCopy = [];
		for (i=0; i<nEntry.length; i++)
			{
			 nEntryCopy[nEntryCopy.length] = nEntry[i].firstChild.data;
			}
		while (nList.lastChild)
			{	
			 nList.removeChild(nList.lastChild);
			}	
		listOrder = listOrder.split(",");
		for (i=0; i<nEntryCopy.length; i++)
			{			 
			 var nEntry = document.createElement('li');	
			 nEntry.appendChild(document.createTextNode(nEntryCopy[listOrder[i]-1]));
			 nList.appendChild(nEntry);
			}		
        }	

	navigator.appName == "Microsoft Internet Explorer" ? attachEvent('onload', init, false) : addEventListener('load', init, false);	

</script>
<style type="text/css">

	 body {background-color: #fffacd; margin-top: 60px;}

	
</style>
</head>
	<body>
		<ul>
			<li> One </li>
			<li> Two </li>
			<li> Three </li>
		</ul>
	</body>
</html>