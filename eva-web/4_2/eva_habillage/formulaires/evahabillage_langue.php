<?php

if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_evahabillage_langue_charger_dist(){
	$valeurs=array();
	// Langue courante
	global  $spip_lang;
	$valeurs['langue_courante'] = $spip_lang;
	return $valeurs;
}


function formulaires_evahabillage_langue_traiter_dist(){
	$res = array('editable'=>true);
	include (_DIR_PLUGIN_EVASQUELETTES.'lang/local_fr.php');
	foreach ($langue_fichier_initial as $cle => $val) {
		sql_delete('spip_eva_habillage_images',"type = 'fichier_lang' AND attach='"._request('langue')."' AND nom_habillage = 'Defaut' AND nom_div = '".$cle."'");
		if (_request($cle)) {
			sql_insertq('spip_eva_habillage_images',array('type' => 'fichier_lang','nom_habillage' => 'Defaut','nom_div' => $cle,'nom_image' => _request($cle),'attach' => _request('langue')));
		}
	}
	$res['message_ok'] = _T('config_info_enregistree');
	return $res;
}