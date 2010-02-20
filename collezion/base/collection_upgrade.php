<?php
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
        if (version_compare($current_version,'0.5','<=')){
				ecrire_config('collezionth/couleur_titre',lire_config('collection/couleur_titre'));
				ecrire_config('collezionth/couleur_filets',lire_config('collection/couleur_filets'));
				ecrire_config('collezionth/couleur_fond_sepia',lire_config('collection/couleur_fond_sepia'));
				ecrire_config('collezionth/colorer_fond_texte',lire_config('collection/colorer_fond_texte'));
				ecrire_config('collezionth/couleur_liens_nav',lire_config('collection/couleur_liens_nav'));
				ecrire_config('collezionth/couleur_liens_spip_in',lire_config('collection/couleur_liens_spip_in'));
				ecrire_config('collezionth/couleur_liens_spip_out',lire_config('collection/couleur_spip_out'));
				ecrire_config('collezionth/couleur_liens_spip_glossaire',lire_config('collection/couleur_liens_spip_glossaire'));
				
				effacer_config('collection/couleur_titre');
				effacer_config('collection/couleur_filets');
				effacer_config('collection/couleur_fond_sepia');
				effacer_config('collection/colorer_fond_texte');
				effacer_config('collection/couleur_liens_nav');
				effacer_config('collection/couleur_liens_spip_in');
				effacer_config('collection/couleur_spip_out');
				effacer_config('collection/couleur_liens_spip_glossaire');
				
				ecrire_meta($nom_meta_base_version,'0.5');
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
