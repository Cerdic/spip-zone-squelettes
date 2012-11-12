<?php
function formulaires_sauvegarde_cfg_charger_dist() {

	$options = '';

	$pages_cfg = array();
	$sections = explode('|',_SARKASPIP_PAGES_CONFIG);
	foreach ($sections as $section){
		$section = explode("!",$section);
		$section = end($section);
		$pages_cfg = $pages_cfg + array_map('trim',explode(":",$section));
	}


	foreach ($pages_cfg as $_page) {
		if ($_page != 'maintenance') {
			$fond = "sarkaspip_{$_page}";
			$options .= '<option value="' . $fond . '">' . _T("sarkaspip:$fond") . '</option>';
		}
	}

	$valeurs = array('_fonds' => $options);

	return $valeurs;
}

function formulaires_sauvegarde_cfg_verifier_dist() {
	return array();
}

function formulaires_sauvegarde_cfg_traiter_dist() {
	$message=array();
	
	$fonds = null;
	$mode = _request('fond_a_sauvegarder');
	if ($mode !== '--')
		$fonds = array($mode);

	$dir_cfg = sous_repertoire(_DIR_TMP,"cfg");
	$ok = sauvegarder_fonds($fonds, $dir_cfg, 'maintenance');
	
	if (!$ok) $message['message_nok'] = _T('sarkaspip:cfg_msg_fichier_sauvegarde_nok');
	if ($ok) 
		if ($mode == 'page')
			$message['message_ok'] = _T('sarkaspip:cfg_msg_fichier_sauvegarde_ok', array('nom_fichier' => $nom));
		else
			$message['message_ok'] = _T('sarkaspip:cfg_msg_fichiers_sauvegardes_ok');
	return $message;
}


// =======================================================================================================================================
// Filtre : sauvegarder_fonds
// =======================================================================================================================================
// Auteur: Smellup
// Fonction : Cree les sauvegardes d'une liste de fonds suivant un format et dans un repertoire donne
// =======================================================================================================================================
//
function sauvegarder_fonds($fonds, $ou) {
	include_spip('inc/config');

	// si pas de fond precise, on prend toutes les configs de la meta
	if (is_null($fonds))
		$fonds = array_keys(lire_config("sarkaspip"));

	$dir = $ou;
	foreach ($fonds as $fond) {
		$dir = sous_repertoire($ou, $fond);
		$nom = $fond . "_" . date("Ymd_Hi") . ".txt";
		$f = $dir . $nom;
		$ok = ecrire_fichier($f, serialize(lire_config("sarkaspip/$fond")));
	}

	return $ok;
}
// FIN du Filtre : sauvegarder_fonds

?>