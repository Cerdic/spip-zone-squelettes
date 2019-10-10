<?php
if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_spipr_educ_responsive_tres_grand_charger_dist() {
	// Layout précédemment choisi
	$test_layout=sql_select('parametre1','spip_spipr_educ',"nom='layout_1200' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
	$tab_test_layout=sql_fetch($test_layout);
	$test_layout_1200=$tab_test_layout['parametre1'];
	if (!$test_layout_1200) {$test_layout_1200=9;}
	// Répertoire des vignettes des LayoutGala
	$chemin =_DIR_PLUGIN_SPIPR_EDUC.'prive/themes/spip/images/LayoutGala/';
	$valeurs=array();
	$valeurs['layout_actuel'] = $test_layout_1200;
	$valeurs['chemin_vignettes'] = $chemin;
	return $valeurs;
}

function formulaires_spipr_educ_responsive_tres_grand_traiter_dist() {
	include_spip('inc/spipr_educ_structure_responsive');
	$largeurs_colonnes = spipr_educ_definition_largeurs_colonnes();
	$res = array('editable'=>true);
	foreach(array("layoutgala_plus_1200") as $layout) {
		sql_updateq(
			'spip_spipr_educ',
			array(
				'parametre1' => _request($layout),
				'parametre2' => $largeurs_colonnes[_request($layout)][0],
				'parametre3' => $largeurs_colonnes[_request($layout)][1],
				'parametre4' => $largeurs_colonnes[_request($layout)][2],
			),
			"nom='layout_1200' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
		);
	}
	$res['message_ok'] = _T('config_info_enregistree');
	return $res;
}
?>