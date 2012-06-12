<?php
##########################################################################
#
#           			Plugin Beespip pour SPIP
#
#
#             Site de documentation des squelettes BeeSpip
#                       http://www.beespip.org
#
#	                 2004-2011 - Christophe Gindro
############################################################################

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/meta');
include_spip('base/create');


function beespip_upgrade($nom_meta_base_version, $version_cible){
        $current_version = 0.0;
        if (   (!isset($GLOBALS['meta'][$nom_meta_base_version]) )
                        || (($current_version = $GLOBALS['meta'][$nom_meta_base_version])!=$version_cible)){
				$ancienne_installation = lire_meta('spipgen_version');
				if ($ancienne_installation!='') {
					beespip_recuperer_meta();
					beespip_effacer_meta();
				}
                if ($current_version==0.0){
                        //include_spip('base/beespip');
                        //creer_base();
                        beespip_definir_meta();
                        ecrire_meta($nom_meta_base_version,$current_version=$version_cible);
                }
                if (version_compare($current_version,"0.26","<")){
                        $lien_affichebloc = lire_config('BeeSpip/menu/lien_affichebloc');
                        if ($lien_affichebloc!='') ecrire_config('BeeSpip/menu/lien_affichebloc','oui');
                        ecrire_meta($nom_meta_base_version,$current_version="0.26",'non');
                }
                if (version_compare($current_version,"0.31","<")){
                        beespip_modifier_motscles();
                        // Supression des configurations obsolètes
                        $intranet = lire_config('BeeSpip/configuration/intranet');
                        if ($intranet!='') effacer_config('BeeSpip/configuration/intranet');
                        $fils_rss = lire_config('BeeSpip/configuration/fils_rss');
                        if ($fils_rss!='') effacer_config('BeeSpip/configuration/fils_rss');
                        $fond_entete = lire_config('BeeSpip/affichage/fond_entete');
                        if ($fond_entete!='') effacer_config('BeeSpip/affichage/fond_entete');
                        $logo = lire_config('BeeSpip/affichage/logo');
                        if ($logo!='') effacer_config('BeeSpip/affichage/logo');
                        $logo_largeur = lire_config('BeeSpip/affichage/logo_largeur');
                        if ($logo_largeur!='') effacer_config('BeeSpip/affichage/logo_largeur');
                        $logo_hauteur = lire_config('BeeSpip/affichage/logo_hauteur');
                        if ($logo_hauteur!='') effacer_config('BeeSpip/affichage/logo_hauteur');
                        $site_ombre = lire_config('BeeSpip/affichage/site_ombre');
                        if ($site_ombre!='') effacer_config('BeeSpip/affichage/site_ombre');
                        $cartouche_services = lire_config('BeeSpip/affichage/cartouche_services');
                        if ($cartouche_services!='') effacer_config('BeeSpip/affichage/cartouche_services');
                        // Ajout des nouvelles configurations
                        $nom_site = lire_config('BeeSpip/affichage/nom_site');
                        if ($nom_site!='') ecrire_config('BeeSpip/affichage/nom_site','oui');
                        $hauteur_entete = lire_config('BeeSpip/affichage/hauteur_entete');
                        if ($hauteur_entete!='') ecrire_config('BeeSpip/affichage/hauteur_entete','275');
                        $hauteur_menu = lire_config('BeeSpip/affichage/hauteur_menu');
                        if ($hauteur_menu!='') ecrire_config('BeeSpip/affichage/hauteur_menu','5');
                        ecrire_meta($nom_meta_base_version,$current_version="0.31",'non');
                }
                if (version_compare($current_version,"0.36","<")){
                        // Ajout des nouvelles configurations
                        ecrire_config('BeeSpip/couleur/couleur_principale','#b83233');
                        ecrire_config('BeeSpip/couleur/couleur_secondaire_foncee','#8b0b00');
                        ecrire_config('BeeSpip/couleur/couleur_secondaire_claire','#ff645b');
                        ecrire_config('BeeSpip/couleur/couleur_principale_texte','#666666');
                        ecrire_config('BeeSpip/couleur/beespip_couleur_titres','#444444');
                        ecrire_config('BeeSpip/couleur/couleur_liens','#0070a7');
                        ecrire_meta($nom_meta_base_version,$current_version="0.36",'non');
                }
                if (version_compare($current_version,"0.40","<")){
                        // Supression des configurations obsolètes 
                        $affichage_portfolio = lire_config('BeeSpip/affichage/affichage_portfolio');
                        if ($affichage_portfolio!='') effacer_config('BeeSpip/affichage/affichage_portfolio');
                        $emplacement_date = lire_config('BeeSpip/affichage/emplacement_date');
                        if ($emplacement_date!='') effacer_config('BeeSpip/affichage/emplacement_date');
                        $menu_vertical = lire_config('BeeSpip/menu/menu_vertical');
                        if ($menu_vertical!='') effacer_config('BeeSpip/menu/menu_vertical');
                        $menu_liens_deplier_replier = lire_config('BeeSpip/menu/menu_liens_deplier_replier');
                        if ($menu_liens_deplier_replier!='') effacer_config('BeeSpip/menu/menu_liens_deplier_replier');
                        $menu_articles = lire_config('BeeSpip/menu/menu_articles');
                        if ($menu_articles!='') effacer_config('BeeSpip/menu/menu_articles');
                        $menu_horizontal = lire_config('BeeSpip/menu/menu_horizontal');
                        if ($menu_horizontal!='') effacer_config('BeeSpip/menu/menu_horizontal');
                        $lien_agenda = lire_config('BeeSpip/menu/lien_agenda');
                        if ($lien_agenda!='') effacer_config('BeeSpip/menu/lien_agenda');
                        $lien_reactions = lire_config('BeeSpip/menu/lien_reactions');
                        if ($lien_reactions!='') effacer_config('BeeSpip/menu/lien_reactions');
                        $lien_usagers = lire_config('BeeSpip/menu/lien_usagers');
                        if ($lien_usagers!='') effacer_config('BeeSpip/menu/lien_usagers');
                        $lien_actu_web = lire_config('BeeSpip/menu/lien_actu_web');
                        if ($lien_actu_web!='') effacer_config('BeeSpip/menu/lien_actu_web');
                        $lien_newsletter = lire_config('BeeSpip/menu/lien_newsletter');
                        if ($lien_newsletter!='') effacer_config('BeeSpip/menu/lien_newsletter');
                        $lien_annuaire = lire_config('BeeSpip/menu/lien_annuaire');
                        if ($lien_annuaire!='') effacer_config('BeeSpip/menu/lien_annuaire');
                        $lien_portfolio = lire_config('BeeSpip/menu/lien_portfolio');
                        if ($lien_portfolio!='') effacer_config('BeeSpip/menu/lien_portfolio');
                        $index_mots_cles = lire_config('BeeSpip/menu/index_mots_cles');
                        if ($index_mots_cles!='') effacer_config('BeeSpip/menu/index_mots_cles');
                        $lien_plan = lire_config('BeeSpip/menu/lien_plan');
                        if ($lien_plan!='') effacer_config('BeeSpip/menu/lien_plan');
                        $lien_espace_redacteur = lire_config('BeeSpip/menu/lien_espace_redacteur');
                        if ($lien_espace_redacteur!='') effacer_config('BeeSpip/menu/lien_espace_redacteur');
                        $lien_affichebloc = lire_config('BeeSpip/menu/lien_affichebloc');
                        if ($lien_affichebloc!='') effacer_config('BeeSpip/menu/lien_affichebloc');
                        $theme = lire_config('BeeSpip/themes/theme');
                        if ($theme!='') effacer_config('BeeSpip/themes/theme');

                        // Ajout des nouvelles configurations
                        ecrire_config('BeeSpip/affichage/nb_items_menu','5');
                        ecrire_config('BeeSpip/configuration/nb_article_col_droite','2');
                        ecrire_config('BeeSpip/configuration/nb_evenement_accueil','5');
                        ecrire_meta($nom_meta_base_version,$current_version="0.40",'non');
                }
                if (version_compare($current_version,"0.41","<")){
                        // Ajout des nouvelles configurations
                        ecrire_config('BeeSpip/configuration/autres_articles','oui');
                        ecrire_meta($nom_meta_base_version,$current_version="0.41",'non');
                }
                if (version_compare($current_version,"0.44","<")){
                        // Ajout des nouvelles configurations
                        ecrire_config('BeeSpip/couleur/couleur_fond_page','#ffffff');
                        ecrire_config('BeeSpip/couleur/couleur_menu_fond','#f5f4f3');
                        ecrire_config('BeeSpip/couleur/couleur_menu_liens','#666666');
                        ecrire_config('BeeSpip/couleur/couleur_menu_liens_survol','#000000');
                        ecrire_config('BeeSpip/couleur/couleur_filets_titres','#ebebeb');
                        ecrire_config('BeeSpip/couleur/couleur_filets_colonnes','#e8e8e8');
                        ecrire_config('BeeSpip/couleur/couleur_cadres','#ebebeb');
                        ecrire_config('BeeSpip/couleur/couleur_liens_survol','#b83233');
                        ecrire_meta($nom_meta_base_version,$current_version="0.44",'non');
                }
                if (version_compare($current_version,"0.45","<")){
                        // Ajout des nouvelles configurations
                        ecrire_config('BeeSpip/couleur/couleur_fond_formulaires','#f8f8f8');
                        ecrire_meta($nom_meta_base_version,$current_version="0.45",'non');
                }
                if (version_compare($current_version,"0.46","<")){
                        // Ajout des nouvelles configurations
                        ecrire_config('BeeSpip/affichage/modele_pagination','');
                        ecrire_config('BeeSpip/configuration/articles_populaires','oui');
                        ecrire_meta($nom_meta_base_version,$current_version="0.46",'non');
                }
                if (version_compare($current_version,"0.47","<")){
                        // Ajout des nouvelles configurations
                        ecrire_config('BeeSpip/affichage/taille_typo_menu','1.1');
                        ecrire_meta($nom_meta_base_version,$current_version="0.47",'non');
                }
                if (version_compare($current_version,"0.48","<")){
                        // Ajout des nouvelles configurations
                        ecrire_config('BeeSpip/configuration/nb_article_une','6');
                        ecrire_config('BeeSpip/configuration/nb_ligne_sousune','1');
                        ecrire_config('BeeSpip/affichage/libelle_rubrique_article','oui');
                        ecrire_meta($nom_meta_base_version,$current_version="0.48",'non');
                }

                if (version_compare($current_version,"0.49","<")){
                        // Ajout des nouvelles configurations
                        ecrire_config('BeeSpip/affichage/largeur_items_menu','0');
                        ecrire_meta($nom_meta_base_version,$current_version="0.49",'non');
                }
                if (version_compare($current_version,"0.50","<")){
                        // Ajout des nouvelles configurations
                        ecrire_config('BeeSpip/affichage/menu_debut','oui');
                        ecrire_meta($nom_meta_base_version,$current_version="0.50",'non');
                }
                ecrire_metas();
        }
}
/*
function beespip_vider_tables($nom_meta_base_version){
	include_spip('base/abstract_sql');
	sql_drop_table("spip_annuaire_individus");
	sql_drop_table("spip_annuaire_organisations");
	sql_drop_table("spip_annuaire_categories");
	effacer_meta('beespip_base_version');
}*/


