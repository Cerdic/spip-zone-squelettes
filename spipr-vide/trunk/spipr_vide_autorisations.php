<?php
/**
 * Définit les autorisations du plugin spipr vide
 *
 * @plugin     spipr vide
 * @copyright  2013
 * @author     Alain Cousin
 * @licence    GNU/GPL
 * @package    SPIP\Spipr_vide\Autorisations
 */

if (!defined('_ECRIRE_INC_VERSION')) return;


/*
 * Un fichier d'autorisations permet de regrouper
 * les fonctions d'autorisations de votre plugin
 */

/**
 * Fonction d'appel pour le pipeline
 * @pipeline autoriser */
function spipr_vide_autoriser(){}


/* Exemple
function autoriser_configurer_spipr_vide_dist($faire, $type, $id, $qui, $opt) {
	// type est un objet (la plupart du temps) ou une chose.
	// autoriser('configurer', '_spipr_vide') => $type = 'spipr_vide'
	// au choix
	return autoriser('webmestre', $type, $id, $qui, $opt); // seulement les webmestres
	return autoriser('configurer', '', $id, $qui, $opt); // seulement les administrateurs complets
	return $qui['statut'] == '0minirezo'; // seulement les administrateurs (même les restreints)
	// ...
}
*/
?>