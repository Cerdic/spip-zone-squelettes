<?php


// =======================================================================================================================================
   // pour gerer les classes des differents liens dans les articles
   // Un grand merci a l'auteur : bobof
// =======================================================================================================================================
if (!function_exists('inc_lien')){
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
}
// balises issues da la contrib  "Balises de comptage" de Franck
// http://www.spip-contrib.net/Balises-de-comptage 
// =======================================================================================================================================
// balise #TOTAL_VISITES
// =======================================================================================================================================
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
// =======================================================================================================================================
// balise #NBPAGES_VISITEES
// =======================================================================================================================================
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

// =======================================================================================================================================
// balise #MOY_VISITES
// =======================================================================================================================================
function moyenne_visites_par_jour() {
// calcul de la moyenne de visites
// Période d'analyse couverte (nb de jours avant aujourd'hui)
$periode = lire_config('escal/config/periodevisites', '365') ;

// Sur tout le site, nombre de visites pendant la période
$query="SELECT UNIX_TIMESTAMP(date) AS date_unix, visites FROM spip_visites ".
		"WHERE 1 AND date > DATE_SUB(NOW(),INTERVAL $periode DAY) ORDER BY date";
	$result=spip_query($query);
        $i=0 ;
        $total_absolu=0;
	while ($row = spip_fetch_array($result)) {
                $total_absolu = $total_absolu + $row['visites'];
                $i++;
	}
// Nombre moyen de visites par jour sur la période
        $moyenne =  round($total_absolu / $periode );
        return $moyenne;
}
function balise_MOY_VISITES($p) {
	$p->code = "moyenne_visites_par_jour()";
	$p->statut = 'php';
	return $p;
}
// =======================================================================================================================================
// fonction pour l'affichage du nombre de visiteurs connectes
// =======================================================================================================================================
// issue du plugin "Nombre de visiteurs connectées"
// http://www.spip-contrib.net/Nombres-de-visiteurs-connectes
// corrections par Vincent de la liste Spip
function escal_visiteurs_connectes_compter(){
         return count(preg_files(_DIR_TMP.'visites/','.'));
     }

// =======================================================================================================================================
// Balise : #JOUR_MAX_VISITES & #VAL_MAX_VISITES
// =======================================================================================================================================

  function generer_jour_val_max_visites($arg) {
	$qv = spip_query("SELECT MAX(visites) as maxvi FROM spip_visites");
	$rv = spip_fetch_array($qv);
	$valmaxi = $rv['maxvi'];

	if($arg=="date") {
		$qd = spip_query("SELECT date FROM spip_visites WHERE visites = $valmaxi");
		$rd = spip_fetch_array($qd);
		$jourmaxi = $rd['date'];
	}
	if($arg=="date") { $a = $jourmaxi; }
	if($arg=="val") { $a = $valmaxi; }
	return $a;
}
function balise_JOUR_MAX_VISITES($p) {
	$arg="date";
	$p->code = "generer_jour_val_max_visites($arg)";
	$p->interdire_scripts = false;
	return $p;
}
function balise_VAL_MAX_VISITES($p) {
	$arg="val";
	$p->code = "generer_jour_val_max_visites($arg)";
	$p->interdire_scripts = false;
	return $p;
}

// =======================================================================================================================================
// fonction pour les citations du pied de page
// =======================================================================================================================================

function citations($txt){
$BDDArray = $txt;// Lecture de l'article
$BDDArray = explode('<p>', $BDDArray); // couper à la  rencontre un p
$BDDArray = array_map('rtrim', $BDDArray); // Suppression des fins de lignes de chaque élément
$BDDArray = array_filter($BDDArray); // Suppression de TOUTES les entrées vides

$citation = $BDDArray[array_rand($BDDArray)]; // une phrase au hasard dans le tableau
if(strlen($citation)<200) //on ne veut pas dépasser 200 caractères
return strip_tags($citation); //on vire les tags html
else citations($txt);
}

// =======================================================================================================================================
// Ajout de  nofollow sur les liens (pas mal à utiliser  sur les commentaires pour éviter le spam)
// =======================================================================================================================================

function nofollow($texte){
   $texte=str_replace("<a href","<a rel='nofollow' href",$texte);
   return $texte;
}

// =======================================================================================================================================
// paramètres pour le plugin diapo
// =======================================================================================================================================

//nombre de vignettes par page
$GLOBALS['diapo_vignettes']=15;

//largeur et hauteur maxi des vignettes :
$GLOBALS['diapo_vignette']=60;

//largeur maxi de la grande image avec vignettes en haut :
$GLOBALS['diapo_grand']=400;

//largeur maxi de la grande image avec vignettes sur les côtés:
$GLOBALS['diapo_petit']=300;
//hauteur maxi de la grande image avec vignettes sur les côtés :
$GLOBALS['diapo_petit_h']=300;

//diaporama : temps de pause en millisecondes :
$GLOBALS['diapo_temps']=3000;

?>