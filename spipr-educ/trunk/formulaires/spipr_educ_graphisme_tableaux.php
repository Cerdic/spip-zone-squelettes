<?php
if (!defined('_ECRIRE_INC_VERSION')) return;

// Voir ci-dessous pour obtenir la correspondance entre variable bootstrap/less et paramètres de la base de données

function formulaires_spipr_educ_graphisme_tableaux_charger_dist() {
	$valeurs=array();
	$test_tableaux=sql_select('*','spip_spipr_educ',"nom='graphisme_tableaux' AND type='graphisme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
	$tab_tableaux=sql_fetch($test_tableaux);
	$valeurs['tableBackground']= ($tab_tableaux['parametre1'] ? $tab_tableaux['parametre1'] : '#ffffff');
	$valeurs['tableBackgroundAccent']= ($tab_tableaux['parametre2'] ? $tab_tableaux['parametre2'] : '#f9f9f9');
	$valeurs['tableBackgroundHover']=($tab_tableaux['parametre3'] ? $tab_tableaux['parametre3'] : '#f5f5f5');
	$valeurs['bordures_verticales']=($tab_tableaux['parametre4'] ? $tab_tableaux['parametre4'] : 'non');
	$valeurs['tableBorder']=($tab_tableaux['parametre5'] ? $tab_tableaux['parametre5'] : '#dddddd');
	return $valeurs;
}

function formulaires_spipr_educ_graphisme_tableaux_traiter_dist() {
	$res['message_ok'] = _T('config_info_enregistree');
	$tab = array(
		'tableBackground'=>'parametre1',
		'tableBackgroundAccent'=>'parametre2',
		'tableBackgroundHover'=>'parametre3',
		'bordures_verticales'=>'parametre4',
		'tableBorder'=>'parametre5',
	);
	if (_request('hidden_graphisme_tableaux')=='ok') {
		foreach ($tab as $cle=>$parametre) {
			sql_updateq(
				'spip_spipr_educ',
				array(
					"$parametre" => _request("$cle"),
				),
				"nom='graphisme_tableaux' AND type='graphisme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
			);
		}
	}
	return $res;
}
?>