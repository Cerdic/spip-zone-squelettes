<?php
	function durzy_ajouter_boutons($boutons_admin) {
		// si on est admin
		if ($GLOBALS['connect_statut'] == "0minirezo") {
		  // on voit le bouton comme  sous-menu de "naviguer"
			$boutons_admin['configuration']->sousmenu['cfg&cfg=durzy']= new Bouton("plugin-24.gif", _T('Configuration Durzy') );
		}
		return $boutons_admin;
	}
	
?>