function beespip_verifier_meta(){
	// Vérifier si les tables de l'annuaire "ancienne version" sont installées
	/*include_spip('base/abstract_sql');
	if (sql_showtable('intra_annuaire_cate_orga')) {
		// Passer les tables en prefixage spip_ ou autre..
		if ($GLOBALS['table_prefix']) $table_pref = $GLOBALS['table_prefix']."_";
		else $table_pref = "spip_";
		sql_query("RENAME TABLE intra_annuaire_indi TO ".$table_pref."annuaire_individus");
		sql_query("RENAME TABLE intra_annuaire_orga TO ".$table_pref."annuaire_organisations");
		sql_query("RENAME TABLE intra_annuaire_categories TO ".$table_pref."annuaire_categories");
		sql_query("RENAME TABLE intra_annuaire_indi_orga TO ".$table_pref."annuaire_individus_organisations");
		sql_query("RENAME TABLE intra_annuaire_cate_orga TO ".$table_pref."annuaire_categories_organisations");
		sql_alter("TABLE spip_annuaire_individus CHANGE `i_id` `id_individu` DOUBLE NOT NULL AUTO_INCREMENT");
		sql_alter("TABLE spip_annuaire_organisations CHANGE `i_id` `id_organisation` DOUBLE NOT NULL AUTO_INCREMENT");
		sql_alter("TABLE spip_annuaire_categories CHANGE `i_id` `id_categorie` DOUBLE NOT NULL AUTO_INCREMENT");
		sql_alter("TABLE spip_annuaire_categories_organisations CHANGE `i_id` `id_i` DOUBLE NOT NULL AUTO_INCREMENT");
		sql_alter("TABLE spip_annuaire_categories_organisations CHANGE `i_orga` `id_organisation` BIGINT( 20 ) NOT NULL DEFAULT '1'");
		sql_alter("TABLE spip_annuaire_categories_organisations CHANGE `i_cate` `id_categorie` BIGINT( 20 ) NOT NULL DEFAULT '1'");
		sql_alter("TABLE spip_annuaire_individus_organisations CHANGE `i_id` `id_i` DOUBLE NOT NULL AUTO_INCREMENT");
		sql_alter("TABLE spip_annuaire_individus_organisations CHANGE `i_orga` `id_organisation` BIGINT( 20 ) NOT NULL DEFAULT '1'");
		sql_alter("TABLE spip_annuaire_individus_organisations CHANGE `i_user` `id_individu` BIGINT( 20 ) NOT NULL DEFAULT '1'");
		// Encodage des tables
		include_spip('inc/charsets');
		$s = spip_query("SELECT * FROM spip_annuaire_categories");
		while ($t = sql_fetch($s)) {
			sql_query("UPDATE spip_annuaire_categories SET `nom_cate` = '". utf8_decode($t[nom_cate]). "' WHERE `id_categorie`='".$t[id_categorie]."'");
		}
		$s = spip_query("SELECT * FROM spip_annuaire_individus");
		while ($t = sql_fetch($s)) {
			sql_query("UPDATE spip_annuaire_individus SET `titre` = '". utf8_decode($t[titre]). "' WHERE `id_individu`='".$t[id_individu]."'");
			sql_query("UPDATE spip_annuaire_individus SET `prenom` = '". utf8_decode($t[prenom]). "' WHERE `id_individu`='".$t[id_individu]."'");
			sql_query("UPDATE spip_annuaire_individus SET `nom` = '". utf8_decode($t[nom]). "' WHERE `id_individu`='".$t[id_individu]."'");
			sql_query("UPDATE spip_annuaire_individus SET `adr1` = '". utf8_decode($t[adr1]). "' WHERE `id_individu`='".$t[id_individu]."'");
			sql_query("UPDATE spip_annuaire_individus SET `adr2` = '". utf8_decode($t[adr2]). "' WHERE `id_individu`='".$t[id_individu]."'");
			sql_query("UPDATE spip_annuaire_individus SET `ville` = '". utf8_decode($t[ville]). "' WHERE `id_individu`='".$t[id_individu]."'");
			sql_query("UPDATE spip_annuaire_individus SET `commentaire` = '". utf8_decode($t[commentaire]). "' WHERE `id_individu`='".$t[id_individu]."'");
		}
		$s = spip_query("SELECT * FROM spip_annuaire_organisations");
		while ($t = sql_fetch($s)) {
			sql_query("UPDATE spip_annuaire_organisations SET `nom_organisme` = '". utf8_decode($t[nom_organisme]). "' WHERE `id_organisation`='".$t[id_organisation]."'");
			sql_query("UPDATE spip_annuaire_organisations SET `sigle` = '". utf8_decode($t[sigle]). "' WHERE `id_organisation`='".$t[id_organisation]."'");
			sql_query("UPDATE spip_annuaire_organisations SET `adr1` = '". utf8_decode($t[adr1]). "' WHERE `id_organisation`='".$t[id_organisation]."'");
			sql_query("UPDATE spip_annuaire_organisations SET `adr2` = '". utf8_decode($t[adr2]). "' WHERE `id_organisation`='".$t[id_organisation]."'");
			sql_query("UPDATE spip_annuaire_organisations SET `ville` = '". utf8_decode($t[ville]). "' WHERE `id_organisation`='".$t[id_organisation]."'");
			sql_query("UPDATE spip_annuaire_organisations SET `commentaire` = '". utf8_decode($t[commentaire]). "' WHERE `id_organisation`='".$t[id_organisation]."'");
		}
		$s = spip_query("SELECT * FROM spip_annuaire_individus_organisations");
		while ($t = sql_fetch($s)) {
			sql_query("UPDATE spip_annuaire_individus_organisations SET `fonction` = '". utf8_decode($t[fonction]). "' WHERE `id_i`='".$t[id_i]."'");
			sql_query("UPDATE spip_annuaire_individus_organisations SET `commentaire` = '". utf8_decode($t[commentaire]). "' WHERE `id_i`='".$t[id_i]."'");
		}
		// Supprimer les tables inutiles
		sql_drop_table("intra_sessions");
		sql_drop_table("intra_sessions_logs");
		sql_drop_table("intra_users");
		
	}*/

}

