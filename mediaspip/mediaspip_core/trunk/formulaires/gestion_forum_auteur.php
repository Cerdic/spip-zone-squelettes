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

function formulaires_gestion_forum_auteur_charger_dist($id_forum='', $id_rubrique='', $id_article='', $id_breve='', $id_syndic='', $id_message='', $id_auteur='', $auteur='', $email_auteur='', $ip='',$objet='',$id_objet='',$auteur_voir='',$recherche='') {
	$valeurs = array(
		'editable'=>true
		);
	
	$valeurs['id_forums'] = array();
	$valeurs['pagination'] = _request('pagination');
	$valeurs['select_type'] = _request('select_type');
	$valeurs['select_statut'] = _request('select_statut');
	
	$valeurs['id_forum'] = _request('id_forum');
	$valeurs['id_rubrique'] = _request('id_rubrique');
	$valeurs['id_article'] = _request('id_article');
	$valeurs['id_breve'] = _request('id_breve');
	$valeurs['id_syndic'] = _request('id_syndic');
	$valeurs['id_message'] = _request('id_message');
	$valeurs['id_objet'] = _request('id_objet');
	$valeurs['objet'] = _request('objet');
	
	//$valeurs['id_auteur'] = _request('id_auteur');
	$valeurs['auteur'] = _request('auteur');
	$valeurs['email_auteur'] = _request('email_auteur');
	$valeurs['ip'] = _request('ip');
	$valeurs['debut_forum'] = _request('debut_forum');
	$valeurs['auteur_voir'] = $auteur_voir;
	$valeurs['recherche'] = _request('recherche');

	return $valeurs;
}

function formulaires_gestion_forum_auteur_verifier_dist($id_forum='', $id_rubrique='', $id_article='', $id_breve='', $id_syndic='', $id_message='', $id_auteur='', $auteur='', $email_auteur='', $ip='',$objet='',$id_objet='',$auteur_voir='') {

	$erreurs = array();
	
	return $erreurs;
}


function formulaires_gestion_forum_auteur_traiter_dist($id_forum='', $id_rubrique='', $id_article='', $id_breve='', $id_syndic='', $id_message='', $id_auteur='', $auteur='', $email_auteur='', $ip='',$objet='',$id_objet='',$auteur_voir='') {

	$retour = array();
	
	if(_request('valider') OR _request('bruler') OR _request('supprimer'))
		$retour['message_ok'] = _T('forum:message_rien_a_faire');
	
	if (!$forum_ids = _request('forum_ids'))
		$forum_ids = array();
	
	$select_type = _request('select_type');
	$select_statut = _request('select_statut');
	$pagination = _request('pagination');
	$pagination_ancien = _request('pagination_ancien');

	set_request('select_type',$select_type);
	set_request('voir_staut',$select_statut);
	
	if ($pagination != $pagination_ancien)
		set_request('debut_forum','');
	
	if (_request('valider') && (count($forum_ids) > 0)){
		$statut = 'publie';
		$retour['message_ok'] = singulier_ou_pluriel(count($forum_ids), 'forum:message_publie', 'forum:messages_publies');
	}
	
	if (_request('bruler') && (count($forum_ids) > 0)){
		$statut = 'spam';
		$retour['message_ok'] = singulier_ou_pluriel(count($forum_ids), 'forum:message_marque_comme_spam', 'forum:messages_marques_comme_spam');
	}
	
	if(_request('supprimer') && (count($forum_ids) > 0)){
		$statut = 'off';
		$retour['message_ok'] = singulier_ou_pluriel(count($forum_ids), 'forum:message_supprime', 'forum:messages_supprimes');
	}
	
	include_spip('action/instituer_forum');
	foreach ($forum_ids as $id) {
		$row = sql_fetsel("*", "spip_forum", "id_forum=$id");
		if($statut == "publie" and $row['statut'] == "privoff")
			$statut = "prive";
		if($statut == "off" and $row['statut'] == "prive")
			$statut = "privoff";	
		if($statut == "off" and $row['statut'] == "privrac")
			$statut = "privoff";		
		instituer_un_forum($statut,$row);
	}
	
	return $retour;
}

?>
