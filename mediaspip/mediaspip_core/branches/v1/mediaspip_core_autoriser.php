<?php
/**
 * Plugin Mediaspip Core
 * 
 * © 2010-2011 kent1 (kent1@arscenic.info)
 * Distribué sous licence GNU/GPL v3
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
 * N'autoriser l'accès à l'espace privé que pour les webmestres
 */
if(!function_exists('autoriser_ecrire')){
	function autoriser_ecrire($faire, $type, $id, $qui, $opt) {
		return ($qui['statut'] =='0minirezo') && ($qui['webmestre'] == 'oui');
	}
}
?>