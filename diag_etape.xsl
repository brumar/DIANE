<?xml version="1.0" encoding="iso-8859-1"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output encoding="iso-8859-1"/>
	<xsl:include href="balises.xsl"/>
	<xsl:template match="diagnostic">
		<html>
			<head>
				<title>Diagnostic</title>
			</head>
			<body>
				<xsl:apply-templates select="exercice"/>
			</body>
		</html>
	</xsl:template>
	<xsl:template match="exercice">
		<table width="80%" border="0" align="center">
			<tr>
				<td height="75">
					<table width="90%" border="2" align="center" cellpadding="5" cellspacing="0" bordercolor="#000000" bgcolor="#FFFF99">
						<tr>
							<td width="60%">
								<xsl:copy-of select="enonce"/>
							</td>
							<td width="40%">
								<xsl:copy-of select="reponse"/>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<xsl:value-of select="nom"/>
					<xsl:apply-templates/>
				</td>
			</tr>
		</table>
	</xsl:template>
	<xsl:template match="enonce"/>
	<xsl:template match="reponse"/>
	<xsl:template match="nom"/>
	<xsl:template match="col1">
		<xsl:choose>
			<xsl:when test="@code=0"> a bien résolu le problème.<br/>
			</xsl:when>
			<xsl:when test="@code=1"> a bien résolu le problème.<br/>
			</xsl:when>
			<xsl:when test="@code=2"> a bien résolu le problème à l'exception d'erreurs de calcul.<br/>
			</xsl:when>
			<xsl:when test="@code=3 or @code=43"> n'a pas résolu le problème correctement.<br/>
			</xsl:when>
			<xsl:when test="@code=41"> a fait plusieurs calculs. L'un des calculs correspond à la bonne opération.<br/>
			</xsl:when>
			<xsl:when test="@code=42"> a fait plusieurs calculs. L'un des calculs correspond à la bonne opération, mais il comporte une erreur de calcul.<br/>
			</xsl:when>
		</xsl:choose>
	</xsl:template>
	<xsl:template match="prenom">
		<xsl:choose>
			<xsl:when test="@col1!=9">
				<xsl:value-of select="."/> a procédé de la manière suivante :<br/>
			</xsl:when>
		</xsl:choose>
	</xsl:template>
	<xsl:template match="nbOper">
		<xsl:choose>
			<xsl:when test="@nbOper>1 and @calImp=0">Sa résolution s'est faite en <xsl:value-of select="."/> calculs explicites.<br/>
			</xsl:when>
			<xsl:when test="@nbOper>1 and @calImp=1">Sa résolution s'est faite en <xsl:value-of select="."/> calculs explicites et un ou plusieurs calculs implicites.<br/>
			</xsl:when>
			<xsl:when test="@nbOper=1 and @calImp=0">Sa résolution s'est faite en <xsl:value-of select="."/> calcul explicite.<br/>
			</xsl:when>
			<xsl:when test="@nbOper=1 and @calImp=1">Sa résolution s'est faite en <xsl:value-of select="."/> calcul explicite et un ou plusieurs calculs implicites.<br/>
			</xsl:when>
			<xsl:when test="@nbOper=0 and @calImp=1 and @sexe='f' and @col1!=9"/>
			<xsl:when test="@nbOper=0 and @calImp=1 and @sexe='m' and @col1!=9"/>
			<xsl:when test="@nbOper=0 and @sexe='f' and @col1!=9">Elle n'a pas posé d'opérations.<br/>
			</xsl:when>
			<xsl:when test="@nbOper=0 and @sexe='m' and @col1!=9">Il n'a pas posé d'opérations.<br/>
			</xsl:when>
		</xsl:choose>
	</xsl:template>
	<xsl:template match="operation">
		<xsl:if test="@sexe='m'">
			<xsl:choose>
				<xsl:when test="@col2=0 and @col3=9 and @col4=0">
				Dans sa résolution, il a fait un calcul implicite qui l'a mené au résultat correct (<xsl:value-of select="res"/>).
			</xsl:when>
				<xsl:when test="@col2=0 and @col3=9 and @col4=9">
				Dans sa résolution, il a fait des calculs implicites. Le résultat donné (<xsl:value-of select="res"/>) n'a pas de sens relativement à l'énoncé.
			</xsl:when>

			<xsl:when test="@col1=1 and @col2=1 and @col5=1">
				Dans sa résolution, il a fait une addition à trou (<xsl:value-of select="op"/>) mais il a fait un mauvais choix dans sa réponse. 
			</xsl:when>
			<xsl:when test="@col1=1 and @col2=1">
				Dans sa résolution, il a fait une addition à trou (<xsl:value-of select="op"/>). 
			</xsl:when>
			
			<xsl:when test="@col1=1 and @col2=2">
				Dans sa résolution, il a fait une soustraction (<xsl:value-of select="op"/>). 
			</xsl:when>
			<xsl:when test="(@col1=1 or @col1=2) and @col2=7">
				Dans sa résolution, il a fait une soustraction à trou (<xsl:value-of select="op"/>). 
			</xsl:when>
				<xsl:when test="@col1=1 and @col2=6">
				Dans sa résolution, il a fait une addition à trou avec une erreur sur le signe de l'opération (<xsl:value-of select="op"/>). 
			</xsl:when>
			<xsl:when test="@col1=1 and @col2=3">
				Dans sa résolution, il a fait une soustraction inversée (<xsl:value-of select="op"/>). 
			</xsl:when>
			<xsl:when test="@type='tout'  and @col1=3 and @col2=4 and nbOper=1">
				Dans sa résolution, il a fait une somme (<xsl:value-of select="op"/>) au lieu d'une soustraction. 
			</xsl:when>
			<xsl:when test="@col1=1 and @col2=4">
				Dans sa résolution, il a fait une addition (<xsl:value-of select="op"/>). 
			</xsl:when>
			<xsl:when test="@type='tout' and @col1=3 and @col2=2 and nbOper=1">
					Dans sa résolution, il fait une difference (<xsl:value-of select="op"/>) au lieu d'une somme <xsl:copy-of select="op"/>
			</xsl:when>
			<xsl:when test="@type='tout' and @col1=3 and @col2=1 and nbOper=1">
					Dans sa résolution, il fait une addition à trou (<xsl:value-of select="op"/>) au lieu d'une somme <xsl:copy-of select="op"/>
			</xsl:when>
			<xsl:when test="@col2=53">
				Dans sa résolution, il a fait une addition avec une erreur sur le signe de l'opperation (<xsl:value-of select="op"/>). 
			</xsl:when>			
			<xsl:when test="@col2=51">
				Dans sa résolution, il a fait un calcul non pertinent (multiplication) avec les données de l'énoncé (<xsl:value-of select="op"/>). 
			</xsl:when>
			<xsl:when test="@col2=52">
				Dans sa résolution, il a fait un calcul non pertinent (soustraction) avec les données de l'énoncé (<xsl:value-of select="op"/>). 
			</xsl:when>
			<xsl:when test="@col2=5">
				Dans sa résolution, il a fait un calcul non pertinent (<xsl:value-of select="op"/>). 
			</xsl:when>
			<xsl:when test="(@col1=2 or @col1=3) and @col2=2">
				Dans sa résolution, il a fait une soustraction (<xsl:value-of select="op"/>). 
			</xsl:when>
			<xsl:when test="(@col1=2 or @col1=3) and @col2=4">
				Dans sa résolution, il a fait une addition (<xsl:value-of select="op"/>). 
			</xsl:when>
			<xsl:when test="@col1=1 and @col2=41">
				Dans sa résolution, il a fait une addition avec une erreur sur le signe de l'opération (<xsl:value-of select="op"/>). 
			</xsl:when>
				<xsl:when test="@col1=41 or @col1=42 or @col1=43">
					<xsl:copy-of select="op"/>
				</xsl:when>
			</xsl:choose>
		</xsl:if>
		<xsl:if test="@sexe='f'">
			<xsl:choose>
				<xsl:when test="@col2=0 and @col3=9 and @col4=0">
				Dans sa résolution, elle a fait un calcul implicite qui l'a mené au résultat correct (<xsl:value-of select="res"/>).
			</xsl:when>
				<xsl:when test="@col2=0 and @col3=9 and @col4=9">
				Dans sa résolution, elle a fait des calculs implicites. Le résultat donné (<xsl:value-of select="res"/>) n'a pas de sens relativement à l'énoncé.
			</xsl:when>
				<xsl:when test="@col1=1 and @col2=1">
				Dans sa résolution, elle a fait une addition à trou (<xsl:value-of select="op"/>). 
			</xsl:when>
			<xsl:when test="@col1=1 and @col2=1 and @col5=1">
				Dans sa résolution, il a fait une addition à trou (<xsl:value-of select="op"/>) mais elle a fait un mauvais choix dans sa réponse. 
			</xsl:when>
			<xsl:when test="@col1=1 and @col2=2">
				Dans sa résolution, elle a fait une soustraction (<xsl:value-of select="op"/>). 
			</xsl:when>
				<xsl:when test="(@col1=1 or @col1=2) and @col2=7">
				Dans sa résolution, elle a fait une soustraction à trou(<xsl:value-of select="op"/>). 
			</xsl:when>
				<xsl:when test="@col1=1 and @col2=6">
				Dans sa résolution, elle a fait une addition à trou avec une erreur sur le signe de l'opération (<xsl:value-of select="op"/>). 
			</xsl:when>
			<xsl:when test="@type='tout'  and @col1=3 and @col2=4 and nbOper=1">
				Dans sa résolution, elle a fait une somme (<xsl:value-of select="op"/>) au lieu d'une soustraction. 
			</xsl:when>
				<xsl:when test="@col1=1 and @col2=4">
				Dans sa résolution, elle a fait une addition (<xsl:value-of select="op"/>). 
			</xsl:when>
				<xsl:when test="@type='tout' and @col1=3 and @col2=2 and nbOper=1">
					Dans sa résolution, elle fait une difference (<xsl:value-of select="op"/>) au lieu d'une somme
				<xsl:copy-of select="op"/>
				</xsl:when>
			<xsl:when test="@col2=53">
				Dans sa résolution, elle a fait une addition avec une erreur sur le signe de l'opperation (<xsl:value-of select="op"/>). 
			</xsl:when>			
			<xsl:when test="@col2=51">
				Dans sa résolution, elle a fait un calcul non pertinent (multiplication) avec les données de l'énoncé (<xsl:value-of select="op"/>). 
			</xsl:when>
			<xsl:when test="@col2=52">
				Dans sa résolution, elle a fait un calcul non pertinent (soustraction) avec les données de l'énoncé (<xsl:value-of select="op"/>). 
			</xsl:when>
			<xsl:when test="@col2=5">
				Dans sa résolution, elle a fait un calcul non pertinent (<xsl:value-of select="op"/>). 
			</xsl:when>
				<xsl:when test="(@col1=2 or @col1=3) and @col2=2">
				Dans sa résolution, elle a fait une soustraction (<xsl:value-of select="op"/>). 
			</xsl:when>
			<xsl:when test="(@col1=2 or @col1=3) and @col2=4">
				Dans sa résolution, elle a fait une addition (<xsl:value-of select="op"/>). 
			</xsl:when>
			<xsl:when test="@col1=2 and @col2=41">
				Dans sa résolution, il a fait une addition avec une erreur sur le signe de l'opération (<xsl:value-of select="op"/>). 
			</xsl:when>
				<xsl:when test="@col1=41 or @col1=42 or @col1=43">
					<xsl:copy-of select="op"/>
				</xsl:when>
			</xsl:choose>
		</xsl:if>
	</xsl:template>
	<xsl:template match="col4">
		<xsl:if test="@sexe='m'">
			<xsl:choose>
				<xsl:when test="@col4=0 and @col3=0 and @nbOper=1 and @col5=1" > Il n'a pas fait d'erreur de calcul (<xsl:value-of select="res"/>), mais il a fait un mauvais choix dans sa réponse (<xsl:value-of select="resErr"/>).
				</xsl:when>
				<xsl:when test="@col4=0 and @col3=0 and @nbOper=1 and @col5=11" > Il n'a pas fait d'erreur de calcul (<xsl:value-of select="res"/>), mais il a fait une erreur de recopie du résultat (<xsl:value-of select="resErr"/>).
				</xsl:when>
				<xsl:when test="@col4=0 and @col3=0 and @nbOper=1"> Il n'a pas fait d'erreur de calcul (<xsl:value-of select="res"/>).</xsl:when>
				<xsl:when test="@col4=0 and @col3=1 and @nbOper=1"> Il a utilisé des données qui ne correspondent pas à l'énoncé, mais le résultat de son calcul est correct (<xsl:value-of select="res"/>) relativement à l'opération.</xsl:when>
				<xsl:when test="@col4=1 and @col3=0 and @nbOper=1"> Il a fait une erreur de calcul (<xsl:value-of select="res"/>).</xsl:when>
				<xsl:when test="@col4=2 and @col3=0 and @nbOper=1"> Il a fait une erreur de calcul (<xsl:value-of select="res"/>).</xsl:when>
				<xsl:when test="@col4=9 and @col3=9"/>
			</xsl:choose>
		</xsl:if>
		<xsl:if test="@sexe='f'">
			<xsl:choose>
				<xsl:when test="@col4=0 and @col3=0 and @nbOper=1 and @col5=1" > Elle n'a pas fait d'erreur de calcul (<xsl:value-of select="res"/>), mais elle a fait un mauvais choix dans sa réponse (<xsl:value-of select="resErr"/>).
				</xsl:when>
				<xsl:when test="@col4=0 and @col3=0 and @nbOper=1 and @col5=11" > Elle n'a pas fait d'erreur de calcul (<xsl:value-of select="res"/>), mais elle a fait une erreur de recopie du résultat (<xsl:value-of select="resErr"/>).
				</xsl:when>
				<xsl:when test="@col4=0 and @col3=0 and @nbOper=1"> Elle n'a pas fait d'erreur de calcul (<xsl:value-of select="res"/>).</xsl:when>
				<xsl:when test="@col4=0 and @col3=1 and @nbOper=1"> Elle a utilisé des données qui ne correspondent pas à l'énoncé, mais le résultat de son calcul est correct (<xsl:value-of select="res"/>) relativement à l'opération.</xsl:when>
				<xsl:when test="@col4=1 and @col3=0 and @nbOper=1"> Elle a fait une erreur de calcul (<xsl:value-of select="res"/>).</xsl:when>
				<xsl:when test="@col4=2 and @col3=0 and @nbOper=1"> Elle a fait une erreur de calcul (<xsl:value-of select="res"/>).</xsl:when>
				<xsl:when test="@col4=9 and @col3=9"/>
			</xsl:choose>
		</xsl:if>
	</xsl:template>
</xsl:stylesheet>
