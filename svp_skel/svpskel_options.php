<?php
// On force le mode d'utilisation de SVP a non runtime car on veut presenter tous les
// plugins contenus dans les depots quelque soit leur compatibilite spip
if (!defined('_SVP_MODE_RUNTIME'))
	define('_SVP_MODE_RUNTIME', false);

// Liste des pages publiques d'objet supportees par le squelette (depot, plugin).
// Permet d'afficher le bouton voir en ligne dans la page d'edition de l'objet
if (!defined('_SVP_PAGES_OBJET_PUBLIQUES'))
	define('_SVP_PAGES_OBJET_PUBLIQUES', 'depot:plugin');

// Branche SPIP stable
if (!defined('_SVPSKEL_BRANCHE_STABLE'))
	define('_SVPSKEL_BRANCHE_STABLE', '3.0');

// Forcer l'utilisation de langue du visiteur
$GLOBALS['forcer_lang'] = true;

// Définition des blocs Z utilisés par le squelette
$GLOBALS['z_blocs'] = array('content','extra1','extra2','head','head_js','header','footer');
?>
