<?php

//      Mes_fonctions.php3

/*
* les notes ont un petit bug :il manque parfois le <p> de debut
* cette fonction y remedie
* fonction utilisee aussi sur mon site pour la bio des auteurs notamment
* */

function nb_checkparas($str) {
    $str = trim($str);
    if($str!="") {
        if(substr($str, 0, 2)!="<p") {
            $str = "<p>" . $str;
        }
        if(substr($str, strlen($str)-4, 4)!="</p>") {
            $str .= "</p>";
        }
    }
    return $str;
}
// FIN du filtre nb_checkparas

/*
 *   +----------------------------------+
 *    Nom du Filtre : Sommaire de l'article
 *   +----------------------------------+
 *    Date : dimanche 9 février 2003
 *    Auteur :  Noplay (noplay@altern.org)
 *   +-------------------------------------+
 *    Fonctions de ce filtre :
 *      Cette modification permet d'afficher le sommaire de son article
 *      généré dynamiquement à partir du texte de l'article. Vous pouvez naviguer
 *      dans l'article en cliquant sur les titres du sommaire.
 *
 *      Tous ce qui ce trouve entre {{{ et }}} est considéré comme un titre à ajouter au sommaire de l'article.
 *   +-------------------------------------+
 *
 * Pour toute suggestion, remarque, proposition d'ajout
 * reportez-vous au forum de l'article :
 * http://www.uzine.net/spip_contrib/article.php3?id_article=76
*/
function sommaire_article($texte,$istxt=0)
{

	preg_match_all("|(\{[\{12345]\{)(.*)(\}[\}12345]\})|U", $texte, $regs);


	$nb=1;
	$lastniveau=0;
	if ($istxt==0) {
		$texte="<a name='SommaireAutomatique'></a>";
	for($j=0;$j<count($regs[2]);$j++)
	{
		$niveau=substr($regs[1][$j], 1, 1);
		if ($niveau=='{') {$niveau=1;}
		if ($niveau==$lastniveau) {
			$texte.="</li>\n";
		}
		if ($niveau>$lastniveau) {
			$texte.="<ul>";
			$lastniveau=$niveau;
		}
		if ($niveau<$lastniveau) {
			$texte.="</li>\n";
			for($ulli=$niveau;$ulli<$lastniveau;$ulli++) {
				$texte.="</ul></li>\n";
			}
			$lastniveau=$niveau;
		}

    		$texte.="<li><a href=\"#sommaire_".$nb."\">".$regs[2][$j]."</a>";
		$nb++;
    }
	for($j=0;$j<$niveau;$j++) {
		$texte.="</li></ul>\n";
	}
	} else {
		$texte="";
		for($j=0;$j<count($regs[2]);$j++)
		{
			$niveau=substr($regs[1][$j], 1, 1);
			if ($niveau=='{') { $puce="\n- ";}
			if ($niveau==2) { $puce=" · ";}
			if ($niveau==3) { $puce="  × ";}
			if ($niveau==4) { $puce="   ° ";}
			if ($niveau==5) { $puce="    ¤ ";}
			$texte.=$puce.$regs[2][$j]."\n";
		}

	}
	return $texte;
}

function sommaire_ancre($texte)
{
	$texte = preg_replace("|(<h[23456]>)(.*)(<\/h[23456]>)|U","<p class='retoursommaire'><a href='#SommaireAutomatique'>Retour Sommaire</a></p><a name=\"sommaire_#NB_TITRE_DE_MON_ARTICLE#\"></a>$1$2$3", $texte);

	$array = explode("#NB_TITRE_DE_MON_ARTICLE#" , $texte);
	$res =count($array);
	$i =1;
	$texte=$array[0];
	while($i<$res)
	{
		$texte.=$i.$array[$i];
		$i++;
	}
	$texte.="<p class='retoursommaire'><a href='#SommaireAutomatique'>Retour Sommaire</a></p>";
	return $texte;
}
//Fin filtre sommaire de l'article

function PyratprepareNLtexte($texte) {
	// Remplace tous les liens
	while (eregi("<a href=['\"]([^'\">]+)['\"][^>]*>([^<]+)</a>", $texte, $regs)) {
		$cleanReg1 = ereg_replace("\\?", "\?", $regs[1]);
		$cleanReg1 = ereg_replace("\\+", "\+", $cleanReg1);
		$cleanReg2 = ereg_replace("\\?", "\?", $regs[2]);
		$cleanReg2 = ereg_replace("\\+", "\+", $cleanReg2);
		if ($regs[1] == $regs[2]) {
		    $texte = eregi_replace("<a href=['\"]".$cleanReg1."['\"][^>]*>".$cleanReg1."</a>", $regs[1], $texte);
		} else {
		    if ($regs[1] == str_replace("&nbsp;?","?",$regs[2])) {
			    $texte = eregi_replace("<a href=['\"]".$cleanReg1."['\"][^>]*>".$cleanReg2."</a>", $regs[1], $texte);
		    } else {
			    $texte = eregi_replace("<a href=['\"]".$cleanReg1."['\"][^>]*>".$cleanReg2."</a>", str_replace("&nbsp;?","?",$regs[2])." (".$regs[1].")", $texte);
		    }
		}
	}
	$texte = preg_replace("|(<h[2]>)(.*)(<\/h[2]>)|U","<br /><br />----------------------------------------------------------------------<br />$1$2$3<br />----------------------------------------------------------------------<br />", $texte);
	$texte = preg_replace("|(<h[3456]>)(.*)(<\/h[3456]>)|U","<br />···· $1$2$3 ····", $texte);
	$texte = ereg_replace ('<li[^>]>', "\n".'-', $texte);
	$texte = ereg_replace ('&#8217;', '\'', $texte);
	$texte = ereg_replace ('&#171;', '"', $texte);
	$texte = ereg_replace ('&#187;', '"', $texte);
	$texte = ereg_replace ('&amp;', '&', $texte);
	$texte = textebrut($texte);
	$texte = wordwrap($texte, 70, "\n");
	return $texte;
}

