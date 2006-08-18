<?php

	/***
	* declaration doctype et entete html, a appliquer a #CHARSET
	***/
		define("ENVOI_XML", false); //false par defaut, mettre a true (vrai) dans ecrire/mes_options.php3 si on est sur de soi

	function doctype($charset) {
		# En-tetes et prologue
		# Envoie des en-tete HTTP
		$accept_xml =
			!empty($_SERVER['HTTP_ACCEPT']) &&
			strpos($_SERVER['HTTP_ACCEPT'],'application/xhtml+xml') !== false;

		if (ENVOI_XML && $accept_xml) {
			header('Content-Type: application/xhtml+xml');
		} else {
			header('Content-Type: text/html; charset='.$charset);
		}

		if ($accept_xml) {
			echo '<?xml version="1.0" encoding="'.$charset.'"?'.'>'."\n";
		}
		return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
	}

	// Format de date des archives
	function affdate_archive($date, $type = 'mois') {
		return affdate_base($date, 'annee').'-'.affdate_base($date, 'mois').(($type == 'jour')?'-'.affdate($date, 'd'):'');
	}

	function affdate_long($date) {
		return affdate_base($date, 'nom_jour').' '.affdate_base($date, 'entier');
	}

	//
	// Definition des balises
	//
	function balise_SC_CUSTOM_TITLE($p) {
		$p->code = "lire_meta('scCustomTitle')";
		$p->interdire_scripts = false;
		return $p;
	}

?>