function beespip_modifier_motscles(){
	// On supprime tous les mots clés obsolètes
	$titre_groupemotscles = "~meta_beespip_communs";
	$row = sql_fetsel("id_mot", "spip_mots", "titre='revisit-after' AND type='".$titre_groupemotscles."'");
	sql_delete("spip_mots", "id_mot=".$row['id_mot']);
	sql_delete("spip_groupes_mots", "titre='".$titre_groupemotscles."'");
	
	$titre_groupemotscles = "~meta_beespip";
	$row = sql_fetsel("id_mot", "spip_mots", "titre='description' AND type='".$titre_groupemotscles."'");
	sql_delete("spip_mots", "id_mot=".$row['id_mot']);
	$row = sql_fetsel("id_mot", "spip_mots", "titre='description' AND type='".$titre_groupemotscles."'");
	sql_delete("spip_mots", "id_mot=".$row['id_mot']);
	sql_delete("spip_groupes_mots", "titre='".$titre_groupemotscles."'");

	$titre_groupemotscles = "~rubriques_beespip";
	$row = sql_fetsel("id_mot", "spip_mots", "titre='beespip_accueil' AND type='".$titre_groupemotscles."'");
	sql_delete("spip_mots_rubriques", "id_mot=".$row['id_mot']);
	sql_delete("spip_mots", "id_mot=".$row['id_mot']);
	$row = sql_fetsel("id_mot", "spip_mots", "titre='beespip_actu' AND type='".$titre_groupemotscles."'");
	sql_delete("spip_mots_rubriques", "id_mot=".$row['id_mot']);
	sql_delete("spip_mots", "id_mot=".$row['id_mot']);
	$row = sql_fetsel("id_mot", "spip_mots", "titre='beespip_com' AND type='".$titre_groupemotscles."'");
	sql_delete("spip_mots_rubriques", "id_mot=".$row['id_mot']);
	sql_delete("spip_mots", "id_mot=".$row['id_mot']);
	$row = sql_fetsel("id_mot", "spip_mots", "titre='beespip_signets' AND type='".$titre_groupemotscles."'");
	sql_delete("spip_mots_rubriques", "id_mot=".$row['id_mot']);
	sql_delete("spip_mots", "id_mot=".$row['id_mot']);
	$row = sql_fetsel("id_mot", "spip_mots", "titre='beespip_rss' AND type='".$titre_groupemotscles."'");
	sql_delete("spip_mots_rubriques", "id_mot=".$row['id_mot']);
	sql_delete("spip_mots", "id_mot=".$row['id_mot']);
	$row = sql_fetsel("id_mot", "spip_mots", "titre='beespip_blog' AND type='".$titre_groupemotscles."'");
	sql_delete("spip_mots_rubriques", "id_mot=".$row['id_mot']);
	sql_delete("spip_mots", "id_mot=".$row['id_mot']);
	sql_delete("spip_groupes_mots", "titre='".$titre_groupemotscles."'");

	$titre_groupemotscles = "~modalites_affichage_sites";
	$row = sql_fetsel("id_mot", "spip_mots", "titre='exclu' AND type='".$titre_groupemotscles."'");
	sql_delete("spip_mots_syndic", "id_mot=".$row['id_mot']);
	sql_delete("spip_mots", "id_mot=".$row['id_mot']);
	$row = sql_fetsel("id_mot", "spip_mots", "titre='ouvert_actualites' AND type='".$titre_groupemotscles."'");
	sql_delete("spip_mots_syndic", "id_mot=".$row['id_mot']);
	sql_delete("spip_mots", "id_mot=".$row['id_mot']);
	$row = sql_fetsel("id_mot", "spip_mots", "titre='exclu_actualites' AND type='".$titre_groupemotscles."'");
	sql_delete("spip_mots_syndic", "id_mot=".$row['id_mot']);
	sql_delete("spip_mots", "id_mot=".$row['id_mot']);
	$row = sql_fetsel("id_mot", "spip_mots", "titre='exclu_actualites_web' AND type='".$titre_groupemotscles."'");
	sql_delete("spip_mots_syndic", "id_mot=".$row['id_mot']);
	sql_delete("spip_mots", "id_mot=".$row['id_mot']);
	sql_delete("spip_groupes_mots", "titre='".$titre_groupemotscles."'");

	$titre_groupemotscles = "~modalites_affichage_breves";
	$row = sql_fetsel("id_mot", "spip_mots", "titre='exclu' AND type='".$titre_groupemotscles."'");
	sql_delete("spip_mots_breves", "id_mot=".$row['id_mot']);
	sql_delete("spip_mots", "id_mot=".$row['id_mot']);
	$row = sql_fetsel("id_mot", "spip_mots", "titre='ouvert_actualites' AND type='".$titre_groupemotscles."'");
	sql_delete("spip_mots_breves", "id_mot=".$row['id_mot']);
	sql_delete("spip_mots", "id_mot=".$row['id_mot']);
	$row = sql_fetsel("id_mot", "spip_mots", "titre='ouvert_actualites_resume' AND type='".$titre_groupemotscles."'");
	sql_delete("spip_mots_breves", "id_mot=".$row['id_mot']);
	sql_delete("spip_mots", "id_mot=".$row['id_mot']);
	$row = sql_fetsel("id_mot", "spip_mots", "titre='ouvert_rubrique' AND type='".$titre_groupemotscles."'");
	sql_delete("spip_mots_breves", "id_mot=".$row['id_mot']);
	sql_delete("spip_mots", "id_mot=".$row['id_mot']);
	$row = sql_fetsel("id_mot", "spip_mots", "titre='ouvert_rubrique_resume' AND type='".$titre_groupemotscles."'");
	sql_delete("spip_mots_breves", "id_mot=".$row['id_mot']);
	sql_delete("spip_mots", "id_mot=".$row['id_mot']);
	$row = sql_fetsel("id_mot", "spip_mots", "titre='ouvert_actualites_titre' AND type='".$titre_groupemotscles."'");
	sql_delete("spip_mots_breves", "id_mot=".$row['id_mot']);
	sql_delete("spip_mots", "id_mot=".$row['id_mot']);
	$row = sql_fetsel("id_mot", "spip_mots", "titre='exclu_actualites' AND type='".$titre_groupemotscles."'");
	sql_delete("spip_mots_breves", "id_mot=".$row['id_mot']);
	sql_delete("spip_mots", "id_mot=".$row['id_mot']);
	sql_delete("spip_groupes_mots", "titre='".$titre_groupemotscles."'");

	$titre_groupemotscles = "~modalites_affichage_rubriques";
	$row = sql_fetsel("id_mot", "spip_mots", "titre='trier_par_date' AND type='".$titre_groupemotscles."'");
	sql_delete("spip_mots_rubriques", "id_mot=".$row['id_mot']);
	sql_delete("spip_mots", "id_mot=".$row['id_mot']);
	$row = sql_fetsel("id_mot", "spip_mots", "titre='menu_deplie' AND type='".$titre_groupemotscles."'");
	sql_delete("spip_mots_rubriques", "id_mot=".$row['id_mot']);
	sql_delete("spip_mots", "id_mot=".$row['id_mot']);
	$row = sql_fetsel("id_mot", "spip_mots", "titre='menu_sans_articles' AND type='".$titre_groupemotscles."'");
	sql_delete("spip_mots_rubriques", "id_mot=".$row['id_mot']);
	sql_delete("spip_mots", "id_mot=".$row['id_mot']);
	$row = sql_fetsel("id_mot", "spip_mots", "titre='menu_horizontal' AND type='".$titre_groupemotscles."'");
	sql_delete("spip_mots_rubriques", "id_mot=".$row['id_mot']);
	sql_delete("spip_mots", "id_mot=".$row['id_mot']);
	// On renomme ceux que l'on conserve
	$row = sql_fetsel("id_mot", "spip_mots", "titre='exclu' AND type='".$titre_groupemotscles."'");
	sql_updateq("spip_mots", array("titre" => ("exclu"), "texte" => ("Permet d'exclure (tant que le mot lui est affecté) l'élément du plan du site, de la recherche et de la page d'accueil")), "id_mot=".$row['id_mot']);
	// On renomme le groupe et on modifie les éléments ciblés
	$nouveau_titre_groupemotscles = "~modalites_affichage";
	sql_updateq("spip_groupes_mots", array("titre" => $nouveau_titre_groupemotscles, "tables_liees" => "breves,rubriques,syndic"), "titre='".$titre_groupemotscles."'");


	$titre_groupemotscles = "~modalites_affichage_articles";
	$row = sql_fetsel("id_mot", "spip_mots", "titre='ouvert_rubrique' AND type='".$titre_groupemotscles."'");
	sql_delete("spip_mots_articles", "id_mot=".$row['id_mot']);
	sql_delete("spip_mots", "id_mot=".$row['id_mot']);
	$row = sql_fetsel("id_mot", "spip_mots", "titre='ouvert_rubrique_resume' AND type='".$titre_groupemotscles."'");
	sql_delete("spip_mots_articles", "id_mot=".$row['id_mot']);
	sql_delete("spip_mots", "id_mot=".$row['id_mot']);
	$row = sql_fetsel("id_mot", "spip_mots", "titre='exclu_actualites' AND type='".$titre_groupemotscles."'");
	sql_delete("spip_mots_articles", "id_mot=".$row['id_mot']);
	sql_delete("spip_mots", "id_mot=".$row['id_mot']);
	$row = sql_fetsel("id_mot", "spip_mots", "titre='exclu_page_reactions' AND type='".$titre_groupemotscles."'");
	sql_delete("spip_mots_articles", "id_mot=".$row['id_mot']);
	sql_delete("spip_mots", "id_mot=".$row['id_mot']);
	$row = sql_fetsel("id_mot", "spip_mots", "titre='portfolio' AND type='".$titre_groupemotscles."'");
	sql_delete("spip_mots_articles", "id_mot=".$row['id_mot']);
	sql_delete("spip_mots", "id_mot=".$row['id_mot']);
	$row = sql_fetsel("id_mot", "spip_mots", "titre='portfolio_vignette' AND type='".$titre_groupemotscles."'");
	sql_delete("spip_mots_articles", "id_mot=".$row['id_mot']);
	sql_delete("spip_mots", "id_mot=".$row['id_mot']);
	
	// On renomme ceux que l'on conserve
	$row = sql_fetsel("id_mot", "spip_mots", "titre='exclu' AND type='".$titre_groupemotscles."'");
	sql_updateq("spip_mots", array("titre" => ("exclu"), "texte" => ("Permet d'exclure (tant que le mot lui est affecté) l'article du plan du site, de la recherche et de la page d'accueil")), "id_mot=".$row['id_mot']);
	$row = sql_fetsel("id_mot", "spip_mots", "titre='ouvert_actualites' AND type='".$titre_groupemotscles."'");
	sql_updateq("spip_mots", array("titre" => ("actualites_une"), "texte" => ("Permet d'afficher (tant que le mot lui est affecté) l'article dans la partie Une")), "id_mot=".$row['id_mot']);
	$row = sql_fetsel("id_mot", "spip_mots", "titre='ouvert_actualites_resume' AND type='".$titre_groupemotscles."'");
	sql_updateq("spip_mots", array("titre" => ("actualites_sous_une"), "texte" => ("Permet d'afficher (tant que le mot lui est affecté) l'article sous les Unes")), "id_mot=".$row['id_mot']);
	$row = sql_fetsel("id_mot", "spip_mots", "titre='ouvert_actualites_titre' AND type='".$titre_groupemotscles."'");
	sql_updateq("spip_mots", array("titre" => ("actualites_colonne_droite"), "texte" => ("Permet d'afficher (tant que le mot lui est affecté) l'article en colonne de droite sur la page d'accueil")), "id_mot=".$row['id_mot']);


}

