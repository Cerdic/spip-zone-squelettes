<?php
/**
 * Plugin Mediaspip Core
 * Formulaire de changement de tri des listes de medias
 *
 * © 2010-2015 - Distribue sous licence GNU/GPL
 * @author kent1 <kent1@arscenic.info>
 */
if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * Formulaire dynamique #FORMULAIRE_MS_TRI
 *
 * Passe au préalable par balises/formulaire_ms_tri
 */

/**
 * Chargement des valeurs par defaut des champs du formulaire
 * - On récupère le nom de la boucle parente
 * - On récupère l'ordre de tri actuel si présent dans l'environnement
 *
 * @param string $boucle
 * @param string $defaut : le critère par défaut si rien dans l'environnement
 * @param string $ancre : l'ancre sur laquelle on pointe ensuite
 */
function formulaires_ms_tri_charger_dist($boucle,$defaut='',$ancre='',$recharger=false){
	$tri_actuel = _request('tri'.$boucle) ? _request('tri'.$boucle) : $defaut;
	$exclus = lire_config('mediaspip/recherche/liste_criteres_exclus_tri',array());
	$page = _request('page');
	return
		array(
			'action' => self(),
			'defaut' => $tri_actuel,
			'exclus' => $exclus,
			'nom' => 'champ_tri'.$boucle,
			'boucle' => $boucle,
			'page_en_cours' => $page
		);
}

function formulaires_ms_tri_traiter_dist($boucle,$defaut='',$ancre='',$recharger=false){
	$lien = self();
	$valeur = _request('champ_tri'.$boucle);
	$lien_retour = parametre_url($lien,'tri'.$boucle,$valeur);
	if($recharger){
		$res['message_ok'] = '<script type="text/javascript">if (window.jQuery) jQuery("'.$recharger.'").ajaxReload({args:{tri'.$boucle.':"'.$valeur.'"},history:true});</script>';
		set_request('tri'.$boucle,$valeur);
	}else{
		$res['redirect'] = $lien_retour.($ancre ? '#'.$ancre : '');
	}
	return $res;
}

?>