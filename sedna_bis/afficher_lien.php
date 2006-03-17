<?php
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
?>
