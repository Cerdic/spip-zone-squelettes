<?php
if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/cextras');
include_spip('base/ressourcotheque');

function ressourcotheque_upgrade($nom_meta_base_version,$version_cible) {

	$maj = array();
	$maj['create'] = array(array('ressourcotheque_create'));
  cextras_api_upgrade(ressourcotheque_declarer_champs_extras(), $maj['create']);
  cextras_api_upgrade(ressourcotheque_declarer_champs_extras(), $maj['0.5.0']);
  cextras_api_upgrade(ressourcotheque_declarer_champs_extras(), $maj['0.6.0']);
  include_spip('base/upgrade');
  maj_plugin($nom_meta_base_version, $version_cible, $maj);

}

/**
 * À l'activation pour la première fois de la ressourcothèque
 * configure pas mal de choses
 *
**/

function ressourcotheque_create() {
	include_spip('inc/config');
	//Config indexer
	ecrire_config('indexer/sources_objets', array('spip_articles', 'spip_documents'));
	$statuts_ignores = array('prepa', 'prop', 'refuse', 'poubelle');
	ecrire_config('indexer/article/statuts_ignores', $statuts_ignores);
	ecrire_config('indexer/document/statuts_ignores', $statuts_ignores);
	ecrire_config('indexer/article/jointure_mots/activer', 'on');
	ecrire_config('indexer/source', lire_config('adresse_site'));

	// Configurer documents joints + logos
	ecrire_config('documents_objets','spip_articles,spip_rubriques');
	ecrire_config('activer_logos', 'oui');

	// Configurer articles
	ecrire_config('articles/urlref', 'oui');

	// Configurer mots
	ecrire_config('articles_mots', 'oui');
	ecrire_config('config_precise_groupes', 'oui');
}

function ressourcotheque_vider_tables($nom_meta_base_version) {
	include_spip('inc/meta');
  effacer_meta($nom_meta_base_version);
}
