<?php
	function orion_ajouter_boutons($boutons_admin) {
		// si on est admin
		if ($GLOBALS['connect_statut'] == "0minirezo") {
		  // on voit le bouton comme  sous-menu de "naviguer"
			$boutons_admin['naviguer']->sousmenu['cfg&cfg=orion']= new Bouton("plugin-24.gif", _T('configuration web-paroisse') );
		}
		return $boutons_admin;
	}
	
?>
