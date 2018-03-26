<?php
/**
 * Plugin Gribouille 2.0 pour Spip 2.0
 * Licence GPL (c) 2006-2009 Fil
 *
 */
if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/autoriser');

function formulaires_ajouter_page_wiki_charger($id_rubrique=''){
	if(is_numeric($id_rubrique)){
		if (!autoriser('publierdans', 'rubrique', $id_rubrique)) {
			$editable = false;
		}else{
			$editable = true;
		}
	}else{
		$editable = true;
	}
	$valeurs['editable'] = $editable;
	return $valeurs;
}

function formulaires_ajouter_page_wiki_verifier($id_rubrique=''){
	$titre = _request('ajouter_page_wiki');
	if(preg_match(",http://,",_request('ajouter_page_wiki'))){
		$erreurs['ajouter_page_wiki'] = _T('gribouille:pas_url');
	}
	if(_request('pas_de_robot_merci')){
		$erreurs['pas_de_robot_merci'] = _T('gribouille:pas_de_robot');
	}

	return $erreurs;
}

function formulaires_ajouter_page_wiki_traiter($id_rubrique=''){

	$id_article = null;
	$message = array();
	
	// on verifie d'abord qu'un article de ce titre n'existe pas deja
	$s = sql_select("id_article","spip_articles","titre="
	.sql_quote(_request('ajouter_page_wiki'))." AND statut='publie'");
	if ($t = sql_fetch($s)) {
		$id_article = $t['id_article'];
	} else {
		if (autoriser('publierdans', 'rubrique', $id_rubrique)) {
			include_spip('action/editer_article');
			$id_article = insert_article($id_rubrique);
			include_spip('inc/modifier');
			$r = modifier_contenu('article', $id_article,
				array('champs' => array('titre')),
				array(
					'titre' => _request('ajouter_page_wiki')
				)
			);
			if (function_exists('instituer_article'))
				instituer_article($id_article,array('statut' => 'publie'));
		}
	}

	if (!$id_article)
		die("Erreur : creation d'article interdite");

	$retour = generer_url_entite($id_article, 'article');

	include_spip('inc/headers');
	$message['message_ok'] = redirige_formulaire($retour);
	$message['editable'] = false;
	return $message;
}

?>