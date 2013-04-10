<?php
/**
 * Plugin Mediaspip Core
 * 
 * Auteurs :
 * kent1 (http://www.kent1.info - kent1@arscenic.info)
 *
 * © 2010-2013 - Distribue sous licence GNU/GPL
 * 
 * Fichier des options spécifiques du plugin (utilisées à chaque hit)
 */
if (!defined('_ECRIRE_INC_VERSION')) return;

define('_ZENGARDEN_FILTRE_THEMES','mediaspip_core');

define('_DIR_LIB_SVG',_DIR_RACINE.'lib/jquery.svg.package-1.4.4/');
define('_DIR_LIB_SLIDER',_DIR_RACINE.'lib/easyslider1.7/easyslider1.7/');

$GLOBALS['forcer_lang'] = true;

define('_STATUT_AUTEUR_CREATION', '6forum');

if (
	( // on est en mode apercu
		(isset($_COOKIE['spip_zengarden_theme']) AND $t = $_COOKIE['spip_zengarden_theme'])
        // ou avec le cookie du switcher
		OR
		// ou un theme est vraiment selectionne
		(isset($GLOBALS['meta']['zengarden_theme']) AND $t = $GLOBALS['meta']['zengarden_theme']))
		AND is_dir(_DIR_RACINE . $t)){
			if(file_exists(_DIR_RACINE . $t.'/theme_options.php')){
				include_spip(_DIR_RACINE . $t.'/theme_options');
			}
		}
/**
 * Les limites de nombre de fichiers pour emballe medias
 * - _EM_FILE_UPLOAD_LIMIT : Le nombre maximum de fichier que l'on peut uploader dans un article (1)
 * - _EM_FILE_QUEUE_LIMIT : Le nombre maximum de fichier que l'on peut mettre dans la file d'upload dans un article (1)
 */
define('_EM_FILE_UPLOAD_LIMIT','1');
define('_EM_FILE_QUEUE_LIMIT','1');

if(!defined('_EM_PREVISU_HAUTEUR'))
	define('_EM_PREVISU_HAUTEUR','400');
if(!defined('_EM_PREVISU_LARGEUR'))
	define('_EM_PREVISU_LARGEUR','400');
?>