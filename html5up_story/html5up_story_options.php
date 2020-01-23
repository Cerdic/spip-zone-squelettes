<?php
/**
 * Chargement du plugin Html5up Story
 *
 * @plugin     Html5up Story
 * @copyright  2018
 * @author     erational
 * @licence    GNU/GPL
 * @package    SPIP\Html5up_story\Options
 */

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

// desactiver l'insertion de jquery  dsn insert_head
// pour eviter les conflits entre jquery 1.1 et jquery 3.2
// Charge uniquement le .js que je veux
// https://forum.spip.net/fr_249697.html
$GLOBALS['spip_pipeline']['jquery_plugins'] .= "|limiter_javascript_html5_story";

function limiter_javascript_html5_story($plugins){
	include_spip('inc/utils');

	// uniquement sur les pages publiques de SPIP (ne pas casser l'admin)
	if(!test_espace_prive()) {
		//return array('javascript/jquery.js');  // exemple dans lequel on garde uniquement jQuery mais pas les autres jQuery UI
		$plugins = array(); // Aucun jQuery ... Le crayon a un js embarqué
	}

	return $plugins;
}