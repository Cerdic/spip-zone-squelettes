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
				include_spip('inc/fulltext_exec');
				Fulltext_creer_tous();
			}
			// Installation d'exemples concernant l'agenda si le plugin est actif
			if ($f('agenda', 'est_actif')) {
				// Réserve le formulaire des événements aux seules rubriques d'Agenda (avec le plugin agenda 2 installé)
				sql_update('spip_rubriques INNER JOIN spip_mots_rubriques ON spip_rubriques.id_rubrique = spip_mots_rubriques.id_rubrique INNER JOIN spip_mots ON spip_mots_rubriques.id_mot=spip_mots.id_mot', array('spip_rubriques.agenda' => 1), 'spip_mots.titre='.sql_quote('Agenda'));
				include_spip('inc/sc_article');
				
				$id_rubrique = id_rubrique('900. Agenda');
				if ($id_rubrique >0) {
					$date = date('Y-m-d H:i:00');
					create_evenement("900. Agenda", "Installation du site", "Installation du site", $date, $date, "Quand le titre de l'événement est identique au titre de l'article, il n'est pas affiché en plus", 'Votre serveur web.');
					create_evenement("900. Agenda", "Installation du site", "Installé !", $date, $date, "Quand le titre de l'événement est différent du titre de l'article, alors, les 2 titres sont affichés.", '');
					create_evenement("900. Agenda", "Événement exceptionnel", "Événement exceptionnel", date('Y-m-d 20:30:00'), date('Y-m-d 22:30:00'), "Quand l'heure de début est différente de l'heure de fin, c'est un événement avec une durée...", '');
					create_evenement("10. SPIP", "Historique des versions de SPIP", "SPIP 2.1", '2010-04-09', '2010-04-09', "[->http://www.spip.net/fr_article4728.html]", '', 'non');
					create_evenement("10. SPIP", "Historique des versions de SPIP", "SPIP 2.0", '2008-12-13', '2008-12-13', "[->http://www.spip.net/fr_article3784.html]", '', 'non');
					create_evenement("900. Agenda", "Démonstration Agenda", "Démonstration Agenda", '2017-12-13', '2017-12-13', "", '', 'non');
				}
			}
			spip_log("SoyezCreateurs maj 3.0.20 Faite", "soyezcreateurs_install");
			ecrire_meta($nom_meta_base_version,$current_version='3.0.20','non');
		}

		if (version_compare($current_version,'3.0.23','<')) {
			spip_log("SoyezCreateurs maj 3.0.23 Début", "soyezcreateurs_install");
			// Activer les lames du CouteauSuisse Special SoyezCreateurs
			$f = chercher_filtre('info_plugin');
			if ($f('couteau_suisse', 'est_actif')) {
				include_spip('couteau_suisse_administrations');
				cout_install_pack('SoyezCreateurs');
				include_spip('outils/boites_privees');
				tri_auteurs_verifie_table(true);
				cout_exec_redirige(false);
			}
			spip_log("SoyezCreateurs maj 3.0.23 Faite", "soyezcreateurs_install");
			ecrire_meta($nom_meta_base_version,$current_version='3.0.23','non');
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
		
		if (version_compare($current_version,'3.0.29','<')) {
			spip_log("SoyezCreateurs maj 3.0.29 Début", "soyezcreateurs_install");
			create_groupe("_FondPage", "Images en fond de page :\n-* Créer autant de mots clefs que de fonds de page désirés\n-* Mettre un logo à ces mots clefs\n-* Possibilité de fixer un fond de page pour :\n-** Une rubrique (et la branche en dessous)\n-** Un type de page particulier (Sommaire, Plan)\n\nSe reporter à la documentation sur [Personnalisation graphique du squelette SoyezCreateurs->http://contrib.spip.net/Personnalisation-graphique-du-squelette-SoyezCreateurs]", "", 'oui', 'non', 'non', 'non', 'oui', 'non', 'non', 'oui', 'non', 'non');
			
			spip_log("SoyezCreateurs maj 3.0.29 Faite", "soyezcreateurs_install");
			ecrire_meta($nom_meta_base_version,$current_version='3.0.29','non');
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
		if (version_compare($current_version,'3.0.32','<')) {
			spip_log("SoyezCreateurs maj 3.0.32 Début", "soyezcreateurs_install");
			$id_mot = create_mot("_Specialisation_Rubrique", "GisSecteur", "Mettre ce mot clef à une rubrique où l'on veut afficher la carte Gis pour l'ensemble du Secteur (Rubrique racine de SPIP et toutes ses sous rubriques).", "");
			ecrire_meta($nom_meta_base_version,$current_version='3.0.32','non');
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
		if (version_compare($current_version,'3.0.35','<')) {
			spip_log("SoyezCreateurs maj 3.0.33 Début", "soyezcreateurs_install");
			$id_mot = create_mot("_ModePortail", "Goodies2", "Affecter ce mot clef aux objets SPIP devant apparaitre dans la zone des Goodies (en mode international, sous la Une).", "");
			ecrire_meta($nom_meta_base_version,$current_version='3.0.35','non');
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
