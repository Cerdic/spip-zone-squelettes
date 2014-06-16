<?php
/**
 * Gestion du formulaire d'uniformisation d'un bloc de Mélusine
 * (le bloc est rendu homogène sur les types de pages choisies)
 *
 * @plugin     Mélusine
 * @copyright  2014
 * @author     Bertrand Marne
 * @licence    GNU/GPL
 * @package    SPIP\melusine\Formulaires
 */

if (!defined('_ECRIRE_INC_VERSION')) return;

/**
 * Chargement du formulaire d'uniformisation
 *
 * @uses formulaires_editer_objet_charger()
 *
 * @param string $bloc
 *     nom du bloc à uniformiser
 * @param string $type
 *     type de page du bloc à uniformiser
 * @return array
 *     Environnement du formulaire
 */
function formulaires_melusine_uniformiser_bloc_charger_dist($bloc,$type="rubrique"){

	$valeurs = array(
		"bloc" => $bloc,
		"type" => $type,
		"tableau_types" => $GLOBALS['types_gabarits_melusine']
	);
	return $valeurs;

}

/**
 * Vérification du formulaire d'uniformisation
 *
 * @uses formulaires_editer_objet_verifier()
 *
 * @param string $bloc
 *     nom du bloc à uniformiser
 * @param string $type
 *     type de page du bloc à uniformiser
 * @return array
 *     Tableau des erreurs
 */
function formulaires_melusine_uniformiser_bloc_verifier_dist($bloc,$type="rubrique"){
	$erreurs = array();

	return $erreurs;
	
}

/**
 * Traitement du formulaire d'uniformisation
 *
 * @uses formulaires_editer_objet_traiter()
 *
 * @param string $bloc
 *     nom du bloc à uniformiser
 * @param string $type
 *     type de page du bloc à uniformiser
 * @return array
 *     retour des traitements
 */
function formulaires_melusine_uniformiser_bloc_traiter_dist($bloc,$type="rubrique"){
	// Pas d'ajax...
	// refuser_traiter_formulaire_ajax();

	$gabarits = _request("gabarits");
	$liste_pages = array();

	// On fait la liste des pages concernées
	foreach($gabarits as $gabarit)
		$liste_pages = array_merge($liste_pages,melusine_pages_du_gabarit($gabarit));


	// on récupère les blocs du gabarit à uniformiser
	$infos_modules_bloc= sql_allfetsel(
		array(
			"id_noisette",
			"rang",
			"bloc",
			"noisette",
			"parametres",
			"css",
			),
		"spip_noisettes",
		"bloc REGEXP '^".$bloc."' AND type = ".sql_quote($type)
		);
	// Pour chaque page,
	// - On vide les noisettes existantes
	// - On remplace par les noisettes à uniformiser
	include_spip('base/abstract_sql');
	include_spip('action/editer_objet');
	foreach($liste_pages as $page) {
		//On efface les modules du bloc pour cette page
		$result = sql_delete(
				"spip_noisettes",
				"bloc=".sql_quote($bloc)." AND type=".sql_quote($page)
			);
		if ($result === false)
			return array("message_erreur" => "Échec lors de la vidange du bloc $bloc de la page $type...");
		// on crée une copie pour chaque page des gabarits selectionnés
		foreach($infos_modules_bloc as $noisette_a_copier) {
			$noisette_a_copier['type'] = $page;
			unset($noisette_a_copier['id_noisette']);
			$id_noisette = objet_inserer("noisette", $id_parent="",$noisette_a_copier);
			if (!$id_noisette)
				return array("message_erreur" => "Impossible d'insérer le module ".$noisette_a_copier['nom']." dans le bloc ".$bloc." de la page ".$page. "au rang ".$noisette_a_copier['rang']);
		}
		
	}

	return array(
		"message_ok" => "Uniformisation du bloc réussie",
		"editable" => false
		);
}
?>