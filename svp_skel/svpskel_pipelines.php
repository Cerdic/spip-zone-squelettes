<?php

/**
 * Insertion dans le pipeline insert_head_css
 * Permet d'inserer les css necessaires aux page publiques de SVP Squelettes
 *
 * @param object $flux
 * @return $flux
 */
function svpskel_insert_head_css($flux) {
	if ($f = find_in_path('css/svpskel_habillage.css')) {
		$flux .= '<link rel="stylesheet" href="'.direction_css($f).'" type="text/css" media="all" />';
	}
	return $flux;
}

?>
