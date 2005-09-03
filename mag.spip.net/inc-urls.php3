<?php

// executer une seule fois
if (defined("_INC_URLS2")) return;
define("_INC_URLS2", "1");

# On charge les fonctions de connection au cas où le fichier est appelé hors contexte spip
require("ecrire/inc_version.php3");
require("ecrire/inc_connect.php3");
include_ecrire("inc_db_mysql.php3");
include_ecrire("inc_filtres.php3");

function generer_url_article($id_article) {
$r = spip_fetch_array(spip_query("SELECT chapo FROM spip_articles WHERE id_article='$id_article' LIMIT 1"));
if(substr($r['chapo'], 0, 1) == '=') {
if(ereg('^(art(icle)?|rub(rique)?|br(.ve)?|aut(eur)?|mot|site|doc(ument)?|im(age|g))? *([[:digit:]]+)$', substr($r['chapo'], 1),$match)) {
switch (substr($match[1], 0, 2)) {
case 'ru': return generer_url_rubrique($match[8]); break;
case 'br': return generer_url_breve($match[8]); break;
case 'au': return generer_url_auteur($match[8]); break;
case 'mo': return generer_url_mot($match[8]); break;
case 'im':
case 'do': return generer_url_document($match[8]); break;
case 'si':
$row = @spip_fetch_array(@spip_query("SELECT nom_site,url_site FROM spip_syndic WHERE id_syndic='$id_lien' LIMIT 1"));
if ($row) return $row['url_site']; break;
default: return generer_url_article($match[8]); break;
}
}
else
return substr($r['chapo'], 1);
}
else
# return "article".$id_article.".html"; // Version html
return "article".$id_article.".html"; // Version standard
}

function generer_url_rubrique($id_rubrique) {
	return "rubrique$id_rubrique.html";
}

function generer_url_breve($id_breve) {
	return "breve$id_breve.html";
}

function generer_url_mot($id_mot) {
	return "mot$id_mot.html";
}

function generer_url_auteur($id_auteur) {
	return "auteur$id_auteur.html";
}

function generer_url_document($id_document) {
	if ($id_document > 0) {
		$query = "SELECT fichier FROM spip_documents WHERE id_document = $id_document";
		$result = spip_query($query);
		if ($row = spip_fetch_array($result)) {
			$url = $row['fichier'];
		}
	}
	return $url;
}

function recuperer_parametres_url($fond, $url) {
	global $contexte;
	return;
}


//
// URLs des forums
//

function generer_url_forum($id_forum, $show_thread=false) {
	list($type, $id, $id_thread) = racine_forum($id_forum);
	if ($id_thread>0 AND $show_thread)
		$id_forum = $id_thread;
	switch($type) {
		case 'article':
			return generer_url_article($id)."#forum$id_forum";
			break;
		case 'breve':
			return generer_url_breve($id)."#forum$id_forum";
			break;
		case 'rubrique':
			return generer_url_rubrique($id)."#forum$id_forum";
			break;
		default:
			return "forum$id_forum.html";
	}
}

?>
