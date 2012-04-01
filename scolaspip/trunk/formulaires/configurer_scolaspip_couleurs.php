<?php
/*
 * Plugin Scolaspip
 * (c) 2012 CRDP de l'academie de Versailles
 * Distribue sous licence GNU/GPL
 *
 */

if (!defined('_ECRIRE_INC_VERSION')) return;

include_spip('scolaspip_fonction');

function formulaires_configurer_scolaspip_couleurs_charger_dist(){
	$valeurs = scolaspip_couleurs_config(true);
	
	return $valeurs;
}

function formulaires_configurer_scolaspip_couleurs_traiter_dist(){
	$config = scolaspip_couleurs_config(true);

	include_spip('inc/meta');
	if (_request('reinit')){
		foreach ($config as $k=>$v){
			set_request($k);
		}
		effacer_meta('scolaspip_colorer');
	}
	else {
		foreach ($config as $k=>$v){
			if (!is_null(_request($k)))
				$config[$k] = _request($k);
		}
		ecrire_meta('scolaspip_colorer',serialize($config));
	}
	
	return array('message_ok'=>_T('config_info_enregistree'),'editable'=>true);
}

?>