<?php 
/**
 * Plugin MediaSPIP Init
 * © 2010-2012 kent1 (kent1@arscenic.info)
 * Distribué sous licence GNU/GPL v3
 * 
 * Fichier des options du plugin
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * On enlève le cookie de mutualisation
 */
if(isset($_COOKIE['mutu_code_activation'])){
	setcookie('mutu_code_activation', false,time() - 3600);
}

if(defined('_DIR_PLUGIN_FULLTEXT')){
	define('_FULLTEXT_PDF_EXE','pdftotext');
	define('_FULLTEXT_PDF_CMD_OPTIONS','-enc UTF-8');
	define('_FULLTEXT_TAILLE',1000000);
}
?>