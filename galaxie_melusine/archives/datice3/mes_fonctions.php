<?php
// ===================================================
// Filtre : hauteur_majoree
// ===================================================
// Auteur: S. Bellégo
// Fonction : Retourne la hauteur d'une image + 20. Sert pour
//                   afficher correctemnt le logo d'une rubrique
// ===================================================
//



function hauteur_majoree($img) {
    if (!$img) return;
    include_spip('logos.php');
    list ($h,$l) = taille_image($img);
    $h+=20;
    return $h;
}
// FIN du Filtre : hauteur_majoree

// ===================================================
// Filtre : typo_couleur
// ===================================================
// Auteur : Smellup, inspiré du filtre original de A. Piérard
// Fonction : permettant de modifier la couleur du texte ou 
//                   de l'introduction d'un article
// Utilisation :                  
//  - pour le rédacteur : [rouge]xxxxxx[/rouge]
//  - pour le webmaster : [(#TEXTE|couleur)]
// ===================================================
//
function typo_couleur($texte) {

    // Variables personnalisables par l'utilisateur
    $typo_couleur_active = 'oui';
    // --> Activation ou désactivation de la fonction
    // --> Nuances personnalisables par l'utilisateur
    $couleur = array(
        'noir' => "#000000",
        'blanc' => "#FFFFFF",
        'rouge' => "#FF0000",
        'vert' => "#00FF00",
        'bleu' => "#0000FF",
        'jaune' => "#FFFF00",
        'gris' => "#808080",
        'marron' => "#800000",
        'violet' => "#800080",
        'rose' => "#FFC0CB",
        'orange' => "#FFA500"
    );

    $recherche = array(
        'noir' => "/(\[noir\])(.*?)(\[\/noir\])/",
        'blanc' => "/(\[blanc\])(.*?)(\[\/blanc\])/",
        'rouge' => "/(\[rouge\])(.*?)(\[\/rouge\])/",
        'vert' => "/(\[vert\])(.*?)(\[\/vert\])/",
        'bleu' => "/(\[bleu\])(.*?)(\[\/bleu\])/",
        'jaune' => "/(\[jaune\])(.*?)(\[\/jaune\])/",
        'gris' => "/(\[gris\])(.*?)(\[\/gris\])/",
        'marron' => "/(\[marron\])(.*?)(\[\/marron\])/",
        'violet' => "/(\[violet\])(.*?)(\[\/violet\])/",
        'rose' => "/(\[rose\])(.*?)(\[\/rose\])/",
        'orange' => "/(\[orange\])(.*?)(\[\/orange\])/"
    );

    $remplace = array(
        'noir' => "<span style=\"color:".$couleur['noir'].";\">\\2</span>",
        'blanc' => "<span style=\"color:".$couleur['blanc'].";\">\\2</span>",
        'rouge' => "<span style=\"color:".$couleur['rouge'].";\">\\2</span>",
        'vert' => "<span style=\"color:".$couleur['vert'].";\">\\2</span>",
        'bleu' => "<span style=\"color:".$couleur['bleu'].";\">\\2</span>",
        'jaune' => "<span style=\"color:".$couleur['jaune'].";\">\\2</span>",
        'gris' => "<span style=\"color:".$couleur['gris'].";\">\\2</span>",
        'marron' => "<span style=\"color:".$couleur['marron'].";\">\\2</span>",
        'violet' => "<span style=\"color:".$couleur['violet'].";\">\\2</span>",
        'rose' => "<span style=\"color:".$couleur['rose'].";\">\\2</span>",
        'orange' => "<span style=\"color:".$couleur['orange'].";\">\\2</span>"
    );

    $supprime = "\\2";


    if ($typo_couleur_active == 'non') {
        $texte = preg_replace($recherche, $supprime, $texte);
    }
    else {
        $texte = preg_replace($recherche, $remplace, $texte);
    }
    return $texte;
}

