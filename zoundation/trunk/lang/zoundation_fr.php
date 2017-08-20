<?php

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

$GLOBALS[$GLOBALS['idx_lang']] = array(

	'zoundation_titre' => 'Zoundation',
	'titre_page_configurer_zoundation' => 'Configuration du squelette Zoundation',
	'configurer_squelette' => 'Configurer le squelette',
	'rubrique_sommaire' => 'Rubriques du sommaire',
	'explication_rubrique_sommaire' => "Limite l'affichage des articles sur la page d'accueil à une ou plusieurs rubriques <br />Si aucune rubrique n'est choisie, l'ensemble des rubriques sera utilisé.",
	'dernier_album' => 'Dernier album',
	'vous_etes_ici' => 'Vous êtes ici',
	'vous_etes_page' => 'Vous êtes à la page',
	'mailsubscribers_liste' => 'Liste de newsletter',
	'rubrique_exclue_menu' => 'Exclure ces rubriques du menu',
	'explication_rubrique_exclue_menu' => 'Les rubriques sélectionnées seront exclue des menu du site',
	'rubrique_footer' => 'Rubrique du footer',
	'explication_rubrique_footer' => 'Choisissez la rubrique qui constituera le footer. Les articles de cette rubrique seront automatiquement transformé en menu.',
	'inscription' => 'Inscription',

	'footer_js' => 'Insertion dans le footer',
	'explication_footer_js' => "Cette configuration permet d'insérer de manière arbitraire des éléménts juste
avant la balise fermante du body.",
	'mes_adresses' => 'Mes adresses',
	'inc-sommaire' => 'Squelette du sommaire',
	'explication_inc-sommaire' => 'Séléctionnez le squelette qui sera utilisé pour le sommaire du site. Vous pouvez créer vos propres squelettes en les placant dans un dossier <strong>inclure/</strong> avec pour nom <strong>inc-sommaire-*.html</strong>.',
	'case_sticky' => 'Activer la navigation "<a href="http://foundation.zurb.com/sites/docs/sticky.html#sticky-navigation">sticky</a>" des menus par défaut.'
);
