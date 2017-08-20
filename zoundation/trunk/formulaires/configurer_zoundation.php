<?php

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

function formulaires_configurer_zoundation_saisies_dist() {

	$saisies = array(
		array(
			'saisie' => 'secteur',
			'options' => array(
				'nom' => 'rubrique_sommaire',
				'label' => _T('zoundation:rubrique_sommaire'),
				'explication' => _T('zoundation:explication_rubrique_sommaire'),
				'multiple' => 'oui'
			)
		),
		array(
			'saisie' => 'selecteur_rubrique',
			'options' => array(
				'nom' => 'rubrique_exclue_menu',
				'label' => _T('zoundation:rubrique_exclue_menu'),
				'explication' => _T('zoundation:explication_rubrique_exclue_menu'),
				'multiple' => 'oui'
			)
		),
		array(
			'saisie' => 'selecteur_rubrique',
			'options' => array(
				'nom' => 'rubrique_footer',
				'label' => _T('zoundation:rubrique_footer'),
				'explication' => _T('zoundation:explication_rubrique_footer')
			)
		),
	   array(
		   'saisie' => 'textarea',
		   'options' => array(
			   'nom' => 'footer_js',
			   'label' => _T('zoundation:footer_js'),
			   'explication' => _T('zoundation:explication_footer_js')
		   )
	   ),
		array(
			'saisie' => 'selecteur_squelettes',
			'options' => array(
				'nom' => 'inc-sommaire',
				'label' => _T('zoundation:inc-sommaire'),
				'explication' => _T('zoundation:explication_inc-sommaire')
			)
		),
		array(
			'saisie' => 'case',
			'options' => array(
				'nom' => 'sticky',
				'label_case' => _T('zoundation:case_sticky')
			)
		)
	);

	include_spip('inc/utils');
	if (test_plugin_actif('mailsubscribers')) {
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

function formulaires_configurer_zoundation_verifier_dist() {
	$erreurs = array();

	// Dans le cas ou inc-sommaire est vide, on s'assure de vider la méta
	// correctement
	if (empty(_request('inc-sommaire'))) {
		set_request('inc-sommaire', null);
	}

	return $erreurs;
}
