<?php

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

// Définition des blocs Z utilisés par le squelette
$GLOBALS['z_blocs'] = array('content', 'breadcrumb', 'nav', 'aside', 'extra', 'head', 'head_js', 'header', 'footer');

// Forcer, lors de l'affichage des thèmes par Zen-Garden, le filtrage exclusif des thèmes compatibles avec Zgala
define('_ZENGARDEN_FILTRE_THEMES', 'zgala');

define('_NOIZETIER_LISTER_PAGES_SANS_XML', false);
