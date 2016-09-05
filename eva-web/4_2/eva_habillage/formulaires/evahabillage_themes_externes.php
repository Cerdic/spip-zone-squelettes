<?php
if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_evahabillage_themes_externes_charger_dist() {
	// Theme d'habillage externe precedemment choisi
	$test_theme_present=sql_select('nom_div','spip_eva_habillage_images',"nom_habillage='Defaut' AND type='theme'");
	$tab_theme_present=sql_fetch($test_theme_present);
	$test_theme_actif=$tab_theme_present['nom_div'];
	if (!$test_theme_actif) {$test_theme_actif=1;}
	// Répertoire des vignettes des thêmes externes
	$chemin =_DIR_PLUGIN_EVA_HABILLAGE.'img_pack/vignettes/';
	$valeurs=array();
	$valeurs['habillage_actuel'] = $test_theme_actif;
	$valeurs['chemin_vignettes'] = $chemin;
	return $valeurs;
}

function formulaires_evahabillage_themes_externes_traiter_dist() {
	$res = array('editable'=>true);
	include_spip('inc/eva_habillage_themes_externes');
	$tab_externe = eva_charger_themes();
	$tableau=array_keys($tab_externe);
	foreach(array("integrer_theme_externe") as $m) {
		$num=_request($m)-1;
		$theme_externe_nom = $tableau[$num];
		$theme_externe=$tab_externe[$theme_externe_nom];
		sql_delete('spip_eva_habillage_themes',"nom = 'Defaut'");
		sql_delete('spip_eva_habillage_images',"nom_habillage = 'Defaut'");
		sql_updateq('spip_eva_habillage',array('habillage' => $theme_externe['habillage']),"sauvegarde = 'Defaut'");
		spip_query("INSERT INTO spip_eva_habillage_themes VALUES ".$theme_externe['theme']);
		$tab = $theme_externe['images'];
		sql_insertq('spip_eva_habillage_images',array('type'=>'theme','nom_habillage'=>'Defaut','nom_div'=>_request($m)));
		foreach ($tab as $val) {spip_query("INSERT INTO spip_eva_habillage_images VALUES ".$val);}
		include_spip('inc/eva_habillage_transition_module');
		eva_habillage_transition_module();
		include_spip('inc/eva_habillage_parametres_accessibilite');
		eva_habillage_parametres_accessibilite();
	}
	$res['message_ok'] = _T('config_info_enregistree');
	return $res;
}