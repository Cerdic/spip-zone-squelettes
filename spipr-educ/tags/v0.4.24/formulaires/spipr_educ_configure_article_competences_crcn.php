<?php
if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_spipr_educ_configure_article_competences_crcn_charger_dist($nom,$id) {
	$req_sql=sql_select('*','spip_spipr_educ',"id='$id'");
	$tab_sql=sql_fetch($req_sql);
	$legifrance=$tab_sql['parametre5'];
	$hauteur=$tab_sql['parametre6'];
	$CSS=$tab_sql['parametre7'];
	$valeurs = array (
		'nom' => $nom,
		'id' => $id,
		'legifrance' => $legifrance,
		'hauteur' => $hauteur,
		'CSS' => $CSS,
	);
	return $valeurs;
}

function formulaires_spipr_educ_configure_article_competences_crcn_traiter_dist($nom,$id) {
	if (_request('hidden_competences_crcn')=='ok') {
		sql_updateq(
			'spip_spipr_educ',
			array(
				'parametre5' => _request('legifrance'),
				'parametre6' => _request('hauteur'),
				'parametre7' => _request('CSS'),
			),
			"id='$id'"
		);
	}
	$res['message_ok'] = _T('config_info_enregistree');
	return $res;
}
?>