<?php
/**
 * Squelette SarkaSPIP v3
 * (c) 2005-2012 Licence GPL 3
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

function lister_couleurs_typo() {
	$couleurs = array();

	include_spip('base/sarkaspip_declarations');
	$config_typo = sarkaspip_declarer_config_typo();
	if (isset($config_typo['couleurs']))
		$couleurs = $config_typo['couleurs'];

	return $couleurs;
}

// =======================================================================================================================================
// Filtre : typo_couleur
// =======================================================================================================================================
// Auteur : Smellup, inspire du filtre original de A. Pierard
// Fonction : permettant de modifier la couleur du texte ou de l'introduction d'un article
// Utilisation :                  
// 	- pour le redacteur : [rouge]xxxxxx[/rouge]
// 	- pour le webmaster : [(#TEXTE|typo_couleur)]
// Néanmoins, par défaut ce filtre est appelé dans le pipeline post_propre
// =======================================================================================================================================
//
function filtre_typo_couleur_dist($texte) {

	include_spip('inc/config');

	// Acquérir les valeurs par défaut des couleurs typo
	include_spip('base/sarkaspip_declarations');
	$config_typo = sarkaspip_declarer_config_typo();
	$couleurs_texte = $config_typo['couleurs'];

	if ($couleurs_texte) {
		// Variables personnalisables par l'utilisateur
		// --> Activation (oui) ou desactivation (non) de la fonction
		$typo_couleur_active = (lire_config('sarkaspip_typo/coloration_active', 'non') == 'oui');
		// --> Nuances personnalisables par l'utilisateur
		$couleurs_utilisees = lire_config('sarkaspip_typo/couleurs');

		$recherche = array();
		$remplace = array();
		foreach ($couleurs_texte as $_id_couleur => $_defaut_couleur) {
			$recherche[$_id_couleur] = "/(\[${_id_couleur}\])(.*?)(\[\/${_id_couleur}\])/";
			if ($typo_couleur_active)
				$remplace[$_id_couleur] =
					"<span style=\"color:" .
					sinon($couleurs_utilisees[$_id_couleur], $_defaut_couleur) .
					";\">\\2</span>";
		}
		if (!$remplace)
			$remplace = "\\2";

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

// =======================================================================================================================================
// Filtre : afaire_liste_par_jalon
// =======================================================================================================================================
// Auteur: Smellup
// Fonction : Retourne les blocs d'affichage des tickets par jalon dans la page afaire
// =======================================================================================================================================
//
function afaire_liste_par_jalon($jalons) {
	$page = NULL;
	if (($jalons) && defined('_SARKASPIP_AFAIRE_JALONS_AFFICHES')) {
		$liste = explode(":", $jalons);
		$i =0;
		foreach($liste as $_jalon) {
			$i += 1;
			$page .= recuperer_fond('noisettes/afaire/inc_afaire_jalon', 
				array('jalon' => $_jalon, 'ancre' => 'ancre_jalon_'.strval($i)));
		}
	}
	return $page;
}
// FIN du Filtre : afaire_liste_par_jalon

// =======================================================================================================================================
// Filtre : afaire_tdm_par_jalon
// =======================================================================================================================================
// Auteur: Smellup
// Fonction : Retourne les blocs d'affichage des tickets par jalon dans la page afaire
// =======================================================================================================================================
//
function afaire_tdm_par_jalon($jalons) {
	$page = NULL;
	if (($jalons) && defined('_SARKASPIP_AFAIRE_JALONS_AFFICHES')) {
		$liste = explode(":", $jalons);
		$i =0;
		foreach($liste as $_jalon) {
			$i += 1;
			$nb = afaire_compteur_jalon($_jalon);
			$nb_str = ($nb == 0) ? _T('sarkaspip:0_ticket') : (($nb == 1) ? strval($nb).' '._T('sarkaspip:1_ticket') : strval($nb).' '._T('sarkaspip:n_tickets'));
			$page .= '<li><a href="#ancre_jalon_'.strval($i).'" title="'._T('sarkaspip:afaire_aller_jalon').'">'
				._T('sarkaspip:afaire_colonne_jalon').'&nbsp;&#171;&nbsp;'.$_jalon.'&nbsp;&#187;, '.$nb_str
				.'</a></li>';
		}
	}
	$nb = afaire_compteur_jalon();
	if ($nb > 0) {
		$nb_str = ($nb == 1) ? strval($nb).' '._T('sarkaspip:1_ticket') : strval($nb).' '._T('sarkaspip:n_tickets');
		$page .= '<li><a href="#ancre_jalon_non_planifie" title="'._T('sarkaspip:afaire_aller_jalon').'">&#171;&nbsp;'
			._T('sarkaspip:afaire_non_planifies').'&nbsp;&#187;, '.$nb_str
			.'</a></li>';
	}
	return $page;
}
// FIN du Filtre : afaire_tdm_par_jalon

// =======================================================================================================================================
// Filtre : afaire_compteur_jalon
// =======================================================================================================================================
// Auteur: Smellup
// Fonction : Retourne le nombre de tickets pour le jalon ou pour le jalon et le statut choisis
// =======================================================================================================================================
//
function afaire_compteur_jalon($jalon='', $statut='') {
	$valeur = 0;
	// Nombre total de tickets pour le jalon
	$select = array('t1.id_ticket');
	$from = array('spip_tickets AS t1');
	$where = array('t1.jalon='.sql_quote($jalon));
	if ($statut)
		$where = array_merge($where, array('t1.statut='.sql_quote($statut)));
	$result = sql_select($select, $from, $where);
	$valeur = sql_count($result);
	return $valeur;
}
// FIN du Filtre : afaire_compteur_jalon

// =======================================================================================================================================
// Filtre : afaire_avancement_jalon
// =======================================================================================================================================
// Auteur: Smellup
// Fonction : Retourne le pourcetage de tickets termines sur le nombre de tickets total du jalon
// =======================================================================================================================================
//
function afaire_avancement_jalon($jalon='') {
	$valeur = 0;
	// Nombre total de tickets pour le jalon
	$select = array('t1.id_ticket');
	$from = array('spip_tickets AS t1');
	$where = array('t1.jalon='.sql_quote($jalon));
	$result = sql_select($select, $from, $where);
	$n1 = sql_count($result);
	// Nombre de tickets termines pour le jalon
	if ($n1 != 0) {
		$where = array_merge($where, array(sql_in('t1.statut', array('resolu','ferme'))));
		$result = sql_select($select, $from, $where);
		$n2 = sql_count($result);
		$valeur = floor($n2*100/$n1);
	}
	return $valeur;
}
// FIN du Filtre : afaire_avancement_jalon

// =======================================================================================================================================
// Filtre : afaire_ticket_existe
// =======================================================================================================================================
// Auteur: Smellup
// Fonction : Retourne l'info qu'au moins un ticket a ete cree
// =======================================================================================================================================
//
function afaire_ticket_existe($bidon) {
	$existe = false;
	// Test si la table existe
	$table = sql_showtable('spip_tickets', true);
	if ($table) {
		// Nombre total de tickets
		$from = array('spip_tickets AS t1');
		$where = array();
		$result = sql_countsel($from, $where);
		// Nombre de tickets termines pour le jalon
		if ($result >= 1)
			$existe = true;
	}
	return $existe;
}
// FIN du Filtre : afaire_ticket_existe

// =======================================================================================================================================
// Filtre : statut_forum
// =======================================================================================================================================
// Auteur: Smellup
// Fonction : Retourne le statut d'un forum cad non autorise, ouvert, ferme
// =======================================================================================================================================
//
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

	$ok = true;
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

	$ok = true;
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

function afficher_meta($env) {
	$env = str_replace(array('&quot;', '&#039;'), array('"', '\''), $env);
	if (is_array($env_tab = @unserialize($env))) {
		$env = $env_tab;
	}
	if (!is_array($env)) {
		return '';
	}
	$style = " style='border:1px solid #ddd;'";
	$res = "<table style='border-collapse:collapse;'>\n";
	foreach ($env as $nom => $val) {
		if (is_array($val) || is_array(@unserialize($val))) {
			$val = afficher_meta($val);
		}
		else {
			$val = entites_html($val);
		}
		$res .= "<tr>\n<td$style><strong>". entites_html($nom).
				"&nbsp;:&nbsp;</strong></td><td$style>" .$val. "</td>\n</tr>\n";
	}
	$res .= "</table>";
	return $res;
}


function inscription_possible() {
	global $visiteur_session;

	// fournir le mode de la config ou tester si l'argument du formulaire est un mode accepte par celle-ci
	include_spip('inc/filtres');
	$mode = tester_config(0, '');

	// pas de formulaire si le mode est interdit
	if (!$mode)
		return false;

	// pas de formulaire si on a déjà une session avec un statut égal ou meilleur au mode
	if(isset($visiteur_session['statut']) && ($visiteur_session['statut'] <= $mode))
		return false;

	return true;
}


function abonnement_possible($plugin) {
	$retour = false;

	$informer = chercher_filtre('info_plugin');
	$plugin_actif = ($informer($plugin, 'est_actif') == 1);

	if ($plugin_actif) {
		if (strtolower($plugin) == 'mailsubscribers') {
			$retour = true;
		}
	}

	return $retour;
}


// =======================================================================================================================================
// Filtres : module AGENDA
// =======================================================================================================================================
// Auteur: Smellup
// Fonction : regroupe les filtres permettant les affichages de l'agenda
// =======================================================================================================================================
//
include_spip('inc/sarkaspip_filtres_agenda');


?>
