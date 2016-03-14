<?php

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

function formulaires_configurer_zoundation_saisies_dist() {
	$saisies = array(
		array(
			'saisie' => 'input',
			'options' => array(
				'nom' => 'rubrique_sommaire',
				'label' => _T('zoundation:rubrique_sommaire'),
				'explication' => _T('zoundation:explication_rubrique_sommaire')
			)
		)
	);

	return $saisies;
}

function formulaires_configurer_zoundation_charger_dist() {
	include_spip('inc/config');
	$config = lire_config('zoundation');
	return (empty($config)) ? array() : lire_config('zoundation');
}
