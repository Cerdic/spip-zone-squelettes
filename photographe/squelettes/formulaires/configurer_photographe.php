<?php
if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

function formulaires_configurer_photographe_saisies_dist() {
	$saisies = array(
		array(
			'saisie' => 'radio',
			'options' => array(
				'nom' => 'accueil_quoi',
				'label' => _T('photographe:configurer_accueil_quoi_label'),
				'data' => array(
					'recentes' => _T('photographe:configurer_accueil_quoi_recentes'),
					'albums' => _T('photographe:configurer_accueil_quoi_albums'),
				),
				'defaut' => 'recentes',
			),
		),
		array(
			'saisie' => 'input',
			'options' => array(
				'nom' => 'pagination_accueil',
				'label' => _T('photographe:configurer_pagination_accueil_label'),
				'defaut' => 50,
				'afficher_si' => '@accueil_quoi@ == "recentes"'
			),
		),
		array(
			'saisie' => 'input',
			'options' => array(
				'nom' => 'pagination_album',
				'label' => _T('photographe:configurer_pagination_album_label'),
				'defaut' => 50,
			),
		),
	);
	
	return $saisies;
}

