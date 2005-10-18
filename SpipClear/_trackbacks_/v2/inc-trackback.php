<?php

	//trackback4spip V2
	//(c)2005 James <klike@free.fr>
	//Licence GNU/GPL

	//corrections SPIP_FORUM
	/*
	ALTER TABLE `spip_forum` ADD `trackback` VARCHAR( 3 ) DEFAULT 'non' NOT NULL ;
	ALTER TABLE `spip_forum` ADD INDEX ( `trackback` ) ;

	ALTER TABLE `spip_articles` ADD `accepter_trackback` VARCHAR( 3 ) NOT NULL ;
	*/

	//MàJ Trackback V1
	/*
	UPDATE `spip_forum` SET `statut`='publie', `trackback`='oui' WHERE `statut`='tbpublie' ;
	UPDATE `spip_forum` SET `statut`='prop', `trackback`='oui' WHERE `statut`='tbprop' ;
	UPDATE `spip_forum` SET `statut`='off', `trackback`='oui' WHERE `statut`='tboff' ;
	*/

// SQL
# retourne le champ 'accepter_trackback' d'un article
function sql_accepter_trackback($id_article) {
	static $cache = array();

	if (!$id_article) return;

	if (!isset($cache[$id_article])) {
		$row = spip_abstract_fetsel(array('accepter_trackback'),
			array('spip_articles'),
			array("id_article=".intval($id_article)));
		$cache[$id_article] = $row['accepter_trackback'];
	}

	return $cache[$id_article];
}

// {trackback}
function critere_trackback($idb, &$boucles, $crit) {
	$not = $crit->not;
	$boucle = &$boucles[$idb];

	if ($not)
		erreur_squelette(_T('zbug_info_erreur_squelette'), $param);

	$boucle->where['trackback'] = '1';
	$boucle->where[] = $boucle->id_table.".trackback='oui'";

}

//
// <BOUCLE(FORUMS)>
//
function boucle_FORUMS($id_boucle, &$boucles) {
	$boucle = &$boucles[$id_boucle];
	$id_table = $boucle->id_table;
	//$boucle->from[] =  "spip_forum AS $id_table"; /* 1.8.2 */
	$boucle->from[$id_table] =  "spip_forum"; /* 1.9 */
	// Par defaut, selectionner uniquement les forums sans pere
	if (!$boucle->tout AND !$boucle->plat)
		$boucle->where[] = "$id_table.id_parent=0";

	// Restreindre aux elements publies
	if (!isset($boucle->where['statut'])) {
		$boucle->where['statut'] = "$id_table.statut='publie'";
	}

	// Restreindre aux commentaires interactifs
	if (!isset($boucle->where['trackback'])) {
		$boucle->where['trackback'] = "$id_table.trackback='non'";
	}

	return calculer_boucle($id_boucle, $boucles); 
}

/**
@function generer_url_trackback

Cette fonction calcule l'url absolue de trackback
*/
function generer_url_trackback($type, $id) {
	$col_id = id_table_objet($type);
	return url_absolue("spip_tb.php?".$col_id."=".$id);
}

/**
@function balise_URL_TRACKBACK

Cette fonction affiche l'url absolue de trackback
*/
function balise_URL_TRACKBACK($p) {
	switch ($p->type_requete) {
		case 'articles':
			$_type = 'article'; 
			$_id = champ_sql('id_article', $p);
			break;
		case 'breves':
			$_type = 'breve'; 
			$_id = champ_sql('id_breve', $p);
			break;
	}
	$p->code = "generer_url_trackback('$_type', $_id)";
	$p->statut = 'html';
	return $p;
}

/**
@function balise_PARAMETRES_TRACKBACK

Cette fonction permet de savoir si oui ou non, l'article accepte les trackbacks
*/
function balise_PARAMETRES_TRACKBACK($p) {
	$_id_article = champ_sql('id_article', $p);
	$p->code = '
		// refus des trackbacks ?
		(sql_accepter_trackback('.$_id_article.')=="non" OR
		(lire_meta("trackbacks") == "non"
		AND sql_accepter_trackback('.$_id_article.') == ""))
		? "" : // sinon:
		" "';
	$p->statut = 'html';
	return $p;
}

?>
