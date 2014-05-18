<?php
/**
 * Ce fichier contient les fonctions de création, de mise à jour et de suppression
 * du schéma de données propres au plugin (uniquement de la configuration).
 *
 * @package SPIP\SARKASPIP\CONFIGURATION
 */

if (!defined("_ECRIRE_INC_VERSION")) return;


/**
 * Installation du schéma de données propre au plugin et gestion des migrations suivant
 * les évolutions du schéma.
 *
 * Le schéma comprend uniquement des variables de configuration.
 *
 * @api
 *
 * @param string $nom_meta_base_version
 * 		Nom de la meta dans laquelle sera rangée la version du schéma
 * @param string $version_cible
 * 		Version du schéma de données en fin d'upgrade
 *
 * @return void
 */
function sarkaspip_upgrade($nom_meta_base_version, $version_cible){

	$maj = array();

	// Configuration :
	// - à la première activation du plugin
	// - ou à la mise à jour à partir d'une version sans schéma
	$maj['create'] = array(
		array('creer_schema_sarkaspip')
	);

	include_spip('base/upgrade');
	maj_plugin($nom_meta_base_version, $version_cible, $maj);
	effacer_meta($nom_meta_base_version);
}


/**
 * Suppression de l'ensemble du schéma de données propre au plugin, c'est-à-dire
 * de ses variables de configuration.
 *
 * @api
 *
 * @param string $nom_meta_base_version
 * 		Nom de la meta dans laquelle est rangée la version du schéma et qui sera supprimée.
 *
 * @return void
 */
function sarkaspip_vider_tables($nom_meta_base_version) {

	// on efface les metas de configuration du plugin
	$pages = lister_pages_configuration();
	foreach ($pages as $_page) {
		effacer_meta("sarkaspip_${_meta}");
	}

	// on efface la meta du schéma du plugin
	effacer_meta($nom_meta_base_version);
}


/**
 * Création du schéma 1 du squelette Sarka-SPIP.
 *
 * Le schéma est créé soit uniquement à partir des valeurs par défaut dans le cas d'une
 * nouvelle installation, soit à partir des variables de configuration déjà existantes.
 *
 * @return void
 */
function creer_schema_sarkaspip() {
	include_spip('base/sarkaspip_declarations');

	$pages = lister_pages_configuration();
	foreach ($pages as $_page) {
		// définir la meta de configuration
		$meta = "sarkaspip_${_page}";

		if (function_exists($configurer = "sarkaspip_declarer_config_${_page}") {
			// acquérir les valeurs par défaut de la meta considérée
			$defaut = $configurer();

			// compiler les valeurs par défaut et les valeurs configurées si elles existent
			creer_schema($meta, $defaut);
		}
	}
}


/**
 * Création du schéma d'une meta donnée en utilisant les valeurs par défaut et/ou la configuration
 * existante en base de données.
 *
 * @param string	$meta
 * 		Nom de la meta accueillant la configuration d'une page.
 * @param array		$defaut
 * 		Tableau des variables et de leur valeur par défaut.
 *
 * @return void
 */
function creer_schema($meta, $defaut) {
	include_spip('inc/config');
	$config = array();

	// Lecture de la meta en base de données si elle existe
	$config_existante = lire_config($meta, array());

	if (!$config_existante)
		// Aucune config existante (site neuf par ex.), on insère les valeurs par défaut
		$config = $defaut;
	else {
		// Compilation de la config existante et de celle par défaut afin de nettoyer des variables obsolètes
		foreach ($defaut as $_variable => $_defaut) {
			$config[$_variable] = isset($config_existante[$_variable] ? $config_existante[$_variable] : $_defaut;
		}
	}

	// Ecriture de la configuration compilée
	ecrire_config($meta, $config);
}

?>
