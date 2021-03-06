<?php
/*
* Configuration de SPIP pour SoyezCreateurs
* Realisation : RealET : real3t@gmail.com
* Attention, fichier en UTF-8 sans BOM
*/

if (!defined("_ECRIRE_INC_VERSION")) return;

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
			$id_mot = id_mot("membre", $id_groupe);
			if ($id_mot>0) {
				sql_delete("spip_mots", "id_mot=$id_mot");
				sql_delete("spip_mots_articles", "id_mot=$id_mot");
				sql_delete("spip_mots_rubriques", "id_mot=$id_mot");
				sql_delete("spip_mots_syndic", "id_mot=$id_mot");
				sql_delete("spip_mots_forum", "id_mot=$id_mot");
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
			$mentions = array('titre' => 'Mentions légales & conditions d’utilisation', 'texte' => '');
			$id_groupe = id_groupe("_InformationsLegales");
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
			create_mot("_ModePortail", "Goodies", "Affecter ce mot clef aux objets SPIP devant apparaitre dans la zone des Goodies (en bas du sommaire du mode portail, sur une colonne).", "S'applique aux articles uniquement.\n\nLe site prendra les 3 derniers articles ayant ce mot clef");
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

		/*
		#En attente
		if (version_compare($current_version,'2.1.10','<')) {
			include_spip('base/soyezcreateurs');
			spip_log("SoyezCreateurs maj 2.1.10", "soyezcreateurs_install");
			create_groupe("_TypeRubrique", "Pour indiquer un type spécifique de rubrique", "Il faut choisir un mot clef dans cette liste pour obtenir un affichage spécifique de rubrique.\n\nNB : pour rajouter un mot clef \"mc1\", il faut aussi rajouter les squelettes correspondants :\n-* noisettes/rubriques/typerubrique_mc1.html\n-* noisettes/footer/footer_typerubrique_mc1.html\n-* noisettes/articles/typearticle_mc1.html", 'oui', 'non', 'non', 'non', 'oui', 'non', 'non', 'oui', 'non', 'non');
				create_mot("_TypeRubrique", "annuaire", "Pour dire que la rubrique ayant ce mot clef doit utiliser le squelette type des annuaires.", "Affecter ce mot clef à chaque rubrique racine d'un annuaire.");
			create_groupe("_TypeArticle", "Pour indiquer un type spécifique d'article", "Il faut choisir un mot clef dans cette liste pour obtenir un affichage spécifique d'article.\n\nNB : pour rajouter un mot clef \"mc1\", il faut aussi rajouter les squelettes correspondants :\n-* noisettes/articles/typearticle_mc1.html\n-* noisettes/footer/footer_typearticle_mc1.html", 'oui', 'non', 'oui', 'non', 'non', 'non', 'non', 'oui', 'non', 'non');
				create_mot("_TypeArticle", "annuaire", "Pour dire que l'article ayant ce mot clef doit utiliser le squelette type des annuaire.", "Affecter ce mot clef à chaque article de l'annuaire.");
			ecrire_meta($nom_meta_base_version,$current_version='2.1.10','non');
		}
		// A integrer quand SPIP permettra d'avoir des critères optionnels sur un champ de table innexistant
		// en l'occurrence, remplacer dans le squelette {titre_mot=Agenda} par {agenda=1}
		if (version_compare($current_version,'2.1.14','<')) {
			include_spip('base/soyezcreateurs');
			spip_log("SoyezCreateurs maj 2.1.14", "soyezcreateurs_install");
			sql_query('UPDATE spip_rubriques INNER JOIN spip_mots_rubriques ON spip_rubriques.id_rubrique=spip_mots_rubriques.id_rubrique INNER JOIN spip_mots ON spip_mots_rubriques.id_mot=spip_mots.id_mot 
SET spip_rubriques.agenda = 1
WHERE spip_mots.titre=\'Agenda\'');
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
