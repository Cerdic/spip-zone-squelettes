<?php
if (!defined('_ECRIRE_INC_VERSION')) return;

// Voir ci-dessous pour obtenir la correspondance entre variable bootstrap/less et paramètres de la base de données

function formulaires_spipr_educ_graphisme_typographie_charger_dist() {
	$valeurs=array();
	$test_typo=sql_select('*','spip_spipr_educ',"nom='graphisme_typographie' AND type='graphisme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
	$tab_typo=sql_fetch($test_typo);
	$valeurs['sansFontFamily']=($tab_typo['parametre1'] ? $tab_typo['parametre1'] : '"Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Geneva, Verdana, sans-serif');
	$valeurs['serifFontFamily']=($tab_typo['parametre2'] ? $tab_typo['parametre2'] : 'Georgia, Cambria, "Times New Roman", Times, serif');
	$valeurs['monoFontFamily']=($tab_typo['parametre3'] ? $tab_typo['parametre3'] : '"Courier New", Courier, monospace');
	$valeurs['headingsFontFamily']=($tab_typo['parametre4'] ? $tab_typo['parametre4'] : ($tab_typo['parametre2'] ? $tab_typo['parametre2'] : 'Georgia, Cambria, "Times New Roman", Times, serif'));
	$valeurs['baseFontSize']=($tab_typo['parametre5'] ? $tab_typo['parametre5'] : 14);
	$valeurs['baseLineHeight']=($tab_typo['parametre6'] ? $tab_typo['parametre6'] : 20);
	return $valeurs;
}

function formulaires_spipr_educ_graphisme_typographie_traiter_dist() {
	$res['message_ok'] = _T('config_info_enregistree');
	$tab = array(
		'sansFontFamily'=>'parametre1',
		'serifFontFamily'=>'parametre2',
		'monoFontFamily'=>'parametre3',
		'headingsFontFamily'=>'parametre4',
		'baseFontSize'=>'parametre5',
		'baseLineHeight'=>'parametre6',
	);
	if (_request('hidden_graphisme_typographie')=='ok') {
		foreach ($tab as $cle=>$parametre) {
			sql_updateq(
				'spip_spipr_educ',
				array(
					"$parametre" => _request("$cle"),
				),
				"nom='graphisme_typographie' AND type='graphisme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
			);
		}
	}
	return $res;
}
?>