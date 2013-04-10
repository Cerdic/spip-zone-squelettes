<?php
/**
 * Plugin Mediaspip Core
 * 
 * © 2010-2011 kent1 (kent1@arscenic.info)
 * Distribué sous licence GNU/GPL v3
 * 
 * Action de cron
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * Fonction appelée par le génie de SPIP à intervalle régulier
 * Par défaut une fois par jour
 *
 * Vérifie qu'il n'y a pas de documents originaux qui ont été perdus
 * 
 * @return
 * @param object $time
 */
function genie_mediaspip_maintenance($time){
	$verifier_originaux = charger_fonction('mediaspip_verifier_originaux','inc');
	$verifier_originaux();
	
	include_spip('inc/plugin');

	if (actualise_plugins_actifs()==-1){
		include_spip('inc/headers');
		redirige_par_entete(str_replace('&amp;','&',self()));
	}
	if ($erreur_activation = isset($GLOBALS['meta']['plugin_erreur_activation'])){
		$erreur_activation = $GLOBALS['meta']['plugin_erreur_activation'];
		// l'effacement reel de la meta se fera au moment de l'affichage
		// mais on la vide pour ne pas l'afficher dans le bandeau haut
		unset($GLOBALS['meta']['plugin_erreur_activation']);
	}
	if ($erreur_activation){
		effacer_meta('plugin_erreur_activation');
	}
	installe_plugins();
	
	return 1;
}

?>