<?php

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

function formulaires_configurer_zoundation_saisies_dist() {

	$saisies = array(
		array(
			'saisie' => 'selecteur_rubrique',
			'options' => array(
				'nom' => 'rubrique_sommaire',
				'label' => _T('zoundation:rubrique_sommaire'),
				'explication' => _T('zoundation:explication_rubrique_sommaire'),
				'multiple' => 'oui'
			)
		)
	);


	$plugin = charger_filtre('info_plugin');

	if ($plugin('mailsubscribers', 'est_actif')) {
		include_spip('inc/mailsubscribers');

		// Récupérer les listes de newsletter et créer une data compatible
		$listes = mailsubscribers_listes();
		$listes = array_column($listes, 'titre', 'id');

		$saisies[] = array(
			'saisie' => 'selection',
			'options' => array(
				'nom' => 'mailsubscribers_liste',
				'label' => _T('zoundation:mailsubscribers_liste'),
				'datas' => $listes
			)
		);
	}

	return $saisies;
}

function formulaires_configurer_zoundation_charger_dist() {
	include_spip('inc/config');
	$config = lire_config('zoundation');
	return (empty($config)) ? array() : lire_config('zoundation');
}
