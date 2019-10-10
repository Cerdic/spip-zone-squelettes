<?php
if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_spipr_educ_configure_sommaire_nuage_charger_dist($nom) {
	$req_sql=sql_select('*','spip_spipr_educ',"nom='".$nom."' AND type='bloc de base' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
	$tab_sql=sql_fetch($req_sql);
	$valeurs['nuageCSS']= ($tab_sql['parametre6'] ? $tab_sql['parametre6'] : '');
	$valeurs['array_nuage']= ($tab_sql['parametre7'] ? $tab_sql['parametre7'] : '');
	$valeurs['nuageTitre']= ($tab_sql['parametre8'] ? $tab_sql['parametre8'] : '');
	$valeurs['nom']=$nom;
	return $valeurs;
}

function formulaires_spipr_educ_configure_sommaire_nuage_traiter_dist($nom) {
	if (_request('hidden_nuage')=='ok') {
		// Boucler sur les checkbox via les groupes présents et vérifier valeur du request, compléter un array puis enregistrer dans la base son implode
		$array_nuage=array();
		$req_sql=sql_select('*','spip_groupes_mots');
		foreach ($req_sql as $tab_sql) {
			if (_request("groupe".$tab_sql['id_groupe'])=='oui') {
				$array_nuage[]=$tab_sql['id_groupe'];
			}
		}
		sql_updateq(
			'spip_spipr_educ',
			array(
				'parametre6' => _request('nuageCSS'),
				'parametre7' => implode("|",$array_nuage),
				'parametre8' => _request('nuageTitre'),
			),
			"nom='".$nom."' AND type='bloc de base' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
		);
	}
	$res['message_ok'] = _T('config_info_enregistree');
	return $res;
}
?>