<?php
if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_spipr_educ_ajout_bloc_charger_dist($page) {
	$valeurs = array (
		'page' => $page
	);
	return $valeurs;
}

function formulaires_spipr_educ_ajout_bloc_traiter_dist($page) {
	if ((_request('nom_bloc', $_POST)!='') AND (_request('nom_secteur', $_POST)!='')) {
		include_spip('inc/spipr_educ_deplacement_bloc');
		spipr_educ_ajout_bloc_personnel($page,$_POST['nom_secteur'],$_POST['nom_bloc']);
		echo "<script type='text/javascript'>if (window.jQuery) ajaxReload('".$page."_"._request('nom_secteur', $_POST)."');</script>";
		$res['message_ok'] = _T('config_info_enregistree');
	}
	else {$res['message_erreur'] = 'Configuration non enregistrée';}
	return $res;
}
?>