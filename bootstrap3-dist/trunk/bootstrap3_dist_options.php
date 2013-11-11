<?php
/**
 * Options du plugin Bootstrap3 - Distau chargement
 *
 * @plugin     Bootstrap3 - Dist
 * @copyright  2013
 * @author     Teddy Payet
 * @licence    GNU/GPL
 * @package    SPIP\Bootstrap3_Dist\Options
 */

if (!defined('_ECRIRE_INC_VERSION')) return;


if (!isset($GLOBALS['z_blocs']))
	$GLOBALS['z_blocs'] = array('content','aside','extra','head','head_js','header','footer','breadcrumb');

define('_ZENGARDEN_FILTRE_THEMES','bootstrap3_dist');

?>