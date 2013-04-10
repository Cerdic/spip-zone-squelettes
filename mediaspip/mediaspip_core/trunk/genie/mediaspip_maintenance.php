<?php
/**
 * Plugin Mediaspip Core
 * 
 * Auteurs :
 * kent1 (http://www.kent1.info - kent1@arscenic.info)
 *
 * © 2010-2012 - Distribue sous licence GNU/GPL
 * 
 * Action de cron
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * Fonction appelée par le génie de SPIP à intervalle régulier
 * Par défaut une fois par jour
 *
 * Vérifie qu'il n'y a pas de documents originaux qui ont été perdus
 * Installe les mises à jour de plugins et rafraichi la liste des plugins
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
	include_spip('inc/plugin'); 
	$new = actualise_plugins_actifs();
	if ($new AND _request('actualise')<2) {
		include_spip('inc/headers');
		$url = parametre_url(self(),'actualise',_request('actualise')+1,'&');
		redirige_par_entete($url);
	}
	
	$erreur_activation = plugin_donne_erreurs();
	
	plugin_installes_meta();
	
	return 1;
}

?>