<?php
/**
 * Ce fichier contient les fonctions permettant de déclarer les configurations par défaut des metas
 * du squelette.
 *
 *
 * @package SPIP\SARKASPIP\CONFIGURATION
 */

if (!defined("_ECRIRE_INC_VERSION")) return;


function sarkaspip_declarer_config_accueil() {
	$defaut = array(
		'rubrique_squelette' => 0,			// 0 : aucune rubrique, >0 : id de la rubrique
	);

	return $defaut;
}

function sarkaspip_declarer_config_sommaire() {
	$defaut = array(
		'album_1_colonne' => 0,				// 0 : deux colonnes, 1 : une colonne
		'article_edito' => 0,				// 0 : aucun article, >0 : id de l'article
		'avec_lire_suite' => 'non',			// non : pas de lien, oui : lien lire suite
		'intro_album' => 300,				//
		'intro_article' => 300,				//
		'logo_rubrique' => 'oui',			// oui : logo rubrique si pas de logo, non : pas de substitution
		'max_albums_recents' => 5,			//
		'max_articles_recents' => 5,		//
		'position_albums_recents' => 1,		// 1 : albums affichés dans le corps du sommaire, 0 : non affichés
		'position_articles_recents' => 1,	// 1 : articles affichés dans le corps du sommaire, 0 : non affichés
		'position_secteurs' => 0,			// 1 : secteurs affichés dans le corps du sommaire, 0 : non affichés
		'taille_logo' => 150,				// taille max du logo dans les deux dimensions
		'titre_edito' => 1,					// 1 : titre de l'article affiché dans l'édito, 0 : non affiché
	);

	return $defaut;
}

function sarkaspip_declarer_config_rubrique() {
	$defaut = array(
		'avec_descriptif' => 'non',			// oui : descriptif sous les docs joints, non : pas de descriptif
		'avec_filles' => 'non',				// oui : affichage des rubriques filles dans le corps de la page, non : pas d'affichage
		'avec_lire_suite' => 'non',			//
		'intro_article'=> 300,				//
		'mode_galerie' => 0,				// effet du portfolio. 0 : aucun effet, 1 : mediabox image par image, 2: mediabox diaporama
		'modele_pagination' => '',			// '' : modèle par défaut, autres valeurs : page, precedent_suivant, page_precedent_suivant
		'pas_pagination' => 5,				//
		'position_articles'=> 1,			// 1 : articles affichés dans le corps de la page, 0 : non affichés
		'position_pagination' => 3,			// 1: en haut, 2: en bas, 3: en haut et en bas
		'taille_logo_articles'=> 150,		//
		'taille_logo_rubrique' => 150,		//
	);

	return $defaut;
}

function sarkaspip_declarer_config_article() {
	$defaut = array(
		'auteur_commentaires' => 1,
		'avec_descriptif' => 'non',
		'avec_popularite' => 'oui',
		'avec_traduction' => 'non',
		'logo_rubrique' => 'oui',
		'mode_commentaires' => 2,
		'mode_galerie' => 0,
		'modele_pagination_commentaires' => '',
		'modele_pagination_signatures' => '',
		'pas_pagination_commentaires' => 20,
		'pas_pagination_signatures' => 20,
		'position_pagination_commentaires' => 2,
		'position_pagination_signatures' => 2,
		'sens_tri_commentaires' => 1,
		'taille_logo' => 150,
	);

	return $defaut;
}

function sarkaspip_declarer_config_auteur() {
	$defaut = array(
		'album_1_colonne' => 0,
		'avec_lire_suite' => 'non',
		'intro_article' => 300,
		'modele_pagination_albums' => '',
		'modele_pagination_articles' => '',
		'pas_pagination_albums' => 5,
		'pas_pagination_articles' => 5,
		'position_albums' => 1,
		'position_articles' => 1,
		'position_contact' => 1,
		'position_pagination_albums' => 3,
		'position_pagination_articles' => 3,
		'taille_logo_articles' => 150,
		'taille_logo_rubrique' => 150,
	);

	return $defaut;
}

function sarkaspip_declarer_config_breve() {
	$defaut = array(
		'modele_pagination_breve' => '',
		'pas_pagination_breve' => 10,
		'position_pagination_breve' => 3,
	);

	return $defaut;
}

function sarkaspip_declarer_config_site() {
	$defaut = array(
		'modele_pagination_site' => '',
		'nbj_syndication_1' => 30,
		'nbj_syndication_2' => 60,
		'pas_pagination_site' => 50,
		'position_pagination_site' => 3,
	);

	return $defaut;
}

function sarkaspip_declarer_config_forum() {
	$defaut = array(
		'modele_pagination_1' => '',
		'modele_pagination_2' =>'',
		'pas_pagination_1' => 20,
		'pas_pagination_2' => 30,
		'position_pagination_1' => 2,
		'position_pagination_2' => 2,
		'rubrique_forum' => 0,
		'sens_tri_reponses' => 0,
	);

	return $defaut;
}

function sarkaspip_declarer_config_plan() {
	$defaut = array(
		'position_pagination' => 1,
		'senstri_date' => 1,
	);

	return $defaut;
}

