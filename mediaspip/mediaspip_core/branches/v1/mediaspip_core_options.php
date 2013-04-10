<?php
/**
 * Plugin Mediaspip Core
 * 
 * © 2010-2011 kent1 (kent1@arscenic.info)
 * Distribué sous licence GNU/GPL v3
 * 
 * Fichier des options spécifiques du plugin (utilisées à chaque hit)
 */
if (!defined("_ECRIRE_INC_VERSION")) return;

define('_DIR_LIB_SVG',_DIR_RACINE.'lib/jquery.svg.package-1.4.4/');
define('_DIR_LIB_SLIDER',_DIR_RACINE.'lib/easyslider1.7/easyslider1.7/');

$forcer_lang = true;

$GLOBALS['spip_pipeline']['mediaspip_extensions_lisibles'] = "";
$GLOBALS['table_des_traitements']['TITRE'][]= 'typo(supprimer_numero(%s))';

define('_STATUT_AUTEUR_CREATION', '6forum');

/**
 * Définir les APIS de cartographie utilisables et celle par défaut
 */
define('_GIS_APIS', serialize(array('google' => _T('gis:cfg_lbl_api_google'),'googlev3' => _T('gis:cfg_lbl_api_googlev3'))));
define('_GIS_APIS_DEFAUT','googlev3');
define('_GIS_APIS_FORCEE','googlev3');

if (
	( // on est en mode apercu
		(isset($_COOKIE['spip_zengarden_theme']) AND $t = $_COOKIE['spip_zengarden_theme'])
        // ou avec le cookie du switcher
		OR
		// ou un theme est vraiment selectionne
		(isset($GLOBALS['meta']['zengarden_theme']) AND $t = $GLOBALS['meta']['zengarden_theme']))
		AND is_dir(_DIR_THEMES . $t)){
			if(file_exists(_DIR_THEMES . $t.'/theme_options.php')){
				include_spip(_DIR_THEMES . $t.'/theme_options');
			}
		}
		
/**
 * Les couleurs et tailles de fichiers pour emballe medias :
 * - couleur claire
 * - couleur foncée
 * - couleur du texte du bouton
 * - la largeur maximale de la previsu
 * - la hauteur maximale de la previsu
 */
if(!defined(_EM_COULEUR_FONCEE))
	define('_EM_COULEUR_FONCEE','#408BB6');
if(!defined(_EM_COULEUR_CLAIRE))
	define('_EM_COULEUR_CLAIRE','#59A5D1');
if(!defined(_EM_COULEUR_TEXTE_BOUTON))
	define('_EM_COULEUR_TEXTE_BOUTON','#FFFFFF');
if(!defined(_EM_PREVISU_HAUTEUR))
	define('_EM_PREVISU_HAUTEUR','400');
define('_EM_PREVISU_LARGEUR','400');

/**
 * Les limites de nombre de fichiers pour emballe medias
 * - _EM_FILE_UPLOAD_LIMIT : Le nombre maximum de fichier que l'on peut uploader dans un article (1)
 * - _EM_FILE_QUEUE_LIMIT : Le nombre maximum de fichier que l'on peut mettre dans la file d'upload dans un article (1)
 */
define('_EM_FILE_UPLOAD_LIMIT','1');
define('_EM_FILE_QUEUE_LIMIT','1');

function mediaspip_mini_html($texte) {
	$texte = preg_replace(array(",[\n\r][\t\ ]*,",",\n+,"), "\n", $texte);
	return $texte;
}
?>