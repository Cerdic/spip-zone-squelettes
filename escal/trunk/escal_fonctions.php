<?php
/**
 * Plugin Escal
 * Licence GNU/GPL
 */

if (!defined('_ECRIRE_INC_VERSION')) return;

if (!defined('_ECRIRE_INC_VERSION')) return;

// ============================
// Nuage de tags
// ============================
function coef($texte, $max, $nbrMax= 2, $minFont= 0.8) {
	return ($texte/$max*$nbrMax + $minFont);
}

function max_mot($texte, $max) {
	return max($texte, $max);
}
 
// =======================================================================================================================================
// Paramétrage à l'installation d'Escal
// Merci à Arnaud Bérard pour son aide précieuse
// =======================================================================================================================================

/**
 * escal_configuration()
 * teste et configure certaines options de spip pour escal
 * penser à incrementer la valeur de schema dans paquet.xml et celle de $maj dans escal_administrations.php en cas de mise à jour des mots cles
*/


function escal_configuration(){
    include_spip('inc/config');

    // active l'utilisation des mots clefs
    $articles_mots = lire_config('articles_mots');
    if($articles_mots == 'non')
        ecrire_meta('articles_mots','oui');

    // activation du descriptif sur les rubriques et article
    if(lire_config('rubriques_descriptif') == 'non')
        ecrire_meta('rubriques_descriptif','oui') ;
    if(lire_config('articles_descriptif') == 'non')
       ecrire_meta('articles_descriptif','oui') ;
}


