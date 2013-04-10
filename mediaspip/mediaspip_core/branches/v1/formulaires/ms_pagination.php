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
 * Formulaire dynamique #FORMULAIRE_MS_PAGINATION
 *
 * Passe au préalable par balises/formulaire_ms_pagination
 */

/**
 * Chargement des valeurs par defaut des champs du formulaire
 * - On récupère le nom de la boucle parente
 * - On récupère le nombre d'éléments de la pagination actuel si présent dans l'url
 *
 * @param string $boucle : le nom de la boucle parente depuis le fichier de balise appelé précédemment
 * @param int $total_elements : le nombre total de résultats possibles permettant de moduler le nombre maximal
 * @param string $ancre : Une ancre sur laquelle la redirection pointe par la suite
 * @param string $type : select|libre le type de formulaire select par défaut, affiche dans un select une liste de valeurs
 * @param int $pas : Le pas entre les valeurs possibles
 * @param int $min : Le nombre minimal possible
 * @param int $max : Le nombre maximal possible de la pagination
 */
function formulaires_ms_pagination_charger_dist($boucle,$total_elements='',$ancre='',$type='select',$pas='5',$min='1',$max='30',$afficher_tout = false){
	$lien = self();
	$pagination_actuel = _request('pagination'.$boucle) ? _request('pagination'.$boucle) : $pas;
	$max_new = (floor($total_elements/$pas) * $pas);
	if(($total_elements > 0) && ($total_elements < $max)){
		$afficher_tout = true;
	}
	return
		array(
			'action' => $lien,
			'defaut' => $pagination_actuel,
			'type_form' => $type,
			'pas' => $pas,
			'min' => $min,
			'max' => $max_new,
			'nom' => 'champ_pagination'.$boucle,
			'total' => $total_elements,
			'afficher_tout' => $afficher_tout
		);
}

/**
 * Traitement du formulaire
 *
 * Redirige vers une page ayant dans l'environnement les paramètres nécessaires pour gérer la pagination
 *
 * @param string $boucle : le nom de la boucle parente depuis le fichier de balise appelé précédemment
 * @param int $total_elements : le nombre total de résultats possibles permettant de moduler le nombre maximal
 * @param string $ancre : Une ancre sur laquelle la redirection pointe par la suite
 * @param string $type : select|libre le type de formulaire select par défaut, affiche dans un select une liste de valeurs
 * @param int $pas : Le pas entre les valeurs possibles
 * @param int $min : Le nombre minimal possible
 * @param int $max : Le nombre maximal possible de la pagination
 */
function formulaires_ms_pagination_traiter_dist($boucle,$total_elements='',$ancre='',$type='select',$pas='5',$min='1',$max='30'){
	$lien = self();
	$valeur = _request('champ_pagination'.$boucle);
	$lien_retour = parametre_url(parametre_url($lien,'pagination'.$boucle,$valeur),'debut'.$boucle,'');
	$res['redirect'] = $lien_retour.($ancre ? '#'.$ancre : '');
	return $res;
}

?>