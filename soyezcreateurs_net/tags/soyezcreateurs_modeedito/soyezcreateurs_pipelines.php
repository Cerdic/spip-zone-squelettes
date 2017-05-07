<?php
if (!defined('_ECRIRE_INC_VERSION')) return; 

function soyezcreateurs_declarer_tables_interfaces($interface){
	// Documentation et inspiration :
	// - https://programmer.spip.net/declarer_tables_interfaces,379
	// - http://permalink.gmane.org/gmane.comp.web.spip.devel/57655
	// version complexe (ne pas ecraser la definition existante)
	if (isset($interface['table_des_traitements']['TITRE'][0])) {
		$s = $interface['table_des_traitements']['TITRE'][0];
	} else {
		$s = '%s';
	}
	$interface['table_des_traitements']['TITRE'][0] = str_replace('%s', 'supprimer_numero(%s)', $s);
	
	return $interface; 
}

?>