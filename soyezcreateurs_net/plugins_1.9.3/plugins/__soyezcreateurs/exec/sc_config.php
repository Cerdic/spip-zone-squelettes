<?php
//
// Configuration de SPIP pour SoyezCreateurs
// Realisation : RealET : real3t@gmail.com
//

function config_site() {
	include_spip('inc/minipres');
	
	echo install_debut_html("Configurateur SoyezCreateurs");
	// Autorisations dates antérieures et gestion avancée des mots clé
	
	spip_query("REPLACE spip_meta (nom, valeur) VALUES ('activer_breves', 'oui')");
	spip_query("REPLACE spip_meta (nom, valeur) VALUES ('activer_logos_survol', 'oui')");
	spip_query("REPLACE spip_meta (nom, valeur) VALUES ('config_precise_groupes', 'oui')");
	spip_query("REPLACE spip_meta (nom, valeur) VALUES ('articles_surtitre', 'oui')");
	spip_query("REPLACE spip_meta (nom, valeur) VALUES ('articles_soustitre', 'oui')");
	spip_query("REPLACE spip_meta (nom, valeur) VALUES ('articles_descriptif', 'oui')");
	spip_query("REPLACE spip_meta (nom, valeur) VALUES ('articles_chapeau', 'oui')");
	spip_query("REPLACE spip_meta (nom, valeur) VALUES ('articles_ps', 'oui')");
	spip_query("REPLACE spip_meta (nom, valeur) VALUES ('articles_mots', 'oui')");
	spip_query("REPLACE spip_meta (nom, valeur) VALUES ('articles_urlref', 'oui')");
	spip_query("REPLACE spip_meta (nom, valeur) VALUES ('articles_redirection', 'oui')");
	spip_query("REPLACE spip_meta (nom, valeur) VALUES ('creer_preview', 'oui')");
	spip_query("REPLACE spip_meta (nom, valeur) VALUES ('articles_modif', 'oui')");
	spip_query("REPLACE spip_meta (nom, valeur) VALUES ('rubriques_descriptif', 'oui')");
	spip_query("REPLACE spip_meta (nom, valeur) VALUES ('forums_urlref', 'oui')");
	spip_query("REPLACE spip_meta (nom, valeur) VALUES ('activer_sites', 'oui')");
	spip_query("REPLACE spip_meta (nom, valeur) VALUES ('forums_publics', 'non')");
	spip_query("REPLACE spip_meta (nom, valeur) VALUES ('accepter_inscriptions', 'oui')");
	spip_query("REPLACE spip_meta (nom, valeur) VALUES ('prevenir_auteurs', ',pos,pri,abo,')");
	spip_query("REPLACE spip_meta (nom, valeur) VALUES ('messagerie_agenda', 'non')");
	spip_query("REPLACE spip_meta (nom, valeur) VALUES ('articles_versions', 'oui')");
	spip_query("REPLACE spip_meta (nom, valeur) VALUES ('activer_statistiques', 'oui')");
	spip_query("REPLACE spip_meta (nom, valeur) VALUES ('documents_article', 'oui')");
	spip_query("REPLACE spip_meta (nom, valeur) VALUES ('documents_rubrique', 'oui')");
	spip_query("REPLACE spip_meta (nom, valeur) VALUES ('preview', ',0minirezo,1comite,')");
	spip_query("REPLACE spip_meta (nom, valeur) VALUES ('btv2', 'a:1:{s:7:\"avancee\";s:3:\"Oui\";}')");
	spip_query("REPLACE spip_meta (nom, valeur) VALUES ('barre_typo_generalisee', 'a:6:{s:38:\"rubriques_texte_barre_typo_generalisee\";s:2:\"on\";s:40:\"groupesmots_texte_barre_typo_generalisee\";s:2:\"on\";s:33:\"mots_texte_barre_typo_generalisee\";s:2:\"on\";s:40:\"sites_description_barre_typo_generalisee\";s:2:\"on\";s:48:\"configuration_description_barre_typo_generalisee\";s:2:\"on\";s:42:\"auteurs_quietesvous_barre_typo_generalisee\";s:2:\"on\";}')");
	spip_query("REPLACE spip_meta (nom, valeur) VALUES ('boutonstexte', 'a:8:{s:7:\"txtOnly\";s:1:\"_\";s:11:\"txtBackSpip\";s:26:\"boutonstexte:retour_a_spip\";s:9:\"txtSizeUp\";s:29:\"boutonstexte:augmenter_police\";s:11:\"txtSizeDown\";s:28:\"boutonstexte:diminuer_police\";s:8:\"selector\";s:15:\"#contenu .texte\";s:6:\"jsFile\";s:15:\"boutonstexte.js\";s:7:\"cssFile\";s:12:\"boutonstexte\";s:7:\"imgPath\";s:21:\"images/fontsizeup.png\";}')");
	
	echo "<h1>Installation termin&eacute;</h1><p>Vous pouvez revenir &agrave; l'<a href='".generer_url_ecrire('')."'>administration du site</a>.</p>
	<p>Vous pouvez aussi <a href='".generer_url_ecrire('postconfig')."'>installer les mots-clefs</a>.</p>";
	echo install_fin_html();
	
	return TRUE;
}

function exec_sc_config() {
	if (!defined("_ECRIRE_INC_VERSION")) return;

	include_spip('inc/admin');
	include_spip("inc/lang");
	include_spip("inc/charsets");	

	debut_admin("postconfig", "Configurateur des mots clefs", "Voulez-vous vraiment configurer SPIP pour le squelette SoyezCreateurs ?");
	config_site();
	fin_admin("Configurateur site");
}
?>