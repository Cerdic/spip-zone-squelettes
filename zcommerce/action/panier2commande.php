<?php

// Sécurité
if (!defined('_ECRIRE_INC_VERSION')) return;

/**
 * Remplir la commande avec le panier en cours
 * appel au plugin commandes
 * puis panier2commandes
 */
function action_panier2commande_dist($arg=null) {
	
		include_spip('inc/commandes');
		creer_commande_encours();
		
}

?>
