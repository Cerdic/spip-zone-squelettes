<?php
$p=explode(basename(_DIR_PLUGINS)."/",str_replace('\\','/',realpath(dirname(__FILE__))));
define('_DIR_PLUGIN_EVAMENTIONS',(_DIR_PLUGINS.end($p)));

	function eva_mentions_AjouterBoutons($boutons_admin) {
		// si on est admin
		if ($GLOBALS['connect_statut'] == "0minirezo" && $GLOBALS["connect_toutes_rubriques"]
		AND $GLOBALS["options"]=="avancees") {
		  // on voit le bouton dans la barre "naviguer"
			$boutons_admin['configuration']->sousmenu['eva_mentions']= new Bouton(
			"../"._DIR_PLUGIN_EVAMENTIONS."/img_pack/install.png",  // icone
			_T('evamentions:EVA_mentions')	// titre
			);
		}
		return $boutons_admin;

	}

?>
