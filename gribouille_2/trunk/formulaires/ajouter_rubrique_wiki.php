<?php
/**
 * Plugin Gribouille 2.0 pour Spip 2.0
 * Licence GPL (c) 2006-2009 Fil
 *
 */
if (!defined("_ECRIRE_INC_VERSION")) {
	return;
}

include_spip('inc/autoriser');

function formulaires_ajouter_rubrique_wiki_charger($id_rubrique = '') {
	if (is_numeric($id_rubrique)) {
		if (!autoriser('creerrubriquedans', 'rubrique', $id_rubrique)) {
			$editable = false;
		}
		else {
			$editable = true;
		}
	}
	else {
		$editable = true;
	}
	$valeurs['editable'] = $editable;

	return $valeurs;
}

function formulaires_ajouter_rubrique_wiki_verifier($id_rubrique = '') {
	$titre = _request('ajouter_rubrique_wiki');
	if (preg_match(",http://,", $titre)) {
		$erreurs['ajouter_rubrique_wiki'] = _T('gribouille:pas_url');
	}
	if (_request('pas_de_robot_merci')) {
		$erreurs['pas_de_robot_merci'] = _T('gribouille:pas_de_robot');
	}

	return $erreurs;
}

function formulaires_ajouter_rubrique_wiki_traiter($id_rubrique = '') {

	$id_article = null;
	$message    = "";

	// on verifie d'abord qu'un article de ce titre n'existe pas deja
	$s = sql_select("id_rubrique", "spip_rubriques", "titre="
								 . sql_quote(_request('ajouter_rubrique_wiki')));
	if ($t = sql_fetch($s)) {
		$new_rubrique = $t['id_rubrique'];
	}
	else {
		if (autoriser('creerrubriquedans', 'rubrique', $id_rubrique)) {
			include_spip('action/editer_rubrique');
			$new_rubrique = insert_rubrique($id_rubrique);
			$c            = array('titre' => _request('ajouter_rubrique_wiki'));
			revisions_rubriques($new_rubrique, $c);
		}
	}

	if (!$new_rubrique) {
		die("Erreur : creation de rubrique interdite");
	}

	$retour = generer_url_entite($new_rubrique, 'rubrique');

	include_spip('inc/headers');
	$message .= redirige_formulaire($retour);

	return $message;
}

