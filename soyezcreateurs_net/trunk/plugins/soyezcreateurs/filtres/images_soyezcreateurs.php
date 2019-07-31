<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

// Permet de recadrer une image en la centrant sur son focus (plugin Centre Image)
function image_focus($img, $largeur, $hauteur, $position = 'center') {
	if (!$img) return('');
	
	include_spip('filtres_images_lib_mini');
	include_spip('filtres/images_transforme');
	$largeurimg = largeur($img);
	$hauteurimg = largeur($img);
	if (($largeurimg <= $largeur) AND ($hauteurimg <= $hauteur)) {
		$img = filtrer('image_recadre', $img, $largeur, $hauteur, $position, 'transparent');
	} else if (($largeurimg <= $largeur) OR ($hauteurimg <= $hauteur)) {
		if ($largeurimg <= $largeur) {
			$img = filtrer('image_recadre', $img, "$largeurimg:$hauteur", '-', 'focus', 'transparent');
			$img = filtrer('image_graver', $img);
		} else {
			$img = filtrer('image_recadre', $img, "$largeur:$hauteurimg", '-', 'focus', 'transparent');
			$img = filtrer('image_graver', $img);			
		}
		$img = filtrer('image_recadre', $img, $largeur, $hauteur, $position, 'transparent');
	} else  {
		// On commence par réduire à 2 fois la taille finale pour travailler sur de plus petites images
		$img = filtrer('image_reduire', $img, $largeur*2, $hauteur*2, $position, 'transparent');
		$img = filtrer('image_graver', $img);
		$img = filtrer('image_recadre', $img, "$largeur:$hauteur", '-', 'focus', 'transparent');
		$img = filtrer('image_graver', $img);
		$img = filtrer('image_reduire', $img, $largeur, $hauteur, $position, 'transparent');
		$img = filtrer('image_graver', $img);
		$img = filtrer('image_recadre', $img, $largeur, $hauteur, $position, 'transparent');
	}
	
	// Pas la peine, c'est fait automatiquement quand c'est un vrai filtre d'image comme ici
	// Par contre, il en faut pour les images intermédiaires !!!!
	//$img = filtrer('image_graver', $img);
	
	return $img;
}
