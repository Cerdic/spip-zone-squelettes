<?php
/**
 * Fonctions utiles au plugin Html5up Spectral 
 *
 * @plugin     Html5up Spectral 
 * @copyright  2020
 * @author     chankalan
 * @licence    GNU/GPL
 * @package    SPIP\Html5up_spectral\Fonctions
 */

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
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
 *         |vider_attribut{width}
 *         |vider_attribut{class})]
 *	+ un parametre pour la couleur de fond sans le # -> image_recadre
 *
 */
function html5up_image_reduire($img, $width = 500, $height = 400, $alt = '', $fond = FFFFFF) {
	if (defined('_DIR_PLUGIN_CENTRE_IMAGE')) {
		$img = filtrer('image_recadre', $img, "$width:$height", '-', 'focus');
	}
	$img = filtrer('image_passe_partout', $img, $width, $height);
	$img = filtrer('image_recadre', $img, $width, $height, 'center', '#'.$fond);
	$img = filtrer('image_graver', $img);
	$img = vider_attribut($img, 'width');
	$img = vider_attribut($img, 'height');
	$img = vider_attribut($img, 'class');
	$img = inserer_attribut($img, 'alt', $alt);
	return $img;
}

/**
 * Pouvoir utiliser un paramètre de configuration de couleur hexa dans un css rgba
 * 
 * cf css/styles_config.css.html
 * [.arbo { color:rgba((#CONFIG{html5up/couleur_typo}|html5up_hex2dec),0.5) !important; }]
 *
 */
function html5up_hex2dec($hex){
	include_spip('inc/filtres_images_lib_mini');
	$dec = _couleur_hex_to_dec($hex);
	$rgb = $dec['red'].','.$dec['green'].','.$dec['blue'];
	return $rgb;
}
