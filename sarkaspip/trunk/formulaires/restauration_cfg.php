<?php
function formulaires_restauration_cfg_charger_dist(){
	$fonds = array();

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
			$fonds[$fond] = _T("sarkaspip:$fond");
		}
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
	$valeurs = array('_fichiers_sauvegardes' => $options);

	return $valeurs;
}

function formulaires_restauration_cfg_verifier_dist(){
	return array();
}

function formulaires_restauration_cfg_traiter_dist(){
	$message=array();
	
	$fichier = _request('fichier_a_restaurer');
	lire_fichier($fichier,$tableau);

	include_spip('inc/config');
	$fond = end(explode('/', dirname($fichier)));
	$fond = str_replace("sarkaspip_","sarkaspip/",$fond);
	$ok = ecrire_config($fond, $tableau);
	
	if (!$ok) $message['message_nok'] = _T('sarkaspip:cfg_msg_fichier_restauration_nok');
	if ($ok) $message['message_ok'] = _T('sarkaspip:cfg_msg_fichier_restauration_ok', array('nom_fichier' => $fichier));
	return $message;
}

?>
