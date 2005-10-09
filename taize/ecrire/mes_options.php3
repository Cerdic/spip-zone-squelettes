<?php

$auto_compress = false;
$quota_cache = 40;

function calcul_CURDATE() {
   return date('Y-m-d', time());
}

function balise_CURDATE($p) {
   $p->code = "calcul_CURDATE()";
   $p->statut = 'html';
   return $p;
}

// useful command for testing...
// error_log($..., 3, "D:\Dump\MyFile.txt");

define('_TIDY_COMMAND', 'tidy');
// define('_TIDY_COMMAND', '/home/taizefr/bin/tidy');
// define('_TIDY_OPTIONS', '--output-html true');
// $xhtml =true;



// Extra colours for the private area
global $couleurs_spip;
$couleurs_spip[10] = array (
		"couleur_foncee" => "#508A72",
		"couleur_claire" => "#A5DFC7",
		"couleur_lien" => "#657701",
		"couleur_lien_off" => "#A6C113"
);
$couleurs_spip[11] = array (
		"couleur_foncee" => "#949064",
		"couleur_claire" => "#DFDBA5",
		"couleur_lien" => "#657701",
		"couleur_lien_off" => "#A6C113"
);
$couleurs_spip[12] = array (
		"couleur_foncee" => "#6770AC",
		"couleur_claire" => "#F8D768",
		"couleur_lien" => "#363F7A",
		"couleur_lien_off" => "#747DB4"
);

function avant_propre($texte) {
// Escape ampersands whether in A&PT or free-standing;
// $texte = preg_replace("/\s\&\s/"," &amp; ",$texte);
// $texte = preg_replace("/A\&PT/","A&amp;PT",$texte);

$texte = preg_replace("/([{|A|\s])&([}|P|\s])/","$1&amp;$2",$texte);

// Extra levels of subtitles (part I)
	$chercher_raccourcis = array(
		/*  1 */	"/\{0\{/",
		/*  2 */	"/\}0\}/",
		/*  3 */	"/\{1\{/",
		/*  4 */	"/\}1\}/",
		/*  5 */	"/\{2\{/",
		/*  6 */	"/\}2\}/",
		/*  7 */	"/\{3\{/",
		/*  8 */	"/\}3\}/");

	$remplacer_raccourcis = array(
		/*  1 */	"<@@SPIP_debut_intertitre_0@@>",
		/*  2 */	"<@@SPIP_fin_intertitre_0@@>",
		/* 3 */	"<@@SPIP_debut_intertitre_1@@>",
		/* 4 */	"<@@SPIP_fin_intertitre_1@@>",
//		/*  3 */	"<@@SPIP_debut_intertitre@@>",
//		/*  4 */	"<@@SPIP_fin_intertitre@@>",
		/*  5 */	"<@@SPIP_debut_intertitre_2@@>",
		/*  6 */	"<@@SPIP_fin_intertitre_2@@>",
		/*  7 */	"<@@SPIP_debut_intertitre_3@@>",
		/*  8 */	"<@@SPIP_fin_intertitre_3@@>");

return preg_replace($chercher_raccourcis, $remplacer_raccourcis, $texte);
}

