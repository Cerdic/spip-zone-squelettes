<?php
/**
 * Fichier gérant l'installation et désinstallation du plugin Html5up Spectral
 *
 * @plugin     Html5up Spectral
 * @copyright  2020
 * @author     chankalan
 * @licence    GNU/GPL
 * @package    SPIP\Html5up_spectral\Installation
 */

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}


/**
 * Fonction d'installation et de mise à jour du plugin Html5up Spectral .
 *
 * @param string $nom_meta_base_version
 *     Nom de la meta informant de la version du schéma de données du plugin installé dans SPIP
 * @param string $version_cible
 *     Version du schéma de données dans ce plugin (déclaré dans paquet.xml)
 * @return void
**/
function html5up_spectral_upgrade($nom_meta_base_version, $version_cible) {
	$maj = array();
	$maj['create'] = array(
		array('ecrire_config','html5up', array(
			'couleur_accent' => '#ed4933',
			'couleur_typo_entete' => '#ffffff',
			'couleur_bkg_entete' => '#1D242A',
		))
	);
	include_spip('base/upgrade');
	maj_plugin($nom_meta_base_version, $version_cible, $maj);
}


/**
 * Fonction de désinstallation du plugin Html5up Spectral .
 *
 * @param string $nom_meta_base_version
 *     Nom de la meta informant de la version du schéma de données du plugin installé dans SPIP
 * @return void
**/
function html5up_spectral_vider_tables($nom_meta_base_version) {
	effacer_meta($nom_meta_base_version);
	effacer_meta('html5up');
}
