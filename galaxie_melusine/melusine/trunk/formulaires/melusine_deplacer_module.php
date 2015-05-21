<?php
/**
 * Gestion du formulaire de déplacement des modules de Mélusine
 *
 * @plugin     Mélusine
 * @copyright  2014
 * @author     Bertrand Marne
 * @licence    GNU/GPL
 * @package    SPIP\melusine\Formulaires
 */

if (!defined('_ECRIRE_INC_VERSION')) return;


/**
 * Chargement du formulaire de déplacement des modules
 *
 * @uses formulaires_editer_objet_charger()
 *
 * @param int|string $id_noisette
 *
 * @return array
 *     Environnement du formulaire
 */
function formulaires_melusine_deplacer_module_charger_dist($id_noisette){

	$valeurs = array(
		"id_noisette" => $id_noisette
	);

	return $valeurs;

}

/**
 * Vérification du formulaire de déplacement des modules
 *
 * @uses formulaires_editer_objet_verifier()
 *
 * @param int|string $id_noisette
 *
 * @return array
 *     Tableau des erreurs
 */
function formulaires_melusine_deplacer_module_verifier_dist($id_noisette){
	$erreurs = array();

	if (!$id_noisette)
		$erreurs["message_erreur"] = "le module n'a pas été correctement défini";

	$action = _request("deplacement");

	if ($action != "descendre"
	AND $action != "monter"
	AND $action != "supprimer")
		$erreurs["message_erreur"] = "l'action n'a pas été correctement définie";

	return $erreurs;
	
}

/**
 * Traitement du formulaire de déplacement des modules
 *
 * @uses formulaires_editer_objet_traiter()
 *
 * @param int|string $id_noisette
 *
 * @return array
 *     retour des traitements
 */
function formulaires_melusine_deplacer_module_traiter_dist($id_noisette){
	$retour = array();

	// Il vaut mieux éviter l'ajax et
	// recharger toute la page
	refuser_traiter_formulaire_ajax();

	// On récupère l'action à faire
	$action=_request('deplacement');

	// Infos de la noisette:
	include_spip('base/abstract_sql');
	$infos_module= sql_fetsel(
		array(
			"rang",
			"type",
			"bloc",
			"noisette"
			),
		"spip_noisettes",
		"id_noisette=".intval($id_noisette)
		);

	// On récupère la position
	$rang=intval($infos_module['rang']);


	include_spip('action/editer_objet');


	// descendre d'une rangée
	// 12 rangées maxi
	if($action=="descendre" && $rang<11 ){
		// On regarde si on a un module en dessous
		$infos_module_suivant= sql_fetsel(
		array(
			"rang",
			"type",
			"bloc",
			"noisette",
			"id_noisette"
			),
		"spip_noisettes",
		"type = '".$infos_module['type'].
		"' AND bloc = '".$infos_module['bloc'].
		"' AND rang > ".$rang,
		"",//groupby (inutile)
		"rang ASC" //orderby
		);
		if ($infos_module_suivant) {
			// si oui, on intervertit les rangs
			$retour["message_erreur"] = $retour["message_erreur"].objet_modifier("noisette",$id_noisette, array("rang" => $infos_module_suivant["rang"]));
			$retour["message_erreur"] = $retour["message_erreur"].objet_modifier("noisette",$infos_module_suivant["id_noisette"], array("rang" => $rang));
		} else {
			// si non, on incrémente le rang
			$retour["message_erreur"] = $retour["message_erreur"].objet_modifier("noisette",$id_noisette, array("rang" => $rang+1));
		}
	}

	// monter d'une rangée
	if($action=="monter" && $rang>1 ){
		// On regarde si on a un module au dessus
		$infos_module_precedent= sql_fetsel(
		array(
			"rang",
			"type",
			"bloc",
			"noisette",
			"id_noisette"
			),
		"spip_noisettes",
		"type = '".$infos_module['type'].
		"' AND bloc = '".$infos_module['bloc'].
		"' AND rang < ".$rang,
		"",//groupby (inutile)
		"rang DESC" //orderby
		);
		if ($infos_module_precedent) {
			// si oui, on intervertit les rangs
			$retour["message_erreur"] = $retour["message_erreur"].objet_modifier("noisette",$id_noisette, array("rang" => $infos_module_precedent["rang"]));
			$retour["message_erreur"] = $retour["message_erreur"].objet_modifier("noisette",$infos_module_precedent["id_noisette"], array("rang" => $rang));
		} else {
			// si non, on décrémente le rang
			$retour["message_erreur"] = $retour["message_erreur"].objet_modifier("noisette",$id_noisette, array("rang" => $rang-1));
		}
	}

	// Supprimer le contenu de la rangée
	if($action=="supprimer"){
		$result = sql_delete("spip_noisettes","id_noisette =".intval($id_noisette));
		if ($result === false)
			return $retour['message_erreur'] = "Échec lors de la suppression du module...";
		// Il faut boucher le trou si la suppression a créé un trou
		$infos_modules_suivants = sql_allfetsel(
			array(
				"rang",
				"id_noisette"
			),
			"spip_noisettes",
			"type = '".$infos_module['type'].
			"' AND bloc = '".$infos_module['bloc'].
			"' AND rang > ".$rang
		);
		foreach($infos_modules_suivants as $info_module_suivant) {
			$retour["message_erreur"] = $retour["message_erreur"].objet_modifier("noisette",$info_module_suivant['id_noisette'], array("rang" => $info_module_suivant['rang']-1));
		}
		
	}

		
	// On invalide le cache
	include_spip('inc/invalideur');
	suivre_invalideur(1);

	/*if (count($retour) < 1)
		$retour = array(
			'message_ok'=>'Saisie enregistr&eacute;e',
			'id_noisette' => $id_noisette
		);*/

	return $retour;
	
}
?>