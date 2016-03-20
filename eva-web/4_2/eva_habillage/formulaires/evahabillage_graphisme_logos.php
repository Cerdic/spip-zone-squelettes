<?php

if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_evahabillage_graphisme_logos_charger_dist(){
	//Rien à retourner ici : tout est dans le formulaire html et en php
	$valeurs=array();
	return $valeurs;
}


function formulaires_evahabillage_graphisme_logos_traiter_dist(){
	$res = array('editable'=>true);
	$res['message_ok'] = 'Aucune modification n\'a &eacute;t&eacute; enregistr&eacute;e';
	// Tailles des logos
	if (_request('test_logotaille')) {
		if (is_numeric(_request('largeur_mini_logo'))) {$logo1l=_request('largeur_mini_logo');} else {$logo1l='';}
		if (is_numeric(_request('hauteur_mini_logo'))) {$logo1h=_request('hauteur_mini_logo');} else {$logo1h='';}
		if (is_numeric(_request('largeur_petit_logo'))) {$logo2l=_request('largeur_petit_logo');} else {$logo2l='';};
		if (is_numeric(_request('hauteur_petit_logo'))) {$logo2h=_request('hauteur_petit_logo');} else {$logo2h='';}
		if (is_numeric(_request('largeur_logo_moyen'))) {$logo3l=_request('largeur_logo_moyen');} else {$logo3l='';}
		if (is_numeric(_request('hauteur_logo_moyen'))) {$logo3h=_request('hauteur_logo_moyen');} else {$logo3h='';}
		sql_delete('spip_eva_habillage_images',"type='logos' AND nom_habillage='Defaut'");
		sql_insertq('spip_eva_habillage_images',array('type'=>'logos','nom_habillage'=>'Defaut','nom_div'=>'largeur_mini_logo','nom_image'=>$logo1l));
		sql_insertq('spip_eva_habillage_images',array('type'=>'logos','nom_habillage'=>'Defaut','nom_div'=>'hauteur_mini_logo','nom_image'=>$logo1h));
		sql_insertq('spip_eva_habillage_images',array('type'=>'logos','nom_habillage'=>'Defaut','nom_div'=>'largeur_petit_logo','nom_image'=>$logo2l));
		sql_insertq('spip_eva_habillage_images',array('type'=>'logos','nom_habillage'=>'Defaut','nom_div'=>'hauteur_petit_logo','nom_image'=>$logo2h));
		sql_insertq('spip_eva_habillage_images',array('type'=>'logos','nom_habillage'=>'Defaut','nom_div'=>'largeur_logo_moyen','nom_image'=>$logo3l));
		sql_insertq('spip_eva_habillage_images',array('type'=>'logos','nom_habillage'=>'Defaut','nom_div'=>'hauteur_logo_moyen','nom_image'=>$logo3h));
		$res['message_ok'] = 'Les tailles des logos ont &eacute;t&eacute; modifi&eacute;es';
	}
	return $res;
}