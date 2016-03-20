<?php

if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_evahabillage_graphisme_images_charger_dist(){
	//Rien à retourner ici : tout est dans le formulaire html et en php
	$valeurs=array();
	return $valeurs;
}


function formulaires_evahabillage_graphisme_images_traiter_dist(){
	$res = array('editable'=>true);
	$res['message_ok'] = 'Aucune modification n\'a &eacute;t&eacute; enregistr&eacute;e';
	//Enregistrement des images
	if	(!empty($_FILES['image_eva_habillage_envoi']['tmp_name'])
	AND is_uploaded_file($_FILES['image_eva_habillage_envoi']['tmp_name'])
	AND filesize($_FILES['image_eva_habillage_envoi']['tmp_name'])<2000000) {
		list($largeur, $hauteur, $type, $attr)=getimagesize($_FILES['image_eva_habillage_envoi']['tmp_name']);
		if (($type===1) OR ($type===2) OR ($type===3)) {
			if(!move_uploaded_file($_FILES['image_eva_habillage_envoi']['tmp_name'], _DIR_IMG.'eva_habillage/'.$_FILES['image_eva_habillage_envoi']['name'])) {
				$res['message_erreur'] = 'Erreur lors de la copie du fichier';
			}
			else {$res['message_ok'] = 'L\'image a &eacute;t&eacute; t&eacute;l&eacute;charg&eacute;e sur le serveur';}
		}
	}
	// Saisie d'une image pour un secteur du site
	if((_request('submit_image_choix')) AND (_request('nom_image')!='')) {
		$recup_image_exists = sql_select('id','spip_eva_habillage_images',"nom_div = '"._request('secteur_image')."' AND nom_habillage = 'Defaut'");
		$tab_recup_image_exists = sql_fetch($recup_image_exists);
		$repeat = _request('repeat_x')+_request('repeat_y');
		if ($repeat==0) {$rep='no-repeat';}
		elseif ($repeat==1) {$rep='repeat-x';}
		elseif ($repeat==2) {$rep='repeat-y';}
		elseif ($repeat==3) {$rep='repeat';}
		if (_request('pos_x')==4) {$Xpos=_request('position_x');} else {$Xpos=_request('pos_x');}
		if (_request('pos_y')==4) {$Ypos=_request('position_y');} else {$Ypos=_request('pos_y');}
		if (isset($tab_recup_image_exists['id'])) {            
			sql_updateq('spip_eva_habillage_images',array('nom_image' => _request('nom_image'), 'pos_x' => $Xpos, 'pos_y' => $Ypos , 'repetition' => $rep , 'attach' => _request('attach')),"id =".$tab_recup_image_exists['id']);
		}
		else {
			sql_insertq('spip_eva_habillage_images',array('type' =>'image','nom_habillage' => 'Defaut','nom_div' => _request('secteur_image'),'nom_image' =>_request('nom_image'),'pos_x' => $Xpos,'pos_y' => $Ypos,'repetition' => $rep,'attach' =>_request('attach')));
		}
		$res['message_ok'] = 'L\'insertion de l\'image de fond <b>'._request('nom_image').'</b> dans le secteur "<b>'._T('evahabillage:'._request('secteur_image')).'</b>" a &eacute;t&eacute; enregistr&eacute;e';
	}

	// Suppression de l'enregistrement d'une image
	$recup_exist_image = sql_select('id , nom_div , nom_image','spip_eva_habillage_images',"type = 'image' AND nom_habillage = 'Defaut'");
	while ($tab_exist_image = sql_fetch($recup_exist_image)) {
		if (_request('submit_supprime_image_'.$tab_exist_image['id'])) {
			sql_delete('spip_eva_habillage_images',"id=".$tab_exist_image['id']);
			$res['message_ok'] = 'L\'enregistrement de l\'image de fond <b>'.$tab_exist_image['nom_image'].'</b> a &eacute;t&eacute; supprim&eacute;';
		}
	}

	// Sélection d'une image de puce
	if (_request('submit_choix_puce')) {
		sql_delete('spip_eva_habillage_images',"type='puce_spip' AND nom_habillage='Defaut'");
		sql_insertq('spip_eva_habillage_images',array('type'=>'puce_spip','nom_habillage'=>'Defaut','nom_image'=>_request('nom_puce')));
		$res['message_ok'] = 'La puce personnelle a &eacute;t&eacute; enregistr&eacute;e';
	}

	// Suppression de l'enregistrement d'une image de puce
	if (_request('submit_supprime_puce')) {
		sql_delete('spip_eva_habillage_images',"type='puce_spip' AND nom_habillage='Defaut'");
		$res['message_ok'] = 'L\'enregistrement de la puce personnelle a &eacute;t&eacute; supprim&eacute;';
	}
	return $res;
}