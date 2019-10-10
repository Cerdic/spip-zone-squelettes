<?php
if (!defined('_ECRIRE_INC_VERSION')) return;

// Voir ci-dessous pour obtenir la correspondance entre variable bootstrap/less et paramètres de la base de données

function formulaires_spipr_educ_graphisme_couleur_fond_charger_dist() {
	$valeurs=array();
	$test_graphisme=sql_select('*','spip_spipr_educ',"nom='graphisme_couleur_fond' AND type='graphisme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
	$tab_graphisme=sql_fetch($test_graphisme);
	$valeurs['bodyBackground']= $tab_graphisme['parametre1'];
	$valeurs['headerBackground']= $tab_graphisme['parametre2'];
	$valeurs['wrapperBackground']=$tab_graphisme['parametre3'];
	$valeurs['contentBackground']=$tab_graphisme['parametre4'];
	$valeurs['asideBackground']=$tab_graphisme['parametre5'];
	$valeurs['extraBackground']=$tab_graphisme['parametre6'];
	$valeurs['footerBackground']=$tab_graphisme['parametre7'];
	$valeurs['windowBackground']=$tab_graphisme['parametre8'];
	return $valeurs;
}

function formulaires_spipr_educ_graphisme_couleur_fond_traiter_dist() {
	$res['message_ok'] = _T('config_info_enregistree');
	$tab = array(
		'bodyBackground'=>'parametre1',
		'headerBackground'=>'parametre2',
		'wrapperBackground'=>'parametre3',
		'contentBackground'=>'parametre4',
		'asideBackground'=>'parametre5',
		'extraBackground'=>'parametre6',
		'footerBackground'=>'parametre7',
		'windowBackground'=>'parametre8',
	);
	if (_request('hidden_graphisme_couleur_fond')=='ok') {
		foreach ($tab as $cle=>$parametre) {
			sql_updateq(
				'spip_spipr_educ',
				array(
					"$parametre" => _request("$cle"),
				),
				"nom='graphisme_couleur_fond' AND type='graphisme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
			);
		}
	}
	return $res;
}
?>