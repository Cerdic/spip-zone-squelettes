<?php
if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_spipr_educ_configure_bloc_type_liste_charger_dist($nom,$id) {
	$tab_titre_bloc=array(
		'sommaire_derniers_articles'=>_T('spipr_educ:derniers_articles'),
		'sommaire_dernieres_breves'=>_T('spipr_educ:dernieres_breves'),
		'sommaire_articles_syndiques'=>_T('spipr_educ:nouveau_web'),
		'sommaire_evenements'=>_T('agenda:evenements'),
		'sommaire_forums'=>_T('spipr_educ:derniers_commentaires'),
		'rubrique_articles'=>_T('spipr_educ:derniers_articles'),
		'rubrique_breves'=>_T('breves:breves'),
		'rubrique_sites'=>_T('spipr_educ:nouveau_web'),
		'rubrique_evenements'=>_T('agenda:evenements'),
		'article_evenements'=>_T('agenda:evenements'),
		'article_meme_rubrique'=>_T('spipr_educ:meme_rubrique'),
		'breve_evenements'=>_T('agenda:evenements'),
		'breve_meme_rubrique'=>_T('spipr_educ:autres_breves'),
		'site_articles_syndiques'=>_T('spipr_educ:articles'),
		'site_autres_sites'=>_T('spipr_educ:sites_web'),
		'site_evenements'=>_T('agenda:evenements'),
		'auteur_articles'=>_T('spipr_educ:articles_auteur'),
		'auteur_autres_auteurs'=>_T('spipr_educ:autres_auteurs'),
		'auteur_evenements'=>_T('agenda:evenements'),
		'autre_evenements'=>_T('agenda:evenements'),
	);
	$req_sql=sql_select('*','spip_spipr_educ',"id='$id'");
	$tab_sql=sql_fetch($req_sql);
	$valeurs = array (
		'nom' => $nom,
		'id' => $id,
		'pagination' => $tab_sql['parametre5'],
		'blocCSS' => $tab_sql['parametre6'],
		'blocTitre' => ($tab_sql['parametre7'] ? $tab_sql['parametre7'] : $tab_titre_bloc[$nom]),
	);
	return $valeurs;
}

function formulaires_spipr_educ_configure_bloc_type_liste_traiter_dist($nom,$id) {
	if (_request('hidden_pagination')=='ok') {
		sql_updateq(
			'spip_spipr_educ',
			array(
				'parametre5' => _request('pagination'),
				'parametre6' => _request('blocCSS'),
				'parametre7' => _request('blocTitre'),
			),
			"id='$id'"
		);
	}
	$res['message_ok'] = _T('config_info_enregistree');
	return $res;
}
?>