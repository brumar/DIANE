<xsl:stylesheet xmlns:xsl='http://www.w3.org/1999/XSL/Transform' version="1.0">

<xsl:template match="b">
  <b><xsl:apply-templates/></b>
</xsl:template>

<xsl:template match="br">
  <br/><xsl:apply-templates/>
</xsl:template>

</xsl:stylesheet>