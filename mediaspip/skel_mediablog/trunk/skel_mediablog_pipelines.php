<?php
/**
 * Plugin Mediaspip Blog
 * 
 * Auteurs :
 * kent1 (http://www.kent1.info - kent1@arscenic.info)
 *
 * © 2010-2013 - Distribue sous licence GNU/GPL
 * 
 * Fichier des pipelines utilisés par le plugin
 * 
 * @package SPIP\Skel_mediablog\Pipelines
 */
if (!defined("_ECRIRE_INC_VERSION")) return;


/**
 * Insertion dans le pipeline insert_head_css (SPIP)
 * 
 * Ajout d'une feuille de styles "css/ms_blog.css" si présente
 * 
 * @param string $flux 
 * 		Le contenu textuel de la balise #INSERT_HEAD_CSS
 * @return string $flux 
 * 		Le contenu textuel modifié de la balise #INSERT_HEAD_CSS
 */
function skel_mediablog_insert_head_css($flux){
	if($css = find_in_path('css/ms_blog.css')){
		$flux .= '
<link rel="stylesheet" href="'.direction_css($css).'" type="text/css" media="all" />
';
	}
	return $flux;
}

?>