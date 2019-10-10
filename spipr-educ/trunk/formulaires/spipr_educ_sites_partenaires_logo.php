<?php
if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_spipr_educ_sites_partenaires_logo_charger_dist() {
	$test_sites_logos=sql_select('*','spip_spipr_educ',"nom='options_sites' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
	$tab_sites_logos=sql_fetch($test_sites_logos);
	$valeurs['sites_def']=$tab_sites_logos['parametre2'];
	$test_sites_graphisme=sql_select('*','spip_spipr_educ',"nom='graphisme_bloc_logos' AND type='graphisme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
	$tab_sites_graphisme=sql_fetch($test_sites_graphisme);
	$valeurs['largeur_mini']=$tab_sites_graphisme['parametre1'];
	$valeurs['largeur_maxi']=$tab_sites_graphisme['parametre2'];
	$valeurs['hauteur_mini']=$tab_sites_graphisme['parametre3'];
	$valeurs['hauteur_maxi']=$tab_sites_graphisme['parametre4'];
	$valeurs['logoTitre']=$tab_sites_graphisme['parametre5'];
	$valeurs['couleurTitre']=$tab_sites_graphisme['parametre6'];
	$valeurs['backgroundLogo']=$tab_sites_graphisme['parametre7'];
	$valeurs['couleurBordure']=$tab_sites_graphisme['parametre8'];
	$valeurs['logoCSS']=$tab_sites_graphisme['parametre9'];
	return $valeurs;
}

function formulaires_spipr_educ_sites_partenaires_logo_traiter_dist() {
	include_spip('inc/spipr_educ_traitements_listes');
	$test_sites_logos=sql_select('*','spip_spipr_educ',"nom='options_sites' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
	$tab_sites_logos=sql_fetch($test_sites_logos);
	$chaine=$tab_sites_logos['parametre2'];
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
	sql_updateq('spip_spipr_educ',array('parametre2' => $chaine_retour),"nom='options_sites' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
	
	if (_request('hidden_sites_partenaires_logo')=='ok') {
		sql_updateq(
			'spip_spipr_educ',
			array(
				'parametre1' => _request('largeur_mini'),
				'parametre2' => _request('largeur_maxi'),
				'parametre3' => _request('hauteur_mini'),
				'parametre4' => _request('hauteur_maxi'),
				'parametre5' => _request('logoTitre'),
				'parametre6' => _request('couleurTitre'),
				'parametre7' => _request('backgroundLogo'),
				'parametre8' => _request('couleurBordure'),
				'parametre9' => _request('logoCSS'),
			),
			"nom='graphisme_bloc_logos' AND type='graphisme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
		);
		$res['message_ok'] = _T('config_info_enregistree');
	}
	return $res;
}
?>