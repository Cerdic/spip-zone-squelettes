<?php
/**
 * Fichier gérant l'installation et désinstallation du plugin Html5_landed
 *
 * @plugin     Html5_landed
 * @copyright  2017
 * @author     Nicolas Dorigny
 * @licence    GNU/GPL
 * @package    SPIP\Html5_landed\Installation
 */

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

include_spip('base/upgrade');
include_spip('inc/config');
include_spip('action/editer_groupe_mots');
include_spip('action/editer_mot');

/**
 * Fonction d'installation et de mise à jour du plugin html5_landed.
 *
 * @param string $nom_meta_base_version
 *     Nom de la meta informant de la version du schéma de données du plugin installé dans SPIP
 * @param string $version_cible
 *     Version du schéma de données dans ce plugin (déclaré dans paquet.xml)
 *
 * @return void
 **/
function html5_landed_upgrade($nom_meta_base_version, $version_cible) {
	$maj = array();

	$maj['create'] = array(
		array('html5_landed_creer_mots'),
	);

	maj_plugin($nom_meta_base_version, $version_cible, $maj);
}

/**
 * Fonction de désinstallation du plugin Html5_landed.
 *
 * @param string $nom_meta_base_version
 *     Nom de la meta informant de la version du schéma de données du plugin installé dans SPIP
 *
 * @return void
 **/
function html5_landed_vider_tables($nom_meta_base_version) {

	// Supprimer les mots clés
	$id_groupe = lire_config('html5_landed/id_groupe_articles');
	sql_delete('spip_groupes_mots', 'id_groupe = '.$id_groupe);
	$mots = sql_allfetsel('id_mot','spip_mots','id_groupe = '.$id_groupe);
	foreach ($mots as $mot) {
		mot_supprimer($mot['id_mot']);
	}
	effacer_meta('html5_landed');
	effacer_meta($nom_meta_base_version);
}

/**
 * Fonction qui génère les mots clés nécessaires au fonctionnement de Html5_landed.
 *
 * @return void
 **/
function html5_landed_creer_mots() {
	$titre_groupe = 'HTML5UP Landed';

	// mots sur les articles
	
	$id_groupe = groupe_mots_inserer();
	groupe_mots_modifier($id_groupe, array(
		'titre'        => $titre_groupe,
		'tables_liees' => 'articles',
		'un_seul'      => 'non',
		'obligatoire'  => 'non',
		'minirezo'     => 'oui',
		'comite'       => 'oui',
		'forum'        => 'non',
	));
	ecrire_config('html5_landed/id_groupe_articles', $id_groupe);

	html5_landed_inserer_mot('01. '._T('html5_landed:mot_article_une'), '', 'sommaire', $id_groupe, $titre_groupe);
	html5_landed_inserer_mot('02. '._T('html5_landed:mot_mot_intro_dessous'), '', 'intro_dessous', $id_groupe, $titre_groupe);
	html5_landed_inserer_mot('03. '._T('html5_landed:mot_mot_intro_droite'), '', 'intro_droite', $id_groupe, $titre_groupe);
	html5_landed_inserer_mot('04. '._T('html5_landed:mot_mot_intro_gauche'), '', 'intro_gauche', $id_groupe, $titre_groupe);

}

function html5_landed_inserer_mot($titre, $descriptif, $identifiant, $id_groupe, $titre_groupe) {
	$id_mot = mot_inserer($id_groupe);
	mot_modifier($id_mot, array(
		'titre'      => $titre,
		'descriptif' => $descriptif,
	));
	ecrire_config('html5_landed/id_mot_' . $identifiant, $id_mot);
}