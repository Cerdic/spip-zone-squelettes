<?php
/*
* Configuration de SPIP pour SoyezCreateurs
* Realisation : RealET : real3t@gmail.com
* Attention, fichier en UTF-8 sans BOM
*/

if (!defined('_ECRIRE_INC_VERSION')) return;

include_spip('inc/meta');
include_spip('inc/sc_utils');
include_spip('inc/cextras');
include_spip('base/soyezcreateurs');
/*
 * Fonction d'installation, mise a jour de la base
 *
 * @param unknown_type $nom_meta_base_version
 * @param unknown_type $version_cible
 */
function soyezcreateurs_upgrade($nom_meta_base_version,$version_cible){
	if (defined('_BYPASS_SC_INSTALL')) return;
	include_spip('base/soyezcreateurs');
	$maj = array();
	
	$maj['3.0.20'] = array( array('soyezcreateurs_3_0_20') );
	$maj['3.0.24'] = array( array('soyezcreateurs_3_0_24') );
	$maj['3.0.28'] = array( array('soyezcreateurs_3_0_28') );
	$maj['3.0.30'] = array( array('soyezcreateurs_3_0_30') );
	$maj['3.0.31'] = array( array('soyezcreateurs_3_0_31') );
	$maj['3.0.33'] = array( array('soyezcreateurs_3_0_33') );
	$maj['3.0.34'] = array( array('soyezcreateurs_3_0_34') );
	$maj['3.1.35'] = array( array('soyezcreateurs_3_1_35') );
	$maj['3.1.36'] = array( array('soyezcreateurs_3_1_36') );
	$maj['3.1.39'] = array( array('soyezcreateurs_3_1_39') );
	$maj['3.1.40'] = array( array('soyezcreateurs_3_1_40') );
	$maj['3.1.41'] = array( array('soyezcreateurs_3_1_41') );
	$maj['3.1.42'] = array( array('soyezcreateurs_3_1_42') );
	$maj['3.1.43'] = array( array('soyezcreateurs_3_1_43') );
	$maj['3.1.44'] = array( array('soyezcreateurs_3_1_44') );
	$maj['3.1.45'] = array( array('soyezcreateurs_3_1_45') );
	$maj['3.1.46'] = array( array('soyezcreateurs_3_1_46') );
	$maj['3.1.47'] = array( array('soyezcreateurs_3_1_47') );
	$maj['3.1.49'] = array( array('soyezcreateurs_3_1_49') );
	$maj['3.1.50'] = array( array('soyezcreateurs_3_1_50') );
	$maj['3.1.51'] = array( array('soyezcreateurs_3_1_51') );
	$maj['3.1.52'] = array( array('soyezcreateurs_3_1_52') );
	$maj['3.1.53'] = array( array('soyezcreateurs_3_1_53') );
	$maj['3.1.54'] = array( array('soyezcreateurs_3_1_54') );
	$maj['3.1.55'] = array( array('soyezcreateurs_3_1_55') );
	cextras_api_upgrade(soyezcreateurs_declarer_champs_extras(), $maj['3.1.58']);
	$maj['3.1.59'] = array( array('soyezcreateurs_3_1_59') );
	$maj['3.1.62'] = array( 
		array('soyezcreateurs_3_1_61'),
		array('soyezcreateurs_3_1_62')
	);
	$maj['3.1.63'] = array( 
		array('soyezcreateurs_3_1_63')
	);
	$maj['3.1.64'] = array( 
		array('soyezcreateurs_3_1_64'),
		array('soyezcreateurs_finalisationinstall') /* À rajouter à la fin systématiquement */
	);
		
	include_spip('base/upgrade');
	maj_plugin($nom_meta_base_version, $version_cible, $maj);
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

function soyezcreateurs_3_0_20() {
	soyezcreateurs_config_site();
	soyezcreateurs_config_motsclefs();
	// Installation des index FullText si le plugin est présent
	$f = chercher_filtre('info_plugin');
	if($f('Fulltext', 'est_actif')) {
		include_spip('inc/fulltext_creer_index');
		fulltext_liste_creer_index('all');
	}
}

function soyezcreateurs_3_0_24() {
	// Initialisation Sigles du dictionnaire
	if (defined('_DIR_PLUGIN_DICTIONNAIRES')) {
		include_spip('action/editer_dictionnaire');
		$id_dictionnaire = sql_fetsel("id_dictionnaire", "spip_dictionnaires", "titre='"._T('dictionnaire:importer_acronymes_titre')."'");
		if (is_array($id_dictionnaire)) {
			$id_dictionnaire = $id_dictionnaire['id_dictionnaire'];
		}
		if (!$id_dictionnaire) {
			if ($id_dictionnaire = insert_dictionnaire()){
				autoriser_exception('modifier', 'dictionnaire', $id_dictionnaire);
				// On lui met des champs par défaut
				dictionnaire_set($id_dictionnaire, array(
					'titre' => _T('dictionnaire:importer_acronymes_titre'),
					'statut' => 'actif',
					'descriptif' => _T('dictionnaire:importer_acronymes_descriptif'),
					'type_defaut' => 'abbr',
				));
				autoriser_exception('modifier', 'dictionnaire', $id_dictionnaire, false);
			}
		}
		if ($id_dictionnaire) {
			// 0 et pas $id_dictionnaire 
			// car insert_definition a utilisé les valeurs par défaut
			autoriser_exception('publierdans', 'dictionnaire', 0);
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
					autoriser_exception('modifier', 'definition', $id_definition);
					definition_set($id_definition, $definition, false);
					autoriser_exception('modifier', 'definition', $id_definition, false);
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
					autoriser_exception('modifier', 'definition', $id_definition);
					definition_set($id_definition, $definition, false);
					autoriser_exception('modifier', 'definition', $id_definition, false);
				}
			autoriser_exception('publierdans', 'dictionnaire', 0, false);
			}
		}
		// On calcule le cache des définitions une seule fois à la fin
		include_spip('inc/dictionnaires');
		dictionnaires_lister_definitions(true);
		
	}
}

