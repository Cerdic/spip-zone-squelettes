<?php
/*
 * Plugin Scolaspip
 * (c) 2012 CRDP de l'academie de Versailles
 * Distribue sous licence GNU/GPL
 *
 */

if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_configurer_scolaspip_accueil_charger_dist(){
	$valeurs = scolaspip_accueil_config(true);
	
	return $valeurs;
}

function formulaires_configurer_scolaspip_accueil_traiter_dist(){
	$config = scolaspip_accueil_config(true);

	include_spip('inc/meta');
	if (_request('reinit')){
		foreach ($config as $k=>$v){
			set_request($k);
		}
		effacer_meta('scolaspip_accueil');
	}
	else {
		foreach ($config as $k=>$v){
			if (!is_null(_request($k)))
				$config[$k] = _request($k);
		}
		ecrire_meta('scolaspip_accueil',serialize($config));
	}
	
	return array('message_ok'=>_T('config_info_enregistree'),'editable'=>true);
}

?>