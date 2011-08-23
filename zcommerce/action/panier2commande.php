<?php

// Sécurité
if (!defined('_ECRIRE_INC_VERSION')) return;

/**
 * Remplir la commande avec le panier en cours
 * cf plugin commandes
 * puis panier2commandes
 */
//[(#URL_ACTION_AUTEUR{panier2commande,panier-#SESSION{id_panier}

function action_panier2commande_dist($arg=null) {
		
		$securiser_action = charger_fonction('securiser_action', 'inc');
		$args = $securiser_action();
	
		include_spip('inc/commandes');
		creer_commande_encours();
		
}

?>