// ===================================================
// Filtre : premier_jour_annee
// ===================================================
// Auteur: Smellup
// Fonction : Retourne la date du premier jour de l'année
//                   passée en argument
// ===================================================
//
function premier_jour_annee($annee) {
    if (!$annee) return;
    
    $jour = date("Y-m-d H:i:s", mktime(0,0,0,1,1,$annee));
    return $jour;
}
// FIN du Filtre : premier_jour_annee

// ===================================================
// Filtre : dernier_jour_annee
// ===================================================
// Auteur: Smellup
// Fonction : Retourne la date du dernier jour de l'année
//                   passée en argument
// ===================================================
//
function dernier_jour_annee($annee) {
    if (!$annee) return;
    
    $jour = date("Y-m-d H:i:s", mktime(23,59,59,12,31,$annee));
    return $jour;
}
// FIN du Filtre : dernier_jour_annee

// ===================================================
// Filtre : debut_journee
// ===================================================
// Auteur: Smellup
// Fonction : Retourne la date-heure de début de la journée
//                   passée en argument
// ===================================================
//
function debut_journee($date) {
    if (!$date) return;
    
    $jour = date('d', strtotime($date));
    $mois = date('m', strtotime($date));
    $annee = date('Y', strtotime($date));
    $jour = date("Y-m-d H:i:s", mktime(0,0,0,$mois,$jour,$annee));
    return $jour;
}
// FIN du Filtre : debut_journee

// ===================================================
// Filtre : fin_journee
// ===================================================
// Auteur: Smellup
// Fonction : Retourne la date-heure de fin de la journée
//                   passée en argument
// ===================================================
//
function fin_journee($date) {
    if (!$date) return;
    
    $jour = date('d', strtotime($date));
    $mois = date('m', strtotime($date));
    $annee = date('Y', strtotime($date));
    $jour = date("Y-m-d H:i:s", mktime(23,59,59,$mois,$jour,$annee));
    return $jour;
}
// FIN du Filtre : fin_journee

// ===================================================
// Balise : #VERSION_SPIP
// ===================================================
// Auteur: Smellup, inspiré de la balise originale de Scoty
// Fonction : affiche la version SPIP correspondant à la 
//                   variable globale $version_spip_affichee
// ===================================================
//
function balise_VERSION_SPIP($p) {
    $p->code = "\$GLOBALS['spip_version_affichee']";
    $p->statut = 'html';
    return $p;
}

// ===================================================
// Balise : #VERSION_SQUELETTE
// ===================================================
// Auteur: Smellup
// Fonction : affiche la version utilisée du squelette Sarka 
//                   variable globale $version_squelette
// ===================================================
//
$GLOBALS['version_squelette'] = '1.9.0';
function balise_VERSION_SQUELETTE($p) {
    $p->code = 'calcul_version_squelette()';
    $p->statut = 'php';
    return $p;
}

function calcul_version_squelette() {

    $version = $GLOBALS['version_squelette'];
    $fichier = find_in_path('sarka-spip.revision');
    
    if (isset($fichier)) {
        if (lire_fichier($fichier, $contenu)) {
            if (preg_match('/Revision:[[:blank:]]([0-9]+)/', $contenu, $match)) {
                $version .= ' [rev'.$match[1].']';
            }
        }
    }
    return $version;
}

// ===================================================
// Balise : #VISITES_SITE
// ===================================================
// Auteur: Smellup
// Fonction : affiche le nombre de visites sur le site pour le
//                   jour courant, la veille ou dépuis le début
// Paramètre: aujourdhui, hier, depuis_debut (ou vide)
// ===================================================
//
function balise_VISITES_SITE($p) {

    if ($a = $p->param) {
        $sinon = array_shift($a);
        if  (!array_shift($sinon)) {
            $p->fonctions = $a;
            array_shift( $p->param );
            $jour = array_shift($sinon);
            $jour = ($jour[0]->type=='texte') ? $jour[0]->texte : '';
        }
    }
    else {
        $jour = 'depuis_debut';
    }

    $p->code = 'calcul_visites_site('.$jour.')';
    $p->statut = 'php';
    return $p;
}

