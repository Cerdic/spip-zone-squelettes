<?php
/**
 * Plugin Mediaspip Core
 * 
 * © 2010-2011 kent1 (kent1@arscenic.info)
 * Distribué sous licence GNU/GPL v3
 * 
 */
if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * 
 * Fonction appelée au moment du traitement du formulaire
 * On invalide le cache tout simplement
 * 
 */
function cfg_config_mediaspip_medias_traiter(&$cfg){
	include_spip('inc/invalideur');
	suivre_invalideur(1);
}
?>