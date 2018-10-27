<?php
if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

/**
 * Prend une url et la transforme en supprimant un élèment de tableau passé en paramètre.
 * function supprimer
 * @param url
 * @param param
 * @param tableau_original
 * @param index_element_supprimer
 * @return string
 **/
function parametre_url_supprimer_element_tableau($url,$param, $tableau_original,$index_element_supprimer){
	$url = parametre_url($url,$param,'');//effacons d'abord
	unset($tableau_original[$index_element_supprimer]);
	$url = parametre_url($url,$param, $tableau_original);
	return $url;	
}
