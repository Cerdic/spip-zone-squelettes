<?php
/*
* Configuration de Noizetier pour SoyezCreateurs
* Realisation : RealET : real3t@gmail.com
*/

if (!defined('_ECRIRE_INC_VERSION')) return;

function sc_noisettespardefaut() {
	if (!defined('_DIR_PLUGIN_NOIZETIER')) {
		return;
	}

	include_spip('inc/ncore_noisette');
	include_spip('ncore/noizetier');
	include_spip('inc/noizetier_conteneur');
	
	$conteneur = array();

	//Liste tous les noisettes de tous les conteneurs existant
	$liste_noisettes = noizetier_noisette_lister('noizetier', $conteneur, '', $cle = 'rang_noisette');
	if (!isset($liste_noisettes['contenu/corps_sommaire_modecognac'])) {//S'il n'y a pas de noisettes dans contenu/corps
		//Liste des noisettes à inserer
		$noisettes = array('sommaire_modeportailcognac_zoomsur', 'sommaire_modeportailcognac_cycloshow', 'sommaire_modeportailcognac_sc_edito', 'sommaire_modeportailcognac_quoideneuf', 'sommaire_modeportailcognac_bandeau', 'sommaire_modeportailcognac_dessousBreves', 'sommaire_modeportailcognac_goodies');
		$conteneur = conteneur_noizetier_decomposer('contenu/corps_sommaire_modecognac');

		//Insersion des noisettes
		foreach ($noisettes as $noisette) {
			$id_noisette = noisette_ajouter('noizetier', $noisette, $conteneur);
		}
		
		sc_noizetier_vidercache();
	}
}

function sc_noizetier_vidercache() {
	// Supprime la meta du plugin Cache Factory de façon à mettre à jour la configuration des
	// plugins utilisateur si besoin.
	// Recharge la configuration des plugins utilisateur :
	// -- on lit la meta pour obtenir la liste des plugins
	include_spip('inc/ezcache_cache');
	$configuration = configuration_cache_lire();
	if ($configuration) {
		$plugins = array_keys($configuration);
		// -- on supprime la meta
		configuration_cache_effacer();
		// -- on reconfigure chaque plugin
		include_spip('ezcache/ezcache');
		foreach ($plugins as $_plugin) {
			if (defined('_DIR_PLUGIN_' . strtoupper($_plugin))) {
				cache_cache_configurer($_plugin);
			}
		}
	}
	
	// On recharge les pages du noiZetier dont la liste ou l'activité a pu changer. Inutile de forcer un
	// rechargement complet.
	include_spip('inc/noizetier_page');
	page_noizetier_charger();
	// On recharge les types de noisettes dont la liste ou l'activité a pu changer. Inutile de forcer un
	// rechargement complet.
	include_spip('inc/ncore_type_noisette');
	type_noisette_charger('noizetier');

	// Suppression des caches N-Core nécessaires à la compilation des noisettes
	type_noisette_decacher('noizetier');
}