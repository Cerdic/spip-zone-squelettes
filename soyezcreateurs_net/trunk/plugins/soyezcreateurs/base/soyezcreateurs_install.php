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

			spip_log("SoyezCreateurs maj 3.0.20 Faite", "soyezcreateurs_install");
			ecrire_meta($nom_meta_base_version,$current_version='3.0.20','non');
		}

		if (version_compare($current_version,'3.0.22','<')) {
			spip_log("SoyezCreateurs maj 3.0.22 Début", "soyezcreateurs_install");
			// Activer les lames du CouteauSuisse Special SoyezCreateurs
			$f = chercher_filtre('info_plugin');
			if ($f('couteau_suisse', 'est_actif')) {
				include_spip('base/cout_install');
				cout_install_pack('SoyezCreateurs');
				ecrire_metas();
				include_spip('inc/invalideur');
				suivre_invalideur('1'); # tout effacer
				include_spip('inc/getdocument');
				effacer_repertoire_temporaire(_DIR_TMP.'couteau-suisse');
			}
			spip_log("SoyezCreateurs maj 3.0.22 Faite", "soyezcreateurs_install");
			ecrire_meta($nom_meta_base_version,$current_version='3.0.22','non');
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
			
			spip_log("SoyezCreateurs maj 3.0.28 Faite", "soyezcreateurs_install");
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
