<?php
/**
 * Plugin Mediaspip Core
 * 
 * Auteurs :
 * kent1 (http://www.kent1.info - kent1@arscenic.info)
 *
 * © 2010-2012 - Distribue sous licence GNU/GPL
 * 
 * Fichier des fonctions spécifiques du plugin (utilisées à chaque calcul de pages)
 */
if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * Traduction des statuts d'auteurs en chaine lisible
 *
 * @param string $statut
 */
function ms_traduire_statut($statut){
	if ($t = array_search($statut, $GLOBALS['liste_des_statuts'])){
		return _T('mediaspip_core:statut_'.$t);
	}
	return;
}

/**
 * Définition du critère notation si le plugin notation n'est pas dispo
 */
if (!function_exists('critere_notation')){
	function critere_notation_dist($idb, &$boucles, $crit){}
}

/**
 * Définition du critère branche_complete si le plugin polyhierarchie n'est pas dispo
 */
if(!function_exists('critere_branche_complete_dist')){
	function critere_branche_complete_dist($idb, &$boucles, $crit){}
}

/**
 * Définition du critère mesfavoris si le plugin mes favoris n'est pas dispo
 */
if (!function_exists('critere_mesfavoris_dist')){
	function critere_mesfavoris_dist($idb, &$boucles, $crit){}
}

/**
 * Définition du critère id_licence si le plugin licences n'est pas dispo
 */
if (!defined('_DIR_PLUGIN_LICENCE') && !function_exists('critere_id_licence_dist') && !function_exists('critere_id_licence')){
	function critere_id_licence_dist($idb, &$boucles, $crit){}
}

if (!function_exists('inc_vignette')){
	function inc_vignette($ext, $size=true, $loop = true) {
		if(test_espace_prive()){
			$f = include_spip('inc/vignette');
			return inc_vignette_dist($ext, $size, $loop);
		}
		if (!$ext)
			$ext = 'txt';

		// Chercher la vignette correspondant a ce type de document
		// dans les vignettes persos, ou dans les vignettes standard
		if (
		# installation dans un dossier /vignettes personnel, par exemple /squelettes/vignettes
		!@file_exists($v = find_in_path("images/media_sans_logo_".$ext.".png"))
		AND !@file_exists($v = find_in_path("images/media_sans_logo_".$ext.".gif"))
		)
			if ($loop){
				$f = charger_fonction('vignette','inc');
				$v = $f('defaut', false, $loop=false);
			}
			else
				$v = false; # pas trouve l'icone de base

		if (!$size) return $v;

		if ($size = @getimagesize($v)) {
			$largeur = $size[0];
			$hauteur = $size[1];
		}

		return array($v, $largeur, $hauteur);
	}
}

function has_cookie_admin(){
	return isset($_COOKIE['spip_admin']) ? $_COOKIE['spip_admin'] : false;
}
?>