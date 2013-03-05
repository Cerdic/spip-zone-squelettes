<?php
/**
 * Formulaire #FORMULAIRE_CONFIGURER_LOCUTEUR
 * Configure les langues disponibles sur le site
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * Fonction de chargement des valeurs du formulaire
 */
function formulaires_configurer_locuteur_charger_dist(){
	/**
	 * Vérification si la configuration du site actuelle
	 * permet bien de choisir des langues
	 */
	if ($GLOBALS['meta']['multi_articles'] != "oui"
		&& $GLOBALS['meta']['multi_rubriques'] != "oui"
		&& count(explode(',',$GLOBALS['meta']['langues_utilisees'])) < 2) {
			$valeurs['editable'] = false;
			return $valeurs;
	}

	include_spip('inc/lang_liste');
	/**
	 * L'ensemble des langues
	 * @var array $langues
	 */
	$langues = $GLOBALS['codes_langues'];

	/**
	 * Les langues installées
	 * @var array $langues_installees
	 */
	$langues_installees = explode(',', $GLOBALS['meta']['langues_proposees']);
	$langues_autorisees = explode(',', $GLOBALS['meta']['langues_multilingue']);
	
	while (list(,$l) = each ($langues_installees)) {
		$langues_trad[$l] = $langues[$l];
	}

	$langues_auth = array();
	while (list(,$l) = each ($langues_autorisees)) {
		if($langues[$l])
			$langues_auth[$l] = $langues[$l];
	}

	$l_bloquees_tmp = explode(',',$GLOBALS['meta']['langues_utilisees']);
	while (list(,$l) = each($l_bloquees_tmp)) {
		$langues_bloquees[$l] = $langues[$l];
		unset($langues[$l]);
	}
	$valeurs['langue_site'] = $GLOBALS['meta']['langue_site'];
	$valeurs['_bloquees'] = $langues_bloquees;
	$valeurs['_trad'] = $langues_trad;
	if(count($langues_auth) > 1)
		$valeurs['_auth'] = $langues_auth;
	else 
		$valeurs['_auth'] = array();
	$valeurs['_langues'] = $langues;
	return $valeurs;
}

function formulaires_configurer_locuteur_traiter_dist(){
	include_spip('inc/config');
	appliquer_modifs_config();
	
	$langues_autorisees = explode(',', $GLOBALS['meta']['langues_multilingue']);
	if(_request('changer_langue_site') && !in_array(_request('changer_langue_site'),$langues_autorisees)){
		ecrire_meta("langue_site",$langues_autorisees[0]);
	}
	
	include_spip('inc/invalideur');
	suivre_invalideur(1);
	
	$res['message_ok'] = _T('mediaspip_config:message_config_lang_ok');
	
	return $res;
}
?>