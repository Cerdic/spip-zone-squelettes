<?php

if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_evahabillage_graphisme_flash_charger_dist(){
	//Rien à retourner ici : tout est dans le formulaire html et en php
	$valeurs=array();
	return $valeurs;
}


function formulaires_evahabillage_graphisme_flash_traiter_dist(){
	$res = array('editable'=>true);
	$res['message_ok'] = 'Aucune modification n\'a &eacute;t&eacute; enregistr&eacute;e';
	//Envoi du fichier flash
	if (_request('submit_fichier_flash')) {
		if(!empty($_FILES['flash_eva_habillage_envoi']['tmp_name'])
		AND is_uploaded_file($_FILES['flash_eva_habillage_envoi']['tmp_name'])
		AND (strpos($_FILES['flash_eva_habillage_envoi']['name'],'.swf'))){
			if(!move_uploaded_file($_FILES['flash_eva_habillage_envoi']['tmp_name'], _DIR_IMG.'eva_habillage/flash/'.$_FILES['flash_eva_habillage_envoi']['name'])) {
				$res['message_erreur'] = 'Erreur dans le t&eacute;l&eacute;chargement du fichier !';
			}
			$res['message_ok'] = 'Le fichier <b>'.$_FILES['flash_eva_habillage_envoi']['name'].'</b> a &eacute;t&eacute; t&eacute;l&eacute;charg&eacute; sur le serveur';
		}
	}
	// Choix de l'incrustation d'une animation flash
	if (_request('submit_insertion_flash')) {
		$recup_flash_exists = sql_select('id','spip_eva_habillage_images',"nom_div = '"._request('secteur_flash')."' AND nom_habillage = 'Defaut'");
		$tab_recup_flash_exists = sql_fetch($recup_flash_exists);
		if ((_request('secteur_flash')=='flash_secteur_pied') OR (_request('secteur_flash')=='flash_secteur_titre')) {
			if (isset($tab_recup_flash_exists['id'])) {            
				sql_updateq('spip_eva_habillage_images',array('nom_image' => _request('nom_flash'), 'pos_x' => _request('flash_horizontal'), 'pos_y' => _request('flash_vertical'),'repetition' => _request('flash_version')), "id =".$tab_recup_flash_exists['id']);
			}
			else {
				sql_insertq('spip_eva_habillage_images',array('type' =>'flash','nom_habillage' => 'Defaut','nom_div' => _request('secteur_flash'),'nom_image' =>_request('nom_flash'),'pos_x' => _request('flash_horizontal'), 'pos_y' => _request('flash_vertical'),'repetition' => _request('flash_version')));
			}
		}
		else {
			sql_insertq('spip_eva_habillage_images',array('type' =>'flash','nom_habillage' => 'Defaut','nom_div' => _request('secteur_flash'),'nom_image' =>_request('nom_flash'),'pos_x' => _request('flash_horizontal'), 'pos_y' => _request('flash_vertical'),'repetition' => _request('flash_version')));
		}
		$res['message_ok'] = "L'animation flash a &eacute;t&eacute; ins&eacute;r&eacute;e";
	}
	//Suppression d'une animation flash précédemment insérée
	$recup_exist_flash = sql_select('id , nom_div , nom_image , pos_x , pos_y , repetition','spip_eva_habillage_images',"type = 'flash' AND nom_habillage = 'Defaut'");
	while ($tab_exist_flash = sql_fetch($recup_exist_flash)) {
		if (_request('supprime_image'.$tab_exist_flash['id'])) {
			sql_delete('spip_eva_habillage_images',"id=".$tab_exist_flash['id']);
			$res['message_ok'] = "L'enregistrement de l'animation flash a &eacute;t&eacute; effac&eacute;e";
		}
	}
	return $res;
}