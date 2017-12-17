<?php
// =======================================================================================================================================
// Balise : #VERSION_SQUELETTE
// =======================================================================================================================================
// Auteur: SpipFactory
// Fonction : affiche la version utilisee du squelette Escal variable globale $version_squelette
// =======================================================================================================================================
//
function balise_VERSION_SQUELETTE($p) {
	$p->code = 'calcul_version_squelette()';
	$p->interdire_scripts = false;
	return $p;
}

function calcul_version_squelette() {

	$version = NULL;

	if (lire_fichier(_DIR_PLUGIN_ESCAL.'/plugin.xml', $contenu)
	&& preg_match('/<version>(.*?)<\/version>/', $contenu, $match))
		$version .= trim($match[1]);

	$revision = version_svn_courante(_DIR_PLUGIN_ESCAL);
	if ($revision > 0)
		$version .= ' ['.strval($revision).']';
	else if ($revision < 0)
		$version .= ' ['.strval(abs($revision)).'&nbsp;<strong>svn</strong>]';

	return $version;
}

// =======================================================================================================================================
   // pour gerer les classes des differents liens dans les articles
   // Un grand merci a l'auteur : bobof

function inc_lien($lien, $texte='', $class='', $title='', $hlang='', $rel='', $connect='')
{
	$mode = ($texte AND $class) ? 'url' : 'tout';
	$lien = calculer_url($lien, $texte, $mode, $connect);
	if ($mode === 'tout') {
		$texte = $lien['titre'];
		if (!$class AND isset($lien['class'])) $class = $lien['class'];
		$lang = isset($lien['lang']) ?$lien['lang'] : '';
		$lien = $lien['url'];
	}
	if (substr($lien,0,1) == '#')  # spip_ancre pour liens de type ->#ancre
		$class = 'spip_ancre';
	elseif (preg_match('/^\s*spip.php\?page\=/', $lien)) # spip_in pour liens de type ->rubXX, ->artXX, ->breXX et ->spip.php?page=XYZ
		$class = "spip_in";
	elseif (preg_match('/^\s*mailto:/',$lien)) # spip_mail pour liens de type ->mailto:
		$class = "spip_mail";
	elseif (preg_match(',s*('._SITE.'),Ui', $lien)) # spip_site pour liens de type ->http://mon_site.tld/repertoire/fichier.html
		$class = "spip_site";
	elseif (preg_match(',('._DOMAINE_SITE.'),Ui', $lien)) # spip_dom pour liens de type ->http://www.domaine.tld ou ->http://sous-domaine.domaine.tld
		$class = "spip_dom";
	elseif (preg_match('/^<html>/',$lien)) # spip_url, spip_out pour les autres cas de figures
		$class = "spip_url spip_out";
	elseif (!$class) $class = "spip_out"; # spip_out pour les liens externes
return inc_lien_dist($lien, $texte, $class, $titre, $hlang, $rel, $connect);
}

// balises issues da la contrib  "Balises de comptage" de Franck
// https://contrib.spip.net/Balises-de-comptage

// balise #TOTAL_VISITES
function vst_total_visites() {
	$query = "SELECT SUM(visites) AS total_abs FROM spip_visites";
	$result = spip_query($query);
	if ($row = spip_fetch_array($result))
		{ return $row['total_abs']; }
	else { return "0";}
}
function balise_TOTAL_VISITES($p) {
	$p->code = "vst_total_visites()";
	$p->statut = 'php';
	return $p;
}
// balise #NBPAGES_VISITEES
function vst_total_pages_visitees() {
	$query = "SELECT SUM(visites) AS nbPages FROM spip_visites_articles";
	$result = spip_query($query);
	if ($row = spip_fetch_array($result))
		{ return $row['nbPages']; }
	else { return "0";}
}
function balise_NBPAGES_VISITEES($p) {
	$p->code = "vst_total_pages_visitees()";
	$p->statut = 'php';
	return $p;
}

// fonction pour l'affichage du nombre de visiteurs connectes
// issue du plugin "Nombre de visiteurs connectées"
// https://contrib.spip.net/Nombres-de-visiteurs-connectes
// corrections par Vincent de la liste Spip
function escal_visiteurs_connectes_compter(){
         return count(preg_files(_DIR_TMP.'visites/','.'));
     }
     
// paramètres pour le plugin diapo

//nombre de vignettes par page
$GLOBALS['diapo_vignettes']=15;

//largeur de la grande image :
$GLOBALS['diapo_grand']=400;

//largeur maxi de la photo :
$GLOBALS['diapo_petit']=300;
//hauteur maxi de la photo :
$GLOBALS['diapo_petit_h']=300;

//largeur et hauteur maxi des vignettes :
$GLOBALS['diapo_vignette']=60;

//diaporama : temps de pause en millisecondes :
$GLOBALS['diapo_temps']=3000;

?>