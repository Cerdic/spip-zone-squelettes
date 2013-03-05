<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function action_mediaspip_notices_dist(){
	$securiser_action = charger_fonction('securiser_action', 'inc');
	$arg = $securiser_action();
	
	$redirect = urldecode(_request('redirect'));
	spip_log($arg,'em_config');
	if (!preg_match(",(\w*)\/(\w*)$,", $arg, $r)){
		spip_log("action_mediaspip_notices_dist incompris: " . $arg,'em_config');
		return $redirect;
	}
	spip_log($r,'em_config');
	$id_auteur = $GLOBALS['visiteur_session']['id_auteur'];
	if(!$id_auteur)
		return $redirect;
	
	$notices = sql_getfetsel('notices','spip_auteurs','id_auteur='.intval($id_auteur));
	$notices = @unserialize($notices);
	
	if(!is_array($notices)){
		$notices = array();
	}
	
	if($r[1] == 'supprimer'){
		$notices = array();	
	}else if($r[1] == 'ajouter'){
		if(in_array($r[2],$notices)){
			return $redirect;
		}
		if(strlen($r[2]))
			$notices[] = $r[2];
	}
	
	$c['notices'] = serialize($notices);

	include_spip('action/editer_auteur');
	auteur_modifier($id_auteur, $c);
	
	include_spip('inc/session');
	session_set('notices', $c['notices']);
	
	return $redirect;

}
?>