function soyezcreateurs_3_0_28() {
	// Au cas où : remttre au carré les id_secteur des articles et rubriques.
	include_spip('inc/rubriques');
	calculer_rubriques();
	propager_les_secteurs();
	effacer_meta("date_calcul_rubriques");
}

function soyezcreateurs_3_0_30() {
	$id_mot = create_mot("_ModePortail", "ZoomSur2_Variante1", "Affecter ce mot clef à l’objet que vous voulez placer dans le cadre « Zoom sur secondaire » (facultatif).\n\nLe site prendra le dernier article ayant ce mot clef.", "Variante sur 2 colonnes : \n-* Titre de la rubrique contenant l’article\n-* 1re colonne :\n-** Document joint (de type autre média, PowerPoint par exemple) affiché avec son logo\n-** Chapo de l'article en dessous (permet de faire un lien)\n-* 2e colonne :\n-** Logo de l’article\n-** faisant un lien vers l’article (et si c’est une redirection, ça peut conduire à une autre page");
}

function soyezcreateurs_3_0_31() {
	$id_mot = create_mot("_ModePortail", "ZoomSur2_Variante2", "Affecter ce mot clef à l’objet que vous voulez placer dans le cadre « Zoom sur secondaire » (facultatif).\n\nLe site prendra le dernier article ayant ce mot clef.", "Variante sur 2 colonnes : \n-* Titre de la rubrique contenant l’article\n-* 1re colonne :\n-** Fonctionne comme le Cycloshow avec les articles de la sous rubriques de la rubrique de l'article\n-* 2e colonne :\n-** Logo de l’article\n-** faisant un lien vers l’article (et si c’est une redirection, ça peut conduire à une autre page");
}

function soyezcreateurs_3_0_33() {
	$id_mot = create_mot("_Specialisation_Rubrique", "ClassementAlpha", "Mettre ce mot clef à la rubrique pour classer son contenu alphabétiquement.", "");
}

function soyezcreateurs_3_0_34() {
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
}

function soyezcreateurs_3_1_35() {
	supprimer_mot_groupe("_Specialisation_Rubrique", "GisSecteur");
}

function soyezcreateurs_3_1_36() {
	ecrire_config('boutonstexte/skin','soyezcreateurs');
}

function soyezcreateurs_3_1_39() {
	ecrire_meta('orthotypo',"a:7:{s:10:\"guillemets\";s:1:\"1\";s:9:\"exposants\";s:1:\"1\";s:4:\"mois\";s:1:\"1\";s:4:\"caps\";s:1:\"0\";s:5:\"fines\";s:1:\"0\";s:11:\"corrections\";s:1:\"1\";s:18:\"corrections_regles\";s:319:\"oeuf = œuf\ncceuil = ccueil\n(a priori) = {a priori}\n(([hH])uits) = $1uit\n/([cC]h?)oeur/ = $1œur\n/oeuvre/ = œuvre\n(O[Ee]uvre([rs]?)) = Œuvre$1\n/\b([cC]|[mM].c|[rR]ec)on+ais+a((?:n(?:ce|te?)|ble)s?)\b/ = $1onnaissa$2\nCO2 = <abbr title=\"CO2, Dioxyde de carbone, O=C=O\">CO<sub>2</sub></abbr>\noeil = œil\n(O[Ee]il) = Œil\";}", 'non');
}

