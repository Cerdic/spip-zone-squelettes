<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function fsgtf_upgrade($nom_meta_base_version, $version_cible) {
	$maj = array();
	include_spip('base/upgrade');
	maj_plugin($nom_meta_base_version, $version_cible, $maj);
}

function fsgtf_vider_tables($nom_meta_base_version) {
	effacer_meta('fsgtf');
	effacer_meta($nom_meta_base_version);
}

?>
