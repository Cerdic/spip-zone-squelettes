<?php
function formulaires_sauvegarde_cfg_charger_dist($fond, $items_langue=array()){
	$items=array();
	foreach ($items_langue as $_cle => $_item) {
		$index = '_' . $_cle;
		$items[$index] = $_item;
	}

	$args = array_merge(array('_titre' => _T('cfg:sauver_meta_titre'),
								'_legende' => _T('cfg:sauver_meta_legende'),
								'_description' => _T('cfg:sauver_meta_description')),
								$items);

	return $args;
}

function formulaires_sauvegarde_cfg_verifier_dist($fond, $items_langue=array()){
	return array();
}

function formulaires_sauvegarde_cfg_traiter_dist($fond, $items_langue=array()){
	$message=array();
	
	$dir = sous_repertoire(_DIR_TMP,"cfg");
	$nom = $fond . "_" . date("Ymd_Hi") . ".txt";
	$f = $dir . $nom;
	$ok = ecrire_fichier($f, serialize(lire_config($fond)));
	
	if (!$ok) $message['message_nok'] = _T('sarkaspip:cfg_msg_fichier_sauvegarde_nok');
	if ($ok) $message['message_ok'] = _T('sarkaspip:cfg_msg_fichier_sauvegarde_ok', array('nom_fichier' => $nom));
	return $message;
}
?>