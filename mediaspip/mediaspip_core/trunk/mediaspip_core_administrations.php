<?php
/**
 * Plugin MediaSPIP Core
 *
 * Auteurs :
 * kent1 (http://www.kent1.info - kent1@arscenic.info)
 *
 * © 2008/2012 - Distribue sous licence GNU/GPL
 *
 * Installation du plugin
 **/

if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * Fonction d'installation et de mise à jour du plugin
 * @param string $nom_meta_base_version Le nom de la meta
 * @param string $version_cible La version actuelle
 */
function mediaspip_core_upgrade($nom_meta_base_version,$version_cible){
	$maj = array();
	
	$maj['create'] = array(
		array('maj_tables',array('spip_articles'))
	);

	include_spip('base/upgrade');
	maj_plugin($nom_meta_base_version, $version_cible, $maj);
}
?>