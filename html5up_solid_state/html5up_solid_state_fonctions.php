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

/**
 * Créer une balise image carrée adaptée au thème
 */
function html5up_image_reduire_carre($img, $taille = 300) {
	return html5up_image_reduire($img, $taille, $taille);
}

/**
 * Créer une balise image adaptée au thème
 *
 * Équivalent de :
 *
 *     [(#LOGO_RUBRIQUE
 *         |image_passe_partout{300,300}
 *         |image_recadre{300,300,center}
 *         |vider_attribut{height}
 *         |vider_attribut{width})]
 *
 */
function html5up_image_reduire($img, $width = 300, $height = 300) {
	$img = filtrer('image_passe_partout', $img, $width, $height);
	$img = filtrer('image_recadre', $img, $width, $height, 'center');
	$img = filtrer('image_graver', $img);
	$img = vider_attribut($img, 'width');
	$img = vider_attribut($img, 'height');
	return $img;
}