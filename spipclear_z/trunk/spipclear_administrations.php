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

		$maj['create'] = array(
			array('spipclear_install_noizetier')
		);
				
		cextras_api_upgrade(spipclear_declarer_champs_extras(), $maj['create']);

		include_spip('base/upgrade');
		maj_plugin($nom_meta_base_version, $version_cible, $maj);
}

function spipclear_install_noizetier(){
	spip_log('un passage','test');
	include_spip('noizetier_fonctions');
	$config_defaut = _DIR_PLUGIN_SPIPCLEAR . 'config_noizetier/spipclear.yaml';
	$yaml = spipclear_get_config_noizetier($config_defaut);
	if(!noizetier_importer_configuration('remplacer', 'non', $yaml)) {
		return _T('spipclear:msg_erreur_v00')."<br/>";
	} else {
		return true;
	}
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