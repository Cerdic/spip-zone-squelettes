<?php
function cfg_sarkaspip_plugins_post_traiter($cfg){
	if ($cfg->val['config_boutonstexte']=='sarkaspip') {
		ecrire_config('boutonstexte/', array(	'txtOnly'=>_SARKASPIP_CONFIG_BOUTONSTEXTE_TXTONLY,
											'txtBackSpip'=>_SARKASPIP_CONFIG_BOUTONSTEXTE_TXTBACKSPIP,
											'txtSizeUp'=>_SARKASPIP_CONFIG_BOUTONSTEXTE_TXTSIZEUP,
											'txtSizeDown'=>_SARKASPIP_CONFIG_BOUTONSTEXTE_TXTSIZEDOWN,
											'selector'=>_SARKASPIP_CONFIG_BOUTONSTEXTE_SELECTOR,
                      'jsFile'=>_SARKASPIP_CONFIG_BOUTONSTEXTE_JSFILE,
                      'cssFile'=>_SARKASPIP_CONFIG_BOUTONSTEXTE_CSSFILE,
                      'imgPath'=>_SARKASPIP_CONFIG_BOUTONSTEXTE_IMGPATH));
	}
	else {
		effacer_config('boutonstexte/');
  }


	if ($cfg->val['config_nyroceros']=='sarkaspip') {
		ecrire_config('nyroceros/', array(	'traiter_toutes_images'=>_SARKASPIP_CONFIG_NYROCEROS_TOUT,
											'selecteur_image'=>_SARKASPIP_CONFIG_NYROCEROS_IMAGE,
											'selecteur_galerie'=>_SARKASPIP_CONFIG_NYROCEROS_GALERIE,
											'preload'=>_SARKASPIP_CONFIG_NYROCEROS_PRELOAD,
											'bgcolor'=>_SARKASPIP_CONFIG_NYROCEROS_BGFOND));
	}
	else {
		effacer_config('nyroceros/');
  }
}
?>
