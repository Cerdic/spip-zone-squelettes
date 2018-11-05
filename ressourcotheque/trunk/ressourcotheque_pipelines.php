<?php
if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

/**
 * Pipeline pour choisir quels champs sont vérifier par linkcheck
 * @param array $flux paramètres d'entrée
 * @return array $flux
**/
function ressourcotheque_linkcheck_champs_a_traiter($flux) {
	if ($flux['args']['table'] == 'articles') {
		$flux['data']['contenu_documents'] = 0;
	}
	return $flux;
}
