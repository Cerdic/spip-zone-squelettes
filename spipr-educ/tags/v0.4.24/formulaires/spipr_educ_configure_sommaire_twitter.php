<?php
if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_spipr_educ_configure_sommaire_twitter_charger_dist($nom,$id) {
	$req_sql=sql_select('*','spip_spipr_educ',"id='$id'");
	$tab_sql=sql_fetch($req_sql);
	$nom_fil_twitter=$tab_sql['parametre5'];
	$couleur_liens_twitter=$tab_sql['parametre6'];
	$hauteur_fil_twitter=$tab_sql['parametre7'];
	$valeurs = array (
		'nom' => $nom,
		'id' => $id,
		'nom_fil_twitter' => $nom_fil_twitter,
		'couleur_liens_twitter' => $couleur_liens_twitter,
		'hauteur_fil_twitter' => $hauteur_fil_twitter,
	);
	return $valeurs;
}

function formulaires_spipr_educ_configure_sommaire_twitter_traiter_dist($nom,$id) {
	if (_request('hidden_fil_twitter')=='ok') {
		sql_updateq(
			'spip_spipr_educ',
			array(
				'parametre5' => _request('nom_fil_twitter'),
				'parametre6' => _request('couleur_fil_twitter'),
				'parametre7' => _request('hauteur_fil_twitter'),
			),
			"id='$id'"
		);
	}
	$res['message_ok'] = _T('config_info_enregistree');
	return $res;
}
?>