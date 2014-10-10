<?xml version="1.0" encoding="iso-8859-1"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output encoding="iso-8859-1"/>
	<xsl:template match="diagnostic">
				<xsl:apply-templates select="exercice"/>
	</xsl:template>
	<xsl:template match="exercice">						
					<xsl:value-of select="nom"/>
					<xsl:value-of select="resolution"/>.
                    Cet élève a procédé de la manière suivante :
                    <xsl:apply-templates/>
	</xsl:template>
	<xsl:template match="enonce"/>
	<xsl:template match="reponse"/>
	<xsl:template match="nom"/>
	<xsl:template match="resolution"/>
	<xsl:template match="nbOper">
		<xsl:choose>
			<xsl:when test="@nbOper>1">Sa résolution s'est faite en <xsl:value-of select="."/> calculs.</xsl:when>
			<xsl:when test="@nbOper=1">Sa résolution s'est faite en <xsl:value-of select="."/> calcul.</xsl:when>
			<xsl:when test="@nbOper=0">Il n'a pas posé d'opérations.</xsl:when>
		</xsl:choose> 
	</xsl:template>
	<xsl:template match="colonne1">
		<xsl:choose>
			<xsl:when test="@code=1">Tout d'abord, cet élève a calculé la partie manquante, en faisant </xsl:when>
			<xsl:when test="@code=2 and @type=&quot;e&quot; and @q=&quot;p&quot;">Tout d'abord, cet élève a calculé l'écart entre la valeur du tout initial (<xsl:value-of select="tout1"/>) et la valeur du tout final (<xsl:value-of select="tout2"/>). </xsl:when>
			<xsl:when test="@code=2 and @type=&quot;e&quot; and @q=&quot;t&quot;">Tout d'abord, cet élève a calculé l'écart entre la valeur de la partie initial (<xsl:value-of select="partie1"/>) et la valeur du tout final (<xsl:value-of select="partie2"/>). </xsl:when>
			<xsl:when test="@code=2 and @type=&quot;a&quot; and @q=&quot;p&quot;">Cet élève a calculé directement la solution en utilisant l'écart (<xsl:value-of select="valdiff"/>) entre la valeur de la partie initial (<xsl:value-of select="partie1"/>) et la valeur de la partie recherchée. </xsl:when>
			<xsl:when test="@code=2 and @type=&quot;a&quot; and @q=&quot;t&quot;">Cet élève a calculé directement la solution en utilisant l'écart (<xsl:value-of select="valdiff"/>) entre la valeur du tout initial (<xsl:value-of select="tout1"/>) et la valeur de la partie recherchée. </xsl:when>
			<xsl:when test="@code=3">Tout d'abord, cet élève a calculé la partie manquante, en faisant </xsl:when>
			<xsl:when test="@code=4 and @nbOper>1">Tout d'abord, cet élève a fait </xsl:when>
			<xsl:when test="@code=4"><!--Il a utilisé une <xsl:value-of select="@intitule"/><xsl:value-of select="."/>, --></xsl:when>
			<xsl:when test="@code=5">Il a utilisé une stratégie non identifiée qui l'a </xsl:when>
			<xsl:when test="@code=6">Il a effectué des calculs mentaux non identifiées. </xsl:when>
			<xsl:when test="@code=7">Tout d'abord, cet élève a réalisé l'opération de comparaison, </xsl:when>
			<xsl:otherwise/>
		</xsl:choose>
	</xsl:template>
	
	<xsl:template match="colonne2">
		<xsl:choose>
			<xsl:when test="@code='0'">le calcul de manière <xsl:value-of select="."/>.</xsl:when>
			<xsl:when test="@code='1' or @code='2' or @code='3' or @code='7'"> une <xsl:value-of select="."/><xsl:text>. </xsl:text></xsl:when>
			<xsl:when test="@code=4">une <xsl:value-of select="."/>.</xsl:when>

		</xsl:choose>
	</xsl:template>
	
	<xsl:template match="colonne4">
		<xsl:choose>
			<xsl:when test="@code='0'"> Il n'a pas fait d'erreur de calcul <xsl:value-of select="./res"/>. </xsl:when>
			<xsl:when test="@code='1' or @code='2'"> Il a fait une <xsl:value-of select="."/> de calcul. </xsl:when>
			<xsl:when test="9"/>
		</xsl:choose>
	</xsl:template>
	
	<xsl:template match="colonne3">
		<xsl:choose>
            <xsl:when test="@code=0 and @col2=4"> Le résultat de cette opération n'a pas de sens relativement à l'énoncé. </xsl:when>
            <!-- <xsl:when test="@code=1">les données utilisées pour son opération sont <xsl:value-of select="."/>, </xsl:when>
            <xsl:when test="@code=9"></xsl:when>-->
        </xsl:choose>
	</xsl:template>
	
	<xsl:template match="colonne6">
		
        <xsl:choose>
			<xsl:when test="@code='0' and @nbOper=0">Il a réalisé l'opération de comparaison à partir de calculs mentaux</xsl:when>
			<xsl:when test="@code='0'">Ensuite, il a réalisé l'opération de comparaison à partir de calculs mentaux</xsl:when>
			<xsl:when test="(@code='1' or @code='2' or @code='3' or @code='4' or @code='7') and (@str='7')">par une <xsl:value-of select="."/><xsl:text>, </xsl:text></xsl:when>
		 <xsl:when test="@code='1' or @code='2' or @code='3' or @code='4' or @code='7'">
				Ensuite, il a réalisé l'opération de comparaison, par  une <xsl:value-of select="."/><xsl:text>, </xsl:text>
			</xsl:when>
		</xsl:choose>
	</xsl:template>
	<xsl:template match="colonne7">
		<!-- <xsl:choose>
            <xsl:when test="@code=0">les données utilisées pour son opération sont <xsl:value-of select="."/>, </xsl:when>
            <xsl:when test="@code=1">les données utilisées pour son opération sont <xsl:value-of select="."/>, </xsl:when>
            <xsl:when test="@code=9"></xsl:when>
        </xsl:choose>-->
	</xsl:template>
	<xsl:template match="colonne8">
		<xsl:choose>
			<xsl:when test="@code='0'"> et il a trouvé un <xsl:value-of select="@intitule"/> <xsl:value-of select="."/>. </xsl:when>
			<xsl:when test="@code='1' or @code='2'"> il a fait une <xsl:value-of select="."/> de calcul. </xsl:when>
			<xsl:when test="9"/>
		</xsl:choose>
	</xsl:template>
	<xsl:template match="colonne10">
		<xsl:choose>
			<xsl:when test="@code='0'"> Pour le <xsl:value-of select="@intitule"/> il a utilisé un  calcul <xsl:value-of select="."/></xsl:when>
			<xsl:when test="@code='1' or @code='2'"> Il a utilisé une <xsl:value-of select="."/><xsl:text>, </xsl:text></xsl:when>
		</xsl:choose>
	</xsl:template>
	<xsl:template match="colonne11"/>
	<xsl:template match="colonne12">
		<xsl:choose>
			<xsl:when test="@code='0'"> et il a trouvé un <xsl:value-of select="@intitule"/>
				<xsl:value-of select="."/>. </xsl:when>
			<xsl:when test="@code='1' or @code='2'"> il a fait une <xsl:value-of select="."/> de calcul. </xsl:when>
			<xsl:when test="9"/>
		</xsl:choose>
	</xsl:template>
	
	<xsl:template match="colonne14">
		<xsl:choose>
			<xsl:when test="@code=0 and @nbOper=0 and @str=6">Le résultat donné n'a pas de sens relativement à l'énoncé.</xsl:when>
			<xsl:when test="@code=0 and @nbOper=0 and @str=5">mené à une solution correcte à partir de calculs mentaux.</xsl:when>
			<xsl:when test="@code=0">Pour le calcul final, il a fait un calcul <xsl:value-of select="."/>, </xsl:when>
			<xsl:when test="@code=1 and @nbOper =1 and @str=4">Le calcul effectué correspond au calcul de la première partie manquante. Il a utilisé une </xsl:when>
			<xsl:when test="@code=1 or @code =2">Pour le calcul final, qui correspond au calcul d'<xsl:value-of select="."/>. Il a utilisé une </xsl:when>
			<xsl:when test="@code=3 and @col1=3 and @type =&quot;a&quot;  and @q = &quot;t&quot;">Pour le calcul final, l'élève a calculé directement la solution en utilisant l'écart (<xsl:value-of select="valdiff"/>) entre la valeur du tout initial (<xsl:value-of select="tout1"/>) et la valeur de la partie recherchée. Il a utilisé une </xsl:when>
			<xsl:when test="@code=3 and @col1=3 and @type =&quot;a&quot;  and @q = &quot;p&quot;">Pour le calcul final, l'élève a calculé directement la solution en utilisant l'écart (<xsl:value-of select="valdiff"/>) entre la valeur de la partie initial (<xsl:value-of select="partie1"/>) et la valeur de la partie recherchée. Il a utilisé une </xsl:when>
			<xsl:when test="@code=3 and @col15=0 and @type=&quot;a&quot;">Pour le calcul final, il correspond au calcul de la comaraison. Il a utilisé des calculs mentaux.</xsl:when>
			<xsl:when test="@code=3"><xsl:value-of select="."/>Pour le calcul final, Il a utilisé une </xsl:when>
			<xsl:when test="@code=4">Pour le calcul final, il utilise <xsl:value-of select="."/>. Il a utilisé une </xsl:when>
			<xsl:when test="@code=41 and @q='p' and @str=1">Pour le calcul final, la question finale porte sur une partie. Il aurait donc fallu une opération de soustration, au lieu de l' </xsl:when>
			<xsl:when test="@code=42 and @q='t' and @str=1">Pour le calcul final, la question finale porte sur un tout. ll aurait donc fallu une opération d'addition, au lieu de la </xsl:when>
		    <xsl:when test="@code=51">Pour le calcul final, il a utilisé plusieurs opérations qui ne mènent pas à la solution. Dans son dernier calcul, il a fait une</xsl:when>
  
		    <xsl:when test="@code=5 and @nbOper =1 and @str=4">Le calcul effectué est erroné. Il a utilisé une </xsl:when>
		    <xsl:when test="@code=5 and @str=7">Pour le calcul final, il a utilsé une</xsl:when>
		    <xsl:when test="@code=5 and @col15=8">Pour le calcul final, il a utilisé une opération non pertinente</xsl:when>
		    <xsl:when test="@code=5">Pour le calcul final, qui correspond <xsl:value-of select="."/>,</xsl:when>
			<xsl:when test="@code=9"/>
		</xsl:choose>
	</xsl:template>
	
	<xsl:template match="colonne15">
		<xsl:choose>
			<xsl:when test="@code=0"/>
			<xsl:when test="@code=1 or @code=2 or @code=3 or @code=4 "><xsl:value-of select="."/>. </xsl:when>
			<xsl:when test="@code=6">. </xsl:when>
			<xsl:when test="@code=7">. </xsl:when>
			<xsl:when test="@code=8"><xsl:value-of select="op"/>.</xsl:when>
			<xsl:when test="@code=9"/>
		</xsl:choose>
	</xsl:template>
	
	<xsl:template match="colonne17">
		<xsl:choose>
			<xsl:when test="@code=0 and @sol=3 and @nbOper>1">Concernant cette opération, il n'a pas fait d'erreur de calcul <xsl:value-of select="./res"/>.</xsl:when>
			<xsl:when test="@code=0 and @nbOper>1"> Il n'a pas fait d'erreur pour ce calcul<xsl:value-of select="./res"/>.</xsl:when>
			<xsl:when test="@code=0 and @col14=0 and @col15=0"> qui mène à un resultat correct<xsl:value-of select="res"/></xsl:when>
			<xsl:when test="@code=0 and @nbOper=0"></xsl:when>
			<xsl:when test="@code=0">  Il n'a pas fait d'erreur de calcul <xsl:value-of select="./res"/>.</xsl:when>
			<xsl:when test="@code=1">  Il a commis une une petite erreur de calcul <xsl:value-of select="res"/>.</xsl:when>
			<xsl:when test="@code=2">  Il a commis une erreur de calcul <xsl:value-of select="res"/>.</xsl:when>
			<xsl:when test="@code=9 and @col14=0 and @col15=0"> qui mène à un resultat incorrect<xsl:value-of select="res"/></xsl:when>
			<xsl:when test="@code=9"/>
		</xsl:choose>
	</xsl:template>	
	
	<xsl:template match="colonne16">
		<xsl:choose>
			<xsl:when test="@code=0"> <!-- Les données utilisées pour l'opération finale sont<xsl:value-of select="."/>.--></xsl:when>
			<xsl:when test="@code=1 and @nbOper=1 and @str=4 and @col14=1"> Les données utilisées sont pertinente pour le calcul de la première partie manquante, mais pas pour l'opération finale.</xsl:when>
			<xsl:when test="@code=1 and @nbOper=1 and @str=4 and @col14=5"> Le résultat de cette opération n' a pas de sens relativement à l'énoncé.</xsl:when>
			<xsl:when test="@code=1 and @col14=4 and @str=4"> Le résultat de cette opération n' a pas de sens relativement à l'énoncé.</xsl:when>
			<xsl:when test="@code=1 and @str=7"></xsl:when>			
			<xsl:when test="@code=1"><xsl:value-of select="."/>. </xsl:when>
			<xsl:when test="@code=2"><xsl:value-of select="."/>. </xsl:when>
			<xsl:when test="@code=3"><xsl:value-of select="."/>. </xsl:when>
			<xsl:when test="@code=4"><xsl:value-of select="."/>. </xsl:when>
			<xsl:when test="@code=9"/>
		</xsl:choose>
	</xsl:template>
	
</xsl:stylesheet>
