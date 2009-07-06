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
		
		
		
		if (version_compare($current_version,'0.3','<=')){
		      // paramètrage de collection
            ecrire_config('collection/afficher_hr','');
            ecrire_config('collection/proposer_recherche','on');
            ecrire_config('collection/menu',array('plan'));
            ecrire_config('collection/sommaire',array('articles'));
            ecrire_config('collection/pages',array('plan','pluri_criteres','contact'));
            ecrire_config('collection/pagination',3);
            
                //paramétrage de spip
            ecrire_meta('article_redac','oui');
            ecrire_meta('articles_mots','oui');
            ecrire_meta('config_precise_groupes','oui');
            
				}
        if (version_compare($current_version,'0.4','<=')){
				ecrire_meta('mots_cles_forums','non');
				ecrire_meta($nom_meta_base_version,'0.4');
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
