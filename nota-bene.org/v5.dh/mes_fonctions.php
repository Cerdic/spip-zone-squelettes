<?php

/**
 * Réglages génériques
 */
$GLOBALS['debut_intertitre'] = "\n<h2>";
$GLOBALS['fin_intertitre'] = "</h2>\n";

/*
$GLOBALS['ouvre_ref'] = '<span class="footnote">';
$GLOBALS['ferme_ref'] = '</span>';
*/
$GLOBALS['ouvre_ref'] = '';
$GLOBALS['ferme_ref'] = '';
$GLOBALS['ouvre_note'] = '<strong>';
$GLOBALS['ferme_note'] = '.</strong> ';
$GLOBALS['puce'] = '<img src="/v5/img/puce.gif" width="9" height="5" alt="-" />';

/**
 * Filtres spécifiques nota-bene.org V5
 */

/**
 * nb_netvibes_lang
 * @return la langue de l'article si une langue est précisée en [**]
 *         ou vide
 * @param $str Object
 */
function nb_netvibes_lang($str) {
	$lang="";
	if( preg_match("/\[([a-z]{2})\]/",$str,$results) ) {
		$lang = $results[1];
	}
	return $lang;
}

/**
 * nb_netvibes_hreflang
 * @return le hreflang de l'article s'il est précisé en [hreflang=**]
 *         ou vide
 * @param $str Object
 */
function nb_netvibes_hreflang($str) {
	$lang="";
	if( preg_match("/\[hreflang\=([a-z]{2})\]/",$str,$results) ) {
		$lang = $results[1];
	}
	return $lang;
}

/**
 * nb_netvibes_titre
 * @return $str mais sans les "Untel shared as favorite "
 * @param $str Object
 */
function nb_netvibes_titre($str) {
	$sub = "/Stephane Deschamps shared as favorite |notabeneorg shared as favorite /";
	$str = preg_replace($sub,"",$str);
	return $str;
}

/**
 * nb_netvibes_descriptif
 * @return $str nettoyé des hreflang, des lang, et les tags sont transformés en liens
 * @param $str Object
 */
function nb_netvibes_descriptif($str) {
	// stockage du hreflang en cas de citations dans le corps du descriptif
	$hreflang = nb_netvibes_hreflang($str);

	// vidage langue
	$str = preg_replace("/\[(hreflang)\=([a-z]{2})\]|\[([a-z]{2})\]/","",$str);
	// ajout liens sur les tags
	$str = preg_replace("/#((\S)*)/i","<a href='/recherche.html?recherche=\\1'>\\0</a>",$str);
	// s'il reste des crochets, en faire des balises HTML
	$str = preg_replace("/\[/","<",$str);
	$str = preg_replace("/\]/",">",$str);
	// s'il y a des <q> et que hreflang!="" alors ajouter un lang="" sur le <q>
	if($hreflang!="") {
		$str = preg_replace("/<q>/","<q lang='$hreflang'>",$str);
	}
	return $str;
}

/**
* gravatar pour l'email du mec qui commente
* */

function nb_gravatar($str,$size=48) {
    if($str!='') {
        //$strtmp = 'http://www.gravatar.com/avatar.php?gravatar_id='.md5($str).'&amp;size='.$size.'&amp;rating=PG&amp;default=' . urlencode("http://www.nota-bene.org/rien.gif") ;
        $str = "gravatar-" . md5($str);
    }
    return $str;
}

/**
 * Corriger les URLs des appels de notes qui ne sont pas bonnes dans spip
 */
function nb_corrigerss($str,$url_site_spip='') {
	//$url_site_spip = "http://localhost:81/"; //debug
	if($str!='' && $url_site_spip!='') {
		if(!preg_match(",/,",substr($url_site_spip,strlen($url_site_spip)-2))) {
			$url_site_spip .= "/";
		}
		//$str = preg_replace(",http://([^#]*)(#nh|#nb),U","\\2",$str); // ancienne regexp mais posait probleme si on pointait vers une ancre d'un site
		$str = preg_replace(",($url_site_spip)(#nh|#nb),U","\\2",$str);
	}
	return $str;
}

/**
 * nb_FuzzyDate
 * donne des dates plus sympas dans les forums
 * @return 
 * @param $date Object
 */
function nb_FuzzyDate($date) {
	if($date!='') {
		// this is now
		$now = date("U");
		// a day is 
		$oneday = 3600 * 24;

		// reconstructing a proper date from what's in the database
		$test_date = preg_match_all(",[0-9]*,",$date,$matches);
		$Y = $matches[0][0];
		$M = $matches[0][2];
		$D = $matches[0][4];
		$computed = date("U", mktime(0,0,0,$M,$D,$Y) );
		
		// $diff is the number of days between $now and $computed
		$diff = floor(($now-$computed)/$oneday);

		// conditionally setting $date
		if($diff < 1) { // then it's today
			$date = _T('fuzzy_today');
		} else if($diff < 2) { // then it's yesterda
			$date = _T('fuzzy_yesterday');
		} else if($diff < 7) { // then it's last {weekday}
			$date = _T('fuzzy_last_w' . date("w",$computed) );
		} else { // too old: resorting to classical affdate display
			$date = affdate($date);
		}
	}
	return $date;
}