// Description du shema de groupes et mots
function shema_escal(){
    $schema = array(
        'groupes' => array(
            array(  // creation du groupe affichage
                'titre'=>'affichage',
                'descriptif'=> _T('escal:groupe_affichage'),
                'tables_liees'=>'articles,rubriques,syndic',
                'minirezo'=>'oui',
                'comite'=>'oui'
            ),
            array( // creation du groupe Agenda_couleur
                'titre'=>'Agenda_couleur',
                'descriptif'=> _T('escal:groupe_agenda_couleur'),
                'tables_liees'=>'evenements',
                'minirezo'=>'oui',
                'comite'=>'oui'
            )
        ),
        'mots'=> array(
            // Agenda_couleur
            array(
                'titre'=>'Noir',
                'descriptif'=>'#000000',
                'type'=>'Agenda_couleur'
                ),
            array(
                'titre'=>'Rouge',
                'descriptif'=>'red',
                'type'=>'Agenda_couleur'
                ),
            array(
                'titre'=>'Vert',
                'descriptif'=>'green',
                'type'=>'Agenda_couleur'
                ),
            array(
                'titre'=>'Violet',
                'descriptif'=>'#FF00FF',
                'type'=>'Agenda_couleur'
                ),
            array(
                'titre'=>'Marron',
                'descriptif'=>'#7F3D00',
                'type'=>'Agenda_couleur'
                ),
            // affichage
            array(
                'titre'=>'acces-direct',
                'descriptif'=> _T('escal:mot_acces_direct'),
                'type'=>'affichage'
            ),
            array(
                'titre'=>'accueil',
                'descriptif'=> _T('escal:mot_accueil'),
                'type'=>'affichage'
            ),
            array(
                'titre'=> 'actus',
                'descriptif'=> _T('escal:mot_actus'),
                'type'=>'affichage'
            ),
            array(
                'titre'=>'agenda',
                'descriptif'=> _T('escal:mot_agenda'),
                'type'=>'affichage'
            ),
            array(
                'titre'=>'annonce',
                'descriptif'=> _T('escal:mot_annonce'),
                'type'=>'affichage'
            ),
            array(
                'titre'=>'annonce-defilant',
                'descriptif'=> _T('escal:mot_annonce_defilant'),
                'type'=>'affichage'
            ),
            array(
                'titre'=>'annuaire',
                'descriptif'=> _T('escal:mot_annuaire'),
                'type'=>'affichage'
            ),
            array(
                'titre'=>'archive',
                'descriptif'=> _T('escal:mot_archive'),
                'type'=>'affichage'
            ),
            array(
                'titre'=>'articles-de-rubrique',
                'descriptif'=> _T('escal:mot_articles_rubrique'),
                'type'=>'affichage'
            ),
            array(
                'titre'=>'article-libre1',
                'descriptif'=> _T('escal:mot_article_libre1'),
                'type'=>'affichage'
            ),
            array(
                'titre'=>'article-libre2',
                'descriptif'=> _T('escal:mot_article_libre2'),
                'type'=>'affichage'
            ),
            array(
                'titre'=>'article-libre3',
                'descriptif'=> _T('escal:mot_article_libre3'),
                'type'=>'affichage'
            ),
            array(
                'titre'=>'article-libre4',
                'descriptif'=> _T('escal:mot_article_libre4'),
                'type'=>'affichage'
            ),
            array(
                'titre'=>'article-libre5',
                'descriptif'=> _T('escal:mot_article_libre5'),
                'type'=>'affichage'
            ),
            array(
                'titre'=>'article-sans-date',
                'descriptif'=> _T('escal:mot_article_sans_date'),
                'type'=>'affichage'
            ),
            array(
                'titre'=>'chrono',
                'descriptif'=> _T('escal:mot_chrono'),
                'type'=>'affichage'
            ),
            array(
                'titre'=>'citations',
                'descriptif'=> _T('escal:mot_citations'),
                'type'=>'affichage'
            ),
            array(
                'titre'=>'edito',
                'descriptif'=> _T('escal:mot_edito'),
                'type'=>'affichage'
            ),
            array(
                'titre'=>'favori',
                'descriptif'=> _T('escal:mot_favori'),
                'type'=>'affichage'
            ),
            array(
                'titre'=>'forum',
                'descriptif'=> _T('escal:mot_forum'),
                'type'=>'affichage'
            ),
            array(
                'titre'=>'invisible',
                'descriptif'=> _T('escal:mot_invisible'),
                'type'=>'affichage'
            ),
            array(
                'titre'=>'mon-article',
                'descriptif'=> _T('escal:mot_mon_article'),
                'type'=>'affichage'
            ),
            array(
                'titre'=>'mon-article2',
                'descriptif'=> _T('escal:mot_mon_article2'),
                'type'=>'affichage'
            ),
            array(
                'titre'=>'mon-article3',
                'descriptif'=> _T('escal:mot_mon_article3'),
                'type'=>'affichage'
            ),
            array(
                'titre'=>'pas-a-decouvrir',
                'descriptif'=> _T('escal:mot_pas_decouvrir'),
                'type'=>'affichage'
            ),
            array(
                'titre'=>'pas-a-la-une',
                'descriptif'=> _T('escal:mot_pas_une'),
                'type'=>'affichage'
            ),
            array(
                'titre'=>'pas-au-menu',
                'descriptif'=> _T('escal:mot_pas_menu'),
                'type'=>'affichage'
            ),
            array(
                'titre'=>'pas-au-menu-vertical',
                'descriptif'=> _T('escal:mot_pas_menu_vertical'),
                'type'=>'affichage'
            ),
            array(
                'titre'=>'pas-au-plan',
                'descriptif'=> _T('escal:mot_pas_plan'),
                'type'=>'affichage'
            ),
            array(
                'titre'=>'photo-une',
                'descriptif'=> _T('escal:mot_photo_une'),
                'type'=>'affichage'
            ),
            array(
                'titre'=>'pleinepage',
                'descriptif'=> _T('escal:mot_pleine_page'),
                'type'=>'affichage'
            ),
            array(
                'titre'=>'RubriqueOnglet',
                'descriptif'=> _T('escal:mot_rubrique_onglet'),
                'type'=>'affichage'
            ),
            array(
                'titre'=>'RubriqueOnglet2',
                'descriptif'=> _T('escal:mot_rubrique_onglet2'),
                'type'=>'affichage'
            ),
            array(
                'titre'=>'RubriqueOnglet3',
                'descriptif'=> _T('escal:mot_rubrique_onglet3'),
                'type'=>'affichage'
            ),
            array(
                'titre'=>'RubriqueOnglet4',
                'descriptif'=> _T('escal:mot_rubrique_onglet4'),
                'type'=>'affichage'
            ),
            array(
                'titre'=>'RubriqueOnglet5',
                'descriptif'=> _T('escal:mot_rubrique_onglet5'),
                'type'=>'affichage'
            ),
            array(
                'titre'=>'site-exclu',
                'descriptif'=> _T('escal:mot_site_exclu'),
                'type'=>'affichage'
            ),
            array(
                'titre'=>'special',
                'descriptif'=> _T('escal:mot_special'),
                'type'=>'affichage'
            ),
            array(
                'titre'=>'texte2colonnes',
                'descriptif'=> _T('escal:mot_texte2colonnes'),
                'type'=>'affichage'
            ),
            array(
                'titre'=>'video-une',
                'descriptif'=> _T('escal:mot_video_une'),
                'type'=>'affichage'
            )
        )
    );

    return $schema;
}

