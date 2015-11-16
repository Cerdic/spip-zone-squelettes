<?php
/**
 * Options du plugin spipr videau chargement
 *
 * @plugin     spipr vide
 * @copyright  2013
 * @author     Alain Cousin
 * @licence    GNU/GPL
 * @package    SPIP\Spipr_vide\Options
 */

if (!defined('_ECRIRE_INC_VERSION')) return;

if (!isset($GLOBALS['z_blocs']))
	$GLOBALS['z_blocs'] = array('content','aside','extra','head','head_js','header','footer','breadcrumb');

define('_ZENGARDEN_FILTRE_THEMES','spipr');
define('_ALBUMS_INSERT_HEAD_CSS',false);
define('_NOIZETIER_REPERTOIRE_PAGES','content/');
define('_NOIZETIER_LISTER_PAGES_SANS_XML',false);
define('_NOIZETIER_COMPOSITIONS_TYPE_PAGE',true);
define('_NOIZETIER_RECUPERER_FOND',true);

$GLOBALS['z_blocs_404'] = array();

if (
	defined('_SPIPR_AUTH_DEMO')?
		_SPIPR_AUTH_DEMO
		:
		(isset($GLOBALS['visiteur_session']['statut'])
	AND $GLOBALS['visiteur_session']['statut']=='0minirezo'
	AND $GLOBALS['visiteur_session']['webmestre']=='oui')
	)
	_chemin(_DIR_PLUGIN_SPIPR_DIST."demo/");
?>