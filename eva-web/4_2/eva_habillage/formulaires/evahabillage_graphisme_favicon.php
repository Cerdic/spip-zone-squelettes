<?php

if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_evahabillage_graphisme_favicon_charger_dist(){
	//Rien à retourner ici : tout est dans le formulaire html et en php
	$valeurs=array();
	return $valeurs;
}


function formulaires_evahabillage_graphisme_favicon_traiter_dist(){
	$res = array('editable'=>true);
	$res['message_ok'] = 'Aucune modification n\'a &eacute;t&eacute; enregistr&eacute;e';
	// Choix du favicon
	if (_request('nom_favicon')) {
		$test_favicon=sql_select('id','spip_eva_habillage_images',"type = 'favicon'");
		$result_favicon=sql_fetch($test_favicon);
		if (isset($result_favicon['id'])) {
			sql_updateq('spip_eva_habillage_images',array('nom_image' => _request('nom_favicon'),'nom_habillage' => 'Defaut'),'id = '.$result_favicon['id']);
		}
		else {
			sql_insertq('spip_eva_habillage_images',array('type' => 'favicon','nom_image' => _request('nom_favicon'),'nom_habillage' => 'Defaut'));
		}
		$res['message_ok'] = 'Le nouveau favicon du site est <b>'._request('nom_favicon').'</b>';
	}
	// Téléchargement du favicon
	if(	!empty($_FILES['favicon_eva_habillage_envoi']['tmp_name'])
	AND is_uploaded_file($_FILES['favicon_eva_habillage_envoi']['tmp_name'])
	AND ((strpos($_FILES['favicon_eva_habillage_envoi']['name'],'.ico'))
	OR (strpos($_FILES['favicon_eva_habillage_envoi']['name'],'.png'))
	OR (strpos($_FILES['favicon_eva_habillage_envoi']['name'],'.gif'))
	OR (strpos($_FILES['favicon_eva_habillage_envoi']['name'],'.ICO'))
	OR (strpos($_FILES['favicon_eva_habillage_envoi']['name'],'.PNG'))
		OR (strpos($_FILES['favicon_eva_habillage_envoi']['name'],'.GIF')))){
		if(!move_uploaded_file($_FILES['favicon_eva_habillage_envoi']['tmp_name'], _DIR_IMG.'eva_habillage/favicon/'.$_FILES['favicon_eva_habillage_envoi']['name']))
		{echo 'Erreur lors de la copie du fichier';}
		$res['message_ok'] = "L'ic&ocirc;ne <b>".$_FILES['favicon_eva_habillage_envoi']['name']."</b> a &eacute;t&eacute; charg&eacute;e sur le serveur";
	}
	//Suppression d'un favicon précédemment téléchargé
	if (_request('submit_supprim_favicon')) {
		sql_delete('spip_eva_habillage_images',"id="._request('supprim_favicon'));
	}
	return $res;
}