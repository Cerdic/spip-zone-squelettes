<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

// On déclare ici la config d'import/export des eva-mentions legales
function evamentions_ieconfig_metas($table) {
	$table['evamentions']['titre'] = _T('evamentions:eva_mentions_titre');
	$table['evamentions']['icone'] = 'evamentions-16.png';
	$table['evamentions']['metas_serialize'] = 'eva_mentions';
	return $table;
}

?>