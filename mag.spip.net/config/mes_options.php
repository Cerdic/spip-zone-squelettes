<?php

// Ce fichier ne sera execute qu'une fois
if (defined("_ECRIRE_INC_MES_OPTIONS")) return;
define("_ECRIRE_INC_MES_OPTIONS", "1");

define('_SVN_UPDATE_AUTEURS', '68'); 

// Dossier squelettes
$GLOBALS['dossier_squelettes'] = 'layout';

// Interdire l'affichage des vignettes dans les stats
$source_vignettes = '';

// Chargement des champs EXTRA
require_once("extra.php");

function avant_typo($texte) {
	$chercher_raccourcis = array(
		/* 3 */		"/<-->/",
		/* 4 */		"/-->/",
		/* 5 */		"/<--/");
	$remplacer_raccourcis = array(
		/* 3 */		"&harr;",
		/* 4 */		"&rarr;",
		/* 5 */		"&larr;");
	return preg_replace($chercher_raccourcis, $remplacer_raccourcis, $texte);
}

function avant_propre($texte) {

#	$texte =  ancres_intertitre($texte);

	$chercher_raccourcis = array(
		/* 1 */		"/\{0\{/",
		/* 2 */		"/\}0\}/",
		/* 3 */		"/\{1\{/",
		/* 4 */		"/\}1\}/",
		/* 5 */		"/\{2\{/",
		/* 6 */		"/\}2\}/",
		/* 7 */		"/\{3\{/",
		/* 8 */		"/\}3\}/",
		/* 9 */		"/\[\*/",
		/* 10 */	"/\*\]/");

	$remplacer_raccourcis = array(
		/* 1 */		"<@@SPIP_debut_intertitre_0@@>",
		/* 2 */		"<@@SPIP_fin_intertitre_0@@>",
		/* 3 */		"<@@SPIP_debut_intertitre@@>",
		/* 4 */		"<@@SPIP_fin_intertitre@@>",
		/* 5 */		"<@@SPIP_debut_intertitre_2@@>",
		/* 6 */		"<@@SPIP_fin_intertitre_2@@>",
		/* 7 */		"<@@SPIP_debut_intertitre_3@@>",
		/* 8 */		"<@@SPIP_fin_intertitre_3@@>",
		/* 9 */		"<span style=\"font-variant: small-caps\">",
		/* 10 */	"</span>");

	return preg_replace($chercher_raccourcis, $remplacer_raccourcis, $texte);

}

function apres_propre($texte) {

	# Intertitre -1 (intertitre de niveau supérieur à l'intertitre usuel de spip)
	global $debut_intertitre_0, $fin_intertitre_0;
	if(!$debut_intertitre_0) $debut_intertitre_0 = "<h2 class=\"spip\">";
	if(!$fin_intertitre_0) $fin_intertitre_0 = "</h2>";
	$texte = ereg_replace('(<p class="spip">)?[[:space:]]*<@@SPIP_debut_intertitre_0@@>', $debut_intertitre_0, $texte);
	$texte = ereg_replace('<@@SPIP_fin_intertitre_0@@>[[:space:]]*(</p>)?', $fin_intertitre_0, $texte);

	# Intertitre de deuxième niveau
	global $debut_intertitre_2, $fin_intertitre_2;
	if(!$debut_intertitre_2) $debut_intertitre_2 = "<h4 class=\"spip\">";
	if(!$fin_intertitre_2) $fin_intertitre_2 = "</h4>";
	$texte = ereg_replace('(<p class="spip">)?[[:space:]]*<@@SPIP_debut_intertitre_2@@>', $debut_intertitre_2, $texte);
	$texte = ereg_replace('<@@SPIP_fin_intertitre_2@@>[[:space:]]*(</p>)?', $fin_intertitre_2, $texte);

	# Intertitre de troisième niveau
	global $debut_intertitre_3, $fin_intertitre_3;
	if(!$debut_intertitre_3) $debut_intertitre_3 = "<h5 class=\"spip\">";
	if(!$fin_intertitre_3) $fin_intertitre_3 = "</h5>";
	$texte = ereg_replace('(<p class="spip">)?[[:space:]]*<@@SPIP_debut_intertitre_3@@>', $debut_intertitre_3, $texte);
	$texte = ereg_replace('<@@SPIP_fin_intertitre_3@@>[[:space:]]*(</p>)?', $fin_intertitre_3, $texte);

	global $activer_antispam;
	if($activer_antispam && function_exists('anti_spam'))
		return anti_spam($texte);
	else
		return $texte;
}


#
# Fonctions anti-spam
#
function crypter ($texte) {
	include_ecrire ("inc_acces.php3");
	$masque = creer_pass_aleatoire(3);
	$texte = ereg_replace("@", " (at) ", $texte);
	$s="";
	for ($i=0;$i<strlen($texte);$i++)
		$s .= "&#".ord($texte{$i}).";";
	return $s;
}

function anti_spam ($texte) {
	return preg_replace_callback('|(mailto:)?[-\w.]{2,}@[-\w.]{2,}|',
		create_function('$match', 'return crypter($match[0]);'),
		$texte);
}

/*
function ancres_intertitre($texte) {
	$regexp = "/{{{(.*?)}}}/";
	$texte = preg_replace_callback($regexp,'remplace_intertitre',$texte);
#	$texte = avant_propre_ancres($texte);
		//on est obligé de le refaire ici, parce que dans inc_texte, c'est fait avant l'apel à avant_propre, bizarre.
	return $texte;
}

function remplace_intertitre ($matches) {
	static $cId = 0;
	$cId++;
	$url = translitteration(corriger_caracteres(
supprimer_tags(supprimer_numero(extraire_multi($matches[1])))
));
$url = @preg_replace(',[[:punct:][:space:]]+,u', ' ', $url);
// S'il reste des caracteres non latins, utiliser l'id a la place
if (preg_match(",[^a-zA-Z0-9 ],", $url)) {
$url = "ancre$cId";
}
else {
$mots = explode(' ', $url);
$url = '';
foreach ($mots as $mot) {
if (!$mot) continue;
$url2 = $url.'-'.$mot;
if (strlen($url2) > 35) {
break;
}
$url = $url2;
}
$url = substr($url, 1);
//echo "$url<br>";
if (strlen($url) < 2) $url = "ancre$cId";
}
return '{{{ ['.$url.'<-] '.$matches[1].' }}}';
}
*/


?>
