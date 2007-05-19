<?php


define('SECTEUR_WIKI', 607);

// true quand on vient du wiki
// true dans l'espace prive
// true dans les crayons
// false dans les autres pages (publiques hors wiki)
function boucle_exclure_secteur() {
	return
	(
		_DIR_RESTREINT==''
		OR _request('action')
		OR (defined('RUBRIQUE_WIKI_OK') AND RUBRIQUE_WIKI_OK)
	)
		? '0'
		: SECTEUR_WIKI
	;
}

//
// <BOUCLE(ARTICLES)> sans le wiki (secteur 607)
//
function boucle_ARTICLES($id_boucle, &$boucles) {
	$boucle = &$boucles[$id_boucle];
	$id_table = $boucle->id_table;

	$boucle->where[] = array("'!='", "'id_secteur'", '_q(boucle_exclure_secteur())');

	return boucle_ARTICLES_dist($id_boucle, $boucles);
}

//
// <BOUCLE(RUBRIQUES)> sans le wiki (secteur 607)
//
function boucle_RUBRIQUES($id_boucle, &$boucles) {
	$boucle = &$boucles[$id_boucle];
	$id_table = $boucle->id_table;

	$boucle->where[] = array("'!='", "'id_secteur'", '_q(boucle_exclure_secteur())');

	return boucle_RUBRIQUES_dist($id_boucle, $boucles);
}


?>
