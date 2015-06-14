<?php
/**
 * Plugin Mediaspip Core
 * 
 * Auteurs :
 * kent1 (http://www.kent1.info - kent1@arscenic.info)
 *
 * © 2010-2012 - Distribue sous licence GNU/GPL
 * 
 */
if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * Chargement des valeurs par defaut des champs du formulaire
 */

include_spip('inc/date_gestion');

function formulaires_ms_recherche_avancee_charger_dist($lien = NULL){
	$valeurs = array(
			'recherche' => _request('recherche'),
			'editable' => 'oui'
		);
	
	/* A noter : on accepte en entrée le paramètre "id_mot", mais sans champ associé : il est fusionné au paramètre "mots", si le plugin critere_mots est installé */
	foreach(array('recherche','id_auteur','date_debut','date_fin','type_date','em_type','id_rubrique','licence_nom','lang_forcee','mots','id_mot') as $recherche){
		$valeurs[$recherche] = _request($recherche);
		if(in_array($recherche,array('date_debut','date_fin')) && $valeurs[$recherche]){
			if($valeurs[$recherche] == 0){
				$valeurs[$recherche] = '';
			}else{
				$valeurs[$recherche] = date('d/m/Y',strtotime($valeurs[$recherche]));
				set_request($recherche,$valeurs[$recherche]);
			}
		}
	}
	if(defined('_DIR_PLUGIN_LICENCE')){
		include_spip('inc/licence');
		$valeurs['licences'] = $GLOBALS['licence_licences'];
		$valeurs['id_licence'] = _request('licence_nom');
	}

	return $valeurs;
}

function formulaires_ms_recherche_avancee_verifier_dist($lien = NULL){
	$erreurs = array();
	/**
	 * On vérifie les dates ...
	 */
	foreach(array('date_debut','date_fin') as $recherche){
		include_spip('inc/filtres');
		if(_request($recherche)){
			$date = _request($recherche);
			$date = recup_date($date);
			if(!is_numeric($date[0]) OR !is_numeric($date[1]) OR !is_numeric($date[2])){
				$erreurs[$recherche] = _T('mediaspip_core:erreur_date_saisie');
			}else{
				$date_fin[$recherche] = $date[0].''.$date[1].''.(($date[2] > 10) ? $date[2] :'0'.$date[2]);
			} 
		}
	}
	if(_request('date_debut') && _request('date_fin')){
		if($date_fin['date_debut'] > $date_fin['date_fin']){
			$erreurs['date_fin'] = _T('mediaspip_core:erreur_date_saisie_superieure');
		}
	}
	if(count($erreurs) > 0){
		$erreurs['message_erreur'] = _T('mediaspip_core:erreur_verifier_form');
	}
	return $erreurs;
}

function formulaires_ms_recherche_avancee_traiter_dist($lien = NULL){
	$action = ($lien ? $lien : generer_url_public('recherche_avancee'));
	$horaire = false;

	foreach(array('recherche','id_auteur','date_debut','date_fin','type_date','em_type','id_rubrique','licence_nom','lang_forcee','mots') as $recherche){
		if(($recherche == 'date_debut') && _request('date_debut')){
			$date_debut = date('Y-m-d H:i:s',verifier_corriger_date_saisie('debut',$horaire,$erreurs));
			$action = parametre_url($action,$recherche,$date_debut);
		}
		else if(($recherche == 'date_fin') && _request('date_fin')){
			$date_fin = date('Y-m-d H:i:s',verifier_corriger_date_saisie('fin',$horaire,$erreurs));
			$action = parametre_url($action,$recherche,$date_fin);
		}
		else if(($recherche == 'mots') && _request('mots')){
			foreach(_request('mots') as $id_mot){
				$action = parametre_url($action,'mots[]',$id_mot);
			}
		}
		else{
			$action = parametre_url($action,$recherche,_request($recherche,''));
		}
	}
	include_spip('inc/headers');
	redirige_formulaire($action);
}
?>
