<?php
/**
 * Squelette SarkaSPIP v3
 * (c) 2005-2012 Licence GPL 3
 */

if (!defined("_ECRIRE_INC_VERSION")) return;


/**
 * Liste des pages de configuration sous la forme d'un tableau.
 *
 * @return array
 */
function lister_pages_configuration() {
	$pages = array();

	$sections = explode('|',_SARKASPIP_PAGES_CONFIG);
	foreach ($sections as $_section){
		$_section = explode("!",$_section);
		$_section = end($_section);
		$pages = array_merge($pages, array_map('trim',explode(":",$_section)));
	}

	return $pages;
}


/**
 * Création du select (uniquement les balises option) de la liste des pages de configuration du squelette.
 *
 * @return string
 */
function creer_select_configurations() {
	$options = '';

	$pages = lister_pages_configuration();
	foreach ($pages as $_page) {
		$item = "sarkaspip_{$_page}";
		$options .= '<option value="' . $_page . '">' . _T("sarkaspip_config:$item") . '</option>';
	}

	return $options;
}


/**
 * Création de la configuration d'une liste de pages.
 *
 * Le schéma est créé soit uniquement à partir des valeurs par défaut dans le cas d'une
 * nouvelle installation, soit à partir des variables de configuration déjà existantes.
 *
 * @param array		$pages
 * 		Tableau des pages à configurer
 * @param string	$mode
 * 		Mode de traitement de la configuration:
 *
 * 		- 'configuration' : indique un merge entre la configuration existante et celle par défaut;
 * 		- 'effacement'    : indique d'écraser la configuration avec celle par défaut
 * 		- 'restauration'  : indique de restaurer une configuration avec merge de celle par défaut si absente
 * @param array		$sauvegarde
 * 		Le tableau des sauvegardes à restaurer ou vide si le mode ne correspond pas.
 *
 * @return boolean
 */
function creer_config($pages, $mode='configuration', $sauvegardes=array()) {
	include_spip('base/sarkaspip_declarations');

	$ok = true;
	foreach ($pages as $_page) {
		// définir la meta de configuration
		$meta = "sarkaspip_${_page}";

		if (function_exists($configurer = "sarkaspip_declarer_config_${_page}")) {
			// acquérir les valeurs par défaut de la meta considérée
			$meta_defaut = $configurer();

			// compiler les valeurs par défaut et les valeurs configurées ou à restaurer si elles existent
			$meta_sauvegarde = (isset($sauvegardes[$_page]) ? $sauvegardes[$_page] : array());
			merger_config($meta, $meta_defaut, $mode, $meta_sauvegarde);
		}
		else
			$ok = false;
	}

	return $ok;
}


/**
 * Mise à jour d'une meta donnée en utilisant les valeurs par défaut et/ou la configuration
 * existante en base de données ou une sauvegarde.
 *
 * @param string	$meta
 * 		Nom de la meta accueillant la configuration d'une page.
 * @param array		$meta_defaut
 * 		Tableau des variables et de leur valeur par défaut pour la meta considérée.
 * @param string	$mode
 * 		Mode de traitement de la configuration:
 *
 * 		- 'configuration' : indique un merge entre la configuration existante et celle par défaut;
 * 		- 'effacement'    : indique d'écraser la configuration avec celle par défaut
 * 		- 'restauration'  : indique de restaurer une configuration avec merge de celle par défaut si absente
 * @param array		$meta_sauvegarde
 * 		Tableau des variables et de leur valeurs à restaurer pour la meta considérée.
 *
 * @return void
 */
function merger_config($meta, $meta_defaut, $mode, $meta_sauvegarde) {
	include_spip('inc/config');
	$config = array();

	// Lecture de la meta en base de données si elle existe
	$config_bdd = lire_config($meta, array());

	if (($mode == 'effacement')
	OR (($mode == 'configuration') AND !$config_bdd)) {
		// on insère les valeurs par défaut
		$config = $meta_defaut;
	}
	else if ((($mode == 'configuration') AND $config_bdd)
	OR (($mode == 'restauration') AND $meta_sauvegarde)) {
		$config_base = ($mode == 'configuration') ? $config_bdd : $meta_sauvegarde;
		// Compilation de la config existante et de celle par défaut afin de nettoyer des variables obsolètes
		foreach ($meta_defaut as $_variable => $_defaut) {
			$config[$_variable] = (isset($config_base[$_variable]) ? $config_base[$_variable] : $_defaut);
		}
	}

	// Ecriture de la configuration compilée sauf si elle est vide (cas d'une restauration d'une sauvegarde vide)
	if ($config)
		ecrire_config($meta, $config);
}

?>
