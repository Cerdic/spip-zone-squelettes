<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

if (!isset($GLOBALS['meta']['puce_eva']) OR _request('var_mode')) {
	$GLOBALS['meta']['puce_eva'] = '';
	include_spip('base/eva_habillage_base');
	include_spip('base/abstract_sql');
	$test = sql_showtable('spip_eva_habillage_images', true);
	if ($test['field']){
		$test_puce = sql_select('nom_image', 'spip_eva_habillage_images', "type='puce_spip' AND nom_habillage='Defaut'");
		$tab_puce = sql_fetch($test_puce);
		$puce = $tab_puce['nom_image'];
		if ($puce){
			$GLOBALS['meta']['puce_eva'] = $puce;
		}
	}
	ecrire_meta('puce_eva',$GLOBALS['meta']['puce_eva']);
}
if ($GLOBALS['meta']['puce_eva']) {
	$GLOBALS['puce'] = "<img src='" . _DIR_IMG . "eva_habillage/" . $GLOBALS['meta']['puce_eva'] . "' alt='-' align='top' border='0'>";
}
?>
