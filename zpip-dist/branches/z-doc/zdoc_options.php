<?php
$GLOBALS['z_blocs'] = array('content','aside','head','head_js','header','footer');
define('_ZENGARDEN_FILTRE_THEMES','zboot');
define('_ALBUMS_INSERT_HEAD_CSS',false);

function title2anchor($titre,$id_article=""){
	include_spip("inc/charsets");
	$titre = translitteration($titre);
	$titre = preg_replace(",\W,","",$titre);
	$titre = strtolower($titre);
	if (preg_match(',^\d,',$titre))
		$titre = "a$titre";
	return $titre;
}

?>