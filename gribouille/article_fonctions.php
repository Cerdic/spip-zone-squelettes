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
AND $_POST['id_rubrique'] == $GLOBALS['contexte']['id_rubrique']) {
	$id_rubrique = intval($_POST['id_rubrique']);
	$id_article = null;

	// on verifie d'abord qu'un article de ce titre n'existe pas deja
	$s = spip_query("SELECT id_article FROM spip_articles WHERE titre="
	._q($_POST['ajouter_page_wiki'])." OR url_propre="
	._q($_POST['ajouter_page_wiki']));
	if ($t = spip_fetch_array($s)) {
		$id_article = $t['id_article'];
	} else {
		include_spip('inc/autoriser');
		if (autoriser('publierdans', 'rubrique', $id_rubrique)) {
			include_spip('action/editer_article');
			$id_article = insert_article($id_rubrique);
			include_spip('inc/modifier');
			$r = modifier_contenu('article', $id_article,
				array('champs' => array('titre', 'statut')),
				array(
					'titre' => $_POST['ajouter_page_wiki'],
					'statut' => 'publie'
				)
			);
		}
	}

	if (!$id_article)
		die("Erreur : creation d'article interdite");

	charger_generer_url();
	include_spip('inc/headers');
	redirige_par_entete(generer_url_article($id_article, '&'));
}

define ('RUBRIQUE_WIKI_OK', true);

?>