<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:dc="http://purl.org/dc/elements/1.1/">
<xsl:output method="html" doctype-system="http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd" doctype-public="-//W3C//DTD XHTML 1.1//EN"/>
<xsl:template match="/">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr" xml:lang="fr" dir="ltr">
<head>
<title>Nouvelles du jour</title>
    <xsl:if test="system-property('xsl:vendor')='Transformiix'">
      <!-- Mozilla ignores disable-output-escaping -->
      <script type="text/javascript">
        function onload_cb() {
            var elements = document.getElementsByTagName('div');
            for (var i = 0; i &lt; elements.length; i++) {
                var el = elements[i];
                if (el.className == 'description') {
                    el.innerHTML = el.firstChild.data;
                }
            }
        }
      </script>
    </xsl:if>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
<xsl:apply-templates select="rss/channel"/>
</html>
</xsl:template>

<xsl:template match="rss/channel">
 <body>
    <xsl:if test="system-property('xsl:vendor')='Transformiix'">
      <xsl:attribute name="onload">onload_cb()</xsl:attribute>
    </xsl:if>
   <h1 id="title"><a href="{link}" accesskey="1"><xsl:value-of select="title"/></a></h1>
<div id="main">
  <div class="sidebar">
   <h2>This is an <abbr title="Really Simple Syndication">RSS</abbr> feed.</h2>
   <p>This file is designed to be put into an aggregator program.  There is information on how to use this file on the <a href="http://glenn.typepad.com/news/rss.html"><abbr title="Really Simple Syndication">RSS</abbr> info page.</a></p>
  </div>
  <div id="content">
  <xsl:for-each select="item">
<div class="dategroup">  
<div class="item">
   <h2><a href="{link}" rel="bookmark"><xsl:value-of select="title"/></a></h2>
<div class="description"><xsl:value-of select="description" disable-output-escaping="yes" /></div>
<p class="posted"><xsl:value-of select="date"/></p>
</div>
  </div>

  </xsl:for-each>
  </div>

  </div>
 </body>
</xsl:template>
</xsl:stylesheet>