function beespip_recuperer_meta(){
	$page_accueil = $GLOBALS['meta']['page_accueil'];
	if ($page_accueil!='') ecrire_config('BeeSpip/configuration/page_accueil',$page_accueil);
	$spipgen_cal = $GLOBALS['meta']['spipgen_cal'];
	if ($spipgen_cal!='') ecrire_config('BeeSpip/configuration/calendrier_public',$spipgen_cal);
	$beespip_pos_recherche = $GLOBALS['meta']['beespip_pos_recherche'];
	if ($beespip_pos_recherche!='') ecrire_config('BeeSpip/affichage/emplacement_recherche',$beespip_pos_recherche);
	$beespip_datepubli = $GLOBALS['meta']['beespip_datepubli'];
	if ($beespip_datepubli!='') ecrire_config('BeeSpip/affichage/dates_articles',$beespip_datepubli);
	$beespip_datepubli_breve = $GLOBALS['meta']['beespip_datepubli_breve'];
	if ($beespip_datepubli_breve!='') ecrire_config('BeeSpip/affichage/dates_breves',$beespip_datepubli_breve);
	$beespip_auteur = $GLOBALS['meta']['beespip_auteur'];
	if ($beespip_auteur!='') ecrire_config('BeeSpip/affichage/auteurs_articles',$beespip_auteur);
	$spipgen_maj = $GLOBALS['meta']['spipgen_maj'];
	if ($spipgen_maj!='') ecrire_config('BeeSpip/affichage/derniere_date_publication',$spipgen_maj);

}

