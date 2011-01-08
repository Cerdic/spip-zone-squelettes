<?php

function affdate_long($date) {
	return affdate_base($date, 'nom_jour').' '.affdate_base($date, 'entier');
}

/**
 * |me compare un id_auteur avec les auteurs d'un article
 * et renvoie la valeur booleenne true (vrai) si on trouve une correspondance
 * utilisation: <div id="forum#ID_FORUM"[(#ID_ARTICLE|me{#ID_AUTEUR}|?{' ', ''})class="me"]>
 * @param int $id_article
 * @param int $id_auteur
 * @return boolean
 */
function me($id_article, $id_auteur = 0) {
	static $deja = false;
	static $auteurs = array();
	if(!$deja) {
		$r = sql_select('id_auteur', 'spip_auteurs_articles', "id_article=$id_article");
		while($row = sql_fetch($r))
			$auteurs[] = intval($row['id_auteur']);
		$deja = true;
	}
	return in_array($id_auteur, $auteurs);
}

/**
 * Balise #DC_CLASS
 * @param <type> $p
 * @return string
 */
function balise_DC_CLASS ($p) {
	$type = champ_sql('type', $p);
	$composition = champ_sql('composition', $p);
	$p->code = "calculer_dc_class(".$type.",".$composition.")";
	return $p;
}

/**
 * Definir une classe en fonciton du type de page ou de la composition utilisee
 * @param string $type
 * @param string $composition
 * @return string
 */
function calculer_dc_class ($type, $composition) {
	$class= '';
	if ($composition == 'sommaire')
		$class = 'dc-home';
	if ($composition == 'archive')
		$class = 'dc-archive';
	if ($composition == 'search')
		$class = 'dc-search';
	if ($type == 'article')
		$class = 'dc-post';
	if ($type == 'rubrique')
		$class = 'dc-category';
	if ($type == 'mot')
		$class = 'dc-tag';
	return $class;
}

?>
