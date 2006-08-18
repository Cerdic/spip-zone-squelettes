<?php

	/***
	* declaration doctype et entete html, a appliquer a #CHARSET
	***/

	function doctype($charset) {
		global $envoi_xml;
		tester_variable("envoi_xml", false); //false par défaut, mettre à true (vrai) dans ecrire/mes_options.php3 si on est sûr de soi
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
			echo '<?xml version="1.0" encoding="'.$charset.'"?'.'>'."\n";
		}
		return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
	}

	// Format de date des archives
	function affdate_archive($date, $type = 'mois') {
		return affdate_base($date, 'annee').'-'.affdate_base($date, 'mois').(($type == 'jour')?'-'.affdate($date, 'd'):'');
	}

	// Gestion des parametres des urls
	/*function parametre_url($url, $parametre, $valeur = '__global__') {
		$link = new Link(str_replace('&amp;', '&', $url));
		if($valeur == '__global__')
			$valeur = $GLOBALS[$parametre];
		if(empty($valeur)) $link->DelVar($parametre);
		else $link->AddVar($parametre, $valeur);
		return quote_amp($link->getUrl());
	}*/

	function generer_url_base($fond, $delais = 0) {
		$url = "page.php3";
		$url = parametre_url($url, 'fond', $fond);
		$url = parametre_url($url, 'delais', $delais);
		//if ($fond == 'rss' || $fond == 'atom') $url = parametre_url($url, 'flag_preserver', 1);
		return $url;
	}
	
	function generer_url_rss($id, $type = 'rubrique') {
		return parametre_url(generer_url_base('rss'), "id_".$type, $id);
	}

	function generer_url_atom($id_secteur) {
		return parametre_url(generer_url_base('atom'), 'id_rubrique', $id_secteur);
	}

	//
	// Definition des balises
	//
	function balise_SC_CUSTOM_TITLE($p) {
		$p->code = "lire_meta('scCustomTitle')";
		$p->interdire_scripts = false;
		return $p;
	}

	//
	// Themes de blog
	//
	function theme($id_secteur) {
		return $GLOBALS['scEstUnBlog'][$id_secteur];
	}

	function affdate_long($date) {
		return affdate_base($date, 'nom_jour').' '.affdate_base($date, 'entier');
	}


?>