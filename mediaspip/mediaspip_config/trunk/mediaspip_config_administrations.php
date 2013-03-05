<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('base/create');
include_spip('base/abstract_sql');

function mediaspip_config_upgrade($nom_meta_base_version,$version_cible){
	$current_version = 0.0;
	if ((!isset($GLOBALS['meta'][$nom_meta_base_version]) )
			|| (($current_version = $GLOBALS['meta'][$nom_meta_base_version])!=$version_cible)){
		include_spip('base/mediaspip_config');
		if (version_compare($current_version,'0.0','<=')){
			maj_tables(array('spip_auteurs'));
			ecrire_meta($nom_meta_base_version,$current_version=$version_cible,'non');
		}
	}
}

function mediaspip_config_vider_tables($nom_meta_base_version) {
	effacer_meta($nom_meta_base_version);
}

?>