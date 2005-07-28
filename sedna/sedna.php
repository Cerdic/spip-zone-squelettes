<?php

	include('ecrire/inc_version.php3');
	$dossier_squelettes = 'sedna/';

	// filtre |syndication_en_erreur
	function syndication_en_erreur($statut_syndication) {
		if ($statut_syndication == 'oui') return '';
		return _L('Erreur de syndication');
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
		$id_lien,
		$id_syndic,
		$heure,
		$url,
		$titre,
		$lesauteurs,
		$desc
		) {
		static $vu, $lus;
		global $ex_syndic, $class_desc;

		// initialiser la liste des articles lus
		if (!is_array($lus)) {
			foreach (explode(' ', $_COOKIE['sedna_lu']) as $id)
				$lus[$id]=true;
		}

		if ($vu[$id_lien]++) return;

		// regler la classe des liens, en fonction du cookie sedna_lu
		$class_link = $lus[$id_lien] ? 'vu' : '';

		// indiquer un intertitre si on change de source ou de date
		if ($id_syndic != $ex_syndic) {
			echo "</ul>\n";
			echo "<h2 class='site' name='site$id_syndic'
				onmousedown=\"highlight_site('site$id_syndic');\"
			>";
			echo $GLOBALS["memo_$id_syndic"];
			echo "</h2>\n<ul>\n";
			$ex_syndic = $id_syndic;
		}
		
		echo "<li class='item' onmousedown=\"jai_lu('$id_lien');\">\n",
		"<small>$heure</small> &nbsp;\n",
		"<a href=\"$url\"
			title=\"".attribut_html($url)."\"
			class=\"link$class_link\"
			id=\"news$id_lien\">",
		$titre, "</a>", $lesauteurs;
		
		if ($desc)
			echo "<div class=\"desc\"><div class=\"$class_desc\" name=\"desc\">\n",
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

	// Si synchro active il faut comparer la date du cookie et ce qu'on a
	// stocke dans le champ spip_auteurs.sedna (a creer au besoin)
	$synchpo = '';
	if ($_COOKIE['sedna_synchro'] == 'oui'
	AND $id = $auteur_session['id_auteur']) {
		// Restaurer ce qu'on a stocke, ou stocker ce qui est nouveau
		if (!$s = spip_query("SELECT sedna FROM spip_auteurs
		WHERE id_auteur=$id")) {
			// creer le champ sedna si ce n'est pas deja fait
			spip_query("ALTER TABLE spip_auteurs
			ADD sedna TEXT NOT NULL DEFAULT ''");
		}

		list($champ) = spip_fetch_array($s);
		if (preg_match('@^([0-9]+),(.*)@', $champ, $regs)) {
			$date_synchro = $regs[1];
			$lus = $regs[2];
		}

		// Si le cookie n'est pas le meme que celui qui est stocke
		if ($lus <> $_COOKIE['sedna_lu']) {

			// path='/chemin/vers/sedna/' comme dans sedna.js
			$cookiepath = preg_replace(',^[^/]*://[^/]*,',
				'',lire_meta('adresse_site'))
				. preg_replace(',/$,','','/'.$dossier_squelettes);

			// Exporter la valeur vers le brouteur si plus recente
			if ($date_synchro > $_COOKIE['sedna_synchro_date']) {
				spip_setcookie('sedna_lu', $lus,
					time()+365*24*3600, $cookiepath);
				$_COOKIE['sedna_lu'] = $lus;

				// Signaler que la synchro a eu lieu
				$synchro = ' &lt;&lt;&lt;';
			}
			// sinon prendre la valeur qui est dans le brouteur
			else if ($date_synchro == $_COOKIE['sedna_synchro_date']) {
				$date_synchro = date('U');
				spip_query("UPDATE spip_auteurs SET sedna='$date_synchro,"
					.addslashes($_COOKIE['sedna_lu'])."'
					WHERE id_auteur=$id");

				// Signaler que la synchro a eu lieu
				$synchro = ' *';
			} else {
				$synchro = ' ??'; // bug de cookie
			}

			// Mettre a jour la date de synchro sur le brouteur
			spip_setcookie('sedna_synchro_date', $date_synchro,
				time()+365*24*3600, $cookiepath);
		}
	}

	// forcer le refresh ?
	if ($id = intval($refresh)) {
		include_ecrire('inc_sites.php3');
		syndic_a_jour($id);
	}

	// Calcul du $delais optimal (on est tjs a jour, mais quand meme en cache)
	// valeur max = 15 minutes (900s)
	$s = spip_query("SELECT UNIX_TIMESTAMP(NOW()),
		UNIX_TIMESTAMP(MAX(maj)) FROM spip_syndic_articles
		");
	list($now,$max_maj) = spip_fetch_array($s);
	if (!$synchro) {
		$delais= min(900,max(0,$now-$max_maj));
	} else
		$delais=0;

	$flag_preserver=true;
	include('inc-public.php3');

?>