/*
* gestion des abreviations
* credits : Michel Valdrighi pour l'idee originale
*           Julien Wajsberg et Gabriel Euzet pour l'aide a la simplification
* */
function nb_abbr($str) {
    // reste a finir : definitions comme mots entiers
    $array_acronyms = array(
        '/ALA/' => '<abbr title="A List Apart">\\0</abbr>',
		'/ARIA/' => '<acronym title="Accessible Rich Internet Application">\\0</acronym>',
        '/CSS/' => '<abbr title="Cascading Stylesheets">\\0</abbr>',
        '/DOM/' => '<acronym title="Document Object Model">\\0</acronym>',
		'/([^a-z])(etc\.)/' => '\\1<abbr title="et c&aelig;tera">\\2</abbr>',
        '/GIF/' => '<abbr title="Graphic Interchange Format">\\0</abbr>',
        '/([^A-Z])(HTML)/' => '\\1<abbr title="Hypertext Markup Language">\\2</abbr>',
        '/JS/' => '<abbr title="Javascript">\\0</abbr>',
        '/MDC/' => '<abbr title="Mozilla Developer Center">\\0</abbr>',
        '/MSIE/' => '<abbr title="Microsoft Internet Explorer">\\1</abbr>',
        '/([^A-Z])(IE)([^A-Z])/' => '\\1<abbr title="Microsoft Internet Explorer">\\2</abbr>\\3',
        '/([^A-Z])(NN)([^A-Z])/' => '\\1<abbr title="Netscape Navigator">\\2</abbr>\\3',
        '/PDF/' => '<abbr title="Portable Document Format">\\0</abbr>',
        '/PNG/' => '<abbr title="Portable Network Graphics">\\0</abbr>',
        '/RSS/' => '<abbr title="Really Simple Syndication">\\0</abbr>',
        '/SEO/' => '<abbr title="Search Engine Optimization">\\0</abbr>',
        '/W[aA][sS]P/' => '<acronym title="Web Standards Project">WaSP</acronym>',
        '/W3C/' => '<abbr title="World Wide Web Consortium">\\0</abbr>',
        '/WCAG/' => '<abbr title="Web Content Accessibility Guidelines">\\0</abbr>',
        '/wifi/i' => '<acronym title="Wireless network">\\0</acronym>',
        '/XHTML/i' => '<abbr title="eXtensible Hypertext Markup Language">\\0</abbr>',
        '/XML/' => '<abbr title="eXtensible Markup Language">\\0</abbr>',
        '/XSLT/' => '<abbr title="eXtensible Style Language Transformation">\\0</abbr>',
        '/(XSL)([^A-Z])/' => '<abbr title="eXtensible Style Language">\\1</abbr>\\2'
    );

    if( !ereg('<',$str)) { // premier test pour le cas des titres
        $str = preg_replace(array_keys($array_acronyms), array_values($array_acronyms) , $str);
    } else {
        $coll = explode('<',$str);
        $str = '' . $coll[0]; // on prend le premier morceau, qu'il soit vide ou pas
        for($i=1;$i<count($coll);$i++) {
            $coll[$i] = '<' . $coll[$i];
            if(!preg_match('/(<abbr|<acronym)/i',$coll[$i])) { // si le tag n'est ni abbr ni acronym
                $str .= substr($coll[$i],0,strpos($coll[$i],'>')+1)
                    . preg_replace(array_keys($array_acronyms), array_values($array_acronyms) , substr($coll[$i],strpos($coll[$i],'>')+1));
            } else { // sinon passer tel quel et aller au tag suivant
                $str .= $coll[$i];
            }
        }
    }
    return $str;
}

/**
 * nb_commentaires_nofollow
 * ajouter un attribut nofollow aux liens en commentaires
 * @return 
 * @param $str Object
 */
function nb_commentaires_nofollow($str) {
	if($str != "") {
		$str = preg_replace("/a href=/","a rel=\"nofollow\" href=",$str);
	}
	
	return $str;
}

function nb_dateexif($array) {
	$str = "";
	if(is_array($array)) {
		$str = $array['DateTime'];
		// EXIF 2011:04:21 20:51:05
		// format attendu : 2011-04-21 20:51:05 
		$str = substr($str,0,4) . "-" . substr($str,5,2) . "-" . substr($str,8,2) . " 00:00:00";
		$str = affdate($str);
	}
	return $str;
}
?>