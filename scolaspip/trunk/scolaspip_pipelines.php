<?php

if (!defined('_ECRIRE_INC_VERSION')) return;

function autoriser_scolaspip_menu_dist($faire, $type, $id, $qui, $opt) {
	return ($qui['statut'] == '0minirezo' AND !$qui['restreint']);
}
function autoriser_scolaspip_configurer_dist($faire, $type, $id, $qui, $opt) {
	return ($qui['statut'] == '0minirezo' AND !$qui['restreint']);
}

function scolaspip_ieconfig_metas($table){
	$table['scolaspip']['titre'] = _T('scolaspip:titre_ie_scolaspip_couleurs');
	$table['scolaspip']['icone'] = 'scolaspip-16.png';
	$table['scolaspip']['metas_serialize'] = 'scolaspip_colorer';
	return $table;
}

function scolaspip_compagnon_messages($flux) {

	$exec = $flux['args']['exec'];
	$pipeline = $flux['args']['pipeline'];
	$aides = &$flux['data'];

	switch ($pipeline) {
		case 'affiche_milieu':
			switch ($exec) {
				case 'configurer_scolaspip':
					$aides[] = array(
						'id' => 'scolaspip_info',
						'titre' => _T('scolaspip:c_scolaspip_info'),
						'texte' => _T('scolaspip:c_scolaspip_info_texte'),
						'statuts'=> array('0minirezo', 'webmestre')
					);
			}
			break;
	}
	return $flux;
}
