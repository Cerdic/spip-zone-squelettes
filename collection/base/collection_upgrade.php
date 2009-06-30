<?php
/**
 * Plugin Acces Restreint 3.0 pour Spip 2.0
 * Licence GPL (c) 2006-2008 Cedric Morin
 *
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/meta');
/**
 * Fonction d'installation, mise a jour de la base
 *
 * @param unknown_type $nom_meta_base_version
 * @param unknown_type $version_cible
 */
function collection_upgrade($nom_meta_base_version,$version_cible){
	$current_version = 0.0;

	if (   (!isset($GLOBALS['meta'][$nom_meta_base_version]) )
			|| (($current_version = $GLOBALS['meta'][$nom_meta_base_version])!=$version_cible)){
		
		if (version_compare($current_version,'0.1','<=')){
            ecrire_config('collection/menu',array('plan'));
            ecrire_config('collection/sommaire',array('alea9'));
			ecrire_meta($nom_meta_base_version,$current_version="0.1");
				}
		ecrire_metas();
		}
    
}
/**
 * Fonction de desinstallation
 *
 * @param unknown_type $nom_meta_base_version
 */
function collection_vider_tables($nom_meta_base_version) {
    effacer_config('collection/menu');
    effacer_config('collection/sommaire');
	effacer_meta($nom_meta_base_version);
}

?>
