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
function cfg_config_mediaspip_squelettes_verifier(&$cfg){
	$numeriques = array(
					'logo_largeur',
					'logo_hauteur',
					'logo_objets_largeur',
					'nb_syndics_nav',
					'vignette_grande_largeur',
					'vignette_grande_hauteur',
					'vignettes_nav_largeur',
					'vignettes_nav_hauteur',
					'vignettes_nav_nb',
					'vignettes_download_largeur',
					'vignettes_download_hauteur'
	);
	
	foreach($numeriques as $numerique){
		if($cfg->val[$numerique] && !ctype_digit($cfg->val[$numerique])){
			$erreur[$numerique] = _T('mediaspip_core:erreur_valeur_int');
		}
	}
	
	$inf_30s = array('vignettes_nav_nb');
	foreach($inf_30s as $inf_30){
		if(!$erreur[$inf_30] && $cfg->val[$inf_30] && ($cfg->val[$inf_30] > 30)){
			$erreur[$inf_30] = _T('mediaspip_core:erreur_valeur_int_inf',array('nb'=>'30'));
		}
	}
	
	$inf_cents = array('nb_sites_nav','nb_syndics_nav');
	foreach($inf_cents as $inf_cent){
		if(!$erreur[$inf_cent] && $cfg->val[$inf_cent] && ($cfg->val[$inf_cent] > 100)){
			$erreur[$inf_cent] = _T('mediaspip_core:erreur_valeur_int_inf',array('nb'=>'100'));
		}
	}
	
	$inf_milles = array(
					'logo_hauteur',
					'logo_objets_largeur',
					'logo_objets_hauteur',
					'vignette_grande_largeur',
					'vignette_grande_hauteur',
					'vignettes_nav_largeur',
					'vignettes_nav_hauteur',
					'vignettes_download_largeur',
					'vignettes_download_hauteur'
	);
	foreach($inf_milles as $inf_mille){
		if(!$erreur[$inf_mille] && $cfg->val[$inf_mille] && ($cfg->val[$inf_mille] > 1000)){
			$erreur[$inf_mille] = _T('mediaspip_core:erreur_valeur_int_inf',array('nb'=>'1000'));
		}
	}
	
	$inf_2milles = array('logo_largeur');
	foreach($inf_2milles as $inf_2mille){
		if(!$erreur[$inf_2mille] && $cfg->val[$inf_2mille] && ($cfg->val[$inf_2mille] > 2000)){
			$erreur[$inf_2mille] = _T('mediaspip_core:erreur_valeur_int_inf',array('nb'=>'2000'));
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
function cfg_config_mediaspip_squelettes_traiter(&$cfg){
	include_spip('inc/invalideur');
	suivre_invalideur(1);
}
?>