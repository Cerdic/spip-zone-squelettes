<?php

// récupération de l'url du site
// pour redéfinir la fonction inc_lien dans escal_options
// un grand merci à l'auteur : bobof

define('_SITE', $GLOBALS['meta']['adresse_site']); // récupère l'url du site déclarée dans l'espace privé > configuration > Adresse (URL) du site public
$url_el = parse_url($GLOBALS['meta']['adresse_site']);
$hote = $url_el['host'];
$hote_el  = explode('.', $hote);
$nb_el = count($hote_el);
$domaine = $hote_el[$nb_el - 2] . '.' . $hote_el[$nb_el - 1];
define('_DOMAINE_SITE', $domaine); // extrait dans l'url du site le nom du domaine pleinement qualifié sous la forme domaine.tld

 


// Suppression globale des nombres devant les titres du type :
//   1. Mon titre

	$table_des_traitements['TITRE'][]= 'supprimer_numero(typo(%s))';

// multilinguisme

$forcer_lang = true;

?>