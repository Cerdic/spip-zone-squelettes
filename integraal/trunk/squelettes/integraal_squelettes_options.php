<?php

// Sécurité
if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

// Activer HTML5 depuis le squelette
$GLOBALS['meta']['version_html_max'] = 'html5';

// Déclaration des blocs pour Z (plugin z-core)
if (!isset($GLOBALS['z_blocs'])) {
	$GLOBALS['z_blocs'] = array(
		'main',
		'aside',
		'extra',
		'head',
		'head_js',
		'header',
		'footer',
		'breadcrumb',
	);
}

// N'afficher que le thème du projet dans le sélecteur de thèmes (plugin Zen-garden)
define('_ZENGARDEN_FILTRE_THEMES', 'integraal');

// Ne pas insérer les CSS des albums sur les pages publiques (plugin albums)
define('_ALBUMS_INSERT_HEAD_CSS',false);
