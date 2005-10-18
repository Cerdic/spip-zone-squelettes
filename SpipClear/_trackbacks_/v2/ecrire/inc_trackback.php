<?php

//
// Ce fichier ne sera execute qu'une fois
if (defined("_ECRIRE_INC_TRACKBACK")) return;
define("_ECRIRE_INC_TRACKBACK", "1");

include_ecrire("inc_sites.php3"); //pour recuperer_page() et init_http()
include_ecrire("inc_abstract_sql.php3"); //pour spip_abstract_fetsel()
include_local('../inc-calcul-outils.php3'); //pour caclul_introduction()

function prepare_trackback($type, $id_objet) {
	$table = "spip_".table_objet($type);
	$col_id = id_table_objet($type);

	$select = array('titre', 'texte');
	$from = array($table);
	$where = array("statut='publie'", "$col_id=$id_objet");
	switch($type) {
		case 'article':
			$select = array_merge($select, array('chapo', 'ps', 'descriptif', 'url_site'));
			$post_dates = lire_meta("post_dates");
			if($post_dates=='non') $where = array_merge($where, array('date<=NOW()'));
			$url = generer_url_article($id_objet);
			break;
		case 'breve':
			$select = array_merge($select, array('lien_url'));
			$where = array_merge($where, array('date_heure<=NOW()'));
			$url = generer_url_breve($id_objet);
			break;
		default:
			return false;
	}

	$donnees = spip_abstract_fetsel($select, $from, $where);
	if(empty($donnees)) return false;
	else {
		switch($type) {
			case 'article':
				$texte = $donnees['descriptif'] . 
					$donnees['chapo'] .
					$donnees['texte'] .
					$donnees['ps'] .
					"[->".$donnees['url_site']."]";
				break;
			case 'breve':
				$texte = $donnees['texte']."[->".$donnees['lien_url']."]";
				$donnees['chapo'] = '';
				$donnees['descriptif'] = '';
				break;
			default:
				break;
		}
		$liens = recuperer_liens_externes($texte);
		$liste_urls = array();
		foreach($liens as $link) {
			if(($ping = auto_decouverte_trackback($link)) !== false)
				$liste_urls[] = $ping;
		}
		$excerpt = calcul_introduction($type.'s', $donnees['texte'], $donnees['chapo'], $donnees['descriptif']);
		return array(
			'url' => url_absolue($url),
			'title' => $donnees['titre'],
			'blog_name' => lire_meta('nom_site'),
			'excerpt' => $excerpt,
			'charset' => lire_meta('charset'),
			'utf8' => lire_meta('charset') == 'utf-8' ? 1 : 0,
			'liste_urls' => $liste_urls
		);
	}
}

//faire un tableau de tous les liens externes d'un texte
function recuperer_liens_externes($text) {
	$linkArray = array();
	//d'abord les raccourcis typo de spip (cf. traiter_raccourcis)
	if (preg_match_all("|\[([^][]*)->(>?)([^]]*)\]|ms", $text, $array, PREG_SET_ORDER)) {
		for ($i = 0; $i<count($array); $i++) {
			if (preg_match('/^http:\/\/(.+)/ms', $array[$i][3], $matches)) {
				$linkArray[] = $matches[1];
			}
		}
	}
	unset($array);
	//ensuite les liens classiques (import DC)
	# Attributs href des liens
	if (preg_match_all('/<a ([^>]+)>/ms', $text, $array, PREG_SET_ORDER)) {
		for ($i = 0; $i<count($array); $i++) {
			if (preg_match('/href="http:\/\/([^"]+)"/ms', $array[$i][1], $matches)) {
				$linkArray[] = $matches[1];
			}
		}
	}
	unset($array);
	# Attributs cite sur blockquote et q
	if (preg_match_all('/<(blockquote|q) ([^>]+)>/ms', $text, $array, PREG_SET_ORDER)) {
		for ($i = 0; $i<count($array); $i++) {
			if (preg_match('/cite="http:\/\/([^"]+)"/ms', $array[$i][2], $matches)) {
				$linkArray[] = $matches[1];
			}
		}
	}
	return $linkArray;
}

//decouvrir les entete de definitions de trackback des pages distantes
function auto_decouverte_trackback($link) {
	$pageContents = recuperer_page('http://'.$link);
	//trouve dans DotClear (RDF)
	preg_match_all('/(<rdf:RDF.*?<\/rdf:RDF>)/sm', $pageContents, $rdf_all, PREG_SET_ORDER);
	
	for ($i=0; $i<count($rdf_all); $i++) {
		if (preg_match('|dc:identifier="http://'.preg_quote($link).'"|ms',$rdf_all[$i][1])) {
			//trouver l'attribut trackback:ping dans le tag rdf:Description
			if(preg_match('/<rdf:Description([^>]*)\/>/ms', $rdf_all[$i][1], $rdf_descr)) {
				if(preg_match('/trackback:ping[[:space:]]*=[[:space:]]*"(http:\/\/([^"]+))"/ms',
					$rdf_descr[1], $tb_ping_url)) {
					return $tb_ping_url[1];
				}
			}
		}
	}

	//trouve dans WordPress (le premier rel="trackback" de la page)
	if(preg_match('/<a href="([^"]+)" rel="trackback">[^<]+<\/a>/ms', $pageContents, $tb_ping_url))
		return $tb_ping_url[1];

	return false;
}

function auto_decouverte_pingback($link) {
	$pageContents = recuperer_page('http://'.$link, true, true);
	//Header HTTP method
	if(preg_match('/^X-Pingback: (.+)$/m', $pageContents, $tb_ping_url))
		return $tb_ping_url[1];
	//Link HTML/XHTML method
	if(preg_match('/<link rel="pingback" href="([^"]+)" ?\/?>/ms', $pageContents, $tb_ping_url))
		return $tb_ping_url[1];
	return false;
}

function envoi_trackback($ping, $datas) {
	//TODO:detection du charset distant et conversion si necessaire
	$pageContents = recuperer_page($ping, true, true, 1048576, $datas);
	
	$pattern = '|<response>.*<error>(.*)</error>(.*)'.
			'(<message>(.*)</message>(.*))?'.
			'</response>|msU';
	
	if (!preg_match($pattern,$pageContents,$matches))
	{
		return array(false, _L('Source is not a ping URL'));
	}

	# On continue, le match est OK
	$ping_error = $matches[1];
	$ping_msg = (!empty($matches[4])) ? $matches[4] : '';
	
	if ($ping_error != '0') {
		return array(false, _L('Trackback error').' : '.$ping_msg);
	} else {
		# Oui ! Le trackback est passé ! champagne :))
		# On va faire la notification
		//$this->postPingNotify($post_id,$url); TODO historiser les ping réussi (et les echecs?)
		return array(true, "Ok");
	}

}

?>
