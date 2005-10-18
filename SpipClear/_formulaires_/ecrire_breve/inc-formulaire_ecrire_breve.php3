<?php

if (!defined("_ECRIRE_INC_VERSION")) return;	#securite

// Le contexte indique dans quelle rubrique le visiteur peut ecrire la breve
global $balise_FORMULAIRE_ECRIRE_BREVE_collecte;
$balise_FORMULAIRE_ECRIRE_BREVE_collecte = array('id_rubrique', 'lang');

function balise_FORMULAIRE_ECRIRE_BREVE_stat($args, $filtres) {

	// Pas d'id_rubrique ? Erreur de squelette
	if (!$args[0])
		return erreur_squelette(
			_T('zbug_champ_hors_motif',
				array ('champ' => '#FORMULAIRE_ECRIRE_BREVE',
					'motif' => 'RUBRIQUES')), '');

	// Verifier que les visisteurs sont autorises a proposer un site
	return (((lire_meta("activer_breves")!= 2) || (!$GLOBALS["auteur_session"])) ? '' : $args);
}

function balise_FORMULAIRE_ECRIRE_BREVE_dyn($id_rubrique,$lang) {

	if (!_request('titre')) return array('formulaire_ecrire_breve', 0);

	// Tester le nom du site
	//if (strlen (_request('titre')) < 2){
	//	return _T('form_prop_indiquer_nom_site');
	//}

	// Tester l'URL du site
	//include_ecrire("inc_sites.php3");
	//if (!recuperer_page(_request('url_site')))
	//	return _T('form_pet_url_invalide');

	// Integrer a la base de donnees
	$titre = addslashes(_request('titre'));
	$texte = addslashes(_request('texte'));
	$nom_site = addslashes(_request('nom_site'));
	$url_site = addslashes(_request('url_site'));
	$query="INSERT INTO spip_breves (titre, texte, nom_site, url_site, statut, id_rubrique, date_heure,maj, lang) VALUES ('$titre','$texte', '$nom_site', '$url_site','prop', $id_rubrique,  NOW(), NOW(), '$lang')";
	spip_query($query);

	return  _T('form_prop_enregistre');
}

?>