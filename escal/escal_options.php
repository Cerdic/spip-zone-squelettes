<?php

// definitions pour le traitement des liens dans mes_options
// un grand merci à l'auteur : bobof

define('_SITE', $GLOBALS['meta']['adresse_site']);
	$url_el = parse_url('_SITE');
	$hote = $url_el['host']; 
	$nb_el = count($hote_el);
	$domaine = $hote_el[$nb_el - 2] . '.' . $hote_el[$nb_el - 1];


// Suppression globale des nombres devant les titres du type :
//   1. Mon titre

	$table_des_traitements['TITRE'][]= 'supprimer_numero(typo(%s))';


?>