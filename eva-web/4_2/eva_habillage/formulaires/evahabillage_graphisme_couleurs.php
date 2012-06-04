<?php

if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_evahabillage_graphisme_couleurs_charger_dist(){
	//Rien � retourner ici : tout est dans le formulaire html et en php
	$valeurs=array();
	return $valeurs;
}


function formulaires_evahabillage_graphisme_couleurs_traiter_dist(){
	$res = array('editable'=>true);
	$res['message_ok'] = 'Aucune modification n\'a &eacute;t&eacute; enregistr&eacute;e';
	include_spip("inc/eva_habillage_definition_themes");
	$mon_theme=eva_habillage_definition_themes ();
	$resultat_themes_defini = sql_select('*','spip_eva_habillage_themes',"nom='Defaut'");
	$tableau_themes_defini = sql_fetch($resultat_themes_defini);
	if (_request('eva_choix_fond')) {
		foreach($mon_theme as $habillage_cles => $habillage_inutile) {
			if (strpos($habillage_cles,'fond_')!==FALSE) {
					sql_updateq('spip_eva_habillage_themes',array($habillage_cles=>_request($habillage_cles)),"nom='Defaut'");
			}
		}
		$res['message_ok'] = 'Modification des couleurs de fond enregistr&eacute;e';
	}
	return $res;
}

