<?php
if (!defined('_ECRIRE_INC_VERSION')) return;

include_spip('inc/meta');

function spipclear_upgrade($nom_meta_base_version,$version_cible){
	$current_version = "0.0";
	if (	(!isset($GLOBALS['meta'][$nom_meta_base_version]))
			|| (($current_version = $GLOBALS['meta'][$nom_meta_base_version])!=$version_cible)){
		include_spip('spipclear_pipelines');
		include_spip('inc/noizetier');
		if ($current_version==0.0){
			$config_defaut = _DIR_PLUGIN_SPIPCLEAR . 'config_noizetier/spipclear.yaml';
			$yaml = spipclear_get_config_noizetier($config_defaut);
			noizetier_importer_configuration('remplacer', 'non', $yaml);
			ecrire_meta($nom_meta_base_version,$current_version=$version_cible,'non');
		}
	}
}

function spipclear_vider_tables($nom_meta_base_version) {
	effacer_meta($nom_meta_base_version);
}

?>