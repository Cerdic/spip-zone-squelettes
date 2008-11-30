<?php
function formulaires_restauration_cfg_charger_dist($fond, $items_langue=array()){
	$items=array();
	foreach ($items_langue as $_cle => $_item) {
		$index = '_' . $_cle;
		$items[$index] = $_item;
	}

	$args = array_merge(array('_titre' => _T('cfg:charger_meta_titre'),
								'_legende' => _T('cfg:charger_meta_legende'),
								'_description' => _T('cfg:charger_meta_description')),
								$items);

	$dir = sous_repertoire(_DIR_TMP,"cfg");
	$save = preg_files($dir, $fond);

	return $args;
}

function formulaires_restauration_cfg_verifier_dist($fond, $items_langue=array()){
	return array();
}

function formulaires_restauration_cfg_traiter_dist($fond, $items_langue=array()){
	$message=array();
	
	if (!$ok) $message['message_nok'] = _T('sarkaspip:cfg_msg_fichier_restauration_nok');
	if ($ok) $message['message_ok'] = _T('sarkaspip:cfg_msg_fichier_restauration_ok', array('nom_fichier' => $nom));
	return $message;
}
?>