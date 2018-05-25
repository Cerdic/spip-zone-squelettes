<?php
/**
 * Définit les autorisations du plugin Html5_landed
 *
 * @plugin     Html5_landed
 * @copyright  2017
 * @author     Nicolas Dorigny
 * @licence    GNU/GPL
 * @package    SPIP\Html5_landed\Autorisations
 */

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

/**
 * Fonction d'appel pour le pipeline
 *
 * @pipeline autoriser
 */
function html5_landed_autoriser() {
}

if (!function_exists('autoriser_groupemots_modifier')) {
	function autoriser_groupemots_modifier($faire, $type, $id, $qui, $opt) {
		$id_groupe = lire_config('html5_landed/id_groupe_articles');
		if ($id == $id_groupe) {
			return false;
		}
		else {
			return autoriser_groupemots_modifier_dist($faire, $type, $id, $qui, $opt);
		}
	}
}

if (!function_exists('autoriser_mot_modifier')) {
	function autoriser_mot_modifier($faire, $type, $id, $qui, $opt) {
		$id_groupe_mot = sql_getfetsel('id_groupe', 'spip_mots', 'id_mot = ' . $id);
		$id_groupe     = lire_config('html5_landed/id_groupe_articles');
		if ($id_groupe_mot == $id_groupe) {
			return false;
		}
		else {
			return autoriser_mot_modifier_dist($faire, $type, $id, $qui, $opt);
		}
	}
}