<?php

// r�cup�ration de l'url du site
// pour red�finir la fonction inc_lien dans escal_options
// un grand merci � l'auteur : bobof

define('_SITE', $GLOBALS['meta']['adresse_site']); // r�cup�re l'url du site d�clar�e dans l'espace priv� > configuration > Adresse (URL) du site public
$url_el = parse_url($GLOBALS['meta']['adresse_site']);
$hote = $url_el['host'];
$hote_el  = explode('.', $hote);
$nb_el = count($hote_el);
$domaine = $hote_el[$nb_el - 2] . '.' . $hote_el[$nb_el - 1];
define('_DOMAINE_SITE', $domaine); // extrait dans l'url du site le nom du domaine pleinement qualifi� sous la forme domaine.tld

 


// Suppression globale des nombres devant les titres du type :
//   1. Mon titre

	$table_des_traitements['TITRE'][]= 'supprimer_numero(typo(%s))';


?>