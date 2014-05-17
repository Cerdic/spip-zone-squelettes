<?php
function formulaires_raz_cfg_charger_dist() {

	$options = '';

	$pages_cfg = lister_pages_configuration();

	foreach ($pages_cfg as $_config) {
		$item = "sarkaspip_{$_config}";
		$options .= '<option value="' . $_config . '">' . _T("sarkaspip_config:$item") . '</option>';
	}

	$valeurs = array('_configurations' => $options);

	return $valeurs;
}


function formulaires_raz_cfg_traiter_dist() {
	$retour=array();
	
	$mode = _request('config_a_raz');
	$configs = ($mode !== '--') ? array($mode) : lister_pages_configuration();

	include_spip('inc/config');
	foreach($configs as $_config) {
		effacer_config("sarkaspip_$_config");
	}

	if ($mode !== '--')
		$retour['message_ok'] = _T('sarkaspip_config:cfg_msg_configuration_raz_ok', array('page' =>  _T("sarkaspip_config:sarkaspip_$mode")));
	else
		$retour['message_ok'] = _T('sarkaspip_config:cfg_msg_configurations_raz_ok');
	return $retour;
}

?>