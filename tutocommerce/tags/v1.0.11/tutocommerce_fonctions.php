<?php
/*
 * @plugin     Tuto-commerce
 * @copyright  2015
 * @author     tcharlss
 * @licence    GNU/GPL
 * @package    SPIP\Tuto-commerce\fonctions
 */

if (!defined('_ECRIRE_INC_VERSION')) return;

/**
 * Test sur le plugin Bank (Paiements en ligne)
 * envoyer le tableau du ou des prestataires sélectionnés
 *
 * @return array
 */
function tutocommerce_prestas_actif(){
	$prestas = lire_config('bank_paiement');

	if (!is_null($prestas) AND is_array($prestas)) {
		foreach ($prestas as $key => $value) {
			$prestas = preg_match('/^config/i', $key, $result);
			if (is_array($result) && count($result) > 0) {
				$meta_prestas = 'bank_paiement/'.$key.'/presta';
				$val_presta = lire_config($meta_prestas);
				$quels_prestas[] = $val_presta;
			}
		}
	}
	
	return $quels_prestas;
}

/**
 * Test sur le plugin Bank (Paiements en ligne)
 * Parmi les prestataires sélectionnés, vérifier qu'il y en a qui sont actif ET en mode test
 * pour ceux qui n'ont pas de mode Test, on vérifie que _SIMU_BANK_ALLOWED a été défini.
 *
 * @return int
 */
function tutocommmerce_tout_en_ordre(){
	$compteur_mode_test = 0;
	$prestas = lire_config('bank_paiement');
	if (!is_null($prestas) AND is_array($prestas)) {
		foreach ($prestas as $key => $value) {
			$prestas = preg_match('/^config/i', $key, $result);
			if (is_array($result) && count($result) > 0) {

				$meta_actif = 'bank_paiement/'.$key.'/actif';
				$meta_mode_test = 'bank_paiement/'.$key.'/mode_test';
				$val_test = lire_config($meta_mode_test);
				if (is_null($val_test)) {
					defined("_SIMU_BANK_ALLOWED") ? $val_test = '1' : $val_test = '0';
				}
				if (lire_config($meta_actif) == 1 && $val_test == 1) $compteur_mode_test ++;
			}
		}
	}
	return $compteur_mode_test;
}
