<?php
if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_spipr_educ_configure_sommaire_editorial_hero_charger_dist() {
	$req_sql=sql_select('*','spip_spipr_educ',"nom='graphisme_editorial_hero' AND type='graphisme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
	$tab_sql=sql_fetch($req_sql);
	$valeurs['heroUnitBackground']= ($tab_sql['parametre1'] ? $tab_sql['parametre1'] : '#eeeeee');
	$valeurs['heroUnitHeadingColor']= ($tab_sql['parametre2'] ? $tab_sql['parametre2'] : '#0088cc');
	$valeurs['heroUnitLeadColor']= ($tab_sql['parametre3'] ? $tab_sql['parametre3'] : '#333333');
	$valeurs['heroUnitCSS']= ($tab_sql['parametre4'] ? $tab_sql['parametre4'] : '');
	
	$req_sql3=sql_select('*','spip_spipr_educ',"nom='options_articles' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
	$tab_sql3=sql_fetch($req_sql3);
	$valeurs['editoOrdreArticles']= ($tab_sql3['parametre2'] ? $tab_sql3['parametre2'] : '');
	
	return $valeurs;
}

function formulaires_spipr_educ_configure_sommaire_editorial_hero_traiter_dist() {
	if (_request('hidden_editorial_hero')=='ok') {
		sql_updateq(
			'spip_spipr_educ',
			array(
				'parametre1' => _request('heroUnitBackground'),
				'parametre2' => _request('heroUnitHeadingColor'),
				'parametre3' => _request('heroUnitLeadColor'),
				'parametre4' => _request('heroUnitCSS'),
			),
			"nom='graphisme_editorial_hero' AND type='graphisme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
		);
		include_spip('inc/spipr_educ_traitements_listes');
		$test_articles_edito=sql_select('*','spip_spipr_educ',"nom='options_articles' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
		$tab_articles_edito=sql_fetch($test_articles_edito);
		$chaine=$tab_articles_edito['parametre2'];
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
		sql_updateq('spip_spipr_educ',array('parametre2' => $chaine_retour),"nom='options_articles' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
	}
	$res['message_ok'] = _T('config_info_enregistree');
	return $res;
}
?>