function soyezcreateurs_3_1_40() {
	create_groupe("_TypeArticle", "Pour indiquer un type spécifique d'article", "Il faut choisir un mot clef dans cette liste pour obtenir un affichage spécifique d'article.\n\nNB : pour rajouter un mot clef \"mc1\", il faut aussi rajouter les squelettes correspondants :\n-* noisettes/articles/typearticle_mc1.html", 'oui', 'non', 'articles', 'oui', 'non', 'non');
}

function soyezcreateurs_3_1_41() {
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
}

function soyezcreateurs_3_1_42() {
	supprimer_mot_groupe('_HTTP-EQUIV','pics-label');
}

function soyezcreateurs_3_1_43() {
	create_groupe("_FondPage", "Images en fond de page :\n-* Créer autant de mots clefs que de fonds de page désirés\n-* Mettre un logo à ces mots clefs\n-* Possibilité de fixer un fond de page pour :\n-** Une rubrique (et la branche en dessous)\n-** Un type de page particulier (Sommaire, Plan)\n\nSe reporter à la documentation sur [Personnalisation graphique du squelette SoyezCreateurs->https://contrib.spip.net/Personnalisation-graphique-du-squelette-SoyezCreateurs].\n\nPour mettre une trame de fond, utiliser le logo de survol.\n\nUn site pour [créer des trames de fond->http://www.patternify.com/].", "", 'oui', 'non', 'rubriques', 'oui', 'non', 'non');
}

function soyezcreateurs_3_1_44() {
	$id_mot = create_mot("_ModePortail", "Goodies2", "Affecter ce mot clef aux objets SPIP devant apparaitre dans la zone des Goodies (en mode international, sous la Une).", "");
}

function soyezcreateurs_3_1_45() {
	create_groupe("_HeaderBanner", "Pour définir plusieurs bannières pour le site.", "Il faut créer un mot clef par bannière (le titre n'a pas d'importance).\n\nC'est le logo du mot clef qui est utilisé comme bannière du site.\n\n{{Attention}} : si vous avez déjà défini une bannière avec le logo de survol du site, alors, cette dernière n'est plus utilisée ; seuls les logos des mots clefs de ce groupe seront pris en compte.\n\nLes mots clefs affectés à une rubrique restreignent le choix des bannières pour la branche entière à celles affectées à la rubrique. Le fonctionnement pour le reste du site est inchangé ({{toutes}} les bannières sont disponibles pour le reste du site).\n\nSe reporter à la documentation sur [Personnalisation graphique du squelette SoyezCreateurs->https://contrib.spip.net/Personnalisation-graphique-du-squelette-SoyezCreateurs].\n\nPour mettre une trame de fond, utiliser le logo de survol.\n\nUn site pour [créer des trames de fond->http://www.patternify.com/].", 'non', 'non', 'rubriques', 'oui', 'non', 'non');			
	create_groupe("_FooterBanner", "Pour définir plusieurs fonds de pied de page pour le site.", "Il faut créer un mot clef par fond (le titre n'a pas d'importance).\n\nC'est le logo du mot clef qui est utilisé comme fond de pied du site.\n\nLes mots clefs affectés à une rubrique restreignent le choix des fonds pour la branche entière à celles affectées à la rubrique. Le fonctionnement pour le reste du site est inchangé ({{tous}} les fonds sont disponibles pour le reste du site).\n\nSe reporter à la documentation sur [Personnalisation graphique du squelette SoyezCreateurs->https://contrib.spip.net/Personnalisation-graphique-du-squelette-SoyezCreateurs].\n\nPour mettre une trame de fond, utiliser le logo de survol.\n\nUn site pour [créer des trames de fond->http://www.patternify.com/].", 'non', 'non', 'rubriques', 'oui', 'non', 'non');			
}

function soyezcreateurs_3_1_46() {
	ecrire_meta('version_html_max', 'html4', 'non');
}

function soyezcreateurs_3_1_47() {
	$id_mot = create_mot("_Specialisation_Rubrique", "PasDansMenuHaut", "Pour interdire que la rubrique (et ses sous-rubriques) soi(en)t dans le menu du haut", "");
}

function soyezcreateurs_3_1_49() {
	ecrire_config('boutonstexte/selector','#contenu');
}

