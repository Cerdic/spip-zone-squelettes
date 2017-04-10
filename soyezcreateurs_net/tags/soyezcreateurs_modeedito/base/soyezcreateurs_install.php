<?php
/*
* Configuration de SPIP pour SoyezCreateurs
* Realisation : RealET : real3t@gmail.com
* Attention, fichier en UTF-8 sans BOM
*/

if (!defined('_ECRIRE_INC_VERSION')) return;

include_spip('inc/meta');

/*
 * Fonction d'installation, mise a jour de la base
 *
 * @param unknown_type $nom_meta_base_version
 * @param unknown_type $version_cible
 */
function soyezcreateurs_upgrade($nom_meta_base_version,$version_cible){
	include_spip('base/soyezcreateurs');
	$current_version = 0.0;
	if ((!isset($GLOBALS['meta'][$nom_meta_base_version])) || (($current_version = $GLOBALS['meta'][$nom_meta_base_version])!=$version_cible)){
		if (
			(version_compare($current_version,'2.1','<'))
			&& // Verification que le plugin n'a pas ete deja installe par l'ancienne methode
			(sql_countsel('spip_groupes_mots', "(titre = '_LayoutGala')") != 0)
		) {
			spip_log("SoyezCreateurs deja installe", "soyezcreateurs_install");
			ecrire_meta($nom_meta_base_version,$current_version='2.1','non');
		}
		if (version_compare($current_version,'2.1','<')) {
			soyezcreateurs_config_site();
			soyezcreateurs_config_motsclefs();
			// Installation des index FullText si le plugin est présent
			$f = chercher_filtre('info_plugin');
			if($f('Fulltext', 'est_actif')) {
				include_spip('inc/fulltext_exec');
				Fulltext_creer_tous();
			}
			// Installation d'exemples concernant l'agenda si le plugin est actif
			if ($f('agenda', 'est_actif')) {
				include_spip('inc/sc_article');
				
				$id_rubrique = id_rubrique('900. Agenda');
				if ($id_rubrique >0) {
					$article1 = trouve_article_sc("Installation du site");
					create_article($article1, "900. Agenda");
					$date = date('Y-m-d H:i:00');
					create_evenement("900. Agenda", "Installation du site", "Installation du site", $date, $date, "Quand le titre de l'événement est identique au titre de l'article, il n'est pas affiché en plus", 'Votre serveur web.');
					create_evenement("900. Agenda", "Installation du site", "Installé !", $date, $date, "Quand le titre de l'événement est différent du titre de l'article, alors, les 2 titres sont affichés.", '');
					
					$article1 = trouve_article_sc("Événement exceptionnel");
					create_article($article1, "900. Agenda");
					create_evenement("900. Agenda", "Événement exceptionnel", "Événement exceptionnel", date('Y-m-d 20:30:00'), date('Y-m-d 22:30:00'), "Quand l'heure de début est différente de l'heure de fin, c'est un événement avec une durée...", '');
					
					create_rubrique('10. SPIP', $id_rubrique);
					create_rubrique('20. Linux', $id_rubrique);
					$article1 = trouve_article_sc("Versions de SPIP ");
					create_article($article1, "10. SPIP");
					create_evenement("10. SPIP", "Versions de SPIP ", "SPIP 2.1", '2010-04-09', '2010-04-09', "[->http://www.spip.net/fr_article4728.html]", '', 'non');
					create_evenement("10. SPIP", "Versions de SPIP ", "SPIP 2.0", '2008-12-13', '2008-12-13', "[->http://www.spip.net/fr_article3784.html]", '', 'non');
				}

			}
			spip_log("SoyezCreateurs installation 2.1", "soyezcreateurs_install");
			ecrire_meta($nom_meta_base_version,$current_version='2.1','non');
		}
		if (
			(version_compare($current_version,'2.1.3','<'))
			&& // Verification que les mots clefs ont bien ete supprimes
			(sql_countsel('spip_mots', "(titre = 'NewsLetter')") != 0)
		) {
			ecrire_meta($nom_meta_base_version,$current_version='2.1','non');
			spip_log("SoyezCreateurs installation 2.1 avec mot", "soyezcreateurs_install");
		}
		if (version_compare($current_version,'2.1.1','<')) {
			// Suppresion de "_Specialisation", "Gallerie"
			$id_groupe = id_groupe("_Specialisation");
			$id_mot = id_mot("Gallerie", $id_groupe);
			if ($id_mot>0) {
				sql_delete("spip_mots", "id_mot=$id_mot");
				sql_delete("spip_mots_articles", "id_mot=$id_mot");
				sql_delete("spip_mots_rubriques", "id_mot=$id_mot");
				sql_delete("spip_mots_syndic", "id_mot=$id_mot");
				sql_delete("spip_mots_forum", "id_mot=$id_mot");
			}
			spip_log("SoyezCreateurs maj 2.1.1", "soyezcreateurs_install");
			ecrire_meta($nom_meta_base_version,$current_version='2.1.1','non');
		}
		if (version_compare($current_version,'2.1.2','<')) {
			// Suppresion de "_Specialisation_Rubrique", "NewsLetter"
			$id_groupe = id_groupe("_Specialisation_Rubrique");
			$id_mot = id_mot("NewsLetter", $id_groupe);
			if ($id_mot>0) {
				sql_delete("spip_mots", "id_mot=$id_mot");
				sql_delete("spip_mots_articles", "id_mot=$id_mot");
				sql_delete("spip_mots_rubriques", "id_mot=$id_mot");
				sql_delete("spip_mots_syndic", "id_mot=$id_mot");
				sql_delete("spip_mots_forum", "id_mot=$id_mot");
			}
			spip_log("SoyezCreateurs maj 2.1.2", "soyezcreateurs_install");
			ecrire_meta($nom_meta_base_version,$current_version='2.1.2','non');
		}
		if (version_compare($current_version,'2.1.3','<')) {
			create_mot("_Specialisation", "MenuFooter", "Affecter ce mot clef aux articles devant être affichés dans le menu de pied de page.", "Les liens vers les articles seront faits triés par numéro de titre.\n\nIl est bien sûr possible de faire des articles de redirection...");
			spip_log("SoyezCreateurs maj 2.1.3", "soyezcreateurs_install");
			ecrire_meta($nom_meta_base_version,$current_version='2.1.3','non');
		}
		if (version_compare($current_version,'2.1.4','<')) {
			ecrire_meta('image_process', 'gd2', 'non');
			ecrire_meta('btv2', 'a:1:{s:7:"avancee";s:3:"Oui";}', 'non');
			ecrire_meta('bte', 'a:14:{s:5:"puces";s:3:"Oui";s:14:"titraille1open";s:17:"<h2 class="spip">";s:15:"titraille1close";s:5:"</h2>";s:14:"titraille2open";s:17:"<h3 class="spip">";s:15:"titraille2close";s:5:"</h3>";s:14:"titraille3open";s:17:"<h4 class="spip">";s:15:"titraille3close";s:5:"</h4>";s:14:"titraille4open";s:17:"<h5 class="spip">";s:15:"titraille4close";s:5:"</h5>";s:14:"titraille5open";s:17:"<h6 class="spip">";s:15:"titraille5close";s:5:"</h6>";s:9:"insertcss";s:3:"Non";s:17:"defaultbarrestyle";s:5:"close";s:14:"mode_titraille";N;}', 'non');
			spip_log("SoyezCreateurs maj 2.1.4", "soyezcreateurs_install");
			ecrire_meta($nom_meta_base_version,$current_version='2.1.4','non');
		}
		if (version_compare($current_version,'2.1.5','<')) {
			ecrire_meta('gd_formats_read', 'gif,jpg,png', 'non');
			ecrire_meta('gd_formats', 'gif,jpg,png', 'non');
			ecrire_meta('formats_graphiques', 'gif,jpg,png', 'non');
			spip_log("SoyezCreateurs maj 2.1.5", "soyezcreateurs_install");
			ecrire_meta($nom_meta_base_version,$current_version='2.1.5','non');
		}
		if (version_compare($current_version,'2.1.6','<')) {
			create_mot("_Specialisation", "Outils", "Affecter ce mot clef aux articles devant être affichés dans le cadre Outils dans le bandeau du haut de la page.", "Les liens vers les articles seront faits triés par numéro de titre.\n\nIl est bien sûr possible de faire des articles de redirection...\n\nLe logo de l'article sera utilisé comme picto à droite du titre.");
			spip_log("SoyezCreateurs maj 2.1.6", "soyezcreateurs_install");
			ecrire_meta($nom_meta_base_version,$current_version='2.1.6','non');
		}
		if (version_compare($current_version,'2.1.7','<')) {
			spip_log("SoyezCreateurs maj 2.1.7", "soyezcreateurs_install");
			create_groupe("_Specialisation_Sites", "Groupe permettant de spécifier un rôle particulier pour des sites", "", 'non', 'non', 'non', 'non', 'non', 'oui', 'non', 'oui', 'non', 'non');
				create_mot("_Specialisation_Sites", "SaintDuJour", "Mettre ce mot clef au site donnant le Saint du jour", "");
				create_mot("_Specialisation_Sites", "PortailActualites", "Mettre ce mot clef aux sites à afficher sur le portail actualités", "En mettant un numéro point espace aux titres des sites concernés, on choisi l'ordre d'affichage.");
			$id_groupe = id_groupe("_TypeRubrique");
			if ($id_groupe>0) {
				$id_mot = id_mot("membre", $id_groupe);
				if ($id_mot>0) {
					sql_delete("spip_mots", "id_mot=$id_mot");
					sql_delete("spip_mots_articles", "id_mot=$id_mot");
					sql_delete("spip_mots_rubriques", "id_mot=$id_mot");
					sql_delete("spip_mots_syndic", "id_mot=$id_mot");
					sql_delete("spip_mots_forum", "id_mot=$id_mot");
				}
			}
			$cfg = array(
				'geolocalisation' => 'radio',
				'affichage_ephemeride' => 'radio',
				'aff_datepublication' => 'radio',
				'agendafuturseul' => 'radio',
				'affichage_lien_antichrono' => 'oui_non',
				'nouveauteparbranche' => 'oui_non',
				'activerrechercheparmots' => 'oui_non',
				'miniagenda' => 'oui_non',
				'agendathematique' => 'oui_non',
				'anonymatglobal' => 'oui_non',
				'aff_complet_pour_impression' => 'oui_non'
				);
			soyezcreateurs_changer_cfg($cfg);
			$id_rubrique = id_rubrique('000. Fourre-tout');
			if ($id_rubrique >0) {
				create_rubrique('05. Saint du jour', $id_rubrique, "Rubrique destinée à recevoir le site référencé utilisé pour l'affichage du Saint du jour.");
				$sitesdj = array();
				$sitesdj['nom_site'] = "Nominis (Saint du jour)";
				$sitesdj['url_site'] = "http://nominis.cef.fr/";
				$sitesdj['descriptif'] = "Nominis : Origine et étymologie des prénoms, des fêtes, des saints, la vie des saints.";
				$sitesdj['url_syndic'] = "http://nominis.cef.fr/rss/nominis.php";
				$id_site = create_site($sitesdj, '05. Saint du jour');
				create_site_mot($id_site, 'SaintDuJour', '_Specialisation_Sites');
			}			
			ecrire_meta($nom_meta_base_version,$current_version='2.1.7','non');
		}
		if (version_compare($current_version,'2.1.8','<')) {
			spip_log("SoyezCreateurs maj 2.1.8", "soyezcreateurs_install");
			include_spip('inc/sc_article');
			rename_rubrique("000. Racine", "000. Fourre-tout");
			$article1 = trouve_article_sc("Politique d'accessibilité du site");
				create_article($article1, "000. Fourre-tout");
				create_article_mot($article1['titre'], "000. Fourre-tout", "AccesibiliteLien", "_Specialisation");
				create_article_mot($article1['titre'], "000. Fourre-tout", "Sommaire", "_Specialisation_Rubrique_ou_Article");
			ecrire_meta($nom_meta_base_version,$current_version='2.1.8','non');
		}

		if (version_compare($current_version,'2.1.9','<')) {
			spip_log("SoyezCreateurs maj 2.1.9", "soyezcreateurs_install");
			$mentions = array('titre' => 'Mentions légales', 'texte' => '');
			$id_groupe = id_groupe("_InformationsLegales");
			if ($id_groupe>0) {
				$row = sql_select('0+titre AS num, titre, texte', 'spip_mots', "id_groupe=$id_groupe", '', 'num');
				while($r = sql_fetch($row)){
					$mentions['texte'] .= '{{{'.supprimer_numero($r['titre']).'}}}'."\n";
					$mentions['texte'] .= "\n".$r['texte']."\n\n";
				}
				$ex = "Mention légales obligatoire ([CNIL|Commision Nationale Informatique et Liberté->http://www.cnil.fr/] et [LcEN|Loi sur la confiance en l'Économie Numérique->http://www.legifrance.gouv.fr/WAspad/UnTexteDeJorf?numjo=ECOX0200175L])";
				$ex .= "\n\n[Décryptage des obligations légales->http://maitre.eolas.free.fr/journal/index.php?2005/05/27/135-responsabilite-du-blogueur].";
				create_article($mentions, "000. Fourre-tout");
				create_mot("_Specialisation", "MentionsLegales", $ex, "Affecter ce mot clef à l'article destiné à afficher les mentions légales du site.");
				create_article_mot($mentions['titre'], "000. Fourre-tout", "MentionsLegales", "_Specialisation");
				sql_delete("spip_mots", "id_groupe=$id_groupe");
				sql_delete("spip_groupes_mots", "id_groupe=$id_groupe");
			}
			ecrire_meta($nom_meta_base_version,$current_version='2.1.9','non');
		}
		if (version_compare($current_version,'2.1.10','<')) {
			spip_log("SoyezCreateurs maj 2.1.10", "soyezcreateurs_install");
			create_groupe("_HeaderBanner", "Pour définir plusieurs bannières pour le site.", "Il faut créer un mot clef par bannière (le titre n'a pas d'importance).\n\nC'est le logo du mot clef qui est utilisé comme bannière du site.\n\n{{Attention}} : si vous avez déjà défini une bannière avec le logo de survol du site, alors, cette dernière n'est plus utilisée ; seuls les logos des mots clefs de ce groupe seront pris en compte.", 'non', 'non', 'non', 'non', 'non', 'non', 'non', 'non', 'non', 'non');
			ecrire_meta($nom_meta_base_version,$current_version='2.1.10','non');
		}
		if (version_compare($current_version,'2.1.11','<')) {
			spip_log("SoyezCreateurs maj 2.1.11", "soyezcreateurs_install");
			create_mot("_Specialisation_Rubrique", "PasDansFildAriane", "Pour interdire que la rubrique soit affichée dans le fil d'ariane du site.", "Affecter ce mot clef aux rubriques qui ne doivent pas figurer dans le fil d'ariane.");
			create_rubrique_mot('000. Fourre-tout', 'PasDansFildAriane', "_Specialisation_Rubrique");
			create_rubrique_mot('999. Citations', 'PasDansFildAriane', "_Specialisation_Rubrique");
			ecrire_meta($nom_meta_base_version,$current_version='2.1.11','non');
		}
		if (version_compare($current_version,'2.1.12','<')) {
			spip_log("SoyezCreateurs maj 2.1.12", "soyezcreateurs_install");
			create_mot("_Specialisation_Sites", "NoIndex", "Pour ne pas indexer les articles syndiqués d'un site.", "Affecter ce mot clef aux sites dont les articles syndiqués ne doivent pas être affichés dans l'index des moteurs de recherche.\n\nÀ noter : les liens seront quand même suivis. But : éviter du duplicate content.\n\nVoir la documentation de Google webmaster Central sur les [Meta tags->http://www.google.com/support/webmasters/bin/answer.py?hl=en&answer=79812].");
			ecrire_meta($nom_meta_base_version,$current_version='2.1.12','non');
		}
		if (version_compare($current_version,'2.1.13','<')) {
			spip_log("SoyezCreateurs maj 2.1.13", "soyezcreateurs_install");
			create_mot("_ModePortail", "Goodies", "Affecter ce mot clef aux objets SPIP devant apparaitre dans la zone des Goodies (en bas du sommaire du mode portail, sur une colonne).", "");
			create_mot("_ModePortail", "ZoomSur", "Affecter ce mot clef à l'objet que vous voulez placer dans le cadre « Zoom sur » (facultatif).\n\nLe site prendra le dernier article ayant ce mot clef", "S'applique aux articles uniquement.");
			ecrire_meta($nom_meta_base_version,$current_version='2.1.13','non');
		}
		if (version_compare($current_version,'2.1.14','<')) {
			ecrire_meta('ppp', 'a:5:{s:14:"descriptif_ppp";s:0:"";s:9:"chapo_ppp";s:2:"on";s:6:"ps_ppp";s:2:"on";s:29:"configuration_description_ppp";s:2:"on";s:23:"auteurs_quietesvous_ppp";s:2:"on";}', 'non');
			ecrire_meta($nom_meta_base_version,$current_version='2.1.14','non');
		}
		if (version_compare($current_version,'2.1.15','<')) {
			create_mot("_Specialisation_Rubrique", "PlanLocal", "Affecter ce mot clef aux rubriques où vous voulez afficher le plan local à la place de la liste des articles.");
			ecrire_meta($nom_meta_base_version,$current_version='2.1.15','non');
		}
		if (version_compare($current_version,'3.0.0','<')) {
			// PasDansPlan devient utilisable aussi au niveau des articles
			$id_groupe_actuel = id_groupe("_Specialisation_Rubrique");
			$id_mot = id_mot("PasDansPlan", $id_groupe_actuel);
			if ($id_mot>0) {
				$id_groupe_destination = id_groupe("_Specialisation_Rubrique_ou_Article");
				sql_updateq('spip_mots', 
					array(
						'id_groupe'  => $id_groupe_destination, 
						'descriptif' => "Permet de masquer une rubrique, et tout son contenu (y compris les sous-rubriques) du plan du site et des documents à télécharger.\n\nPermet aussi de le faire article par article.",
						'texte'  => "À affecter aux rubriques ou articles qui ne doivent pas être affichés dans le plan du site et dans la liste des documents à télécharger."
						),
					'id_mot='  . intval($id_mot));
			}
			
			spip_log("SoyezCreateurs maj 3.0.0", "soyezcreateurs_install");
			ecrire_meta($nom_meta_base_version,$current_version='3.0.0','non');
		}
		if (version_compare($current_version,'3.0.1','<')) {
			// Suppression de mots non utilises par les squelettes
			supprimer_mot_groupe("_Specialisation_Rubrique", "dossier_en_avant");
			supprimer_mot_groupe("_Specialisation_Rubrique", "dossier_identite");
			supprimer_mot_groupe("_Specialisation_Rubrique", "dossier_thematique");
			supprimer_mot_groupe("_Specialisation_Rubrique", "info_pratique");
			supprimer_mot_groupe("_Specialisation_Rubrique", "membres");
			
			$f = chercher_filtre('info_plugin');
			if ($f('savecfg', 'est_actif')) {
				include_spip('inc/sauvegarder_savecfg');
				sauvegarder_savecfg('soyezcreateurs_couleurs','Violet','a:39:{s:7:"body_bk";s:7:"#a16e9e";s:6:"header";s:7:"#ffffff";s:9:"header_bk";s:7:"#664e3b";s:11:"datemajsite";s:7:"#ffffff";s:14:"datemajsite_bk";s:7:"#402816";s:6:"footer";s:7:"#ffffff";s:9:"footer_bk";s:7:"#664e3b";s:10:"navigation";s:7:"#013067";s:13:"navigation_bk";s:7:"#3fa3d7";s:8:"menuhaut";s:7:"#ffffff";s:11:"menuhaut_bk";s:7:"#a1856e";s:7:"logo_bk";s:11:"transparent";s:5:"extra";s:7:"#013067";s:8:"extra_bk";s:7:"#3fa3d7";s:6:"menu_a";s:7:"#ffffff";s:9:"menu_a_bk";s:7:"#5599cd";s:12:"menu_a_hover";s:7:"#ffffff";s:15:"menu_a_hover_bk";s:7:"#66aade";s:13:"menu_a_active";s:7:"#5599cd";s:16:"menu_a_active_bk";s:7:"#ffffff";s:13:"menu_a_strong";s:7:"#013067";s:16:"menu_a_strong_bk";s:7:"#ffffff";s:12:"vignettes_bk";s:7:"#3fa3d7";s:9:"container";s:7:"#013067";s:12:"container_bk";s:7:"#ffffff";s:9:"titraille";s:7:"#013067";s:12:"titraille_bk";s:7:"#a6cbec";s:4:"link";s:7:"#5599cd";s:7:"visited";s:7:"#66aade";s:5:"hover";s:7:"#a1856e";s:6:"active";s:7:"#402816";s:15:"fontsnavigation";s:34:"Verdana, Arial, Geneva, sans-serif";s:12:"fontscontent";s:34:"Verdana, Arial, Geneva, sans-serif";s:14:"fontsizeheader";s:3:"1.2";s:14:"fontsizefooter";s:3:"1.2";s:18:"fontsizenavigation";s:3:"1.2";s:15:"fontsizecontenu";s:3:"1.2";s:13:"autovignettes";s:4:"auto";s:17:"fontsizevignettes";s:2:"16";}');
				sauvegarder_savecfg('soyezcreateurs_couleurs','Bleu & marron ','a:35:{s:7:"body_bk";s:7:"#d2e0eb";s:6:"header";s:4:"#fff";s:9:"header_bk";s:7:"#7c4617";s:11:"datemajsite";s:7:"#ffffff";s:14:"datemajsite_bk";s:7:"#7c4617";s:6:"footer";s:7:"#ffffff";s:9:"footer_bk";s:7:"#7c4617";s:10:"navigation";s:7:"#7c4617";s:13:"navigation_bk";s:7:"#d2e0eb";s:7:"logo_bk";s:11:"transparent";s:5:"extra";s:7:"#7c4617";s:8:"extra_bk";s:7:"#ffffff";s:6:"menu_a";s:7:"#7c4617";s:9:"menu_a_bk";s:7:"#d2e0eb";s:12:"menu_a_hover";s:7:"#ffffff";s:15:"menu_a_hover_bk";s:7:"#7c4617";s:13:"menu_a_active";s:7:"#7c4617";s:16:"menu_a_active_bk";s:7:"#ffffff";s:13:"menu_a_strong";s:7:"#7c4617";s:16:"menu_a_strong_bk";s:7:"#b7cde1";s:9:"container";s:7:"#321d0b";s:12:"container_bk";s:7:"#ffffff";s:9:"titraille";s:7:"#7c4617";s:12:"titraille_bk";s:7:"#b7cde1";s:4:"link";s:7:"#273e54";s:7:"visited";s:7:"#321d0b";s:5:"hover";s:7:"#7c4617";s:6:"active";s:7:"#321d0b";s:15:"fontsnavigation";s:31:""Times New Roman", Times, serif";s:12:"fontscontent";s:34:"Verdana, Arial, Geneva, sans-serif";s:14:"fontsizeheader";s:3:"1.4";s:14:"fontsizefooter";s:3:"1.3";s:18:"fontsizenavigation";s:3:"1.5";s:15:"fontsizecontenu";s:3:"1.2";s:12:"vignettes_bk";s:7:"#9dba00";}');
				sauvegarder_savecfg('soyezcreateurs_couleurs','Vert anis','a:54:{s:7:"body_bk";s:7:"#e5eacc";s:6:"header";s:7:"#005500";s:9:"header_bk";s:7:"#c5e41c";s:11:"datemajsite";s:7:"#ffffff";s:14:"datemajsite_bk";s:7:"#7d9a00";s:6:"footer";s:7:"#c5e41c";s:9:"footer_bk";s:7:"#7d9a00";s:10:"navigation";s:7:"#005500";s:13:"navigation_bk";s:7:"#c5e41c";s:7:"logo_bk";s:11:"transparent";s:5:"extra";s:7:"#005500";s:8:"extra_bk";s:7:"#c5e41c";s:6:"menu_a";s:7:"#ffffff";s:9:"menu_a_bk";s:7:"#7d9a00";s:12:"menu_a_hover";s:7:"#ffffff";s:15:"menu_a_hover_bk";s:7:"#9dba00";s:13:"menu_a_active";s:7:"#7d9a00";s:16:"menu_a_active_bk";s:7:"#ffffff";s:13:"menu_a_strong";s:7:"#ff8800";s:16:"menu_a_strong_bk";s:7:"#ffffff";s:9:"container";s:7:"#3e4d00";s:12:"container_bk";s:7:"#ffffff";s:9:"titraille";s:7:"#7d9a00";s:12:"titraille_bk";s:7:"#c5e41c";s:4:"link";s:7:"#7d9a00";s:7:"visited";s:7:"#9dba00";s:5:"hover";s:7:"#ff8c00";s:6:"active";s:7:"#b672a3";s:15:"fontsnavigation";s:34:"Verdana, Arial, Geneva, sans-serif";s:12:"fontscontent";s:34:"Verdana, Arial, Geneva, sans-serif";s:14:"fontsizeheader";s:3:"1.2";s:14:"fontsizefooter";s:3:"1.2";s:18:"fontsizenavigation";s:3:"1.2";s:15:"fontsizecontenu";s:3:"1.2";s:12:"vignettes_bk";s:7:"#9dba00";s:12:"body_degrade";N;s:14:"footer_degrade";N;s:8:"menuhaut";s:7:"#005500";s:11:"menuhaut_bk";s:7:"#c5e41c";s:16:"menuhaut_degrade";N;s:17:"cadreinfo_degrade";N;s:17:"citations_degrade";N;s:17:"cartouche_degrade";N;s:17:"titraille_degrade";N;s:19:"titraille_ssniveaux";s:7:"#7d9a00";s:22:"titraille_ssniveaux_bk";s:7:"#3e4d00";s:11:"cadrestexte";s:7:"#3e4d00";s:14:"cadrestexte_bk";s:7:"#c5e41c";s:13:"header_lettre";s:7:"#005500";s:16:"header_lettre_bk";s:7:"#c5e41c";s:16:"titraille_lettre";s:7:"#7d9a00";s:18:"fontsizeartrecents";s:1:"1";s:13:"autovignettes";s:4:"auto";s:17:"fontsizevignettes";s:2:"16";}');
				sauvegarder_savecfg('soyezcreateurs_couleurs','Rouge bordeaux','a:54:{s:7:"body_bk";s:7:"#872D3F";s:6:"header";s:7:"#F8F2EC";s:9:"header_bk";s:7:"#872D3F";s:11:"datemajsite";s:7:"#872D3F";s:14:"datemajsite_bk";s:7:"#F8F2EC";s:6:"footer";s:7:"#F8F2EC";s:9:"footer_bk";s:7:"#872D3F";s:10:"navigation";s:7:"#F8F2EC";s:13:"navigation_bk";s:7:"#872D3F";s:8:"menuhaut";s:7:"#F8F2EC";s:11:"menuhaut_bk";s:11:"transparent";s:7:"logo_bk";s:7:"#872D3F";s:5:"extra";s:7:"#F8F2EC";s:8:"extra_bk";s:7:"#872D3F";s:6:"menu_a";s:7:"#F8F2EC";s:9:"menu_a_bk";s:7:"#872D3F";s:12:"menu_a_hover";s:7:"#8edbf6";s:15:"menu_a_hover_bk";s:7:"#872D3F";s:13:"menu_a_active";s:7:"#F8F2EC";s:16:"menu_a_active_bk";s:7:"#872D3F";s:13:"menu_a_strong";s:7:"#8edbf6";s:16:"menu_a_strong_bk";s:7:"#872D3F";s:12:"vignettes_bk";s:7:"#872D3F";s:9:"container";s:7:"#872D3F";s:12:"container_bk";s:7:"#F8F2EC";s:9:"titraille";s:7:"#6c3742";s:12:"titraille_bk";s:7:"#F8F2EC";s:4:"link";s:7:"#872D3F";s:7:"visited";s:7:"#6c3742";s:5:"hover";s:7:"#6c3742";s:6:"active";s:7:"#6c3742";s:15:"fontsnavigation";s:34:"Verdana, Arial, Geneva, sans-serif";s:12:"fontscontent";s:34:"Verdana, Arial, Geneva, sans-serif";s:14:"fontsizeheader";s:3:"1.0";s:14:"fontsizefooter";s:3:"1.2";s:18:"fontsizenavigation";s:3:"1.2";s:15:"fontsizecontenu";s:3:"1.2";s:18:"fontsizeartrecents";s:3:"1.2";s:13:"autovignettes";s:4:"auto";s:17:"fontsizevignettes";s:2:"16";s:12:"body_degrade";N;s:14:"footer_degrade";N;s:16:"menuhaut_degrade";N;s:17:"cadreinfo_degrade";N;s:17:"citations_degrade";N;s:17:"cartouche_degrade";N;s:17:"titraille_degrade";N;s:19:"titraille_ssniveaux";s:7:"#6c3742";s:22:"titraille_ssniveaux_bk";s:7:"#872D3F";s:11:"cadrestexte";s:7:"#872D3F";s:14:"cadrestexte_bk";s:7:"#F8F2EC";s:13:"header_lettre";s:7:"#F8F2EC";s:16:"header_lettre_bk";s:7:"#872D3F";s:16:"titraille_lettre";s:7:"#6c3742";}');
				sauvegarder_savecfg('soyezcreateurs_couleurs','(Par défaut)','a:54:{s:7:"body_bk";s:7:"#a1856e";s:6:"header";s:7:"#ffffff";s:9:"header_bk";s:7:"#664e3b";s:11:"datemajsite";s:7:"#ffffff";s:14:"datemajsite_bk";s:7:"#402816";s:6:"footer";s:7:"#ffffff";s:9:"footer_bk";s:7:"#664e3b";s:10:"navigation";s:7:"#013067";s:13:"navigation_bk";s:7:"#3fa3d7";s:8:"menuhaut";s:7:"#ffffff";s:11:"menuhaut_bk";s:7:"#a1856e";s:7:"logo_bk";s:11:"transparent";s:5:"extra";s:7:"#013067";s:8:"extra_bk";s:7:"#3fa3d7";s:6:"menu_a";s:7:"#ffffff";s:9:"menu_a_bk";s:7:"#5599cd";s:12:"menu_a_hover";s:7:"#ffffff";s:15:"menu_a_hover_bk";s:7:"#66aade";s:13:"menu_a_active";s:7:"#5599cd";s:16:"menu_a_active_bk";s:7:"#ffffff";s:13:"menu_a_strong";s:7:"#013067";s:16:"menu_a_strong_bk";s:7:"#ffffff";s:12:"vignettes_bk";s:7:"#3fa3d7";s:9:"container";s:7:"#013067";s:12:"container_bk";s:7:"#ffffff";s:9:"titraille";s:7:"#013067";s:12:"titraille_bk";s:7:"#a6cbec";s:4:"link";s:7:"#5599cd";s:7:"visited";s:7:"#66aade";s:5:"hover";s:7:"#a1856e";s:6:"active";s:7:"#402816";s:15:"fontsnavigation";s:34:"Verdana, Arial, Geneva, sans-serif";s:12:"fontscontent";s:34:"Verdana, Arial, Geneva, sans-serif";s:14:"fontsizeheader";s:3:"1.2";s:14:"fontsizefooter";s:3:"1.2";s:18:"fontsizenavigation";s:3:"1.2";s:15:"fontsizecontenu";s:3:"1.2";s:13:"autovignettes";s:4:"auto";s:17:"fontsizevignettes";s:2:"16";s:12:"body_degrade";N;s:14:"footer_degrade";N;s:16:"menuhaut_degrade";N;s:17:"cadreinfo_degrade";N;s:17:"citations_degrade";N;s:17:"cartouche_degrade";N;s:17:"titraille_degrade";N;s:19:"titraille_ssniveaux";s:7:"#013067";s:22:"titraille_ssniveaux_bk";s:7:"#a6cbec";s:11:"cadrestexte";s:7:"#002652";s:14:"cadrestexte_bk";s:7:"#e4eff9";s:13:"header_lettre";s:7:"#ffffff";s:16:"header_lettre_bk";s:7:"#664e3b";s:16:"titraille_lettre";s:7:"#013067";s:18:"fontsizeartrecents";s:1:"1";}');
				sauvegarder_savecfg('soyezcreateurs_couleurs','Bleu & orange','a:54:{s:7:"body_bk";s:7:"#6e73a1";s:6:"header";s:7:"#ffb014";s:9:"header_bk";s:7:"#3b4266";s:11:"datemajsite";s:7:"#ffffff";s:14:"datemajsite_bk";s:7:"#161e40";s:6:"footer";s:7:"#ffffff";s:9:"footer_bk";s:7:"#3b4066";s:10:"navigation";s:7:"#674d01";s:13:"navigation_bk";s:7:"#cda555";s:8:"menuhaut";s:7:"#ffffff";s:11:"menuhaut_bk";s:7:"#6e7aa1";s:7:"logo_bk";s:11:"transparent";s:5:"extra";s:7:"#674401";s:8:"extra_bk";s:7:"#cda555";s:6:"menu_a";s:7:"#ffffff";s:9:"menu_a_bk";s:7:"#d79c3f";s:12:"menu_a_hover";s:7:"#ffffff";s:15:"menu_a_hover_bk";s:7:"#deb566";s:13:"menu_a_active";s:7:"#cda955";s:16:"menu_a_active_bk";s:7:"#ffffff";s:13:"menu_a_strong";s:7:"#674f01";s:16:"menu_a_strong_bk";s:7:"#d4dcf2";s:12:"vignettes_bk";s:7:"#d7b23f";s:9:"container";s:7:"#674701";s:12:"container_bk";s:7:"#e1e3f4";s:9:"titraille";s:7:"#674c01";s:12:"titraille_bk";s:7:"#eccea6";s:4:"link";s:7:"#cda355";s:7:"visited";s:7:"#deb566";s:5:"hover";s:7:"#6e79a1";s:6:"active";s:7:"#aa8a41";s:15:"fontsnavigation";s:34:"Verdana, Arial, Geneva, sans-serif";s:12:"fontscontent";s:34:"Verdana, Arial, Geneva, sans-serif";s:14:"fontsizeheader";s:3:"1.2";s:14:"fontsizefooter";s:3:"1.2";s:18:"fontsizenavigation";s:3:"1.2";s:15:"fontsizecontenu";s:3:"1.2";s:18:"fontsizeartrecents";s:1:"1";s:13:"autovignettes";s:4:"auto";s:17:"fontsizevignettes";s:2:"16";s:12:"body_degrade";N;s:14:"footer_degrade";N;s:16:"menuhaut_degrade";N;s:17:"cadreinfo_degrade";N;s:17:"citations_degrade";N;s:17:"cartouche_degrade";N;s:17:"titraille_degrade";N;s:19:"titraille_ssniveaux";s:7:"#013067";s:22:"titraille_ssniveaux_bk";s:7:"#a6cbec";s:11:"cadrestexte";s:7:"#002652";s:14:"cadrestexte_bk";s:7:"#f9f2e4";s:13:"header_lettre";s:7:"#ffb014";s:16:"header_lettre_bk";s:7:"#3b4266";s:16:"titraille_lettre";s:7:"#013067";}');
				sauvegarder_savecfg('soyezcreateurs_couleurs','Bleu blanc rouge','a:54:{s:7:"body_bk";s:7:"#6e74a1";s:6:"header";s:7:"#000000";s:9:"header_bk";s:7:"#ffffff";s:11:"datemajsite";s:7:"#ffffff";s:14:"datemajsite_bk";s:7:"#ce6f69";s:6:"footer";s:7:"#ffffff";s:9:"footer_bk";s:7:"#3b3d66";s:10:"navigation";s:7:"#013067";s:13:"navigation_bk";s:7:"#f7eded";s:8:"menuhaut";s:7:"#ffffff";s:11:"menuhaut_bk";s:7:"#cf3c3a";s:7:"logo_bk";s:11:"transparent";s:5:"extra";s:7:"#013067";s:8:"extra_bk";s:7:"#f7eded";s:6:"menu_a";s:7:"#000000";s:9:"menu_a_bk";s:7:"#ffffff";s:12:"menu_a_hover";s:7:"#000000";s:15:"menu_a_hover_bk";s:7:"#de6c66";s:13:"menu_a_active";s:7:"#ffffff";s:16:"menu_a_active_bk";s:7:"#e5bdbd";s:13:"menu_a_strong";s:7:"#670301";s:16:"menu_a_strong_bk";s:7:"#ffffff";s:12:"vignettes_bk";s:7:"#3b3d66";s:9:"container";s:7:"#013067";s:12:"container_bk";s:7:"#7eb4ce";s:9:"titraille";s:7:"#013067";s:12:"titraille_bk";s:7:"#e9bdba";s:4:"link";s:7:"#cd5559";s:7:"visited";s:7:"#de666a";s:5:"hover";s:7:"#a16f6e";s:6:"active";s:7:"#6a2526";s:15:"fontsnavigation";s:34:"Verdana, Arial, Geneva, sans-serif";s:12:"fontscontent";s:34:"Verdana, Arial, Geneva, sans-serif";s:14:"fontsizeheader";s:3:"1.2";s:14:"fontsizefooter";s:3:"1.2";s:18:"fontsizenavigation";s:3:"1.2";s:15:"fontsizecontenu";s:3:"1.2";s:18:"fontsizeartrecents";s:1:"1";s:13:"autovignettes";s:4:"auto";s:17:"fontsizevignettes";s:2:"16";s:12:"body_degrade";N;s:14:"footer_degrade";N;s:16:"menuhaut_degrade";N;s:17:"cadreinfo_degrade";N;s:17:"citations_degrade";N;s:17:"cartouche_degrade";N;s:17:"titraille_degrade";N;s:19:"titraille_ssniveaux";s:7:"#013067";s:22:"titraille_ssniveaux_bk";s:7:"#a6cbec";s:11:"cadrestexte";s:7:"#002652";s:14:"cadrestexte_bk";s:7:"#e4eff9";s:13:"header_lettre";s:7:"#000000";s:16:"header_lettre_bk";s:7:"#ffffff";s:16:"titraille_lettre";s:7:"#013067";}');
				sauvegarder_savecfg('soyezcreateurs_couleurs','Gris & jaune','a:54:{s:7:"body_bk";s:7:"#828282";s:6:"header";s:7:"#e03838";s:9:"header_bk";s:7:"#504f4e";s:11:"datemajsite";s:7:"#ffffff";s:14:"datemajsite_bk";s:7:"#262626";s:6:"footer";s:7:"#ffffff";s:9:"footer_bk";s:7:"#504f4e";s:10:"navigation";s:7:"#676001";s:13:"navigation_bk";s:7:"#d7d13f";s:8:"menuhaut";s:7:"#ffffff";s:11:"menuhaut_bk";s:7:"#a19e6e";s:7:"logo_bk";s:11:"transparent";s:5:"extra";s:7:"#675e01";s:8:"extra_bk";s:7:"#d7c63f";s:6:"menu_a";s:7:"#ffffff";s:9:"menu_a_bk";s:7:"#cdc655";s:12:"menu_a_hover";s:7:"#ffffff";s:15:"menu_a_hover_bk";s:7:"#ded766";s:13:"menu_a_active";s:7:"#8c8c87";s:16:"menu_a_active_bk";s:7:"#ffffff";s:13:"menu_a_strong";s:7:"#2f2f2d";s:16:"menu_a_strong_bk";s:7:"#f5f3e0";s:12:"vignettes_bk";s:7:"#d7c93f";s:9:"container";s:7:"#383838";s:12:"container_bk";s:7:"#f5f3e0";s:9:"titraille";s:7:"#313335";s:12:"titraille_bk";s:7:"#ece7a6";s:4:"link";s:7:"#8f8f8f";s:7:"visited";s:7:"#9fa1a3";s:5:"hover";s:7:"#868483";s:6:"active";s:7:"#272726";s:15:"fontsnavigation";s:34:"Verdana, Arial, Geneva, sans-serif";s:12:"fontscontent";s:34:"Verdana, Arial, Geneva, sans-serif";s:14:"fontsizeheader";s:3:"1.2";s:14:"fontsizefooter";s:3:"1.2";s:18:"fontsizenavigation";s:3:"1.2";s:15:"fontsizecontenu";s:3:"1.2";s:18:"fontsizeartrecents";s:1:"1";s:13:"autovignettes";s:4:"auto";s:17:"fontsizevignettes";s:2:"16";s:12:"body_degrade";N;s:14:"footer_degrade";N;s:16:"menuhaut_degrade";N;s:17:"cadreinfo_degrade";N;s:17:"citations_degrade";N;s:17:"cartouche_degrade";N;s:17:"titraille_degrade";N;s:19:"titraille_ssniveaux";s:7:"#013067";s:22:"titraille_ssniveaux_bk";s:7:"#c5cace";s:11:"cadrestexte";s:7:"#002652";s:14:"cadrestexte_bk";s:7:"#dadbdc";s:13:"header_lettre";s:7:"#e03838";s:16:"header_lettre_bk";s:7:"#504f4e";s:16:"titraille_lettre";s:7:"#013067";}');
				sauvegarder_savecfg('soyezcreateurs_couleurs','Noir & blanc','a:54:{s:7:"body_bk";s:7:"#ffffff";s:6:"header";s:7:"#ffffff";s:9:"header_bk";s:7:"#312f2f";s:11:"datemajsite";s:7:"#ffffff";s:14:"datemajsite_bk";s:7:"#000000";s:6:"footer";s:7:"#ffffff";s:9:"footer_bk";s:7:"#000000";s:10:"navigation";s:7:"#000000";s:13:"navigation_bk";s:7:"#9e9a9b";s:8:"menuhaut";s:7:"#ffffff";s:11:"menuhaut_bk";s:7:"#000000";s:7:"logo_bk";s:11:"transparent";s:5:"extra";s:7:"#000000";s:8:"extra_bk";s:7:"#9e9a9b";s:6:"menu_a";s:7:"#ffffff";s:9:"menu_a_bk";s:7:"#000000";s:12:"menu_a_hover";s:7:"#000000";s:15:"menu_a_hover_bk";s:7:"#ffffff";s:13:"menu_a_active";s:7:"#000000";s:16:"menu_a_active_bk";s:7:"#ffffff";s:13:"menu_a_strong";s:7:"#000000";s:16:"menu_a_strong_bk";s:7:"#ffffff";s:12:"vignettes_bk";s:7:"#000000";s:9:"container";s:7:"#000000";s:12:"container_bk";s:7:"#dedede";s:9:"titraille";s:7:"#000000";s:12:"titraille_bk";s:7:"#9e9a9b";s:4:"link";s:7:"#000000";s:7:"visited";s:7:"#9e9a9b";s:5:"hover";s:7:"#000000";s:6:"active";s:7:"#000000";s:15:"fontsnavigation";s:34:"Verdana, Arial, Geneva, sans-serif";s:12:"fontscontent";s:34:"Verdana, Arial, Geneva, sans-serif";s:14:"fontsizeheader";s:3:"1.2";s:14:"fontsizefooter";s:3:"1.2";s:18:"fontsizenavigation";s:3:"1.2";s:15:"fontsizecontenu";s:3:"1.2";s:18:"fontsizeartrecents";s:1:"1";s:13:"autovignettes";s:4:"auto";s:17:"fontsizevignettes";s:2:"16";s:12:"body_degrade";N;s:14:"footer_degrade";N;s:16:"menuhaut_degrade";N;s:17:"cadreinfo_degrade";N;s:17:"citations_degrade";N;s:17:"cartouche_degrade";N;s:17:"titraille_degrade";N;s:19:"titraille_ssniveaux";s:7:"#000000";s:22:"titraille_ssniveaux_bk";s:7:"#ffffff";s:11:"cadrestexte";s:7:"#000000";s:14:"cadrestexte_bk";s:7:"#ffffff";s:13:"header_lettre";s:7:"#ffffff";s:16:"header_lettre_bk";s:7:"#000000";s:16:"titraille_lettre";s:7:"#000000";}');
				sauvegarder_savecfg('soyezcreateurs_couleurs','Pastel bleu','a:54:{s:7:"body_bk";s:7:"#ffffff";s:6:"header";s:7:"#94abe0";s:9:"header_bk";s:7:"#ebe8e5";s:11:"datemajsite";s:7:"#96abe3";s:14:"datemajsite_bk";s:7:"#e3ddd9";s:6:"footer";s:7:"#9bb3df";s:9:"footer_bk";s:7:"#e9e5e2";s:10:"navigation";s:7:"#4a9cfc";s:13:"navigation_bk";s:7:"#d2e8f4";s:8:"menuhaut";s:7:"#9db2e1";s:11:"menuhaut_bk";s:7:"#ebe5e0";s:7:"logo_bk";s:11:"transparent";s:5:"extra";s:7:"#3e94f9";s:8:"extra_bk";s:7:"#c3e3f3";s:6:"menu_a";s:7:"#1a2d65";s:9:"menu_a_bk";s:7:"#d5e5f1";s:12:"menu_a_hover";s:7:"#293366";s:15:"menu_a_hover_bk";s:7:"#c1dcf0";s:13:"menu_a_active";s:7:"#83b4d8";s:16:"menu_a_active_bk";s:7:"#ffffff";s:13:"menu_a_strong";s:7:"#3b95fc";s:16:"menu_a_strong_bk";s:7:"#ffffff";s:12:"vignettes_bk";s:7:"#bcdff1";s:9:"container";s:7:"#4d9cf9";s:12:"container_bk";s:7:"#ffffff";s:9:"titraille";s:7:"#5ba5fb";s:12:"titraille_bk";s:7:"#e6f0fa";s:4:"link";s:7:"#77add4";s:7:"visited";s:7:"#7db5e3";s:5:"hover";s:7:"#a18872";s:6:"active";s:7:"#cc8f61";s:15:"fontsnavigation";s:34:"Verdana, Arial, Geneva, sans-serif";s:12:"fontscontent";s:34:"Verdana, Arial, Geneva, sans-serif";s:14:"fontsizeheader";s:3:"1.2";s:14:"fontsizefooter";s:3:"1.2";s:18:"fontsizenavigation";s:3:"1.2";s:15:"fontsizecontenu";s:3:"1.2";s:18:"fontsizeartrecents";s:1:"1";s:13:"autovignettes";s:4:"auto";s:17:"fontsizevignettes";s:2:"16";s:12:"body_degrade";N;s:14:"footer_degrade";N;s:16:"menuhaut_degrade";N;s:17:"cadreinfo_degrade";N;s:17:"citations_degrade";N;s:17:"cartouche_degrade";N;s:17:"titraille_degrade";N;s:19:"titraille_ssniveaux";s:7:"#013067";s:22:"titraille_ssniveaux_bk";s:7:"#a6cbec";s:11:"cadrestexte";s:7:"#002652";s:14:"cadrestexte_bk";s:7:"#e4eff9";s:13:"header_lettre";s:7:"#94abe0";s:16:"header_lettre_bk";s:7:"#ebe8e5";s:16:"titraille_lettre";s:7:"#013067";}');
				sauvegarder_savecfg('soyezcreateurs_couleurs','Pastel ocre','a:54:{s:7:"body_bk";s:7:"#e4ba86";s:6:"header";s:7:"#e4ab72";s:9:"header_bk";s:7:"#664e3b";s:11:"datemajsite";s:7:"#ffffff";s:14:"datemajsite_bk";s:7:"#402816";s:6:"footer";s:7:"#ffffff";s:9:"footer_bk";s:7:"#664e3b";s:10:"navigation";s:7:"#e17b14";s:13:"navigation_bk";s:7:"#bea68e";s:8:"menuhaut";s:7:"#ffffff";s:11:"menuhaut_bk";s:7:"#a1856e";s:7:"logo_bk";s:11:"transparent";s:5:"extra";s:7:"#e17b14";s:8:"extra_bk";s:7:"#bea68e";s:6:"menu_a";s:7:"#ffffff";s:9:"menu_a_bk";s:7:"#cd9a55";s:12:"menu_a_hover";s:7:"#ffffff";s:15:"menu_a_hover_bk";s:7:"#deb466";s:13:"menu_a_active";s:7:"#cd8f55";s:16:"menu_a_active_bk";s:7:"#eadecd";s:13:"menu_a_strong";s:7:"#000000";s:16:"menu_a_strong_bk";s:7:"#e9e1d3";s:12:"vignettes_bk";s:7:"#d78d3f";s:9:"container";s:7:"#673901";s:12:"container_bk";s:7:"#f9f3e4";s:9:"titraille";s:7:"#673601";s:12:"titraille_bk";s:7:"#ecd2a6";s:4:"link";s:7:"#cd9a55";s:7:"visited";s:7:"#dea466";s:5:"hover";s:7:"#a1926e";s:6:"active";s:7:"#403016";s:15:"fontsnavigation";s:34:"Verdana, Arial, Geneva, sans-serif";s:12:"fontscontent";s:34:"Verdana, Arial, Geneva, sans-serif";s:14:"fontsizeheader";s:3:"1.2";s:14:"fontsizefooter";s:3:"1.2";s:18:"fontsizenavigation";s:3:"1.2";s:15:"fontsizecontenu";s:3:"1.2";s:18:"fontsizeartrecents";s:1:"1";s:13:"autovignettes";s:4:"auto";s:17:"fontsizevignettes";s:2:"16";s:12:"body_degrade";N;s:14:"footer_degrade";N;s:16:"menuhaut_degrade";N;s:17:"cadreinfo_degrade";N;s:17:"citations_degrade";N;s:17:"cartouche_degrade";N;s:17:"titraille_degrade";N;s:19:"titraille_ssniveaux";s:7:"#673f01";s:22:"titraille_ssniveaux_bk";s:7:"#eccea6";s:11:"cadrestexte";s:7:"#523000";s:14:"cadrestexte_bk";s:7:"#f9f3e4";s:13:"header_lettre";s:7:"#e4ab72";s:16:"header_lettre_bk";s:7:"#664e3b";s:16:"titraille_lettre";s:7:"#673601";}');
				sauvegarder_savecfg('soyezcreateurs_couleurs','Rouge & jaune','a:54:{s:7:"body_bk";s:7:"#efca6c";s:6:"header";s:7:"#ffffff";s:9:"header_bk";s:7:"#a71716";s:11:"datemajsite";s:7:"#ffffff";s:14:"datemajsite_bk";s:7:"#881114";s:6:"footer";s:7:"#ffffff";s:9:"footer_bk";s:7:"#881114";s:10:"navigation";s:7:"#e3d98c";s:13:"navigation_bk";s:7:"#853839";s:8:"menuhaut";s:7:"#ffffff";s:11:"menuhaut_bk";s:7:"#853839";s:7:"logo_bk";s:11:"transparent";s:5:"extra";s:7:"#ffffff";s:8:"extra_bk";s:7:"#853839";s:6:"menu_a";s:7:"#ffffff";s:9:"menu_a_bk";s:7:"#cd7113";s:12:"menu_a_hover";s:7:"#ffffff";s:15:"menu_a_hover_bk";s:7:"#c1103b";s:13:"menu_a_active";s:7:"#000000";s:16:"menu_a_active_bk";s:7:"#ffffff";s:13:"menu_a_strong";s:7:"#c32234";s:16:"menu_a_strong_bk";s:7:"#ffffff";s:12:"vignettes_bk";s:7:"#ffffff";s:9:"container";s:7:"#c32234";s:12:"container_bk";s:7:"#f7e8d9";s:9:"titraille";s:7:"#c32234";s:12:"titraille_bk";s:7:"#efca6c";s:4:"link";s:7:"#ec3927";s:7:"visited";s:7:"#ec3927";s:5:"hover";s:7:"#da552f";s:6:"active";s:7:"#a7432f";s:15:"fontsnavigation";s:34:"Verdana, Arial, Geneva, sans-serif";s:12:"fontscontent";s:34:"Verdana, Arial, Geneva, sans-serif";s:14:"fontsizeheader";s:3:"1.2";s:14:"fontsizefooter";s:3:"1.2";s:18:"fontsizenavigation";s:3:"1.2";s:15:"fontsizecontenu";s:3:"1.2";s:18:"fontsizeartrecents";s:1:"1";s:13:"autovignettes";s:4:"auto";s:17:"fontsizevignettes";s:2:"16";s:12:"body_degrade";N;s:14:"footer_degrade";N;s:16:"menuhaut_degrade";N;s:17:"cadreinfo_degrade";N;s:17:"citations_degrade";N;s:17:"cartouche_degrade";N;s:17:"titraille_degrade";N;s:19:"titraille_ssniveaux";s:7:"#674b01";s:22:"titraille_ssniveaux_bk";s:7:"#ecaaa6";s:11:"cadrestexte";s:7:"#523100";s:14:"cadrestexte_bk";s:7:"#f9e4e4";s:13:"header_lettre";s:7:"#ffffff";s:16:"header_lettre_bk";s:7:"#a71716";s:16:"titraille_lettre";s:7:"#c32234";}');
				sauvegarder_savecfg('soyezcreateurs_couleurs','Vert été','a:54:{s:7:"body_bk";s:7:"#d0ef6c";s:6:"header";s:7:"#f1f7d9";s:9:"header_bk";s:7:"#25a716";s:11:"datemajsite";s:7:"#ffffff";s:14:"datemajsite_bk";s:7:"#1f8811";s:6:"footer";s:7:"#ffffff";s:9:"footer_bk";s:7:"#148811";s:10:"navigation";s:7:"#bce38c";s:13:"navigation_bk";s:7:"#3d8538";s:8:"menuhaut";s:7:"#ffffff";s:11:"menuhaut_bk";s:7:"#38853d";s:7:"logo_bk";s:11:"transparent";s:5:"extra";s:7:"#ffffff";s:8:"extra_bk";s:7:"#38853d";s:6:"menu_a";s:7:"#ffffff";s:9:"menu_a_bk";s:7:"#3d8538";s:12:"menu_a_hover";s:7:"#ffffff";s:15:"menu_a_hover_bk";s:7:"#12c110";s:13:"menu_a_active";s:7:"#000000";s:16:"menu_a_active_bk";s:7:"#ffffff";s:13:"menu_a_strong";s:7:"#29c322";s:16:"menu_a_strong_bk";s:7:"#ffffff";s:12:"vignettes_bk";s:7:"#ffffff";s:9:"container";s:7:"#25c322";s:12:"container_bk";s:7:"#f1f7d9";s:9:"titraille";s:7:"#22c324";s:12:"titraille_bk";s:7:"#c4ef6c";s:4:"link";s:7:"#32ec27";s:7:"visited";s:7:"#27ec27";s:5:"hover";s:7:"#34da2f";s:6:"active";s:7:"#32a72f";s:15:"fontsnavigation";s:34:"Verdana, Arial, Geneva, sans-serif";s:12:"fontscontent";s:34:"Verdana, Arial, Geneva, sans-serif";s:14:"fontsizeheader";s:3:"1.2";s:14:"fontsizefooter";s:3:"1.2";s:18:"fontsizenavigation";s:3:"1.2";s:15:"fontsizecontenu";s:3:"1.2";s:18:"fontsizeartrecents";s:1:"1";s:13:"autovignettes";s:4:"auto";s:17:"fontsizevignettes";s:2:"16";s:12:"body_degrade";N;s:14:"footer_degrade";N;s:16:"menuhaut_degrade";N;s:17:"cadreinfo_degrade";N;s:17:"citations_degrade";N;s:17:"cartouche_degrade";N;s:17:"titraille_degrade";N;s:19:"titraille_ssniveaux";s:7:"#01673e";s:22:"titraille_ssniveaux_bk";s:7:"#a6eccd";s:11:"cadrestexte";s:7:"#002652";s:14:"cadrestexte_bk";s:7:"#f6f9e4";s:13:"header_lettre";s:7:"#f1f7d9";s:16:"header_lettre_bk";s:7:"#25a716";s:16:"titraille_lettre";s:7:"#01673e";}');
				sauvegarder_savecfg('soyezcreateurs_couleurs','Violet & vert','a:54:{s:7:"body_bk";s:7:"#9ed897";s:6:"header";s:7:"#ffffff";s:9:"header_bk";s:7:"#663b62";s:11:"datemajsite";s:7:"#ffffff";s:14:"datemajsite_bk";s:7:"#164017";s:6:"footer";s:7:"#ffffff";s:9:"footer_bk";s:7:"#663b64";s:10:"navigation";s:7:"#c982c2";s:13:"navigation_bk";s:7:"#69c975";s:8:"menuhaut";s:7:"#ffffff";s:11:"menuhaut_bk";s:7:"#70a16e";s:7:"logo_bk";s:11:"transparent";s:5:"extra";s:7:"#8a0f81";s:8:"extra_bk";s:7:"#69c975";s:6:"menu_a";s:7:"#af12a2";s:9:"menu_a_bk";s:7:"#f6daf5";s:12:"menu_a_hover";s:7:"#a4569f";s:15:"menu_a_hover_bk";s:7:"#61b757";s:13:"menu_a_active";s:7:"#cd55c7";s:16:"menu_a_active_bk";s:7:"#ffffff";s:13:"menu_a_strong";s:7:"#670165";s:16:"menu_a_strong_bk";s:7:"#ffffff";s:12:"vignettes_bk";s:7:"#663b62";s:9:"container";s:7:"#cc6cd0";s:12:"container_bk";s:7:"#c5f2d1";s:9:"titraille";s:7:"#670161";s:12:"titraille_bk";s:7:"#c08cd4";s:4:"link";s:7:"#c055cd";s:7:"visited";s:7:"#de66d4";s:5:"hover";s:7:"#a16ea0";s:6:"active";s:7:"#40163f";s:15:"fontsnavigation";s:34:"Verdana, Arial, Geneva, sans-serif";s:12:"fontscontent";s:34:"Verdana, Arial, Geneva, sans-serif";s:14:"fontsizeheader";s:3:"1.2";s:14:"fontsizefooter";s:3:"1.2";s:18:"fontsizenavigation";s:3:"1.2";s:15:"fontsizecontenu";s:3:"1.2";s:18:"fontsizeartrecents";s:1:"1";s:13:"autovignettes";s:4:"auto";s:17:"fontsizevignettes";s:2:"16";s:12:"body_degrade";N;s:14:"footer_degrade";N;s:16:"menuhaut_degrade";N;s:17:"cadreinfo_degrade";N;s:17:"citations_degrade";N;s:17:"cartouche_degrade";N;s:17:"titraille_degrade";N;s:19:"titraille_ssniveaux";s:7:"#013067";s:22:"titraille_ssniveaux_bk";s:7:"#eca6e6";s:11:"cadrestexte";s:7:"#002652";s:14:"cadrestexte_bk";s:7:"#f9e4f4";s:13:"header_lettre";s:7:"#ffffff";s:16:"header_lettre_bk";s:7:"#663b62";s:16:"titraille_lettre";s:7:"#670161";}');
			}
			spip_log("SoyezCreateurs maj 3.0.1", "soyezcreateurs_install");			
			ecrire_meta($nom_meta_base_version,$current_version='3.0.1','non');
		}

		if (version_compare($current_version,'3.0.2','<')) {
			$id_rubrique = id_rubrique('000. Fourre-tout');
			if ($id_rubrique >0) {
				create_rubrique('10. NewsLetter', $id_rubrique, "Pour éviter que les articles servant à la création de vos lettres se retrouvent dans la navigation du site, placez-les dans cette rubrique.\n\nPour faire une lettre, il vous faudra le plugin [CleverMail->https://contrib.spip.net/CleverMail], et utiliser les squelettes : {{lettre_libre}} et {{lettre_libre_txt}}. Utilisez le mot clef {Courrier_libre} pour désigner l'article servant pour le prochain courrier.");
			}
			spip_log("SoyezCreateurs maj 3.0.2", "soyezcreateurs_install");			
			ecrire_meta($nom_meta_base_version,$current_version='3.0.2','non');
		}

		if (version_compare($current_version,'3.0.3','<')) {
			create_mot("_Specialisation", "MentionsLegales", _T('soyezcreateurs:mentions_legales_obligatoires'), "Affecter ce mot clef à l'article destiné à afficher les mentions légales du site.");
			
			// Au cas où : remttre au carré les id_secteur des articles et rubriques.
			include_spip('inc/rubriques');
			calculer_rubriques();
			propager_les_secteurs();
			
			spip_log("SoyezCreateurs maj 3.0.3", "soyezcreateurs_install");			
			ecrire_meta($nom_meta_base_version,$current_version='3.0.3','non');
		}
		if (version_compare($current_version,'3.0.4','<')) {
			// Réserve le formulaire des événements aux seules rubriques d'Agenda (avec le plugin agenda 2 installé)
			sql_update('spip_rubriques INNER JOIN spip_mots_rubriques ON spip_rubriques.id_rubrique = spip_mots_rubriques.id_rubrique INNER JOIN spip_mots ON spip_mots_rubriques.id_mot=spip_mots.id_mot', array('spip_rubriques.agenda' => 1), 'spip_mots.titre='.sql_quote('Agenda'));
			ecrire_meta($nom_meta_base_version,$current_version='3.0.4','non');
		}
		if (version_compare($current_version,'3.0.5','<')) {
			// Activer les crayons dans ecrire, et la barre typo sur les crayons, réduire les images à 400 px de large (au cas où)
			ecrire_config('crayons/barretypo','on');
			ecrire_config('crayons/reduire_logo',400);
			ecrire_config('crayons/espaceprive','on');
			ecrire_config('crayons/exec_autorise','*');
			// Permettre aux webmestres d'éditer les forums (dans le privé et le public, avec les crayons).
			ecrire_config('autorite/editer_forums',1);
			ecrire_meta($nom_meta_base_version,$current_version='3.0.5','non');
		}
		if (version_compare($current_version,'3.0.6','<')) {
			spip_log("SoyezCreateurs maj 3.0.6", "soyezcreateurs_install");
			create_mot("_Specialisation_Sites", "LienDirect", "Mettre ce mot clef aux sites pour faire des liens directs aux sites sans passer par une page intermédiaire.", "");
			ecrire_meta($nom_meta_base_version,$current_version='3.0.6','non');
		}
		if (version_compare($current_version,'3.0.7','<')) {
			spip_log("SoyezCreateurs maj 3.0.7", "soyezcreateurs_install");
			include_spip('inc/autoriser');
			sql_update('spip_auteurs',array('webmestre'=>"'oui'"),sql_in("id_auteur",defined('_ID_WEBMESTRES')?explode(':',_ID_WEBMESTRES):(autoriser('configurer')?array($GLOBALS['visiteur_session']['id_auteur']):array(0)))); // le webmestre est celui qui fait l'upgrade si rien de defini
			ecrire_meta($nom_meta_base_version,$current_version='3.0.7','non');
		}
		
		if (version_compare($current_version,'3.0.8','<')) {
			//pré-configuration du plugin microblog
			ecrire_config('microblog/evt_publierarticles', 'on');
			ecrire_config('microblog/evt_publierarticlesfutur', 'publication');
			ecrire_meta($nom_meta_base_version,$current_version='3.0.8','non');
		}
		if (version_compare($current_version,'3.0.9','<')) {
			//Le mode texte seul de bouton texte bug au retour dans la page avec MediaBox
			ecrire_config('boutonstexte/txtOnly','_');
			ecrire_meta($nom_meta_base_version,$current_version='3.0.9','non');
		}
		if (version_compare($current_version,'3.0.10','<')) {
			create_mot("_Specialisation", "VideoALaUne", "Pour afficher une vidéo À la Une dans certains mode d'affichage de la page d'accueil.", "Affecter ce mot clef aux articles contenant une vidéo à afficher À la Une. C'est le dernier article en date qui est pris en compte, et la première vidéo qui est affichée.");
			
			spip_log("SoyezCreateurs maj 3.0.10", "soyezcreateurs_install");			
			ecrire_meta($nom_meta_base_version,$current_version='3.0.10','non');
		}
		if (version_compare($current_version,'3.0.11','<')) {
			spip_log("SoyezCreateurs maj 3.0.11", "soyezcreateurs_install");
			create_mot("_Specialisation_Rubrique_ou_Article", "Archives", "Pour dire la rubrique ayant ce mot clef ou les articles de la rubrique doivent être considérés comme archivés.", "Affecter ce mot clef à chaque rubrique concernée ou à chaque article individuellement.");
			create_mot("_Specialisation_Rubrique_ou_Article", "GrosLogo", "Pour dire la rubrique ayant ce mot clef ou les articles de la rubrique doit afficher le logo de l'article ou de la rubrique en grand (flottant à gauche du texte de l'article).", "Affecter ce mot clef à chaque rubrique concernée ou à chaque article individuellement.");
			ecrire_meta($nom_meta_base_version,$current_version='3.0.11','non');
		}
		if (version_compare($current_version,'3.0.12','<')) {
			spip_log("SoyezCreateurs maj 3.0.12", "soyezcreateurs_install");
			create_groupe("_TypeRubrique", "Pour indiquer un type spécifique de rubrique", "Il faut choisir un mot clef dans cette liste pour obtenir un affichage spécifique de rubrique.\n\nNB : pour rajouter un mot clef \"mc1\", il faut aussi rajouter les squelettes correspondants :\n-* noisettes/rubriques/typerubrique_mc1.html\n-* noisettes/footer/footer_typerubrique_mc1.html (facultatif)\n-* noisettes/articles/typearticle_mc1.html (facultatif)", 'oui', 'non', 'non', 'non', 'oui', 'non', 'non', 'oui', 'non', 'non');
				create_mot("_TypeRubrique", "ContenuArticles", "Pour dire que la rubrique ayant ce mot clef doit utiliser le squelette type des ContenuArticles.", "Affecter ce mot clef à chaque rubrique racine concernée. À la place de la rubrique, on aura le contenu de tous les articles de cette rubrique, par ordre antichronologique, ou par numéro de titre.");
				create_mot("_TypeRubrique", "ArticlesParAnnees", "Pour dire que la rubrique ayant ce mot clef doit utiliser le squelette type des ArticlesParAnnees.", "Affecter ce mot clef à chaque rubrique racine concernée. À la place de la rubrique, on aura le contenu de tous les articles de cette rubrique, par années, par mois, par ordre antichronologique dans chaque mois.");
				create_mot("_TypeRubrique", "ListeArticlesParAnnees", "Pour dire que la rubrique ayant ce mot clef doit utiliser le squelette type des ListeArticlesParAnnees.", "Affecter ce mot clef à chaque rubrique racine concernée. À la place de la rubrique, on aura la liste des articles de cette rubrique, par années, par mois, par ordre antichronologique dans chaque mois.");
			ecrire_meta($nom_meta_base_version,$current_version='3.0.12','non');
		}
		if (version_compare($current_version,'3.0.13','<')) {
			spip_log("SoyezCreateurs maj 3.0.13", "soyezcreateurs_install");
			create_mot("_ModePortail", "CycloShow", "Affecter ce mot clef à la rubrique de SPIP dont les articles doivent apparaitre dans la zone du cycle d'images.\n\nIndiquer dans le texte du mot clef le nombre d'articles de la rubrique à prendre en compte.", "");
			create_mot("_ModePortail", "Defilant", "Affecter ce mot clef à la rubrique de SPIP dont les brèves doivent apparaitre dans la zone de texte défilant en haut de la page.\n\n", "");
			ecrire_meta($nom_meta_base_version,$current_version='3.0.13','non');
		}
		if (version_compare($current_version,'3.0.14','<')) {
			spip_log("SoyezCreateurs maj 3.0.14", "soyezcreateurs_install");
				create_mot("_TypeRubrique", "multicolonnes", "Pour dire que la rubrique ayant ce mot clef doit utiliser le squelette type multicolonnes.", "Affecter ce mot clef à chaque rubrique racine concernée. À la place de la rubrique, on aura une colonne par sous rubrique, avec la liste des articles par ordre antichronologique, ou par numéro de titre.");
			ecrire_meta($nom_meta_base_version,$current_version='3.0.14','non');
		}
		if (version_compare($current_version,'3.0.15','<')) {
			spip_log("SoyezCreateurs maj 3.0.15", "soyezcreateurs_install");
			create_groupe("_EnDirect", "En direct", "Affecter un mot clef de ce groupe à chaque article devant apparaître dans la Zone En Direct du mode internationnal.\n\nLe Premier mot clef permet de donner le logo et le titre de la première zone qui affiche les quoi de neuf du site.\n\nLe Descriptif du groupe donne le titre de la zone.", 'oui', 'non', 'oui', 'non', 'non', 'non', 'non', 'oui', 'oui', 'non');
				$id_mot = create_mot("_EnDirect", "00. Quoi de neuf ?", "", "");
				create_logo('documents/newspaper.png', $type='mot', $id_mot, 'png'); // http://www.iconfinder.com/icondetails/8437/16/newspaper_icon
			ecrire_meta($nom_meta_base_version,$current_version='3.0.15','non');
		}
		if (version_compare($current_version,'3.0.16','<')) {
			spip_log("SoyezCreateurs maj 3.0.16", "soyezcreateurs_install");
			create_mot("_Specialisation_Rubrique_ou_Article", "PasDansPlanLocal", "Permet de masquer une rubrique, et tout son contenu (y compris les sous-rubriques) des plan locaux du site (ceux affichés quand une rubrique n'a ni texte, ni article, ni site).\n\nPermet aussi de le faire article par article.", "À affecter aux rubriques ou articles qui ne doivent pas être affichés dans les plan locaux du site.");
			ecrire_meta($nom_meta_base_version,$current_version='3.0.16','non');
		}
		if (version_compare($current_version,'3.0.17','<')) {
			spip_log("SoyezCreateurs maj 3.0.17", "soyezcreateurs_install");
			create_mot("_Specialisation_Rubrique", "PasDansMenuExtra", "Pour interdire que la rubrique soit dans le menu des extra (menu droit)", "");
			ecrire_meta($nom_meta_base_version,$current_version='3.0.17','non');
		}
		if (version_compare($current_version,'3.0.18','<')) {
			spip_log("SoyezCreateurs maj 3.0.18", "soyezcreateurs_install");
			create_groupe("_HeaderBanner", "Pour définir plusieurs bannières pour le site.", "Il faut créer un mot clef par bannière (le titre n'a pas d'importance).\n\nC'est le logo du mot clef qui est utilisé comme bannière du site.\n\n{{Attention}} : si vous avez déjà défini une bannière avec le logo de survol du site, alors, cette dernière n'est plus utilisée ; seuls les logos des mots clefs de ce groupe seront pris en compte.\n\nLes mots clefs affectés à une rubrique restreignes le choix des bannières pour la branche entière à celles affectées à la rubrique. Le fonctionnement pour le reste du site est inchangé ({{toutes}} les bannières sont disponibles pour le reste du site).", 'non', 'non', 'non', 'non', 'oui', 'non', 'non', 'oui', 'non', 'non');
			ecrire_meta($nom_meta_base_version,$current_version='3.0.18','non');
		}
		if (version_compare($current_version,'3.0.19','<')) {
			spip_log("SoyezCreateurs maj 3.0.12", "soyezcreateurs_install");
				create_mot("_TypeRubrique", "Magazines", "Pour dire que la rubrique ayant ce mot clef doit utiliser le squelette type des Magazines.", "Affecter ce mot clef à chaque rubrique racine concernée. À la place de la rubrique, on aura la liste des documents joints aux articles, avec la vignette associée.");
			ecrire_meta($nom_meta_base_version,$current_version='3.0.19','non');
		}
		if (version_compare($current_version,'3.0.20','<')) {
			spip_log("SoyezCreateurs maj 3.0.20", "soyezcreateurs_install");
			create_mot("_ModePortail", "ZoomSur2", "Affecter ce mot clef à l'objet que vous voulez placer dans le cadre « Zoom sur secondaire » (facultatif).\n\nLe site prendra le dernier article ayant ce mot clef", "");
			ecrire_meta($nom_meta_base_version,$current_version='3.0.20','non');
		}
		if (version_compare($current_version,'3.0.21','<')) {
			spip_log("SoyezCreateurs maj 3.0.21", "soyezcreateurs_install");
			if (defined(_DIR_PLUGIN_DICTIONNAIRES)) {
				if (sql_countsel('spip_dictionnaires', "(titre = '"._T('dictionnaire:importer_acronymes_titre')."')") == 0) {
					include_spip('action/editer_dictionnaire');
					if ($id_dictionnaire = insert_dictionnaire()){
						// On lui met des champs par défaut
						dictionnaire_set($id_dictionnaire, array(
							'titre' => _T('dictionnaire:importer_acronymes_titre'),
							'actif' => 1,
							'descriptif' => _T('dictionnaire:importer_acronymes_descriptif'),
							'type_defaut' => 'abbr',
						));
					}
				} else {
					$dico = sql_fetsel("id_dictionnaire", "spip_dictionnaires", "titre='"._T('dictionnaire:importer_acronymes_titre')."'");
					$id_dictionnaire = $dico['id_dictionnaire'];
				}
				if (sql_countsel('spip_definitions', array("id_dictionnaire=$id_dictionnaire", "titre = 'SPIP'")) == 0) {
					$definition = array(
						'id_dictionnaire' => $id_dictionnaire,
						'titre' => 'SPIP',
						'texte' => 'Système de Publication pour Internet Participatif',
						'type' => 'abbr',
						'date' => date('Y-m-d H:i:s'),
						'statut' => 'publie',
						'lang' => 'fr'
					);
					
					// On crée la définition dans la base SANS calculer le cache
					include_spip('action/editer_definition');
					if ($id_definition = insert_definition()){
						definition_set($id_definition, $definition, false);
					}
					include_spip('inc/dictionnaires');
					dictionnaires_lister_definitions(true);
				}
			}
			ecrire_meta($nom_meta_base_version,$current_version='3.0.21','non');
		}
		if (version_compare($current_version,'3.0.22','<')) {
			spip_log("SoyezCreateurs maj 3.0.22", "soyezcreateurs_install");
			// Activer les lames du CouteauSuisse Special SoyezCreateurs (enlève la lame Webmestre et Ancre_Douces)
			$f = chercher_filtre('info_plugin');
			if ($f('couteau_suisse', 'est_actif')) {
				include_spip('base/cout_install');
				cout_install_pack('SoyezCreateurs');
				include_spip('inc/getdocument');
				effacer_repertoire_temporaire(_DIR_TMP.'couteau-suisse');
			}
			ecrire_meta($nom_meta_base_version,$current_version='3.0.22','non');
		}
		if (version_compare($current_version,'3.0.23','<')) {
			spip_log("SoyezCreateurs maj 3.0.23", "soyezcreateurs_install");
			create_mot("_Specialisation_Rubrique", "AfficherArticlesMenuHaut", "Affichage des articles de la rubrique dans le menu déroulant", "Affecter ce mot clef aux rubriques dont la liste des articles doit être affichée dans le menu déroulant.");
			$id_rub_fourretout = id_rubrique("000. Fourre-tout");
			$id_raccourcis_typo = id_article("Raccourcis Typographiques de SPIP, mode d'emploi", $id_rub_fourretout);
			create_article_mot("Raccourcis Typographiques de SPIP, mode d'emploi", "000. Fourre-tout", "Sommaire", "_Specialisation_Rubrique_ou_Article");
			create_logo('documents/casiertypo.png', $type='art', $id_raccourcis_typo, 'png'); // 			

			ecrire_meta($nom_meta_base_version,$current_version='3.0.23','non');
		}
		if (version_compare($current_version,'3.0.24','<')) {
			spip_log("SoyezCreateurs maj 3.0.24", "soyezcreateurs_install");
			// Initialisation Sigles du dictionnaire
			if (defined('_DIR_PLUGIN_DICTIONNAIRES')) {
				include_spip('action/editer_dictionnaire');
				$id_dictionnaire = sql_fetsel("id_dictionnaire", "spip_dictionnaires", "titre='"._T('dictionnaire:importer_acronymes_titre')."'");
				if (is_array($id_dictionnaire)) {
					$id_dictionnaire = $id_dictionnaire['id_dictionnaire'];
				}
				if (!$id_dictionnaire) {
					if ($id_dictionnaire = insert_dictionnaire()){
						// On lui met des champs par défaut
						dictionnaire_set($id_dictionnaire, array(
							'titre' => _T('dictionnaire:importer_acronymes_titre'),
							'actif' => 1,
							'descriptif' => _T('dictionnaire:importer_acronymes_descriptif'),
							'type_defaut' => 'abbr',
						));
					}
				}
				if ($id_dictionnaire) {
					$definition = array(
						'id_dictionnaire' => $id_dictionnaire,
						'titre' => 'SPIP',
						'texte' => 'Système de Publication pour un Internet Participatif',
						'type' => 'abbr',
						'casse' => 1,
						'statut' => 'publie',
						'lang' => 'fr'
					);
					$id_definition = sql_fetsel("id_definition", "spip_definitions", "titre='".$definition['titre']."' AND id_dictionnaire=$id_dictionnaire");
					if (!$id_definition) {
						// On crée la définition dans la base SANS calculer le cache
						include_spip('action/editer_definition');
						if ($id_definition = insert_definition()){
							definition_set($id_definition, $definition, false);
						}
					}
					$definition = array(
						'id_dictionnaire' => $id_dictionnaire,
						'titre' => 'RGAA',
						'texte' => 'Référentiel Général pour l\'Accessibilité des Administrations',
						'type' => 'abbr',
						'casse' => 1,
						'statut' => 'publie',
						'lang' => 'fr'
					);
					$id_definition = sql_fetsel("id_definition", "spip_definitions", "titre='".$definition['titre']."' AND id_dictionnaire=$id_dictionnaire");
					if (!$id_definition) {
						// On crée la définition dans la base SANS calculer le cache
						include_spip('action/editer_definition');
						if ($id_definition = insert_definition()){
							definition_set($id_definition, $definition, false);
						}
					}
				}
				// On calcule le cache des définitions une seule fois à la fin
				include_spip('inc/dictionnaires');
				dictionnaires_lister_definitions(true);
				
			}
			ecrire_meta($nom_meta_base_version,$current_version='3.0.24','non');
		}
		if (version_compare($current_version,'3.0.25','<')) {
			// Suppresion de "_Specialisation", "Gallerie"
			$id_groupe = id_groupe("_META");
			$id_mot = id_mot("Description", $id_groupe);
			if ($id_mot>0) {
				if (!$GLOBALS['meta']['descriptif_site']) {
					$descritif_site = sql_fetsel("texte", "spip_mots", "id_mot=$id_mot");
					ecrire_meta('descriptif_site', $descritif_site['texte'], 'non');
				}
				sql_delete("spip_mots", "id_mot=$id_mot");
			}
			$id_mot = id_mot("revisit-after", $id_groupe);
			if ($id_mot>0) {
				sql_delete("spip_mots", "id_mot=$id_mot");
			}
			$id_groupe = id_groupe("_Specialisation_Rubrique");
			$id_mot = id_mot("agenda_principal", $id_groupe);
			if ($id_mot>0) {
				sql_delete("spip_mots", "id_mot=$id_mot");
			}
			spip_log("SoyezCreateurs maj 3.0.25", "soyezcreateurs_install");
			ecrire_meta($nom_meta_base_version,$current_version='3.0.25','non');
		}
		if (version_compare($current_version,'3.0.26','<')) {
			// Menu de navigation haute
			$id_mot = create_mot("_Specialisation", "NavHaute", "Affecter ce mot clef aux articles devant être affichés dans le menu de navigation haute tout en haut du site.", "Les liens vers les articles seront faits triés par numéro de titre.\n\nIl est bien sûr possible de faire des articles de redirection...");
			spip_log("SoyezCreateurs maj 3.0.26", "soyezcreateurs_install");
			// Rubrique où placer les articles pour bien s'organiser
			$id_rubrique = id_rubrique('000. Fourre-tout');
			if ($id_rubrique >0) {
				create_rubrique('10. Navigation haute', $id_rubrique, "Pour éviter que les articles servant à la création du menu de navigation haute se retrouvent dans la navigation du site, placez-les dans cette rubrique.\n\nVoir [->mot$id_mot] pour la documentation.");
			}
			create_rubrique_mot('000. Fourre-tout', 'AfficherArticlesMenu', "_Specialisation_Rubrique");
			create_rubrique_mot('10. Navigation haute', 'AfficherArticlesMenu', "_Specialisation_Rubrique");
			create_rubrique_mot('10. Navigation haute', 'PasDansFildAriane', "_Specialisation_Rubrique");
			ecrire_meta($nom_meta_base_version,$current_version='3.0.26','non');
		}
		if (version_compare($current_version,'3.0.27','<')) {
			spip_log("SoyezCreateurs maj 3.0.27", "soyezcreateurs_install");
			create_mot("_Specialisation_Sites", "ReseauxSociaux", "Mettre ce mot clef aux sites servant de liens vers les réseaux sociaux du site.\n\nMettre un texte dans ce mot clef pour qu'il soit affiché devant les icones des sites", "");
			$id_rubrique = id_rubrique('000. Fourre-tout');
			if ($id_rubrique >0) {
				create_rubrique('80. Réseaux sociaux', $id_rubrique, "Rubrique destinée à recevoir les sites référencés utilisés pour l'affichage des réseaux sociaux.");
				$sitesdj = array();
				$sitesdj['nom_site'] = "10. Facebook";
				$sitesdj['url_site'] = "https://www.facebook.com/";
				$sitesdj['descriptif'] = 'Retrouvez-nous sur Facebook';
				$id_site = create_site($sitesdj, '80. Réseaux sociaux');
				create_logo('documents/facebook.png', $type='site', $id_site, 'png');
				create_site_mot($id_site, 'ReseauxSociaux', '_Specialisation_Sites');
				
				$sitesdj = array();
				$sitesdj['nom_site'] = "20. Twitter";
				$sitesdj['url_site'] = "https://fr.twitter.com/";
				$sitesdj['descriptif'] = 'Retrouvez-nous sur Twitter';
				$id_site = create_site($sitesdj, '80. Réseaux sociaux');
				create_logo('documents/twitter.png', $type='site', $id_site, 'png');
				create_site_mot($id_site, 'ReseauxSociaux', '_Specialisation_Sites');
				
				$sitesdj = array();
				$sitesdj['nom_site'] = "30. Viadeo";
				$sitesdj['url_site'] = "http://www.viadeo.com/fr/";
				$sitesdj['descriptif'] = 'Retrouvez-nous sur Viadeo';
				$id_site = create_site($sitesdj, '80. Réseaux sociaux');
				create_logo('documents/viadeo.png', $type='site', $id_site, 'png');
				create_site_mot($id_site, 'ReseauxSociaux', '_Specialisation_Sites');
				
				$sitesdj = array();
				$sitesdj['nom_site'] = "90. Flux RSS du site";
				$sitesdj['url_site'] = "./?page=backend";
				$sitesdj['descriptif'] = 'Syndiquer tout le site';
				$sitesdj['statut'] = 'publie';
				$id_site = create_site($sitesdj, '80. Réseaux sociaux');
				create_logo('images/rss.png', $type='site', $id_site, 'png');
				create_site_mot($id_site, 'ReseauxSociaux', '_Specialisation_Sites');
			}			
			ecrire_meta($nom_meta_base_version,$current_version='3.0.27','non');
		}
		if (version_compare($current_version,'3.0.28','<')) {
			spip_log("SoyezCreateurs maj 3.0.28", "soyezcreateurs_install");
			$id_rubrique = id_rubrique('000. Fourre-tout');
			if ($id_rubrique >0) {
				$sitesdj = array();
				$sitesdj['nom_site'] = "15. Google+";
				$sitesdj['url_site'] = "https://plus.google.com/GGGGGGGGGG?rel=author";
				$sitesdj['descriptif'] = 'Retrouvez-nous sur Google+';
				$id_site = create_site($sitesdj, '80. Réseaux sociaux');
				create_logo('documents/googleplus.png', $type='site', $id_site, 'png');
				create_site_mot($id_site, 'ReseauxSociaux', '_Specialisation_Sites');
			}			
			ecrire_meta($nom_meta_base_version,$current_version='3.0.28','non');
		}
		
		/*if (version_compare($current_version,'3.0.10','<')) {
			create_document('documents/image.jpg', array('objet' => 'article', 'id_objet' => 3), 'image', array('titre' => 'Mon image', 'descriptif' => 'Superbe image'));
		}
		*/
		/*
		#En attente
		if (version_compare($current_version,'3.0.11','<')) {
			create_groupe("_TypeArticle", "Pour indiquer un type spécifique d'article", "Il faut choisir un mot clef dans cette liste pour obtenir un affichage spécifique d'article.\n\nNB : pour rajouter un mot clef \"mc1\", il faut aussi rajouter les squelettes correspondants :\n-* noisettes/articles/typearticle_mc1.html\n-* noisettes/footer/footer_typearticle_mc1.html", 'oui', 'non', 'oui', 'non', 'non', 'non', 'non', 'oui', 'non', 'non');
				create_mot("_TypeArticle", "annuaire", "Pour dire que l'article ayant ce mot clef doit utiliser le squelette type des annuaire.", "Affecter ce mot clef à chaque article de l'annuaire.");
			ecrire_meta($nom_meta_base_version,$current_version='3.0.11','non');
		}
		// A integrer quand SPIP permettra d'avoir des critères optionnels sur un champ de table innexistant
		// en l'occurrence, remplacer dans le squelette {titre_mot=Agenda} par {agenda=1}
		if (version_compare($current_version,'2.1.14','<')) {
			include_spip('base/soyezcreateurs');
			spip_log("SoyezCreateurs maj 2.1.14", "soyezcreateurs_install");
			$id_groupe = id_groupe("_Specialisation_Rubrique");
			$id_mot = id_mot("Agenda", $id_groupe);
			if ($id_mot>0) {
				sql_delete("spip_mots", "id_mot=$id_mot");
				sql_delete("spip_mots_articles", "id_mot=$id_mot");
				sql_delete("spip_mots_rubriques", "id_mot=$id_mot");
				sql_delete("spip_mots_syndic", "id_mot=$id_mot");
				sql_delete("spip_mots_forum", "id_mot=$id_mot");
			}
			ecrire_meta($nom_meta_base_version,$current_version='2.1.14','non');
		}
		*/
	}
}

