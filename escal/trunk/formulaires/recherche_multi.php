<?php
function formulaires_recherche_multi_charger_dist(){
	// $mot vaut l'id du mot selectionne lorsque l'appel s'est fait a partir des noisettes des mots cles de la colonne extra
	// $mot est nul lorsque l'appel se fait directement par le bouton mot-cle du menu inc_nav_raccourci,

	$valeurs = array();
	$valeurs['id1'] = '';
	$valeurs['id2'] = '';
	$valeurs['id3'] = '';
	$valeurs['id4'] = '';
    $valeurs['id5'] = '';
    $valeurs['id6'] = '';
    $valeurs['id7'] = '';
    $valeurs['id8'] = '';
    $valeurs['id9'] = '';
	// Si au chargement $mot existe c'est qu'on vient d'un mot-cle direct
	if ($mot)
		$valeurs['message_ok'] = 'oui';

	return $valeurs;
}

function formulaires_recherche_multi_verifier_dist(){

	$valeurs = array();
	$valeurs['id1'] = intval(_request('id1'));
	$valeurs['id2'] = intval(_request('id2'));
    $valeurs['id3'] = intval(_request('id3'));
    $valeurs['id4'] = intval(_request('id4'));
    $valeurs['id5'] = intval(_request('id5'));
    $valeurs['id6'] = intval(_request('id6'));
    $valeurs['id7'] = intval(_request('id7'));
    $valeurs['id8'] = intval(_request('id8'));
    $valeurs['id9'] = intval(_request('id9'));
	if (array_sum($valeurs) == 0) {
		return array('message_erreur' =>_T('message'));
	}
}
function formulaires_recherche_multi_traiter_dist(){

	return array('message_ok' => 'oui');
}
