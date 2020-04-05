<?php

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

/**
 * Fonction d'appel pour le pipeline
 * @pipeline autoriser */
function zoundation_autoriser() {
}

/**
* Fonction d'autorisation pour tester si une personne est connectée ou non
* On utilise ce système pour éviter de générer trop de cache sur les tests
* simple.
*
* Il suffit ensuite de faire [(#AUTORISER{connecter}|oui) ... ] oui
* [(#AUTORISER{connecter}|non) ... ]
*
* @param mixed $faire
* @param mixed $type
* @param mixed $id
* @param mixed $qui
* @param mixed $opt
* @access public
*/
function autoriser_connecter_dist($faire, $type, $id, $qui, $opt) {
	return ($qui['id_auteur'] !== 0);
}

/**
 * Surcharger l'autorisation de suppression des adresses: Un auteur peu
 * supprimer une adresse si elle lui appartient et si elle n'est pas encore
 * utilisé
 *
 * @param mixed $faire
 * @param mixed $type
 * @param mixed $id
 * @param mixed $qui
 * @param mixed $opt
 * @access public
 * @return mixed
 */
function autoriser_adresse_supprimer($faire, $type, $id, $qui, $opt) {
	include_spip('action/editer_liens');
	$liens = objet_trouver_liens(array('adresse' => $id), '*', array('objet != '.sql_quote('auteur')));

	// Autoriser les admins
	$admin = ($qui['statut'] == '0minirezo' or $qui['restreint']);

	// On dois aussi tester les 6forums. S'il est l'auteur de l'adresse, il peux
	// la supprimer.
	include_spip('inc/session');
	$liens_auteur = objet_trouver_liens(array('adresse' => $id), array('auteur' => session_get('id_auteur')));

	return !count($liens) and ($admin or !count($liens_auteur));
}
