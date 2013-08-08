<?php

/**
 * Plugin Escal
 * Licence GNU/GPL
 */

if (!defined('_ECRIRE_INC_VERSION')) return;

// =======================================================================================================================================
// Paramétrage à l'installation d'Escal
// Merci à Arnaud Bérard pour son aide précieuse
// =======================================================================================================================================

/**
 * escal_configuration()
 * teste et configure certaines options de spip pour escal
*/

function escal_configuration(){
    include_spip('inc/config');
    
    // active l'utilsation des mots clefs
    $articles_mots = lire_config('articles_mots');
    if($articles_mots == 'non')
        ecrire_meta('articles_mots','oui');
  
}


/*
 * function install_groupe_mot
 * installe le groupe de mots techniques et ses mots clefs
 */
function install_groupe_mots() {
    // Création du groupe de mot-clef : affichage
    $groupe_affichage = sql_insertq('spip_groupes_mots',array(
      'titre'=>'affichage',
      'descriptif'=>'Groupe de mots-cl&eacute;s techniques utilis&eacute;s dans Escal',
      'tables_liees'=>'articles,rubriques,syndic',
      'minirezo'=>'oui',
      'comite'=>'oui'
      ));
    
    // Création des mots-clefs -----------

    // Mot : pas_au_menu
    $pas_au_menu = objet_inserer('mot',$groupe_affichage);
    objet_modifier('mot',$pas_au_menu,array(
        'titre'=>'pas-au-menu',
        'descriptif'=>'pour ne pas afficher une rubrique ou un article dans le menu horizontal'
        )
    );
    
    // Mot : pas_au_menu
    $pas_au_menu_vertical = objet_inserer('mot',$groupe_affichage);
    objet_modifier('mot',$pas_au_menu_vertical,array(
        'titre'=>'pas-au-menu-vertical',
        'descriptif'=>'pour ne pas afficher une rubrique ou un article dans les menus verticaux'
        )
    );
    
    // Mot : chrono
    $chrono = objet_inserer('mot',$groupe_affichage);
    objet_modifier('mot',$chrono,array(
        'titre'=>'chrono',
        'descriptif'=>'pour afficher les articles d&rsquo;une rubrique dans les menus en ordre ant&eacute;chronologique, comportement non transmis aux rubriques-filles'
        )
    );
    
    // Mot : pas-a-la-une
    $pas_a_la_une = objet_inserer('mot',$groupe_affichage);
    objet_modifier('mot',$pas_a_la_une,array(
        'titre'=>'pas-a-la-une',
        'descriptif'=>'pour ne pas afficher une rubrique (et ses articles) ou des articles dans le bloc "les derniers articles ..." de la page d&rsquo;accueil'
        )
    );
    
    // Mot : pas-au-plan
    $pas_au_plan = objet_inserer('mot',$groupe_affichage);
    objet_modifier('mot',$pas_au_plan,array(
        'titre'=>'pas-au-plan',
        'descriptif'=>'pour ne pas afficher une rubrique (et ses articles) ou des articles dans le bloc "Plan du site" de la page d&rsquo;accueil'
        )
    );
    
    // Mot : edito
    $edito = objet_inserer('mot',$groupe_affichage);
    objet_modifier('mot',$edito,array(
        'titre'=>'edito',
        'descriptif'=>'pour choisir l&rsquo;article qui sera affich&eacute; dans le bloc "Edito" (noisette inc-edito)'
        )
    );
    
    // Mot : accueil
    $accueil = objet_inserer('mot',$groupe_affichage);
    objet_modifier('mot',$accueil,array(
        'titre'=>'accueil',
        'descriptif'=>'pour choisir l&rsquo;article affich&eacute; en onglet d&rsquo;accueil (noisette inc-accueil)'
        )
    );
    
    // Mot : acces-direct
    $acces_direct = objet_inserer('mot',$groupe_affichage);
    objet_modifier('mot',$acces_direct,array(
        'titre'=>'acces-direct',
        'descriptif'=>'pour choisir l&rsquo;article qui sera affich&eacute; dans le bloc "Acc&egrave;s direct" (noisette inc-acces_direct)'
        )
    );
    
    // Mot : annonce
    $annonce = objet_inserer('mot',$groupe_affichage);
    objet_modifier('mot',$annonce,array(
        'titre'=>'annonce',
        'descriptif'=>'pour choisir l&rsquo;article dont le texte sera affich&eacute; dans le bloc "Annonce" de la page d&rsquo;accueil (noisette inc-annonce)'
        )
    );
    
    // Mot : annonce-defilant
    $annonce_defilant = objet_inserer('mot',$groupe_affichage);
    objet_modifier('mot',$annonce_defilant,array(
        'titre'=>'annonce-defilant',
        'descriptif'=>'pour choisir les articles dont le texte sera affich&eacute; dans le bloc "Annonces d&eacute;filantes" de la page d&rsquo;accueil (noisette inc-annonce_defilant)'
        )
    );
    
    // Mot : agenda
    $agenda = objet_inserer('mot',$groupe_affichage);
    objet_modifier('mot',$agenda,array(
        'titre'=>'agenda',
        'descriptif'=>'pour choisir les articles ou la ou les rubriques dont les articles seront affich&eacute;s dans l&rsquo;agenda'
        )
    );
    
    // Mot : actus
    $actus = objet_inserer('mot',$groupe_affichage);
    objet_modifier('mot',$actus,array(
        'titre'=>'actus',
        'descriptif'=>'pour choisir les articles qui seront affich&eacute;s dans le bloc "Actus" (noisette inc-actus)'
        )
    );
    
    // Mot : photo-une
    $photo_une = objet_inserer('mot',$groupe_affichage);
    objet_modifier('mot',$photo_une,array(
        'titre'=>'photo-une',
        'descriptif'=>'pour choisir les articles dont les images seront affich&eacute;es dans le bloc "Quelques images au hasard" (noisette inc-photos)'
        )
    );
    
    // Mot : video-une
    $video_une = objet_inserer('mot',$groupe_affichage);
    objet_modifier('mot',$video_une,array(
        'titre'=>'video-une',
        'descriptif'=>'pour choisir les articles dont les vid&eacute;os seront affich&eacute;es dans le bloc "Vid&eacute;o" (noisette inc-video_accueil)'
        )
    );
    
    // Mot : favori
    $favori = objet_inserer('mot',$groupe_affichage);
    objet_modifier('mot',$favori,array(
        'titre'=>'favori',
        'descriptif'=>'pour choisir les sites dont les vignettes seront affich&eacute;es dans le bloc "Sites favoris" (noisette inc-sites_favoris.html)'
        )
    );
    
    // Mot : site-exclu
    $site_exclu = objet_inserer('mot',$groupe_affichage);
    objet_modifier('mot',$site_exclu,array(
        'titre'=>'site-exclu',
        'descriptif'=>'pour exclure des sites dans le bloc "Sur le web" (noisette inc-sites.html)'
        )
    );
    
    // Mot : forum
    $forum = objet_inserer('mot',$groupe_affichage);
    objet_modifier('mot',$forum,array(
        'titre'=>'forum',
        'descriptif'=>'pour choisir le secteur qui sera utilis&eacute; pour le forum du site'
        )
    );
    
    // Mot : annuaire
    $annuaire = objet_inserer('mot',$groupe_affichage);
    objet_modifier('mot',$annuaire,array(
        'titre'=>'annuaire',
        'descriptif'=>'pour choisir l&rsquo;article qui sera utilis&eacute; par la page annuaire.html'
        )
    );
    
    // Mot : RubriqueOnglet
    $RubriqueOnglet = objet_inserer('mot',$groupe_affichage);
    objet_modifier('mot',$RubriqueOnglet,array(
        'titre'=>'RubriqueOnglet',
        'descriptif'=>'pour choisir la rubrique qui sera affich&eacute;e dans les onglets en page d&rsquo;accueil'
        )
    );
    
    // Mot : citations
    $citations = objet_inserer('mot',$groupe_affichage);
    objet_modifier('mot',$citations,array(
        'titre'=>'citations',
        'descriptif'=>'pour choisir l&rsquo;article qui servira de r&eacute;servoir pour les citations dans le pied de page'
        )
    );
    
    $result = array(
        'affichage'=>$groupe_affichage, 
        'affichage_mots'=> array(
            'pas_au_menu'=>$pas_au_menu,
            'pas_au_menu_vertical'=>$pas_au_menu_vertical,
            'chrono'=>$chrono,
            'pas_a_la_une'=>$pas_a_la_une,
            'pas_au_plan'=>$pas_au_plan,
            'edito'=>$edito,
            'accueil'=>$accueil,
            'acces_direct'=>$acces_direct,
            'annonce'=>$annonce,
            'annonce_defilant'=>$annonce_defilant,
            'agenda'=>$agenda,
            'actus'=>$actus,
            'photo_une'=>$photo_une,
            'video_une'=>$video_une,
            'favori'=>$favori,
            'site_exclu'=>$site_exclu,
            'forum'=>$forum,
            'annuaire'=>$annuaire,
            'RubriqueOnglet'=>$RubriqueOnglet,
            'citations'=>$citations
            )
    );
    
    ecrire_config('escal/mots_techniques',$result);
    
    return $result;
}



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