<?php

if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_evahabillage_menu_langue_graphisme_charger_dist(){
	//Rien à retourner ici : tout est dans le formulaire html et en php
	$valeurs=array();
	return $valeurs;
}


function formulaires_evahabillage_menu_langue_graphisme_traiter_dist() {
	$res = array('editable'=>true);
	$res['message_ok'] = 'Aucune modification n\'a &eacute;t&eacute; enregistr&eacute;e';
	//On traite ici la modification des positions des blocs
	if (_request('test_menu_langue')=='Valider') {
		include_spip('inc/eva_habillage_definition_themes');
		$tab_menu_lang=EVA_menu_langue();
		foreach ($tab_menu_lang as $cle => $value) {
			sql_delete('spip_eva_habillage_images',"nom_habillage = 'Defaut' AND type='multilinguisme' AND nom_div='".$cle."'");
			sql_insertq('spip_eva_habillage_images',array('nom_habillage' => 'Defaut','type' => 'multilinguisme','nom_div' => $cle,'nom_image' => _request($cle)));
		}
		$res['message_ok'] = 'Choix graphiques pour le menu de langue enregistr&eacute;s.';
	}
	return $res;
}