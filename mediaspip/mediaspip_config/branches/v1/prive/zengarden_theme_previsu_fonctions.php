<?php 

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/zengarden');
include_spip('inc/headers');

function theme_previsu(){
	return $_COOKIE['spip_zengarden_theme'];
}

function zengarden_liste_themes_apercu($tous){
	return zengarden_charge_themes(_DIR_THEMES,$tous);
}
?>