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
							<td>
								<xsl:copy-of select="enonce"/>
							</td>
							<td>
								<xsl:copy-of select="reponse"/>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<xsl:value-of select="nom"/>
					<xsl:value-of select="resolution"/>.<br/>
					<xsl:apply-templates/>
				</td>
			</tr>
		</table>
	</xsl:template>
	<xsl:template match="enonce"/>
	<xsl:template match="reponse"/>
	<xsl:template match="nom"/>
	<xsl:template match="resolution"/>
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
			<xsl:when test="@nbOper=0 and @sexe='f' and @col1!=9">Elle n'a pas posé d'opération.<br/>
			</xsl:when>
			<xsl:when test="@nbOper=0 and @sexe='m' and @col1!=9">Il n'a pas posé d'opération.<br/>
			</xsl:when>
		</xsl:choose>
	</xsl:template>
	<xsl:template match="colonne1">
		<xsl:if test="@sexe='f'">
			<xsl:choose>
				<xsl:when test="@code=1">Cette élève a calculé la partie manquante en faisant </xsl:when>
				<xsl:when test="@code=2 and @type='e' and @q='p' and @col16=0">Cette élève a calculé l'écart entre la valeur du tout initial (<xsl:value-of select="tout1"/>) et la valeur du tout final (<xsl:value-of select="tout2"/>) </xsl:when>
				<xsl:when test="@code=2 and @type='e' and @q='t' and @col16=0">Cette élève a calculé l'écart entre la valeur de la partie initiale (<xsl:value-of select="partie1"/>) et la valeur de la partie finale (<xsl:value-of select="partie3"/>) </xsl:when>
				<xsl:when test="@code=2 and @type='a' and @q='p' and @col16=0">Cette élève a calculé directement la solution en utilisant l'écart (<xsl:value-of select="valdiff"/>) entre la valeur de la partie initiale (<xsl:value-of select="partie1"/>) et la valeur recherchée. </xsl:when>
				<xsl:when test="@code=2 and @type='a' and @q='t' and @col16=0">Cette élève a calculé directement la solution en utilisant l'écart (<xsl:value-of select="valdiff"/>) entre la valeur du tout initial (<xsl:value-of select="tout1"/>) et la valeur recherchée. </xsl:when>
				<xsl:when test="@code=2 and @type='a' and @q='p' and @col16=4">Cette élève a calculé directement la solution en utilisant l'écart (<xsl:value-of select="valdiff"/>) entre la valeur du tout initial (<xsl:value-of select="tout1"/>) et la valeur recherchée. 
				</xsl:when>
				<xsl:when test="@code=2 and @type='a' and @q='t' and @col16=4">
				Cette élève a calculé directement la solution en utilisant l'écart (<xsl:value-of select="valdiff"/>) entre la valeur de la partie initiale (<xsl:value-of select="partie1"/>) et la valeur recherchée. 
				</xsl:when>
				<xsl:when test="@code=3">Cette élève a calculé la partie manquante en faisant </xsl:when>
				<xsl:when test="@code=4 and @nbOper>1 and @col2!=9">Cette élève a fait </xsl:when>
				<xsl:when test="@code=4 and @nbOper=1 and @col2=9"/>
				<xsl:when test="@code=4 and @nbOper=1 and @col2!=9"> Cette élève a fait </xsl:when>
				<xsl:when test="@code=5"> Elle a utilisé une stratégie non identifiée qui l'a </xsl:when>
				<xsl:when test="@code=6"> Elle a effectué des calculs mentaux non identifiés. </xsl:when>
				<xsl:when test="@code=7"> Cette élève a réalisé l'opération de comparaison </xsl:when>
				<xsl:otherwise/>
			</xsl:choose>
		</xsl:if>
		<xsl:if test="@sexe='m'">
			<xsl:choose>
				<xsl:when test="@code=1">Cet élève a calculé la partie manquante, en faisant </xsl:when>
				<xsl:when test="@code=2 and @type='e' and @q='p' and @col16=0">Cet élève a calculé l'écart entre la valeur du tout initial (<xsl:value-of select="tout1"/>) et la valeur du tout final (<xsl:value-of select="tout2"/>) </xsl:when>
				<xsl:when test="@code=2 and @type='e' and @q='t' and @col16=0">Cet élève a calculé l'écart entre la valeur de la partie initiale (<xsl:value-of select="partie1"/>) et la valeur de la partie finale (<xsl:value-of select="partie3"/>) </xsl:when>
				<xsl:when test="@code=2 and @type='a' and @q='p' and @col16=0">Cet élève a calculé directement la solution en utilisant l'écart (<xsl:value-of select="valdiff"/>) entre la valeur de la partie initiale (<xsl:value-of select="partie1"/>) et la valeur recherchée. </xsl:when>
				<xsl:when test="@code=2 and @type='a' and @q='t' and @col16=0">Cet élève a calculé directement la solution en utilisant l'écart (<xsl:value-of select="valdiff"/>) entre la valeur du tout initial (<xsl:value-of select="tout1"/>) et la valeur recherchée. </xsl:when>
				<xsl:when test="@code=2 and @type='a' and @q='p' and @col16=4">
				Cet élève a calculé directement la solution en utilisant l'écart (<xsl:value-of select="valdiff"/>) entre la valeur du tout initial (<xsl:value-of select="tout1"/>) et la valeur recherchée. 
				</xsl:when>
				<xsl:when test="@code=2 and @type='a' and @q='t' and @col16=4">
				Cet élève a calculé directement la solution en utilisant l'écart (<xsl:value-of select="valdiff"/>) entre la valeur de la partie initiale (<xsl:value-of select="partie1"/>) et la valeur recherchée. 
				</xsl:when>
				<xsl:when test="@code=3">Cet élève a calculé la partie manquante, en faisant </xsl:when>
				<xsl:when test="@code=4 and @nbOper>=1 and @col2!=9">Cet élève a fait </xsl:when>
				<xsl:when test="@code=4 and @nbOper=1 and @col2!=9">Cet élève a fait </xsl:when>
				<xsl:when test="@code=4 and @nbOper=1 and @col2=9"/>
				<xsl:when test="@code=5"> Il a utilisé une stratégie non identifiée qui l'a </xsl:when>
				<xsl:when test="@code=6"> Il a effectué des calculs mentaux non identifiés. </xsl:when>
				<xsl:when test="@code=7"> Cet élève a réalisé l'opération de comparaison, </xsl:when>
				<xsl:otherwise/>
			</xsl:choose>
		</xsl:if>
	</xsl:template>
	<xsl:template match="colonne2">
		<xsl:choose>
			<xsl:when test="@code='0' and @col1=6 and @sexe='m'">
				<br/>Cet élève a calculé la partie manquante, en faisant le calcul de manière implicite. </xsl:when>
			<xsl:when test="@code='0' and @col1=6 and @sexe='f'">
				<br/>Cette élève a calculé la partie manquante, en faisant  le calcul de manière implicite. </xsl:when>
			<xsl:when test="@code='0'">le calcul de manière implicite. </xsl:when>
			<xsl:when test="@code='1' or @code='2' or @code='20' or @code='3' or @code='7'"> une <xsl:value-of select="."/>. </xsl:when>
			<xsl:when test="@code=4">une <xsl:value-of select="."/>.</xsl:when>
			<xsl:when test="@code=5">un calcul erroné <xsl:value-of select="op"/>.</xsl:when>
			<xsl:when test="@code=61">une addition de tous les termes de l'énoncé <xsl:value-of select="op"/>.</xsl:when>
			<xsl:when test="@code=61">un calcul erroné <xsl:value-of select="op"/>.</xsl:when>
		</xsl:choose>
	</xsl:template>
	<xsl:template match="colonne4">
		<xsl:if test="@sexe='m'">
			<xsl:choose>
				<xsl:when test="@code='0'"> Il n'a pas fait d'erreur de calcul <xsl:value-of select="./res"/>. </xsl:when>
				<xsl:when test="@code='1' or @code='2'"> Il a fait une <xsl:value-of select="."/> de calcul. </xsl:when>
				<xsl:when test="9"/>
			</xsl:choose>
		</xsl:if>
		<xsl:if test="@sexe='f'">
			<xsl:choose>
				<xsl:when test="@code='0'"> Elle n'a pas fait d'erreur de calcul <xsl:value-of select="./res"/>. </xsl:when>
				<xsl:when test="@code='1' or @code='2'"> Elle a fait une <xsl:value-of select="."/> de calcul. </xsl:when>
				<xsl:when test="9"/>
			</xsl:choose>
		</xsl:if>
	</xsl:template>
	<xsl:template match="colonne3">
		<xsl:choose>
			<xsl:when test="@code=0 and @col2=4"> Le résultat de cette opération n'a pas de sens relativement à l'énoncé. </xsl:when>
			<xsl:when test="@code=1 and @col1=4 and @col2=2"> Le résultat de cette opération n'a pas de sens relativement à l'énoncé. </xsl:when>
			<!-- <xsl:when test="@code=1">les données utilisées pour son opération sont <xsl:value-of select="."/>, </xsl:when>
            <xsl:when test="@code=9"></xsl:when>-->
		</xsl:choose>
	</xsl:template>
	<xsl:template match="colonne6">
		<xsl:if test="@sexe='m'">
			<xsl:choose>
				<xsl:when test="@code='0' and @nbOper=0 and @col14!=9 and @col2=9"><br/>Il a réalisé l'opération de comparaison à partir de calculs mentaux</xsl:when>				
				<xsl:when test="@code='0' and @nbOper=0 and @col14!=9 and @col2!=9"><br/>En outre, il a réalisé l'opération de comparaison à partir de calculs mentaux </xsl:when>
				<xsl:when test="(@code='1' or @code='2' or @code='21' or @code='3' or @code='4' or @code='7') and (@col2=9)">Il a réalisé l'opération de comparaison par une <xsl:value-of select="."/></xsl:when>
				<xsl:when test="@code='0' and @nbOper=0 and @col14=9 and @col2=9">Il a fait un calcul implicite qui correspond au calcul de la comparaison</xsl:when>
				<xsl:when test="@code='0' and @nbOper=0 and @col14=9 and @col2=0"><br/>Pour le calcul final, il a fait un calcul implicite qui correspond au calcul de la comparaison</xsl:when>
				<xsl:when test="@code='0' and @str='7' and @col14!=9">à partir de calculs mentaux</xsl:when>
				<xsl:when test="@code='0' and @col14!=9 and @col2=9">Il a réalisé l'opération de comparaison à partir de calculs mentaux</xsl:when>
				<xsl:when test="@code='0' and @col14!=9"><br/>En outre, il a réalisé l'opération de comparaison à partir de calculs mentaux</xsl:when>
				<xsl:when test="(@code='1' or @code='2' or @code='21' or @code='3' or @code='4' or @code='7') and (@str='7')">par une <xsl:value-of select="."/><xsl:text>, </xsl:text></xsl:when>
				<xsl:when test="(@code='1' or @code='2' or @code='21' or @code='3' or @code='4' or @code='7') and (@col7=1)"><br/>En outre, il a fait une opération de comparaison reposant sur des données erronées. Il a utilisé une <xsl:value-of select="."/><xsl:text>et </xsl:text></xsl:when>
				<xsl:when test="@code='1' or @code='2' or @code='21'or @code='3' or @code='4' or @code='7'"><br/>En outre, il a réalisé l'opération de comparaison par une <xsl:value-of select="."/></xsl:when>
			</xsl:choose>
		</xsl:if>
		<xsl:if test="@sexe='f'">
			<xsl:choose>
				<xsl:when test="@code='0' and @nbOper=0 and @col14!=9 and @col2=9"><br/>Elle a réalisé l'opération de comparaison à partir de calculs mentaux</xsl:when>	
				<xsl:when test="@code='0' and @nbOper=0 and @col14!=9 and @col2!=9">	<br/>En outre, elle a réalisé l'opération de comparaison à partir de calculs mentaux</xsl:when>
				<xsl:when test="(@code='1' or @code='2' or @code='21' or @code='3' or @code='4' or @code='7') and (@col2=9)">Elle a réalisé l'opération de comparaison par une <xsl:value-of select="."/></xsl:when>
				<xsl:when test="@code='0' and @nbOper=0 and @col14=9 and @col2=9">Elle a fait un calcul implicite qui correspond au calcul de la comparaison</xsl:when>
				<xsl:when test="@code='0' and @nbOper=0 and @col14=9 and @col2=0"><br/>Pour le calcul final, elle a fait un calcul implicite qui correspond au calcul de la comparaison</xsl:when>
				<xsl:when test="@code='0' and @str='7' and @col14!=9">à partir de calculs mentaux</xsl:when>
				<xsl:when test="@code='0' and @col14!=9 and @col2=9">Elle a réalisé l'opération de comparaison à partir de calculs mentaux</xsl:when>
				<xsl:when test="@code='0' and @col14!=9"><br/>En outre, elle a réalisé l'opération de comparaison à partir de calculs mentaux</xsl:when>
				<xsl:when test="(@code='1' or @code='2' or @code='21' or @code='3' or @code='4' or @code='7') and (@str='7')">par une <xsl:value-of select="."/></xsl:when>
				<xsl:when test="(@code='1' or @code='2' or @code='21' or @code='3' or @code='4' or @code='7') and (@col7=1)">
					<br/>En outre, elle a fait une opération de comparaison reposant sur des données erronées. Elle a utilisé une <xsl:value-of select="."/>
					<xsl:text>et </xsl:text>
				</xsl:when>
				<xsl:when test="@code='1' or @code='2' or @code='21' or @code='3' or @code='4' or @code='7'">
					<br/>En outre, elle a réalisé l'opération de comparaison par une <xsl:value-of select="."/>
				</xsl:when>
			</xsl:choose>
		</xsl:if>
	</xsl:template>
	<xsl:template match="colonne7">
		<!-- <xsl:choose>
            <xsl:when test="@code=0">les données utilisées pour son opération sont <xsl:value-of select="."/>, </xsl:when>
            <xsl:when test="@code=1">les données utilisées pour son opération sont <xsl:value-of select="."/>, </xsl:when>
            <xsl:when test="@code=9"></xsl:when>
        </xsl:choose>-->
	</xsl:template>
	<xsl:template match="colonne8">
		<xsl:if test="@sexe='m'">
			<xsl:choose>
				<xsl:when test="@code='0' and @col14!=9">, il a trouvé un résultat de calcul correct <xsl:value-of select="res"/>. </xsl:when>
				<xsl:when test="@code='0' and @col14=9 and @col2=9">, le résultat du calcul est correct <xsl:value-of select="res"/>. Mais, son calcul ne correspond pas au calcul final attendu.</xsl:when>
				<xsl:when test="@code='0' and @col14=9"><xsl:value-of select="res"/>, mais pas au calcul final attendu.</xsl:when>
				<xsl:when test="@code='1' or @code='2'">, il a fait une <xsl:value-of select="."/> de calcul. </xsl:when>
				<xsl:when test="@code='8'">.</xsl:when>
				<xsl:when test="9"/>
			</xsl:choose>
		</xsl:if>
		<xsl:if test="@sexe='f'">
			<xsl:choose>
				<xsl:when test="@code='0' and @col14!=9">, elle a trouvé un résultat de calcul correct <xsl:value-of select="res"/>. </xsl:when>
				<xsl:when test="@code='0' and @col14=9 and @col2=9">, le résultat du calcul est correct <xsl:value-of select="res"/>. Mais, son calcul ne correspond pas au calcul final attendu.</xsl:when>
				<xsl:when test="@code='0' and @col14=9"><xsl:value-of select="res"/>, mais pas au calcul final attendu.</xsl:when>
				<xsl:when test="@code='1' or @code='2'">, elle a fait une <xsl:value-of select="."/> de calcul. </xsl:when>
				<xsl:when test="@code='8'">.</xsl:when>
				<xsl:when test="9"/>
			</xsl:choose>
		</xsl:if>
	</xsl:template>
	<xsl:template match="colonne10">
		<xsl:if test="@sexe='m'">
			<xsl:choose>
				<xsl:when test="@code='0'"> de manière implicite</xsl:when>
				<xsl:when test="@code='0'"> Pour le <xsl:value-of select="@intitule"/>, il a utilisé un calcul <xsl:value-of select="."/>
				</xsl:when>
				<xsl:when test="@code='1' or @code='2'">. Il a utilisé une <xsl:value-of select="."/>
					<xsl:text>, </xsl:text>
				</xsl:when>
			</xsl:choose>
		</xsl:if>
		<xsl:if test="@sexe='f'">
			<xsl:choose>
				<xsl:when test="@code='0'"> de manière implicite</xsl:when>
				<xsl:when test="@code='0'"> Pour le <xsl:value-of select="@intitule"/>, elle a utilisé un calcul <xsl:value-of select="."/>
				</xsl:when>
				<xsl:when test="@code='1' or @code='2'">. Elle a utilisé une <xsl:value-of select="."/>
					<xsl:text>, </xsl:text>
				</xsl:when>
			</xsl:choose>
		</xsl:if>
	</xsl:template>
	<xsl:template match="colonne11"/>
	<xsl:template match="colonne12">
		<xsl:if test="@sexe='m'">
			<xsl:choose>
				<xsl:when test="@code='0'"> et il a trouvé un résultat correct <xsl:value-of select="res"/>. </xsl:when>
				<xsl:when test="@code='1' or @code='2'"> il a fait une <xsl:value-of select="."/> de calcul. </xsl:when>
				<xsl:when test="9"/>
			</xsl:choose>
		</xsl:if>
		<xsl:if test="@sexe='f'">
			<xsl:choose>
				<xsl:when test="@code='0'"> et elle a trouvé un résultat correct <xsl:value-of select="res"/>. </xsl:when>
				<xsl:when test="@code='1' or @code='2'"> elle a fait une <xsl:value-of select="."/> de calcul. </xsl:when>
				<xsl:when test="9"/>
			</xsl:choose>
		</xsl:if>
	</xsl:template>
	<xsl:template match="colonne14">
		<xsl:if test="@sexe='m'">
			<xsl:choose>
				<xsl:when test="@code=0 and @nbOper=0 and @str=6 and (@col2!=0 or @col6!=0)">Le résultat donné (<xsl:value-of select="res"/>) n'a pas de sens relativement à l'énoncé.</xsl:when>
				<xsl:when test="@code=0 and @nbOper=0 and @col2=0 and @str=5"><br/>Pour le calcul final, il a fait un calcul implicite qui mène à une solution correcte (<xsl:value-of select="res"/>).</xsl:when>
                <xsl:when test="@code=0 and @nbOper=0 and @str=5">mené à une solution correcte (<xsl:value-of select="res"/>) à partir de calculs mentaux</xsl:when>
				
                <xsl:when test="@code=0 and @col16=8">
					<br/>Pour le calcul final, il a fait un calcul implicite qui mène à un résultat incorrect</xsl:when>
				<xsl:when test="@code=0">
					<br/>Pour le calcul final, il a fait un calcul implicite </xsl:when>
				<xsl:when test="@code=1 and @nbOper =1 and @str=4">Le calcul effectué correspond au calcul de la première partie manquante. Il a utilisé une </xsl:when>
				<xsl:when test="@code=1 or @code =2">
					<br/>Pour le calcul final, qui correspond au calcul d'<xsl:value-of select="."/>, il a utilisé une </xsl:when>
				<xsl:when test="@code=3 and @col1=3 and @type ='a'  and @q = 't'">
					<br/>Pour le calcul final, il a calculé directement la solution en utilisant l'écart (<xsl:value-of select="valdiff"/>) entre la valeur du tout initial (<xsl:value-of select="tout1"/>) et la valeur recherchée. Il a utilisé une </xsl:when>
				<xsl:when test="@code=3 and @col1=3 and @type ='a'  and @q = 'p'">
					<br/>Pour le calcul final, il a calculé directement la solution en utilisant l'écart (<xsl:value-of select="valdiff"/>) entre la valeur de la partie initiale (<xsl:value-of select="partie1"/>) et la valeur recherchée. Il a utilisé une </xsl:when>
				<xsl:when test="@code=3 and @col15=0 and @type='a'">Pour le calcul final, qui correspond au calcul de la comparaison, il a utilisé des calculs mentaux.</xsl:when>
				<xsl:when test="@code=3 and @nbOper=1 and @str!=2"> Il a utilisé une </xsl:when>
				<xsl:when test="@code=3 and @nbOper=1 and @str=2">Pour le calcul final, il a utilisé une </xsl:when>
				<xsl:when test="@code=3">
					<xsl:value-of select="."/>Pour le calcul final, il a utilisé une </xsl:when>
				<xsl:when test="@code=4">Pour le calcul final, il utilise <xsl:value-of select="."/>, il a utilisé une </xsl:when>
				<xsl:when test="@code=41 and @q='p' and @str=1">Pour le calcul final, la question finale porte sur une partie. Il aurait donc fallu une opération de soustraction, au lieu de l'</xsl:when>
				<xsl:when test="@code=41 and @q='t' and @str=1">Pour le calcul final, il a fait une addition des résultats intermédiaires </xsl:when>
				<xsl:when test="@code=42 and @q='t' and @str=1">Pour le calcul final, la question finale porte sur un tout. ll aurait donc fallu une opération d'addition, au lieu de la </xsl:when>
				<xsl:when test="@code=43 and @nbOper=1">Il a utilisé une</xsl:when>
				<xsl:when test="@code=43">Pour le calcul final, il a utilisé une</xsl:when>
				<xsl:when test="@code=51">Pour le calcul final, il a utilisé plusieurs opérations qui ne mènent pas à la solution. Dans son dernier calcul, il a fait une</xsl:when>
				<xsl:when test="@code=5 and @nbOper =1 and @str=4 and @col15=8">Le calcul effectué est erroné </xsl:when>
				<xsl:when test="@code=5 and @nbOper =1 and @str=4">Le calcul effectué est erroné, il a utilisé une </xsl:when>
				<xsl:when test="@code=5 and @str=7">Pour le calcul final, il a utilisé une</xsl:when>
				<xsl:when test="@code=5 and @col15=8">Pour le calcul final, il a utilisé une opération non pertinente</xsl:when>
				<xsl:when test="@code=5">
					<br/>Pour le calcul final, il a utilisé une </xsl:when>
				<xsl:when test="@code=9"/>
			</xsl:choose>
		</xsl:if>
		<xsl:if test="@sexe='f'">
			<xsl:choose>
				<xsl:when test="@code=0 and @nbOper=0 and @str=6 and @col2!=0 and @col6!=0">Le résultat donné (<xsl:value-of select="res"/>) n'a pas de sens relativement à l'énoncé.</xsl:when>
                	<xsl:when test="@code=0 and @nbOper=0 and @col2=0 and @str=5"><br/>Pour le calcul final, elle a fait un calcul implicite qui mène à une solution correcte (<xsl:value-of select="res"/>).</xsl:when>
				<xsl:when test="@code=0 and @nbOper=0 and @str=5">mené à une solution correcte (<xsl:value-of select="res"/>) à partir de calculs mentaux</xsl:when>
				<xsl:when test="@code=0 and @col16=8">
					<br/>Pour le calcul final, elle a fait un calcul implicite qui mène à un résultat incorrect </xsl:when>
				<xsl:when test="@code=0">
					<br/>Pour le calcul final, elle a fait un calcul implicite </xsl:when>
				<xsl:when test="@code=1 and @nbOper =1 and @str=4">Le calcul effectué correspond au calcul de la première partie manquante. Elle a utilisé une </xsl:when>
				<xsl:when test="@code=1 or @code =2">
					<br/>Pour le calcul final, qui correspond au calcul d'<xsl:value-of select="."/>, elle a utilisé une </xsl:when>
				<xsl:when test="@code=3 and @col1=3 and @type ='a'  and @q = 't'">
					<br/>Pour le calcul final, elle a calculé directement la solution en utilisant l'écart (<xsl:value-of select="valdiff"/>) entre la valeur du tout initial (<xsl:value-of select="tout1"/>) et la valeur recherchée. Elle a utilisé une </xsl:when>
				<xsl:when test="@code=3 and @col1=3 and @type ='a'  and @q = 'p'">
					<br/>Pour le calcul final, elle a calculé directement la solution en utilisant l'écart (<xsl:value-of select="valdiff"/>) entre la valeur de la partie initiale (<xsl:value-of select="partie1"/>) et la valeur recherchée. Elle a utilisé une </xsl:when>
				<xsl:when test="@code=3 and @col15=0 and @type='a'">Pour le calcul final, qui correspond au calcul de la comparaison, elle a utilisé des calculs mentaux.</xsl:when>
				<xsl:when test="@code=3 and @nbOper=1"> Elle a utilisé une </xsl:when>
				<xsl:when test="@code=3">
					<xsl:value-of select="."/>Pour le calcul final, elle a utilisé une </xsl:when>
				<xsl:when test="@code=4">Pour le calcul final, elle utilise <xsl:value-of select="."/>, elle a utilisé une </xsl:when>
				<xsl:when test="@code=41 and @q='p' and @str=1">Pour le calcul final, la question finale porte sur une partie. Il aurait donc fallu une opération de soustration, au lieu de l'</xsl:when>
				<xsl:when test="@code=41 and @q='t' and @str=1">Pour le calcul final, elle a fait une addition des résultats intermédiaires </xsl:when>
				<xsl:when test="@code=42 and @q='t' and @str=1">Pour le calcul final, la question finale porte sur un tout. ll aurait donc fallu une opération d'addition, au lieu de la </xsl:when>
				<xsl:when test="@code=43 and @nbOper=1">Elle a utilisé une</xsl:when>
				<xsl:when test="@code=43">Pour le calcul final, elle a utilisé une</xsl:when>
				<xsl:when test="@code=51">Pour le calcul final, elle a utilisé plusieurs opérations qui ne mènent pas à la solution. Dans son dernier calcul, elle a fait une</xsl:when>
				<xsl:when test="@code=5 and @nbOper =1 and @str=4 and @col15=8">Le calcul effectué est erroné </xsl:when>
				<xsl:when test="@code=5 and @nbOper =1 and @str=4">Le calcul effectué est erroné, elle a utilisé une </xsl:when>
				<xsl:when test="@code=5 and @str=7">Pour le calcul final, elle a utilisé une</xsl:when>
				<xsl:when test="@code=5 and @col15=8">Pour le calcul final, elle a utilisé une opération non pertinente</xsl:when>
				<xsl:when test="@code=5">
					<br/>Pour le calcul final, elle a utilisé une </xsl:when>
				<xsl:when test="@code=9"/>
			</xsl:choose>
		</xsl:if>
	</xsl:template>
	<xsl:template match="colonne15">
		<xsl:choose>
			<xsl:when test="@code=0"/>
			<xsl:when test="(@code=1 or @code=2 or @code=3 or @code=4 or @code=71 or @code=72) and @col14=41">
				<xsl:value-of select="op"/>.</xsl:when>
			<xsl:when test="@code=1 or @code=2 or @code=3 or @code=4 or @code=71or @code=72">
				<xsl:value-of select="."/>. </xsl:when>
			<xsl:when test="@code=5 or @code=52">
				<xsl:value-of select="."/>.</xsl:when>
			<xsl:when test="@code=6">opération non pertinente  sur tous les termes de l'énoncé <xsl:value-of select="op"/>. </xsl:when>
			<xsl:when test="@code=7">opération non pertinente sur deux des termes de l'énoncé <xsl:value-of select="op"/>. </xsl:when>
			<xsl:when test="@code=8">
				<xsl:value-of select="op"/>.</xsl:when>
			<xsl:when test="@code=9"/>
		</xsl:choose>
	</xsl:template>
	<xsl:template match="colonne17">
		<xsl:if test="@sexe='m'">
			<xsl:choose>
				<xsl:when test="@code=0 and @sol=3 and @nbOper>1"> Concernant cette opération, il n'a pas fait d'erreur de calcul <xsl:value-of select="./res"/>.</xsl:when>
				<xsl:when test="@code=0 and @nbOper>1"> Il n'a pas fait d'erreur pour ce calcul <xsl:value-of select="./res"/>.</xsl:when>
				<xsl:when test="@code=0 and @col14=0 and @col15=0 and @str!=5"> qui mène à un résultat correct <xsl:value-of select="res"/>.</xsl:when>
				<xsl:when test="@code=0 and @nbOper=0"/>
				<xsl:when test="@code=0">  Concernant cette opération, il n'a pas fait d'erreur de calcul <xsl:value-of select="./res"/>.</xsl:when>
				<xsl:when test="@code=1">  Il a commis une erreur de calcul <xsl:value-of select="res"/>.</xsl:when>
				<xsl:when test="@code=2">  Il a commis une erreur de calcul <xsl:value-of select="res"/>.</xsl:when>
				<xsl:when test="@code=8 and @str!=6">ab<xsl:value-of select="res"/>.</xsl:when>
				<xsl:when test="@code=9 and @col14=0 and @col15=0 and @str!=6"> qui mène à un résultat incorrect <xsl:value-of select="res"/>.</xsl:when>
				<xsl:when test="@code=9"/>
			</xsl:choose>
		</xsl:if>
		<xsl:if test="@sexe='f'">
			<xsl:choose>
				<xsl:when test="@code=0 and @sol=3 and @nbOper>1"> Concernant cette opération, elle n'a pas fait d'erreur de calcul <xsl:value-of select="./res"/>.</xsl:when>
				<xsl:when test="@code=0 and @nbOper>1"> Elle n'a pas fait d'erreur pour ce calcul <xsl:value-of select="./res"/>.</xsl:when>
				<xsl:when test="@code=0 and @col14=0 and @col15=0 and @str!=5"> qui mène à un résultat correct <xsl:value-of select="res"/>.</xsl:when>
				<xsl:when test="@code=0 and @nbOper=0"/>
				<xsl:when test="@code=0">  Concernant cette opération, elle n'a pas fait d'erreur de calcul <xsl:value-of select="./res"/>.</xsl:when>
				<xsl:when test="@code=1">  Elle a commis une erreur de calcul <xsl:value-of select="res"/>.</xsl:when>
				<xsl:when test="@code=2">  Elle a commis une erreur de calcul <xsl:value-of select="res"/>.</xsl:when>
				<xsl:when test="@code=8 and @str!=6">
					<xsl:value-of select="res"/>.</xsl:when>
				<xsl:when test="@code=9 and @col14=0 and @col15=0 and @str!=6"> qui mène à un résultat incorrect <xsl:value-of select="res"/>.</xsl:when>
				<xsl:when test="@code=9"/>
			</xsl:choose>
		</xsl:if>
	</xsl:template>
	<xsl:template match="colonne16">
		<xsl:choose>
			<xsl:when test="@code=0">
				<!-- Les données utilisées pour l'opération finale sont<xsl:value-of select="."/>.-->
			</xsl:when>
			<xsl:when test="@code=1 and @nbOper=1 and @str=4 and @col14=1"> Les données utilisées sont pertinentes pour le calcul de la première partie manquante, mais pas pour l'opération finale.</xsl:when>
			<xsl:when test="@code=1 and @nbOper=1 and @str=4 and @col14=5">
				<!--Le résultat de cette opération n' a pas de sens relativement à l'énoncé.-->
			 Ce calcul n'est pas cohérent relativement à l'énoncé. 
			</xsl:when>
			<xsl:when test="@code=1 and @col14=4 and @str=4"> Le résultat de cette opération n'a pas de sens relativement à l'énoncé.</xsl:when>
			<xsl:when test="@code=1 and @str=7"/>
			<xsl:when test="@code=1">
				<xsl:value-of select="."/>. </xsl:when>
			<xsl:when test="@code=2">
				<xsl:value-of select="."/>. </xsl:when>
			<xsl:when test="@code=3">
				<xsl:value-of select="."/>. <br/>
			</xsl:when>
			<xsl:when test="@code=4">
				<xsl:value-of select="."/>. </xsl:when>
			<xsl:when test="@code=5">
				<xsl:value-of select="."/>. </xsl:when>
			<xsl:when test="@code=9"/>
		</xsl:choose>
	</xsl:template>
	<xsl:template match="commentaire">
		<xsl:if test="@sexe='m'">
			<xsl:choose>
				<xsl:when test="@str=1 and @nbOper=2 and @type='a' and @col14=4 and @col16=1">
					<br/>Dans la résolution de cet exercice, il a considéré que le calcul final impliquait forcément le résultat du calcul précédent et la donnée restante de l'énoncé.			
				</xsl:when>
				<xsl:when test="@str=4 and (@col2=5 or @col15=8)">
					<br/>Dans la résolution de cet exercice, il a fait le choix d'opérations non pertinentes.</xsl:when>
				<xsl:when test="@str=4 and @col2=9 and @nbOper=1 and (@col14=1 or @col14=2)">
					<br/>La résolution du problème est inachevée</xsl:when>
				<xsl:when test="@str=4 and @col2=9 and @nbOper=1 and @col6!=9 and @col14=9">
					<br/>La résolution du problème est inachevée</xsl:when>
				<xsl:when test="@str=1 and @col2=0 and @nbOper=0 and @col14=9">
					<br/>La résolution du problème est inachevée</xsl:when>
				<xsl:when test="@str=1 and @type='a' and @qi=1 and (@nbOper=0 or @nbOper=2) and (@sol=3 or @sol=2)">
					<br/>Sa résolution correspond à "une question un calcul".</xsl:when>
				<xsl:when test="@str=1 and @col6=20">
					<br/>Dans sa résolution, il a posé le calcul de la différence <xsl:value-of select="op"/>.</xsl:when>
			</xsl:choose>
		</xsl:if>
		<xsl:if test="@sexe='f'">
			<xsl:choose>
				<xsl:when test="@str=1 and @nbOper=2 and @type='a' and @col14=4 and @col16=1">
					<br/>Dans la résolution de cet exercice, elle a considéré que le calcul final impliquait forcément le résultat du calcul précédent et la donnée restante de l'énoncé.
				</xsl:when>
				<xsl:when test="@str=4 and (@col2=5 or @col15=8)">
					<br/>Dans la résolution de cet exercice, elle a fait le choix d'opérations non pertinentes.</xsl:when>
				<xsl:when test="@str=4 and @col2=9 and @nbOper=1 and (@col14=1 or @col14=2)">
					<br/>La résolution du problème est inachevée.</xsl:when>
				<xsl:when test="@str=1 and @col2=0 and @nbOper=0 and @col14=9">
					<br/>La résolution du problème est inachevée.</xsl:when>
				<xsl:when test="@str=4 and @col2=9 and @nbOper=1 and @col6!=9 and @col14=9">
					<br/>La résolution du problème est inachevée.</xsl:when>
				<xsl:when test="@str=1 and @type='a' and @qi=1 and @nbOper=2 and @col6!=0 and (@sol=3 or @sol=2)">
					<br/>Sa résolution correspond à "une question un calcul".</xsl:when>
				<xsl:when test="@str=1 and @type='a' and @qi=1 and @nbOper=0 and (@sol=3 or @sol=2)">
					<br/>Sa résolution correspond à "une question un calcul".</xsl:when>
				<xsl:when test="@str=1 and @col6=20">
					<br/>Dans sa résolution, elle a posé le calcul de la différence <xsl:value-of select="op"/>.</xsl:when>
			</xsl:choose>
		</xsl:if>
	</xsl:template>
</xsl:stylesheet>
