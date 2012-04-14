<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

// On déclare ici la config du core
function scolaspip_ieconfig_metas($table){
	$table['scolaspip']['titre'] = _T('scolaspip:titre_ie_scolaspip_couleurs');
	$table['scolaspip']['icone'] = 'images/scolaspip-16.png';
	$table['scolaspip']['metas_serialize'] = 'scolaspip_colorer';
	return $table;
}

?>