<?php

// Sécurité
if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * Pipeline noizetier_config_export pour ajouter la version_base des noisettes au YAML d'export du noizetier
 *
 * @param array $config
 * @return array
 */

 function gn_noizetier_config_export($config){
	$config['gn_base_version'] = $GLOBALS['meta']['gn_base_version'];
	return $config;
}

/**
 * Pipeline noizetier_config_import pour traiter le tableau de noisettes au cas où les noisettes soient d'une ancienne version
 *
 * @param array $config
 * @return array
 */

 function gn_noizetier_config_import($config){
	$version_actuelle = NULL;
	if (isset($config['gn_base_version']))
		$version_actuelle = $config['gn_base_version'];
	elseif (isset($config['aveline_base_version']))
		$version_actuelle = $config['aveline_base_version'];
	
	if ($version_actuelle) {
		include_spip('base/gn_installation');
		$config['noisettes'] = gn_maj_noisettes($config['noisettes'], $version_actuelle);
	}
	
	return $config;
}


?>
