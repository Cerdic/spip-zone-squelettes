<?php

// Sécurité
if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

/**
 * Modifier le résultat de la compilation des squelettes des formulaires
 *
 * - Login : supprimer l'autofocus
 * - Recherche : ajouter un placeholder
 *
 * Supprimez ce pipeline si vous n'en n'avez pas besoin.
 *
 * @param array $flux
 * @return array
 */
function integraal_formulaire_fond($flux) {

	// Login : enlever autofocus
	if ($flux['args']['form'] == 'login'
		and strpos($flux['data'], 'autofocus')
	) {
		$cherche = '/autofocus\s?=\s?[\"\']autofocus[\"\']/i';
		$remplace = '';
		$flux['data'] = preg_replace($cherche, $remplace, $flux['data']);
	}

	// Recherche : ajouter placeholder
	if ($flux['args']['form'] == 'recherche') {
		$texte_rechercher = _T('info_rechercher');
		$cherche = '/name=[\"\']recherche[\"\']/i';
		$remplace = 'name="recherche" placeholder="'.$texte_rechercher.'"';
		$flux['data'] = preg_replace($cherche, $remplace, $flux['data']);
	}

	return $flux;
}

/**
 * Déclaration des objets éditoriaux
 *
 * Ajout de rôles sur les documents et les sélections éditoriales.
 *
 * Supprimez ce pipeline si vous n'en n'avez pas besoin.
 *
 * @pipeline declarer_tables_objets_sql
 *
 * @param array $tables
 *     Description des tables
 * @return array
 *     Description complétée des tables
 */
function integraal_declarer_tables_objets_sql($tables) {

	// Rôles sur les documents
	$roles_documents = array(
		'banner' => 'integraal:role_document_banner',
	);
	$tables['spip_documents'] = array_merge_recursive(
		$tables['spip_documents'],
		array(
			'roles_titres' => $roles_documents,
			'roles_objets' => array(
				'*' => array(
					'choix' => array_keys($roles_documents),
				)
			)
		)
	);

	// Rôles sur les sélections éditoriales
	$roles_selections = array(
		'alaune'  => 'integraal:role_selection_alaune',  // Contenus À la Une
		'related' => 'integraal:role_selection_related', // Contenus liés
	);
	$tables['spip_selections'] = array_merge_recursive(
		$tables['spip_selections'],
		array(
			'roles_titres' => $roles_selections,
			'roles_objets' => array(
				'*' => array(
					'choix' => array_keys($roles_selections),
				)
			),
		)
	);

	return $tables;
}
