<?php

if (!defined('_ECRIRE_INC_VERSION')) return;

/**
 * chargement des valeurs par defaut des champs du #FORMULAIRE_RECHERCHE
 * on peut lui passer l'url de destination en premier argument
 * on peut passer une deuxième chaine qui va différencier le formulaire pour pouvoir en utiliser plusieurs sur une même page
 * Pour Plugins SPIP on passe systématiquement la compatibilité SPIP.
 *
 * @param string $lien URL où amène le formulaire validé
 * @param string $class Une class différenciant le formulaire
 * @return array
 */
function formulaires_recherche_charger_dist($lien = '', $class=''){
	if ($GLOBALS['spip_lang'] != $GLOBALS['meta']['langue_site'])
		$lang = $GLOBALS['spip_lang'];
	else
		$lang='';

	$action = ($lien ? $lien : generer_url_public('recherche')); # action specifique, ne passe pas par Verifier, ni Traiter
	return 
		array(
			'action' => $action,
			'recherche' => _request('recherche'),
			'compatible_spip' => _request('compatible_spip'),
			'lang' => $lang,
			'class' => $class,
			'_id_champ' => $class ? substr(md5($action.$class),0,4) : 'recherche'
		);
}

?>
