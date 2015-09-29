<?php
/*
* Pipeline pour SoyezCreateurs
* Realisation : RealET : real3t@gmail.com
* Attention, fichier en UTF-8 sans BOM
*/

if (!defined('_ECRIRE_INC_VERSION')) return;

function soyezcreateurs_jqueryui_plugins($scripts) {
	if (lire_config('soyezcreateurs/native_tooltips') !== 'on') {
		$scripts[] = "jquery.ui.tooltip";
	}
	return $scripts;
}