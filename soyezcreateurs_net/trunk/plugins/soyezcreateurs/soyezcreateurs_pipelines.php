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

function soyezcreateurs_formulaire_traiter($flux){
	if(strpos($flux['args']['form'], 'configurer_soyezcreateurs') !== false){
		include_spip('inc/invalideur');
		purger_repertoire(_DIR_VAR.'cache-css');
		purger_repertoire(_DIR_VAR.'cache-js');
		suivre_invalideur('configurer_soyezcreateurs');
	}
	return $flux;
}

function soyezcreateurs_noizetier_blocs_defaut($flux) {
	$flux = array('contenu');
	return $flux;
}

function soyezcreateurs_identite_extra_champs($champs) {
	define('_CHAMPS_INDENTITE_EXTRA_SC', 'adresse,code_postal,ville,pays,telephone,fax,email_contact,informations,id_article_contact,facebook,twitter,linkedin,instagram,pinterest,viadeo,latitude,longitude');
	$champs = explode(',', _CHAMPS_INDENTITE_EXTRA_SC);
	return $champs;
}