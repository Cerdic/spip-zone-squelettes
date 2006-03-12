<?php
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
	//include_spip('inc/filtres');
	function afficher_lien(
		$id_syndic_article,
		$id_lien,
		$id_syndic,
		$date,
		$url,
		$titre,
		$lesauteurs,
		$desc,
		$lang
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
			echo "<h2 id='site${id_syndic}_".(++$id)."'
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

		echo "<li class='entry'";
		if (!$_GET['id_syndic'] AND !strlen($_GET['recherche']))
			echo " id='item${id_syndic}_${id_syndic_article}'";
		echo "	onmousedown=\"jai_lu('$id_lien');\">\n",
#		"<small>".affdate($date,'H:i')."</small>",
		"<abbr class='published updated'
		title='".date_iso($date)."'>".affdate($date,'H:i')."</abbr>", 
		"<div class=\"titre\">",
		"<a href=\"$url\"
			title=\"$url\"
			class=\"link$class_link\"
			id=\"news$id_lien\"
			rel=\"bookmark\"";
		if ($lang) echo " hreflang=\"$lang\"";
		echo ">",
		"<span class=\"title\">", # le "title" du microformat hAtom.feed.entry
		$titre, "</span></a>",
		$lesauteurs,
		"\n<span class=\"source\"><a href=\"",
		$GLOBALS['url_site_'.$id_syndic]."\">",
		$GLOBALS['nom_site_'.$id_syndic]."</a></span>\n",
		"</div>\n";

		if ($desc)
			echo "<div class=\"desc\">",
			"<div class=\"$class_desc\" id=\"desc_".(++$iddesc)."\">\n",
			"<span class=\"content\">", $desc, "</span>\n",
			'</div></div>';
		

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

	## fonction integree dans inc_filtres a partir de SPIP >= 1.8.2d
	if (!function_exists('parametre_url')) {
	function parametre_url($url, $parametre, $valeur = '__global__') {
		$link = new Link(str_replace('&amp;', '&', $url));
		if($valeur == '__global__')
			$valeur = $GLOBALS[$parametre];
		if(empty($valeur)) $link->DelVar($parametre);
		else $link->AddVar($parametre, $valeur);
		return quote_amp($link->getUrl());
	}
	}

	// On ne veut pas de cache navigateur, pour le "*" de synchro et pour
	// la liste des sites ignores (cookies)
	$flag_dynamique = true;

	$flag_preserver=true;
	//include 'spip.php';

?>
