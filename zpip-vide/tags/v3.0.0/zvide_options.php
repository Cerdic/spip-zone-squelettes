<?php

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

// Définition des blocs Z utilisés par le squelette
$GLOBALS['z_blocs'] = array('content', 'breadcrumb', 'nav', 'head', 'head_js', 'header', 'footer');

// Noizetier : ne lister que les pages qui ont un xml/yaml
define('_NOIZETIER_LISTER_PAGES_SANS_XML', false);