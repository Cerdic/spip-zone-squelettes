<?php

if (!defined("_ECRIRE_INC_VERSION")) return;	#securite

// Le contexte indique dans quelle rubrique et sur quelle periode le visiteur fait sa recherche
global $balise_FORMULAIRE_RECHERCHE_collecte;
$balise_FORMULAIRE_RECHERCHE_collecte = array('id_rubrique');

function balise_FORMULAIRE_RECHERCHE_stat($args, $filtres) {
	// Si le moteur n'est pas active, pas de balise
	if (lire_meta("activer_moteur") != "oui")
		return '';

	// pas d'agurments
	else 
		return $args;
}
 
function balise_FORMULAIRE_RECHERCHE_dyn($id_rubrique = 0) {
	global $type_urls;
	include_ecrire('inc_filtres.php3');
	include_local("inc-urls-$type_urls.php3");

	if (!$recherche_securisee = entites_html(_request('recherche'))) {
	  $recherche_securisee = _T('un_seul_mot');
	}

	if (!$lien) {
		$lien = generer_url_rubrique($id_rubrique);	# par defaut
	}

	return array('formulaire_recherche', 3600, 
		array(
			'lien' => $lien,
			'id_rubrique' => $id_rubrique,
			'recherche_securisee' => $recherche_securisee
		));
}

?>
