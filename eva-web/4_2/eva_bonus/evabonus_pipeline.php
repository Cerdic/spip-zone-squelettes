<?php
$p=explode(basename(_DIR_PLUGINS)."/",str_replace('\\','/',realpath(dirname(__FILE__))));
define('_DIR_PLUGIN_EVABONUS',(_DIR_PLUGINS.end($p)));

	function evabonus_AjouterBoutons($boutons_admin) {
		// si on est admin
		if ($GLOBALS['connect_statut'] == "0minirezo" && $GLOBALS["connect_toutes_rubriques"]) {
		  // on voit le bouton dans la barre "naviguer"
			$boutons_admin['configuration']->sousmenu['eva_bonus']= new Bouton(
			"../"._DIR_PLUGIN_EVABONUS."/img_pack/logo_eva_bonus.png",  // icone
			_T('evabonus:evabonus_nom')	// titre
			);
		}
		return $boutons_admin;
	}

?>