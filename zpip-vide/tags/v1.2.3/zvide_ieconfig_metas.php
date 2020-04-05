<?php
if (!defined("_ECRIRE_INC_VERSION")) return;

function zvide_ieconfig_metas($table){
	$table['zvide']['titre'] = _T('zvide:zvide');
	$table['zvide']['icone'] = 'img/zvide-24.png';
	$table['zvide']['metas_serialize'] = 'zvide';
	return $table;
}

?>