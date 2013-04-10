<?php
/**
 * Plugin Mediaspip Core
 * 
 * Auteurs :
 * kent1 (http://www.kent1.info - kent1@arscenic.info)
 *
 * © 2010-2012 - Distribue sous licence GNU/GPL
 * 
 */
if (!defined("_ECRIRE_INC_VERSION")) return;	#securite

/**
 * Balise #MS_NOM_BOUCLE
 *
 * Récupère le nom de la boucle parente
 *
 * @param unknown_type $p
 */
function balise_MS_NOM_BOUCLE($p){
	$b = $p->nom_boucle ? $p->nom_boucle : $p->descr['id_mere'];
	$type_pagination = $p->boucles[$b]->modificateur['debut_nom'];
	if($type_pagination){
		$b = $type_pagination;
	}
	$p->code = $b;
	return $p;
}

?>