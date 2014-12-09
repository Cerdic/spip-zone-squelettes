<?php
if (!isset($GLOBALS['z_blocs']))
	$GLOBALS['z_blocs'] = array('content','head','head_js','footer');

define('_ALBUMS_INSERT_HEAD_CSS',false);

// depuis spipr-doc
function title2anchor($titre,$id_article=""){
	include_spip("inc/charsets");
	$titre = strip_tags($titre);
	$titre = translitteration($titre);
	$titre = supprimer_numero($titre);
	$titre = preg_replace(",\W,","",$titre);
	$titre = strtolower($titre);
	if (preg_match(',^\d,',$titre))
		$titre = "a$titre";
	$titre = $titre.$id_article;
	return $titre;
}
function urls_generer_url_article_dist($id, $args, $ancre){

	$row = sql_fetsel('id_rubrique,titre','spip_articles','id_article='.intval($id));
	// si il y a bien une rubrique > 0 (on laisse passer les pages uniques)
	if ($row['id_rubrique']>0)
		return generer_url_entite($row['id_rubrique'],'rubrique','',title2anchor($row['titre'],$id),true);

	return null;
}
