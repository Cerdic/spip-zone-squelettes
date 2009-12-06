<?php
function formulaires_restauration_cfg_charger_dist($dir_fonds, $items_langue=array()){
	$items=array();
	foreach ($items_langue as $_cle => $_item) {
		$index = '_' . $_cle;
		$items[$index] = $_item;
	}

	$args = array_merge(array('_titre' => _T('cfg:charger_meta_titre'),
								'_legende' => _T('cfg:charger_meta_legende'),
								'_label' => _T('cfg:charger_meta_label'),
								'_description' => _T('cfg:charger_meta_description')),
								$items);

	$fonds = array();
	$fichiers_cfg = preg_files($dir_fonds, "cfg_[^/]*[.]html$");
	foreach ($fichiers_cfg as $_fichier) {
		$fond = substr(basename($_fichier,'.html'), 4);
		$fonds[$fond] = _T("sarkaspip:$fond");
	}

	$dir = sous_repertoire(_DIR_TMP,"cfg");
	$saves = preg_files($dir, implode('|', array_flip($fonds)));
	$options = '';
	$groupe = '';
	foreach ($saves as $_fichier) {
		$nom = basename($_fichier);
		$_dir = end(explode('/', dirname($_fichier)));
		if ($_dir != $groupe) {
			if ($options) $options .= '</optgroup>';
			$options .= '<optgroup style="font-weight: strong;" label="'.$fonds[$_dir].'">';
			$groupe = $_dir;
		}
		$options .= '<option value="' . $_fichier . '">' . $nom . '</option>';
	}
	if ($options) $options .= '</optgroup>';
	$args = array_merge($args, array('_fichiers_sauvegardes' => $options));

	return $args;
}

function formulaires_restauration_cfg_verifier_dist($dir_fonds, $items_langue=array()){
	return array();
}

function formulaires_restauration_cfg_traiter_dist($dir_fonds, $items_langue=array()){
	$message=array();
	
	$fichier = _request('fichier_a_restaurer');
	lire_fichier($fichier,$tableau);

	$fond = end(explode('/', dirname($fichier)));
	$ok = ecrire_config($fond, $tableau);
	
	if (!$ok) $message['message_nok'] = _T('sarkaspip:cfg_msg_fichier_restauration_nok');
	if ($ok) $message['message_ok'] = _T('sarkaspip:cfg_msg_fichier_restauration_ok', array('nom_fichier' => $fichier));
	return $message;
}
?>
