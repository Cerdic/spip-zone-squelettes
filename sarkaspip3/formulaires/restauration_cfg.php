<?php
function formulaires_restauration_cfg_charger_dist($fond, $items_langue=array()){
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

	$dir = sous_repertoire(_DIR_TMP,"cfg");
	$saves = preg_files($dir, $fond);
	$options = '';
	foreach ($saves as $_fichier) {
		$nom = basename($_fichier);
		$options .= '<option value="' . $_fichier . '">' . $nom . '</option>';
	}
	$args = array_merge($args, array('_fichiers_sauvegardes' => $options));

	return $args;
}

function formulaires_restauration_cfg_verifier_dist($fond, $items_langue=array()){
	return array();
}

function formulaires_restauration_cfg_traiter_dist($fond, $items_langue=array()){
	$message=array();
	
	$fichier = _request('fichier_sauvegarde');
	lire_fichier($fichier,$tableau);

	$ok = ecrire_config($fond, $tableau);
	
	if (!$ok) $message['message_nok'] = _T('sarkaspip:cfg_msg_fichier_restauration_nok');
	if ($ok) $message['message_ok'] = _T('sarkaspip:cfg_msg_fichier_restauration_ok', array('nom_fichier' => $fichier));
	return $message;
}
?>
