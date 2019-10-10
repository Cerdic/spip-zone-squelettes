<?php
if (!defined('_ECRIRE_INC_VERSION')) return;

// Voir ci-dessous pour obtenir la correspondance entre variable bootstrap/less et paramètres de la base de données

function formulaires_spipr_educ_graphisme_pagination_charger_dist() {
	$valeurs=array();
	$test_graphisme=sql_select('*','spip_spipr_educ',"nom='graphisme_pagination' AND type='graphisme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
	$tab_graphisme=sql_fetch($test_graphisme);
	$valeurs['paginationBackground']= ($tab_graphisme['parametre1'] ? $tab_graphisme['parametre1'] : '#ffffff');
	$valeurs['paginationActiveBackground']= ($tab_graphisme['parametre2'] ? $tab_graphisme['parametre2'] : '#f5f5f5');
	$valeurs['paginationBorder']=($tab_graphisme['parametre3'] ? $tab_graphisme['parametre3'] : '#dddddd');
	$valeurs['alignement_pagination']=($tab_graphisme['parametre4'] ? $tab_graphisme['parametre4'] : 'left');
	$valeurs['paginationCSS']=($tab_graphisme['parametre5'] ? $tab_graphisme['parametre5'] : '');
	return $valeurs;
}

function formulaires_spipr_educ_graphisme_pagination_traiter_dist() {
	$res['message_ok'] = _T('config_info_enregistree');
	$tab = array(
		'paginationBackground'=>'parametre1',
		'paginationActiveBackground'=>'parametre2',
		'paginationBorder'=>'parametre3',
		'alignement_pagination'=>'parametre4',
		'paginationCSS'=>'parametre5',
	);
	if (_request('hidden_graphisme_pagination')=='ok') {
		foreach ($tab as $cle=>$parametre) {
			sql_updateq(
				'spip_spipr_educ',
				array(
					"$parametre" => _request("$cle"),
				),
				"nom='graphisme_pagination' AND type='graphisme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
			);
		}
	}
	return $res;
}
?>