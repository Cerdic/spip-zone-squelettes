<?php
if (!defined('_ECRIRE_INC_VERSION')) return;

// Voir ci-dessous pour obtenir la correspondance entre variable bootstrap/less et paramètres de la base de données

function formulaires_spipr_educ_graphisme_menu_horizontal_charger_dist() {
	$valeurs=array();
	$test_graphisme=sql_select('*','spip_spipr_educ',"nom='graphisme_menu_horizontal' AND type='graphisme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
	$tab_graphisme=sql_fetch($test_graphisme);
	$valeurs['navbarInverseBackground']= ($tab_graphisme['parametre1'] ? $tab_graphisme['parametre1'] : '#111111');
	$valeurs['navbarInverseBackgroundHighlight']= ($tab_graphisme['parametre2'] ? $tab_graphisme['parametre2'] : '#222222');
	$valeurs['navbarInverseBorder']=($tab_graphisme['parametre3'] ? $tab_graphisme['parametre3'] : '#252525');
	$valeurs['navbarInverseText']=($tab_graphisme['parametre4'] ? $tab_graphisme['parametre4'] : '#999999');
	$valeurs['navbarInverseLinkColor']=($tab_graphisme['parametre5'] ? $tab_graphisme['parametre5'] : '#999999');
	$valeurs['navbarInverseLinkColorHover']=($tab_graphisme['parametre6'] ? $tab_graphisme['parametre6'] : '#ffffff');
	$valeurs['navbarInverseLinkColorActive']=($tab_graphisme['parametre7'] ? $tab_graphisme['parametre7'] : '#ffffff');
	$valeurs['navbarInverseLinkBackgroundHover']=($tab_graphisme['parametre8'] ? $tab_graphisme['parametre8'] : '#797979');
	$valeurs['navbarInverseLinkBackgroundActive']=($tab_graphisme['parametre9'] ? $tab_graphisme['parametre9'] : '#111111');
	$valeurs['navbarHeight']=($tab_graphisme['parametre10'] ? $tab_graphisme['parametre10'] : '40');
	
	$test_graphisme2=sql_select('*','spip_spipr_educ',"nom='graphisme_menu_icones' AND type='graphisme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
	$tab_graphisme2=sql_fetch($test_graphisme2);
	$valeurs['iconeAccueil']= ($tab_graphisme2['parametre1'] ? $tab_graphisme2['parametre1'] : 'oui');
	$valeurs['iconeAgenda']= ($tab_graphisme2['parametre2'] ? $tab_graphisme2['parametre2'] : 'oui');
	$valeurs['iconeContact']= ($tab_graphisme2['parametre3'] ? $tab_graphisme2['parametre3'] : 'oui');
	$valeurs['iconeSite']= ($tab_graphisme2['parametre4'] ? $tab_graphisme2['parametre4'] : 'oui');
	
	return $valeurs;
}

function formulaires_spipr_educ_graphisme_menu_horizontal_traiter_dist() {
	$res['message_ok'] = _T('config_info_enregistree');
	$tab = array(
		'navbarInverseBackground'=>'parametre1',
		'navbarInverseBackgroundHighlight'=>'parametre2',
		'navbarInverseBorder'=>'parametre3',
		'navbarInverseText'=>'parametre4',
		'navbarInverseLinkColor'=>'parametre5',
		'navbarInverseLinkColorHover'=>'parametre6',
		'navbarInverseLinkColorActive'=>'parametre7',
		'navbarInverseLinkBackgroundHover'=>'parametre8',
		'navbarInverseLinkBackgroundActive'=>'parametre9',
		'navbarHeight'=>'parametre10',
	);
	$tab2 = array(
		'iconeAccueil'=>'parametre1',
		'iconeAgenda'=>'parametre2',
		'iconeContact'=>'parametre3',
		'iconeSite'=>'parametre4',
	);
	if (_request('hidden_graphisme_menu_horizontal')=='ok') {
		foreach ($tab as $cle=>$parametre) {
			sql_updateq(
				'spip_spipr_educ',
				array(
					"$parametre" => _request("$cle"),
				),
				"nom='graphisme_menu_horizontal' AND type='graphisme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
			);
		}
		foreach ($tab2 as $cle=>$parametre) {
			sql_updateq(
				'spip_spipr_educ',
				array(
					"$parametre" => _request("$cle"),
				),
				"nom='graphisme_menu_icones' AND type='graphisme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
			);
		}
	}
	return $res;
}
?>