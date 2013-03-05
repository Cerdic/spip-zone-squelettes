<?php
/**
 * Formulaire #FORMULAIRE_CONFIGURER_VOTRE_SITE
 * Configure les informations de base du site
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * Fonction de chargement des valeurs du formulaire
 */
function formulaires_configurer_votre_site_charger_dist(){
	/**
	 * Vérification si la configuration du site actuelle
	 * permet bien de choisir des langues
	 */
	$valeurs['_adresse_site'] = entites_html($GLOBALS['meta']["adresse_site"]);
	$valeurs['_nom_site'] = entites_html($GLOBALS['meta']["nom_site"]);
	$valeurs['_email_webmaster'] = entites_html($GLOBALS['meta']["email_webmaster"]);
	$valeurs['_descriptif_site'] = entites_html($GLOBALS['meta']["descriptif_site"]);

	return $valeurs;
}

function formulaires_configurer_votre_site_traiter_dist(){
	include_spip('inc/config');
	appliquer_modifs_config();

	include_spip('inc/invalideur');
	suivre_invalideur(1);

	$res['message_ok'] = _T('mediaspip_config:message_config_site_ok');
	return $res;
}
?>