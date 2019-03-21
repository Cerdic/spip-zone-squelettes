<?php
/**
 * Fichier gérant l'installation et désinstallation du plugin Html5up Phantom
 *
 * @plugin     Html5up Phantom
 * @copyright  2017
 * @author     chankalan
 * @licence    GNU/GPL
 * @package    SPIP\Html5up_phantom\Installation
 */

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

include_spip('inc/cextras');
include_spip('base/phantom');

/**
 * Fonction d'installation et de mise à jour du plugin Html5up Phantom .
 *
 * @param string $nom_meta_base_version
 *     Nom de la meta informant de la version du schéma de données du plugin installé dans SPIP
 * @param string $version_cible
 *     Version du schéma de données dans ce plugin (déclaré dans paquet.xml)
 * @return void
**/
function html5up_phantom_upgrade($nom_meta_base_version, $version_cible) {
	$maj = array();
	$maj['create'] = array(
		array('ecrire_config','html5up', array(
			'couleur_accent' => '#f56a6a',
		))
	);
	$maj['0.0.2'] = array(
		array('ecrire_config','html5up', array(
			'couleur_typo' => '#585858',
			'couleur_bkg' => '#ffffff',
			'couleur_bkg_footer' => '#f6f6f6',
		))
	);
	cextras_api_upgrade(html5up_phantom_declarer_champs_extras(), $maj['create']);
	include_spip('base/upgrade');
	maj_plugin($nom_meta_base_version, $version_cible, $maj);
}


/**
 * Fonction de désinstallation du plugin Html5up Phantom .
 *
 * @param string $nom_meta_base_version
 *     Nom de la meta informant de la version du schéma de données du plugin installé dans SPIP
 * @return void
**/
function html5up_phantom_vider_tables($nom_meta_base_version) {
	cextras_api_vider_tables(html5up_phantom_declarer_champs_extras());
	effacer_meta($nom_meta_base_version);
	effacer_meta('html5up');
}