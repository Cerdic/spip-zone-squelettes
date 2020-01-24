<?php
/**
 * Fichier gérant l'installation et désinstallation du plugin Sendagi
 *
 * @plugin     Sendagi
 * @copyright  2019
 * @author     erational
 * @licence    GNU/GPL
 * @package    SPIP\Sendagi\Installation
 */

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

include_spip('inc/meta');
include_spip('inc/cextras');
include_spip('base/sendagi');


/**
 * Fonction d'installation et de mise à jour du plugin Sendagi.
 *
 * @param string $nom_meta_base_version
 *     Nom de la meta informant de la version du schéma de données du plugin installé dans SPIP
 * @param string $version_cible
 *     Version du schéma de données dans ce plugin (déclaré dans paquet.xml)
 * @return void
**/
function sendagi_upgrade($nom_meta_base_version, $version_cible) {
	$maj = array();

	cextras_api_upgrade(sendagi_declarer_champs_extras(), $maj['create']);
	$maj['create'][] = 	array('sendagi_peupler_selections_editoriales');

	include_spip('base/upgrade');
	maj_plugin($nom_meta_base_version, $version_cible, $maj);
}


/**
 * Fonction de désinstallation du plugin Sendagi
 *
 * @param string $nom_meta_base_version
 *     Nom de la meta informant de la version du schéma de données du plugin installé dans SPIP
 * @return void
**/
function sendagi_vider_tables($nom_meta_base_version) {
	cextras_api_vider_tables(sendagi_declarer_champs_extras());
	effacer_config('sendagi');
	sql_delete('spip_selections', 'identifiant IN ("accueil-diaporama", "accueil-contenu", "accueil-extra")');  // vite fait.... on n'a pas efface les objets des tables liés
	effacer_meta($nom_meta_base_version);
	ecrire_metas();
}

/**
 * Fonction pour créer automatiquement les selections éditoriales nécessaires à la page d'accueil
 *
 * @return void
**/

function sendagi_peupler_selections_editoriales() {
	// accueil-diaporama
	$sql = array(
		'titre' => _T('sendagi:selections_editoriales_accueil_diaporama'),
		'descriptif' => _T('sendagi:selections_editoriales_accueil_diaporama_descriptif'),
		'identifiant' => 'accueil-diaporama',
		'limite' => '10',
	);
	$id_selection = sql_insertq('spip_selections', $sql);

	// accueil-contenu
	$sql = array(
		'titre' => _T('sendagi:selections_editoriales_accueil_contenu'),
		'descriptif' => _T('sendagi:selections_editoriales_accueil_contenu_descriptif'),
		'identifiant' => 'accueil-contenu',
		'limite' => '0',
	);
	$id_selection = sql_insertq('spip_selections', $sql);

	// accueil-extra
	$sql = array(
		'titre' => _T('sendagi:selections_editoriales_accueil_extra'),
		'descriptif' => _T('sendagi:selections_editoriales_accueil_extra_descriptif'),
		'identifiant' => 'accueil-extra',
		'limite' => '0',
	);
	$id_selection = sql_insertq('spip_selections', $sql);
}