function calcul_visites_site($j) {

    if ( $j == 'aujourdhui' ) {
        $auj = date('Y-m-d',strtotime(date('Y-m-d')));
        $query = "SELECT visites AS visites FROM spip_visites WHERE date='$auj'";
        $result = spip_query($query);
        $visites_auj = 0;
        if ($row = @spip_fetch_array($result)) {
            $visites_auj = $row['visites'];
        }
        $r = $visites_auj;
    }
    else if ( $j == 'hier' ) {
        $hier = date('Y-m-d',strtotime(date('Y-m-d')) - 3600*24);
        $query = "SELECT visites AS visites FROM spip_visites WHERE date='$hier'";
        $result = spip_query($query);
        $visites_hier = 0;
        if ($row = @spip_fetch_array($result)) {
            $visites_hier = $row['visites'];
        }
        $r = $visites_hier;
    }
    else {
        $query = "SELECT SUM(visites) AS total_absolu FROM spip_visites";
        $result = spip_query($query);
        $visites_debut = 0;
        if ($row = @spip_fetch_array($result)) {
            $visites_debut = $row['total_absolu'];
        }
        $r = $visites_debut;
    }
    return $r;
}

// ===================================================
// Balise : #INTRODUCTION (surcharge)
// ===================================================
// Auteur: Smellup
// Fonction : Surcharge de la fonction standard de calcul de la 
//                   balise #INTRODUCTION. Permet d'en definir la
//                   taille en nombre de caractère
// ===================================================
//
function introduction ($type, $texte, $chapo='', $descriptif='') {

    // Personnalisable par l'utilisateur
    $taille_intro_article = 600;
    $taille_intro_breve = 300;
    $taille_intro_message = 600;
    $taille_intro_rubrique = 600;
    
    switch ($type) {
        case 'articles':
            if ($descriptif)
                return propre($descriptif);
            else if (substr($chapo, 0, 1) == '=')   // article virtuel
                return '';
            else
                return PtoBR(propre(supprimer_tags(couper_intro($chapo."\n\n\n".$texte, $taille_intro_article))));
            break;
        case 'breves':
            return PtoBR(propre(supprimer_tags(couper_intro($texte, $taille_intro_breve))));
            break;
        case 'forums':
            return PtoBR(propre(supprimer_tags(couper_intro($texte, $taille_intro_message))));
            break;
        case 'rubriques':
            if ($descriptif)
                return propre($descriptif);
            else
                return PtoBR(propre(supprimer_tags(couper_intro($texte, $taille_intro_rubrique))));
            break;
    }
}

// ===================================================
// Balise : #RUBRIQUE_AGENDA
// ===================================================
// Auteur: Smellup
// Fonction : retourne la valeur de l'ID de la rubrique faisant
//                   office d'agenda (associé au mot-clé agenda)
// ===================================================
//
function balise_RUBRIQUE_AGENDA($p) {

    $p->code = 'calcul_rubrique_agenda()';
    $p->statut = 'php';
    return $p;
}

function calcul_rubrique_agenda() {

    $query = "SELECT id_rubrique AS id_rubrique FROM spip_mots_rubriques, spip_mots, spip_groupes_mots 
    WHERE spip_groupes_mots.titre='squelette_habillage' AND spip_groupes_mots.id_groupe=spip_mots.id_groupe AND spip_mots.titre='agenda' AND spip_mots.id_mot=spip_mots_rubriques.id_mot";
    $result = spip_query($query);
    $id_rubrique = 0;
    if ($row = @spip_fetch_array($result)) {
        $id_rubrique = $row['id_rubrique'];
    }
    return $id_rubrique;
}



// =======================================================================================================================================
// Balise : #PLUGIN
// =======================================================================================================================================
// Auteur: Smellup
// Fonction : retourne une info donnee d'un plugin designe par son prefixe
// =======================================================================================================================================
//
include_spip('public/plugin_balises');

?>