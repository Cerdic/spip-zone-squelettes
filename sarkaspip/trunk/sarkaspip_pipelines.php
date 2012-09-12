<?php

// Pipeline "mes_fichiers_a_sauver" permettant de rajouter des fichiers � sauvegarder dans le plugin Mes Fichiers 2
function SarkaSpip_mes_fichiers_a_sauver($flux){
	$tmp_fonds = defined('_DIR_TMP') ? _DIR_TMP.'fonds/': _DIR_RACINE.'tmp/fonds/';
	$tmp_styles = defined('_DIR_TMP') ? _DIR_TMP.'cfg/': _DIR_RACINE.'tmp/cfg/';

	// le repertoire des images de fonds pour les styles
	if (@is_dir($tmp_fonds))
		$flux[] = $tmp_fonds;
	// le repertoire sauvegardes du cfg des styles
	if (@is_dir($tmp_styles))
		$flux[] = $tmp_styles;

	spip_log('*** SarkaSpip_mes_fichiers_a_sauver ***');
	spip_log($flux);
	return $flux;
}

// Pipeline "zengarden_activer_theme" permettant d'effectuer les traitements d'activation d'un theme lies a Sarka-SPIP
function SarkaSpip_zengarden_activer_theme($flux){
	$dir_cfg = $flux['args']['dir'] . '/cfg';
	$cfg = preg_files($dir_cfg);

	// On sauvegarde des valeurs actuelles pour un eventuel rappel
	$dir_cfg = sous_repertoire(_DIR_TMP,"cfg");
	$dir_cfg = sous_repertoire(_DIR_TMP,"themes");
	$fonds = array();
	foreach ($cfg as $_fichier_cfg) {
		$fonds[] = basename($_fichier_cfg, '.txt');
	}
	include_spip('inc/sarkaspip_filtres');
	$ok = sauvegarder_fonds($fonds, $dir_cfg, 'theme');

	// On ecrit la nouvelle configuration n�cessaire au theme choisi
	$flux['data'] = true;
	foreach ($cfg as $_fichier_cfg) {
		lire_fichier($_fichier_cfg, $tableau);
		$fond = basename($_fichier_cfg, '.txt');
		ecrire_config($fond, $tableau);
	}
	return $flux;
}

// Pipeline "zengarden_effacer_theme" permettant d'effectuer les traitements d'effacement d'un theme lies a Sarka-SPIP
function SarkaSpip_zengarden_effacer_theme($flux){
	$dir_cfg = $flux['args']['dir'] . '/cfg';
	$cfg = preg_files($dir_cfg);
	$fichiers = array();
	$flux['data'] = true;
	foreach ($cfg as $_fichier_cfg) {
		$fond = basename($_fichier_cfg, '.txt');
		effacer_config($fond);
		$fichiers[] = _DIR_TMP . 'themes/cfg/' . $fond . '.txt';
	}
	include_spip('inc/sarkaspip_filtres');
	$ok = restaurer_fonds($fichiers);
	return $flux;
}
?>
