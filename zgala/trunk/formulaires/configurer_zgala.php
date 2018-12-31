<?php
/**
 * Gestion du formulaire de configuration du plugin
 *
 * @package SPIP\ZGALA\ADMINISTRATION
 */
if (!defined("_ECRIRE_INC_VERSION")) return;


/**
 * Vérification des saisies : le numéro de layout est compris entre 1 et 40.
 *
 * @return array
 * 		Tableau des erreurs d'absence de langue saisie ou tableau vide si aucune erreur.
 */
function formulaires_configurer_zgala_verifier() {
	$erreurs = array();

	if ((intval(_request('layout')) < 1) or (intval(_request('layout')) > 40)) {
			$erreurs['layout'] = _T('zgala:form_erreur_saisie_layout');
	}

	return $erreurs;
}