function sarkaspip_declarer_config_herbier() {
	$defaut = array(
		'descriptif' => '',
		'modele' => 'liste',
		'modele_pagination_1' => '',
		'modele_pagination_2' => '',
		'pas_pagination_1' => 5,
		'pas_pagination_2' => 10,
		'position_pagination_1' => 3,
		'position_pagination_2' => 1,
		'titre' => 'Sites favoris',
	);

	return $defaut;
}

function sarkaspip_declarer_config_recherche() {
	$defaut = array(
		'groupes_recherche' => array(),
		'modele_pagination_recherche_article' => '',
		'modele_pagination_recherche_breve' => '',
		'modele_pagination_recherche_commentaire' => '',
		'modele_pagination_recherche_mot' => '',
		'modele_pagination_recherche_rubrique' => '',
		'modele_pagination_recherche_site' => '',
		'pas_pagination_recherche_article' => 5,
		'pas_pagination_recherche_breve' => 5,
		'pas_pagination_recherche_commentaire' => 5,
		'pas_pagination_recherche_mot' => 5,
		'pas_pagination_recherche_rubrique' => 5,
		'pas_pagination_recherche_site' => 5,
		'position_pagination_recherche_article' => 3,
		'position_pagination_recherche_breve' => 3,
		'position_pagination_recherche_commentaire' => 3,
		'position_pagination_recherche_mot' => 3,
		'position_pagination_recherche_rubrique' => 3,
		'position_pagination_recherche_site' => 3,
	);

	return $defaut;
}

function sarkaspip_declarer_config_agenda() {
	$defaut = array(
		'affichage_hors_mois' => 'oui',
		'descriptif' => '',
		'format_pagination' => 'annee',
		'format_resume' => 'd-m H:i',
		'jour1' => 1,
		'max_mois_resume' => 6,
		'mois1' => 9,
		'rubrique_agenda' => 0,
		'sens_tri' => 'normal',
		'taille_resume' => 5,
		'titre' => 'Agenda',
		'type' => 1,
		'type_resume' => 'oui',
	);

	return $defaut;
}

function sarkaspip_declarer_config_galerie() {
	$defaut = array(
		'album_1_colonne' => 0,
		'descriptif' => '',
		'intro_album' => 300,
		'modele_pagination_1' => '',
		'pas_pagination_1' => 5,
		'position_pagination_1' => 3,
		'rubrique_galerie' => 0,
		'sens_tri_1' => 1,
		'titre' => 'Galerie',
	);

	return $defaut;
}

function sarkaspip_declarer_config_album() {
	$defaut = array(
		'afficher_exif' => 'non',
		'afficher_zoom' => 'oui',
		'auteur_commentaires' => 1,
		'avec_descriptif' => 'non',
		'avec_popularite' => 'oui',
		'logo_rubrique' => 'oui',
		'mode_commentaires' => 2,
		'mode_galerie' => 0,
		'modele_carrousel' => 1,
		'modele_pagination_carrousel' => '',
		'modele_pagination_commentaires' => '',
		'pas_pagination_carrousel' => 20,
		'pas_pagination_commentaires' => 20,
		'position_carrousel' => 1,
		'position_pagination_commentaires' => 2,
		'sens_tri_commentaires' => 1,
		'survol_carrousel' => 'non',
		'taille_carrousel' => 10,
		'taille_logo' => 150,
	);

	return $defaut;
}

function sarkaspip_declarer_config_formulaires() {
	$defaut = array(
		'auteur_contact' => 0,
		'avec_lire_suite' => 'non',
		'descriptif_contact' => '',
		'descriptif_dialogue' => '',			// le defaut est <:sarkaspip:dialogue_descriptif:>
		'descriptif_inscription' => '',
		'descriptif_lettre' => '',
		'descriptif_login1' => '',
		'descriptif_login2' => '',
		'descriptif_referencement' => '',
		'intro_article' => 300,
		'logo_rubrique_extrait' => 'oui',
		'plugin_contact' => 0,
		'position_commentaire' => 1,
		'position_extrait' => 1,
		'taille_logo_extrait' => 150,
		'titre_contact' => 'Contacter le webmestre',
		'titre_dialogue' => '',			// le defaut est <:sarkaspip:dialoguer_site:>
		'titre_inscription' => 'S\'inscrire sur le site',
		'titre_lettre' => '',			// le defaut est <:sarkaspip:inscrire_a_newsletter:>
		'titre_login1' => 'Se connecter comme membre du site',
		'titre_login2' => 'Accéder à l\'espace privé',
	);

	return $defaut;
}

function sarkaspip_declarer_config_modeles() {
	$defaut = array(
		'exclusif_doc' => 'oui',
		'exclusif_img' => 'oui',
		'max_vignette_doc' => 52,
		'mode_galerie_img' => 0,
	);

	return $defaut;
}

function sarkaspip_declarer_config_layout() {
	$defaut = array(
		'appliquer_padding' => 0,
		'largeur_padding' => 20,
		'largeur_site' => 700,
		'numero_layout' => 13,
	);

	return $defaut;
}

