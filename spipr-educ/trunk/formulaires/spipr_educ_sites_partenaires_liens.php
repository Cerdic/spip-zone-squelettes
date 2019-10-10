<?php
if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_spipr_educ_sites_partenaires_liens_charger_dist() {
	$test_sites_logos=sql_select('*','spip_spipr_educ',"nom='options_sites' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
	$tab_sites_logos=sql_fetch($test_sites_logos);
	$valeurs['sites_def']=$tab_sites_logos['parametre3'];
	$test_sites_graphisme=sql_select('*','spip_spipr_educ',"nom='graphisme_liens_partenaires' AND type='graphisme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
	$tab_sites_graphisme=sql_fetch($test_sites_graphisme);
	$valeurs['liensTitre']=$tab_sites_graphisme['parametre1'];
	$valeurs['liensColor']=$tab_sites_graphisme['parametre2'];
	$valeurs['backgroundBloc']=$tab_sites_graphisme['parametre3'];
	$valeurs['couleurFondHover']=$tab_sites_graphisme['parametre9'];
	$valeurs['bordureBloc']=$tab_sites_graphisme['parametre4'];
	$valeurs['couleurLiens']=$tab_sites_graphisme['parametre5'];
	$valeurs['couleurLiensHover']=$tab_sites_graphisme['parametre6'];
	$valeurs['liensCSS']=$tab_sites_graphisme['parametre7'];
	if ($tab_sites_graphisme['parametre8']!='') $valeurs['orientation_liens']=$tab_sites_graphisme['parametre8'];
	else $valeurs['orientation_liens']='non';
	return $valeurs;
}

function formulaires_spipr_educ_sites_partenaires_liens_traiter_dist() {
	include_spip('inc/spipr_educ_traitements_listes');
	$test_sites_logos=sql_select('*','spip_spipr_educ',"nom='options_sites' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
	$tab_sites_logos=sql_fetch($test_sites_logos);
	$chaine=$tab_sites_logos['parametre3'];
	$chaine_retour=$chaine;
	$tab=explode(",",$chaine);
	foreach ($tab as $id) {
		if (is_numeric(_request('supprimer_site_'.$id.'_x'))) {
			$chaine_retour=spipr_educ_liste_del($chaine,$id);
		}
		if (is_numeric(_request('monter_site_'.$id.'_x'))) {
			$chaine_retour=spipr_educ_liste_up($chaine,$id);
		}
		if (is_numeric(_request('descendre_site_'.$id.'_x'))) {
			$chaine_retour=spipr_educ_liste_down($chaine,$id);
		}
	}
	sql_updateq('spip_spipr_educ',array('parametre3' => $chaine_retour),"nom='options_sites' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
	
	if (_request('hidden_sites_partenaires_liens')=='ok') {
		sql_updateq(
			'spip_spipr_educ',
			array(
				'parametre1' => _request('liensTitre'),
				'parametre2' => _request('liensColor'),
				'parametre3' => _request('backgroundBloc'),
				'parametre4' => _request('bordureBloc'),
				'parametre5' => _request('couleurLiens'),
				'parametre6' => _request('couleurLiensHover'),
				'parametre7' => _request('liensCSS'),
				'parametre8' => _request('orientation_liens'),
				'parametre9' => _request('couleurFondHover'),
			),
			"nom='graphisme_liens_partenaires' AND type='graphisme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
		);
		$res['message_ok'] = _T('config_info_enregistree');
	}
	return $res;
}
?>