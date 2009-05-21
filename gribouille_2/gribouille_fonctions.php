<?php

// utiliser par exemple, pour afficher une ligne de diff :
//  [<small> (#ID_ARTICLE|affiche_diff{#ID_VERSION,'diff'}|supprimer_tags|couper{50})</small>]
function affiche_diff($id_article, $id_version, $format='complet') {
	include_spip('inc/suivi_versions');

	$textes = revision_comparee($id_article, $id_version, $format);

	$ret = '';
	foreach ($textes as $champ => $texte) {
		$texte = propre_diff($texte);

		if ($champ == 'titre')
			$texte = "<h1>$texte</h1>";
		else
			$texte = "<div class='$k'>$texte</div>";

		$ret .= "\n<hr/>\n". $texte;
	}

	return $ret;
}

function affiche_auteur_diff($auteur) {

	// Si c'est un nombre, c'est un auteur de la table spip_auteurs
	if ($auteur == intval($auteur)
	AND $s = sql_select("*","spip_auteurs","id_auteur=".sql_quote($auteur))
	AND $t = sql_fetch($s)) {
		return typo($t['nom']);
	} else {
		return $auteur;
	}
}

?>