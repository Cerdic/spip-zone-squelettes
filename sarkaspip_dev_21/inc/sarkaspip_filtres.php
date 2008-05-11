<?php
// =======================================================================================================================================
// Filtre : hauteur_majoree
// =======================================================================================================================================
// Auteur: S. Bellego
// Fonction : Retourne la hauteur d'une image + 20. Sert pour afficher correctemnt le logo d'une rubrique
// =======================================================================================================================================
//
function hauteur_majoree($img) {
	if (!$img) return;
	include_spip('logos.php');
	list ($h,$l) = taille_image($img);
	$h+=20;
	return $h;
}
//FIN du Filtre : hauteur_majoree

// =======================================================================================================================================
// Filtre : largeur_majoree
// =======================================================================================================================================
// Auteur: S. Bellego
// Fonction : Retourne la largeur d'une image argument.Utilisee pour dimensionner les cadres des documents dans les articles
// =======================================================================================================================================
//
function largeur_majoree($img, $maj = 0) {
	if (!$img) return;
	include_spip('logos.php');
	list ($h,$l) = taille_image($img);
	$l+=$maj;
	return $l;
}
//FIN du Filtre : largeur_majoree

// =======================================================================================================================================
// Filtre : typo_couleur
// =======================================================================================================================================
// Auteur : Smellup, inspire du filtre original de A. Pierard
// Fonction : permettant de modifier la couleur du texte ou de l'introduction d'un article
// Utilisation :                  
// 	- pour le redacteur : [rouge]xxxxxx[/rouge]
// 	- pour le webmaster : [(#TEXTE|typo_couleur)]
// =======================================================================================================================================
//
function typo_couleur($texte) {

	// Variables personnalisables par l'utilisateur
	// --> Activation (oui) ou desactivation (non) de la fonction
	$typo_couleur_active = 'oui';
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

// =======================================================================================================================================
// Filtre : premier_jour_annee
// =======================================================================================================================================
// Auteur: Smellup
// Fonction : Retourne la date du premier jour de l'annee passe en argument
// =======================================================================================================================================
//
function premier_jour_annee($annee) {
	if (!$annee) return;
	
	$jour = date("Y-m-d H:i:s", mktime(0,0,0,1,1,$annee));
	return $jour;
}
// FIN du Filtre : premier_jour_annee

// =======================================================================================================================================
// Filtre : dernier_jour_annee
// =======================================================================================================================================
// Auteur: Smellup
// Fonction : Retourne la date du dernier jour de l'annee passe en argument
// =======================================================================================================================================
//
function dernier_jour_annee($annee) {
	if (!$annee) return;
	
	$jour = date("Y-m-d H:i:s", mktime(23,59,59,12,31,$annee));
	return $jour;
}
// FIN du Filtre : dernier_jour_annee

// =======================================================================================================================================
// Filtre : debut_journee
// =======================================================================================================================================
// Auteur: Smellup
// Fonction : Retourne la date-heure de debut de la journee passee en argument
// =======================================================================================================================================
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

// =======================================================================================================================================
// Filtre : premier_jour_mois
// =======================================================================================================================================
// Auteur: Smellup
// Fonction : Retourne le premier jour du mois de la date pass�e en argument
// =======================================================================================================================================
//
function premier_jour_mois($date) {
	if (!$date) return;
	
	$mois = date('m', strtotime($date));
	$annee = date('Y', strtotime($date));
	$jour = date("Y-m-d H:i:s", mktime(0,0,0,$mois,1,$annee));
	return $jour;
}
// FIN du Filtre : premier_jour_mois

// =======================================================================================================================================
// Filtre : timestamp_to_date
// =======================================================================================================================================
// Auteur: Smellup
// Fonction : Clone de la fonction PHP date() mais avec les arguments inverses
// =======================================================================================================================================
//
function timestamp_to_date($timestamp, $format) {
	if (!$timestamp) return;
	
	return date($format, $timestamp);
}
// FIN du Filtre : premier_jour_mois

// =======================================================================================================================================
// Filtre : fin_journee
// =======================================================================================================================================
// Auteur: Smellup
// Fonction : Retourne la date-heure de fin de la journee passee en argument
// =======================================================================================================================================
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

// =======================================================================================================================================
// Filtre : mot_associations
// =======================================================================================================================================
// Auteur: Smellup
// Fonction : Retourne le nombre d'associations valides du mot-cle user passe en argument
// =======================================================================================================================================
//
function mot_associations($mot) {
	if (!$mot) return;
	
	static $mots_reserves = array('agenda', 'galerie', 'annonce');
	$rub_specialisee = array();
	reset($mots_reserves);
	while (list($cle, $valeur) = each($mots_reserves)) {
		$rub_specialisee[] = intval(calcul_rubrique($valeur)); 
	}

	$mot = intval($mot);
	$nb = 0;
	
	// Decompte des associations avec des articles
	$from = array('spip_mots_articles AS t1 JOIN spip_articles AS t2 USING (id_article)');
	$where = array('t1.id_mot='.sql_quote($mot),
				   't2.id_rubrique NOT IN ('.sql_quote($rub_specialisee).')');
	$groupby = array('t1.id_mot');
	$nb_articles = sql_countsel($from[0], $where, $groupby);

	// Decompte des associations avec des breves
	$from = array('spip_mots_breves AS t1 JOIN spip_breves AS t2 USING (id_breve)');
	$where = array('t1.id_mot='.sql_quote($mot),
				   't2.id_rubrique NOT IN ('.sql_quote($rub_specialisee).')');
	$groupby = array('id_mot');
	$nb_breves = sql_countsel($from[0], $where, $groupby);

	// Decompte des associations avec des rubriques
	$from = array('spip_mots_rubriques AS t1');
	$where = array('t1.id_mot='.sql_quote($mot),
				   't1.id_rubrique NOT IN ('.sql_quote($rub_specialisee).')');
	$groupby = array('id_mot');
	$nb_rubriques = sql_countsel($from[0], $where, $groupby);

	// Decompte des associations avec des messages de forums
	$from = array('spip_mots_forum AS t1 JOIN spip_forum AS t2 USING (id_forum)');
	$where = array('t1.id_mot='.sql_quote($mot),
				   't2.id_rubrique NOT IN ('.sql_quote($rub_specialisee).')');
	$groupby = array('id_mot');
	$nb_forums = sql_countsel($from[0], $where, $groupby);

	// Decompte des associations avec des sites
	$from = array('spip_mots_syndic AS t1 JOIN spip_syndic AS t2 USING (id_syndic)');
	$where = array('t1.id_mot='.sql_quote($mot),
				   't2.id_rubrique NOT IN ('.sql_quote($rub_specialisee).')');
	$groupby = array('id_mot');
	$nb_syndics = sql_countsel($from[0], $where, $groupby);

	$nb = $nb_articles + $nb_breves + $nb_rubriques + $nb_forums + $nb_syndics;
//	echo 'idmot='.$mot.' art='.$nb_articles.' brv='.$nb_breves.' rub='.$nb_rubriques.' frm='.$nb_forums.' sit='.$nb_syndics.'<br />';
	
	return $nb;
}
// FIN du Filtre : mot_associations

// =======================================================================================================================================
// Filtres : module AGENDA
// =======================================================================================================================================
// Auteur: Smellup
// Fonction : regroupe les filtres permettant les affichages de l'agenda
// =======================================================================================================================================
//
include_spip('inc/sarkaspip_filtres_agenda');

// =======================================================================================================================================
// Filtres : module GALERIE
// =======================================================================================================================================
// Auteur: Smellup
// Fonction : regroupe les filtres permettant les affichages de la galerie
// =======================================================================================================================================
//
include_spip('inc/sarkaspip_filtres_galerie');
?>