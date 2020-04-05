<?php
if (!defined('_ECRIRE_INC_VERSION')) return;

// Voir ci-dessous pour obtenir la correspondance entre variable bootstrap/less et paramètres de la base de données

function formulaires_spipr_educ_graphisme_menu_deroulant_charger_dist() {
	$valeurs=array();
	$test_graphisme=sql_select('*','spip_spipr_educ',"nom='graphisme_menu_deroulant' AND type='graphisme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
	$tab_graphisme=sql_fetch($test_graphisme);
	$valeurs['dropdownBackground']= ($tab_graphisme['parametre1'] ? $tab_graphisme['parametre1'] : '#ffffff');
	$valeurs['dropdownBorder']= ($tab_graphisme['parametre2'] ? $tab_graphisme['parametre2'] : '#aaaaaa');
	$valeurs['dropdownDividerTop']=($tab_graphisme['parametre3'] ? $tab_graphisme['parametre3'] : '#e5e5e5');
	$valeurs['dropdownDividerBottom']=($tab_graphisme['parametre4'] ? $tab_graphisme['parametre4'] : '#ffffff');
	$valeurs['dropdownLinkColor']=($tab_graphisme['parametre5'] ? $tab_graphisme['parametre5'] : '#333333');
	$valeurs['dropdownLinkColorHover']=($tab_graphisme['parametre6'] ? $tab_graphisme['parametre6'] : '#ffffff');
	$valeurs['dropdownLinkColorActive']=($tab_graphisme['parametre7'] ? $tab_graphisme['parametre7'] : '#ffffff');
	$valeurs['dropdownLinkBackgroundActive']=($tab_graphisme['parametre8'] ? $tab_graphisme['parametre8'] : '#0088cc');
	$valeurs['dropdownLinkBackgroundHover']=($tab_graphisme['parametre9'] ? $tab_graphisme['parametre9'] : '#0088cc');
	$valeurs['itemActifGras']=($tab_graphisme['parametre10'] ? $tab_graphisme['parametre10'] : 'non');
	
	return $valeurs;
}

function formulaires_spipr_educ_graphisme_menu_deroulant_traiter_dist() {
	$res['message_ok'] = _T('config_info_enregistree');
	$tab = array(
		'dropdownBackground'=>'parametre1',
		'dropdownBorder'=>'parametre2',
		'dropdownDividerTop'=>'parametre3',
		'dropdownDividerBottom'=>'parametre4',
		'dropdownLinkColor'=>'parametre5',
		'dropdownLinkColorHover'=>'parametre6',
		'dropdownLinkColorActive'=>'parametre7',
		'dropdownLinkBackgroundActive'=>'parametre8',
		'dropdownLinkBackgroundHover'=>'parametre9',
		'itemActifGras'=>'parametre10',
	);
	if (_request('hidden_graphisme_menu_deroulant')=='ok') {
		foreach ($tab as $cle=>$parametre) {
			sql_updateq(
				'spip_spipr_educ',
				array(
					"$parametre" => _request("$cle"),
				),
				"nom='graphisme_menu_deroulant' AND type='graphisme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
			);
		}
	}
	return $res;
}
?>