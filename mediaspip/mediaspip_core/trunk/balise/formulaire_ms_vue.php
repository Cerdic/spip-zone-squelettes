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
 * Balise #FORMULAIRE_MS_VUE
 *
 * Vérifie que l'on est bien dans une boucle sinon affiche une erreur
 * Récupère le nom de la boucle pour le fournir en argument au formulaire
 * Passe la main ensuite à formulaires/ms_vue.php
 *
 * @param unknown_type $p
 */
function balise_FORMULAIRE_MS_VUE_dist ($p) {
	$b = $p->nom_boucle ? $p->nom_boucle : $p->descr['id_mere'];
	if ($b === '' || !isset($p->boucles[$b])) {
		$msg = array('zbug_champ_hors_boucle',
			array('champ' => "#$b" . 'FORMULAIRE_MS_VUE')
		);
		return $p;
	}
	return calculer_balise_dynamique($p,'FORMULAIRE_MS_VUE',array('MS_NOM_BOUCLE'));
}

function balise_FORMULAIRE_MS_VUE_stat($args, $context_compil) {
	return $args;
}

?>
