<?php

/**
@function generer_url_trackback

Cette fonction calcule l'url absolue de trackback
*/
function generer_url_trackback($id) {
	return url_absolue("spip_tb.php?id_article=".$id);
}

/**
@function balise_URL_TRACKBACK

Cette fonction affiche l'url absolue de trackback de l'article
*/
function balise_URL_TRACKBACK($p) {
	$_id = champ_sql('id_article', $p);
	$p->code = "generer_url_trackback($_id)";
	$p->statut = 'html';
	return $p;
}

/**
@function balise_PARAMETRES_TRACKBACK

Cette fonction permet de savoir si oui ou non, l'article accepte les trackbacks
*/
function balise_PARAMETRES_TRACKBACK($p) {
	//1ère phase : simulation champ d'article par ecrire/mes_options.php3 (champ extra)
	include_ecrire("inc_extra.php3");
	$_extra = champ_sql('extra', $p);
	$p->code = "extra($_extra, 'accepter_trackbacks') == 'non'?'':' '";
	$p->statut = 'html';
	return $p;
	//2ème phase : exploitation base de donnée
}

?>
