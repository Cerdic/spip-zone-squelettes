<?php

if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_evasquelettes_multilangue_charger_dist() {
	foreach(array(
		"evamultilinguisme"
		) as $m)
		$valeurs[$m] = 'non';
		$test=sql_showtable('spip_eva_habillage_images',true);
		if ($test['field']) {
			$test=sql_select('nom_image','spip_eva_habillage_images',"type='multilinguisme' AND nom_habillage='Defaut' AND nom_div='menu_langue_actif'");
			$tab=sql_fetch($test);
			$go=$tab['nom_image'];
			if ($go) $valeurs[$m] = 'oui';
		}
	return $valeurs;
}


function formulaires_evasquelettes_multilangue_traiter_dist() {
	$res = array('editable'=>true);
	foreach(array(
		"evamultilinguisme"
		) as $m)
		if (!is_null($v=_request($m))) {
			if ($v=='oui') {
				sql_delete('spip_eva_habillage_images',"type='multilinguisme' AND nom_habillage='Defaut' AND nom_div='menu_langue_actif'");
				sql_insertq('spip_eva_habillage_images',array(
				'type' => 'multilinguisme',
				'nom_habillage' => 'Defaut',
				'nom_div' => 'menu_langue_actif',
				'nom_image' => 'oui'));
			}
			elseif ($v=='non') sql_delete('spip_eva_habillage_images',"type='multilinguisme' AND nom_habillage='Defaut' AND nom_div='menu_langue_actif'");
		}
	$res['message_ok'] = _T('config_info_enregistree');
	return $res;
}