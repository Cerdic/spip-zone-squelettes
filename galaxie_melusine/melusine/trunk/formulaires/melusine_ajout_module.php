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

	return $erreurs;
	
}

/**
 * Traitement du formulaire d'ajout de modules
 *
 * @uses formulaires_editer_objet_traiter()
 *
 * @param string $bloc
 *     nom du bloc à remplir
 * @param string $type
 *     type de page du bloc à remplir
 * @return array
 *     retour des traitements
 */
function formulaires_melusine_ajout_module_traiter_dist($bloc,$type="rubrique"){
	// Pas d'ajax...
	refuser_traiter_formulaire_ajax();

	$nom_module = _request("nom_module");

	// On cherche une place libre dans le casier
	// et on y met le module
	// Infos de la noisette:
	include_spip('base/abstract_sql');
	// infos sur le module le plus bas
	// dans le bloc
	$infos_module_bas= sql_fetsel(
		array(
			"rang",
			),
		"spip_noisettes",
		"bloc = ".sql_quote($bloc)." AND type = ".sql_quote($type),
		"",
		"rang DESC"
		);
	// Pas de place...
	if ($infos_module_bas['rang'] > 11) 
		return array('message_erreur' => "Plus de place dans ce bloc&nbsp;! Vous devez d'abord retirer un module...");
	

	// On met le module dans la base:
	include_spip('action/editer_objet');
	$set = array(
		"rang" => $infos_module_bas['rang']+1,
		"type" => $type,
		"bloc" => $bloc,
		"noisette" => $nom_module
	);
	$id_noisette = objet_inserer("noisette", $id_parent="",$set);
	if (!$id_noisette)
		return array("message_erreur" => "Impossible d'insérer le module ".$nom_module." dans le bloc ".$bloc." de la page ".$type. "au rang ".$rang);

		
	// On invalide le cache
	include_spip('inc/invalideur');
	suivre_invalideur(1);

	$retour = array(
		"message_ok" => "module &laquo;&nbsp;$nom_module&nbsp;&raquo; inséré",
		"editable" => false,
		"id_noisette" => $id_noisette
		);

	return $retour;
}
?>