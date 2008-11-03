<?php
function balise_EVALOGOMOYENLARGEUR($p) {
	$test=sql_select('nom_image','spip_eva_habillage_images',"type='logos' AND nom_habillage='Defaut' AND nom_div='largeur_logo_moyen'");
	$tab=sql_fetch($test);
	$envoi=$tab['nom_image'];
	if ((!$envoi) AND ($envoi!='0')) {$envoi=140;}
	$p->code = "'".$envoi."'";
	$p->interdire_scripts = false;
	return $p;
}
?>