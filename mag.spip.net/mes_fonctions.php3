<?php

//
// Definition des variables globales de personnalisation
//
$GLOBALS['dossier_squelettes'] = 'layout';
$GLOBALS['ouvre_ref'] = '&nbsp;|';
$GLOBALS['ferme_ref'] = '|';
$GLOBALS['ouvre_note'] = '|';
$GLOBALS['ferme_note'] = '| ';

//
// Fonctions de gestion de l'affichage des noms des auteurs sur le site public
//
require("inc-auteurs.php3");

//
// Declaration doctype et entete html, a appliquer a #CHARSET
//              (fonction pompee sur spip.clear)
//
function doctype($charset) {
	global $envoi_xml;
	//false par defaut, mettre a true dans ecrire/mes_options.php3 si on est sur de soi
	tester_variable("envoi_xml", false);
	# En-têtes et prologue
	# Envoie des en-tête HTTP
	$accept_xml =
		!empty($_SERVER['HTTP_ACCEPT']) &&
		strpos($_SERVER['HTTP_ACCEPT'],'application/xhtml+xml') !== false;
	if ($envoi_xml && $accept_xml) {
		header('Content-Type: application/xhtml+xml');
	} else {
		header('Content-Type: text/html; charset='.$charset);
	}
	if ($accept_xml) {
		echo '<?xml version="1.0" encoding="'.$charset.'"?>'."\n";
	}
	return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
}

//
// Affiche des jolies zetoiles dans le moteur de recherche
//
function etoiles($points) {
	$retour = '5';
	if ($points < 26) $retour = '4';
	if ($points < 16) $retour = '3';
	if ($points < 08) $retour = '2';
	if ($points < 05) $retour = '1';
	if ($points < 02) $retour = '0';
	return '<div class="etoiles-'.$retour.'">&nbsp;</div>';
}


?>
