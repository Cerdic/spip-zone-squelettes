<?php

/**
 * pipeline zengarden_activer_theme pour charger une config_noizetier associée à un thème
 *
 * @param array $flux
 * @return array
 */
function spipclear_zengarden_activer_theme($flux){

	$config_defaut = _DIR_PLUGIN_SPIPCLEAR . '/config_noizetier/spipclear.yaml';
	$config_theme = $flux['args']['dir'] . '/config_noizetier/theme.yaml';
	$config_tmp = _DIR_TMP . 'spipclear_noizetier.yaml';

	if ($yaml = spipclear_get_config_noizetier($config_theme)) {
		include_spip('inc/noizetier');
		if ($flux['args']['action'] == 'activer') {
			// exporter la config en place et la sauver dans tmp/spipclear_noizetier.yaml
			include_spip('inc/filtres');
			$export['nom'] = $GLOBALS['meta']['nom_site'].' - '.affdate(date('Y-m-d'));
			$export = yaml_encode(array_merge($export,noizetier_tableau_export()));
			ecrire_fichier($config_tmp, $export);
			// importer la config du theme
			noizetier_importer_configuration('remplacer', 'non', $yaml);
		}
		if ($flux['args']['action'] == 'effacer') {
			// importer la config sauvée dans tmp/ avant activation du theme
			if ($import = spipclear_get_config_noizetier($config_tmp)) {
				noizetier_importer_configuration('remplacer', 'non', $import);
			} elseif ($import = spipclear_get_config_noizetier($config_defaut)) {
				// sinon importer la conifg par défaut de spipclear
				noizetier_importer_configuration('remplacer', 'non', $import);
			}
		}
	}
	return $flux;
}

/**
 * lire un fichier de configuration yaml exportée par le noizetier
 *
 * @param string $fichier
 * @return array ou false
 */
function spipclear_get_config_noizetier($fichier){
	if (file_exists($fichier)) {
		lire_fichier($fichier, $data);
		if ($data) {
			include_spip('base/abstract_sql');
			include_spip('inc/yaml');
			$yaml = yaml_decode($data);
			if (is_array($yaml))
				return $yaml;
		}
	}
	return false;
}

?>