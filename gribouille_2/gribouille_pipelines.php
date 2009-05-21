<?php

// utiliser le pipeline 'styliser' pour
// définir le squelette a utiliser si on est dans le cas
// d'une rubrique de Gribouille

function gribouille_styliser($flux){
	// si article, rubrique ou sommaire,
	// on cherche si spip clear doit s'activer
	if (($fond = $flux['args']['fond'])
	AND in_array($fond, array('article','rubrique'))) {
		
		$ext = $flux['args']['ext'];

		// cas dans une rubrique
		// uniquement si configuration de spipClear pour le secteur en question
		if($id_rubrique = $flux['args']['id_rubrique']) {
			$id_secteur = sql_getfetsel('id_secteur', 'spip_rubriques', 'id_rubrique=' . intval($id_rubrique));
			if (in_array($id_secteur, lire_config('gribouille/secteurs_wiki', array(0,-1)))) {
				if ($squelette = test_squelette_gribouille($fond, $ext)) {
					$flux['data'] = $squelette;
				}
			}
		}
	}
	return $flux;
}

function test_squelette_gribouille($fond, $ext) {
	if ($squelette = find_in_path($fond."_gribouille.$ext")) {
		return substr($squelette, 0, -strlen(".$ext"));
	}
	return false;
}
?>
