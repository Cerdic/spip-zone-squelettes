<?php

//
// Ce fichier ne sera execute qu'une fois
if (defined("_ECRIRE_INC_TRACKBACK")) return;
define("_ECRIRE_INC_TRACKBACK", "1");

include("inc_sites.php3"); //pour recuperer_page() et init_http()
/*if(@file_exists("../inc-urls.php3")) //Comment être clean la-dessus ? '../' c'est moche
	include("../inc-urls.php3");
else
	include("../inc-urls-".$GLOBALS['type_urls'].".php3"); //pour generer_url_article()*/
include("../inc-calcul-outils.php3"); //pour calcul_introduction()

//faire un tableau de tous les liens externes d'un texte
function recuperer_liens_a_pinguer($text) {
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
function auto_decouverte_trackback_rdf($link) {
	$pageContents = recuperer_page('http://'.$link);
	preg_match_all('/(<rdf:RDF.*?<\/rdf:RDF>)/sm', $pageContents, $rdf_all, PREG_SET_ORDER);
	
	for ($i=0; $i<count($rdf_all); $i++)
	{
		if (preg_match('|dc:identifier="http://'.preg_quote($link).'"|ms',$rdf_all[$i][1]))
		{
			//trouver l'attribut trackback:ping dans le tag rdf:Description
			if(preg_match('/<rdf:Description([^>]*)\/>/ms', $rdf_all[$i][1], $rdf_descr)) {
				if(preg_match('/trackback:ping[[:space:]]*=[[:space:]]*"(http:\/\/([^"]+))"/ms', $rdf_descr[1], $tb_ping_url)) {
					return $tb_ping_url[1];
				}
			}
		}
	}
	return false;
}
	
//faire un post sur l'url de trackback
function postTbPingURL($post_id,$url,$blog_name,$content='') {
	//si $post_id est valide (existe, est publié et est correctement daté), recupérer les data.
	$query = "SELECT titre, descriptif, chapo, texte
	  FROM spip_articles
	  WHERE statut='publie' AND date<=NOW() AND id_article=".$post_id;
	$result = spip_query($query);
	$article = spip_fetch_array($result);
	if(!is_array($article)) {
		return false;
	}
	else {
		if($content=='') {
			$content = calcul_introduction('articles', $article['texte'], $article['chapo'], $article['descriptif']);
		}
	}
			
	$post_url = url_absolue(generer_url_article($post_id));
	$post_title = $article['titre'];
	$post_excerpt = strlen($content)>255 ? couper($content, 252).'...' : $content;

	$postdata = "url=".urlencode($post_url);
	if(!empty($blog_name)) $postdata .= "&blog_name=".urlencode($blog_name);
	if(!empty($post_title)) $postdata .= "&title=".urlencode($post_title);
	if(!empty($post_excerpt)) $postdata .= "&excerpt=".urlencode($post_excerpt);

	for ($i=0;$i<10;$i++) {	// dix tentatives maximum en cas d'entetes 301...
		list($f, $fopen) = init_http("POST", $url);

		// si on a utilise fopen() - passer a la suite
		if ($fopen) {
			spip_log('connexion via fopen');
			break;
		} else {
			// Fin des entetes envoyees par SPIP
			fputs($f, "Content-Type: application/x-www-form-urlencoded\r\n");
			fputs($f, "Content-Length: ".strlen($postdata)."\r\n");
			fputs($f,"\r\n");
			fputs($f, $postdata);

			// Reponse du serveur distant
			$s = trim(fgets($f, 16384));
			if (ereg('^HTTP/[0-9]+\.[0-9]+ ([0-9]+)', $s, $r)) {
				$status = $r[1];
			}
			else return;

			// Entetes HTTP de la page
			$headers = '';
			while ($s = trim(fgets($f, 16384))) {
				$headers .= $s."\n";
				if (eregi('^Location: (.*)', $s, $r)) {
					include_ecrire('inc_filtres.php3');
					$location = suivre_lien($url, $r[1]);
					spip_log("Location: $location");
				}
				if (preg_match(",^Content-Encoding: .*gzip,i", $s))
					$gz = true;
			}
			if ($status >= 300 AND $status < 400 AND $location)
				$url = $location;
			else if ($status != 200)
				return;
			else
				break; # ici on est content
			fclose($f);
			$f = false;
		}
	}
	
	// Contenu de la page
	if (!$f) {
		spip_log("ECHEC chargement $url");
		return false;
	}

	$result = '';
	while (!feof($f))
		$result .= fread($f, 16384);
	fclose($f);

	// Decompresser le flux
	if ($gz)
		$result = gzinflate(substr($result,10));

	// Faut-il l'importer dans notre charset local ?

	//traiter le retour de POST d'un trackback
	$pattern = '|<response>.*<error>(.*)</error>(.*)'.
			'(<message>(.*)</message>(.*))?'.
			'</response>|msU';
		
	if (!preg_match($pattern,$result,$matches))
	{
		spip_log('Source is not a ping URL');
		return false;
	}
	
	# On continue, le match est OK
	$ping_error = $matches[1];
	$ping_msg = (!empty($matches[4])) ? $matches[4] : '';
	
	if ($ping_error != '0') {
		spip_log('Trackback error : '.$ping_msg);
		return false;
	} else {
		# Oui ! Le trackback est passé ! champagne :))
		# On va faire la notification
		spip_log("article $post_id : ping $url OK");
		return true;
	}
}

// Gestion des trackbacks espace privé

//
// Afficher les trackbacks
//

function afficher_trackback($request, $adresse_retour, $controle_id_article = 0) {
	global $debut;
	static $compteur_forum;
	static $nb_forum;
	static $i;
	global $couleur_foncee;
	global $connect_id_auteur, $connect_activer_messagerie;
	global $mots_cles_forums;
	global $spip_lang_rtl, $spip_lang_left, $spip_lang_right, $spip_display;

	$activer_messagerie = "oui";

	$compteur_forum++;

	$nb_forum[$compteur_forum] = spip_num_rows($request);
	$i[$compteur_forum] = 1;
	
	if ($spip_display == 4) echo "<ul>";
 
 	while($row = spip_fetch_array($request)) {
		$id_forum=$row['id_forum'];
		$id_parent=$row['id_parent'];
		$id_rubrique=$row['id_rubrique'];
		$id_article=$row['id_article'];
		$id_breve=$row['id_breve'];
		$id_message=$row['id_message'];
		$id_syndic=$row['id_syndic'];
		$date_heure=$row['date_heure'];
		$titre=$row['titre'];
		$texte=$row['texte'];
		$auteur=$row['auteur'];
		$email_auteur=$row['email_auteur'];
		$nom_site=$row['nom_site'];
		$url_site=$row['url_site'];
		$statut=$row['statut'];
		$ip=$row["ip"];
		$id_auteur=$row["id_auteur"];
	
		$forum_stat = $statut;
		if ($forum_stat == "prive") $logo = "forum-interne-24.gif";
		else if ($forum_stat == "privadm") $logo = "forum-admin-24.gif";
		else if ($forum_stat == "privrac") $logo = "forum-interne-24.gif";
		else $logo = "forum-public-24.gif";

		if ($compteur_forum==1) echo "\n<br /><br />";
		$afficher = ($controle_id_article) ? ($statut!="perso") :
			(($statut=="prive" OR $statut=="privrac" OR $statut=="privadm" OR $statut=="perso")
			OR ($statut=="tbpublie" AND $id_parent > 0));

		if ($afficher) {
			echo "<a id='$id_forum'></a>";
			if ($spip_display != 4) echo "<table width='100%' cellpadding='0' cellspacing='0' border='0'><tr>";
			for ($count=2;$count<=$compteur_forum AND $count<20;$count++){
				$fond[$count]=_DIR_IMG_PACK . 'rien.gif';
				if ($i[$count]!=$nb_forum[$count]){
					$fond[$count]=_DIR_IMG_PACK . 'forum-vert.gif';
				}
				$fleche='rien.gif';
				if ($count==$compteur_forum){
					$fleche="forum-droite$spip_lang_rtl.gif";
				}
				if ($spip_display != 4) echo "<td width='10' valign='top' background=$fond[$count]>" .
				  http_img_pack($fleche, " ", "width='10' height='13' border='0'"). "</td>\n";
			}

			if ($spip_display != 4) echo "\n<td width=100% valign='top'>";

			$titre_boite = $titre;
			if ($id_auteur AND $spip_display != 1 AND $spip_display!=4 AND lire_meta('image_process') != "non") {
				include_ecrire("inc_logos.php3");
				$logo_auteur = decrire_logo("auton$id_auteur");
				if ($logo_auteur) {
					$fichier = $logo_auteur[0];
	
					$s = "<div style='position: absolute; $spip_lang_right: 0px; margin: 0px; margin-top: -3px; margin-$spip_lang_right: 0px;'>";
					$s .= reduire_image_logo(_DIR_IMG.$fichier, 48, 48);
					$s .= "</div>";
					$titre_boite = $s.typo($titre_boite);
				}
			}
		
			if ($spip_display == 4) {
				echo "<li>".typo($titre)."<br>";
			} else {
				if ($compteur_forum == 1) echo debut_cadre_forum($logo, false, "", $titre_boite);
				else echo debut_cadre_thread_forum("", false, "", $titre_boite);
			}
			
			// Si refuse, cadre rouge
			if ($statut=="tboff") {
				echo "<div style='border: 2px dashed red; padding: 5px;'>";
			}
			// Si propose, cadre jaune
			else if ($statut=="tbprop") {
				echo "<div style='border: 1px solid yellow; padding: 5px;'>";
			}
		
		
		
		echo "<span class='arial2'>";
		//	echo affdate_court($date_heure);
		//	echo ", ";
		//	echo heures($date_heure).":".minutes($date_heure);
			
			echo date_relative($date_heure);
			
			echo "</span>";
			
			echo " <a href='auteurs_edit.php3?id_auteur=$id_auteur'>".typo($auteur)."</a>";

			if ($id_auteur AND $connect_activer_messagerie != "non") {
				$bouton = bouton_imessage($id_auteur,$row_auteur);
				if ($bouton) echo "&nbsp;".$bouton;
			}

			// boutons de moderation
			if ($controle_id_article)
				echo boutons_controle_trackback($id_forum, $statut, $id_auteur, "id_article=$controle_id_article", $ip);

			echo justifier(propre($texte));

			if (strlen($url_site) > 10 AND $nom_site) {
				echo "<div align='left' class='verdana2'><b><a href='$url_site'>$nom_site</a></b></div>";
			}

			if (!$controle_id_article) {
				echo "<div align='right' class='verdana1'>";
				$url = "forum_envoi.php3?id_parent=$id_forum&adresse_retour=".rawurlencode($adresse_retour)
					."&titre_message=".rawurlencode($titre);
				echo "<b><a href=\"$url\">"._T('lien_repondre_message')."</a></b></div>";
			}

			if ($mots_cles_forums == "oui"){

				$query_mots = "SELECT * FROM spip_mots AS mots, spip_mots_forum AS lien WHERE lien.id_forum = '$id_forum' AND lien.id_mot = mots.id_mot";
				$result_mots = spip_query($query_mots);

				while ($row_mots = spip_fetch_array($result_mots)) {
					$id_mot = $row_mots['id_mot'];
					$titre_mot = propre($row_mots['titre']);
					$type_mot = propre($row_mots['type']);
					echo "<li> <b>$type_mot :</b> $titre_mot";
				}

			}
	
			if ($statut == "tboff" OR $statut == "tbprop") echo "</div>";

			if ($spip_display != 4) {
				if ($compteur_forum == 1) echo fin_cadre_forum();
				else echo fin_cadre_thread_forum();
			}

			if ($spip_display != 4) echo "</td></tr></table>\n";

			afficher_thread_forum($id_forum,$adresse_retour,$controle_id_article);

		}
		$i[$compteur_forum]++;
	}
	if ($spip_display == 4) echo "</ul>";
	spip_free_result($request);
	$compteur_forum--;
}

// tous les boutons de controle d'un trackback
function boutons_controle_trackback($id_forum, $forum_stat, $forum_id_auteur=0, $ref, $forum_ip) {
	$controle = '';

	// selection du logo et des boutons correspondant a l'etat du forum
	switch ($forum_stat) {
		# forum publie sur le site public
		case "tbpublie":
			$logo = "forum-public-24.gif";
			$valider = false;
			$valider_repondre = false;
			$supprimer = 'supp_forum';
			break;
		# forum supprime sur le site public
		case "tboff":
			$logo = "forum-public-24.gif";
			$valider = 'valid_forum';
			$valider_repondre = false;
			$supprimer = false;
			$message = "<BR><FONT COLOR='red'><B>"._T('info_message_supprime')." $forum_ip</B></FONT>";
			if($forum_id_auteur)
				$message .= " - <A HREF='auteurs_edit.php3?id_auteur="
				.$forum_id_auteur."'>" ._T('lien_voir_auteur'). "</A>";
			break;
		# forum propose (a moderer) sur le site public
		case "tbprop":
			$logo = "forum-public-24.gif";
			$valider = 'valid_forum';
			$valider_repondre = false;
			$supprimer = 'supp_forum';
			break;
		default:
			return;
	}

	if ($message)
		$controle .= $message;

	if ($supprimer)
		$controle .= controle_cache_trackback($supprimer,
			$id_forum,
			_T('icone_supprimer_message'), 
			$logo,
			"supprimer.gif");

	if ($valider)
		$controle .= controle_cache_trackback($valider,
			$id_forum,
			_T('icone_valider_message'), 
			$logo,
			"creer.gif");

	if ($valider_repondre) {

		$controle .= controle_cache_trackback($valider,
			$id_forum,
			_T('icone_valider_message') . " &amp; " .
			_T('lien_repondre_message'),
			$logo,
			"creer.gif",
			"../forum.php3?$ref&id_forum=$id_forum"
		);
	}

	return $controle;
}

// Installer un bouton de moderation de trackback dans l'espace prive
function controle_cache_trackback($action, $id, $texte, $fond, $fonction, $but='') {
        $link = new Link();

        $link->addvar('controle_trackback', $action);
        $link->addvar('id_controle_trackback', $id);
        $link = $link->geturl() . "#id$id";

        if ($but)
                $link = $but . "&retour= ecrire/" . urlencode($link);

        return icone($texte,
                $link,
                $fond,
                $fonction,
                "right",
                'non');
}

function controler_statut_trackback ($controle_trackback, $id_controle_trackback) {
	// Verifier qu'on a le droit d'agir sur ce forum
	global $connect_toutes_rubriques, $connect_statut;
	$ok = ($connect_statut == "0minirezo" AND $connect_toutes_rubriques);
	if (!$ok) return;

	// Que faut-il faire ?
	switch($controle_trackback) {
		case 'supp_trackback':
			$statut = 'tboff';
			break;
		case 'valid_trackback':
			$statut = 'tbpublie';
			break;
	}
	changer_statut_forum($id_controle_trackback, $statut);
	return $statut;
}

?>
