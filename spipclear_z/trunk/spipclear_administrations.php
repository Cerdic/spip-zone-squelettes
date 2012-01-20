<?php
if (!defined('_ECRIRE_INC_VERSION')) return;

include_spip('inc/meta');
include_spip('inc/cextras');
include_spip('spipclear_pipelines');

/**
 * Fonction d'upgrade/maj
 * On cree une configuration par defaut
 *
 * @param string $nom_meta_base_version
 * @param string $version_cible
 */
function spipclear_upgrade($nom_meta_base_version,$version_cible){
		include_spip('noisetier_fonctions');
		$config_defaut = _DIR_PLUGIN_SPIPCLEAR . 'config_noizetier/spipclear.yaml';

		$maj['create'] = array(
			array('spipclear_get_config_noizetier',$config_defaut),
		);
				
		cextras_api_upgrade(spipclear_declarer_champs_extras(), $maj['create']);

		include_spip('base/upgrade');
		maj_plugin($nom_meta_base_version, $version_cible, $maj);
}

/**
 * Fonction de desinstallation
 *
 * @param float $nom_meta_base_version
 */
function spipclear_vider_tables($nom_meta_base_version) {
	$champs = spipclear_declarer_champs_extras();
	// C'est le plugin Champs Extras qui supprime le meta
	cextras_api_vider_tables($champs);
	effacer_meta($nom_meta_base_version);
	// TODO : "desimporter" la config du noizetier
}


?>