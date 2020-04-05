<?php
function spipr_educ_noisettes_sommaire_initialisation() {
	$def_som = array(
		'sommaire_menu_navigation'=>array('sommaire','aside',1),
		'sommaire_recherche'=>array('sommaire','aside',2),
		'sommaire_mini_calendrier' => array ('sommaire','aside',3),
		'sommaire_dernieres_breves'=>array('sommaire','aside',3,'cfg'),
		'sommaire_bloc_logos'=>array('sommaire','aside',4,'cfg'),
		'sommaire_liens_partenaires'=>array('sommaire','aside',5,'cfg'),
		'sommaire_breadcrumb'=>array('sommaire','breadcrumb',1),
		'sommaire_carousel'=>array('sommaire','content',1,'cfg'),
		'sommaire_editorial'=>array('sommaire','content',2,'cfg'),
		'sommaire_derniers_articles'=>array('sommaire','content',3,'cfg'),
		'sommaire_inscription'=>array('sommaire','extra',1),
		'sommaire_forums'=>array('sommaire','extra',2,'cfg'),
		'sommaire_articles_syndiques'=>array('sommaire','extra',3,'cfg'),
		'sommaire_evenements' => array ('sommaire','extra',4,'cfg'),
		'sommaire_dyslexie' => array ('sommaire','extra',5,'cfg'),
		'sommaire_derniers_sites'=>array('sommaire','extra',6,'cfg'),
		'sommaire_footer'=>array('sommaire','footer',1),
		'sommaire_head'=>array('sommaire','head',1),
		'sommaire_spipr_dane_js'=>array('sommaire','head_js',1),
		'sommaire_header'=>array('sommaire','header',1),
		'sommaire_nav'=>array('sommaire','header',2),
		'sommaire_twitter' => array ('sommaire','off',1,'cfg'),
		'sommaire_article_hero'=>array('sommaire','off',1,'cfg'),
		'sommaire_nuage'=>array('sommaire','off',1,'cfg'),
		'sommaire_bloc_perso_1'=>array('sommaire','off',1,'cfg'),
		'sommaire_bloc_perso_2'=>array('sommaire','off',1,'cfg'),
		'sommaire_bloc_perso_3'=>array('sommaire','off',1,'cfg'),
		'sommaire_compteur'=>array('sommaire','off',1,'cfg'),
		'sommaire_acces_restreint'=>array('sommaire','off',1),
	);
	return $def_som;	
}
function spipr_educ_noisettes_article_initialisation() {
	$def_art = array(
		'article_menu_navigation'=>array('article','aside',1),
		'article_recherche'=>array('article','aside',2),
		'article_mini_calendrier' => array ('article','aside',3),
		'article_liens_partenaires'=>array('article','aside',4,'cfg'),
		'article_bloc_logos'=>array('article','aside',5,'cfg'),
		'article_breadcrumb'=>array('article','breadcrumb',1),
		'article_cartouche'=>array('article','content',1),
		'article_contenu'=>array('article','content',2),
		'article_portfolio'=>array('article','content',3),
		'article_petition'=>array('article','content',4),
		'article_forum'=>array('article','content',5),
		'article_evenements_article'=>array('article','content',6,'cfg'),
		'article_meme_rubrique'=>array('article','extra',1,'cfg'),
		'article_mots_cles'=>array('article','extra',2),
		'article_evenements' => array ('article','extra',3,'cfg'),
		'article_dyslexie' => array ('article','extra',4,'cfg'),
		'article_footer'=>array('article','footer',1),
		'article_head'=>array('article','head',1),
		'article_spipr_dane_js'=>array('article','head_js',1),
		'article_header'=>array('article','header',1),
		'article_nav'=>array('article','header',2),
		'article_bloc_perso_1'=>array('article','off',1,'cfg'),
		'article_bloc_perso_2'=>array('article','off',1,'cfg'),
		'article_bloc_perso_3'=>array('article','off',1,'cfg'),
		'article_compteur'=>array('article','off',1,'cfg'),
		'article_competences_crcn'=>array('article','off',1,'cfg'),
	);
	return $def_art;	
}
function spipr_educ_noisettes_rubrique_initialisation() {
	$def_rub = array(
		'rubrique_menu_navigation'=>array('rubrique','aside',1),
		'rubrique_recherche'=>array('rubrique','aside',2),
		'rubrique_mini_calendrier' => array ('rubrique','aside',3),
		'rubrique_liens_partenaires'=>array('rubrique','aside',4,'cfg'),
		'rubrique_bloc_logos'=>array('rubrique','aside',5,'cfg'),
		'rubrique_breadcrumb'=>array('rubrique','breadcrumb',1),
		'rubrique_titre'=>array('rubrique','content',1),
		'rubrique_texte'=>array('rubrique','content',2),
		'rubrique_articles'=>array('rubrique','content',3,'cfg'),
		'rubrique_plan'=>array('rubrique','content',4),
		'rubrique_portfolio'=>array('rubrique','content',5),
		'rubrique_breves'=>array('rubrique','content',6,'cfg'),
		'rubrique_sites'=>array('rubrique','content',7,'cfg'),
		'rubrique_proposer_site'=>array('rubrique','content',8),
		'rubrique_mots_cles'=>array('rubrique','extra',1),
		'rubrique_evenements' => array ('rubrique','extra',2,'cfg'),
		'rubrique_dyslexie' => array ('rubrique','extra',3,'cfg'),
		'rubrique_articles_syndiques' => array ('rubrique','extra',4,'cfg'),
		'rubrique_footer'=>array('rubrique','footer',1),
		'rubrique_head'=>array('rubrique','head',1),
		'rubrique_spipr_dane_js'=>array('rubrique','head_js',1),
		'rubrique_header'=>array('rubrique','header',1),
		'rubrique_nav'=>array('rubrique','header',2),
		'rubrique_bloc_perso_1'=>array('rubrique','off',1,'cfg'),
		'rubrique_bloc_perso_2'=>array('rubrique','off',1,'cfg'),
		'rubrique_bloc_perso_3'=>array('rubrique','off',1,'cfg'),
	);
	return $def_rub;	
}
function spipr_educ_noisettes_breve_initialisation() {
	$def_breve = array(
		'breve_menu_navigation'=>array('breve','aside',1),
		'breve_recherche'=>array('breve','aside',2),
		'breve_mini_calendrier' => array ('breve','aside',3),
		'breve_liens_partenaires'=>array('breve','aside',4,'cfg'),
		'breve_bloc_logos'=>array('breve','aside',5,'cfg'),
		'breve_breadcrumb'=>array('breve','breadcrumb',1),
		'breve_contenu'=>array('breve','content',1),
		'breve_forum'=>array('breve','content',2),
		'breve_meme_rubrique'=>array('breve','extra',1,'cfg'),
		'breve_evenements' => array ('breve','extra',2,'cfg'),
		'breve_dyslexie' => array ('breve','extra',3,'cfg'),
		'breve_footer'=>array('breve','footer',1),
		'breve_head'=>array('breve','head',1),
		'breve_spipr_dane_js'=>array('breve','head_js',1),
		'breve_header'=>array('breve','header',1),
		'breve_nav'=>array('breve','header',2),
		'breve_bloc_perso_1'=>array('breve','off',1,'cfg'),
		'breve_bloc_perso_2'=>array('breve','off',1,'cfg'),
		'breve_bloc_perso_3'=>array('breve','off',1,'cfg'),
	);
	return $def_breve;	
}
function spipr_educ_noisettes_site_initialisation() {
	$def_site = array(
		'site_menu_navigation'=>array('site','aside',1),
		'site_recherche'=>array('site','aside',2),
		'site_mini_calendrier' => array ('site','aside',3),
		'site_liens_partenaires'=>array('site','aside',4,'cfg'),
		'site_bloc_logos'=>array('site','aside',5,'cfg'),
		'site_breadcrumb'=>array('site','breadcrumb',1),
		'site_presentation'=>array('site','content',1),
		'site_articles_syndiques'=>array('site','content',2,'cfg'),
		'site_autres_sites'=>array('site','extra',1,'cfg'),
		'site_menu_mots_cles'=>array('site','extra',2),
		'site_evenements' => array ('site','extra',3,'cfg'),
		'site_dyslexie' => array ('site','extra',4,'cfg'),
		'site_footer'=>array('site','footer',1),
		'site_head'=>array('site','head',1),
		'site_spipr_dane_js'=>array('site','head_js',1),
		'site_header'=>array('site','header',1),
		'site_nav'=>array('site','header',2),
		'site_bloc_perso_1'=>array('site','off',1,'cfg'),
		'site_bloc_perso_2'=>array('site','off',1,'cfg'),
		'site_bloc_perso_3'=>array('site','off',1,'cfg'),
	);
	return $def_site;	
}
function spipr_educ_noisettes_auteur_initialisation() {
	$def_aut = array(
		'auteur_menu_navigation'=>array('auteur','aside',1),
		'auteur_recherche'=>array('auteur','aside',2),
		'auteur_mini_calendrier' => array ('auteur','aside',3),
		'auteur_liens_partenaires'=>array('auteur','aside',4,'cfg'),
		'auteur_bloc_logos'=>array('auteur','aside',5,'cfg'),
		'auteur_breadcrumb'=>array('auteur','breadcrumb',1),
		'auteur_presentation'=>array('auteur','content',1),
		'auteur_articles'=>array('auteur','content',2,'cfg'),
		'auteur_ecrire_auteur'=>array('auteur','content',3),
		'auteur_autres_auteurs'=>array('auteur','extra',1,'cfg'),
		'auteur_evenements' => array ('auteur','extra',2,'cfg'),
		'auteur_dyslexie' => array ('auteur','extra',3,'cfg'),
		'auteur_footer'=>array('auteur','footer',1),
		'auteur_head'=>array('auteur','head',1),
		'auteur_spipr_dane_js'=>array('auteur','head_js',1),
		'auteur_header'=>array('auteur','header',1),
		'auteur_nav'=>array('auteur','header',2),
		'auteur_bloc_perso_1'=>array('auteur','off',1,'cfg'),
		'auteur_bloc_perso_2'=>array('auteur','off',1,'cfg'),
		'auteur_bloc_perso_3'=>array('auteur','off',1,'cfg'),
	);
	return $def_aut;	
}
function spipr_educ_noisettes_autre_initialisation() {
	$def_autre = array(
		'autre_menu_navigation'=>array('autre','aside',1),
		'autre_recherche'=>array('autre','aside',2),
		'autre_mini_calendrier' => array ('autre','aside',3),
		'autre_liens_partenaires'=>array('autre','aside',4,'cfg'),
		'autre_bloc_logos'=>array('autre','aside',5,'cfg'),
		'autre_breadcrumb'=>array('autre','breadcrumb',1),
		'autre_inscription'=>array('autre','extra',1),
		'autre_evenements' => array ('autre','extra',2,'cfg'),
		'autre_dyslexie' => array ('autre','extra',3,'cfg'),
		'autre_footer'=>array('autre','footer',1),
		'autre_head'=>array('autre','head',1),
		'autre_spipr_dane_js'=>array('autre','head_js',1),
		'autre_header'=>array('autre','header',1),
		'autre_nav'=>array('autre','header',2),
		'autre_bloc_perso_1'=>array('autre','off',1,'cfg'),
		'autre_bloc_perso_2'=>array('autre','off',1,'cfg'),
		'autre_bloc_perso_3'=>array('autre','off',1,'cfg'),
	);
	return $def_autre;	
}
function spipr_educ_toutes_les_noisettes_initialisation() {
	$toutes_def = array(
		spipr_educ_noisettes_sommaire_initialisation(),
		spipr_educ_noisettes_article_initialisation(),
		spipr_educ_noisettes_rubrique_initialisation(),
		spipr_educ_noisettes_breve_initialisation(),
		spipr_educ_noisettes_site_initialisation(),
		spipr_educ_noisettes_auteur_initialisation(),
		spipr_educ_noisettes_autre_initialisation()
	);
	return $toutes_def;
}
function spipr_educ_definition_secteurs() {
	$def = array(
		'header' => "Entête",
		'breadcrumb' => "Fil d'ariane",
		'content' => "Colonne de contenus",
		'aside' => "Colonne secondaire",
		'extra' => "Colonne tertiaire",
		'footer' => "Pied de page",
		'head' => "Entêtes html",
		'head_js' => "Déclarations Javascript"
	);
	return $def;
}
?>