function apres_propre($texte) {
// Antispam
// variables qui peuvent être modifiées à volonté mais si $arobase est modifiée
// if faut aussi modifier la fonction JavaScript "dolink"
$arobase = '..&aring;t..';  // tip visible OnMouseOver
$affichage = '[Email]';  // affichage par défaut d'un lien mail sans texte
// *** pour version imprimable
if ($_GET['printver']) {
	$masque = '<img src="IMG/commat.gif" alt="" width="13" height="13" align="middle" />';
	preg_match_all('/<a[\\s]{1}[^>]*href=["\']?([^>\\s"\']+)["\']?[^>]*>([^<]*)<\\/a>/is', $texte, $found);
	$total = count($found[0]);
	for($i=0; $i < $total; $i++) {
		if (preg_match("/^mailto:(.*)/",$found[1][$i],$link)) {
		// *** alors il s'agit d'un lien email
			$href = $link[1];
		} else {
		// *** c'est une adresse web
			$href = $found[1][$i];
		}
		$linktext = $found[2][$i];
		// *** si le texte du lien contient déjà l'adresse ou s'il s'agit d'une ancre locale
		// *** alors on peut jeter l'adresse.
		if ($linktext == $href || strpos($href,"#") === 0) { $href = "";}
		// *** sinon l'ajouter entre crochets.
		if ($href > "") { $href = "[".$href."]";}
		$linktext = trim(str_replace("@", $masque,$linktext." ".$href));
	$texte = str_replace($found[0][$i], $linktext, $texte);
	}
  } else {
  // *** pour la page à l'écran
	// *** agir seulement sur les emails
	preg_match_all("/[\"\']mailto:([^@\"']*)@([^\"']*)[\"\']/",$texte,$found);
	$total = count($found[0]);
	for($i=0; $i < $total; $i++) {
		// *** extraire les deux parties de l' adresse (avant et après l'arobase)
		// *** et réécrire le lien
		$part1 = $found[1][$i];
		$part2 = $found[2][$i];
		$newstr ='"#" title="' . $part1 . $arobase . $part2 . '" onClick="location.href = dolink(this.title); return false;"';
		$texte = str_replace($found[0][$i], $newstr, $texte);
	}
	// *** si le texte d'un lien contient une adresse email, le remplacer par le texte choisi
	preg_match_all("/>\s*\S+@{1}\S+\s*<\/a/",$texte,$found);
	$total = count($found[0]);
	for($i=0; $i < $total; $i++) {
		$texte = str_replace($found[0][$i],">$affichage</a",$texte);
	}
 }

// *****
// Extra levels of subtitles (part II)
	# Intertitre -1 (intertitre de niveau supérieur à l'intertitre usuel de spip)
	global $debut_intertitre_0, $fin_intertitre_0;
	tester_variable('debut_intertitre_0', "\n<h2 class=\"spip\">");
	tester_variable('fin_intertitre_0', "</h2>");
	$texte = ereg_replace('(<p class="spip">)?[[:space:]]*<@@SPIP_debut_intertitre_0@@>', $debut_intertitre_0, $texte);
	$texte = ereg_replace('<@@SPIP_fin_intertitre_0@@>[[:space:]]*(</p>)?', $fin_intertitre_0, $texte);

	# Intertitre de premier niveau
	global $debut_intertitre_1, $fin_intertitre_1;
	if($debut_intertitre) {
		$debut_intertitre_1 = $debut_intertitre;
	} else {
		tester_variable('debut_intertitre_1', "\n<h3 class=\"spip\">");
		if($fin_intertitre) {
			$fin_intertitre_1 = $fin_intertitre;
		} else {
			tester_variable('fin_intertitre_1', "</h3>");
			$texte = ereg_replace('(<p class="spip">)?[[:space:]]*<@@SPIP_debut_intertitre_1@@>', $debut_intertitre_1, $texte);
			$texte = ereg_replace('<@@SPIP_fin_intertitre_1@@>[[:space:]]*(</p>)?', $fin_intertitre_1, $texte);
		}
	}

	# Intertitre de deuxième niveau
	global $debut_intertitre_2, $fin_intertitre_2;
	tester_variable('debut_intertitre_2', "\n<h4 class=\"spip\">");
	tester_variable('fin_intertitre_2', "</h4>");
	$texte = ereg_replace('(<p class="spip">)?[[:space:]]*<@@SPIP_debut_intertitre_2@@>', $debut_intertitre_2, $texte);
	$texte = ereg_replace('<@@SPIP_fin_intertitre_2@@>[[:space:]]*(</p>)?', $fin_intertitre_2, $texte);

	# Intertitre de troisième niveau
	global $debut_intertitre_3, $fin_intertitre_3;
	tester_variable('debut_intertitre_3', "\n<h5 class=\"spip\">");
	tester_variable('fin_intertitre_3', "</h5>");
	$texte = ereg_replace('(<p class="spip">)?[[:space:]]*<@@SPIP_debut_intertitre_3@@>', $debut_intertitre_3, $texte);
	$texte = ereg_replace('<@@SPIP_fin_intertitre_3@@>[[:space:]]*(</p>)?', $fin_intertitre_3, $texte);

// Take away paras around photo divs
$texte = preg_replace("/<p\sclass=\"spip\">\s*(<div\sclass=\"photo\">.*<\/div>)\s*<\/p>/", "$1", $texte);
// Take away any empty paragraphs
$texte = preg_replace("/<p\sclass=\"spip\">\s*<\/p>/", "", $texte);

// *****

return $texte;
}
?>