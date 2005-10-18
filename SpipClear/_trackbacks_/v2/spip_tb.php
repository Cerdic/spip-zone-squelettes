<?php

include("ecrire/inc_version.php3"); //peut-on vivre sans inc_version ?
include_ecrire("inc_filtres.php3"); //pour url_absolue(), texte_backend(), texte_script(), corriger_caracteres()
include_local("inc-trackback.php"); //pour generer_url_tracback()
include_ecrire("inc_texte.php3"); //pour couper()
if(@file_exists("inc-urls.php3"))
	include_local("inc-urls.php3");
else
	include_local("inc-urls-".$GLOBALS['type_urls'].".php3"); //pour generer_url_article|breve()
include_local("inc-calcul-outils.php3"); //pour calcul_introduction()
include_local("inc-public-global.php3"); //pour terminer_public_global() (stats&cron)
include_ecrire("inc_abstract_sql.php3"); //pour spip_abstract_insert()
include_local("inc-messforum.php3"); //pour prevenir_auteurs() (notification par mail)

header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="'.lire_meta('charset').'"?>'."\n";
echo '<response>'."\n";

$content = '';

if (empty($_GET['id_article']) && empty($_GET['id_breve'])) {
	$content = '<error>1</error>'."\n".
	'<message>'._T('trackbacks:noid').'</message>';
}
else {
	$type = !empty($_GET['id_breve'])?'breve':'article';
	$table = "spip_".table_objet($type);
	$col_id = id_table_objet($type);
	$id = intval($_GET[$col_id]);
	if(!($id>0)) exit;
	switch($type) {
		case 'breve':
			$query = "SELECT id_breve AS id, titre, texte, lang
			FROM $table
			WHERE statut='publie' AND date_heure<=NOW() AND id_breve=$id";
			break;
		case 'article':
		default:
			$post_dates = lire_meta("post_dates");
			$date = $post_dates=='non'?" AND date<=NOW()":"";
			$query = "SELECT id_article AS id, accepter_trackback, titre, descriptif, chapo, texte, lang
			FROM $table
			WHERE statut='publie'".$date." AND id_article=$id";
			break;
	}
	$result = spip_query($query);
	$row = spip_fetch_array($result);
	if(empty($row['id'])) {
		$content = '<error>1</error>'."\n".
		'<message>'.quote_amp(_T('trackbacks:'.$type.'_nopost')).'</message>';
	}
	elseif ($row['accepter_trackback']=="non"
		OR (lire_meta("trackbacks")=="non" AND $row['accepter_trackback']=="")) {
		$content = '<error>1</error>'."\n".
		'<message>'.quote_amp(_T('trackbacks:notrackbacks')).'</message>';
	}
	elseif (isset($_REQUEST['__info'])) {
		$content =
		'<error>0</error>'."\n".
		'<engine>SPIP</engine>'."\n".
		'<version>'.$spip_version_affichee.'</version>'."\n".
		'<encoding>'.lire_meta('charset').'</encoding>'."\n";
	}
	elseif (!empty($_REQUEST['__mode']) && $_REQUEST['__mode'] == 'rss') {
		$tb_url = quote_amp(generer_url_trackback($type, $row['id']));
		$link_url = $type=='article'?generer_url_article($row['id']):generer_url_breve($row['id']);
		$post_excerpt = calcul_introduction($type.'s', $row['texte'], $row['chapo'], $row['descriptif']);
		$post_excerpt = strlen($post_excerpt)>255 ? couper($post_excerpt, 244) : $post_excerpt;
				
		$content =
		'<error>0</error>'."\n".
		'<rss version="0.91"><channel>'."\n".
		'<title>'.lire_meta('nom_site').' - Trackback</title>'."\n".
		'<link>'.$tb_url.'</link>'."\n".
		'<description>'._T('trackbacks:info_rss').'</description>'."\n".
		'<language>'.$row['lang'].'</language>'."\n".
		'<item>'."\n".
		'<title>'.texte_backend($row['titre']).'</title>'."\n".
		'<link>'.url_absolue($link_url).'</link>'."\n".
		'<description>'.texte_backend($post_excerpt).'</description>'."\n".
		'</item>'."\n".
		'</channel>'."\n".
		'</rss>';
	}
	elseif (empty($_REQUEST['url'])) {
		$content =
		'<error>1</error>'."\n".
		'<message>'.quote_amp(_T('trackbacks:url_requise')).'</message>';
	}
	elseif (spip_fetch_array(spip_query("SELECT id_forum FROM spip_forum WHERE url_site='$url' AND trackback='oui' AND $col_id=$id"))) {//verifier si on a pas déjà reçu un TB de la même source pour le même objet
		$content =
		'<error>1</error>'."\n".
		'<message>'._T('trackbacks:deja_recu_'.$type).'</message>';
	}
	else {
		$url = stripslashes($_REQUEST['url']);
		$title = (!empty($_REQUEST['title'])) ? stripslashes($_REQUEST['title']) : $url;
		$excerpt = (!empty($_REQUEST['excerpt'])) ? stripslashes($_REQUEST['excerpt']) : '';
		$blog_name = (!empty($_REQUEST['blog_name'])) ? stripslashes($_REQUEST['blog_name']) : '';
		
		if (trim($title) == '') {
			$title = $url;
		}
		
		if (strlen($excerpt) > 255) {
			$excerpt = couper($excerpt,244);
		}
			
		# On poste de l'UTF-8 ou pas ? $_REQUEST['charset'] ?
		if (lire_meta('charset') == 'utf-8' && (empty($_REQUEST['utf8']) || $_REQUEST['utf8'] != 1)) {
			$title = utf8_encode($title);
			$excerpt = utf8_encode($excerpt);
			$blog_name = utf8_encode($blog_name);
		}//surement generalisable avec les fonctions de conversion de SPIP... TODO

		# Determination du statut
		$accepter=$row['accepter_trackback']?$row['accepter_trackback']:substr(lire_meta('trackbacks'),0,3);
		if($accepter=="pos") $statut="publie";
		if($accepter=="pri") $statut="prop";

		#insertion du trackback
		$id_message = spip_abstract_insert('spip_forum', '(date_heure, trackback)', '(NOW(), \'oui\')');
		
		$query = "UPDATE spip_forum
		SET titre='".addslashes(corriger_caracteres($title))."',
		texte='".addslashes(corriger_caracteres($excerpt))."',
		nom_site='".addslashes(corriger_caracteres($blog_name))."',
		url_site='".addslashes(corriger_caracteres($url))."',		
		statut='$statut',
		$col_id=$id,
		id_thread = $id_message,
		ip='$REMOTE_ADDR'
		WHERE id_forum=$id_message";
		$result = spip_query($query);
		if(!$result || !$id_message) {
			$content =
			'<error>1</error>'."\n".
			'<message>'._T('trackbacks:erreur_insertion').'</message>';
		}
		else {
			//Stats & Cron
			terminer_public_global();
			// Prevenir les auteurs de l'article
			if (lire_meta("prevenir_auteurs") == "oui" && $id_article)
				prevenir_auteurs($blog_name, $url, $id_message, $id_article, $excerpt, $title, $statut);
			$content =
			'<error>0</error>';
		}
	}
}

echo $content."\n";
echo '</response>';
?>
