<?php
function formulaires_sauvegarde_cfg_charger_dist($dir_fonds, $items_langue=array()){
	$items=array();
	foreach ($items_langue as $_cle => $_item) {
		$index = '_' . $_cle;
		$items[$index] = $_item;
	}

	$options = '';
	$fichiers_cfg = preg_files($dir_fonds, "cfg_[^/]*[.]html$");
	foreach ($fichiers_cfg as $_fichier) {
		$fond = substr(basename($_fichier,'.html'), 4);
		$options .= '<option value="' . $fond . '">' . _T("sarkaspip:$fond") . '</option>';
	}

	$args = array_merge(array('_titre' => _T('cfg:sauver_meta_titre'),
								'_legende' => _T('cfg:sauver_meta_legende'),
								'_choix' => _T('cfg:sauver_meta_choix'),
								'_label_oui' => _T('cfg:label_oui'),
								'_label_non' => _T('cfg:label_non'),
								'_label_fond' => _T('cfg:sauver_meta_fond'),
								'_description' => _T('cfg:sauver_meta_description'),
								'_fonds' => $options),
								$items);

	return $args;
}

function formulaires_sauvegarde_cfg_verifier_dist($dir_fonds, $items_langue=array()){
	return array();
}

function formulaires_sauvegarde_cfg_traiter_dist($dir_fonds, $items_langue=array()){
	$message=array();
	
	$fonds = array();
	$mode = _request('mode');
	if ($mode == 'page')
		$fonds[] = _request('fond_a_sauvegarder');
	else {
		$fichiers_cfg = preg_files($dir_fonds, "cfg_[^/]*[.]html$");
		foreach ($fichiers_cfg as $_fichier) {
			$fonds[] = substr(basename($_fichier,'.html'), 4);
		}
	}
	$dir_cfg = sous_repertoire(_DIR_TMP,"cfg");
	include_spip('inc/sarkaspip_filtres');
	$ok = sauvegarder_fonds($fonds, $dir_cfg, 'maintenance');
	
	if (!$ok) $message['message_nok'] = _T('sarkaspip:cfg_msg_fichier_sauvegarde_nok');
	if ($ok) 
		if ($mode == 'page')
			$message['message_ok'] = _T('sarkaspip:cfg_msg_fichier_sauvegarde_ok', array('nom_fichier' => $nom));
		else
			$message['message_ok'] = _T('sarkaspip:cfg_msg_fichiers_sauvegardes_ok');
	return $message;
}
?>
