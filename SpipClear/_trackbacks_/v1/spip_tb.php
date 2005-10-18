<?php

include("ecrire/inc_version.php3");
include_ecrire("inc_filtres.php3"); //pour extra(), url_absolue(), texte_backend()
include_local("inc-trackback.php"); //pour generer_url_tracback()
include_ecrire("inc_texte.php3"); //pour couper()
if(@file_exists("inc-urls.php3"))
	include_local("inc-urls.php3");
else
	include_local("inc-urls-".$GLOBALS['type_urls'].".php3"); //pour generer_url_article()
include_local("inc-calcul-outils.php3"); //pour calcul_introduction()
include_ecrire("inc_forum.php3");

header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="'.lire_meta('charset').'"?>'."\n";
echo '<response>'."\n";

$content = '';

if (empty($_GET['id_article'])) {
	$content = '<error>1</error>'."\n".
	'<message>No ID.</message>';
}
else {
	$id = intval($_GET['id_article']); //comment fera-t-on pour les breves ?
	$query = "SELECT id_article, extra, titre, descriptif, chapo, texte, lang
	  FROM spip_articles
	  WHERE statut='publie' AND date<=NOW() AND id_article=".$id;
	$result = spip_query($query);
	$article = spip_fetch_array($result);
	if(empty($article['id_article'])) {
		$content = '<error>1</error>'."\n".
		'<message>No post for this ID.</message>';
	}
	elseif (extra($article['extra'],'accepter_trackbacks')=="non") {
		//mieux gerer la regle(peut_etre gerer ca via balise_PARAMETRES_TRACKBACK ?)
		$content = '<error>1</error>'."\n".
		'<message>Trackbacks are not allowed for this post or weblog.</message>';
	}
	elseif (isset($_REQUEST['__info'])) {
		$content =
		'<error>0</error>'."\n".
		'<engine>SPIP</engine>'."\n".
		'<version>'.$spip_version_affichee.'</version>'."\n".
		'<encoding>'.lire_meta('charset').'</encoding>'."\n";
	}
	elseif (!empty($_REQUEST['__mode']) && $_REQUEST['__mode'] == 'rss') {
		$tb_url = quote_amp(generer_url_trackback($id));
		$post_excerpt = calcul_introduction('articles', $article['texte'], $article['chapo'], $article['descriptif']);
		$post_excerpt = strlen($post_excerpt)>255 ? couper($post_excerpt).'...' : $post_excerpt;
				
		$content =
		'<error>0</error>'."\n".
		'<rss version="0.91"><channel>'."\n".
		'<title>'.lire_meta('nom_site').' - Trackback</title>'."\n".
		'<link>'.$tb_url.'</link>'."\n".
		'<description>TrackBack item for this blog</description>'."\n".
		'<language>'.$article['lang'].'</language>'."\n".
		'<item>'."\n".
		'<title>'.texte_backend($article['titre']).'</title>'."\n".
		'<link>'.url_absolue(generer_url_article($article['id_article'])).'</link>'."\n".
		'<description>'.texte_backend($post_excerpt).'</description>'."\n".
		'</item>'."\n".
		'</channel>'."\n".
		'</rss>';
	}
	elseif (empty($_REQUEST['url'])) {
		$content =
		'<error>1</error>'."\n".
		'<message>URL parameter is requiered.</message>';
	}
	else {
		$url = $_REQUEST['url'];
		$title = (!empty($_REQUEST['title'])) ? $_REQUEST['title'] : $url;
		$excerpt = (!empty($_REQUEST['excerpt'])) ? $_REQUEST['excerpt'] : '';
		$blog_name = (!empty($_REQUEST['blog_name'])) ? $_REQUEST['blog_name'] : '';
		
		if (trim($title) == '') {
			$title = $url;
		}
		
		if (strlen($excerpt) > 255) {
			$excerpt = couper($excerpt,252).'...';
		}
			
		# On poste de l'UTF-8 ou pas ?
		if (lire_meta('charset') == 'utf-8' && (empty($_REQUEST['utf8']) || $_REQUEST['utf8'] != 1)) {
			$title = utf8_encode($title);
			$excerpt = utf8_encode($excerpt);
			$blog_name = utf8_encode($blog_name);
		}//surement generalisable avec les fonctions de conversion de SPIP

		#determination du statut (peut_etre gerer ca via balise_PARAMETRES_TRACKBACK ?)
		$extra_article=extra($article['extra'],'accepter_trackbacks');
		if($extra_article=="oui") $statut="tbpublie";
		if($extra_article=="posteriori") $statut="tbprop";

		#insertion du trackback
		$query = "INSERT INTO spip_forum
        		(titre, texte, date_heure, nom_site, url_site, statut,
		        id_article)
		        VALUES ('".texte_script($title)."',
		        '".texte_script($excerpt)."', NOW(),
		        '".texte_script($blog_name)."',
		        '".texte_script($url)."',
		        '".texte_script($statut)."',
		        '$id_article')";
		$result = spip_query($query);
		if(!$result) {
			$content =
			'<error>1</error>'."\n".
			'<message>An error occured while inserting the trackback.</message>';
		}
		else {
			calculer_threads();
			$content =
			'<error>0</error>';
			//on ne notifie pas ici mais via un systeme plus large... TODO
		}
	}
}

echo $content."\n";
echo '</response>';
?>
