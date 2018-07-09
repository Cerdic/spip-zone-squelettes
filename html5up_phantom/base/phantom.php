<?php
if (!defined("_ECRIRE_INC_VERSION")) return;

function html5up_phantom_declarer_champs_extras($champs = array()) {
	$champs['spip_articles']['phantom'] = array(
		'saisie' => 'fieldset',
			'options' => array(
			'nom' => _T('phantom:phantom'),
			'label' => _T('phantom:phantom_label')
		),
		'saisies' => array(
			'extras_accueil' => array(
				'saisie' => 'case',
				'options' => array(
					'nom'=>'extras_accueil',
					'sql' => "tinytext NOT NULL DEFAULT ''",
					'rechercher' => false,
					'label' => _T('phantom:extras_accueil_label'), 
					'explication' => _T('phantom:extras_accueil_explications'),
					'obligatoire' => false, // 'true', 'false' ou ''
			)),
			'extras_ordre_accueil' => array(
				'saisie' => 'input',
				'options' => array(
					'nom'=>'extras_ordre_accueil',
					'sql' => "tinytext NOT NULL DEFAULT ''",
					'rechercher' => false,
					'label' => _T('phantom:extras_ordre_accueil_label'), 
					'explication' => _T('phantom:extras_ordre_accueil_explications'),
					'obligatoire' => false, // 'true', 'false' ou ''
					'afficher_si' => '@extras_accueil@==on'
			))
		)
	);
	return $champs;
}