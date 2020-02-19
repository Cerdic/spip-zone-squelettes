<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

// Permet de recadrer une image en la centrant sur son focus (plugin Centre Image)
function image_focus($img, $largeur, $hauteur, $position = 'center') {
	if (!$img) return('');
	
	$largeurimg = largeur($img);
	$hauteurimg = largeur($img);
	
	$GLOBALS['Smush_Debraye'] = true;
	
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
		$img = filtrer('image_recadre', $img, "$largeur:$hauteur", '-', 'focus', 'transparent');
		$img = filtrer('image_graver', $img);
		$img = filtrer('image_reduire', $img, $largeur, $hauteur, $position, 'transparent');
	}
	
	$GLOBALS['Smush_Debraye'] = false;
	
	return $img;
}
