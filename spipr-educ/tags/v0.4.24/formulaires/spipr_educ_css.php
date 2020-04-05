<?php
if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_spipr_educ_css_charger_dist() {
	$req_sql=sql_select('*','spip_spipr_educ',"nom='graphisme_css' AND type='graphisme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
	$tab_sql=sql_fetch($req_sql);
	$valeurs['CSS-LESS']= ($tab_sql['parametre1'] ? $tab_sql['parametre1'] : '');
	return $valeurs;
}

function formulaires_spipr_educ_css_traiter_dist() {
	if (_request('hidden_css')=='ok') {
		sql_updateq(
			'spip_spipr_educ',
			array(
				'parametre1' => _request('CSS-LESS'),
			),
			"nom='graphisme_css' AND type='graphisme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
		);
	}
	$res['message_ok'] = _T('config_info_enregistree');
	return $res;
}
?>