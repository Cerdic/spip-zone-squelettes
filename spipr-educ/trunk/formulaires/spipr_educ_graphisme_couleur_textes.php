<?php
if (!defined('_ECRIRE_INC_VERSION')) return;

// Voir ci-dessous pour obtenir la correspondance entre variable bootstrap/less et paramètres de la base de données

function formulaires_spipr_educ_graphisme_couleur_textes_charger_dist() {
	$valeurs=array();
	$test_graphisme=sql_select('*','spip_spipr_educ',"nom='graphisme_couleur_textes' AND type='graphisme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
	$tab_graphisme=sql_fetch($test_graphisme);
	$valeurs['textColor']= ($tab_graphisme['parametre1'] ? $tab_graphisme['parametre1'] : '#333333');
	$valeurs['linkColor']= ($tab_graphisme['parametre2'] ? $tab_graphisme['parametre2'] : '#0088cc');
	$valeurs['linkColorHover']=($tab_graphisme['parametre3'] ? $tab_graphisme['parametre3'] : '#005580');
	$valeurs['titreEntete']=($tab_graphisme['parametre4'] ? $tab_graphisme['parametre4'] : '#0088cc');
	$valeurs['sloganSite']=($tab_graphisme['parametre5'] ? $tab_graphisme['parametre5'] : '#333333');
	$valeurs['headingsColor']=($tab_graphisme['parametre6'] ? $tab_graphisme['parametre6'] : '#333333');
	return $valeurs;
}

function formulaires_spipr_educ_graphisme_couleur_textes_traiter_dist() {
	$res['message_ok'] = _T('config_info_enregistree');
	$tab = array(
		'textColor'=>'parametre1',
		'linkColor'=>'parametre2',
		'linkColorHover'=>'parametre3',
		'titreEntete'=>'parametre4',
		'sloganSite'=>'parametre5',
		'headingsColor'=>'parametre6',
	);
	if (_request('hidden_graphisme_couleur_textes')=='ok') {
		foreach ($tab as $cle=>$parametre) {
			sql_updateq(
				'spip_spipr_educ',
				array(
					"$parametre" => _request("$cle"),
				),
				"nom='graphisme_couleur_textes' AND type='graphisme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
			);
		}
	}
	return $res;
}
?>