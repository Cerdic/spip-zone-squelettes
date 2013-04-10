<?php
/**
 * Plugin Mediaspip Core
 * 
 * © 2010-2011 kent1 (kent1@arscenic.info)
 * Distribué sous licence GNU/GPL v3
 * 
 */
if (!defined("_ECRIRE_INC_VERSION")) return;	#securite

/**
 * Balise #FORMULAIRE_MS_TRI
 *
 * Vérifie que l'on est bien dans une boucle sinon affiche une erreur
 * Récupère le nom de la boucle pour le fournir en argument au formulaire
 * Passe la main ensuite à formulaires/ms_tri.php
 *
 * @param unknown_type $p
 */
function balise_FORMULAIRE_MS_TRI_dist ($p) {
	$b = $p->nom_boucle ? $p->nom_boucle : $p->descr['id_mere'];
	if ($b === '' || !isset($p->boucles[$b])) {
		$msg = array('zbug_champ_hors_boucle',
			array('champ' => "#$b" . 'FORMULAIRE_MS_TRI')
		);
		return $p;
	}
	return calculer_balise_dynamique($p,'FORMULAIRE_MS_TRI',array('MS_NOM_BOUCLE'));
}

function balise_FORMULAIRE_MS_TRI_stat($args, $context_compil) {
	return $args;
}

?>