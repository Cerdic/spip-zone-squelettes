<?php
function balise_EVAMENULANGUE($p) {
	$test=sql_select('nom_image','spip_eva_habillage_images',"type='multilinguisme' AND nom_habillage='Defaut' AND nom_div='menu_langue_actif'");
	$tab=sql_fetch($test);
	$envoi=$tab['nom_image'];
	$p->code = "'".$envoi."'";
	$p->interdire_scripts = false;
	return $p;
}
?>