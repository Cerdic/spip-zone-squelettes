<?php
if (!defined("_ECRIRE_INC_VERSION")) return;

function soyezcreateurs_declarer_champs_extras($champs = array()) {

	// Table : spip_articles
	if (!is_array($champs['spip_articles'])) {
		$champs['spip_articles'] = array();
	}

	$champs['spip_articles']['formatquoi2neuf'] = array(
			'saisie' => 'selection',
			'options' => array(
				'nom' => 'formatquoi2neuf',
				'label' => 'Largeur tuiles accueil',
				'explication' => 'Largeur d\'affichage des images de la zone ALaUne/Agenda/Quoi de neuf du mode Cognac',
				'datas' => array(
					0 => 'Automatique en fonction des proportions de l\'image (défaut)',
					1 => '1 colonne',
					2 => '2 colonnes',
					3 => '3 colonnes',
				),
				'defaut' => '0',
				'cacher_option_intro' => 'on',
				'sql' => 'text DEFAULT \'\' NOT NULL',
				'rechercher_ponderation' => '2',
				'versionner' => 'on',
			),
			'verifier' => array(
			),
		);

	return $champs;
}