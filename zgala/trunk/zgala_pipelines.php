<?php
/**
 * Ce fichier contient les cas d'utilisation des pipelines.
 *
 * @package SPIP\ZGALA\Pipelines
 */
if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}


/**
 * Suppression des blocs head et head_js de la liste des blocs pouvant, par défaut,
 * accueillir des noisettes.
 *
 * @pipeline noizetier_blocs_defaut
 *
 * @param array $blocs
 *        Liste blocs par défaut concernés par le NoiZetier
 *
 * @return array
 *        Liste des blocs modifiés. On supprime les blocs head et head_js.
 */
function zgala_noizetier_blocs_defaut($blocs) {

	static $blocs_exclus = array('head', 'head_js');
	if ($blocs) {
		$blocs = array_diff($blocs, $blocs_exclus);
	}

	return $blocs;
}
