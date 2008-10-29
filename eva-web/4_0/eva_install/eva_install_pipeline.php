<?php
$p=explode(basename(_DIR_PLUGINS)."/",str_replace('\\','/',realpath(dirname(__FILE__))));
define('_DIR_PLUGIN_EVAINSTALL',(_DIR_PLUGINS.end($p)));

	function eva_install_AjouterBoutons($boutons_admin) {
		// si on est admin
		if ($GLOBALS['connect_statut'] == "0minirezo" && $GLOBALS["connect_toutes_rubriques"]
		) {
		  // on voit le bouton dans la barre "naviguer"
			$boutons_admin['configuration']->sousmenu['eva_install']= new Bouton(
			"../"._DIR_PLUGIN_EVAINSTALL."/img_pack/install.png",  // icone
			_T('evainstall:EVA_install')	// titre
			);
		}
		return $boutons_admin;

	}

?>
