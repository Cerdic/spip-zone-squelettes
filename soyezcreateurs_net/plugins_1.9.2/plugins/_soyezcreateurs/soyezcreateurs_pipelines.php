<?php

// Ajoute le bouton d'amin aux webmestres

if (!defined("_ECRIRE_INC_VERSION")) return;
function SoyezCreateurs_ajouter_onglets($flux) {
	if($flux['args']=='configuration'
	AND autoriser('webmestre')) {
		// on voit le bouton dans la barre "configurer"
		$flux['data']['cfg_soyezcreateurs']= 
			new Bouton(
			'../'._DIR_PLUGIN_SOYEZCREATEURS.'/img_pack/soyezcreateurs.png', // icone
			'SoyezCreateurs',	// titre
			generer_url_ecrire('cfg','cfg=soyezcreateurs'),
			NULL,
			'cfg_soyezcreateurs'
			);
	}
 	return $flux;
}

?>
