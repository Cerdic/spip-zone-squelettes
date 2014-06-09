<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function formulaires_sauvegarde_cfg_charger_dist() {
	include_spip('inc/sarkaspip_configuration');

	$options = creer_select_configurations();
	$valeurs = array('_configurations' => $options);

	return $valeurs;
}


function formulaires_sauvegarde_cfg_traiter_dist() {
	$retour=array();
	
	$configs = array();
	$page = _request('config_a_sauvegarder');
	if ($page !== '--')
		$configs = array($page);

	$dir_cfg = sous_repertoire(_DIR_TMP,"sarkaspip");
	$dir_cfg = sous_repertoire($dir_cfg,"config");
	$ok = sauvegarder_configuration($configs, $dir_cfg);
	
	if (!$ok)
		$retour['message_nok'] = _T('sarkaspip_config:cfg_msg_fichier_sauvegarde_nok');
	elseif ($page !== '--')
		$retour['message_ok'] = _T('sarkaspip_config:cfg_msg_fichier_sauvegarde_ok', array('page' =>  _T("sarkaspip_config:sarkaspip_$page")));
	else
		$retour['message_ok'] = _T('sarkaspip_config:cfg_msg_fichiers_sauvegardes_ok');
	return $retour;
}


/**
 * Cree les sauvegardes d'une liste de fonds dans le repertoire temporaire tmp/sarkaspip/config
 *
 * @param $configs
 * @param $ou
 * @return bool
 */
function sauvegarder_configuration($configs, $ou) {
	include_spip('inc/config');
	$ok = true;

	// si pas de fond precise, on prend toutes les configs
	if (!$configs) {
		$sections = explode('|',_SARKASPIP_PAGES_CONFIG);
		foreach ($sections as $_section){
			$_section = explode("!",$_section);
			$_section = end($_section);
			$configs = array_merge($configs, array_map('trim',explode(":",$_section)));
		}
	}

	$dir = $ou;
	foreach ($configs as $_config) {
		$dir = sous_repertoire($ou, $_config);
		$nom = $_config . "_" . date("Ymd_Hi") . ".txt";
		$fichier = $dir . $nom;
		$ok = ecrire_fichier($fichier, serialize(lire_config("sarkaspip_$_config")));
	}

	return $ok;
}

?>