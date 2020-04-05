<?php
/**
 * Plugin / Squelettes Gribouille
 * © Fil
 * Distribue sous licence GNU/GPL
 */

if (!defined("_ECRIRE_INC_VERSION")) {
	return;
}

// si le plugin Autorité est installé, c'est lui qui gère les droits
include_spip('inc/filtres');
$f = chercher_filtre('info_plugin');
if ($f('autorite', 'est_actif')) {
	return;
}

function gribouille_autoriser() { }

/**
 * Modification de l'autorisation de modifier un article
 * - On se base d'abord sur l'autorisation de base de SPIP
 * - Sinon on se base sur la configuration du plugin
 *
 * @param object $faire
 * @param object $quoi
 * @param object $id
 * @param object $qui
 * @param object $opts
 *
 * @return boolean
 */
if (!function_exists('autoriser_article_modifier')) {
	function autoriser_article_modifier($faire, $quoi, $id, $qui, $opts) {
		$autorise = false;
		if (autoriser_article_modifier_dist($faire, $quoi, $id, $qui, $opts)) {
			return autoriser_article_modifier_dist($faire, $quoi, $id, $qui, $opts);
		}
		if (function_exists('lire_config')) {
			$secteur_wiki = lire_config('gribouille/secteur_wiki');
			$id_secteur   = sql_getfetsel('id_secteur', 'spip_articles', 'id_article=' . intval($id));
			if ($id_secteur == $secteur_wiki) {
				// Traitement spécifique pour la valeur 'tous'
				if (in_array('tous', lire_config('gribouille/ecrire_statuts', array()))) {
					return true;
				}
				// Autorisation par statut
				$autorise = in_array($qui['statut'], lire_config('gribouille/ecrire_statuts', array('0minirezo')));
			}
		}
		else {
			return autoriser('modifier', 'article', $id, $qui, $opts);
		}

		return $autorise;
	}
}
else {
	spip_log('fonction autoriser_article_modifier() déjà déclarée !', 'gribouille' . _LOG_CRITIQUE);
}

/**
 * Modification de l'autorisation de publier un article ou une rubrique dans une autre
 * - On se base d'abord sur l'autorisation de base de SPIP
 * - Sinon on se base sur la configuration du plugin
 *
 * @param object $faire
 * @param object $quoi
 * @param object $id
 * @param object $qui
 * @param object $opts
 *
 * @return boolean
 */
if (!function_exists('autoriser_rubrique_publierdans')) {
	function autoriser_rubrique_publierdans($faire, $quoi, $id, $qui, $opts) {
		$autorise = false;
		if (autoriser_rubrique_publierdans_dist($faire, $quoi, $id, $qui, $opts)) {
			return autoriser_rubrique_publierdans_dist($faire, $quoi, $id, $qui, $opts);
		}
		if (function_exists('lire_config')) {
			$secteur_wiki = lire_config('gribouille/secteur_wiki');
			$id_secteur   = sql_getfetsel('id_secteur', 'spip_rubriques', 'id_rubrique=' . intval($id));
			if ($id_secteur == $secteur_wiki) {
				// Traitement spécifique pour la valeur 'tous'
				if (in_array('tous', lire_config('gribouille/ecrire_statuts', array()))) {
					return true;
				}
				// Autorisation par statut
				$autorise = in_array($qui['statut'], lire_config('gribouille/ecrire_statuts', array('0minirezo')));
			}
		}
		else {
			return autoriser('publier_dans', 'rubrique', $id, $qui, $opts);
		}

		return $autorise;
	}
}
else {
	spip_log('fonction autoriser_rubrique_publierdans() déjà déclarée !', 'gribouille' . _LOG_CRITIQUE);
}

/**
 * Modification de l'autorisation de voir les rubriques (utilisées dans le privé)
 * Nous l'utilisons au moment du choix du squelette dans le pipeline styliser
 * On renvoie une erreur 404 si nous ne sommes pas autorisé.
 * - On vérifie tout d'abord si nous sommes autorisé à plublier dans cette rubrique
 * Si oui, on passe outre la configuration
 * - On vérifie ensuite si on est autorisé dans la config du plugin
 *
 * @param string $faire L'action à réaliser
 * @param string $quoi  L'objet sur lequel on réalise cette action
 * @param int    $id    L'id de l'objet en question
 * @param array  $qui   L'array des infos de session de l'auteur connecté
 * @param object $opts
 *
 * @return boolean
 */
if (!function_exists('autoriser_rubrique_voir')) {
	function autoriser_rubrique_voir($faire, $quoi, $id, $qui, $opts) {
		$autorise = false;
		if (autoriser('publierdans', 'rubrique', $id, $qui, $opts)) {
			return autoriser('publierdans', 'rubrique', $id, $qui, $opts);
		}
		if (function_exists('lire_config')) {
			$secteur_wiki = lire_config('gribouille/secteur_wiki');
			$id_secteur   = sql_getfetsel('id_secteur', 'spip_rubriques', 'id_rubrique=' . intval($id));
			if ($id_secteur == $secteur_wiki) {
				// Traitement spécifique pour la valeur 'tous'
				if (in_array('tous', lire_config('gribouille/voir_statuts', array()))) {
					return true;
				}
				// Autorisation par statut
				$autorise = in_array($qui['statut'], lire_config('gribouille/voir_statuts', array('0minirezo')));
			}
		}
		else {
			return autoriser('voir', 'rubrique', $id, $qui, $opts);
		}

		return $autorise;
	}
}
else {
	spip_log('fonction autoriser_rubrique_voir() déjà déclarée !', 'gribouille' . _LOG_CRITIQUE);
}

