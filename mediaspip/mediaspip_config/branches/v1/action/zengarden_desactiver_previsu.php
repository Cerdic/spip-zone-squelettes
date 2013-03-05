<?php
/**
 * Plugin Zen-Garden pour Spip 2.0
 * Licence GPL (c) 2006-2008 Cedric Morin
 *
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

function action_zengarden_desactiver_previsu_dist(){
	$securiser_action = charger_fonction('securiser_action','inc');
	$arg = $securiser_action();

	if (isset($_COOKIE['spip_zengarden_theme'])){
		include_spip('inc/cookie');
		spip_setcookie('spip_zengarden_theme',$_COOKIE['spip_zengarden_theme']='',-1);
		include_spip('inc/invalideur');
		suivre_invalideur('1');
	}
}

?>
