<?php

// Sécurité
if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/meta');

// Installation et mise à jour
function gn_upgrade($nom_meta_version_base, $version_cible){
	$version_actuelle = '0.0';
	
	// Historiquement, la version 0.1 correspondant à Aveline (< 1.0.0)
	if (isset($GLOBALS['meta']['aveline_base_version'])) {
		$version_actuelle = $GLOBALS['meta']['aveline_base_version'];
		effacer_meta('aveline_base_version');
	}
	
	if (
		(!isset($GLOBALS['meta'][$nom_meta_version_base]))
		|| (($version_actuelle = $GLOBALS['meta'][$nom_meta_version_base]) != $version_cible)
	){
		// On calcule le tableau des noisettes
		include_spip('base/abstract_sql');
		$noisettes = sql_allfetsel('*','spip_noisettes','1');
		
		// On remet au propre les parametres
		foreach ($noisettes as $cle => $noisette)
			$noisettes[$cle]['parametres'] = unserialize($noisette['parametres']);
		
		// On applique les mises à jour
		$noisettes = gn_maj_noisettes($noisettes,$version_actuelle);
		
		// Il faut serializer les paramètres avant mise en base
		foreach ($noisettes as $cle => $noisette)
			$noisettes[$cle]['parametres'] = serialize($noisette['parametres']);
		
		// On update la base
		sql_replace_multi('spip_noisettes',$noisettes);
		
		ecrire_meta($nom_meta_version_base, $version_actuelle=$version_cible, 'non');
	}

}

// Désinstallation
function gn_vider_tables($nom_meta_version_base){
	// On efface la version enregistrée
	effacer_meta($nom_meta_version_base);
}

// Mise à jour des noisettes

function gn_maj_noisettes($noisettes, $version_actuelle) {
	if (version_compare($current_version,'0.2','<')){
		foreach ($noisettes as $cle => $noisette)
			$noisettes[$cle]['parametres'] = str_replace('aveline_public:','gn_public:',$noisettes[$cle]['parametres']);
	}
	
	return $noisettes;
}

?>
