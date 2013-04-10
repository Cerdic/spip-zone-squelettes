<?php
/**
 * Plugin Mediaspip Core
 * 
 * © 2010-2011 kent1 (kent1@arscenic.info)
 * Distribué sous licence GNU/GPL v3
 * 
 * Action de vérification de la présence des fichiers originaux
 */
if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * Vérifie qu'il n'y a pas de documents originaux qui ont été perdus
 * 
 * @return
 */
function action_mediaspip_verifier_originaux_dist() {
	$verifier_originaux = charger_fonction('mediaspip_verifier_originaux','inc');
	$verifier_originaux();
}

?>