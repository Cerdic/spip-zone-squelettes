<?php
if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_spipr_educ_config_fichier_fond_charger_dist() {
	$valeurs = array ();
	$dir = opendir(_DIR_IMG."spipr_educ");
	while ($nom_fichier = readdir($dir)) {
		if (($nom_fichier!='.') AND ($nom_fichier!='..') AND ($nom_fichier!='favicon')) {
			$valeurs['presence_fichier']='oui';
		}
	}
	return $valeurs;
}

function formulaires_spipr_educ_config_fichier_fond_traiter_dist() {
	$res = array();
	if (_request('nomfichier')!='') {
		sql_updateq(
			'spip_spipr_educ',
			array(
				'parametre1' => _request('nomfichier'),
				'parametre2' => _request('positionverticale'),
				'parametre3' => _request('positionverticale_valeur'),
				'parametre4' => _request('positionhorizontale'),
				'parametre5' => _request('positionhorizontale_valeur'),
				'parametre6' => _request('repetition'),
				'parametre7' => _request('attachement'),
			),
			"nom='"._request('secteurfichier')."' AND type='graphisme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
		);
		echo "<script type='text/javascript'>if (window.jQuery) ajaxReload('presente_images_fond');</script>";
		$res['message_ok'] = _T('config_info_enregistree');
	}
	return $res;
}
?>