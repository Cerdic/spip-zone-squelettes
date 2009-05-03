<?php
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
// Filtre : fin_mois_precedent
// =======================================================================================================================================
// Auteur: Smellup
// Fonction : Calcul la date au format demande correspondant au dernier jour du mois precedent celui du timestamp en argument
// =======================================================================================================================================
//
function fin_mois_precedent($timestamp, $format) {
	if (!$timestamp) return;

	$date = mktime(0, 0, 0, date('m', $timestamp), 0, date('Y', $timestamp));
	return date($format, $date);
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
// Filtre : gravatar_url
// =======================================================================================================================================
// Auteur: Smellup
// Fonction : Retourne l'url du gravatar si l'email de l'auteur est enregistre sur gravatar.com
// =======================================================================================================================================
//
function gravatar_url($email = '', $taille = 32) {
	$url = '';
	if ($email != '') {
		$url = 'http://www.gravatar.com/avatar.php?gravatar_id='.md5($email).'&amp;size='.$taille.'&amp;rating=PG';
		// Ceci est le hash du gravatar bleu moche par defaut : on l'ignore
		$gravatar = recuperer_page($url);
		if (md5($gravatar) === '2bd0ca9726695502d06e2b11bf4ed555')
			$url = '';
	}
	return $url;
}
// FIN du Filtre : gravatar_url

// =======================================================================================================================================
// Filtre : libelle_statut
// =======================================================================================================================================
// Auteur: Smellup
// Fonction : Retourne le libelle multilangue du statut d'un auteur
// =======================================================================================================================================
//
function libelle_statut($statut) {
	return _T('sarkaspip:statut_'.$statut);
}
// FIN du Filtre : gravatar_url

// =======================================================================================================================================
// Filtre : lister_fonds
// =======================================================================================================================================
// Auteur: Smellup
// Fonction : Retourne la chaine des options du select de la liste des fonds
// =======================================================================================================================================
//
function lister_fonds($bidon, $image, $suffixe){
	if (function_exists('lire_config'))
		$f_selected = lire_config('sarkaspip_styles/fond_'.$image.$suffixe);

	$dir = sous_repertoire(_DIR_TMP, 'fonds');
	$saves = preg_files($dir);
	$options = '<option value="">--</option>';
	foreach ($saves as $_fichier) {
		$nom = basename($_fichier);
		$selected = ($_fichier == $f_selected) ? ' selected="selected"' : ''; 
		$options .= '<option value="' . $_fichier . '"' . $selected . '>' . $nom . '</option>';
	}

	return $options;
}
// FIN du Filtre : lister_fonds

// =======================================================================================================================================
// Filtre : afaire_liste_par_jalon
// =======================================================================================================================================
// Auteur: Smellup
// Fonction : Retourne les blocs d'affichage des tickets par jalon dans la page afaire
// =======================================================================================================================================
//
function afaire_liste_par_jalon($jalons) {
	$page = NULL;
	if ($jalons) {
		$liste = explode(":", $jalons);
		foreach($liste as $_jalon) {
			$page .= recuperer_fond('noisettes/afaire/inc_afaire_jalon', array('jalon' => $_jalon));
		}
	}
	return $page;
}
// FIN du Filtre : lister_fonds

// =======================================================================================================================================
// Filtre : afaire_tdm_par_jalon
// =======================================================================================================================================
// Auteur: Smellup
// Fonction : Retourne les blocs d'affichage des tickets par jalon dans la page afaire
// =======================================================================================================================================
//
function afaire_tdm_par_jalon($jalons) {
	$page = NULL;
	if ($jalons) {
		$liste = explode(":", $jalons);
		foreach($liste as $_jalon) {
			$page .= recuperer_fond('noisettes/afaire/inc_afaire_jalon', array('jalon' => $_jalon));
		}
	}
	return $page;
}
// FIN du Filtre : lister_fonds

// =======================================================================================================================================
// Filtre : afaire_avancement_jalon
// =======================================================================================================================================
// Auteur: Smellup
// Fonction : Retourne le pourcetage de tickets termines sur le nombre de tickets total du jalon
// =======================================================================================================================================
//
function afaire_avancement_jalon($jalon) {
	$valeur = 0;
	if ($jalon) {
		// Nombre total de tickets pour le jalon
		$select = array('t1.id_ticket');
		$from = array('spip_tickets AS t1');
		$where = array('t1.jalon='.sql_quote($jalon));
		$result = sql_select($select, $from, $where);
		$n1 = sql_count($result);
		
		if ($n1 != 0) {
			$where = array_merge($where, array(sql_in('t1.statut', array('resolu','ferme'))));
			$result = sql_select($select, $from, $where);
			$n2 = sql_count($result);
			$valeur = floor($n2*100/$n1);
		}
	}
	return $valeur;
}
// FIN du Filtre : lister_fonds

// =======================================================================================================================================
// Filtres : module AGENDA
// =======================================================================================================================================
// Auteur: Smellup
// Fonction : regroupe les filtres permettant les affichages de l'agenda
// =======================================================================================================================================
//
include_spip('inc/sarkaspip_filtres_agenda');
?>