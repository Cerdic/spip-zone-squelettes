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
 * Fonction de verification du formulaire de configuration CFG
 * 
 */
function cfg_config_mediaspip_home_verifier(&$cfg){
	$numeriques = array('document_largeur_maximale_exergue','document_hauteur_maximale_exergue','nb_sites_nav','nb_syndics_nav');
	foreach($numeriques as $numerique){
		if($cfg->val[$numerique] && !ctype_digit($cfg->val[$numerique])){
			$erreur[$numerique] = _T('mediaspip_core:erreur_valeur_int');
		}
	}
	
	$inf_cents = array('nb_sites_nav','nb_syndics_nav');
	foreach($inf_cents as $inf_cent){
		if(!$erreur[$inf_cent] && $cfg->val[$inf_cent] && ($cfg->val[$inf_cent] > 100)){
			$erreur[$inf_cent] = _T('mediaspip_core:erreur_valeur_int_inf',array('nb'=>'100'));
		}
	}
	
	$inf_milles = array('document_largeur_maximale_exergue','document_hauteur_maximale_exergue');
	foreach($inf_milles as $inf_mille){
		if(!$erreur[$inf_mille] && $cfg->val[$inf_mille] && ($cfg->val[$inf_mille] > 1000)){
			$erreur[$inf_mille] = _T('mediaspip_core:erreur_valeur_int_inf',array('nb'=>'1000'));
		}
	}
	
	return $erreur;
}

/**
 * 
 * Fonction appelée au moment du traitement du formulaire
 * On invalide le cache tout simplement
 * 
 */
function cfg_config_mediaspip_home_traiter(&$cfg){
	include_spip('inc/invalideur');
	suivre_invalideur(1);
}
?>