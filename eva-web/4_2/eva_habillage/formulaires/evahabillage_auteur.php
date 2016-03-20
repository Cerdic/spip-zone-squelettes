<?php

if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_evahabillage_auteur_charger_dist(){
	//Rien à retourner ici : tout est dans le formulaire html et en php
	$valeurs=array();
	return $valeurs;
}


function formulaires_evahabillage_auteur_traiter_dist(){
	$res = array('editable'=>true);
	$res['message_ok'] = 'Aucune modification n\'a &eacute;t&eacute; enregistr&eacute;e';
	//On traite ici la modification des positions des blocs
	if (_request('bloc_auteur_valider')) {
		$verif_post_bloc=sql_select('*','spip_eva_habillage_images',"type='bloc' AND nom_habillage='Defaut' AND attach='auteur'");
		while ($tab_eva_bloc = sql_fetch($verif_post_bloc)) {
			if (isset($tab_eva_bloc['nom_div'])) {
				sql_updateq('spip_eva_habillage_images',array('nom_image' => _request($tab_eva_bloc['nom_div']),'pos_x' =>_request($tab_eva_bloc['nom_div'].'_pos_x')),"nom_habillage = 'Defaut' AND type = 'bloc' AND nom_div = '".$tab_eva_bloc['nom_div']."'");
			}
		}
		$res['message_ok'] = 'La modification des positions des blocs a &eacute;t&eacute; enregistr&eacute;e';
	}
	//On traite ici l'injection de noisettes perso
	if (_request('skel_perso_auteur')) {
		sql_insertq('spip_eva_habillage_images',array(
			'type' => 'bloc',
			'nom_habillage' => 'Defaut',
			'nom_div' => _request('eva_mon_bloc_perso_nom_auteur'),
			'nom_image' => _request('eva_mon_bloc_perso_skel_auteur'),
			'pos_x' => _request('eva_mon_bloc_perso_pos_x_auteur'),
			'repetition' => 'perso',
			'attach' => 'auteur'
		));
		$res['message_ok'] = 'Le squelette personnel <b>'._request('eva_mon_bloc_perso_nom_auteur').'</b> a &eacute;t&eacute; ins&eacute;r&eacute;';
	}
	//On traite enfin la suppression des noisettes perso pr&alablement insérées
	if (_request('submit_supprime_skel_perso_auteur')) {
		sql_delete('spip_eva_habillage_images',"id='"._request('eva_suppr_skel_perso_auteur')."'");
		$res['message_ok'] = 'Le squelette personnel a &eacute;t&eacute; supprim&eacute;';
	}
	return $res;
}