<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:dc="http://purl.org/dc/elements/1.1/">
<xsl:output method="xml" doctype-system="http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd" doctype-public="-//W3C//DTD XHTML 1.1//EN"/>
<xsl:template match="/">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<title>backend via xsl</title>
	<meta name="robots" content="noindex,follow" />
	<link rel="stylesheet" href="sage.css" type="text/css" />
</head>
<xsl:apply-templates select="rss/channel"/>
</html>
</xsl:template>

<xsl:template match="rss/channel">
	<body xmlns="http://www.w3.org/1999/xhtml">
		<div id="rss-header">
			<h1 id="rss-title">
				<a href="{link}" id="rss-link" accesskey="1"><xsl:value-of select="title"/></a>
			</h1>
		</div>

<xsl:for-each select="item">
	<div class="item">
		<h2 class="item-title">
			<a href="{link}" rel="bookmark"><xsl:value-of select="title"/></a>
		</h2>
		<div class="item-desc"><xsl:value-of select="description" disable-output-escaping="yes" /></div>
		<div class="item-pubDate"><xsl:value-of select="pubDate"/></div>
	</div>
</xsl:for-each>

	</body>

</xsl:template>
</xsl:stylesheet>
