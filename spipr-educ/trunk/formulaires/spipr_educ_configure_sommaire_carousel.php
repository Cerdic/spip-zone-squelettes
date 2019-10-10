<?php
if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_spipr_educ_configure_sommaire_carousel_charger_dist() {
	$req_sql=sql_select('*','spip_spipr_educ',"nom='graphisme_carousel' AND type='graphisme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
	$tab_sql=sql_fetch($req_sql);
	$valeurs['carouselBackground']= ($tab_sql['parametre1'] ? $tab_sql['parametre1'] : '#eeeeee');
	$valeurs['carouselColor']= ($tab_sql['parametre2'] ? $tab_sql['parametre2'] : '#333333');
	$valeurs['carouselBorder']= ($tab_sql['parametre3'] ? $tab_sql['parametre3'] : '#eeeeee');
	$valeurs['carouselHeaderColor']= ($tab_sql['parametre4'] ? $tab_sql['parametre4'] : '#0088cc');
	$valeurs['carouselArrowColor']= ($tab_sql['parametre5'] ? $tab_sql['parametre5'] : '#ffffff');
	$valeurs['carouselArrowBackground']= ($tab_sql['parametre6'] ? $tab_sql['parametre6'] : '#bbbbbb');
	$valeurs['carouselArrowHoverBackground']= ($tab_sql['parametre7'] ? $tab_sql['parametre7'] : '#aaaaaa');
	$valeurs['carouselPointColor']= ($tab_sql['parametre8'] ? $tab_sql['parametre8'] : '#bbbbbb');
	$valeurs['carouselPointHoverColor']= ($tab_sql['parametre9'] ? $tab_sql['parametre9'] : '#0088cc');
	$valeurs['carouselArrowHoverColor']= ($tab_sql['parametre10'] ? $tab_sql['parametre10'] : '#ffffff');
		
	$req_sql2=sql_select('*','spip_spipr_educ',"nom='graphisme_carousel_2' AND type='graphisme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
	$tab_sql2=sql_fetch($req_sql2);
	$valeurs['carouselPointActiveColor']= ($tab_sql2['parametre1'] ? $tab_sql2['parametre1'] : '#dddddd');
	$valeurs['carouselPointActiveHoverColor']= ($tab_sql2['parametre2'] ? $tab_sql2['parametre2'] : '#037BAFvc');
	$valeurs['carouselCSS']= ($tab_sql2['parametre3'] ? $tab_sql2['parametre3'] : '');
	$valeurs['carouselTitre']= ($tab_sql2['parametre4'] ? $tab_sql2['parametre4'] : 'À la une');
	
	$req_sql3=sql_select('*','spip_spipr_educ',"nom='options_articles' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
	$tab_sql3=sql_fetch($req_sql3);
	$valeurs['carouselOrdreArticles']= ($tab_sql3['parametre3'] ? $tab_sql3['parametre3'] : '');

	return $valeurs;
}

function formulaires_spipr_educ_configure_sommaire_carousel_traiter_dist() {
	if (_request('hidden_carousel')=='ok') {
		sql_updateq(
			'spip_spipr_educ',
			array(
				'parametre1' => _request('carouselBackground'),
				'parametre2' => _request('carouselColor'),
				'parametre3' => _request('carouselBorder'),
				'parametre4' => _request('carouselHeaderColor'),
				'parametre5' => _request('carouselArrowColor'),
				'parametre6' => _request('carouselArrowBackground'),
				'parametre7' => _request('carouselArrowHoverBackground'),
				'parametre8' => _request('carouselPointColor'),
				'parametre9' => _request('carouselPointHoverColor'),
				'parametre10' => _request('carouselArrowHoverColor'),
			),
			"nom='graphisme_carousel' AND type='graphisme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
		);
		sql_updateq(
			'spip_spipr_educ',
			array(
				'parametre1' => _request('carouselPointActiveColor'),
				'parametre2' => _request('carouselPointActiveHoverColor'),
				'parametre3' => _request('carouselCSS'),
				'parametre4' => _request('carouselTitre'),
			),
			"nom='graphisme_carousel_2' AND type='graphisme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
		);
		
		include_spip('inc/spipr_educ_traitements_listes');
		$test_articles_une=sql_select('*','spip_spipr_educ',"nom='options_articles' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
		$tab_articles_une=sql_fetch($test_articles_une);
		$chaine=$tab_articles_une['parametre3'];
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
		sql_updateq('spip_spipr_educ',array('parametre3' => $chaine_retour),"nom='options_articles' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
		
	}
	$res['message_ok'] = _T('config_info_enregistree');
	return $res;
}
?>