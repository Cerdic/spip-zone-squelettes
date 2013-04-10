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

function mediaspip_core_autoriser(){};

/**
 * Autoriser les utilisateurs à modifier leur profil
 * 
 * On garde les autorisations par défaut pour les administrateurs et les rédacteurs
 * Par contre on autorise les visiteurs (6forum) à modifier un profil:
 * -* s'il sont eux même l'utilisateur à modifier
 * -* s'ils ont le bon statut
 * -* si on ne souhaite pas modifier le statut
 *
 * @param string $faire
 * @param string $type
 * @param int $id
 * @param array $qui
 * @param array $opt
 */
if(!function_exists('autoriser_auteur_modifier')){
	function autoriser_auteur_modifier($faire, $type, $id, $qui, $opt) {
		if (in_array($qui['statut'], array('0minirezo', '1comite')))
			return autoriser_auteur_modifier_dist($faire, $type, $id, $qui, $opt);
		else
			return
				!$opt['statut']
				AND $qui['statut'] == '6forum'
				AND $id == $qui['id_auteur'];
	}
}

/**
 * Autoriser à voir les liens directs des medias
 */
function autoriser_msvoirliens_dist($faire, $type, $id, $qui, $opt) {
	include_spip('inc/config');
	$cfg = lire_config('mediaspip/squelettes',array());
	if ($qui['statut'] =='0minirezo'){
		if($cfg['afficher_lien_direct'] == 'on'){
			return true;
		}
	}else{
		if($cfg['afficher_lien_direct'] == 'on'){
			if($cfg['liens_limiter_acces'] == 'on'){
				return $qui['statut'] && ($qui['statut'] <= ($cfg['liens_limiter_statuts'] ? $cfg['liens_limiter_statuts'] : '6forum'));
			}
			return true;
		}
	}
}

/**
 * Autoriser à voir les téléchargements des medias
 */
function autoriser_document_mstelecharger_dist($faire, $type, $id, $qui, $opt) {
	if(intval($id)){
		$ms_auths = sql_fetsel('ms_auth_telecharger,ms_auth_telecharger_loggues','spip_articles','id_article='.intval($id));
		if($ms_auths['ms_auth_telecharger'] == 'defaut'){
			include_spip('inc/config');
			$cfg = lire_config('mediaspip/squelettes',array());
			if ($cfg['autoriser_telecharger'] != 'on'){
				return false;
			}else{
				return (($cfg['autoriser_telecharger_que_logues'] == 'on') && ($qui['id_auteur'] > 0)) OR ($ms_auths['autoriser_telecharger_que_logues'] != 'on');
			}	
		}else{
			if($ms_auths['ms_auth_telecharger'] == 'non')
				return false;
			else
				return (($ms_auths['ms_auth_telecharger_loggues'] == 'on') && ($qui['id_auteur'] > 0)) OR ($ms_auths['ms_auth_telecharger_loggues'] != 'on');
		}
	}
	return false;
}

/**
 * N'autoriser l'accès à l'espace privé que pour les webmestres
 */
if(!function_exists('autoriser_ecrire')){
	function autoriser_ecrire($faire, $type, $id, $qui, $opt) {
		return ($qui['statut'] =='0minirezo') && ($qui['webmestre'] == 'oui');
	}
}

/**
 * Ne pas autoriser la modération de forums internes que l'on n'utilise pas
 */
 if(!function_exists('autoriser_foruminterne_moderer')){
	function autoriser_foruminterne_moderer($faire, $type, $id, $qui, $opt) {
		if(($GLOBALS['meta']['forum_prive'] == 'non') && ($GLOBALS['meta']['forum_prive_admin'] == 'non') && ($GLOBALS['meta']['forum_prive_objets'] == 'non'))
			return false;
		return true;
	}
}
?>