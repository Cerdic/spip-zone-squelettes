<?php

function SoyezCreateurs_ajouterOnglets($flux) {
  if($flux['args']=='configuration')
	$flux['data']['soyez_createurs']= new Bouton(
											  find_in_path('soyezcreateurs.png'), 'Param&egrave;tres SoyezCreateurs',
											  generer_url_ecrire('cfg','cfg=soyezcreateurs'));
  return $flux;
}

?>