function soyezcreateurs_3_1_50() {
	if (lire_config('soyezcreateurs/mode_affichage') == 'portailcognac') {
		sc_mig_mot('ZoomSur', '_ModePortail', 'EDITO', '_Specialisation', true);
	}
}

function soyezcreateurs_3_1_51() {
	$id_groupe_origine = id_groupe('_Specialisation');
	$id_mot = id_mot('PasDansRecherche', $id_groupe_origine);
	$id_groupe_dest = id_groupe('_Specialisation_Rubrique_ou_Article');
	remplacer_mot($id_mot, 'PasDansRecherche', 'Permet de masquer un article, ou le contenu d’une rubrique des résultats de la recherche', 'À affecter aux articles ou aux rubriques qui ne doivent pas être affichés dans les résultats de la recherche', $id_groupe_dest, '_Specialisation_Rubrique_ou_Article');
}

function soyezcreateurs_3_1_52() {
	if (lire_config('soyezcreateurs/mode_affichage') == 'portailcognac') {
		ecrire_config('soyezcreateurs/centrerlogo','oui');
	}
}

function soyezcreateurs_3_1_53() {
	include_spip('inc/soyezcreateurs_noizetier_config');
	sc_noisettespardefaut();
}

function soyezcreateurs_3_1_54() {
	$id_mot = create_mot("_Specialisation_Rubrique", "Blog", "Affecter ce mot clef à une rubrique pour que sa branche se comporte comme un blog.", "Avec ce mot clef : affichage des articles par ordre anti-chronologique pour tous les articles de la branche (et non de la rubrique en cours seulement).\n\nHéritage de la propriété pour les sous-rubriques.");
}

function soyezcreateurs_3_1_55() {
	$id_mot = create_mot("_TypeRubrique", "Mosaique", "Pour dire que la rubrique ayant ce mot clef doit utiliser le squelette type de Mosaïque.", "Affecter ce mot clef à chaque rubrique racine concernée. À la place de la rubrique, on aura la liste des articles, avec le logo de l'article.");
}

function soyezcreateurs_3_1_59() {
	ecrire_config('socialtags/jsselector','#socialtags');
	ecrire_config('socialtags/afterorappend','append');
	ecrire_config('socialtags/wopen','oui');
}

function soyezcreateurs_3_1_61() {
	$id_mot = create_mot("_Specialisation_Rubrique_ou_Article", "MasquerTelechargement", "Ne pas lister les documents à télécharger à la fin de l'article ou de la rubrique", "Affecter ce mot clef aux articles ou rubriques où vous ne voulez pas que les documents joints soient listés.");
}

function soyezcreateurs_3_1_62() {
	$id_groupe_origine = id_groupe('_Specialisation');
	$id_mot = id_mot('MenuFooter', $id_groupe_origine);
	$id_groupe_dest = id_groupe('_Specialisation_Rubrique_ou_Article');
	remplacer_mot($id_mot, 'MenuFooter', 'Affecter ce mot clef aux articles et rubriques devant être affichés dans le menu de pied de page.', "Les liens vers les articles seront faits triés par numéro de titre. Puis les rubriques par numéro de titre aussi.\n\nIl est bien sûr possible de faire des articles de redirection…", $id_groupe_dest, '_Specialisation_Rubrique_ou_Article');
}

function soyezcreateurs_3_1_63() {
	$id_mot = create_mot("_Specialisation_Rubrique", "BandeauPartenaires", "Mettre ce mot clef à la rubrique destinée à contenir les liens vers les partenaires à afficher dans le pied de page", "Mettre dans la rubrique des sites référencés avec Nom du site, descriptif, Logo, URL (RSS si vous voulez).");
	$id_parent = id_rubrique('000. Fourre-tout');
	if (!$id_parent > 0) {
		$id_parent = id_rubrique('000. Contenus transversaux');
	}
	if ($id_parent > 0) {
		$id_rubrique = create_rubrique("40. Partenaires", $id_parent, "Mettre dans cette rubrique les sites des partenaires");
			create_rubrique_mot("40. Partenaires", "BandeauPartenaires", "_Specialisation_Rubrique");
	}
}

function soyezcreateurs_3_1_64() {
	ecrire_config('bigup/max_file_size','64');
}


function soyezcreateurs_finalisationinstall() {
	// On termine en invalidant les caches
	include_spip('inc/invalideur');
	suivre_invalideur("soyezcreateurs");
	
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
	cextras_api_vider_tables(soyezcreateurs_declarer_champs_extras());
	effacer_meta($nom_meta_base_version);
}

