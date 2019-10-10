<?php
if (!defined('_ECRIRE_INC_VERSION')) return;

// Voir ci-dessous pour obtenir la correspondance entre variable bootstrap/less et paramètres de la base de données

function formulaires_spipr_educ_graphisme_fil_ariane_charger_dist() {
	$valeurs=array();
	$test_graphisme=sql_select('*','spip_spipr_educ',"nom='graphisme_fil_ariane' AND type='graphisme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
	$tab_graphisme=sql_fetch($test_graphisme);
	$valeurs['breadcrumbBackground']= ($tab_graphisme['parametre1'] ? $tab_graphisme['parametre1'] : '#fefefe');
	$valeurs['breadcrumbShadow']= ($tab_graphisme['parametre2'] ? $tab_graphisme['parametre2'] : '#ffffff');
	$valeurs['breadcrumbDividerColor']=($tab_graphisme['parametre3'] ? $tab_graphisme['parametre3'] : '#cccccc');
	$valeurs['breadcrumbActiveColor']=($tab_graphisme['parametre4'] ? $tab_graphisme['parametre4'] : '#999999');
	$valeurs['breadcrumbCSS']=($tab_graphisme['parametre5'] ? $tab_graphisme['parametre5'] : '');
	return $valeurs;
}

function formulaires_spipr_educ_graphisme_fil_ariane_traiter_dist() {
	$res['message_ok'] = _T('config_info_enregistree');
	$tab = array(
		'breadcrumbBackground'=>'parametre1',
		'breadcrumbShadow'=>'parametre2',
		'breadcrumbDividerColor'=>'parametre3',
		'breadcrumbActiveColor'=>'parametre4',
		'breadcrumbCSS'=>'parametre5',
	);
	if (_request('hidden_graphisme_fil_ariane')=='ok') {
		foreach ($tab as $cle=>$parametre) {
			sql_updateq(
				'spip_spipr_educ',
				array(
					"$parametre" => _request("$cle"),
				),
				"nom='graphisme_fil_ariane' AND type='graphisme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
			);
		}
	}
	return $res;
}
?>