<?php
/**
 * Fichier gérant l'installation et désinstallation du plugin Html5up Massively
 *
 * @plugin     Html5up Massively
 * @copyright  2017
 * @author     chankalan
 * @licence    GNU/GPL
 * @package    SPIP\Html5up_massively\Installation
 */

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}


/**
 * Fonction d'installation et de mise à jour du plugin Html5up Massively .
 *
 * @param string $nom_meta_base_version
 *     Nom de la meta informant de la version du schéma de données du plugin installé dans SPIP
 * @param string $version_cible
 *     Version du schéma de données dans ce plugin (déclaré dans paquet.xml)
 * @return void
**/
function html5up_massively_upgrade($nom_meta_base_version, $version_cible) {
	$maj = array();
	$maj['create'] = array(
		array('ecrire_config','html5up', array(
			'couleur_accent' => '#18bfef',
			'couleur_typo' => '#909498',
			'couleur_bkg' => '#ffffff',
			'couleur_bkg_footer' => '#F5F5F5',
		))
	);
	include_spip('base/upgrade');
	maj_plugin($nom_meta_base_version, $version_cible, $maj);
}


/**
 * Fonction de désinstallation du plugin Html5up Massively .
 *
 * @param string $nom_meta_base_version
 *     Nom de la meta informant de la version du schéma de données du plugin installé dans SPIP
 * @return void
**/
function html5up_massively_vider_tables($nom_meta_base_version) {
	effacer_meta($nom_meta_base_version);
	effacer_meta('html5up');
}