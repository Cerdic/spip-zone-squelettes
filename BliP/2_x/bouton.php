<?php
function BlipConfig_ajouterBouton($boutons_admin) {
	// si on est admin
	if ($GLOBALS['connect_statut'] == "0minirezo") {
    // on voit le bouton dans la barre "naviguer"
	    $boutons_admin['configuration']->sousmenu['BlipConfig_config']= new Bouton(
		    '../'._DIR_PLUGINS.'blipconfig/ecrire/img_pack/blipconfig-24.gif', _T('configure_blip'));
	}
	return $boutons_admin;
}
?>
