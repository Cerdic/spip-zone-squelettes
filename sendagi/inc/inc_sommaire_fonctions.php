<?php


// Sécurité
if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

// couper un partie en 2 parties egales en gerant la cesure des mots
// https://www.webmaster-hub.com/topic/20066-couper-un-texte-en-3-parties-%C3%A9gales/
function couper_2_parties($str, $partie) {
	$longueur = strlen($str);
	// on decale de 35 pour éviter de generer  3 segments
	// sinon l'autre possibilité de coller le morceau 2 avec le morceau 3
	$longueur_segment = floor($longueur / 2) + 40;
	$parties = explode("\n", wordwrap($str, $longueur_segment, "\n", false));

	if (isset($parties[$partie-1]))  {
		return $parties[$partie-1];
	}
	return $str;
}