<?php
if (!defined('_ECRIRE_INC_VERSION')) return;

// Voir ci-dessous pour obtenir la correspondance entre variable bootstrap/less et paramètres de la base de données

function formulaires_spipr_educ_graphisme_marges_charger_dist() {
	$valeurs=array();
	$test_marges=sql_select('*','spip_spipr_educ',"nom='graphisme_marges' AND type='graphisme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
	$tab_marges=sql_fetch($test_marges);
	$valeurs['marges']= ($tab_marges['parametre1'] ? $tab_marges['parametre1'] : 'non');
	return $valeurs;
}

function formulaires_spipr_educ_graphisme_marges_traiter_dist() {
	$res['message_ok'] = _T('config_info_enregistree');
	$tab = array(
		'marges'=>'parametre1'
	);
	if (_request('hidden_graphisme_marges')=='ok') {
		foreach ($tab as $cle=>$parametre) {
			sql_updateq(
				'spip_spipr_educ',
				array(
					"$parametre" => _request("$cle"),
				),
				"nom='graphisme_marges' AND type='graphisme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
			);
		}
	}
	return $res;
}
?>