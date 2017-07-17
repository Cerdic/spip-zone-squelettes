<?php

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

/**
 * Inspirer par Newsletter, cette fonction renvoie la liste des squelettes
 * inc-sommaire*.html
 *
 * @access public
 * @return mixed
 */
function zoundation_trouver_squelettes_sommaire() {
	$patrons = array();
	// Trouver tout les squelettes inclure/inc-sommaire-*
	$files = find_all_in_path('inclure/', 'inc-sommaire(.*)\.html');


	if (!$files) {
		return $patrons;
	}

	foreach ($files as $k => $file) {
		$fond = basename($k, '.html');
		//  ignorer les variantes .texte.html et .page.html utilisee pour generer les version textes et page en ligne
		if (count($e = explode('.', $fond)) < 2 or !in_array(end($e), array('page', 'texte'))) {
			$patrons[$fond] = $fond;
		}
	}

	return $patrons;
}
