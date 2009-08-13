<?php
function formulaires_multi_mots_charger_dist($mot1){
	// $mot1 vaut l'id du mot selectionne lorsque l'appel s'est fait a partir des noisettes des mots cles de la colonne extra
	// $mot1 est nul lorsque l'appel se fait directement par le bouton mot-cle du menu inc_nav_raccourci, 

	$valeurs = array();
	$valeurs['mot_1'] = $mot1;
	$valeurs['mot_2'] = '';
	$valeurs['mot_3'] = '';

	return $valeurs;
}

function formulaires_multi_mots_verifier_dist(){
   
	$valeurs = array();
	$valeurs['mot_1'] = _request('mot_1');
	$valeurs['mot_2'] = _request('mot_2');
	$valeurs['mot_3'] = _request('mot_3');
	
	if (array_sum($valeurs) == 0) {
		return array('message_erreur' =>_T('sarkaspip:choisir_un_critere'));
	}
}
function formulaires_multi_mots_traiter_dist(){
	
	$valeurs = array();
	$valeurs['mot_1'] = _request('mot_1');
	$valeurs['mot_2'] = _request('mot_2');
	$valeurs['mot_3'] = _request('mot_3');
    // pas sur que ce qui precede serve a grand chose
	
	return array('message_ok' => 'oui');
}
?>