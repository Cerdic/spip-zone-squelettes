<?php
$p=explode(basename(_DIR_PLUGINS)."/",str_replace('\\','/',realpath(dirname(__FILE__))));
define('_DIR_PLUGIN_EVAHABILLAGE',(_DIR_PLUGINS.end($p)));

	function eva_habillage_AjouterBoutons($boutons_admin) {
		// si on est admin
		if ($GLOBALS['connect_statut'] == "0minirezo" && $GLOBALS["connect_toutes_rubriques"]) {
		  // on voit le bouton dans la barre "naviguer"
			$boutons_admin['configuration']->sousmenu['eva_habillage']= new Bouton(
			"../"._DIR_PLUGIN_EVAHABILLAGE."/img_pack/eva3.gif",  // icone
			_T('evahabillage:EVA_nom_court')	// titre
			);
		}
		return $boutons_admin;
	}
	
	function eva_habillage_declarer_tables_interfaces($interface){
		$interface['table_des_tables']['eva_habillage']='eva_habillage';
		$interface['table_des_tables']['eva_habillage_themes']='eva_habillage_themes';
		$interface['table_des_tables']['eva_habillage_images']='eva_habillage_images';
	return $interface;
	}

?>