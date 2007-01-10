<?php

$GLOBALS['puce'] = '- ';

// mettre en place la version et date de la release stable de SPIP
# valeurs definies dans ecrire/mes_options.php3 
#define_once('VERSION_STABLE', '1.8.1');
#define_once('VERSION_STABLE_URL', 'spip-dev/DISTRIB/SPIP-v1-8-1-c.zip');
function filtres_telecharger($texte) {
	$texte = str_replace('$$version_stable$$', VERSION_STABLE, $texte);
	$texte = str_replace('$$version_stable_url$$', VERSION_STABLE_URL, $texte);

	define('VERSION_STABLE_DATE', date("Y-m-d", @filemtime(VERSION_STABLE_URL)));
	$texte = str_replace('$$version_stable_date$$', affdate(VERSION_STABLE_DATE), $texte);
	return $texte;
}

// pour les forums
function raccourcir_nom($nom) {
	if (strpos($nom, "@")) {
		$nom = substr($nom, 0, strpos($nom, "@"));	
	}
	return $nom;
}

// pour afficher proprement le nom des langues
function afficher_nom_langue ($lang) {
	if (ereg("^oc(_|$)", $lang))
		return "occitan";
	else
		return traduire_nom_langue($lang);
}

// pour rendre les dates insecables dans les pages forum
function insecable ($texte) {
	return ereg_replace("( |&nbsp;)+", "&nbsp;", $texte);
}

// hack pour ne jamais afficher les secteurs d'aide en ligne
// sauf evidemment dans le cas de l'aide en ligne
define('secteurs_aide', '324');
if (!defined('aide_en_ligne')) {
	function boucle_ARTICLES($id_boucle, &$boucles) {
		$boucles[$id_boucle]->where[] = array("'NOT IN'", "'id_secteur'", '"('.secteurs_aide.')"');
		return boucle_ARTICLES_dist($id_boucle, $boucles);
	}
	function boucle_RUBRIQUES($id_boucle, &$boucles) {
		$boucles[$id_boucle]->where[] = array("'NOT IN'", "'id_secteur'", '"('.secteurs_aide.')"');
		return boucle_RUBRIQUES_dist($id_boucle, $boucles);
	}
	function boucle_HIERARCHIE($id_boucle, &$boucles) {
		$boucles[$id_boucle]->where[] = array("'NOT IN'", "'id_secteur'", '"('.secteurs_aide.')"');
		return boucle_HIERARCHIE_dist($id_boucle, $boucles);
	}
}

?>