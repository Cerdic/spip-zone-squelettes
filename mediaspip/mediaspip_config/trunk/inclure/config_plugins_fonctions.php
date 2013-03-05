<?php
/**
 * Fonctions nécessaires au squelette config_plugins.html
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * Applique les mises à jour de plugins
 */
function ms_config_verifier_plugins(){
	include_spip('exec/admin_plugin');
	include_spip('inc/autoriser');
	if (!autoriser('configurer', 'plugins')) {
		include_spip('inc/minipres');
		echo minipres();
	}
	
	include_spip('inc/plugin'); 
	$new = actualise_plugins_actifs();
	if ($new AND _request('actualise')<2) {
		$url = parametre_url(self(),'actualise',_request('actualise')+1,'&');
		include_spip('inc/headers');
		echo redirige_formulaire($url);
		exit;
	}

	// reinstaller SVP si on le demande expressement.
	if (_request('var_mode') == 'reinstaller_svp') {
		include_spip('svp_administrations');
		svp_vider_tables('svp_base_version');
		include_spip('inc/headers');
		echo redirige_formulaire(self());
		exit;
	}
	// liste des erreurs mises en forme 
	$erreur_activation = plugin_donne_erreurs();
	// message d'erreur au retour d'une operation
	if ($erreur){
		include_spip('inc/filtres_boites');
		echo "<div class='svp_retour'>" . boite_ouvrir(_T('svp:actions_en_erreur'), 'error') . $erreur . boite_fermer() . "</div>";
	}
	if ($erreur_activation){
		include_spip('inc/filtres_boites');
		echo "<div class='svp_retour'>" . boite_ouvrir(_T('svp:actions_en_erreur'), 'error') . $erreur_activation . boite_fermer() . "</div>";
	}

	// afficher les actions realisees s'il y en a eu
	// (activation/desactivation/telechargement...)
	echo svp_presenter_actions_realisees();
	
	// on installe les plugins maintenant,
	// cela permet aux scripts d'install de faire des affichages (moches...)
	plugin_installes_meta();
}
?>