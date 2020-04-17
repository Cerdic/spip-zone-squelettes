<?php
if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

function ressourcotheque_autoriser() {
}
//Pouvoir modifier son profil
/**
 * Autorisation de modifier un auteur
 *
 * Attention tout depend de ce qu'on veut modifier. Il faut être au moins
 * rédacteur, mais on ne peut pas promouvoir (changer le statut) un auteur
 * avec des droits supérieurs au sien.
 *
 * @param  string $faire Action demandée
 * @param  string $type Type d'objet sur lequel appliquer l'action
 * @param  int $id Identifiant de l'objet
 * @param  array $qui Description de l'auteur demandant l'autorisation
 * @param  array $opt Options de cette autorisation
 * @return bool          true s'il a le droit, false sinon
 **/
function autoriser_auteur_modifier($faire, $type, $id, $qui, $opt) {
	// Un redacteur, un admin restreint ou un visiteur peut modifier ses propres donnees mais ni son login/email
	if ($qui['statut'] == '1comite'
		or $qui['statut'] == '6forum'
		or (isset($qui['restreint']) and $qui['restreint'])) {
		if (!empty($opt['webmestre'])) {
			return false;
		} elseif (
			!empty($opt['statut'])
			or !empty($opt['restreintes'])
			or !empty($opt['email'])
		) {
			return false;
		} elseif ($id == $qui['id_auteur']) {
			return true;
		} else {
			return false;
		}
	}


	// Un admin complet fait ce qu'il veut
	// sauf se degrader
	if ($id == $qui['id_auteur'] && (isset($opt['statut']) and $opt['statut'])) {
		return false;
	} elseif (isset($opt['webmestre'])
				and $opt['webmestre']
				and (defined('_ID_WEBMESTRES')
				or !autoriser('webmestre'))) {
		// et toucher au statut webmestre si il ne l'est pas lui meme
		// ou si les webmestres sont fixes par constante (securite)
		return false;
	} // et modifier un webmestre si il ne l'est pas lui meme
	elseif (intval($id) and autoriser('webmestre', '', 0, $id) and !autoriser('webmestre')) {
		return false;
	} else {
		return true;
	}
}
