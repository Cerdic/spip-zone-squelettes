<?php

function formulaires_logoinsitu_charger_dist(){
	$valeurs = array('choixlogo'=>'','bobo'=>'');
	return $valeurs;
}

function formulaires_logoinsitu_verifier_dist(){
	$erreurs = array();

	$bobo = _request('bobo');
	if (!empty($bobo))
		$erreurs['bobo'] = 'Robot, va !';
	
	return $erreurs;
}

function formulaires_logoinsitu_traiter_dist(){
	$choixlogo = _request('choixlogo');
	return $choixlogo;
}
