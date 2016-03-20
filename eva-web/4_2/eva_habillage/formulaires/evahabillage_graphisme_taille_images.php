<?php

if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_evahabillage_graphisme_taille_images_charger_dist(){
	//Rien à retourner ici : tout est dans le formulaire html et en php
	$valeurs=array();
	return $valeurs;
}


function formulaires_evahabillage_graphisme_taille_images_traiter_dist(){
	$res = array('editable'=>true);
	$res['message_ok'] = 'Aucune modification n\'a &eacute;t&eacute; enregistr&eacute;e';
	// Tailles des images
	if (_request('test_taille_images')) {
		sql_delete('spip_eva_habillage_images',"type='logos' AND nom_habillage='Defaut' AND nom_div='largeur_image_article'");
		if (is_numeric(_request('largeur_image_article'))) {$image_article=_request('largeur_image_article');} else {$image_article='';}
		sql_insertq('spip_eva_habillage_images',array('type'=>'logos','nom_habillage'=>'Defaut','nom_div'=>'largeur_image_article','nom_image'=>$image_article));
		$res['message_ok'] = 'Les tailles des images ont &eacute;t&eacute; modifi&eacute;es';
	}
	return $res;
}