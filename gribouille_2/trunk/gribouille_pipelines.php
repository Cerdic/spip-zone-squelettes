<?php
/**
 * Plugin / Squelettes Gribouille
 * © Fil
 * Distribue sous licence GNU/GPL
 */

if (!defined("_ECRIRE_INC_VERSION")) {
	return;
}

/**
 * Insertion dans le pipeline Styliser
 * définir le squelette a utiliser si on est dans le cas
 * d'une rubrique de Gribouille
 *
 * @param array $flux
 *
 * @return array
 */
function gribouille_styliser($flux) {
	// Gribouille ne s'active que sur les rubriques et les articles
	if (($fond = $flux['args']['fond'])
		AND in_array($fond, array(
			'article',
			'rubrique',
		))) {

		$ext = $flux['args']['ext'];

		// Si la rubrique fait partie du secteur défini dans la configuration on change son fond
		if ($id_rubrique = $flux['args']['id_rubrique']) {
			$id_secteur = sql_getfetsel('id_secteur', 'spip_rubriques', 'id_rubrique=' . intval($id_rubrique));
			if (in_array($id_secteur, lire_config('gribouille/secteurs_wiki',array()))) {
				include_spip('inc/autoriser');
				// On vérifie si nous sommes autorisé à voir le Wiki
				if (autoriser('voir', 'rubrique', $id_rubrique, $GLOBALS['visiteur_session'])) {
					if ($squelette = test_squelette_gribouille($fond, $ext)) {
						$flux['data'] = $squelette;
						// définir les intertitres en H2 sur le Wiki
						$GLOBALS['debut_intertitre'] = "\n<h2 class=\"spip\">\n";
						$GLOBALS['fin_intertitre'] = "</h2>\n";
					}
				}
				else {
					unset($flux['args']);
				}
			}
		}
	}

	return $flux;
}

/**
 * Fonction qui vérifie la présence d'un squelette gribouille disponible
 *
 * @param string $fond article ou rubrique
 * @param string $ext  extension des squelettes (html)
 *
 * @return mixed
 */
function test_squelette_gribouille($fond, $ext) {
	if ($squelette = find_in_path($fond . "_gribouille.$ext")) {
		return substr($squelette, 0, -strlen(".$ext"));
	}

	return false;
}

/**
 * Insertion dans le pipeline Prepare Recherche
 * Si configuré comme tel, exclure de la recherche les secteurs de gribouille
 *
 * @param array $flux
 *
 * @return array
 */
function gribouille_prepare_recherche($flux) {
	if (lire_config('gribouille/exclure_recherche') == 'on') {
		$id_secteurs = lire_config('gribouille/secteurs_wiki');
		if (is_array($id_secteurs)) {
			if ($flux['args']['type'] == 'article'
				AND $flux['args']['tout'] == '0'
				AND $points = $flux['data']) {
				$serveur = $flux['args']['serveur'];
				$p2      = array();
				$s       = sql_select(
					"id_article",
					"spip_articles",
					"statut='publie' 
						AND " . sql_in('id_article', array_keys($points), '', '', '', '', $serveur) . " 
						AND " . sql_in('id_secteur', array_values($id_secteurs), 'NOT', '', '', '', $serveur)
				);
				while ($t = sql_fetch($s, $serveur)) {
					$p2[ $t['id_article'] ] = '';
				}
				$p2           = array_intersect_key($points, $p2);
				$flux['data'] = $p2;
			}
			if ($flux['args']['type'] == 'rubrique'
				AND $flux['args']['tout'] == '0'
				AND $points = $flux['data']) {
				$serveur = $flux['args']['serveur'];
				$p2      = array();
				$s       = sql_select(
					"id_rubrique",
					"spip_rubriques",
					"statut='publie' 
						AND " . sql_in('id_rubrique', array_keys($points), '', '', '', '', $serveur) . " 
						AND " . sql_in('id_secteur', array_values($id_secteurs), 'NOT', '', '', '', $serveur)
				);
				while ($t = sql_fetch($s, $serveur)) {
					$p2[ $t['id_article'] ] = '';
				}
				$p2           = array_intersect_key($points, $p2);
				$flux['data'] = $p2;
			}
		}
	}

	return $flux;
}

