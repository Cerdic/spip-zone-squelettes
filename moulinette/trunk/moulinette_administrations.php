<?php
if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/meta');

// Installation et mise a jour
function moulinette_upgrade($nom_meta_version_base, $version_cible){

	include_spip('inc/config');
	$maj = array();
	$maj['create'] = array(
			array('ecrire_config','moulinette', array(
				'accueil' => '1'
	)));
	include_spip('base/upgrade');
	maj_plugin($nom_meta_version_base, $version_cible, $maj);
}

// Desinstallation
function moulinette_vider_tables($nom_meta_version_base){
	effacer_meta('moulinette');
	effacer_meta($nom_meta_version_base);
}
