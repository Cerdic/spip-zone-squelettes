<?php

// =======================================================================================================================================
// Filtre : lister_fonds
// =======================================================================================================================================
// Auteur: Smellup
// Fonction : Retourne la chaine des options du select de la liste des fonds
// =======================================================================================================================================
//
function lister_fonds($bidon, $image, $suffixe){
	if (function_exists('lire_config'))
		$f_selected = lire_config('sarkaspip_styles/fond_'.$image.$suffixe);

	$dir = sous_repertoire(_DIR_TMP, 'fonds');
	$saves = preg_files($dir);
	$options = '<option value="">--</option>';
	foreach ($saves as $_fichier) {
		$nom = basename($_fichier);
		$selected = ($_fichier == $f_selected) ? ' selected="selected"' : '';
		$options .= '<option value="' . $_fichier . '"' . $selected . '>' . $nom . '</option>';
	}

	return $options;
}
// FIN du Filtre : lister_fonds

?>