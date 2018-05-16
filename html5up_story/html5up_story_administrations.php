<?php
/**
 * Fichier gérant l'installation et désinstallation du plugin Html5up Story
 *
 * @plugin     Html5up Story
 * @copyright  2018
 * @author     erational
 * @licence    GNU/GPL
 * @package    SPIP\Html5up_story\Installation
 */

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

include_spip('inc/meta');


/**
 * Fonction d'installation et de mise à jour du plugin Html5up Story .
 *
 * @param string $nom_meta_base_version
 *     Nom de la meta informant de la version du schéma de données du plugin installé dans SPIP
 * @param string $version_cible
 *     Version du schéma de données dans ce plugin (déclaré dans paquet.xml)
 * @return void
**/
function html5up_story_upgrade($nom_meta_base_version, $version_cible) {
	$maj = array();
	$maj['create'] = array(
		array('ecrire_config','html5up_story', lire_config('html5up_story')),
		array('html5up_story_desactive_mediabox'),
	);

	/*
	$maj['1.1.0'] = array(
	);
	*/

	include_spip('base/upgrade');
	maj_plugin($nom_meta_base_version, $version_cible, $maj);
}


/**
 * Fonction de désinstallation du plugin Html5up Story
 *
 * @param string $nom_meta_base_version
 *     Nom de la meta informant de la version du schéma de données du plugin installé dans SPIP
 * @return void
**/
function html5up_story_vider_tables($nom_meta_base_version) {
	effacer_meta($nom_meta_base_version);
	effacer_meta('html5up_story');
	effacer_meta('mediabox');
}


/**
 * Fonction pour désactiver mediabox et éviter les conflits de js
 *
 * @return void
**/
function html5up_story_desactive_mediabox() {
	effacer_meta('mediabox');
	$config['active'] = 'non';
	ecrire_meta('mediabox', serialize($config));
}
