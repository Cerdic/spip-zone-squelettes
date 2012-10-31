<?php
/**
 * Squelette SarkaSPIP v4
 * (c) 2005-2012 Licence GPL 3
 */

if (!defined('_ECRIRE_INC_VERSION')) return;


/**
 * Fonction d'installation du plugin et de mise à jour.
**/
function sarkaspip_upgrade($nom_meta_base_version, $version_cible){
	$maj = array();

	include_spip('inc/config');
	include_spip('base/abstract_sql');

	$secteur_forum = lire_config("sarkaspip_forum/rubrique_forum");

	# Premiere installation  creation des tables
	$maj['create'] = array(
		array('sql_updateq', 'spip_rubriques', array('composition' => 'forums'), 'id_rubrique= '.intval($secteur_forum)),
	);

	$maj['0.1.1'] = array(
		array('sql_updateq', 'spip_rubriques', array('composition' => 'forums'), 'id_rubrique= '.intval($secteur_forum)),
	);

	include_spip('base/upgrade');
	maj_plugin($nom_meta_base_version, $version_cible, $maj);
}


/**
 * Fonction de désinstallation du plugin.
**/
function sarkaspip_vider_tables($nom_meta_base_version) {


	# suppression meta & config
	effacer_meta($nom_meta_base_version);

}

?>
