<?php
/**
 * Plugin MediaSPIP Init
 * © 2010-2012 kent1 (kent1@arscenic.info)
 * Distribué sous licence GNU/GPL v3
 * 
 * Fichier de description des pipelines utilisés par le plugin
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

function mediaspip_init_configurer_liste_metas($array){

	/**
	 * Pour certains il faudrait au préalable récupérer les infos sur le site maitre
	 * Via un plugin mutu_client?
	 * 'nom_site' => _T('info_mon_site_spip'),
	 * 'descriptif_site' => '',
	 * 'email_envoi' => '',
	 * 'email_webmaster' => '',
	 */
	$nouvel_array = array(
		'nom_site' => _T('mediaspip_core:titre_site_mediaspip'),
		'config_precise_groupes' => 'oui',
		'articles_mots' => 'oui',
		'articles_versions' => 'oui',
		'articles_surtitre' => 'oui',
		'articles_soustitre' => 'oui',
		'articles_descriptif' => 'oui',
		'articles_chapeau' => 'oui',
		'articles_ps' => 'oui',
		'articles_redac' => 'oui',
		'rubriques_descriptif' => 'oui',
		'post_dates' => 'oui',
		'creer_preview' => 'oui',
		'taille_preview' => 300,
		'articles_modif' => 'oui',
		'forums_urlref' => 'oui',
		'activer_sites' => 'oui',
		'proposer_sites' => 2,
		'forums_publics' => 'posteriori',
		'prevenir_auteurs' => ',pos,pri,abo,',
		'forum_prive' => 'non', # forum global dans l'espace prive
		'forum_prive_objets' => 'non', # forum sous chaque article de l'espace prive
		'forum_prive_admin' => 'non', # forum des administrateurs
		'messagerie_agenda' => 'non',
		'activer_statistiques' => 'oui',
		'activer_captures_referers' => 'oui',
		'documents_article' => 'oui',
		'syndication_integrale' => 'oui',
		'multi_articles' => 'oui',
		'gerer_trad' => 'oui',
		'type_urls' => 'arbo'
	);

	$array = array_merge($array, $nouvel_array);
	return $array;
}

function mediaspip_init_notifications_destinataires($flux){
	if($flux['args']['quoi'] == 'mediaspip_recuperation_compte'){
		$mail_auteur = sql_getfetsel('email','spip_auteurs','id_auteur='.intval($flux['args']['id']));
		$flux['data'][] = $mail_auteur;
	}
	return $flux;
}

function mediaspip_init_formulaire_traiter($flux){
	if($flux['args']['form'] == 'configurer_locuteur'){
		$ms_init_maj_langues = charger_fonction('ms_init_maj_langues','inc');
		$ms_init_maj_langues();
	}
	return $flux;
}
?>