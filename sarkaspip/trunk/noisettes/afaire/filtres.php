<?php
/**
 * Squelette SarkaSPIP v4
 * (c) 2005-2012 Licence GPL 3
 */

if (!defined("_ECRIRE_INC_VERSION")) return;


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
			$page .= recuperer_fond('noisettes/afaire/jalon',
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