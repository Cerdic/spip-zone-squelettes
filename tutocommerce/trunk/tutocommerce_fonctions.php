<?php
/*
 * Paiement Bancaire
 * module de paiement bancaire multi prestataires
 * stockage des transactions
 *
 * Auteurs :
 * Cedric Morin, Nursit.com
 * (c) 2012-2015 - Distribue sous licence GNU/GPL
 *
 */

if (!defined('_ECRIRE_INC_VERSION')) return;

/**
 * Test sur le plugin Bank (Paiements en ligne)
 * Il y a t-il au moins 1 prestataire actif ?
 *
 * @return bool
 */
function tutocommerce_prestas_actif(){
	$compteur_presta = 0;
	$prestas = lire_config('bank_paiement');
	foreach ($prestas as $key => $value) {
		$prestas = preg_match('/^config/i', $key, $result);
		if (is_array($result) && count($result) > 0) {
			$meta_actif = 'bank_paiement/'.$key.'/actif';
			if (lire_config($meta_actif) == 1 ) $compteur_presta ++;
		}
	}
	if ($compteur_presta > 0) return true;
	else return false;
}

/**
 * Test sur le plugin Bank (Paiements en ligne)
 * Parmi les prestataires actifs, il y en a t-il au moins 1 pour lequel de mode Test a été activé ?
 *
 * @return bool
 */
function tutocommmerce_mode_test(){
	$compteur_mode_test = 0;
	$prestas = lire_config('bank_paiement');
	foreach ($prestas as $key => $value) {
		$prestas = preg_match('/^config/i', $key, $result);
		if (is_array($result) && count($result) > 0) {
			$meta_mode_test = 'bank_paiement/'.$key.'/mode_test';
			if (lire_config($meta_mode_test) == 1 ) $compteur_mode_test ++;
		}
	}
	if ($compteur_mode_test > 0) return true;
	else return false;
}
