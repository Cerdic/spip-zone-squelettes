<?php
function cfg_sarkaspip_plugins_post_traiter($cfg){
	if ($cfg->val['config_boutonstexte']=='sarkaspip') {
		ecrire_config('boutonstexte/', array(	'selector'=>_SARKASPIP_CONFIG_BOUTONSTEXTE_SELECTOR));
	}
	else
		effacer_config('boutonstexte/');

	if ($cfg->val['config_fancybox']=='sarkaspip') {
		ecrire_config('fancybox/', array(	'selecteur_commun'=>_SARKASPIP_CONFIG_FANCYBOX_IMAGE,
											'selecteur_galerie'=>_SARKASPIP_CONFIG_FANCYBOX_GALERIE));
	}
	else
		effacer_config('fancybox/');

	if ($cfg->val['config_nyroceros']=='sarkaspip') {
		ecrire_config('nyroceros/', array(	'traiter_toutes_images'=>_SARKASPIP_CONFIG_NYROCEROS_TOUT,
											'selecteur_commun'=>_SARKASPIP_CONFIG_NYROCEROS_IMAGE,
											'selecteur_galerie'=>_SARKASPIP_CONFIG_NYROCEROS_GALERIE,
											'installer_diapo_auto'=>_SARKASPIP_CONFIG_NYROCEROS_DIAPORAMA));
	}
	else
		effacer_config('nyroceros/');

	if ($cfg->val['config_socialtags']=='sarkaspip') {
		ecrire_config('socialtags/', array(	'jsselector'=>_SARKASPIP_CONFIG_SOCIALTAGS_SELECTOR,
											'tags' => explode(':', _SARKASPIP_CONFIG_SOCIALTAGS_TAGS)));
	}
	else
		effacer_config('socialtags/');
}
?>