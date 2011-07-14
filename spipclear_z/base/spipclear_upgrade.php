<?php
if (!defined('_ECRIRE_INC_VERSION')) return;

include_spip('inc/meta');
include_spip('inc/cextras_gerer');
include_spip('spipclear_pipelines');

function spipclear_upgrade($nom_meta_base_version,$version_cible){
	$current_version = "0.0";
	if (	(!isset($GLOBALS['meta'][$nom_meta_base_version]))
			|| (($current_version = $GLOBALS['meta'][$nom_meta_base_version])!=$version_cible)){
		include_spip('spipclear_pipelines');
		include_spip('inc/noizetier');

		if (version_compare($current_version,'0.0','=')){
			$config_defaut = _DIR_PLUGIN_SPIPCLEAR . 'config_noizetier/spipclear.yaml';
			$yaml = spipclear_get_config_noizetier($config_defaut);
			if( noizetier_importer_configuration('remplacer', 'non', $yaml)) 
				ecrire_meta($nom_meta_base_version,$current_version=$version_cible,'non');
			else
				echo _T('spipclear:msg_erreur_v00')."<br/>";
		}
		if (version_compare($current_version,'0.2','<=')){	
			$champs = spipclear_declarer_champs_extras();
			if(installer_champs_extras($champs, $nom_meta_base_version, $version_cible))
				ecrire_meta($nom_meta_base_version,$current_version=$version_cible,'non');
			else
				echo _T('spipclear:msg_erreur_v02')."<br/>";
		}
	}
}

function spipclear_vider_tables($nom_meta_base_version) {
	$champs = spipclear_declarer_champs_extras();
	desinstaller_champs_extras($champs, $nom_meta_base_version);

	effacer_meta($nom_meta_base_version);
}


?>