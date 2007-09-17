<?php
// =======================================================================================================================================
// Balise : #PLUGIN
// =======================================================================================================================================
// Auteur: Smellup
// Fonction : retourne une info d'un plugin actif donne
// =======================================================================================================================================
//
include_spip('inc/plugin');

function balise_PLUGIN_dist($p) {
	$plugin = interprete_argument_balise(1,$p);
	$plugin = isset($plugin) ? str_replace('\'', '"', $plugin) : '""';
	$type_info = interprete_argument_balise(2,$p);
	$type_info = isset($type_info) ? str_replace('\'', '"', $type_info) : '"est_actif"';

	$p->code = 'calcul_info_plugin('.$plugin.', '.$type_info.')';
	$p->interdire_scripts = false;
	return $p;
}

function calcul_info_plugin($plugin, $type_info) {
	$plugin = strtoupper($plugin);
	$type_info = strtolower($type_info);
	$plugins_actifs = liste_plugin_actifs();

	if(!$plugin)
		return serialize(array_keys($plugins_actifs));
	if(!empty($plugins_actifs[$plugin]))
		if($type_info == 'est_actif')
			return $plugins_actifs[$plugin] ? 1 : 0;
		else {
			$plugins_valides = liste_plugin_valides(liste_plugin_files(), $inf_tous_plugins);
			return $inf_tous_plugins[$plugins_actifs[$plugin]['dir']][$type_info];
		}
}

function formate_lien_plugin($lien) {
	$ret = NULL;
	if (trim($lien)) {
		if (preg_match(',^https?://,iS', $lien))
			$ret = propre("[->".$lien."]");
		else
			$ret = propre($lien);
	}
	return $ret;
}

function formate_etat_plugin($etat) {
	$ret = NULL;
	if (!isset($etat))
		$etat = 'dev';
	switch ($etat) {
		case 'experimental':
			$ret = _T('plugin_etat_experimental');
			break;
		case 'test':
			$ret = _T('plugin_etat_test');
			break;
		case 'stable':
			$ret = _T('plugin_etat_stable');
			break;
		default:
			$ret = _T('plugin_etat_developpement');
			break;
	}
	return $ret;
}


?>