// Fonction de mise a jour du schema
function update_groupe_mots(){
    include_spip('action/editer_objet');

    // chargement du array des groupe et mots
    $schema = shema_escal();

    // en qu'elle version de escal est on ?
    // si on a une meta escal_base_version, c'est qu'on est sur une version avec instalation auto
    $meta = lire_config('escal_base_version');

    // si la meta est présente
    if($meta!=''){
        // Maj des groupes
        for ($i= 0 , $nbr_grp = count($schema['groupes']) ; $i < $nbr_grp ; ++$i){
            // test si le groupe existe
            $grp_titre = $schema['groupes'][$i]['titre'];
            $id_grp = sql_getfetsel("id_groupe","spip_groupes_mots","titre='$grp_titre'");
            // si pas d'id retournée on inssère
            if($id_grp!=''){
                //echo "Update le groupe existe déja : ".$id_grp."=> ".$grp_titre."\n";
                sql_updateq('spip_groupes_mots', $schema['groupes'][$i], "id_groupe='$id_grp'");
            }//sinon on met a jour
            else{
                //echo "Insert Le groupe n'éxiste pas => ".$grp_titre."\n";
                $id = sql_insertq('spip_groupes_mots',$schema['groupes'][$i]);
            }

        }

        //Maj des mots : on boucle sur le tableau mots
        for ($i= 0 , $nbr_mot = count($schema['mots']) ; $i < $nbr_mot ; ++$i){
            // test la présence du mot sur le champ titre
            $titre = $schema['mots'][$i]['titre'];
            $id_mot = sql_getfetsel("id_mot","spip_mots","titre='$titre'");
            // le titre du mot est déjà présent
            if($id_mot!=''){
                // echo "Update le mot clef existe déja : ".$id_mot."=> ".$titre."\n";
                $test = sql_updateq('spip_mots', $schema['mots'][$i], "titre='$titre'");
                objet_modifier('mot',$id_mot,$schema['mots'][$i]);
            }else{
                // echo "Insert Le mot clef n'éxiste pas => ".$titre."\n";
                // on extrait du array le groupe dont dépend le mot
                $grp_titre = $schema['mots'][$i]['type'];
                $id_grp = sql_getfetsel("id_groupe","spip_groupes_mots","titre='$grp_titre'");
                $id_mot = objet_inserer('mot',$id_grp);
                objet_modifier('mot',$id_mot,$schema['mots'][$i]);
            }
        }
    }//si pas de meta_base on est sur une install plus ancienne
    else{
       // on verra plus tard ;-)
    }
}


/*
 * function install_groupe_mot
 * installe les groupes de mots techniques et leurs mots clefs
 */
function install_groupe_mots() {
    include_spip('action/editer_objet');
    // chargement du array des groupe et mots
    $schema = shema_escal();
    // installation des groupes
    for ($i= 0 , $nbr_mot = count($schema['groupes']) ; $i < $nbr_mot ; ++$i){
        $id = sql_insertq('spip_groupes_mots',$schema['groupes'][$i]);
    }

    // installation des mots
    for ($i= 0 , $nbr_mot = count($schema['mots']) ; $i < $nbr_mot ; ++$i){
        // on extrait du array le groupe dont dépend le mot
        $grp_titre = $schema['mots'][$i]['type'];
        $id_grp = sql_getfetsel("id_groupe","spip_groupes_mots","titre='$grp_titre'");
        if($id_grp!=''){
           $id_mot = objet_inserer('mot',$id_grp);
            objet_modifier('mot',$id_mot,$schema['mots'][$i]);
        }
    }

}