function nettoyer_marqueur($texte) {
	include_spip('inc/charsets');
	$texte=translitteration($texte);
	// Enlève la conversion caractères spéciaux HTML
	$trans_tbl = get_html_translation_table (HTML_ENTITIES);
	$trans_tbl = array_flip ($trans_tbl);
	$texte=strtr ($texte, $trans_tbl);
	$accents =
			/* A */ chr(192).chr(193).chr(194).chr(195).chr(196).chr(197).
			/* a */ chr(224).chr(225).chr(226).chr(227).chr(228).chr(229).
			/* O */ chr(210).chr(211).chr(212).chr(213).chr(214).chr(216).
			/* o */ chr(242).chr(243).chr(244).chr(245).chr(246).chr(248).
			/* E */ chr(200).chr(201).chr(202).chr(203).
			/* e */ chr(232).chr(233).chr(234).chr(235).
			/* Cc */ chr(199).chr(231).
			/* I */ chr(204).chr(205).chr(206).chr(207).
			/* i */ chr(236).chr(237).chr(238).chr(239).
			/* U */ chr(217).chr(218).chr(219).chr(220).
			/* u */ chr(249).chr(250).chr(251).chr(252).
			/* yNn */ chr(255).chr(209).chr(241);
	$texte = ereg_replace("<[^<]*>", "", $texte);
	$texte = ereg_replace("[^A-Za-z0-9]", "_", strtr($texte,$accents,"AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn"));
	$texte = ereg_replace(" ", "_", $texte);
	$texte = ereg_replace(" ", "_", $texte);
	$texte = ereg_replace("_+", "_", $texte);
	return strtolower($texte);
}

function strip_img($x) {
     eregi("<img[^>]* src=['\"]([^'\"]+)['\"]", $x, $r);
     return $r[1];
}

// tronque un liens à $limit caractères
function couper_liens($texte, $limit) {
  if (strlen($texte) <= $limit){
 return $texte;}
else return substr($texte, 0, $limit) . " (...)";
}

/* à appliquer au #TEXTE de forum */
function anti_glouton($texte) {
  $regexp = '|<a href=["\x27]([^"\x27]+)["\x27][^>]*>([^<]+)</a>|i';
  $replace = "\${2} [\${1}]";
  $texte = preg_replace($regexp, $replace, $texte);
  return $texte;
}

function jp_replace($texte,$search,$replace) {
	return trim(str_replace($search,$replace,$texte));
}

function jp_NewLine2str($texte) {
	return str_replace('"','\"',str_replace("\r",'',str_replace("\n",'\n',$texte)));
}

function jp_calcul_addition($texte,$valeur) {
	return $texte + $valeur;
}

function DateAdd($d=null, $v, $f="Y-m-d"){
  return date($f,strtotime($v." days",strtotime($d)));
}

function balise_SPIP_VERSION($p) {
	global $spip_version_affichee;
	$p->code = "'$spip_version_affichee'";
	$p->interdire_scripts = false;
	return $p;
}

/* -------------

Ces 2 balises permettent d'afficher dans une page :
 - le(s) saint(s) du jour
 - l'Evangile du jour

Le tout remis en forme correctement.

---------------*/
function balise_SAINT_DU_JOUR($p) {
	$saint_du_jour = str_replace('+','&dagger;',str_replace("\r",'',str_replace("\n",'',str_replace('&nbsp;',' ',supprimer_tags(recuperer_page('http://www.levangileauquotidien.org/ind-saints-d.php?language=FR', true))))));
	if ($p->param[0][1][0]->texte == -1) {
		if (($posvirg = strpos($saint_du_jour, ',')) > 0) $saint_du_jour = substr($saint_du_jour, 0, $posvirg);
	}
	$saint_du_jour = str_replace('ème','<sup>e</sup>', $saint_du_jour);
	$p->code = "'$saint_du_jour'";
	return $p;
}

function balise_EVANGILE_DU_JOUR($p) {
	$evangile_du_jour = str_replace("'", '&#8217;', recuperer_page('http://www.levangileauquotidien.org/ind-gospel-d.php?language=FR', true));
	$evangile_du_jour = ereg_replace("<script.*</script>", '', $evangile_du_jour);
	$evangile_du_jour = ereg_replace("<center.*</form>", '', $evangile_du_jour);
	$evangile_du_jour = ereg_replace("<center.*</center>", '', $evangile_du_jour);
	$evangile_du_jour = ereg_replace("<p[^>]*>", '', $evangile_du_jour);
	$evangile_du_jour = ereg_replace("<font[^>]*>", '', trim($evangile_du_jour));
	$evangile_du_jour = str_replace("</font>", '', $evangile_du_jour);
	$evangile_du_jour = str_replace("<br>", '<br />', $evangile_du_jour);
	$evangile_du_jour = str_replace("</a><br /><br />", '</dt><dd><p>', '<dl><dt>'.$evangile_du_jour);
	$evangile_du_jour = str_replace("<br /><br />E", '</p></dd><dd class="aelf">E', $evangile_du_jour);
	$evangile_du_jour = str_replace("<br /><br />", '</dd></dl>', $evangile_du_jour);
	$evangile_du_jour = str_replace("<br />", '</p><p>', $evangile_du_jour);
	$p->code = "'$evangile_du_jour'";
	return $p;
}
?>