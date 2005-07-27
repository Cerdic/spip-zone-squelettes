<?php

include_local("inc-trackback.php");
	
/***
* dates spip.clear
***/
function annee_mois($date) {
	return annee($date)."-".mois($date);
}
function nom_jour_jour_nom_mois_annee($date) {
	return nom_jour($date)." ".affdate($date);
}

/***
* filtre à appliquer à #TOTAL_BOUCLE
* TODO: externaliser les mots feminins
***/
function pluriel($nombre, $singulier, $pluriel = '', $module = '') {
  $mots_feminins = array("rubrique", "breve", "categorie", "archive", "langue");
  if(!$module) $module = "local/public/spip";
  global $pluriel_renvoie_zero;
  tester_variable("pluriel_renvoie_zero", true);
  if($pluriel_renvoie_zero AND $nombre == 0) {
    $feminin = in_array($singulier, $mots_feminins)?"e":"";
    return _T($module.":aucun".$feminin."_".$singulier);
  }
  if($nombre == 0) return '';
  if(!$pluriel) $pluriel = $singulier."s";
  $code = $nombre>1?$pluriel:$singulier;
  return $nombre." "._T($module.":".$code);
}

/***
* exploitation calendrier de la partie privée sur le site public
***/

function spipclear_calendrier($date) {
  include_local('inc-calendrier.php'); //copie et adaptation ecrire/inc_calendrier.php
  $v = explode(date('d-m-Y'),'-');
  if(strlen($date)>10) $v = array(jour($date), mois($date), annee($date));
  return http_calendrier_billet(mois($date), annee($date), $v[0], $v[1], $v[2], false, 'blog.php?', '');
}

/***
* url de blog
***/

function generer_url_blog($id, $type) {
	/* calculer le type d'url à fabriquer */
	/* standard, html, perso */
	global $type_urls;
	//dans le pire des cas...
	if(!$type_urls) $type_urls = "standard";
	$f = "generer_url_blog_".$type_urls;
	return $f($id, $type);
}

function generer_url_blog_standard($id, $type) {
	//recuperer id_blog (secteur du site correspondant au blog)
	global $id_blog;
	$link = new Link("blog.php?id_blog=$id_blog");
	$ancre = "";
	if(!($type=='id_rubrique' && $id==$id_blog)) {
	  //cas des commentaires
	  if($type=='id_forum') {
	    //recuperer l'article
	    include_local("inc-urls-standard.php3");
            list($_type, $id_article, $id_thread) = racine_forum($id);
	    $link->addVar('id_article', $id_article);
	    $ancre = "c".$id;
	  }
	  else {
	    $link->addVar($type, $id);
	  }
	}
	return str_replace("&", "&amp;", $link->getUrl($ancre));
}

function generer_url_blog_html($id, $type) {
	/* sur la base d'un .htaccess proche de la distrib */
	$url = '';
	switch($type) {
		case 'id_rubrique':
			$url = 'blogs';
			break;
		case 'id_article':
		case 'id_forum': /**/
			$url = 'blog';
			break;
		case 'id_auteur':
			$url = 'blogger';
			break;
		case 'archives':
			return "blog.php?archives=".$id;
			break;
		case 'lang':
			return "blog.php?lang=".$id;
			break;
		default:
			break;
	}
	return $url.$id.".html";
}

function generer_url_blog_propres($id, $type) {
	/* rewrite rules s'approchant des urls propres */
	return "";
}

function generer_url_blog_spipclear($id, $type) {
	/* rewrite rules s'approchant des urls dotclear */
	return "";
}

function balise_URL_SPIPCLEAR($p) {
  $_type = $p->type_requete;
  if($_type == "rubriques")
    $id = "id_rubrique";
  elseif($_type == "articles")
    $id = "id_article";
  elseif($_type == "auteurs")
    $id = "id_auteur";
  elseif($_type == "forums")
    $id = "id_forum";
  $p->code = "generer_url_blog(" .
    champ_sql($id,$p) .
    ",'" . $id .
    "')";

  if ($p->boucles[$p->nom_boucle ? $p->nom_boucle : $p->id_boucle]->hash)
    $p->code = "url_var_recherche(" . $p->code . ")";

  $p->statut = 'html';
  return $p;
}

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

/***
* appliquer hreflang sur un lien
* remplace <a href="bla">truc|lang</a> par <a href="bla" hreflang="lang">truc</a>
* permet la notation spip [truc|lang->bla] pour les liens dans le #TEXTE
* à appliquer à un #TEXTE
* TODO: ne pas gérer les liens compris entre code ou cadre, ne pas afficher |lang dans l'introduction et les infobulles de notes
***/

function appliquer_hreflang($texte) {
  $regexp = "|<a([^>]+)>([^<]+)(\|([a-z]+))+</a>|i";
  $replace = "<a\\1 hreflang=\"\\4\">\\2</a>";
  $texte = preg_replace($regexp, $replace, $texte);
  return $texte;
}

/***
* rss 2 et atom 3
***/

function pasdecrochet($texte) {
  // replaces ">" if first character by "*"
	$first = substr($texte,0,1);
	if (ord($first)==ord('>')) {
  	$texte = substr($texte,1);
	}
	return $texte;
}

/* cette fonction est bugguee, ne prend pas en compte la timezone */
/*
function w3cdate($texte) {
	// sets date (from #DATE) to W3C format
	$texte = substr($texte,0,10)."T".substr($texte,11,8)."Z";
	return $texte;
}
*/

function tagdate($texte) {
	// sets date (from #DATE) to W3C URI tag format
	$texte = substr($texte,0,10);
	return $texte;
}	

function supprimehttp($texte) {
	// removes "http://" from URL to build Atom tag
	$texte = substr($texte,7);
	return $texte;
}

?>
