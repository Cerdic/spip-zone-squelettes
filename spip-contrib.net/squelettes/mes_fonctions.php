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


function date_rfc822($date_heure) {
  list($annee, $mois, $jour) = recup_date($date_heure);
  list($heures, $minutes, $secondes) = recup_heure($date_heure);
  $time = mktime($heures, $minutes, $secondes, $mois, $jour, $annee);
  return gmdate("D, d M Y H:i:s +0100", $time);
}


function age_style($date) {
 	
// $decal en secondes
$decal = date("U") - date("U", strtotime($date));
			 
// 3 jours = vieux
$decal = min(1.0, sqrt($decal/(3*24*3600)));
			 
// Quand $decal = 0, c'est tout neuf : couleur vive
// Quand $decal = 1, c'est vieux : bleu pale
$red = ceil(128+127*(1-$decal));
$blue = ceil(130+60*$decal);
$green = ceil(200+55*(1-$decal));
										 
$couleur = dec2hex($red).dec2hex($green).dec2hex($blue);
											 
return 'background-color: #'.$couleur.';';
}


?>
