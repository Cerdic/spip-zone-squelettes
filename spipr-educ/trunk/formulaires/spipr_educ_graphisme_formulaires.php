<?php
if (!defined('_ECRIRE_INC_VERSION')) return;

// Voir ci-dessous pour obtenir la correspondance entre variable bootstrap/less et paramètres de la base de données

function formulaires_spipr_educ_graphisme_formulaires_charger_dist() {
	$valeurs=array();
	$test_graphisme=sql_select('*','spip_spipr_educ',"nom='graphisme_formulaires' AND type='graphisme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
	$tab_graphisme=sql_fetch($test_graphisme);
	$valeurs['formulairesBackground']= ($tab_graphisme['parametre1'] ? $tab_graphisme['parametre1'] : '');
	$valeurs['formulairesColor']= ($tab_graphisme['parametre2'] ? $tab_graphisme['parametre2'] : '');
	$valeurs['formulairesBorder']= ($tab_graphisme['parametre3'] ? $tab_graphisme['parametre3'] : '');
	$valeurs['formulairesCSS']= ($tab_graphisme['parametre4'] ? $tab_graphisme['parametre4'] : '');
	return $valeurs;
}

function formulaires_spipr_educ_graphisme_formulaires_traiter_dist() {
	$res['message_ok'] = _T('config_info_enregistree');
	$tab = array(
		'formulairesBackground'=>'parametre1',
		'formulairesColor'=>'parametre2',
		'formulairesBorder'=>'parametre3',
		'formulairesCSS'=>'parametre4',
	);
	if (_request('hidden_graphisme_formulaires')=='ok') {
		foreach ($tab as $cle=>$parametre) {
			sql_updateq(
				'spip_spipr_educ',
				array(
					"$parametre" => _request("$cle"),
				),
				"nom='graphisme_formulaires' AND type='graphisme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
			);
		}
	}
	return $res;
}
?>