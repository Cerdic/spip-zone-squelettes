<?php


define('SECTEUR_WIKI', 607);

//
// <BOUCLE(ARTICLES)> sans le wiki (secteur 607)
//
function boucle_ARTICLES($id_boucle, &$boucles) {
	$boucle = &$boucles[$id_boucle];
	$id_table = $boucle->id_table;

	// true quand on vient du wiki
	// true dans l'espace prive
	// false dans les autres pages (publiques hors wiki)
	define ('RUBRIQUE_WIKI_OK', _DIR_RESTREINT=='');

	if (!RUBRIQUE_WIKI_OK) {
		// et le filtrage d'acces filtre !
		$boucle->where[] = array("'!='", "'id_secteur'", "'".SECTEUR_WIKI."'");
	}

	return boucle_ARTICLES_dist($id_boucle, $boucles);
}

//
// <BOUCLE(RUBRIQUES)> sans le wiki (secteur 607)
//
function boucle_RUBRIQUES($id_boucle, &$boucles) {
	$boucle = &$boucles[$id_boucle];
	$id_table = $boucle->id_table;

	define ('RUBRIQUE_WIKI_OK', _DIR_RESTREINT=='');

	if (!RUBRIQUE_WIKI_OK) {
		// et le filtrage d'acces filtre !
		$boucle->where[] = array("'!='", "'id_secteur'", "'".SECTEUR_WIKI."'");
	}

	return boucle_RUBRIQUES_dist($id_boucle, $boucles);
}


?>
