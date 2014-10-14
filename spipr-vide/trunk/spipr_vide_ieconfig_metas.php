<?php
if (!defined("_ECRIRE_INC_VERSION")) return;

function spipr_vide_ieconfig_metas($table){
	$table['spipr_vide']['titre'] = _T('spipr_vide:spipr_vide_titre');
	$table['spipr_vide']['icone'] = 'entete-16.png';
	$table['spipr_vide']['metas_serialize'] = 'spipr_vide';
	return $table;
}
?>