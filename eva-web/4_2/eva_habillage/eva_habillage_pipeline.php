<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function eva_habillage_declarer_tables_interfaces($interface){
	$interface['table_des_tables']['eva_habillage'] = 'eva_habillage';
	$interface['table_des_tables']['eva_habillage_themes'] = 'eva_habillage_themes';
	$interface['table_des_tables']['eva_habillage_images'] = 'eva_habillage_images';
	return $interface;
}

?>