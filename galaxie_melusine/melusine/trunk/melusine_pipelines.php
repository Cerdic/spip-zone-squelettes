<?php
/**
 * Plugin Mélusine
 * (c) 2012 Jean-Marc Labat
 * Licence GNU/GPL
 */

if (!defined('_ECRIRE_INC_VERSION')) return;


/*
 * Un fichier de pipelines permet de regrouper
 * les fonctions de branchement de votre plugin
 * sur des pipelines existants.
 */



function melusine_affiche_milieu ($flux) {
// On affiche la liste des fichiers que le webmestre doit déplacer
	include_spip('inc/autoriser');

	// On affiche que pour le webmestre !
	if (autoriser('webmestre')) {

		$fichiers_a_deplacer = melusine_message_noisettes_a_deplacer();

		// Pages de l'espace privé où l'on veut que le message s'affiche
		// TODO affiche_milieu ne semble pas fonctionner avec SVT (admin_plugin)
		// -> trouver une solution (voir le bug: https://core.spip.net/issues/2694)
		$pages_cibles = array("accueil","admin_vider","admin_plugin","configurer_identite","configurer_contenu","configurer_interactions","configurer_avancees");

		if ($fichiers_a_deplacer AND in_array($flux['args']['type-page'],$pages_cibles)) {
			// Dans une belle boite "notice"
			include_spip('inc/filtres_boites');
			$flux["data"] = "<div id='melusine_deplacer_fichiers'>" . boite_ouvrir("Fichiers à déplacer", 'notice') . $fichiers_a_deplacer . boite_fermer() . "</div>".$flux["data"];
		}
	}
    return $flux;
}

// Pipeline pour affiche le bouton d'admin de mélusine :
// ajouter le mode voir=modules
// tout est piké au noizetier
// TODO sortir du fork pour devenir une vraie interface au noizetier
function melusine_formulaire_admin($flux) {
	if (autoriser('webmestre')) {
		$btn = recuperer_fond('prive/bouton/voir_modules');
		$flux['data'] = preg_replace('%(<!--extra-->)%is', $btn.'$1', $flux['data']);
	}
	return $flux;
}

?>