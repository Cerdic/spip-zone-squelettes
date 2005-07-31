<?php

/***************************************************************************\
 *  SPIP, Systeme de publication pour l'internet                           *
 *                                                                         *
 *  Copyright (c) 2001-2005                                                *
 *  Arnaud Martin, Antoine Pitrou, Philippe Riviere, Emmanuel Saint-James  *
 *                                                                         *
 *  Ce programme est un logiciel libre distribue sous licence GNU/GPL.     *
 *  Pour plus de details voir le fichier COPYING.txt ou l'aide en ligne.   *
\***************************************************************************/

/***************************************************************************\
 *  Spip-Clear, Squelette Pour SPIP inspire par DotClear                   *
 *                                                                         *
 *  Copyright (c) 2005                                                     *
 *  James <klike@free.fr> & Ben. <ben.spip@gmail.com>                      *
 *                                                                         *
 *  Ce programme est aussi un logiciel libre                               *
 *  distribue sous licence GNU/GPL.                                        *
\***************************************************************************/

// executer une seule fois
if (defined("_INC_URLS2")) return;
define("_INC_URLS2", "1");

function scTrouveSecteur($id, $type) { //$type= article ou rubrique
	$query = "SELECT id_secteur FROM spip_".$type."s WHERE id_".$type."=".$id;
	$result = spip_query($query);
	if (!($row = spip_fetch_array($result))) return ""; # objet inexistant
	return $row["id_secteur"];
}

function scEstUnBlog($id_secteur) {
	return in_array($id_secteur, array_keys($GLOBALS['scEstUnBlog']))?$id_secteur:false;
}
	
function generer_url_article($id_article) {
	if($id_secteur = scEstUnBlog(scTrouveSecteur($id_article, 'article')))
		return "blog.php?id_article=$id_article";
	else
		return "article.php3?id_article=$id_article";
}

function generer_url_rubrique($id_rubrique) {
	if($id_secteur = scEstUnBlog(scTrouveSecteur($id_rubrique, 'rubrique')))
		return "blog.php?id_rubrique=$id_rubrique";
	else
		return "rubrique.php3?id_rubrique=$id_rubrique";
}

function generer_url_breve($id_breve) {
	return "breve.php3?id_breve=$id_breve";
}

function generer_url_mot($id_mot) {
	return "mot.php3?id_mot=$id_mot";
}

function generer_url_site($id_syndic) {
	return "site.php3?id_syndic=$id_syndic";
}

function generer_url_auteur($id_auteur) {
	return "auteur.php3?id_auteur=$id_auteur";
}

function generer_url_document($id_document) {
	if (intval($id_document) <= 0)
		return '';
	if ((lire_meta("creer_htaccess")) == 'oui')
		return "spip_acces_doc.php3?id_document=$id_document";
	if ($row = @spip_fetch_array(spip_query("SELECT fichier FROM spip_documents WHERE id_document = $id_document")))
		return ($row['fichier']);
	return '';
}

function recuperer_parametres_url($fond, $url) {
	global $contexte;


	/*
	 * Le bloc qui suit sert a faciliter les transitions depuis
	 * le mode 'urls-propres' vers les modes 'urls-standard' et 'url-html'
	 * Il est inutile de le recopier si vous personnalisez vos URLs
	 * et votre .htaccess
	 */
	// Si on est revenu en mode html, mais c'est une ancienne url_propre
	// on ne redirige pas, on assume le nouveau contexte (si possible)
	if ($url_propre = $GLOBALS['_SERVER']['REDIRECT_url_propre']
	OR $url_propre = $GLOBALS['HTTP_ENV_VARS']['url_propre']
	AND preg_match(',^(article|breve|rubrique|mot|auteur|site)$,', $fond)) {
		$url_propre = preg_replace('/^[_+-]{0,2}(.*?)[_+-]{0,2}(\.html)?$/',
			'$1', $url_propre);
		if ($r = spip_query("SELECT ".id_table_objet($fond)." AS id
		FROM spip_".table_objet($fond)."
		WHERE url_propre = '".addslashes($url_propre)."'")
		AND $t = spip_fetch_array($r))
			$contexte[id_table_objet($fond)] = $t['id'];
	}
	/* Fin du bloc compatibilite url-propres */

	return;
}

//
// URLs des forums
//

function generer_url_forum($id_forum, $show_thread=false) {
	list($type, $id, $id_thread) = racine_forum($id_forum);
	if ($id_thread>0 AND $show_thread)
		$id_forum = $id_thread;
	
	$ancre = "forum";
	if($type == 'article' || $type == 'rubrique') {
		if($id_secteur = scEstUnBlog(scTrouveSecteur($id, $type)))
			$ancre = "c";
	}
	
	switch($type) {
		case 'article':
			return generer_url_article($id)."#$ancre$id_forum";
			break;
		case 'breve':
			return generer_url_breve($id)."#forum$id_forum";
			break;
		case 'rubrique':
			return generer_url_rubrique($id)."#$ancre$id_forum";
			break;
		case 'site':
			return generer_url_site($id)."#forum$id_forum";
			break;
		default:
			return "forum.php3?id_forum=".$id_forum;
	}
}

?>
