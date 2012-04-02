<?php

if (!defined('_ECRIRE_INC_VERSION')) return;

function scolaspip_insert_head($flux){
	$js_start = parametre_url(generer_url_public('scolaspip.js'), 'lang', $lang);
	if (_VAR_MODE=="recalcul")
		$js_start = parametre_url($js_start, 'var_mode', 'recalcul');
	$flux .= "<script type='text/javascript' src='$js_start'></script>\n";

	return $flux;
}
function scolaspip_insert_head_css($flux){
	$config = scolaspip_couleurs_config();
	if ($config['css_scolaspip']=='oui') {
		$flux .= '<link rel="stylesheet" href="'.direction_css(find_in_path('scolaspip.css')).'" type="text/css" media="all" />';
		if ($config['couleurs']=='oui') {
			$css_start = parametre_url(generer_url_public('couleurs.css'), 'lang', $lang);
			if (_VAR_MODE=="recalcul")
				$css_start = parametre_url($css_start, 'var_mode', 'recalcul');
			$flux .= "<link rel='stylesheet' href='$css_start' type='text/css' media='all' />";
		}
	}
	else{
		$flux .= '<link rel="stylesheet" href="'.direction_css(find_in_path('sans_scolaspip.css')).'" type="text/css" media="all" />';
	}
	return $flux;
}

?>
