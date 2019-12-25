<?php
if (!defined("_ECRIRE_INC_VERSION")) return;




/**
 * Déclarer la liste des rôles
 *
 * @note
 * L'API des rôles impose de donner un rôle par défaut : on ne peut pas dissocier des objets sans rôle.
 *
 * @param array $tables
 * 		Description des tables
 * @return array
 * 		Description complétée des tables
 */
function html5up_massively_declarer_tables_objets_sql($tables) {

	include_spip('inc/config');

	// Le rôle par défaut est 'document', ça revient à dire que le document lié n'a aucun rôle particulier.
	$roles_documents = array(
		'document' => 'roles_documents:role_document',
		'arriereplan'    => 'massively:arriereplan'
	);
	// Si les logos sont activés, on les propose en rôles supplémentaires
	$config_logos = array(
		'logo'        => lire_config('activer_logos'),
		'logo_survol' => lire_config('activer_logos_survol'),
	);
	foreach ($config_logos as $role => $config) {
		if ($config == 'oui') {
			$roles_documents[$role] = "roles_documents:role_$role";
		}
	}
	$choix = array_keys($roles_documents);

	array_set_merge($tables, 'spip_documents', array(
		'roles_colonne' => 'role',
		'roles_titres' => $roles_documents,
		'roles_objets' => array(
			'*' => array(
				'choix' => $choix,
				'defaut' => 'document',
				'principaux' => array(
					'logo',
					'logo_survol',
					'arriereplan'
				),
			)
		),
	));

	return $tables;
}

