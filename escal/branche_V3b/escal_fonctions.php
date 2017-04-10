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


// Description du shema de groupes et mots
function shema_escal(){
    $schema = array(
        'groupes' => array(
            array(
                'titre'=>'affichage',
                'descriptif'=>'Groupe de mots-cl&eacute;s techniques utilis&eacute;s dans Escal',
                'tables_liees'=>'articles,rubriques,syndic',
                'minirezo'=>'oui',
                'comite'=>'oui'
            )   
        ),
        'mots'=> array(
            array(
                'titre'=>'pas-au-menu',
                'descriptif'=>'pour ne pas afficher une rubrique ou un article dans le menu horizontal',
                'type'=>'affichage'
                ),
            array(
                'titre'=>'pas-au-menu-vertical',
                'descriptif'=>'Modification dans le descriptif !! pour ne pas afficher une rubrique ou un article dans les menus verticaux',
                'type'=>'affichage'
            ),
            array(
                'titre'=>'chrono',
                'descriptif'=>'pour afficher les articles d&rsquo;une rubrique dans les menus en ordre ant&eacute;chronologique, comportement non transmis aux rubriques-filles',
                'type'=>'affichage'
            ),
            array(
                'titre'=>'pas-a-la-une',
                'descriptif'=>'pour ne pas afficher une rubrique (et ses articles) ou des articles dans le bloc "les derniers articles ..." de la page d&rsquo;accueil',
                'type'=>'affichage'
                ),
            array(
                'titre'=>'pas-au-plan',
                'descriptif'=>'pour ne pas afficher une rubrique (et ses articles) ou des articles dans le bloc "Plan du site" de la page d&rsquo;accueil',
                'type'=>'affichage'
            ),
            array(
                'titre'=>'edito',
                'descriptif'=>'pour choisir l&rsquo;article qui sera affich&eacute; dans le bloc "Edito" (noisette inc-edito)',
                'type'=>'affichage'
            ),
            array(
                'titre'=>'accueil',
                'descriptif'=>'pour choisir l&rsquo;article affich&eacute; en onglet d&rsquo;accueil (noisette inc-accueil)',
                'type'=>'affichage'
            ),
            array(
                'titre'=>'acces-direct',
                'descriptif'=>'pour choisir l&rsquo;article qui sera affich&eacute; dans le bloc "Acc&egrave;s direct" (noisette inc-acces_direct)',
                'type'=>'affichage'
            ),
            array(
                'titre'=>'annonce',
                'descriptif'=>'pour choisir l&rsquo;article dont le texte sera affich&eacute; dans le bloc "Annonce" de la page d&rsquo;accueil (noisette inc-annonce)',
                'type'=>'affichage'
            ),
            array(
                'titre'=>'annonce-defilant',
                'descriptif'=>'pour choisir les articles dont le texte sera affich&eacute; dans le bloc "Annonces d&eacute;filantes" de la page d&rsquo;accueil (noisette inc-annonce_defilant)',
                'type'=>'affichage'
            ),
            array(
                'titre'=>'agenda',
                'descriptif'=>'pour choisir les articles ou la ou les rubriques dont les articles seront affich&eacute;s dans l&rsquo;agenda',
                'type'=>'affichage'
            ),
            array(
                'titre'=>'actus',
                'descriptif'=>'pour choisir les articles qui seront affich&eacute;s dans le bloc "Actus" (noisette inc-actus)',
                'type'=>'affichage'
            ),
            array(
                'titre'=>'photo-une',
                'descriptif'=>'pour choisir les articles dont les images seront affich&eacute;es dans le bloc "Quelques images au hasard" (noisette inc-photos)',
                'type'=>'affichage'
            ),
            array(
                'titre'=>'video-une',
                'descriptif'=>'pour choisir les articles dont les vid&eacute;os seront affich&eacute;es dans le bloc "Vid&eacute;o" (noisette inc-video_accueil)',
                'type'=>'affichage'
            ),
            array(
                'titre'=>'favori',
                'descriptif'=>'pour choisir les sites dont les vignettes seront affich&eacute;es dans le bloc "Sites favoris" (noisette inc-sites_favoris.html)',
                'type'=>'affichage'
            ),
            array(
                'titre'=>'site-exclu',
                'descriptif'=>'pour exclure des sites dans le bloc "Sur le web" (noisette inc-sites.html)',
                'type'=>'affichage'
            ),
            array(
                'titre'=>'forum',
                'descriptif'=>'pour choisir le secteur qui sera utilis&eacute; pour le forum du site',
                'type'=>'affichage'
            ),
            array(
                'titre'=>'annuaire',
                'descriptif'=>'pour choisir l&rsquo;article qui sera utilis&eacute; par la page annuaire.html',
                'type'=>'affichage'
            ),
            array(
                'titre'=>'RubriqueOnglet',
                'descriptif'=>'pour choisir la rubrique qui sera affich&eacute;e dans les onglets en page d&rsquo;accueil',
                'type'=>'affichage'
            ),
            array(
                'titre'=>'citations',
                'descriptif'=>'pour choisir l&rsquo;article qui servira de r&eacute;servoir pour les citations dans le pied de page',
                'type'=>'affichage'
            ),
            array(
                'titre'=>'mon-article',
                'descriptif'=>'pour choisir l&rsquo;article qui sera affich&eacute; dans un onglet du bloc central de la page d&rsquo;accueil',
                'type'=>'affichage'
            ),
            array(
                'titre'=>'special',
                'descriptif'=>'pour choisir la rubrique et/ou les articles qui seront affich&eacute;s dans le bloc &agrave; personnaliser (noisette inc-perso.html)',
                'type'=>'affichage'
            ),
            array(
                'titre'=>'pas-a-decouvrir',
                'descriptif'=>'pour choisir les rubriques et les articles &agrave; exclure de l&rsquo;affichage dans la noisette "A decouvrir" si on choisit "dans tout le site" (inc-decouvrir-articles-sites.html)',
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
// https://contrib.spip.net/Balises-de-comptage 
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
// https://contrib.spip.net/Nombres-de-visiteurs-connectes
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