<?php
global $repertoire_squelettes_alternatifs;
global $styleListeSwitcher;

// Repertoire contenant les repertoires squelettes a tester
$repertoire_squelettes_alternatifs ='plugins/jaycee/themes';

// Style css associe a la liste deroulante
$styleListeSwitcher="";

// Liste des squelettes definie dans mes_options avec
// define('SWITCHER_SQUELETTES','jcef2006:jcef2007');

// Booleen pour determiner qui a le droit de jouer ; par defaut, les admins.
if (!defined('SWITCHER_AFFICHER')) // true ou false
  define('SWITCHER_AFFICHER',
    true //$GLOBALS['auteur_session']['statut'] == '0minirezo'
  );

?>
