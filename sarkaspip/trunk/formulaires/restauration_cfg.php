<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function formulaires_restauration_cfg_charger_dist(){
	$configs = array();

	$pages = lister_pages_configuration();
	foreach ($pages as $_page) {
		$item = "sarkaspip_{$_page}";
		$configs[$_page] = _T("sarkaspip_config:$item");
	}

	$dir_cfg = sous_repertoire(_DIR_TMP,"sarkaspip");
	$dir_cfg = sous_repertoire($dir_cfg,"config");
	$sauvegardes = preg_files($dir_cfg, implode('|', array_flip($configs)));
	$options = '';
	$erreur = '';
	if (!$sauvegardes) {
		$erreur = _T('sarkaspip_config:cfg_msg_aucune_sauvegarde');
	}
	else {
		$groupe = '';
		foreach ($sauvegardes as $_fichier) {
			$nom = basename($_fichier);
			$dirs = explode('/', dirname($_fichier));
			$dir = end($dirs);
			if ($dir != $groupe) {
				if ($options) $options .= '</optgroup>';
				$options .= '<optgroup style="font-weight: strong;" label="'.$configs[$dir].'">';
				$groupe = $dir;
			}
			$options .= '<option value="' . $_fichier . '">' . $nom . '</option>';
		}
		if ($options) $options .= '</optgroup>';
	}

	$valeurs = array('_fichiers_sauvegardes' => $options, '_erreur_sauvegarde' => $erreur);

	return $valeurs;
}


function formulaires_restauration_cfg_traiter_dist(){
	$retour=array();
	
	$fichier = _request('config_a_restaurer');
	lire_fichier($fichier, $contenu);

	include_spip('inc/config');
	$dirs = explode('/', dirname($fichier));
	$page = end($dirs);

	include_spip('inc/sarkaspip_configuration');
	$ok = creer_config(array($page), 'restauration', array($page => unserialize($contenu)));
	
	if (!$ok)
		$retour['message_nok'] = _T('sarkaspip_config:cfg_msg_fichier_restauration_nok');
	else
		$retour['message_ok'] = _T('sarkaspip_config:cfg_msg_fichier_restauration_ok', array('nom_fichier' => $fichier));

	return $retour;
}

?>
