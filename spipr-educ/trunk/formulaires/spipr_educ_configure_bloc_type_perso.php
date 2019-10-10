<?php
if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_spipr_educ_configure_bloc_type_perso_charger_dist($nom,$id) {
	$req_sql=sql_select('*','spip_spipr_educ',"id='$id'");
	$tab_sql=sql_fetch($req_sql);
	$valeurs = array (
		'id' => $id,
		'nom' => $nom,
		'titreBloc' => $tab_sql['parametre5'],
		'texteBloc' => $tab_sql['parametre6'],
	);
	$req_sql2=sql_select('*','spip_spipr_educ',"nom='$nom' AND type='graphisme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
	$tab_sql2=sql_fetch($req_sql2);
	$valeurs['blocFond']=$tab_sql2['parametre1'];
	$valeurs['blocBordure']=$tab_sql2['parametre2'];
	$valeurs['titreCouleur']=$tab_sql2['parametre3'];
	$valeurs['titreFond']=$tab_sql2['parametre4'];
	$valeurs['texteCouleur']=$tab_sql2['parametre5'];
	$valeurs['blocCSS']=$tab_sql2['parametre6'];
	return $valeurs;
}

function formulaires_spipr_educ_configure_bloc_type_perso_traiter_dist($nom,$id) {
	if (_request('hidden_'.$nom)=='ok') {
		sql_updateq(
			'spip_spipr_educ',
			array(
				'parametre5' => _request('titreBloc'),
				'parametre6' => _request('texteBloc'),
			),
			"id='$id'"
		);
		sql_updateq(
			'spip_spipr_educ',
			array(
				'parametre1' => _request('blocFond'),
				'parametre2' => _request('blocBordure'),
				'parametre3' => _request('titreCouleur'),
				'parametre4' => _request('titreFond'),
				'parametre5' => _request('texteCouleur'),
				'parametre6' => _request('blocCSS'),
			),
			"nom='$nom' AND type='graphisme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
		);
	}
	$res['message_ok'] = _T('config_info_enregistree');
	return $res;
}
?>