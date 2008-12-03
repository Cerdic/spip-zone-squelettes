<?php
/*
* Configuration de SPIP pour SoyezCreateurs
* Realisation : RealET : real3t@gmail.com
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
	$current_version = 0.0;
	if (   (!isset($GLOBALS['meta'][$nom_meta_base_version]) )
			|| (($current_version = $GLOBALS['meta'][$nom_meta_base_version])!=$version_cible)){
		if (
			(version_compare($current_version,'2.1','<'))
			&& // Verification que le plugin n'a pas ete deja installe par l'ancienne methode
			(sql_countsel('spip_groupes_mots', "(titre = '_LayoutGala')") != 0)
		) {
			echo "SoyezCreateurs d&eacute;j&agrave; install&eacute; <br />";
			ecrire_meta($nom_meta_base_version,$current_version='2.1','non');
		}
		if (version_compare($current_version,'2.1','<')) {
			include_spip('base/soyezcreateurs');
			soyezcreateurs_config_site();
			soyezcreateurs_config_motsclefs();
			echo "SoyezCreateurs Install 2.1<br />";
			ecrire_meta($nom_meta_base_version,$current_version='2.1','non');
		}
		if (
			(version_compare($current_version,'2.1.3','<'))
			&& // Verification que les mots clefs ont bien ete supprimes
			(sql_countsel('spip_mots', "(titre = 'NewsLetter')") != 0)
		) {
			ecrire_meta($nom_meta_base_version,$current_version='2.1','non');
		}
		if (version_compare($current_version,'2.1.1','<')) {
			include_spip('base/soyezcreateurs');
			// Suppresion de "_Specialisation", "Gallerie"
			$id_mot = id_mot("Gallerie");
			if ($id_mot>0) {
				sql_delete("spip_mots", "id_mot=$id_mot");
				sql_delete("spip_mots_articles", "id_mot=$id_mot");
				sql_delete("spip_mots_rubriques", "id_mot=$id_mot");
				sql_delete("spip_mots_syndic", "id_mot=$id_mot");
				sql_delete("spip_mots_forum", "id_mot=$id_mot");
			}
			echo "SoyezCreateurs MaJ 2.1.1<br />";
			ecrire_meta($nom_meta_base_version,$current_version='2.1.1','non');
		}
		if (version_compare($current_version,'2.1.2','<')) {
			include_spip('base/soyezcreateurs');
			// Suppresion de "_Specialisation_Rubrique", "NewsLetter"
			$id_mot = id_mot("NewsLetter");
			if ($id_mot>0) {
				sql_delete("spip_mots", "id_mot=$id_mot");
				sql_delete("spip_mots_articles", "id_mot=$id_mot");
				sql_delete("spip_mots_rubriques", "id_mot=$id_mot");
				sql_delete("spip_mots_syndic", "id_mot=$id_mot");
				sql_delete("spip_mots_forum", "id_mot=$id_mot");
			}
			echo "SoyezCreateurs MaJ 2.1.2<br />";
			ecrire_meta($nom_meta_base_version,$current_version='2.1.2','non');
		}
		if (version_compare($current_version,'2.1.3','<')) {
			include_spip('base/soyezcreateurs');
			create_mot("_Specialisation", "MenuFooter", "Affecter ce mot clef aux articles devant être affichés dans le menu de pied de page.", "Les liens vers les articles seront faits triés par numéro de titre.\n\nIl est bien sûr possible de faire des articles de redirection...");
			echo "SoyezCreateurs MaJ 2.1.3<br />";
			ecrire_meta($nom_meta_base_version,$current_version='2.1.3','non');
		}
	}
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
