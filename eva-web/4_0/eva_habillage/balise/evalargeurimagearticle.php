<?php
function balise_EVALARGEURIMAGEARTICLE($p) {
	$test=sql_select('nom_image','spip_eva_habillage_images',"type='logos' AND nom_habillage='Defaut' AND nom_div='largeur_image_article'");
	$tab=sql_fetch($test);
	$envoi=$tab['nom_image'];
	if ((!$envoi) AND ($envoi!='0')) {$envoi='0';}
	$p->code = "'".$envoi."'";
	$p->interdire_scripts = false;
	return $p;
}
?>