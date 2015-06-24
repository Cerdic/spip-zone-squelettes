<?php

function formulaires_logoinsitu_charger_dist(){
	$valeurs = array('choixlogo'=>'','bobo'=>'');
	return $valeurs;
}

function formulaires_logoinsitu_traiter_dist(){
	$choixlogo = _request('choixlogo');
	return $choixlogo;
}
