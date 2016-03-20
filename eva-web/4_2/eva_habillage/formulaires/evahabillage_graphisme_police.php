<?php

if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_evahabillage_graphisme_police_charger_dist(){
	//Rien à retourner ici : tout est dans le formulaire html et en php
	$valeurs=array();
	return $valeurs;
}


function formulaires_evahabillage_graphisme_police_traiter_dist(){
	$res = array('editable'=>true);
	$res['message_ok'] = 'Aucune modification n\'a &eacute;t&eacute; enregistr&eacute;e';
	if (_request('modif_police')) {
		include_spip("inc/eva_habillage_definition_themes");
		foreach (EVA_def_textes() as $habillage_modif_cles => $habillage_modif_inutile) {
			$mes_modifs_tableau[$habillage_modif_cles] =_request($habillage_modif_cles);
		}
		sql_updateq('spip_eva_habillage_themes',$mes_modifs_tableau,"nom='Defaut'");
		$res['message_ok'] = 'Modification de la police enregistr&eacute;e';
	}
	return $res;
}