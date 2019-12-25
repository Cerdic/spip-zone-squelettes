<?php
/**
 * Squelette SarkaSPIP v3
 * (c) 2005-2015 Licence GPL 3.
 */
if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

// =======================================================================================================================================
// Balises : AGENDA, RUBRIQUE, AUJOURDHUI...
// =======================================================================================================================================
// Auteur: Smellup
// Fonction : regroupe les balises definies par le squelette
// =======================================================================================================================================
//
include_spip('public/sarkaspip_balises');

// =======================================================================================================================================
// Criteres : tout_voir...
// =======================================================================================================================================
// Auteur: Smellup
// Fonction : regroupe les criteres definis par le squelette
// =======================================================================================================================================
//
include_spip('public/sarkaspip_criteres');

// =======================================================================================================================================
// Filtres :
// =======================================================================================================================================
// Auteur: Smellup
// Fonction : regroupe les filtres definis par le squelette
// =======================================================================================================================================
//
include_spip('inc/sarkaspip_filtres');

function ajuster_couleur_input($couleur, $type) {
	include_spip('filtres/couleurs');
	$transparent = ($type == 'background') ? '#ffffff' : '#000000';
	if (strtolower($couleur) == 'transparent') {
		$couleur_calculee = $transparent;
	} elseif ($type == 'color') {
		$couleur_calculee = '#'.couleur_extreme(couleur_inverser($couleur));
	} else {
		$couleur_calculee = $couleur;
	}

	return $couleur_calculee;
}
