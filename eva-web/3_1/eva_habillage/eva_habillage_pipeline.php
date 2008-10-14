<?php
/******************************************************************
***  Ce plugin EVA_habillage, crיי par Olivier Gautier, est mis ***
***      א disposition sous un contrat Creative Commons BY      *** 
***                 consultable א l'adresse                     ***
***      http://www.creativecommons.org/licenses/by/2.0/fr/     ***
******************************************************************/
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

?>