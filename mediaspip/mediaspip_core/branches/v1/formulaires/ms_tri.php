<?php
/**
 * Plugin Mediaspip Core
 * 
 * © 2010-2011 kent1 (kent1@arscenic.info)
 * Distribué sous licence GNU/GPL v3
 * 
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
function formulaires_ms_tri_charger_dist($boucle,$defaut='',$ancre=''){
	$tri_actuel = _request('tri'.$boucle) ? _request('tri'.$boucle) : $defaut;
	$page = _request('page');
	return
		array(
			'action' => self(),
			'defaut' => $tri_actuel,
			'nom' => 'champ_tri'.$boucle,
			'boucle' => $boucle,
			'page_en_cours' => $page
		);
}

function formulaires_ms_tri_traiter_dist($boucle,$defaut='',$ancre=''){
	$lien = self();
	$valeur = _request('champ_tri'.$boucle);
	$lien_retour = parametre_url($lien,'tri'.$boucle,$valeur);
	$res['redirect'] = $lien_retour.($ancre ? '#'.$ancre : '');
	return $res;
}

?>