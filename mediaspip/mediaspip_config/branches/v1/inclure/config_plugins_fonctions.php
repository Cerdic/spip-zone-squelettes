<?php
/**
 * Fonctions nécessaires au squelette config_plugins.html
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * Applique les mises à jour de plugins
 */
function ms_config_verifier_plugins(){
	include_spip('inc/plugin');
	if (actualise_plugins_actifs()==-1){
		include_spip('inc/headers');
		redirige_par_entete(str_replace('&amp;','&',self()));
	}
	if ($erreur_activation = isset($GLOBALS['meta']['plugin_erreur_activation'])){
		$erreur_activation = $GLOBALS['meta']['plugin_erreur_activation'];
		// l'effacement reel de la meta se fera au moment de l'affichage
		// mais on la vide pour ne pas l'afficher dans le bandeau haut
		unset($GLOBALS['meta']['plugin_erreur_activation']);
	}
	if ($erreur_activation){
		echo "<div class='formulaire_spip'><div class='reponse_formulaire_erreur'>" . str_replace('ecrire/ecrire/',self(),$erreur_activation) . "</div></div>";
		effacer_meta('plugin_erreur_activation');
	}
	installe_plugins();
}
?>