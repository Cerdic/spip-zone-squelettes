/**
 * Les fonctions javascript du plugin mediaspip_config
 *
 */

var mediaspip_config_load = function(){
	/**
	 * On vire certains champs de formulaires non désirés
	 * Ils doivent aussi être cachés via CSS 
	 * - Sur le formulaire de configuration des notifications
	 * - Sur le formulaire de configuration des crayons 
	 * - Sur le formulaire de configuration de mediabox
	 * - Sur le formulaire de configuration de multilang
	 * - Sur le formulaire de configuration de googleplus1
	 * - Sur le formulaire de configuration de socialtags
	 */
	jQuery(".formulaire_spip .fieldset_forums_prives,.formulaire_spip .fieldset_messagerie_interne,.formulaire_spip .fieldset_signature_petition,.formulaire_spip .fieldset_suivis_perso,.formulaire_spip .fieldset_crayons_prive,.formulaire_spip .editer_palette_ecrire,.formulaire_config_crayons h3.titrem,.fieldset_microblog_invite,.i3_table,.lien_memcache,.editer_piwik_prive,.formulaire_configurer_mediabox .editer_selecteur_galerie,.formulaire_configurer_mediabox .editer_transition,.formulaire_configurer_mediabox .editer_speed,.formulaire_configurer_mediabox .editer_slideshow_speed,.formulaire_configurer_multilang .editer_breve,.formulaire_configurer_multilang .editer_article,.formulaire_configurer_multilang .editer_motcle,.editer_multilang_public,.editer_multilang_crayons .explication,.formulaire_configurer_socialtags .editer_jsselector div.explication,.formulaire_configurer_googleplus1 .editer_jsselector div.explication,.formulaire_configurer_comments fieldset#comments-style,.formulaire_config_saveauto .explication_restauration,.formulaire_config_saveauto .editer_eviter,.formulaire_config_saveauto .editer_accepter,.item_picker .choix_rapide")
		.detach();
}

jQuery(document).ready(function(){
	mediaspip_config_load();
	onAjaxLoad(mediaspip_config_load);
});