<?php

// Creation d'un nouvel article du WIKI -- cf. inc-entete
if (_request('ajouter_page_jaycee')!==NULL
AND (!preg_match(",http://,",_request('ajouter_page_wiki'))) // pas d'url en titre de page, non mais
AND _request('id_rubrique')!==NULL
AND (!_request('pas_de_robot_merci'))
AND _request('id_rubrique') == $GLOBALS['contexte']['id_rubrique']) {
	$id_rubrique = intval($_POST['id_rubrique']);
	$id_article = null;

	// on verifie d'abord qu'un article de ce titre n'existe pas deja
		include_spip('inc/autoriser');
		if (autoriser('publierdans', 'rubrique', $id_rubrique)) {
			include_spip('action/editer_article');
			$id_article = insert_article($id_rubrique);
			include_spip('inc/modifier');
			$r = modifier_contenu('article', $id_article,
				array('champs' => array('titre', 'statut')),
				array(
					'titre' => _request('ajouter_page_wiki'),
					'statut' => 'publie'
				)
			);
		}

	if (!$id_article)
		die("Erreur : creation d'article interdite");

	charger_generer_url();
	include_spip('inc/headers');
	redirige_par_entete(generer_url_article($id_article, '&'));
}

define ('RUBRIQUE_WIKI_OK', true);

?>
