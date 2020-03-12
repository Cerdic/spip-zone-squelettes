<?php

// Sécurité
if (!defined('_ECRIRE_INC_VERSION')) {return;}

// Activer HTML5 depuis le squelette
$GLOBALS['meta']['version_html_max'] = 'html5';
// Intertitres commençant par h2
$GLOBALS['debut_intertitre'] = "\n<h2 class=\"spip\">\n";
$GLOBALS['fin_intertitre'] = "</h2>\n";