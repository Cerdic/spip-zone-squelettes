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
	
	$nb = 0;
	
	$rub_agenda = calcul_rubrique('agenda');
	$rub_galerie = calcul_rubrique('galerie');

	// Decompte des associations avec des articles
	$query = "SELECT COUNT(DISTINCT id_mot) AS assocations FROM spip_mots_articles, spip_articles
			  WHERE spip_mots_articles.id_mot=$mot AND spip_mots_articles.id_article=spip_articles.id_article
			  AND spip_articles.id_rubrique!=$rub_agenda AND spip_articles.id_rubrique!=$rub_galerie";
	$result = spip_query($query);
	$nb_articles = 0;
	if ($row = @spip_fetch_array($result)) {
		$nb_articles = $row['assocations'];
	}

	// Decompte des associations avec des breves
	$query = "SELECT COUNT(DISTINCT id_mot) AS assocations FROM spip_mots_breves, spip_breves
			  WHERE spip_mots_breves.id_mot=$mot AND spip_mots_breves.id_breve=spip_breves.id_breve
			  AND spip_breves.id_rubrique!=$rub_agenda AND spip_breves.id_rubrique!=$rub_galerie";
	$result = spip_query($query);
	$nb_breves = 0;
	if ($row = @spip_fetch_array($result)) {
		$nb_breves = $row['assocations'];
	}

	// Decompte des associations avec des rubriques
	$query = "SELECT COUNT(DISTINCT id_mot) AS assocations FROM spip_mots_rubriques
			  WHERE spip_mots_rubriques.id_mot=$mot
			  AND spip_mots_rubriques.id_rubrique!=$rub_agenda AND spip_mots_rubriques.id_rubrique!=$rub_galerie";
	$result = spip_query($query);
	$nb_rubriques = 0;
	if ($row = @spip_fetch_array($result)) {
		$nb_rubriques = $row['assocations'];
	}

	// Decompte des associations avec des messages de forums
	$query = "SELECT COUNT(DISTINCT id_mot) AS assocations FROM spip_mots_forum, spip_forum
			  WHERE spip_mots_forum.id_mot=$mot AND spip_mots_forum.id_forum=spip_forum.id_forum
			  AND spip_forum.id_rubrique!=$rub_agenda AND spip_forum.id_rubrique!=$rub_galerie";
	$result = spip_query($query);
	$nb_forums = 0;
	if ($row = @spip_fetch_array($result)) {
		$nb_forums = $row['assocations'];
	}

	// Decompte des associations avec des sites
	$query = "SELECT COUNT(DISTINCT id_mot) AS assocations FROM spip_mots_syndic, spip_syndic
			  WHERE spip_mots_syndic.id_mot=$mot AND spip_mots_syndic.id_syndic=spip_syndic.id_syndic
			  AND spip_syndic.id_rubrique!=$rub_agenda AND spip_syndic.id_rubrique!=$rub_galerie";
	$result = spip_query($query);
	$nb_syndics = 0;
	if ($row = @spip_fetch_array($result)) {
		$nb_syndics = $row['assocations'];
	}

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