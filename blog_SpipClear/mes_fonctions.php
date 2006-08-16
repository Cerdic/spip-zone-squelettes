<?php

	/***
	* declaration doctype et entete html, à appliquer à #CHARSET
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

	/***
	* appliquer hreflang sur un lien
	* cf. : http://www.la-grange.net/w3c/html4.01/struct/links.html#h-12.1.5
	*     & http://www.la-grange.net/w3c/html4.01/struct/links.html#adef-hreflang
	* prérequis: extention pcre
	* remplace <a href="bla">truc|code-de-langue</a> par <a href="bla" hreflang="code-de-langue">truc</a>
	* permet la notation spip [truc|code-de-langue->bla] pour les liens dans le #TEXTE
	* à appliquer à un #TEXTE => [(#TEXTE|appliquer_hreflang)]
	***/

	function appliquer_hreflang($texte) {
		$regexp = "|<a([^>]+)>([^<]+)(\|(([a-z]+)(-([a-z]+))?))+</a>|i";
		$replace = "<a\\1 hreflang=\"\\4\">\\2</a>";
		return preg_replace($regexp, $replace, $texte);
	}

	/* exemple de definition css (dotclear V1.2):
	a[hreflang]:after {
		content: "\0000a0(" attr(hreflang) ")";
		color : #666;
		background : transparent;
	} */

	/* autre exemple (pompage.net)
	a[hreflang|="en"]:after {
		content: "\0000a0"url(/pompage_v3/linken.gif);
	}

	a[hreflang] {
		content: normal !important; #  Hack pour Opera, qui ne comprend pas la règle précédente
	} */

	/***
	* retirer hreflang sur un lien tronqué dans une INTRODUCTION
	* remplace truc|code-langue par truc
	* à appliquer à un #INTRODUCTION => [(#INTRODUCTION|retirer_hreflang)]
	***/

	function retirer_hreflang($introduction) {
		$regexp = "|\|(([a-z]+)(-([a-z]+))?)|i";
		$replace = "";
		return preg_replace($regexp, $replace, $introduction);
	}

?>