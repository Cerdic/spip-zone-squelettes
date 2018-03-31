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
 * Affiche le diff d'un objet
 * (uniquement pour les articles en 2.0.X)
 * Ex: [<small> (#ID_ARTICLE|affiche_diff{article,#ID_VERSION,diff}|supprimer_tags|couper{50})</small>]
 *
 * @param int    $id_objet
 * @param string $objet
 * @param int    $id_version
 * @param string $format [optional]
 *
 * @return string
 */
function affiche_diff($id_objet, $objet, $id_version, $format = 'complet') {
	include_spip('inc/suivi_versions');
	
	$textes = revision_comparee($id_objet, $objet, $id_version, $format);
	$ret = '';
	foreach ($textes as $champ => $texte) {
		if ($champ == 'titre') {
			$ret .= '<h1>'.propre_diff($texte).'</h1>';
		}
		else if ($champ == 'texte') {
			$ret .= '<div>'.propre_diff($texte).'</div>';
		}
	}

	return $ret;
}

function boucle_secteurs_wiki() {
	return lire_config('gribouille/secteurs_wiki');
}

// un critère qui restreint les boucles articles et rubriques aux secteurs wiki
function critere_wiki($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
	$id_table = $boucle->id_table;
	$boucle->where[] = array("'IN'", "'$id_table.id_secteur'", "'('.join(',',boucle_secteurs_wiki()).')'");
	$boucle->modificateur['wiki'] = true;
}
