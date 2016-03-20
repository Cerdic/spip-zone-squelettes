<?php

if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_evahabillage_article_nbre_charger_dist(){
	//Rien à retourner ici : tout est dans le formulaire html et en php
	$valeurs=array();
	return $valeurs;
}

function formulaires_evahabillage_article_nbre_traiter_dist(){
	$res = array('editable'=>true);
	$res['message_ok'] = 'Aucune modification n\'a &eacute;t&eacute; enregistr&eacute;e';
	if (_request('submit_nbre_article')) {
		include_spip("inc/eva_habillage_definition_themes");
		$les_blocs_array = EVA_mes_nbres();
		$val_nbre=$les_blocs_array['EVA_nbre_article'];
		foreach($val_nbre as $val) {
			if (_request($val)) {
				sql_delete('spip_eva_habillage_images',"nom_habillage='Defaut' AND nom_div='".$val."'");
				sql_insertq('spip_eva_habillage_images',array('type' => 'nbre','nom_habillage' => 'Defaut','nom_div' => $val,'nom_image' => _request($val)));
			}
		}
		$res['message_ok'] = 'Modification enregistr&eacute;e';
	}
	return $res;
}