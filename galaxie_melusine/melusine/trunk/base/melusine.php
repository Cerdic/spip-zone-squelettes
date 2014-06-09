<?php
/**
 * Déclarations relatives à la base de données
 *
 * @plugin     Mélusine
 * @copyright  2014
 * @author     Bertrand
 * @licence    GNU/GPL
 * @package    SPIP\Melusine\Pipelines
 */

if (!defined('_ECRIRE_INC_VERSION')) return;


/**
 * Déclaration des alias de tables et filtres automatiques de champs
 *
 * @pipeline declarer_tables_interfaces
 * @param array $interfaces
 *     Déclarations d'interface pour le compilateur
 * @return array
 *     Déclarations d'interface pour le compilateur
 */
function melusine_declarer_tables_interfaces($interfaces) {

	// vérification de la présence du noizetier
	include_spip('inc/filtres');
	$f = chercher_filtre('info_plugin');
	$noiz_actif = $f("noizetier","est_actif");

	// Si pas noizetier, on crée la base...
	if (!$noiz_actif)
		$interfaces['table_des_tables']['noisettes'] = 'noisettes';
	return $interfaces;
}


/**
 * Déclaration des objets éditoriaux
 *
 * @pipeline declarer_tables_objets_sql
 * @param array $tables
 *     Description des tables
 * @return array
 *     Description complétée des tables
 */
function melusine_declarer_tables_objets_sql($tables) {

	// vérification de la présence du noizetier
	include_spip('inc/filtres');
	$f = chercher_filtre('info_plugin');
	$noiz_actif = $f("noizetier","est_actif");

	// Si pas noizetier, on crée lles tables
	if (!$noiz_actif)
		$tables['spip_noisettes'] = array(
			'type' => 'noisette',
			'principale' => "oui",
			'field'=> array(
				"id_noisette"        => "bigint(21) NOT NULL",
				"rang"               => "int(6) NOT NULL DEFAULT 1",
				"type"               => "tinytext NOT NULL DEFAULT ''",
				"bloc"               => "tinytext NOT NULL DEFAULT ''",
				"noisette"           => "tinytext NOT NULL DEFAULT ''",
				"parametres"         => "text NOT NULL DEFAULT ''",
				"css"                => "tinytext NOT NULL DEFAULT ''",
				"maj"                => "TIMESTAMP"
			),
			'key' => array(
				"PRIMARY KEY"        => "id_noisette",
				"PRIMARY KEY"        => "id_noisette",
			),
			'titre' => "'' AS titre, '' AS lang",
			#'date' => "",
			'champs_editables'  => array('rang', 'type', 'bloc', 'noisette', 'parametres', 'css'),
			'champs_versionnes' => array('rang', 'type', 'bloc', 'noisette', 'parametres', 'css'),
			'rechercher_champs' => array(),
			'tables_jointures'  => array(),
			

		);

	return $tables;
}



?>