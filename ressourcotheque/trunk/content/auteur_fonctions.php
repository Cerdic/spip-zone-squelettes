<?php
if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}
/**
 * Vérifier si l'id auteur qu'on passe en argument est connecté
 * @param string  $id_auteur
 * @return bool
**/
function auteur_est_connecte($id_auteur) {
	settype($id_auteur, 'int');
	return $id_auteur == $GLOBALS['visiteur_session']['id_auteur'] ? ' ' : '';
}


