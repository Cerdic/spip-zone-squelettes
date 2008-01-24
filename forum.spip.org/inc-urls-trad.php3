<?php

include_spip('inc/vieilles_defs');

// executer une seule fois
if (defined("_INC_URLS2")) return;
define("_INC_URLS2", "1");

// attention maintenant ces fichiers sont appeles depuis l'espace prive aussi...
if (!function_exists('generer_url_article')) {
	function langue_choix ($id, $type='article') {
		switch ($type) {
			case 'article':
				$r = spip_query("SELECT lang, id_secteur
					FROM spip_articles
					WHERE id_article='$id'");
				if ($a = sql_fetch($r)) {
					if ($a['id_secteur'] == 324) # aide en ligne
						return "aide/".$a['lang'].'-aide.html';
#					if ($a['id_secteur'] == 91)  # rubrique 'fr'
#						return 'fr';
#					if ($a['lang'] <> 'fr')      # rubrique 'traducteurs'
						return ereg_replace("_.*","",$a['lang']);
#					else
#						return '';
				}
			case 'rubrique':
				$r = spip_query("SELECT lang, id_secteur
					FROM spip_rubriques
					WHERE id_rubrique='$id'");
				if ($a = sql_fetch($r)) {
					return ereg_replace("_.*","",$a['lang']);
				}
			case 'forum':
				include_spip('inc/forum');
				$racine = racine_forum($id);
				return langue_choix($racine[1], $racine[0]);
		}
	}

function generer_url_article($id_article) {
	$lang = langue_choix ($id_article);
	if (ereg('aide/', $lang))
		return $lang;
	else if ($lang)
		return $lang."_article$id_article.html";
	else
		return "article$id_article.html";
}

function generer_url_rubrique($id_rubrique) {
	$s = spip_query("SELECT id_secteur FROM spip_rubriques WHERE id_rubrique='$id_rubrique' AND id_secteur=id_rubrique");
	$t = sql_fetch($s);
#	if ($t AND $url=langue_choix ($t['id_secteur'], 'rubrique'))
#		return $url;
	if ($lang = langue_choix ($id_rubrique, 'rubrique'))
		return $lang."_rubrique$id_rubrique.html";
	return "rubrique$id_rubrique.html";
}

function generer_url_breve($id_breve) {
	return "breve$id_breve.html";
}

function generer_url_forum($id_forum) {
	$s = spip_query("SELECT id_thread, id_forum FROM spip_forum WHERE id_forum=$id_forum");
	$lang = langue_choix($id_forum, 'forum');
	if ($t=sql_fetch($s)) {
		$url = $lang."_".$t['id_thread'].'.html';
		if ($t['id_forum'] <> $t['id_thread']) $url .= '#forum'.$t['id_forum'];
	}
	return $url;
}

function generer_url_mot($id_mot) {
	include_spip('inc/charsets');
	$s = spip_query("SELECT titre FROM spip_mots WHERE id_mot=$id_mot");
	if ($q = sql_fetch($s)) {
		$url = '@'.ereg_replace('[^a-z0-9_,-]', '',
			strtolower(translitteration($q['titre'])));
		$extra = addslashes(serialize(array('url'=>$url)));
		spip_query("UPDATE spip_mots SET extra='$extra' WHERE id_mot=$id_mot");
		return $url;
	}
	return "mot$id_mot.html";
}

function generer_url_auteur($id_auteur) {
	return "auteur$id_auteur.html";
}

function generer_url_document($id_document) {
	if ($id_document > 0) {
		$query = "SELECT fichier FROM spip_documents WHERE id_document = $id_document";
		$result = spip_query($query);
		if ($row = sql_fetch($result)) {
			include_spip('inc/documents');
			$url = get_spip_doc($row['fichier']);
		}
	}
	return $url;
}

function recuperer_parametres_url($fond, $url) {
	global $contexte, $sitelang;

	// recuperer la variable passee par apache/rewriterule
	$lang=$sitelang;

	// recuperer les rubriques meres demandees par "www.spip.net/xx_"
	if (eregi("^/([a-z_]+)_$", $url, $regs) || $lang) {
		if ($regs[1]) $lang = $regs[1];
		if ($lang == 'fr')
			$contexte['id_rubrique'] = 91;	// cas particulier du francais qui a plusieurs rubriques
		else {
			$s = spip_query("SELECT id_secteur
				FROM spip_rubriques WHERE id_parent=0 AND
				lang LIKE '".addslashes($lang)."%' AND statut='publie'
				AND NOT (titre LIKE '%-aide.html%')");
			if (spip_num_rows($s) > 1)
				$s = spip_query("SELECT id_secteur
				FROM spip_rubriques WHERE id_parent=0 AND
				lang = '".addslashes($lang)."' AND statut='publie'");
			$t = sql_fetch($s);
			if ($id_secteur = $t['id_secteur'])
				$contexte['id_rubrique'] = $id_secteur;
			else {
				$sites_redirection = Array (
					'da' => 'http://listes.rezo.net/mailman/listinfo/spip-da',
				//	'de' => 'http://www.spip.de/',
				//	'eo' => 'http://listes.rezo.net/mailman/listinfo/spip-eo',
					'gl' => 'http://listes.rezo.net/mailman/listinfo/spip-gl',
					'it' => 'http://listes.rezo.net/mailman/listinfo/spip-it',
				//	'nl' => 'http://listes.rezo.net/mailman/listinfo/spip-nl',
					'pt' => 'http://listes.rezo.net/mailman/listinfo/spip-pt'
				);

				if ($url = $sites_redirection[$lang]) {
					@header("Location: $url");
					exit;
				} else {
					@header("Location: http://www.spip.net/");
					exit;
				}
			}
		}
	}

	// recuperer l'aide en ligne
	else if (eregi("^/aide/([^-]*)-aide\.html$", $url, $regs)) {
		$lang = addslashes($regs[1]);

		## redirections d'aide
		if (ereg('^oc(_.*)?$', $lang)) $lang = 'oc_lnc';
		if (ereg('^pt(_.*)?$', $lang)) $lang = 'pt';

		$s = spip_query("SELECT id_rubrique
			FROM spip_rubriques WHERE id_parent=324 AND
			lang ='$lang' AND statut='publie'
			AND (titre LIKE '%-aide.html%')");
		$t = sql_fetch($s);
		if ($id_rubrique = $t['id_rubrique'])
			$contexte['id_rubrique'] = $id_rubrique;
	}

	// recuperer l'article correspondant a "www.spip.net/xx_suivi"
	// si possible dans la langue, sinon en francais
	else if (eregi("^/([a-z_]+)_suivi$", $url, $regs)) {
		$id_original = 2275;
		$lang = $regs[1];
		$s = spip_query("SELECT * FROM spip_articles WHERE id_trad=$id_original AND statut='publie' ORDER BY lang<>'$lang',lang<>'fr'");
		if ($t = sql_fetch($s))
			$contexte['id_article'] = $t['id_article'];
	}

	// recuperer les mots-cles (balises de spip)
	else if (eregi("^/(@[a-z_0-9,-]+)$", $url, $regs)) {
		$extra = addslashes(serialize(array('url'=>$regs[1])));
		$s = spip_query("SELECT id_mot FROM spip_mots WHERE extra='$extra'");
		if ($t = sql_fetch($s))
			$contexte['id_mot'] = $t['id_mot'];
	}
}


} // function_exists

?>
