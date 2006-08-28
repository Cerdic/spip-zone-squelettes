<?php
function BliP_ajouterBouton($boutons_admin) {
	// si on est admin
	if ($GLOBALS['connect_statut'] == "0minirezo") {
    // on voit le bouton dans la barre "naviguer"
	    $boutons_admin['configuration']->sousmenu['blip']= new Bouton(
		    '../'._DIR_PLUGINS.'blip/ecrire/img_pack/blipconfig-24.gif', _T('Configurer BliP'));
	}
	return $boutons_admin;
}

function BliP_ajouterOnglets($flux) {
  if($flux['args']=='blip')
	{
	$flux['data']['voir']= new Bouton(null, 'Voir la configuration',
											  generer_url_ecrire("blip"));
	$flux['data']['modifier']= new Bouton(null, 'Modifier la configuration',
											  generer_url_ecrire("blip_modifier","action=creer"));
	$flux['data']['effacer']= new Bouton(null, 'Supprimer BliP',
											  generer_url_ecrire("blip_effacer"));
	}
	return $flux;
}

?>
