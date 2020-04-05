<?php
if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_spipr_educ_restaurer_charger_dist($page) {
	$tab = array(
		'sommaire' => 'votre sommaire',
		'rubrique' => 'vos rubriques',
		'article' => 'vos articles',
		'breve' => 'vos brèves',
		'site' => 'vos sites',
		'auteur' => 'vos pages de type auteur'
	);
	$valeurs = array (
		'page' => $page,
		'page_texte' => $tab[$page]
	);
	return $valeurs;
}

function formulaires_spipr_educ_restaurer_traiter_dist($page) {
	if ((_request('id_bloc', $_POST)!='') AND (_request('nom_secteur', $_POST)!='')) {
		include_spip('inc/spipr_educ_deplacement_bloc');
		spipr_educ_bloc_reintegrer(_request('id_bloc', $_POST),_request('nom_secteur', $_POST));
		echo "<script type='text/javascript'>if (window.jQuery) ajaxReload('".$page."_"._request('nom_secteur', $_POST)."');</script>";
		$res['message_ok'] = _T('config_info_enregistree');
	}
	else {$res['message_erreur'] = 'Configuration non enregistrée';}
	return $res;
}
?>