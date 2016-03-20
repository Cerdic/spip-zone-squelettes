<?php

if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_evahabillage_structure_charger_dist() {

	// S'il n'y a pas encore d'habillage par défaut défini, on pose l'habillage eva4_menu_gauche.css
	$test_fri=sql_select('id_habillage','spip_eva_habillage',"sauvegarde='Defaut'");
	$tab_fri=sql_fetch($test_fri);
	if (!isset($tab_fri['id_habillage'])) {sql_insertq('spip_eva_habillage',array('habillage' => 'eva4_menu_gauche.css','sauvegarde' => 'Defaut'));}

	//On charge maintenant l'habillage précédemment défini
	$resultat1 = sql_select('habillage','spip_eva_habillage',"sauvegarde = 'Defaut'");
	$resultat1_tableau = sql_fetch($resultat1);
	$mon_habillage = $resultat1_tableau['habillage'];

	// Si on est encore avec un habillage par défaut en version EVA 4.1 (habillage 0), alors on passe en habillage par défaut EVA 4.2 (eva4_menu_gauche.css)
	if ($mon_habillage=='0') {
		sql_updateq('spip_eva_habillage',array('habillage' => 'eva4_menu_gauche.css'),"sauvegarde = 'Defaut'");
	}

	$valeurs=array();
	$valeurs['changement_habillage'] = $mon_habillage;
	$image_habillage = preg_replace('/.css/','.png',$mon_habillage);
	$valeurs['nom_vignette'] = $image_habillage;
	$valeurs['chemin_vignettes'] = _DIR_PLUGIN_EVASQUELETTES."images/vignettes_styles/";
	$valeurs['chemin_styles'] = _DIR_PLUGIN_EVASQUELETTES."eva_styles/";
	return $valeurs;
}


function formulaires_evahabillage_structure_traiter_dist() {
	$res = array('editable'=>true);
	foreach(array("changement_habillage") as $m) {
		sql_updateq('spip_eva_habillage',array('habillage' => _request($m)),"sauvegarde = 'Defaut'");
	}
	$res['message_ok'] = _T('config_info_enregistree');
	return $res;
}