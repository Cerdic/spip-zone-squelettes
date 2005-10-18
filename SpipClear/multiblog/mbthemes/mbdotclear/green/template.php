<?php
# ***** BEGIN LICENSE BLOCK *****
# This file is part of DotClear.
# Copyright (c) 2004 Olivier Meunier and contributors. All rights
# reserved.
#
# DotClear is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
# 
# DotClear is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# 
# You should have received a copy of the GNU General Public License
# along with DotClear; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
#
# ***** END LICENSE BLOCK *****
#
# Author: Zoe (http://www.callmepep.org/zoe)
# Thème Green (version 1.2)
#
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php dcInfo('lang'); ?>"
lang="<?php dcInfo('lang'); ?>">
<head>
	<meta http-equiv="Content-Type"
	content="text/html; charset=<?php dcInfo('encoding'); ?>" />
	<meta name="MSSmartTagsPreventParsing" content="TRUE" />
	<?php dcHeadLinks(); ?>
	<link rel="alternate" type="application/rss+xml" title="RSS" href="<?php dcInfo('rss'); ?>" />
	<link rel="alternate" type="application/xml" title="Atom" href="<?php dcInfo('atom'); ?>" />
	<meta name="DC.title" content="<?php dcInfo(); ?>" />
	<title><?php dcSinglePostTitle('%s - '); dcSingleCatTitle('%s - ');
	dcSingleMonthTitle('%s - '); dcCustomTitle('%s - '); dcInfo(); ?></title>
	<link rel="shortcut icon" href="<?php dcInfo('theme'); ?>/images/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="<?php dcInfo('theme'); ?>/style.css" media="screen" />
	<?php dcPostTrackbackAutoDiscovery(); ?>
</head>

<body>

<div id="page"><a name="debut"></a> 

	<div id="top">
		<h1><a href="<?php dcInfo('url'); ?>"><img src="<?php dcInfo('theme'); ?>/images/title.png" alt="Le Blogueur est dans le pr&eacute;" title="Le Blogueur est dans le pr&eacute;"/></a></h1>
	</div>

	<p id="prelude" class="prel">
	<a href="<?php dcInfo('url'); ?>">Accueil</a> | 
	<a href="#fin">Bas de page</a> |
	<a href="#sidebar">Calendrier</a> |
	<a href="#search">Recherche</a></p>

	<div id="main">
		<div id="content">
			<?php if ($err_msg != '') : /* Si on a une quelconque erreur, on l'affiche */?>
			<div class="error"><strong>Erreur : </strong>
			<?php echo $err_msg; ?></div>
			
			<!-- Affichage des pages connexes (si le pluggin related est installé) -->
			<?php elseif (is_callable(array('dcRelatedPages','relatedMode')) && dcRelatedPages::relatedMode()) : ?>
			<?php dcRelatedPages::includeFile(); ?>
			
			<?php elseif ($preview) : /* Si on demande la prévisualisation d'un commentaire */?>
			<h3>Commentaire pour <?php dcPostTitle(); ?></h3>
			<div id="comment-preview">
				<blockquote>
				<?php dcCommentPreview(); ?>
				</blockquote>
			</div>
			
			<div id="change-comment">
				<h3>Changer le commentaire</h3>
				<?php include dirname(__FILE__).'/form.php'; ?>
			</div>
			
			<?php elseif ($mode != 'post') : /* Si aucune erreur et mode != post on affiche une liste de billets */?>
				<?php # Phrase affichée en cas de recherche (%s est le mot cherché)
				dcSearchString('<p>R&eacute;sultats de votre recherche de <em>%s</em>.</p>');
				?>
			
			<?php include dirname(__FILE__).'/list.php'; ?>
			
			<?php else : /* Sinon, mode = post, donc billet unique (avec commentaires et tout le reste)*/?>
				<?php include dirname(__FILE__).'/post.php'; ?>
			<?php endif; ?>
		</div>
	</div>
	
	<div id="sidebar">
		
		<div id="imgcalendar">
			<img src="<?php dcInfo('theme'); ?>/images/chenille.png" alt="Chenille"/>
		</div>
		<div id="calendar">
			<h2>Calendrier</h2>
			<?php #Affichage du calendrier 
			dcCalendar('<table summary="Calendrier">%s</table>'); ?>
		</div>
		
		<div id="search">
			<form action="<?php dcInfo('search'); ?>" method="get">
				<h2><label for="q">Rechercher</label></h2>
				<p class="field"><input name="q" id="q" type="text" size="10"
				value="<?php dcSearchString(); ?>" accesskey="4" />
				<input type="submit" class="submit" value="ok" /></p>
			</form>
		</div>
		
		<?php /* Affichage du blog "selection uniquement si des billets sont présents */ ?>
		<?php dcSelection('<div id="selection"><h2>&Agrave; retenir</h2><ul>%s</ul></div>'); ?>
		<?php dcLangList('<div id="languages"><h2>Langues</h2><ul>%s</ul></div>'); ?>
		
		<!-- Liens vers les pages connexes (si le pluggin related est installé) -->
		<div>
			<h2>Infos</h2>
			<?php if (is_callable(array('dcRelatedPages','relatedList'))) { dcRelatedPages::relatedList(); } ?>
		</div>

		<div id="categories">
			<h2>Cat&eacute;gories</h2>
			<?php dcCatList(); ?>
		</div>
		
		<div id="archives">
			<h2>Archives</h2>
			<?php dcMonthsList(); ?>
		</div>
		
		<div id="links">
			<h2>Liens</h2>
			<?php dcBlogroll::linkList(); ?>
		</div>
		
		<div id="syndicate">
			<h2>Syndication</h2>
			<ul>
				<li><a href="<?php dcInfo('rss'); ?>">fil rss</a></li>
				<li><a href="<?php dcInfo('rss'); ?>?type=co">fil rss commentaires</a></li>
				<li><a href="<?php dcInfo('atom'); ?>">fil atom</a></li>
				<li><a href="<?php dcInfo('atom'); ?>?type=co">fil atom commentaires</a></li>
			</ul>
		</div>
		
		<!-- Liens vers les autres thèmes (si le pluggin themeswitcher est installé) -->
		<?php if(function_exists('dcThemesList')) { dcThemesList('<div id="themes"><h2>Th&egrave;mes</h2><ul>%s</ul></div>'); } ?>

	</div>
	
	<div id="footer"><a name="fin"></a> 
		<p id="dotclear"><a href="http://www.dotclear.net/"><img src="<?php dcInfo('theme'); ?>/images/dotclear.png" alt="DotClear"/> 
		Propuls&eacute; par DotClear</a> - Thème réalisé par <a href="http://www.callmepep.org/zoe">Zoe</a></p>
		<p id="prelude-bottom" class="prel">
			<a href="<?php dcInfo('url'); ?>">Accueil</a> | 
			<a href="#debut">Haut de page</a> | 
			<a href="#sidebar">Calendrier</a> |
			<a href="#search">Recherche</a>
		</p>
		<p style="clear:both;"></p>
	</div>

</div>
<!-- end #page -->

</body>
</html>
