<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function formulaires_raz_cfg_charger_dist() {
	include_spip('inc/sarkaspip_configuration');

	$options = creer_select_configurations();
	$valeurs = array('_configurations' => $options);

	return $valeurs;
}


function formulaires_raz_cfg_traiter_dist() {
	include_spip('inc/sarkaspip_configuration');
	$retour=array();
	
	$page = _request('config_a_raz');
	$configs = ($page !== '--') ? array($page) : lister_pages_configuration();

	include_spip('inc/sarkaspip_configuration');
	creer_config($configs, 'effacement');

	if ($page !== '--')
		$retour['message_ok'] = _T('sarkaspip_config:cfg_msg_configuration_raz_ok', array('page' =>  _T("sarkaspip_config:sarkaspip_$page")));
	else
		$retour['message_ok'] = _T('sarkaspip_config:cfg_msg_configurations_raz_ok');
	return $retour;
}

?>