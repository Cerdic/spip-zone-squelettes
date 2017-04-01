<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

// Permet de recadrer une image en la centrant sur son focus (plugin Centre Image)
function image_focus($img, $largeur, $hauteur, $position = 'center') {
	if (!$img) return('');

	include_spip('filtres_images_lib_mini');
	include_spip('filtres/images_transforme');
	if ((largeur($img) <= $largeur) AND (hauteur($img) <= $hauteur)) {
		$img = image_recadre($img, "$largeur:$hauteur", '+', $position, 'transparent');
		image_graver($img);
		$img = image_recadre($img, $largeur, $hauteur, $position, 'transparent');
	} else  {
		$img = image_recadre($img, "$largeur:$hauteur", '-', 'focus', 'transparent');
		image_graver($img);
		$img = image_reduire($img, $largeur, $hauteur, $position, 'transparent');
	}
	
	image_graver($img);
	
	return $img;
}
