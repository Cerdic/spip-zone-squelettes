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
	AND $s = spip_query("SELECT * FROM spip_auteurs WHERE id_auteur="._q($auteur))
	AND $t = spip_fetch_array($s)) {
		return typo($t['nom']);
	} else {
		return $auteur;
	}
}


// Creation d'un nouvel article du WIKI -- cf. inc-entete
if (isset($_POST['ajouter_page_wiki'])
AND isset($_POST['id_rubrique'])
AND $_POST['id_rubrique'] == $GLOBALS['contexte_inclus']['id_rubrique']) {
	$id_rubrique = intval($_POST['id_rubrique']);
	include_spip('inc/autoriser');
	if (autoriser('publierdans', 'rubrique', $id_rubrique)) {
		$s = spip_query("SELECT id_secteur FROM spip_rubriques WHERE id_rubrique=$id_rubrique");
		if ($t = spip_fetch_array($s)) {
			$id_secteur = $t['id_secteur'];
			spip_query("INSERT spip_articles (id_rubrique, id_secteur, statut, titre, date) VALUES ($id_rubrique, $id_secteur, 'publie', "._q($_POST['ajouter_page_wiki']).", NOW())");
			$id_article = spip_insert_id();
			charger_generer_url();
			include_spip('inc/headers');
			redirige_par_entete(generer_url_article($id_article, '&'));
		}

	}
}

define ('RUBRIQUE_WIKI_OK', true);

?>