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
 * @param int|string $nom_module
 *     nom du fichier du module
 * @param int|string $position_module
 *     position du module
 * @param int|string $casier
 *     emplacement de la description du bloc dans les metas de SPIP
	(ex. melusine_sommaire/x/)
 * @param int $env
 *     environnement du module
 * @return array
 *     Environnement du formulaire
 */
function formulaires_melusine_deplacer_module_charger_dist($nom_module="aucun", $position_module=0, $casier="", $env=array()){

	$valeurs = array(
		"nom_module" => $nom_module,
		"position_module" => $position_module,
		"casier" => $casier,
		"environnement" => $env
	);

	return $valeurs;

}

/**
 * Vérification du formulaire de déplacement des modules
 *
 * @uses formulaires_editer_objet_verifier()
 *
 * @param int|string $nom_module
 *     nom du fichier du module
 * @param int|string $position_module
 *     position du module
 * @param int|string $casier
 *     emplacement de la description du bloc dans les metas de SPIP
	(ex. melusine_sommaire/x/)
 * @param int $env
 *     environnement du module
 * @return array
 *     Tableau des erreurs
 */
function formulaires_melusine_deplacer_module_verifier_dist($nom_module="aucun", $position_module=0, $casier="", $env=array()){
	$erreurs = array();

	if (!$casier OR !lire_config($casier))
		$erreurs["message_erreur"] = "le bloc n'a pas été correctement défini";

	$action = _request("deplacement");

	if ($action != "descendre"
	AND $action != "monter"
	AND $action("action") != "supprimer")
		$erreurs["message_erreur"] = "l'action n'a pas été correctement définie";

	return $erreurs;
	
}

/**
 * Traitement du formulaire de déplacement des modules
 *
 * @uses formulaires_editer_objet_traiter()
 *
 * @param int|string $nom_module
 *     nom du fichier du module
 * @param int|string $position_module
 *     position du module
 * @param int|string $casier
 *     emplacement de la description du bloc dans les metas de SPIP
	(ex. melusine_sommaire/x/)
 * @param int $env
 *     environnement du module
 * @return array
 *     retour des traitements
 */
function formulaires_melusine_deplacer_module_traiter_dist($nom_module="aucun", $position_module=0, $casier="", $env=array()){

	// Il vaut mieux éviter l'ajax et
	// recharger toute la page
	refuser_traiter_formulaire_ajax();

	// On récupère l'action à faire
	$action=_request('deplacement');

	// On récupère la position
	$var=$position_module;


	include_spip('inc/config');

	// descendre d'une rangée
	// 12 rangées maxi
	if($action=="descendre" && $var<11 ){
		$varplus=$var+1;
		$chemin=$casier.$var;
		$chemin_bas=$casier.$varplus;
		$pos=lire_config($chemin);
		$pos_bas=lire_config($chemin_bas);
		ecrire_config($chemin_bas, $pos);
		ecrire_config($chemin,$pos_bas);				
	}

	// monter d'une rangée
	if($action=="monter" && $var>1 ){
		$varmoins=$var-1;
		$chemin=$casier.$var;
		$chemin_haut=$casier.$varmoins;
		$pos=lire_config($chemin);
		$pos_haut=lire_config($chemin_haut);
		ecrire_config($chemin_haut, $pos);
		ecrire_config($chemin,$pos_haut);		
	}

	// Supprimer le contenu de la rangée
	if($action=="supprimer"){
		$chemin=$casier.$var;
		ecrire_config($chemin,'aucun');
		// On utilise que el derbier param qui définit le casier
		// TODO changer l'arité de cette fonction quand
		// les zones ne seront plus utilisées
		melusine_rassembler($var,"","",$casier);
	}

		
	// On invalide le cache
	include_spip('inc/invalideur');
	suivre_invalideur(1);


	return array('message_ok'=>'enregistré');
	
}
?>