function beespip_effacer_meta(){
	effacer_meta('spipgen_version');
	effacer_meta('page_accueil');
	effacer_meta('spipgen_intranet');
	effacer_meta('spipgen_cal');
	effacer_meta('spipgen_lien_syndic');
	effacer_meta('spipgen_fond_entete');
	effacer_meta('spipgen_logo');
	effacer_meta('spipgen_logo_largeur');
	effacer_meta('spipgen_logo_hauteur');
	effacer_meta('spipgen_affichage');
	effacer_meta('beespip_cart_services');
	effacer_meta('beespip_aff_portfolio');
	effacer_meta('beespip_pos_date');
	effacer_meta('emplacement_recherche');
	effacer_meta('beespip_datepubli');
	effacer_meta('beespip_datepubli_breve');
	effacer_meta('beespip_auteur');
	effacer_meta('spipgen_maj');
	effacer_meta('menu_vertical');
	effacer_meta('spipgen_menudeplie');
	effacer_meta('article_menu');
	effacer_meta('menu_horizontal');
	effacer_meta('spipgen_agenda');
	effacer_meta('spipgen_forums');
	effacer_meta('spipgen_auteurs');
	effacer_meta('spipgen_syndic');
	effacer_meta('spipgen_newsletter');
	effacer_meta('beespip_theme');
	effacer_meta('spipgen_portfolio');
	effacer_meta('spipgen_annuaire');
	effacer_meta('spipgen_index');
	effacer_meta('spipgen_plan');
	effacer_meta('spipgen_prive');
	effacer_meta('spipgen_spikini');
	effacer_meta('spipgen_chat');
	effacer_meta('spipgen_phpbb');
	effacer_meta('spipgen_artpdf');
	effacer_meta('spipgen_access');
	effacer_meta('spipgen_access_niveaumax');
	effacer_meta('beespip_theme');
}

