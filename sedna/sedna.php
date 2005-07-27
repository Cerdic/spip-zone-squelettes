<?php

	include('ecrire/inc_version.php3');
	$dossier_squelettes = 'sedna/';

	// critere {contenu}
	function critere_contenu($idb, &$boucles, $crit) {
		$boucle = &$boucles[$idb];

		$boucle->hash = '
		// RECHERCHE
		if ($r = addslashes($GLOBALS["recherche"])) $s="(syndic_articles.descriptif LIKE \'%$r%\'
			OR syndic_articles.titre LIKE \'%$r%\'
			OR syndic_articles.url LIKE \'%$r%\'
			OR syndic_articles.lesauteurs LIKE \'%$r%\')";
			else $s=1;
		';

		// un peu trop rapide, ca... le compilateur exige mieux
		$boucle->where[] = '$s';
	}

	// l'identifiant du lien est fonction de son url et de sa date
	// ce qui permet de reperer les "updated" *et* les doublons
	function afficher_lien(
		$id_lien,
		$id_syndic,
		$heure,
		$url,
		$titre,
		$lesauteurs,
		$desc
		) {
		static $vu;
		global $ex_syndic, $class_desc;
		
		if ($vu[$id_lien]++) return;

		// regler la classe des liens, en fonction du cookie sedna_lu
		$class_link = strstr(__articles_lus,' '.$id_lien.' ') ? 'vu' : '';

		// indiquer un intertitre si on change de source ou de date
		if ($id_syndic != $ex_syndic) {
			echo "</ul>\n";
			echo '<h2 class="site" name="site$id_syndic"
				onmousedown="highlight_site(\'site$id_syndic\');"
			>';
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
		$flag_preserver=true;
	}
	else {
		$fond='sedna';
	}


	// Descriptifs : affiches ou masques ?
	if ($_COOKIE['sedna_style'] == 'afficher') {
		$class_desc = "desc_afficher";
		$sel2="selected"; $sel1="";
	} else {
		$class_desc = "desc_masquer";
		$sel1="selected"; $sel2="";
	}

	// Si memo est active il faut comparer la date du cookie et ce qu'on a
	// stocke dans le champ pgp de l'auteur
	if ($var_memo AND $id = $auteur_session['id_auteur']) {
		// Restaurer ce qu'on a stocke, ou stocker ce qui est nouveau
		if ($var_memo=='synchroniser') {
			list($champ) = spip_fetch_array(spip_query(
				"SELECT pgp FROM spip_auteurs WHERE id_auteur=$id"
			));
			# note path='/' comme dans sedna.js
			spip_setcookie('sedna_lu', $champ, time()+365*24*3600, '/');
			$_COOKIE['sedna_lu'] = $champ;
		} else if ($var_memo=='enregistrer') {
			$champ=addslashes($_COOKIE['sedna_lu']);
			spip_query("UPDATE spip_auteurs SET pgp='$champ'
				WHERE id_auteur=$id");
		}
	}

	define('__articles_lus', ' '.$_COOKIE['sedna_lu'].' ');


	if ($id = intval($refresh)) {
		include_ecrire('inc_sites.php3');
		syndic_a_jour($id);
	}


	$delais=0;
	include('inc-public.php3');

?>