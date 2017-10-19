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
	if (defined('_BYPASS_SC_INSTALL')) return;
	include_spip('base/soyezcreateurs');
	$current_version = 0.0;
	if ((!isset($GLOBALS['meta'][$nom_meta_base_version])) || (($current_version = $GLOBALS['meta'][$nom_meta_base_version])!=$version_cible)){
		if (version_compare($current_version,'3.0.20','<')) {
			spip_log("SoyezCreateurs maj 3.0.20 Début", "soyezcreateurs_install");
			soyezcreateurs_config_site();
			soyezcreateurs_config_motsclefs();
			// Installation des index FullText si le plugin est présent
			$f = chercher_filtre('info_plugin');
			if($f('Fulltext', 'est_actif')) {
				include_spip('inc/fulltext_creer_index');
				fulltext_liste_creer_index('all');
			}
			// Installation d'exemples concernant l'agenda si le plugin est actif
			if ($f('agenda', 'est_actif')) {
				// Réserve le formulaire des événements aux seules rubriques d'Agenda (avec le plugin agenda 2 installé)
				sql_update('spip_rubriques INNER JOIN spip_mots_rubriques ON spip_rubriques.id_rubrique = spip_mots_rubriques.id_rubrique INNER JOIN spip_mots ON spip_mots_liens.id_mot=spip_mots.id_mot', array('spip_rubriques.agenda' => 1, 'spip_mots_liens.objet'=>'rubrique'), 'spip_mots.titre='.sql_quote('Agenda'));
				include_spip('inc/sc_article');
				
				$id_rubrique = id_rubrique('900. Agenda');
				if ($id_rubrique >0) {
					$date = date('Y-m-d H:i:00');
					create_evenement("900. Agenda", "Installation du site", "Installation du site", $date, $date, "Quand le titre de l'événement est identique au titre de l'article, il n'est pas affiché en plus", 'Votre serveur web.');
					create_evenement("900. Agenda", "Installation du site", "Installé !", $date, $date, "Quand le titre de l'événement est différent du titre de l'article, alors, les 2 titres sont affichés.", '');
					create_evenement("900. Agenda", "Événement exceptionnel", "Événement exceptionnel", date('Y-m-d 20:30:00'), date('Y-m-d 22:30:00'), "Quand l'heure de début est différente de l'heure de fin, c'est un événement avec une durée...", '');
					create_evenement("10. SPIP", "Historique des versions de SPIP", "SPIP 2.1", '2010-04-09', '2010-04-09', "[->https://www.spip.net/fr_article4728.html]", '', 'non');
					create_evenement("10. SPIP", "Historique des versions de SPIP", "SPIP 2.0", '2008-12-13', '2008-12-13', "[->https://www.spip.net/fr_article3784.html]", '', 'non');
					create_evenement("900. Agenda", "Démonstration Agenda", "Démonstration Agenda", '2017-12-13', '2017-12-13', "", '', 'non');
				}
			}
			spip_log("SoyezCreateurs maj 3.0.20 Faite", "soyezcreateurs_install");
			ecrire_meta($nom_meta_base_version,$current_version='3.0.20','non');
		}

		if (version_compare($current_version,'3.0.24','<')) {
			spip_log("SoyezCreateurs maj 3.0.24 Début", "soyezcreateurs_install");
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
							'statut' => 'actif',
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
			spip_log("SoyezCreateurs maj 3.0.24 Faite", "soyezcreateurs_install");
			ecrire_meta($nom_meta_base_version,$current_version='3.0.24','non');
		}
		if (version_compare($current_version,'3.0.28','<')) {
			spip_log("SoyezCreateurs maj 3.0.28 Début", "soyezcreateurs_install");
			// Au cas où : remttre au carré les id_secteur des articles et rubriques.
			include_spip('inc/rubriques');
			calculer_rubriques();
			propager_les_secteurs();
			effacer_meta("date_calcul_rubriques");
			
			spip_log("SoyezCreateurs maj 3.0.28 Faite", "soyezcreateurs_install");
			ecrire_meta($nom_meta_base_version,$current_version='3.0.28','non');
		}
		
		if (version_compare($current_version,'3.0.30','<')) {
			spip_log("SoyezCreateurs maj 3.0.30 Début", "soyezcreateurs_install");
			$id_mot = create_mot("_ModePortail", "ZoomSur2_Variante1", "Affecter ce mot clef à l’objet que vous voulez placer dans le cadre « Zoom sur secondaire » (facultatif).\n\nLe site prendra le dernier article ayant ce mot clef.", "Variante sur 2 colonnes : \n-* Titre de la rubrique contenant l’article\n-* 1re colonne :\n-** Document joint (de type autre média, PowerPoint par exemple) affiché avec son logo\n-** Chapo de l'article en dessous (permet de faire un lien)\n-* 2e colonne :\n-** Logo de l’article\n-** faisant un lien vers l’article (et si c’est une redirection, ça peut conduire à une autre page");
			spip_log("SoyezCreateurs maj 3.0.30 Faite", "soyezcreateurs_install");
			ecrire_meta($nom_meta_base_version,$current_version='3.0.30','non');
		}
		if (version_compare($current_version,'3.0.31','<')) {
			spip_log("SoyezCreateurs maj 3.0.31 Début", "soyezcreateurs_install");
			$id_mot = create_mot("_ModePortail", "ZoomSur2_Variante2", "Affecter ce mot clef à l’objet que vous voulez placer dans le cadre « Zoom sur secondaire » (facultatif).\n\nLe site prendra le dernier article ayant ce mot clef.", "Variante sur 2 colonnes : \n-* Titre de la rubrique contenant l’article\n-* 1re colonne :\n-** Fonctionne comme le Cycloshow avec les articles de la sous rubriques de la rubrique de l'article\n-* 2e colonne :\n-** Logo de l’article\n-** faisant un lien vers l’article (et si c’est une redirection, ça peut conduire à une autre page");
			ecrire_meta($nom_meta_base_version,$current_version='3.0.31','non');
		}
		if (version_compare($current_version,'3.0.33','<')) {
			spip_log("SoyezCreateurs maj 3.0.33 Début", "soyezcreateurs_install");
			$id_mot = create_mot("_Specialisation_Rubrique", "ClassementAlpha", "Mettre ce mot clef à la rubrique pour classer son contenu alphabétiquement.", "");
			ecrire_meta($nom_meta_base_version,$current_version='3.0.33','non');
		}
		
		if (version_compare($current_version,'3.0.34','<')) {
			spip_log("SoyezCreateurs maj 3.0.34 Début", "soyezcreateurs_install");
			$sites['nom_site'] = "90. Flux RSS du site";
			$sites['url_site'] = "?page=backend";
			$sites['descriptif'] = "public:syndiquer_site";
			$sites['url_syndic'] = "";
			$sites['statut'] = 'publie';
			$id_site = create_site($sites, "80. Réseaux sociaux");
				if ($id_site > 0) {
					create_logo('documents/siteon5.png', $type='site', $id_site, 'png');
					create_site_mot($id_site, "ReseauxSociaux", "_Specialisation_Sites");
				}
			ecrire_meta($nom_meta_base_version,$current_version='3.0.34','non');
		}
		if (version_compare($current_version,'3.1.35','<')) {
			spip_log("SoyezCreateurs maj 3.1.35 Début", "soyezcreateurs_install");
			supprimer_mot_groupe("_Specialisation_Rubrique", "GisSecteur");
			ecrire_meta($nom_meta_base_version,$current_version='3.1.35','non');
		}
		if (version_compare($current_version,'3.1.36','<')) {
			spip_log("SoyezCreateurs maj 3.1.36 Début", "soyezcreateurs_install");
			ecrire_config('boutonstexte/skin','soyezcreateurs');
			ecrire_meta($nom_meta_base_version,$current_version='3.1.36','non');
		}
		if (version_compare($current_version,'3.1.39','<')) {
			spip_log("SoyezCreateurs maj 3.1.39 Début", "soyezcreateurs_install");
			ecrire_meta('orthotypo',"a:7:{s:10:\"guillemets\";s:1:\"1\";s:9:\"exposants\";s:1:\"1\";s:4:\"mois\";s:1:\"1\";s:4:\"caps\";s:1:\"1\";s:5:\"fines\";s:1:\"1\";s:11:\"corrections\";s:1:\"1\";s:18:\"corrections_regles\";s:319:\"oeuf = œuf\ncceuil = ccueil\n(a priori) = {a priori}\n(([hH])uits) = $1uit\n/([cC]h?)oeur/ = $1œur\n/oeuvre/ = œuvre\n(O[Ee]uvre([rs]?)) = Œuvre$1\n/\b([cC]|[mM].c|[rR]ec)on+ais+a((?:n(?:ce|te?)|ble)s?)\b/ = $1onnaissa$2\nCO2 = <abbr title=\"CO2, Dioxyde de carbone, O=C=O\">CO<sub>2</sub></abbr>\noeil = œil\n(O[Ee]il) = Œil\";}", 'non');
			ecrire_meta($nom_meta_base_version,$current_version='3.1.39','non');
		}
		if (version_compare($current_version,'3.1.40','<')) {
			create_groupe("_TypeArticle", "Pour indiquer un type spécifique d'article", "Il faut choisir un mot clef dans cette liste pour obtenir un affichage spécifique d'article.\n\nNB : pour rajouter un mot clef \"mc1\", il faut aussi rajouter les squelettes correspondants :\n-* noisettes/articles/typearticle_mc1.html", 'oui', 'non', 'articles', 'oui', 'non', 'non');
			ecrire_meta($nom_meta_base_version,$current_version='3.1.40','non');
		}
		if (version_compare($current_version,'3.1.41','<')) {
			ecrire_meta('auto_compress_css', 'oui', 'non');
			ecrire_meta('auto_compress_js', 'oui', 'non');
			ecrire_meta('forum_prive', 'non', 'non');
			ecrire_meta('forum_prive_objets', 'spip_articles,spip_auteurs,spip_breves,spip_dictionnaires,spip_definitions,spip_rubriques,spip_syndic,', 'non');
			ecrire_meta('objets_versions', 'a:10:{i:0;s:13:"spip_articles";i:1;s:12:"spip_auteurs";i:2;s:14:"spip_rubriques";i:3;s:9:"spip_mots";i:4;s:17:"spip_groupes_mots";i:5;s:11:"spip_syndic";i:6;s:16:"spip_definitions";i:7;s:11:"spip_breves";i:8;s:14:"spip_documents";i:9;s:15:"spip_evenements";}', 'non');
			ecrire_meta('urls_activer_controle', 'oui', 'non');
			ecrire_meta('facteur_filtre_iso_8859', '0', 'non');
			ecrire_meta('calendriermini', 'a:4:{s:11:"format_jour";s:8:"initiale";s:19:"affichage_hors_mois";s:1:"1";s:17:"changement_rapide";s:1:"1";s:5:"jour1";s:1:"1";}', 'non');
			ecrire_meta('inserer_modeles', 'a:1:{s:6:"objets";a:2:{i:0;s:13:"spip_articles";i:1;s:0:"";}}', 'non');
			ecrire_meta('notifications', 'a:19:{s:17:"limiter_rubriques";s:0:"";s:17:"moderateurs_forum";s:0:"";s:24:"forums_limiter_rubriques";s:0:"";s:12:"forums_liste";s:0:"";s:23:"moderateurs_forum_prive";s:0:"";s:22:"moderateurs_signatures";s:0:"";s:11:"inscription";s:10:"webmestres";s:5:"suivi";s:1:"1";s:25:"prevenir_auteurs_articles";s:2:"on";s:31:"prevenir_auteurs_articles_refus";s:2:"on";s:21:"pas_prevenir_publieur";s:2:"on";s:26:"prevenir_admins_restreints";s:2:"on";s:16:"prevenir_auteurs";s:2:"on";s:12:"thread_forum";s:2:"on";s:13:"forum_article";s:2:"on";s:24:"forums_admins_restreints";s:2:"on";s:22:"prevenir_auteurs_prive";s:2:"on";s:18:"thread_forum_prive";s:2:"on";s:10:"messagerie";s:2:"on";}', 'non');
			ecrire_config('uploadhtml5/max_file_size','32');
			ecrire_meta($nom_meta_base_version,$current_version='3.1.41','non');
		}
		if (version_compare($current_version,'3.1.42','<')) {
			supprimer_mot_groupe('_HTTP-EQUIV','pics-label');
			ecrire_meta($nom_meta_base_version,$current_version='3.1.42','non');
		}
		if (version_compare($current_version,'3.1.43','<')) {
			spip_log("SoyezCreateurs maj 3.1.43 Début", "soyezcreateurs_install");
			create_groupe("_FondPage", "Images en fond de page :\n-* Créer autant de mots clefs que de fonds de page désirés\n-* Mettre un logo à ces mots clefs\n-* Possibilité de fixer un fond de page pour :\n-** Une rubrique (et la branche en dessous)\n-** Un type de page particulier (Sommaire, Plan)\n\nSe reporter à la documentation sur [Personnalisation graphique du squelette SoyezCreateurs->https://contrib.spip.net/Personnalisation-graphique-du-squelette-SoyezCreateurs].\n\nPour mettre une trame de fond, utiliser le logo de survol.\n\nUn site pour [créer des trames de fond->http://www.patternify.com/].", "", 'oui', 'non', 'rubriques', 'oui', 'non', 'non');
			spip_log("SoyezCreateurs maj 3.1.43 Faite", "soyezcreateurs_install");
			ecrire_meta($nom_meta_base_version,$current_version='3.1.43','non');
		}
		if (version_compare($current_version,'3.1.44','<')) {
			spip_log("SoyezCreateurs maj 3.1.44 Début", "soyezcreateurs_install");
			$id_mot = create_mot("_ModePortail", "Goodies2", "Affecter ce mot clef aux objets SPIP devant apparaitre dans la zone des Goodies (en mode international, sous la Une).", "");
			ecrire_meta($nom_meta_base_version,$current_version='3.1.44','non');
		}
		if (version_compare($current_version,'3.1.45','<')) {
			spip_log("SoyezCreateurs maj 3.1.45 Début", "soyezcreateurs_install");
			create_groupe("_HeaderBanner", "Pour définir plusieurs bannières pour le site.", "Il faut créer un mot clef par bannière (le titre n'a pas d'importance).\n\nC'est le logo du mot clef qui est utilisé comme bannière du site.\n\n{{Attention}} : si vous avez déjà défini une bannière avec le logo de survol du site, alors, cette dernière n'est plus utilisée ; seuls les logos des mots clefs de ce groupe seront pris en compte.\n\nLes mots clefs affectés à une rubrique restreignent le choix des bannières pour la branche entière à celles affectées à la rubrique. Le fonctionnement pour le reste du site est inchangé ({{toutes}} les bannières sont disponibles pour le reste du site).\n\nSe reporter à la documentation sur [Personnalisation graphique du squelette SoyezCreateurs->https://contrib.spip.net/Personnalisation-graphique-du-squelette-SoyezCreateurs].\n\nPour mettre une trame de fond, utiliser le logo de survol.\n\nUn site pour [créer des trames de fond->http://www.patternify.com/].", 'non', 'non', 'rubriques', 'oui', 'non', 'non');			
			create_groupe("_FooterBanner", "Pour définir plusieurs fonds de pied de page pour le site.", "Il faut créer un mot clef par fond (le titre n'a pas d'importance).\n\nC'est le logo du mot clef qui est utilisé comme fond de pied du site.\n\nLes mots clefs affectés à une rubrique restreignent le choix des fonds pour la branche entière à celles affectées à la rubrique. Le fonctionnement pour le reste du site est inchangé ({{tous}} les fonds sont disponibles pour le reste du site).\n\nSe reporter à la documentation sur [Personnalisation graphique du squelette SoyezCreateurs->https://contrib.spip.net/Personnalisation-graphique-du-squelette-SoyezCreateurs].\n\nPour mettre une trame de fond, utiliser le logo de survol.\n\nUn site pour [créer des trames de fond->http://www.patternify.com/].", 'non', 'non', 'rubriques', 'oui', 'non', 'non');			
			spip_log("SoyezCreateurs maj 3.1.45 Faite", "soyezcreateurs_install");
			ecrire_meta($nom_meta_base_version,$current_version='3.1.45','non');
		}
		if (version_compare($current_version,'3.1.46','<')) {
			spip_log("SoyezCreateurs maj 3.1.46 Début", "soyezcreateurs_install");
			ecrire_meta('version_html_max', 'html4', 'non');
			ecrire_meta($nom_meta_base_version,$current_version='3.1.46','non');
		}
		if (version_compare($current_version,'3.1.47','<')) {
			spip_log("SoyezCreateurs maj 3.1.47 Début", "soyezcreateurs_install");
			$id_mot = create_mot("_Specialisation_Rubrique", "PasDansMenuHaut", "Pour interdire que la rubrique (et ses sous-rubriques) soi(en)t dans le menu du haut", "");
			ecrire_meta($nom_meta_base_version,$current_version='3.1.47','non');
		}
		if (version_compare($current_version,'3.1.49','<')) {
			spip_log("SoyezCreateurs maj 3.1.49 Début", "soyezcreateurs_install");
			ecrire_config('boutonstexte/selector','#contenu');
			// On invalide les caches
			include_spip('inc/invalideur');
			suivre_invalideur("soyezcreateurs");
			ecrire_meta($nom_meta_base_version,$current_version='3.1.49','non');
		}
		
		
		/*if (version_compare($current_version,'3.0.10','<')) {
			create_document('documents/image.jpg', array('objet' => 'article', 'id_objet' => 3), 'image', array('titre' => 'Mon image', 'descriptif' => 'Superbe image'));
		}
		*/
		/*
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
