<?php

if (!defined('_ECRIRE_INC_VERSION')) return;

$GLOBALS['spip_pipeline']['insert_head'] .= "|moodboard";

function moodboard_insert_head($flux){
	$js_jquery_wookmark = find_in_path('js/jquery.wookmark.js');
	$flux .= "<script type='text/javascript' src='$js_jquery_wookmark'></script>\n";
	return $flux;
}

$GLOBALS['spip_pipeline']['insert_head_css'] .= "|moodboard";

function moodboard_insert_head_css($flux){
	$css_moodboard = find_in_path('css/moodboard.css');
	$flux .= "<link rel='stylesheet' type='text/css' media='all' href='$css_moodboard' />\n";
	return $flux;
}
?>