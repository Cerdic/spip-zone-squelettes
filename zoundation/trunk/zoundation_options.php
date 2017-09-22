<?php
/**
 * Options du plugin Zoundationau chargement
 *
 * @plugin     Zoundation
 * @copyright  2013
 * @author     Phenix
 * @licence    GNU/GPL
 * @package    SPIP\Zoundation\Options
 */

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

$GLOBALS['z_blocs'] = array('content','colonne','head','head_js','header','footer');

// Par défaut les intertitre produise des H2
$GLOBALS['debut_intertitre'] = "\n<h2 class=\"spip\">\n";
$GLOBALS['fin_intertitre'] = "</h2>\n";