function soyezcreateurs_changer_cfg($cfg) {
	include_spip('inc/cfg_config'); 
	foreach ($cfg as $conf => $faire) {
		$recherche_conf = lire_config('soyezcreateurs/'.$conf);
		spip_log('cfg = '.$conf.' = '.$recherche_conf.' go','soyezcreateurs_install');
		if ($faire == 'radio') {
			if ($recherche_conf == 'Oui') {
				$res = ecrire_config('soyezcreateurs/'.$conf, 'oui');
				spip_log('cfg go to '.$faire.'= '.$recherche_conf.' ok','soyezcreateurs_install');
			}
			else if ($recherche_conf == 'Non') {
				$res = ecrire_config('soyezcreateurs/'.$conf, 'non');
				spip_log('cfg go to '.$faire.'= '.$recherche_conf.' ok','soyezcreateurs_install');
			}
		}
		else if ($faire == 'oui_non') {
			if ($recherche_conf == 'Non') {
				$res = ecrire_config('soyezcreateurs/'.$conf, '');
				spip_log('cfg go to '.$faire.'= '.$recherche_conf.' ok','soyezcreateurs_install');
			}
			else if ($recherche_conf == 'Oui') {
				$res = ecrire_config('soyezcreateurs/'.$conf, 'on');
				spip_log('cfg go to '.$faire.'= '.$recherche_conf.' ok','soyezcreateurs_install');
			}
		}
	}
	return true;
}

/*
 * Fonction de desinstallation
 *
 * @param unknown_type $nom_meta_base_version
 */
function soyezcreateurs_vider_tables($nom_meta_base_version) {
	effacer_meta('soyezcreateurs');
	effacer_meta('soyezcreateurs_couleurs');
	effacer_meta('soyezcreateurs_google');
	effacer_meta('soyezcreateurs_layout');
	effacer_meta($nom_meta_base_version);
}
?>