function beespip_definir_meta(){
	// Casier configuration
	ecrire_config('BeeSpip/configuration/page_accueil','accueil');
	ecrire_config('BeeSpip/configuration/calendrier_public','non');
	ecrire_config('BeeSpip/configuration/nb_article_une','6');
	ecrire_config('BeeSpip/configuration/nb_ligne_sousune','1');
	ecrire_config('BeeSpip/configuration/nb_article_col_droite','2');
	ecrire_config('BeeSpip/configuration/nb_evenement_accueil','5');
	ecrire_config('BeeSpip/configuration/autres_articles','oui');
	ecrire_config('BeeSpip/configuration/articles_populaires','oui');
	// Casier affichage
	ecrire_config('BeeSpip/affichage/nom_site','oui');
	ecrire_config('BeeSpip/affichage/hauteur_entete','275');
	ecrire_config('BeeSpip/affichage/hauteur_menu','5');
	ecrire_config('BeeSpip/affichage/nb_items_menu','5');
	ecrire_config('BeeSpip/affichage/menu_debut','oui');
	ecrire_config('BeeSpip/affichage/largeur_items_menu','0');
	ecrire_config('BeeSpip/affichage/taille_typo_menu','1.1');
	ecrire_config('BeeSpip/affichage/emplacement_recherche','haut');
	ecrire_config('BeeSpip/affichage/libelle_rubrique_article','oui');
	ecrire_config('BeeSpip/affichage/modele_pagination','');
	ecrire_config('BeeSpip/affichage/dates_articles','oui');
	ecrire_config('BeeSpip/affichage/dates_breves','oui');
	ecrire_config('BeeSpip/affichage/auteurs_articles','oui');
	ecrire_config('BeeSpip/affichage/derniere_date_publication','non');
	// Casier couleur
	ecrire_config('BeeSpip/couleur/couleur_principale','#b83233');
	ecrire_config('BeeSpip/couleur/couleur_secondaire_foncee','#8b0b00');
	ecrire_config('BeeSpip/couleur/couleur_secondaire_claire','#ff645b');
	ecrire_config('BeeSpip/couleur/couleur_principale_texte','#666666');
	ecrire_config('BeeSpip/couleur/beespip_couleur_titres','#444444');
	ecrire_config('BeeSpip/couleur/couleur_liens','#0070a7');
	ecrire_config('BeeSpip/couleur/couleur_fond_page','#ffffff');
	ecrire_config('BeeSpip/couleur/couleur_menu_fond','#f5f4f3');
	ecrire_config('BeeSpip/couleur/couleur_menu_liens','#666666');
	ecrire_config('BeeSpip/couleur/couleur_menu_liens_survol','#000000');
	ecrire_config('BeeSpip/couleur/couleur_filets_titres','#ebebeb');
	ecrire_config('BeeSpip/couleur/couleur_filets_colonnes','#e8e8e8');
	ecrire_config('BeeSpip/couleur/couleur_cadres','#ebebeb');
	ecrire_config('BeeSpip/couleur/couleur_liens_survol','#b83233');
	ecrire_config('BeeSpip/couleur/couleur_fond_formulaires','#f8f8f8');
	
	beespip_modifier_motscles();

	/*$titre_groupemotscles = "~modalites_affichage";
	sql_insertq("spip_groupes_mots", array("titre" => $titre_groupemotscles, "tables_liees" => "breves,rubriques,syndic", "minirezo" => "oui","comite" => "oui"));
	$row = sql_fetsel("id_groupe", "spip_groupes_mots", "titre='".$titre_groupemotscles."'");
	sql_insertq("spip_mots", array("titre" => ("exclu"), "texte" => ("Permet d'exclure (tant que le mot lui est affecté) l'élément du plan du site, de la recherche et de la page d'accueil"), "id_groupe" => $row['id_groupe'], "type" => $titre_groupemotscles));

	$titre_groupemotscles = "~modalites_affichage_articles";
	sql_insertq("spip_groupes_mots", array("titre" => $titre_groupemotscles, "tables_liees" => "articles", "minirezo" => "oui","comite" => "oui"));
	$row = sql_fetsel("id_groupe", "spip_groupes_mots", "titre='".$titre_groupemotscles."'");
	sql_insertq("spip_mots", array("titre" => ("exclu"), "texte" => ("Permet d'exclure (tant que le mot lui est affecté) l'article du plan du site, de la recherche et de la page d'accueil"), "id_groupe" => $row['id_groupe'], "type" => $titre_groupemotscles));
	sql_insertq("spip_mots", array("titre" => ("actualites_une"), "texte" => ("Permet d'afficher (tant que le mot lui est affecté) l'article dans la partie Une"), "id_groupe" => $row['id_groupe'], "type" => $titre_groupemotscles));
	sql_insertq("spip_mots", array("titre" => ("actualites_sous_une"), "texte" => ("Permet d'afficher (tant que le mot lui est affecté) l'article sous les Unes"), "id_groupe" => $row['id_groupe'], "type" => $titre_groupemotscles));
	sql_insertq("spip_mots", array("titre" => ("actualites_colonne_droite"), "texte" => ("Permet d'afficher (tant que le mot lui est affecté) l'article en colonne de droite sur la page d'accueil"), "id_groupe" => $row['id_groupe'], "type" => $titre_groupemotscles));
	*/
}

?>
