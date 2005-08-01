<?php

	include('ecrire/inc_version.php3');
	$dossier_squelettes = 'sedna/';
	$forcer_lang = true;

	// filtre |syndication_en_erreur
	function syndication_en_erreur($statut_syndication) {
		if ($statut_syndication == 'off'
		OR $statut_syndication == 'sus')
			return _T('sedna_probleme_de_syndication');
	}

	// filtre de nettoyage XHTML strict d'un contenu potentiellement hostile
	// |textebrut|lignes_longues|entites_html|antispam2|texte_script
	function nettoyer_texte($texte) {
		return texte_script(
			antispam2(
			corriger_toutes_entites_html(
			entites_html(
			lignes_longues(
			textebrut(
				$texte
			))))));
	}

	// tri maison : d'abord par jour de syndication,
	// et a l'interieur du jour par date de maj
	function critere_tri_sedna($idb, &$boucles, $crit) {
		$boucle = &$boucles[$idb];
		$boucle->order = array(
			"'date_format(syndic_articles.date,\\'%Y-%m-%d 00:00:00\\') DESC', 'syndic_articles.maj DESC'"
		);
	}

	// critere {contenu}
	function critere_contenu($idb, &$boucles, $crit) {
		$boucle = &$boucles[$idb];

		// un peu trop rapide, ca... le compilateur exige mieux
		$boucle->hash = '
		// RECHERCHE
		if ($r = addslashes($GLOBALS["recherche"]))
			$s = "(syndic_articles.descriptif LIKE \'%$r%\'
				OR syndic_articles.titre LIKE \'%$r%\'
				OR syndic_articles.url LIKE \'%$r%\'
				OR syndic_articles.lesauteurs LIKE \'%$r%\')";
			else $s = 1;
		';
		$boucle->where[] = '$s';
	}

	// l'identifiant du lien est fonction de son url et de sa date
	// ce qui permet de reperer les "updated" *et* les doublons
	include_ecrire('inc_filtres.php3');
	function afficher_lien(
		$id_syndic_article,
		$id_lien,
		$id_syndic,
		$date,
		$url,
		$titre,
		$lesauteurs,
		$desc
		) {
		static $vu, $lus, $ferme_ul, $id, $iddesc;
		global $ex_syndic, $class_desc;

		// Articles a ignorer
		if (!$_GET['id_syndic']
		AND $_COOKIE['sedna_ignore_'.$id_syndic])
			return;

		// initialiser la liste des articles lus
		if (!is_array($lus))
			$lus = array_flip(split('-', '-'.$_COOKIE['sedna_lu']));

		if ($vu[$id_lien]++) return;

		// regler la classe des liens, en fonction du cookie sedna_lu
		$class_link = $lus[$id_lien] ? 'vu' : '';

		if (unique(substr($date,0,10)))
			$affdate = '<h1 class="date">'
				.jour($date).' '.nom_mois($date).'</h1>';


		// indiquer un intertitre si on change de source ou de date
		if ($affdate OR ($id_syndic != $ex_syndic)) {
			echo $ferme_ul; $ferme_ul="</ul>\n";
			echo $affdate;
		}

		// Suite intertitres
		if ($affdate OR ($id_syndic != $ex_syndic)) {
			echo "<h2 class='site' id='site${id_syndic}_".(++$id)."'
			onmouseover=\"getElementById('url".$id."').className='urlsiteon';\"
			onmouseout=\"getElementById('url".$id."').className='urlsite';\"
			>";
			echo "<a href=\"?id_syndic=$id_syndic";
			if ($age = intval($GLOBALS['age']))
				echo "&amp;age=$age";
			echo "\">".$GLOBALS['nom_site_'.$id_syndic]
				."</a>";
			echo " <a class=\"urlsite\"
					href=\""
					.$GLOBALS['url_site_'.$id_syndic]
					.'" id="url'.$id.'">'
					.$GLOBALS['url_site_'.$id_syndic]
					."</a>";
			echo "</h2>\n<ul>\n";
			$ex_syndic = $id_syndic;
		}

		echo "<li class='item'";
		if (!$_GET['id_syndic'] AND !strlen($_GET['recherche']))
			echo " id='item${id_syndic}_${id_syndic_article}'";
		echo "	onmousedown=\"jai_lu('$id_lien');\">\n",
		"<small>".affdate($date,'H:i')."</small>",
		"<div class=\"titre\"><a href=\"$url\"
			title=\"$url\"
			class=\"link$class_link\"
			id=\"news$id_lien\">",
		$titre, "</a>", $lesauteurs, "</div>";
		
		if ($desc)
			echo "<div class=\"desc\"><div class=\"$class_desc\" id=\"desc_".(++$iddesc)."\">\n",
			$desc, '</div></div>';
		
		echo "\n</li>\n";
	}


	// identifiant d'un lien en fonction de son url et sa date, 4 chars
	// 3ko = 500 * (5 caracteres + espace)
	// 16**5 possibilites = suffisant pour eviter risque de doublons sur 500
	function creer_identifiant ($url,$date) {
		return substr(md5("$date$url"),0,5);
	}

	// unicode 24D0 = caractere de forme "(a)"
	function antispam2($texte) {
		return preg_replace(',(\w+)@(\w+\.\w+),','\\1&#x24d0;\\2', $texte);
	}

	function parametre_url($url, $parametre, $valeur = '__global__') {
		$link = new Link(str_replace('&amp;', '&', $url));
		if($valeur == '__global__')
			$valeur = $GLOBALS[$parametre];
		if(empty($valeur)) $link->DelVar($parametre);
		else $link->AddVar($parametre, $valeur);
		return quote_amp($link->getUrl());
	}

	// Choix du $fond (rss ou sedna)
	if ($rss) {
		$fond = 'sedna-rss';
	}
	else {
		$fond='sedna';
	}


	// Descriptifs : affiches ou masques ?
	// l'accessibilite sans javascript => affiches par defaut
	if ($_COOKIE['sedna_style'] == 'masquer') {
		$class_desc = "desc_masquer";
		$sel1="selected"; $sel2="";
	} else {
		$class_desc = "desc_afficher";
		$sel2="selected"; $sel1="";
	}


	// authentification du visiteur
	if ($GLOBALS['_COOKIE']['spip_session'] OR
	($GLOBALS['_SERVER']['PHP_AUTH_USER']  AND !$ignore_auth_http)) {
		include_ecrire ("inc_session.php3");
		verifier_visiteur();
	}

	// Si synchro active il faut comparer le contenu du cookie et ce
	// qu'on a stocke dans le champ spip_auteurs.sedna (a creer au besoin)
	$synchro = '';
	if ($_COOKIE['sedna_synchro'] == 'oui'
	AND $id = $auteur_session['id_auteur']) {
		// Recuperer ce qu'on a stocke
		if (!$s = spip_query("SELECT sedna FROM spip_auteurs
		WHERE id_auteur=$id")) {
			// creer le champ sedna si ce n'est pas deja fait
			spip_query("ALTER TABLE spip_auteurs
			ADD sedna TEXT NOT NULL DEFAULT ''");
		}
		list($champ) = spip_fetch_array($s);
		// mixer avec le cookie en conservant un ordre chronologique
		if ($_COOKIE['sedna_lu'] <> $champ) {
			$lus_cookie = preg_split(',[- +],',$_COOKIE['sedna_lu']);
			$lus_champ = preg_split(',[- +],',$champ);
			$lus = array();
			while (count($lus_cookie) OR count($lus_champ)) {
				if ($a = array_shift($lus_cookie))
					$lus[$a] = true;
				if ($a = array_shift($lus_champ))
					$lus[$a] = true;
			}
			$lus = substr(join('-', array_keys($lus)),0,3000); # 3ko maximum
			// Mettre la base a jour
			spip_query("UPDATE spip_auteurs SET sedna='"
				.addslashes($lus)."'
				WHERE id_auteur=$id");
			$synchro = ' *';

			// Si le cookie n'est pas a jour, on l'update sur le brouteur
			if ($lus <> $_COOKIE['sedna_lu']) {
				// path='/chemin/vers/sedna/' comme dans sedna.js
				$cookiepath = preg_replace(',^[^/]*://[^/]*,',
					'',lire_meta('adresse_site'))
					. preg_replace(',/$,','','/'.$dossier_squelettes);

				spip_setcookie('sedna_lu', $lus,
					time()+365*24*3600, $cookiepath);
					$_COOKIE['sedna_lu'] = $lus;
				// Signaler que la synchro a eu lieu
				$synchro = ' &lt;&lt;';
			}
		}
	}

	// forcer le refresh ?
	if ($id = intval($refresh)) {
		include_ecrire('inc_sites.php3');
		spip_touch('ecrire/data/sites.lock');
		syndic_a_jour($id);
	}

	// Calcul du $delais optimal (on est tjs a jour, mais quand meme en cache)
	// valeur max = 15 minutes (900s) (et on hacke #ENV{max_maj} pour affichage
	// de "Derniere syndication..." en pied de page).
	$_GET['max_maj'] = @filemtime('ecrire/data/sites.lock');
	$delais= min(900,max(0,time()-$_GET['max_maj']));
	$_GET['max_maj'] = date('Y-m-d H:i:s', $_GET['max_maj']); # format SPIP

	// On ne veut pas de cache navigateur, pour le "*" de synchro et pour
	// la liste des sites ignores (cookies)
	$flag_dynamique = true;

	$flag_preserver=true;
	include('inc-public.php3');

?>
