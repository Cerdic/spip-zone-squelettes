<?php
/**
 * Fonctions utiles au plugin Html5up Solid State 
 *
 * @plugin     Html5up Solid State 
 * @copyright  2017
 * @author     Matthieu Marcillaud
 * @licence    GNU/GPL
 * @package    SPIP\Html5up_solid_state\Fonctions
 */

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

/**
 * Retourne des classes css à écrire.
 *
 * @param int $position
 * @param null|bool $alt
 * @param null|bool $spot
 */
function html5up_sections_css($position = 1, $alt = null, $spot = null) {
	$classes = 'style' . $position;
	if ($spot) {
		$classes .= ' spotlight';
	}
	if (is_null($alt)) {
		$alt = ($position + 1) % 2;
	}
	if ($alt) {
		$classes .= ' alt';
	}
	return $classes;
}