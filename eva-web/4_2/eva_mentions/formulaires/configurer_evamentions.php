<?php
/*
 * Plugin Eva-mentions (Gestion des mentions legales)
 * Distribue sous licence GNU/GPL
 *
 */

if (!defined('_ECRIRE_INC_VERSION')) return;

function evamentions_config($public=null) {
	$config = @unserialize($GLOBALS['meta']['eva_mentions']);
	if (!is_array($config))
	$config = array();
	$config = array_merge(array(
		'structure' => _T('evamentions:a_preciser'),
		'directeur' => _T('evamentions:a_preciser'),
		'responsable' => _T('evamentions:a_preciser'),
		'hebergeur' => _T('evamentions:a_preciser'),
		'adresse' => _T('evamentions:a_preciser'),
		'webmaster' => _T('evamentions:a_preciser'),
		'fonction' => _T('evamentions:a_preciser'),
		'idwebmaster'=> '1',
	), $config);

	return $config;	
}

function formulaires_configurer_evamentions_charger_dist() {
	$valeurs = evamentions_config(true);

	return $valeurs;
}

function formulaires_configurer_evamentions_traiter_dist() {
	$config = evamentions_config(true);
	include_spip('inc/meta');

	foreach ($config as $k=>$v) {
		if (!is_null(_request($k))) $config[$k] = _request($k);
	}
	ecrire_meta('eva_mentions',serialize($config));

	return array('message_ok'=>_T('config_info_enregistree'),'editable'=>true);
}

?>