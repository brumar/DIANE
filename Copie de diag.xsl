<?xml version="1.0" encoding="iso-8859-1"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>
    <xsl:template match="diagnostic">
        <html>
            <head>
                <title>Diagnostic</title>
            </head>
            <body> L'élève a résolu le problème de la manière suivante:<br/> Il a utilisé la
                    <xsl:value-of select="colonne1/@intitule"/> à <xsl:value-of select="colonne1"/>
                <br/> il a commencé par le <xsl:value-of select="colonne2/@intitule"/> en utilisant
                une <xsl:value-of select="colonne2"/>
                <br/>
                <xsl:value-of select="colonne3"/> colonne 3 = <xsl:value-of select="colonne3/@code" />
                <br/>
                <xsl:value-of select="colonne4"/> colonne 4 = <xsl:value-of
                    select="colonne4/@code"/>
                <br/>
                <xsl:value-of select="colonne10"/> colonne 10 = <xsl:value-of
                    select="colonne10/@code"/>
                <br/>
                <xsl:value-of select="colonne11"/> colonne 11 = <xsl:value-of
                    select="colonne1/@code"/>
                <br/>
                <xsl:value-of select="colonne12"/> colonne 12 = <xsl:value-of
                    select="colonne12/@code"/>
                <br/>
                <xsl:value-of select="colonne14"/> colonne 14 = <xsl:value-of
                    select="colonne14/@code"/>
                <br/>
                <xsl:value-of select="colonne15"/> colonne 14 = <xsl:value-of
                    select="colonne15/@code"/>
                <br/>
                <xsl:value-of select="colonne16"/> colonne 16 = <xsl:value-of
                    select="colonne16/@code"/>
                <br/>
                <xsl:value-of select="colonne17"/> colonne 17 = <xsl:value-of
                    select="colonne17/@code"/>
                <br/>
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>
