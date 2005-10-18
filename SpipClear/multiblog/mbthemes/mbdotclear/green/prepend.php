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

# Change here the template lang
//$__lang = 'fr';

# Ajout des fichiers du template pour le cache
$mod_files[] = dirname(__FILE__).'/list.php';
$mod_files[] = dirname(__FILE__).'/post.php';
$mod_files[] = dirname(__FILE__).'/form.php';
$mod_files[] = dirname(__FILE__).'/style.css';

/**
 * Affiche un barre d'outils pour la mise en forme des commentaires au format wiki.
 *
 * @param string $message un message d'information optionnel.
 *
 */
function dcWikiCommentToolbar($message = '') {
	global $theme_path, $theme_uri, $__theme;
	
	if (is_dir($theme_path.$__theme.'/wikibtns/')) {
		$dc_url_wikibuttons = $theme_uri.$__theme.'/wikibtns/';
	} else {
		$dc_url_wikibuttons = $theme_uri.'default/wikibtns/';
	}
	if (file_exists($theme_path.$__theme.'/js/wikibar.js')) {
		$dc_url_wikijs = $theme_uri.$__theme.'/js/wikibar.js';
	} else {
		$dc_url_wikijs = $theme_uri.'default/js/wikibar.js';
	}
	if (dc_wiki_comments) {
		echo '<script type="text/javascript" src="'.$dc_url_wikijs.'"></script>'. "\n".
'<script type="text/javascript">'. "\n".
"	if (document.getElementById) {
		var tb = new dcWikiBar(document.getElementById('c_content'),'$dc_url_wikibuttons');
	
		tb.btStrong('".str_replace("'","\'",__('Strong emphasis'))."');
		tb.btEm('".str_replace("'","\'",__('Emphasis'))."');
		tb.btIns('".str_replace("'","\'",__('Inserted'))."');
		tb.btDel('".str_replace("'","\'",__('Deleted'))."');
		tb.btQ('".str_replace("'","\'",__('Inline quote'))."');
		tb.btCode('".str_replace("'","\'",__('Code'))."');
		tb.btBr('".str_replace("'","\'",__('Line break'))."');
		tb.btPre('".str_replace("'","\'",__('Preformated text'))."');
		tb.btList('".str_replace("'","\'",__('Unordered list'))."','ul');
		tb.btList('".str_replace("'","\'",__('Ordered list'))."','ol');
		tb.btLink('".str_replace("'","\'",__('Link'))."',
			'".str_replace("'","\'",__('URL?'))."',
			'".str_replace("'","\'",__('Language?'))."',
			'".DC_LANG."');
		tb.addSpace(10);
		tb.draw('$message');
	}
</script>\n";
	}
}
?>
