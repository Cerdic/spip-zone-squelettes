<?php
if (!defined('_ECRIRE_INC_VERSION')) return;

// Voir ci-dessous pour obtenir la correspondance entre variable bootstrap/less et paramètres de la base de données

function formulaires_spipr_educ_graphisme_menu_vertical_charger_dist() {
	$valeurs=array();
	$test_graphisme=sql_select('*','spip_spipr_educ',"nom='graphisme_menu_vertical' AND type='graphisme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
	$tab_graphisme=sql_fetch($test_graphisme);
	$valeurs['MenuVerticalBorder']= ($tab_graphisme['parametre1'] ? $tab_graphisme['parametre1'] : '#e9e9e9');
	$valeurs['MenuVerticalBackground']= ($tab_graphisme['parametre2'] ? $tab_graphisme['parametre2'] : '#f5f5f5');
	$valeurs['MenuVerticalLegend']=($tab_graphisme['parametre3'] ? $tab_graphisme['parametre3'] : '#999999');
	$valeurs['MenuVerticalItemColor']=($tab_graphisme['parametre4'] ? $tab_graphisme['parametre4'] : '#0088cc');
	$valeurs['MenuVerticalHoverItemColor']=($tab_graphisme['parametre5'] ? $tab_graphisme['parametre5'] : '#005588');
	$valeurs['MenuVerticalHoverItemBackground']=($tab_graphisme['parametre6'] ? $tab_graphisme['parametre6'] : '#eeeeee');
	$valeurs['MenuVerticalActiveItemColor']=($tab_graphisme['parametre7'] ? $tab_graphisme['parametre7'] : '#ffffff');
	$valeurs['MenuVerticalActiveItemBackground']=($tab_graphisme['parametre8'] ? $tab_graphisme['parametre8'] : '#0088cc');
	$valeurs['MenuVerticalCSS']=($tab_graphisme['parametre9'] ? $tab_graphisme['parametre9'] : '');	
	return $valeurs;
}

function formulaires_spipr_educ_graphisme_menu_vertical_traiter_dist() {
	$res['message_ok'] = _T('config_info_enregistree');
	$tab = array(
		'MenuVerticalBorder'=>'parametre1',
		'MenuVerticalBackground'=>'parametre2',
		'MenuVerticalLegend'=>'parametre3',
		'MenuVerticalItemColor'=>'parametre4',
		'MenuVerticalHoverItemColor'=>'parametre5',
		'MenuVerticalHoverItemBackground'=>'parametre6',
		'MenuVerticalActiveItemColor'=>'parametre7',
		'MenuVerticalActiveItemBackground'=>'parametre8',
		'MenuVerticalCSS'=>'parametre9',
	);
	if (_request('hidden_graphisme_menu_vertical')=='ok') {
		foreach ($tab as $cle=>$parametre) {
			sql_updateq(
				'spip_spipr_educ',
				array(
					"$parametre" => _request("$cle"),
				),
				"nom='graphisme_menu_vertical' AND type='graphisme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
			);
		}
	}
	return $res;
}
?>