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
	$champs = explode(',', _CHAMPS_INDENTITE_EXTRA_SC);
	$champs[] = 'facebook';
	$champs[] = 'twitter';
	$champs[] = 'linkedin';
	$champs[] = 'instagram';
	$champs[] = 'pinterest';
	$champs[] = 'viadeo';
	return $champs;
}

function sc_extension($fichier){ 
    //Si je trouve un point vers la fin du nom de fichier, je renvoie ce qui suit 
    if (preg_match(',\.([^\.]+)$,', $fichier, $regs)) 
        return $regs[1]; 
    //Sinon, je ne renvoie rien, il n'y a pas d'extension. 
    return ''; 
} 


/*
  S'il y a un Cookie de lang ({lang}, on va chercher une image :
  - de même extension que le logo du site ({extention})
  - dans le dossier images/logo/
  - portant le nom site_{lang}.{extension}
*/
function soyezcreateurs_quete_logo_objet($flux) {
	if (
		isset($_COOKIE['spip_lang'])
		and !empty($flux['data'])
		and $flux['args']['objet'] === 'site'
		and intval($flux['args']['id_objet']) === 0
		and $flux['args']['mode'] !== 'off'
	) {
		$lang = $_COOKIE['spip_lang'];
		$extension = sc_extension($flux['data']['chemin']);
		if ($image = find_in_path('images/logo/site_'. $lang . '.'. $extension)) {
			$flux['data'] = array(
				'chemin'    => $image,
				'timestamp' => @filemtime($image),
			);
		}
	}
	
	return $flux;
}
