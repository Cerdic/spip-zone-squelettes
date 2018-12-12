<?php
/**
 * Plugin / Squelettes Gribouille
 * © Fil
 * Distribue sous licence GNU/GPL
 */

if (!defined("_ECRIRE_INC_VERSION")) {
	return;
}

/**
 * Retourne le diff d'un objet
 * (uniquement pour les articles en 2.0.X)
 * Ex: [<small> (#ID_ARTICLE|gribouille_calcul_diff{article,#ID_VERSION,diff}|supprimer_tags|couper{50})</small>]
 *
 * @param int    $id_objet
 * @param string $objet
 * @param int    $id_version
 * @param string $format [optional]
 *
 * @return array
 */
function gribouille_calcul_diff($id_objet, $objet, $id_version, $format = 'complet') {
	include_spip('inc/suivi_versions');
	
	$textes = revision_comparee($id_objet, $objet, $id_version, $format);
	$ret = array();
	foreach ($textes as $champ => $texte) {
		$ret[$champ] = propre_diff($texte);
	}

	return $ret;
}

/**
 * Retourne l'id_secteur du Wiki
 * 
 * @return array|mixed
 */
function gribouille_secteurs_wiki() {
	include_spip('inc/filtres');
	$f = chercher_filtre('info_plugin');
	if($f('autorite','est_actif')) {
		return lire_config('autorite/espace_wiki');
	} else {
		return array(lire_config('gribouille/secteur_wiki'));
	}
}


/**
 * Teste si on doit exclure le secteur Wiki 
 * true quand on vient du wiki
 * true dans l'espace prive
 * true dans les crayons
 * false dans les autres pages (publiques hors wiki)
 *
 * @return array|mixed|null
 */
function boucle_exclure_secteur() {
	if (!test_espace_prive() && !_request('action')) {
		return gribouille_secteurs_wiki();
	}
	return array();
}

/**
 * Surcharge de la boucle ARTICLES permettant d'exclure les articles du Wiki
 * @param $id_boucle
 * @param $boucles
 *
 * @return string
 */
function boucle_ARTICLES($id_boucle, &$boucles) {
	$boucle = &$boucles[$id_boucle];
	$id_table = $boucle->id_table;
	$secteurs_wiki = join(',',boucle_exclure_secteur());

	if (empty($boucle->modificateur['wiki']) && $secteurs_wiki) {
		$boucle->where[] = array(
			"'NOT IN'",
			"'$id_table.id_secteur'",
			"'($secteurs_wiki)'",
		);
	}

	return boucle_DEFAUT_dist($id_boucle, $boucles);
}

/**
 * Surcharge de la boucle RUBRIQUES permettant d'exclure les rubriques du Wiki
 * @param $id_boucle
 * @param $boucles
 *
 * @return string
 */
function boucle_RUBRIQUES($id_boucle, &$boucles) {
	$boucle = &$boucles[$id_boucle];
	$id_table = $boucle->id_table;
	$secteurs_wiki = join(',',boucle_exclure_secteur());

	if (empty($boucle->modificateur['wiki']) && $secteurs_wiki) {
		$boucle->where[] = array(
			"'NOT IN'",
			"'$id_table.id_secteur'",
			"'($secteurs_wiki)'",
		);
	}

	return boucle_DEFAUT_dist($id_boucle, $boucles);
}

/**
 * Critère qui restreint les boucles articles et rubriques du wiki
 * 
 * @param $idb
 * @param $boucles
 * @param $crit
 */
function critere_wiki($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
	$id_table = $boucle->id_table;
	$id_secteurs_wiki = join(',',gribouille_secteurs_wiki());
	if($id_secteurs_wiki) {
		$boucle->where[] = array(
			"'IN'",
			"'$id_table.id_secteur'",
			"'($id_secteurs_wiki)'"
		);
	}
	$boucle->modificateur['wiki'] = true;
}

/**
 * Critère qui restreint les versions aux articles du wiki
 * 
 * @param $idb
 * @param $boucles
 * @param $crit
 */
function critere_versions_wiki($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
	$id_table = $boucle->id_table;
	$id_secteurs_wiki = join(',',gribouille_secteurs_wiki());
	
	$boucle->select[]= 'articles.*';
	$boucle->from['articles'] = "spip_articles";
	$boucle->from_type['articles'] = "LEFT";
	$boucle->join["articles"]= array("'$id_table'","'id_article'","'id_objet'","'$id_table.objet=\"article\"'");
	
	$boucle->where[] = array("'IN'", "'articles.id_secteur'", "'($id_secteurs_wiki)'");
	$boucle->where[] = array("'='", "'articles.statut'", "'\"publie\"'");
	$boucle->modificateur['wiki'] = true;
}

/**
 * Masque les deux derniers octets d'une adresse IP
 *
 * @param $texte
 *
 * @return string
 */
function masquer_ip($texte) {
	if (preg_match('#^(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\z#', $texte, $matches)) {
		return $matches[1] . '.' . $matches[2] . '.xx.xx';
	} else {
		return $texte;
	}
}