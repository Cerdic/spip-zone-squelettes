<?php
function cfg_sarkaspip_plugins_post_traiter($cfg){
	if ($cfg->val['config_nyroceros']=='sarkaspip') {
		ecrire_config('nyroceros/', array(	'traiter_toutes_images'=>_SARKASPIP_CONFIG_NYROCEROS_TOUT,
											'selecteur_image'=>_SARKASPIP_CONFIG_NYROCEROS_IMAGE,
											'selecteur_galerie'=>_SARKASPIP_CONFIG_NYROCEROS_GALERIE,
											'preload'=>_SARKASPIP_CONFIG_NYROCEROS_PRELOAD,
											'bgcolor'=>_SARKASPIP_CONFIG_NYROCEROS_BGFOND));
	}
	else 
		effacer_config('nyroceros/');
}
?>