// Fonction de désinstalation des groupes et mots de Escal
function uninstal_escal(){
    // chargement du array des groupe et mots
    $schema = shema_escal();
    $id_grp = array();
    // recuperer les id des groupes
    for ($i= 0 , $nbr_mot = count($schema['groupes']) ; $i < $nbr_mot ; ++$i){
        $grp_titre = $schema['groupes'][$i]['titre'];
        $id_grp = sql_getfetsel("id_groupe","spip_groupes_mots","titre='$grp_titre'");
        // désinstaller les mots correspondant a ce groupe
        sql_delete("spip_mots","id_groupe='$id_grp'");
        sql_delete("spip_groupes_mots","id_groupe='$id_grp'");
    }
}

// fonction install_contenus
// - créer une rubrique "Rubrique cachée"
// - créer un article "Edito" et un article "Accès direct"
// - associer le mot-clé "invisible" à cette rubrique
// - associer le mot-clé "edito" à l'article "Edito"
// - associer le mot-clé "acces-direct" à l'article "Accès direct"
function install_contenus(){
    include_spip('action/editer_objet');
    include_spip('action/editer_liens');
    // créer une rubrique "Rubrique cachée"
    $rubrique_contenu = array(
      'titre'=> _T('escal:rubrique_cachee_titre'),
      'descriptif'=> _T('escal:rubrique_cachee_descriptif')
    );
    $id_rubrique = objet_inserer('rubrique',null,$rubrique_contenu);
    // créer dans cette rubrique, un article "Edito"
    $article_edito_contenu = array(
      'titre'=> _T('escal:article_edito_titre'),
      'descriptif'=> _T('escal:article_edito_descriptif'),
      'texte'=> _T('escal:article_edito_texte')
    );
    $article_edito = objet_inserer('article',$id_rubrique,$article_edito_contenu);
    objet_modifier('article',$article_edito,array('statut'=>'publie'));
    // créer dans cette rubrique, un article "Accès direct"
    $article_acces_direct_contenu = array(
      'titre'=> _T('escal:article_acces_direct_titre'),
      'descriptif'=> _T('escal:article_acces_direct_descriptif'),
      'texte'=> _T('escal:article_acces_direct_texte')
    );
    $article_acces_direct = objet_inserer('article',$id_rubrique,$article_acces_direct_contenu);
    objet_modifier('article',$article_acces_direct,array('statut'=>'publie'));

    // Ajout des liaisons
    // recupérer l'id_mot invisible
    $id_mot_invisible = sql_getfetsel("id_mot","spip_mots","titre='invisible'");
    if($id_mot_invisible){
      objet_associer(array('mot'=>$id_mot_invisible),array('rubrique'=>$id_rubrique));
    }
    // recupérer l'id_mot edito
    $id_mot_edito = sql_getfetsel("id_mot","spip_mots","titre='edito'");
    if($id_mot_edito){
      objet_associer(array('mot'=>$id_mot_edito),array('article'=>$article_edito));
    }
    // recupérer l'id_mot acces-direct
    $id_mot_acces_direct = sql_getfetsel("id_mot","spip_mots","titre='acces-direct'");
    if($id_mot_acces_direct){
      objet_associer(array('mot'=>$id_mot_acces_direct),array('article'=>$article_acces_direct));
    }

    // spip_log("Rubrique: $id_rubrique, Acces direct: $article_acces_direct",'Escal');

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
return inc_lien_dist($lien, $texte, $class, $title, $hlang, $rel, $connect);
}
}
// balises issues da la contrib  "Balises de comptage" de Franck
// http://contrib.spip.net/Balises-de-comptage
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
// http://contrib.spip.net/Nombres-de-visiteurs-connectes
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
	$arg="'date'";
	$p->code = "generer_jour_val_max_visites($arg)";
	$p->interdire_scripts = false;
	return $p;
}
function balise_VAL_MAX_VISITES($p) {
	$arg="'val'";
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

/*   +----------------------------------+
 *    Nom du Filtre :    tuer les lettres!
 *   +----------------------------------+
 *    Date : lundi 11 mai 2005
 *    Auteur :  Posted by cerdic
 *   +-------------------------------------+
 *    Fonctions de ce filtre :
 *   remplacement des caractères accentués
 *    exemple trouvé là:
 *    http://be.php.net/manual/fr/function.strtr.php#52098
 *   +-------------------------------------+
 *
*/


function lettre1($texte) {
	$texte = $texte{0}; // première lettre
		$texte =
strtr($texte, "\xA1\xAA\xBA\xBF\xC0\xC1\xC2\xC3\xC5\xC7\xC8\xC9\xCA\xCB\xCC\xCD\xCE\xCF\xD0\xD1\xD2\xD3\xD4\xD5\xD8\xD9\xDA\xDB\xDD\xE0\xE1\xE2\xE3\xE5\xE7\xE8\xE9\xEA\xEB\xEC\xED\xEE\xEF\xF0\xF1\xF2\xF3\xF4\xF5\xF8\xF9\xFA\xFB\xFD\xFF", "!ao?AAAAACEEEEIIIIDNOOOOOUUUYaaaaaceeeeiiiidnooooouuuyy");
	$texte = strtr($texte,
array("\xC4"=>"Ae", "\xC6"=>"AE", "\xD6"=>"Oe", "\xDC"=>"Ue", "\xDE"=>"TH", "\xDF"=>"ss", "\xE4"=>"ae", "\xE6"=>"ae", "\xF6"=>"oe", "\xFC"=>"ue", "\xFE"=>"th"));
	$texte = strtoupper($texte); // tout en majuscules
	return $texte;
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



// =======================================================================================================================================
// fonction couperpropre
// =======================================================================================================================================

/*
* Coupe une chaine en gardant le formatage HTML
* @param string $text Texte a couper
* @param integer $length Longueur a garder
* @param string $ending Caracteres a ajouter a la fin
* @param boolean $exact Coupure exacte
* @return string
*/

function couperpropre($text, $length, $ending = '...', $exact = false) {
if(strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
	return $text;
}
	preg_match_all('/(<.+?>)?([^<>]*)/is', $text, $matches, PREG_SET_ORDER);
	$total_length = 0;
	$arr_elements = array();
	$truncate = '';
foreach($matches as $element) {
if(!empty($element[1])) {
if(preg_match('/^<\s*.+?\/\s*>$/s', $element[1])) {
}
else if(preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $element[1], $element2)) {
	$pos = array_search($element2[1], $arr_elements);
if($pos !== false) {
	unset($arr_elements[$pos]);
}
}
else if(preg_match('/^<\s*([^\s>!]+).*?>$/s', $element[1], $element2)) {
	array_unshift($arr_elements,    strtolower($element2[1]));
}
	$truncate .= $element[1];
}
$content_length = strlen(preg_replace('/(&[a-z] {
	1,6
}
	;
	|&#[0-9]+;
	)/i', ' ', $element[2]));
if($total_length >= $length) {
	break;
}
elseif ($total_length+$content_length > $length) {
	$left = $total_length>$length?$total_length-$length: $length-$total_length;
	$entities_length = 0;
if(preg_match_all('/&[a-z] {
	1,6
}
	;
	|&#[0-9]+;
/i', $element[2], $element3, PREG_OFFSET_CAPTURE)) {
foreach($element3[0] as $entity) {
if($entity[1]+1-$entities_length <= $left) {
	$left--;
	$entities_length += strlen($entity[0]);
}
	else break;
}
}
	$truncate .= substr($element[2], 0, $left+$entities_length);
	break;
}
else {
	$truncate .= $element[2];
	$total_length += $content_length;
}
}
if(!$exact) {
	$spacepos = strrpos($truncate, ' ');
if(isset($spacepos)) {
	$truncate = substr($truncate, 0, $spacepos);
}
}
	$truncate .= $ending;
foreach($arr_elements as $element) {
	$truncate .= '</' . $element . '>';
}
	return $truncate;
}

// =======================================================================================================================================
// traitement json
// =======================================================================================================================================

if (!function_exists('json_decode')) {
    function json_decode($content, $assoc=false) {
        require_once 'classes/JSON.php';
        if ($assoc) {
            $json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
        }
        else {
            $json = new Services_JSON;
        }
        return $json->decode($content);
    }
}

if (!function_exists('json_encode')) {
    function json_encode($content) {
        require_once 'classes/JSON.php';
        $json = new Services_JSON;
        return $json->encode($content);
    }
}



/*######
#
# Filtre SPIP 'decouper_en_XD_parties'
# 4 Alexandra By Apsulis
# 14 janvier 2007
#
# OBJET :
# -------
# Pour decouper un contenu texte en X parties egale avec cesure mot entier.
# Retourne la partie Y demandee.
#
# USAGE :
# -------
# Dans le squelette :
# [(#TEXTE*|decouper_en_XD_parties{X,Y}|propre)]
#
# Dans le fichier mes_fonctions.php (a ranger par exemple dans votre dossier de squelettes) :
# placer la fonction qui suit depuis "function decouper"... jusqu'a "return $partie_isolee; }"
#
#
# Remarque :
# ----------
# - Fonctionne avec n'importe quel contenu texte : #INTRO, #TEXTE, #DESCRIPTIF, #PS, etc...
# - Pour remplir X colonnes, dans le cadre d'une boucle (ou pas, vous faites ce que vous voulez),
# utiliser X fois le filtre en changeant la partie Y demandee.
#
#######*/



function decouper_en_XD_parties($texte,$nb_parties,$partie_a_retourner){

        /* On traite les erreurs positives et negatives au cas ou */
        if($partie_a_retourner > $nb_parties){
                $partie_a_retourner = $nb_parties;
        }
        if($partie_a_retourner == 0){
                $partie_a_retourner = 1;
        }


//var_dump($nb_parties);
        $longueur = strlen($texte);                                                                 // Longueur totale de la chaine de caractere
        $partie = $longueur/$nb_parties;                                        // Taille en caracteres d'une partie
        $decoupe = str_word_count($texte, 2, '.&<|>');                        // On decoupe le texte par mot pour savoir a quels mots couper les parties

//print_r(str_word_count($texte, 2, '.&'));

        $mots_cesure[0] = 0;                                                                                        // Premiere borne = 0
        $j = 1;


                        while($j < $nb_parties){                                                                        // On recherche la fin du dernier mot de la partie pour ne pas le couper (=cesure)
                $i = $partie*($j);                                                                                        // On debute la recherche a partie, et ensuite on incremente de la taille d'une partie pour trouver le mot suivant
                while(!isset($decoupe[$i])){                                                // On part du caractere ou on devrait couper,
                        $i++;                                                                                                                                        // et on avance jusqu'a trouver la fin du mot
                }
        /*###
        # CORRECTIF par Pierre
        # Pour eviter de couper les colonnes au milieu d'une ligne (par exemple une ligne de un ou deux mots)
        # La coupure se fait  la fin d'une phrase, aprs le point.
        # (ligne 49)"$decoupe = str_word_count($texte, 2, '.&');" ici le troisime parametre est l'ensemble des caracteres autorises dans un mot dont le point ce qui permet la coupure.
        ###*/
                while(!preg_match('`\.$`',"$decoupe[$i]")){   //tant que le mot ne se termine pas par un point...
                        $i++;                                                                                                                                                                //incrementation d'un caractere
                        while(!isset($decoupe[$i])){
                        $i++;
                        }
                }
                $i++;
                        while(!isset($decoupe[$i])){
                        $i++;
                        }
        //echo $decoupe[$i];

        /*### FIN DU CORRECTIF ###*/


                $mots_cesure[$j] = $i;                                                                        // On range la valeur en caractere du mot clef pour la cesure
                $j++;                                                                                                                                                // On passe a la partie suivante
        }
        $mots_cesure[$j] = $longueur;                                                        // Derniere borne = fin du texte

        // On isole la partie qu'on renvoi pour affichage par SPIP
        $partie_isolee = substr($texte, $mots_cesure[$partie_a_retourner-1], $mots_cesure[$partie_a_retourner]-$mots_cesure[$partie_a_retourner-1]);

        return propre($partie_isolee);
}
?>
