<?php

// Sécurité
if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/meta');

// Installation et mise à jour
function aveline_upgrade($nom_meta_version_base, $version_cible){
	$version_actuelle = '0.0';
	if (
		(!isset($GLOBALS['meta'][$nom_meta_version_base]))
		|| (($version_actuelle = $GLOBALS['meta'][$nom_meta_version_base]) != $version_cible)
	){
		ecrire_meta($nom_meta_version_base, $version_actuelle=$version_cible, 'non');
	}

}

// Désinstallation
function aveline_vider_tables($nom_meta_version_base){
	// On efface la version enregistrée
	effacer_meta($nom_meta_version_base);
}

?>
