<?php
/**
 * Gestion du formulaire d'ajout de module dans un bloc de Mélusine
 *
 * @plugin     Mélusine
 * @copyright  2014
 * @author     Bertrand Marne
 * @licence    GNU/GPL
 * @package    SPIP\melusine\Formulaires
 */

if (!defined('_ECRIRE_INC_VERSION')) return;


/**
 * Chargement du formulaire d'ajout de modules
 *
 * @uses formulaires_editer_objet_charger()
 *
 * @param string $bloc
 *     nom du bloc à remplir
 * @param string $type
 *     type de page du bloc à remplir
 * @return array
 *     Environnement du formulaire
 */
function formulaires_melusine_ajout_module_charger_dist($bloc,$type="rubrique"){

	$valeurs = array(
		"bloc" => $bloc,
		"type" => $type
	);

	return $valeurs;

}

/**
 * Vérification du formulaire d'ajout de modules
 *
 * @uses formulaires_editer_objet_verifier()
 *
 * @param string $bloc
 *     nom du bloc à remplir
 * @param string $type
 *     type de page du bloc à remplir
 * @return array
 *     Tableau des erreurs
 */
function formulaires_melusine_ajout_module_verifier_dist($bloc,$type="rubrique"){
	$erreurs = array();

	if (!$casier OR !lire_config($casier))
		$erreurs["message_erreur"] = "le bloc n'a pas été correctement défini";

	return $erreurs;
	
}

/**
 * Traitement du formulaire d'ajout de modules
 *
 * @uses formulaires_editer_objet_traiter()
 *
 * @param int|string $casier
 *     nom du casier correspondant au bloc dans lequel on veut ajouter un module
 * @param int|string $casiers_page
 *     liste des casiers de la page
 * @param int|string $reserve
 *     casier contenant la réserve de modules dédiée à la page
 *	(par défaut c'est "squelettes")
 * @return array
 *     retour des traitements
 */
function formulaires_melusine_ajout_module_traiter_dist($casier="", $casiers_page="", $reserve="squelettes"){

	$nom_module = _request("nom_module");

	// On cherche une place libre dans le casier
	// et on y met le module
	$j=1;
	while($valeur!='aucun'){
		$chemin=$casier.$j;
		$valeur=lire_config($chemin);
		$j++;
	}
	if($j<11){
		ecrire_config($chemin,$nom_module);
		return array('message_ok'=>'enregistré');
	} else {
		return array("message_erreur" => "Plus de place dans ce bloc&nbsp;! Vous devez d'abord retirer un module...");
		
	}
	
}
?>