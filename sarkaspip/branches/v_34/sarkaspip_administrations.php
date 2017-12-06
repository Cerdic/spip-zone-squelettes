<?php
/**
 * Ce fichier contient les fonctions de création, de mise à jour et de suppression
 * du schéma de données propres au plugin (uniquement de la configuration).
 *
 * @package SPIP\SARKASPIP\CONFIGURATION
 */
if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

/**
 * Installation du schéma de données propre au plugin et gestion des migrations suivant
 * les évolutions du schéma.
 *
 * Le schéma comprend uniquement des variables de configuration.
 *
 * @api
 *
 * @param string $nom_meta_base_version
 *                                      Nom de la meta dans laquelle sera rangée la version du schéma
 * @param string $version_cible
 *                                      Version du schéma de données en fin d'upgrade
 */
function sarkaspip_upgrade($nom_meta_base_version, $version_cible) {
	$maj = array();

	// Configuration :
	// - à la première activation du plugin
	// - ou à la mise à jour à partir d'une version sans schéma
	$maj['create'] = array(
		array('creer_config_sarkaspip'),
	);

	include_spip('base/upgrade');
	maj_plugin($nom_meta_base_version, $version_cible, $maj);
}

/**
 * Suppression de l'ensemble du schéma de données propre au plugin, c'est-à-dire
 * de ses variables de configuration.
 *
 * @api
 *
 * @param string $nom_meta_base_version
 *                                      Nom de la meta dans laquelle est rangée la version du schéma et qui sera supprimée.
 */
function sarkaspip_vider_tables($nom_meta_base_version) {
	include_spip('inc/sarkaspip_configuration');

	// on efface les metas de configuration du plugin
	$pages = lister_pages_configuration();
	foreach ($pages as $_page) {
		effacer_meta("sarkaspip_${_page}");
	}

	// on efface la meta du schéma du plugin
	effacer_meta($nom_meta_base_version);
}

/**
 * Création du schéma de version 1 du squelette Sarka-SPIP.
 *
 * Le schéma est créé soit uniquement à partir des valeurs par défaut dans le cas d'une
 * nouvelle installation, soit à partir des variables de configuration déjà existantes.
 */
function creer_config_sarkaspip() {
	include_spip('inc/sarkaspip_configuration');

	$pages = lister_pages_configuration();
	creer_config($pages, 'configuration');
}
