<?php
if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_spipr_educ_configure_dyslexie_charger_dist($nom,$id) {
	$req_sql=sql_select('*','spip_spipr_educ',"id='".$id."' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
	$tab_sql=sql_fetch($req_sql);
	$valeurs['dysBackground']= $tab_sql['parametre5'];
	$valeurs['dysColor']= $tab_sql['parametre6'];
	$valeurs['dysBorder']= $tab_sql['parametre7'];
	$valeurs['dysCSS']= $tab_sql['parametre8'];
	$valeurs['nom']= $nom;
	return $valeurs;
}

function formulaires_spipr_educ_configure_dyslexie_traiter_dist($nom,$id) {
	if (_request('hidden_dys')=='ok') {
		sql_updateq(
			'spip_spipr_educ',
			array(
				'parametre5' => _request('dysBackground'),
				'parametre6' => _request('dysColor'),
				'parametre7' => _request('dysBorder'),
				'parametre8' => _request('dysCSS'),
			),
			"id='".$id."' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
		);
	}
	$res['message_ok'] = _T('config_info_enregistree');
	return $res;
}
?>