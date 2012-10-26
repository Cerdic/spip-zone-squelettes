<?php
/**
 * Squelette SarkaSPIP v4
 * (c) 2005-2012 Licence GPL 3
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

// TODO : conditionner a l'existence du plugin tickets
include_spip("noisettes/afaire/filtres");

/**
 * Tester si on doit rediriger une rubrique vers son article orphelin
 * - si reglage active dans la configuration
 * - si la rubrique ne contient qu'un article, aucune sous-rubrique ni documents
 *
 * @param $id_rubrique
 * @return string|int
 */
function sarkaspip_test_si_redirection_article_solitaire($id_rubrique){
	include_spip("inc/config");
	$serveur = '';

	// si reglage pas active, renvoyer rien (pas de redirection)
	if (lire_config('sarkaspip_menus/option_rubriques',0)!=2)
		return "";

	$trouver_table = charger_fonction('trouver_table', 'base');
	include_spip('public/compiler');
	include_spip('public/composer');
	// si plus d'un article publie, pas de redirection (on prend les 2 premiers, permet d'avoir l'id de l'article unique si besoin
	// il faut passer par une boucle compilateur pour avoir les conditions de statut publie
	if (!$desc = $trouver_table("spip_articles", $serveur))
		return "";
	$id_table_objet = "id_article";
	$id_table = $table_objet = "articles";
	$boucle = new Boucle();
	$boucle->show = $desc;
	$boucle->nom = 'articles_publies';
	$boucle->id_boucle = $id_table;
	$boucle->id_table = $id_table;
	$boucle->sql_serveur = $serveur;
	$boucle->select[] = $id_table_objet;
	$boucle->from[$table_objet] = "spip_articles";
	$boucle->where[] = $id_table.".id_rubrique=".intval($id_rubrique);
	$boucle->limit = "0,2";
	instituer_boucle($boucle, false);
	$res = calculer_select($boucle->select,$boucle->from,$boucle->from_type,$boucle->where,$boucle->join,$boucle->group,$boucle->order,$boucle->limit,$boucle->having,$table_objet,$id_table,$serveur);
	$a = array();
	while ($row = sql_fetch($res))
		$a[] = $row;
	if (count($a)!=1)
		return "";

	// si une sous-rubrique publie, pas de redirection
	// il faut passer par une boucle compilateur pour avoir les conditions de statut publie
	if (!$desc = $trouver_table("spip_rubriques", $serveur))
		return "";
	$id_table_objet = "id_rubrique";
	$id_table = $table_objet = "rubriques";
	$boucle = new Boucle();
	$boucle->show = $desc;
	$boucle->nom = 'sousrubriques_publies';
	$boucle->id_boucle = $id_table;
	$boucle->id_table = $id_table;
	$boucle->sql_serveur = $serveur;
	$boucle->select[] = $id_table_objet;
	$boucle->from[$table_objet] = "spip_rubriques";
	$boucle->where[] = $id_table.".id_parent=".intval($id_rubrique);
	$boucle->limit = "0,1";
	instituer_boucle($boucle, false);
	$res = calculer_select($boucle->select,$boucle->from,$boucle->from_type,$boucle->where,$boucle->join,$boucle->group,$boucle->order,$boucle->limit,$boucle->having,$table_objet,$id_table,$serveur);
	if (sql_fetch($res))
		return "";

	if (sql_countsel("spip_documents_liens","objet=".sql_quote('rubrique')." AND id_objet=".intval($id_rubrique)))
		return "";

	return intval(reset(reset($a)));
}

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
// Filtre : libelle_statut
// =======================================================================================================================================
// Auteur: Smellup
// Fonction : Retourne le libelle multilangue du statut d'un auteur
// =======================================================================================================================================
//
function libelle_statut($statut) {
	return _T('sarkaspip:statut_'.$statut);
}
// FIN du Filtre : libelle_statut

