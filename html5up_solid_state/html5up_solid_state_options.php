<?php
/**
 * Chargement du plugin Html5up Solid State
 *
 * @plugin     Html5up Solid State
 * @copyright  2017
 * @author     Matthieu Marcillaud
 * @licence    GNU/GPL
 * @package    SPIP\Html5up_solid_state\Options
 */

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

$GLOBALS['z_blocs'] = array('content', 'head', 'head_js', 'breadcrumb', 'header', 'footer');

// stocker la langue d'arrivee pour que le sommaire affiche la langue souhaitee
// et on ajoute la langue dans le contexte systematiquement.
if (!$langue = _request('lang')) {
	include_spip('inc/lang');
	$langues = explode(',', $GLOBALS['meta']['langues_multilingue']);
	$langue = utiliser_langue_visiteur();
	if (!in_array($langue, $langues)) {
		$langue = $GLOBALS['meta']['langue_site'];
	}
	set_request('lang', $langue);
}

// stocker la langue...
if ($langue != $_COOKIE['spip_lang']) {
	include_spip('inc/cookie');
	spip_setcookie('spip_lang', $langue);
}
