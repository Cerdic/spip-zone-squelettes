<?php
// Balise #LOGOA
// http://romy.tetue.net/logos-automatiques-articles-SPIP#forum2039
	function balise_LOGOA_dist($p) {
		$_id_article = champ_sql('id_article', $p);
		$_id_rubrique= champ_sql('id_rubrique', $p);

		$p->code = "recuperer_fond('balises/logoa',array('id_article'=>$_id_article,'id_rubrique'=>$_id_rubrique))";
		$p->interdire_scripts = false;
		return $p;
	}

/*** https://contrib.spip.net/1398
 * (c)James 2006, Licence GNU/GPL
 * |me compare un id_auteur, par exemple,
 * d'une boucle FORUMS avec les auteurs d'un article
 * et renvoie la valeur booleenne true (vrai) si on trouve
 *  une correspondance
 * utilisation: 
 * <div id="forum#ID_FORUM"[(#ID_ARTICLE|me{#ID_AUTEUR}|?{' ', ''})class="me"]>
 ***/
function me($id_article, $id_auteur, $sioui = true, $sinon = false) {
	static $deja = false;
	static $auteurs = array();
	if(!$deja) {
		$r = spip_query("SELECT id_auteur
			FROM spip_auteurs_articles
			WHERE id_article=$id_article");
		while($row = spip_fetch_array($r))
			$auteurs[] = intval($row['id_auteur']);
		$deja = true;
	}
	return in_array($id_auteur, $auteurs)?$sioui:$sinon;
}
function balise_ME($p){
	$p->code = "me(".
		champ_sql('id_article', $p).', '.
		champ_sql('id_auteur', $p).', '.
		"'me', '')";
	return $p;
}