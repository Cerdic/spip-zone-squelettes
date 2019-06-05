<?php

// Sécurité
if (!defined('_ECRIRE_INC_VERSION')) {return;}

// Activer HTML5 depuis le squelette
$GLOBALS['meta']['version_html_max'] = 'html5';
// Intertitres commençant par h2 + surcharge de la config de Enluminures typo
$GLOBALS['debut_intertitre'] = '<h4 class="spip">';
$GLOBALS['fin_intertitre'] = '</h4>';
$GLOBALS['debut_intertitre_2'] = '<h5 class="spip">';
$GLOBALS['fin_intertitre_2'] = '</h5>';
$GLOBALS['debut_intertitre_3'] = '<h6 class="spip">';
$GLOBALS['fin_intertitre_3'] = '</h6>';
$GLOBALS['debut_intertitre_4'] = '<h7 class="spip">';
$GLOBALS['fin_intertitre_4'] = '</h7>';
$GLOBALS['debut_intertitre_5'] = '<h8 class="spip">';
$GLOBALS['fin_intertitre_5'] = '</h8>';
