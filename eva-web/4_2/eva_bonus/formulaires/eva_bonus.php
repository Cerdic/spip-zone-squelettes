<?php

if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_eva_bonus_charger_dist(){
	//On retourne ici le service choisi et le code commune
	$req_service=sql_select('nom_image','spip_eva_habillage_images',"type='evabonus' AND nom_habillage='Defaut' AND nom_div='service'");
	$tab_service=sql_fetch($req_service);
	$service=$tab_service['nom_image'];
	
	$req_meteo=sql_select('nom_image','spip_eva_habillage_images',"type='evabonus' AND nom_habillage='Defaut' AND nom_div='code_commune'");
	$tab_meteo=sql_fetch($req_meteo);
	$code_commune=$tab_meteo['nom_image'];
	
	$req_prev=sql_select('nom_image','spip_eva_habillage_images',"type='evabonus' AND nom_habillage='Defaut' AND nom_div='jours_prevision'");
	$tab_prev=sql_fetch($req_prev);
	$jours_prevision=$tab_prev['nom_image'];
	
	$valeurs=array(
	'service'=>$service,
	'code_commune'=>$code_commune,
	'jours_prevision'=>$jours_prevision);
	return $valeurs;
}


function formulaires_eva_bonus_traiter_dist(){
	$res = array('editable'=>true);
	$res['message_ok'] = 'Aucune modification n\'a &eacute;t&eacute; enregistr&eacute;e';
	//On traite ici le choix du service météo
	if (_request('service')) {
		sql_delete('spip_eva_habillage_images',"type='evabonus' AND nom_habillage='Defaut' AND nom_div='service'");
		sql_insertq('spip_eva_habillage_images',array(
			'type' => 'evabonus',
			'nom_habillage' => 'Defaut',
			'nom_div' => 'service',
			'nom_image' => _request('service')
			));
		$res['message_ok'] = 'Le choix du service de météo a été enregistré';
	}
	
	//On traite ensuite le code commune
	if (_request('code_commune')) {
		sql_delete('spip_eva_habillage_images',"type='evabonus' AND nom_habillage='Defaut' AND nom_div='code_commune'");
		sql_insertq('spip_eva_habillage_images',array(
			'type' => 'evabonus',
			'nom_habillage' => 'Defaut',
			'nom_div' => 'code_commune',
			'nom_image' => _request('code_commune')
			));
		$res['message_ok'] = 'Vos choix ont été enregistrés';
	}
	
	//On traite enfin le nombre de jours pour la noisette de prévision
	if (_request('jours_prevision')) {
		sql_delete('spip_eva_habillage_images',"type='evabonus' AND nom_habillage='Defaut' AND nom_div='jours_prevision'");
		sql_insertq('spip_eva_habillage_images',array(
			'type' => 'evabonus',
			'nom_habillage' => 'Defaut',
			'nom_div' => 'jours_prevision',
			'nom_image' => _request('jours_prevision')
			));
		$res['message_ok'] = 'Vos choix ont été enregistrés';
	}
	
	return $res;
}