<?php

// Sécurité
if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

// Activer HTML5 depuis le squelette
$GLOBALS['meta']['version_html_max'] = 'html5';

if (!isset($GLOBALS['z_blocs'])) {
	$GLOBALS['z_blocs'] = array(
		'content',
		'aside',
		'extra',
		'head',
		'head_js',
		'header',
		'footer',
		'breadcrumb',
	);
}

define('_ZENGARDEN_FILTRE_THEMES','integraal');
define('_ALBUMS_INSERT_HEAD_CSS',false);

// Déclaration des menus utilisés
function integraal_squelettes_menus_utiles($menus) {
	$menus['firstnav'] = 'Menu principal';
	$menus['access'] = 'Accessibilité';
	$menus['footer'] = 'Pied de page';
	
	return $menus;
}