function statut_forum($id_article) {

	$id = intval($id_article);
	$statut = 'non_autorise';

	// Forum active ou pas ?
	$accepter = 'non';
	$select = array('t1.accepter_forum');
	$from = array('spip_articles AS t1');
	$where = array('t1.id_article='.sql_quote($id));
	$result = sql_select($select, $from, $where);
	if ($row = sql_fetch($result)) 
		$accepter = $row['accepter_forum'];

	// Nombre messages de forum de l'article
	$from = array('spip_forum AS t1');
	$where = array('t1.id_objet='.sql_quote($id), 't1.objet='.sql_quote('article'));
	$nb = sql_countsel($from, $where);
	// Nombre de tickets termines pour le jalon
	if ($nb >= 1)
		$statut = ($accepter == 'non') ? 'ferme' : 'ouvert';
	else
		if ($accepter != 'non') $statut = 'ouvert';
	return $statut;
}
// FIN du Filtre : statut_forum

// =======================================================================================================================================
// Filtre : sauvegarder_fonds
// =======================================================================================================================================
// Auteur: Smellup
// Fonction : Cree les sauvegardes d'une liste de fonds suivant un format et dans un repertoire donne 
// =======================================================================================================================================
//
function sauvegarder_fonds($fonds, $ou, $mode='maintenance') {
	include_spip('inc/config');

	$dir = $ou;
	foreach ($fonds as $_fond) {
		if ($mode == 'maintenance') {
			$dir = sous_repertoire($ou, $_fond);
			$nom = $_fond . "_" . date("Ymd_Hi") . ".txt";
		}
		else {
			$nom = $_fond . ".txt";
		}
		$f = $dir . $nom;
		$ok = ecrire_fichier($f, serialize(lire_config($_fond)));
	}

	return $ok;
}
// FIN du Filtre : sauvegarder_fonds

// =======================================================================================================================================
// Filtre : restaurer_fonds
// =======================================================================================================================================
// Auteur: Smellup
// Fonction : Restaure les sauvegardes d'une liste de fonds suivant un format et dans un repertoire donne 
// =======================================================================================================================================
//
function restaurer_fonds($fichiers) {
	include_spip('inc/config');

	foreach ($fichiers as $_fichier) {
		lire_fichier($_fichier,$tableau);
		$fond = basename($_fichier, '.txt');
		$ok = ecrire_config($fond, $tableau);
	}

	return $ok;
}
// FIN du Filtre : restaurer_fonds

// =======================================================================================================================================
// Filtre : nettoyer_titre_sujet
// =======================================================================================================================================
// Auteur: Smellup 
// Fonction : Restaure le titre exact du sujet en supprimant le préfixe éventuel
// =======================================================================================================================================
//
function nettoyer_titre_sujet($titre, $resolu='') {
	$titre_nettoye = trim(preg_replace(',^\[(annonce|epingle)\](&nbsp;)*,UimsS', '', $titre));
	$titre_nettoye = trim(preg_replace(',_(verrouille|resolu)_,UimsS', '', $titre_nettoye));
	if ($resolu) $titre_nettoye = _T('sarkaspip:titre_sujet_resolu', array('titre' => $titre_nettoye)); 
	return $titre_nettoye;
}
// FIN du Filtre : nettoyer_titre_sujet



// =======================================================================================================================================
// Filtre : afficher_config
// =======================================================================================================================================
// Auteur: Smellup
// Fonction : Affiche la meta de configuration demandee sous un format lisible (remplace #CFG_ARBO)
// =======================================================================================================================================
//
function afficher_config($meta) {
	$texte ='';
	if ($meta) {
		$f = chercher_filtre('foreach');
		$texte = $f(lire_config($meta));
	}
	return $texte;
}
// FIN du Filtre : afficher_config


// =======================================================================================================================================
// Filtres : module AGENDA
// =======================================================================================================================================
// Auteur: Smellup
// Fonction : regroupe les filtres permettant les affichages de l'agenda
// =======================================================================================================================================
//
include_spip('inc/sarkaspip_filtres_agenda');


?>
