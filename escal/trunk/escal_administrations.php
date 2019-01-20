<?php

/**
 * Plugin Escal
 * Licence GNU/GPL
 */

if (!defined('_ECRIRE_INC_VERSION')) return;

/**
 * Fonction d'installation du plugin et de mise a jour.
 * Vous pouvez :
 * - creer la structure SQL,
 * - inserer du pre-contenu,
 * - installer des valeurs de configuration,
 * - mettre a jour la structure SQL
 *  Merci a Arnaud Berard pour son aide precieuse
**/
function escal_upgrade($nom_meta_base_version, $version_cible) {
    $maj = array();
    include_spip('escal_fonctions');
    include_spip('inc/config');
    include_spip('action/editer_objet');

    $maj['create'] = array(
        array('install_groupe_mots'),
        array('install_contenus'),
        array('escal_configuration'),
        array('ecrire_config', 'escal', array())
    );

    $maj['1.0.13'] =array(
        array('update_groupe_mots')
    );

    include_spip('base/upgrade');
    maj_plugin($nom_meta_base_version, $version_cible, $maj);
}


/**
 * Fonction de desinstallation du plugin.
 * - nettoyer toutes les donnees ajoutees par le plugin et son utilisation
 * - supprimer les tables et les champs crees par le plugin.
**/
function escal_vider_tables($nom_meta_base_version) {
    include_spip('escal_fonctions');

    uninstal_escal();

    effacer_config('escal');
    effacer_config($nom_meta_base_version);
}



?>