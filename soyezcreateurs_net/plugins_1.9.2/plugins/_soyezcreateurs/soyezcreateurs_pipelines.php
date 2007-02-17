<?php

function SoyezCreateurs_ajouterOnglets($flux) {
  if($flux['args']=='configuration')
	$flux['data']['soyez_createurs']= new Bouton(
											  '../'._DIR_PLUGIN_SOYEZCREATEURS.'/img_pack/soyezcreateurs.png', 'Param&egrave;tres SoyezCreateurs',
											  generer_url_ecrire('cfg','cfg=soyezcreateurs'));
  return $flux;
}

?>
