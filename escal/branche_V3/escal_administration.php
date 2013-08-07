<?php

/**
 * Plugin Escal
 * Licence GNU/GPL
 */

if (!defined('_ECRIRE_INC_VERSION')) return;

/**
 * Fonction d'installation du plugin et de mise à jour.
 * Vous pouvez :
 * - créer la structure SQL,
 * - insérer du pre-contenu,
 * - installer des valeurs de configuration,
 * - mettre à jour la structure SQL 
 *  Merci à Arnaud Bérard pour son aide précieuse 
**/
function escal_upgrade($nom_meta_base_version, $version_cible) {
    $maj = array();
    include_spip('escal_fonctions');
    include_spip('inc/config');
    include_spip('action/editer_objet');
    
    $maj['create'] = array(
        array('install_groupe_mots'),
        array('escal_configuration'),
        array('ecrire_config', array('escal', array()))
    );
    
    include_spip('base/upgrade');
    maj_plugin($nom_meta_base_version, $version_cible, $maj);
    ecrire_meta($nom_meta_base_version,$version_cible);
    ecrire_meta();
}


/**
 * Fonction de désinstallation du plugin.
 * - nettoyer toutes les données ajoutées par le plugin et son utilisation
 * - supprimer les tables et les champs créés par le plugin. 
**/
function escal_vider_tables($nom_meta_base_version) {

    include_spip('inc/config');
    $affichage = lire_config('escal/mots_techniques/affichage');
    
    sql_delete('spip_groupes_mots', sql_in("id_groupe", array($affichage)));
    sql_delete('spip_mots', sql_in("id_groupe", array($affichage)));
    
    effacer_meta('escal');
    effacer_meta($nom_meta_base_version);
    ecrire_meta();
}



?>