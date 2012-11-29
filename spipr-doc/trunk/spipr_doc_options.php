<?php
$GLOBALS['z_blocs'] = array('content','aside','head','head_js','header','footer');

if ($GLOBALS['visiteur_session']['statut']=='0minirezo')
	$GLOBALS['marqueur'].=":minirezo";

define('_ZENGARDEN_FILTRE_THEMES','spipr');
define('_ALBUMS_INSERT_HEAD_CSS',false);

function title2anchor($titre,$id_article=""){
	include_spip("inc/charsets");
	$titre = translitteration($titre);
	$titre = supprimer_numero($titre);
	$titre = preg_replace(",\W,","",$titre);
	$titre = strtolower($titre);
	if (preg_match(',^\d,',$titre))
		$titre = "a$titre";
	return $titre;
}

function urls_generer_url_article_dist($id, $args, $ancre){

	$row = sql_fetsel('id_rubrique,titre','spip_articles','id_article='.intval($id));
	return generer_url_entite($row['id_rubrique'],'rubrique','',title2anchor($row['titre'],$id),true);

}

function placeholder($texte,$p=true){
	if (!$texte
		AND !strlen($texte)
		AND $GLOBALS['visiteur_session']['statut']=='0minirezo'){
		$texte = "<i class='mute' title='Inserer un texte'>¤</i>";
		if ($p)
			$texte = "<p class='placeholder muted'>$texte</p>";
	}
	return $texte;
}
?>