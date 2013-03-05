<?php
/**
 * Formulaire #FORMULAIRE_CONFIGURER_VISITEURS
 * Configure la possibilité pour les visiteurs d'avoir un compte sur le site
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * Fonction de chargement des valeurs du formulaire
 */
function formulaires_configurer_visiteurs_charger_dist(){
	$valeurs = array();
	$valeurs['accepter_visiteurs'] = $GLOBALS['meta']['accepter_visiteurs'];
	return $valeurs;
}

function formulaires_configurer_visiteurs_traiter_dist(){
	include_spip('inc/config');
	appliquer_modifs_config();
	
	include_spip('inc/invalideur');
	suivre_invalideur(1);
	
	$res['message_ok'] = _T('mediaspip_config:message_config_visiteurs_ok');
	return $res;
}
?>