function sarkaspip_declarer_config_bandeau() {
	$defaut = array(
		'bas'=> 0,
		'bas_minheight' => 23,
		'chemin' => 1,
		'haut' => 1,
		'haut_minheight' => 50,
		'item_align' => 'left',
		'item_largeur' => 150,
		'logo_reduit' => 1,
		'menu_align' => 0,
		'menu_largeur' => 600,
		'slogan' => '',
		'taille_logo' => 150,
		'titre_site' => 1,
	);

	return $defaut;
}

function sarkaspip_declarer_config_menus() {
	$defaut = array(
		'lien_plan' => 0,
		'lien_texte_1' => '',
		'lien_texte_2' => '',
		'lien_texte_3' => '',
		'lien_texte_4' => '',
		'lien_texte_5' => '',
		'lien_texte_6' => '',
		'lien_texte_7' => '',
		'lien_texte_8' => '',
		'lien_texte_9' => '',
		'lien_url_1' => '',
		'lien_url_2' => '',
		'lien_url_3' => '',
		'lien_url_4' => '',
		'lien_url_5' => '',
		'lien_url_6' => '',
		'lien_url_7' => '',
		'lien_url_8' => '',
		'lien_url_9' =>  '',
		'modele_rubriques' => 1,
		'option_rubriques' => 0,
		'position_formulaires' => 1,
		'position_langues' => 4,
		'position_pages' => 1,
		'position_perso' => 0,
		'position_rubriques' => 1,
		'position_secteurs' => 0,
	);

	return $defaut;
}

function sarkaspip_declarer_config_pied() {
	$defaut = array(
		'ancre_haut_page' => 1,
		'bas_minheight' => 50,
		'bas_toppadding' => 10,
		'collectif_sarka' => 1,
		'copyright_site' => 1,
		'licence_site' => '',
		'licence_squelette' => 1,
		'lien_plan' => 1,
		'lien_squelette' => 1,
		'outils_perso' => '',
		'position_pied' => 1,
		'version_sarka' => 1,
		'version_spip' => 1,
	);

	return $defaut;
}

function sarkaspip_declarer_config_noisettes() {
	$defaut = array(
		'position_publications' => 0,
		'max_publications' => 5,
		'position_miniagenda' => 2,
		'position_commentaires' => 0,
		'max_commentaires' => 50,
		'intro_commentaire' => 100,
		'position_messages' => 0,
		'max_messages' => 50,
		'intro_message' => 100,
		'position_breves' => 2,
		'liste_breves' => 2,
		'max_breves' => 5,
		'intro_breve' => 100,
		'liste_sites' => 2,
		'max_sites' => 5,
		'max_syndic' => 5,
		'position_herbier' => 0,
		'liste_herbier' => 2,
		'max_herbier' => 5,
		'position_rechspip' => 3,
		'position_recherche' => 2,
		'moteur_externe' => 1,
		'position_stats_1' => 1,
		'position_stats_2' => 0,
		'composition_stats_2' => 3,
		'max_articles_top' => 5,
		'max_articles_hasard' => 5,
		'position_badges' => 1,
		'lien_badge_perso' => 'http://',
		'infobulle_badge_perso' => '',
		'position_annonce' => 0,
		'modele_pagination_navigation' => '',
		'pas_pagination_navigation' => 10,
		'modele_pagination_filtre' => '',
		'pas_pagination_filtre' => 10,
		'modele_pagination_commentaires' => '',
		'pas_pagination_commentaires' => 10,
		'modele_pagination_messages' => '',
		'pas_pagination_messages' => 10,
	);

	return $defaut;
}

function sarkaspip_declarer_config_styles() {
	$defaut = array(
	);

	return $defaut;
}

function sarkaspip_declarer_config_typo() {
	$defaut = array(
	);

	return $defaut;
}

function sarkaspip_declarer_config_coins() {
	$defaut = array(
	);

	return $defaut;
}

function sarkaspip_declarer_config_header() {
	$defaut = array(
		'auteur_site' => 'Collectif Sarka-SPIP',
		'keywords_site' => '',
		'recurrence_robot' => 30,
	);

	return $defaut;
}

function sarkaspip_declarer_config_backend() {
	$defaut = array(
		'age_albums' => 5,
		'age_articles' => 5,
		'age_evenements' => 5,
		'nb_albums' => 10,
		'nb_articles' => 10,
		'nb_evenements' => 10,
		'rss_albums' => 'oui',
		'rss_articles' => 'oui',
		'rss_evenements' => 'oui',
	);

	return $defaut;
}

function sarkaspip_declarer_config_plugins() {
	$defaut = array(
		'config_boutonstexte' => 'defaut',
		'config_mediabox' => 'defaut',
		'config_socialtags' => 'defaut',
	);

	return $defaut;
}

function sarkaspip_declarer_config_maintenance() {
	$defaut = array(
		'debug_arbo' => 'non',				// non : variables non affichées, oui : variables affichées sous le formulaire
		'debug_bouton' => 'non',			// non : bouton non affiché, oui : bouton configuration affiché dans le menu
	);

	return $defaut;
}


?>
