<?php

if (!defined("_ECRIRE_INC_VERSION")) return;	#securite

// Pas besoin de contexte de compilation
global $balise_CALENDRIER_SCOLASPIP_collecte;
$balise_CALENDRIER_SCOLASPIP_collecte = array('id_rubrique','id_article','id_mot');

function balise_CALENDRIER_SCOLASPIP ($p) {
	return calculer_balise_dynamique($p,'CALENDRIER_SCOLASPIP', array('id_rubrique','id_article', 'id_mot'));
}

function balise_CALENDRIER_SCOLASPIP_stat($args, $filtres) {
	return $args;
}

function balise_CALENDRIER_SCOLASPIP_dyn($id_rubrique=0, $id_article = 0, $id_mot = 0,$date, $var_date = 'date', $url = '') {
	if(!$url)
		$url = self();
	// nettoyer l'url qui est passee par htmlentities pour raison de securités
	$url = str_replace("&amp;","&",$url);

	return array('formulaires/calendrier_scolaspip', 0,
		array(
			'date' => $date,
			'id_rubrique' => $id_rubrique,
			'id_article' => $id_article,
			'id_mot' => $id_mot,
			'var_date' => $var_date,
			'self' => $url,
		));
}

?>
