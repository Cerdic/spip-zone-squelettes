<?php
function balise_EVALOGOPETITHAUTEUR($p) {
	$test=sql_select('nom_image','spip_eva_habillage_images',"type='logos' AND nom_habillage='Defaut' AND nom_div='hauteur_petit_logo'");
	$tab=sql_fetch($test);
	$envoi=$tab['nom_image'];
	if ((!$envoi) AND ($envoi!='0')) {$envoi=60;}
	$p->code = "'".$envoi."'";
	$p->interdire_scripts = false;
	return $p;
}
?>