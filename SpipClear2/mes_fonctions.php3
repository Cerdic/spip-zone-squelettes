<?php

	$GLOBALS['dossier_squelettes'] = 'SpipClear2';

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
			echo '<?xml version="1.0" encoding="'.$charset.'"?>'."\n";
		}
		return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
	}

	// Format de date des archives
	function affdate_archive($date, $type = 'mois') {
		return affdate_base($date, 'annee').'-'.affdate_base($date, 'mois').(($type == 'jour')?'-'.sprintf("%02s",affdate_base($date, 'jour')):'');
	}

	// Gestion des parametres des urls
	function parametre_url($url, $parametre, $valeur = '__global__') {
		$link = new Link(str_replace('&amp;', '&', $url));
		if($valeur == '__global__')
			$valeur = $GLOBALS[$parametre];
		if(empty($valeur)) $link->DelVar($parametre);
		else $link->AddVar($parametre, $valeur);
		return quote_amp($link->getUrl());
	}
	
	function generer_url_rss($id, $type = 'rubrique') {
		if($type == 'article') return "rss.php?id_article=$id";
		return "rss.php?id_rubrique=$id";
	}

	function generer_url_atom($id_secteur) {
		return "atom.php?id_rubrique=$id_secteur";
	}

	//
	// Definition des balises
	//
	function balise_SC_CUSTOM_TITLE($p) {
		$p->code = "lire_meta('scCustomTitle')";
		$p->statut = 'php';
		return $p;
	}

	//
	// Themes de blog
	//
	function theme($id_secteur) {
		return $GLOBALS['scEstUnBlog'][$id_secteur];
	}

	/***
	* fonctions de generation du calendrier
	***/
	
	function scSql_Calendrier($date, $id_secteur = 0) {
		$post_dates = lire_meta("post_dates");
		$post_dates = $post_dates == 'non' ? 'AND articles.date<=NOW()':'';

		$annee = annee($date);
		$mois = mois($date);

		$query = "SELECT COUNT(*) as cnt
		FROM spip_articles AS articles 
		WHERE articles.date >='$annee-$mois-1'
		AND articles.date < DATE_ADD('$annee-$mois-1', INTERVAL 1 MONTH)
		$post_date
		AND articles.statut='publie'";
		$query .= ($id_secteur>0)?" AND id_secteur=$id_secteur":"";

		$row = spip_fetch_array(spip_query($query));
		return $row['cnt']>0?$annee.'-'.$mois:'';	
	}

	function mois_precedent($date, $id_secteur = 0, $format = 'texte') {
		$mois_precedent = date("Y-m", mktime(0, 0, 0, mois($date)-1, 1, annee($date)));
		return ($format == 'texte')?affdate_mois_annee($mois_precedent):scSql_Calendrier($mois_precedent , $id_secteur);
	}
	
	function mois_suivant($date, $id_secteur = 0, $format = 'texte') {
		$mois_suivant = date("Y-m", mktime(0, 0, 0, mois($date)+1, 1, annee($date)));
		return ($format == 'texte')?affdate_mois_annee($mois_suivant):scSql_Calendrier($mois_suivant, $id_secteur);
	}

	function http_calendrier_mini_mois($annee, $mois, $jour, $echelle, $partie_cal, $script, $ancre, $evt) {
		global $contexte_inclus;

		$annee = $contexte_inclus['annee'];
		$mois = $contexte_inclus['mois'];
		$jour = $contexte_inclus['jour'];
		
		list($sansduree, $evenements, $premier_jour, $dernier_jour) = $evt;

		if ($sansduree)
			foreach($sansduree as $d => $r) {
				$evenements[$d] = !$evenements[$d] ? $r : 
				     array_merge($evenements[$d], $r);
			     }

		if (!$premier_jour) $premier_jour = '01';
		if (!$dernier_jour) {
			$dernier_jour = 31;
			while (!(checkdate($mois,$dernier_jour,$annee))) $dernier_jour--;
		}

		// affichage du debut de semaine hors periode
		$ligne = '';
		$debut = date("w",mktime(1,1,1,$mois,$premier_jour,$annee));
		for ($i=$debut ? $debut : 7;$i>1;$i--) {
			$ligne .= "\n\t<td>&nbsp;</td>";
		}

		$total = '';
		for ($j=$premier_jour; $j<=$dernier_jour; $j++) {
			$nom = mktime(1,1,1,$mois,$j,$annee);
			$jour = date("d",$nom);
			$jour_semaine = date("w",$nom);
			$mois_en_cours = date("m",$nom);
			$annee_en_cours = date("Y",$nom);
			$amj = date("Y",$nom) . $mois_en_cours . $jour;

			if ($jour_semaine==1) { 
				$total .= "\n<tr>$ligne\n</tr>";
				$ligne = '';
			}

			//aujourd'hui
			if ($amj == date("Ymd")) {
				/*$couleur_lien = "red";
				$couleur_fond = "white";*/
			}
			$evts = $evenements[$amj];
			if ($evts) {
				$evts = "<a href=\"".$evts[0]['URL']."\">".$evts[0]['SUMMARY']."</a>";
			}
			else {
				$evts = intval($jour);
			}
			$ligne .= "\n\t<td>" . $evts . "\n\t</td>";
		}

		return $total . ($ligne ? "\n<tr>$ligne\n</tr>" : '');
	}

	include_local('inc-trackback.php');

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
		$texte = preg_replace($regexp, $replace, $texte);
		return $texte;
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
		$texte = preg_replace($regexp, $replace, $introduction);
		return $introduction;
	}

?>
