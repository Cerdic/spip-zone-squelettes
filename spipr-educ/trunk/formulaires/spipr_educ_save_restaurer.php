<?php
if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_spipr_educ_save_restaurer_charger_dist() {
	// On va tout d'abord tester si des sauvegardes son présentes, si ce n'est pas le cas, on marque la variable sauvegarde_presente pour ne rien afficher
	$valeurs['sauvegarde_presente']='non';
	$test_save=sql_select('nom_sauvegarde','spip_spipr_educ',"type='theme'");
	while ($tab_save = sql_fetch($test_save)){
		if ($tab_save['nom_sauvegarde']!='en_cours_d_utilisation_SPIPr') $valeurs['sauvegarde_presente']='oui';
	}
	return $valeurs;
}

function formulaires_spipr_educ_save_restaurer_traiter_dist() {
	$res = array('editable'=>true);
	// Cas de la suppression
	if (_request('hidden_confirme_supp')!='') {
		$test_supprimer=sql_select('nom_sauvegarde','spip_spipr_educ',"id='"._request('hidden_confirme_supp')."'");
		$tab_supprimer=sql_fetch($test_supprimer);
		sql_delete('spip_spipr_educ', "nom_sauvegarde = '". $tab_supprimer['nom_sauvegarde']."'");
		$res['message_ok'] = "La sauvegarde <b>".$tab_supprimer['nom_sauvegarde']."</b> a été supprimée.";
		// S'il ne reste plus de sauvegarde, ne pas afficher le bloc
		$test_restant=sql_select('id','spip_spipr_educ',"type='theme' AND nom_sauvegarde!='en_cours_d_utilisation_SPIPr'");
		while ($tab_restant = sql_fetch($test_restant)){
			$res['sauvegarde_presente']='non';
		}
	}
	// Cas de la restauration
	if (_request('hidden_confirme_restaure')!='') {
		$test_rest=sql_select('nom_sauvegarde','spip_spipr_educ',"id='"._request('hidden_confirme_restaure')."'");
		$tab_rest=sql_fetch($test_rest);
		$nom_sauvegarde=$tab_rest['nom_sauvegarde'];
		// Supprimer l'habillage courant
		sql_delete('spip_spipr_educ', "nom_sauvegarde = 'en_cours_d_utilisation_SPIPr'");
		// Intégrer l'habillage à restaurer
		$test_integration=sql_select('*','spip_spipr_educ',"nom_sauvegarde = '".$nom_sauvegarde."'");
		while ($tab_integration = sql_fetch($test_integration)){
			sql_insertq('spip_spipr_educ',array(
					'nom'=>$tab_integration['nom'],
					'type'=>$tab_integration['type'],
					'nom_sauvegarde'=>'en_cours_d_utilisation_SPIPr',
					'parametre1'=>$tab_integration['parametre1'],
					'parametre2'=>$tab_integration['parametre2'],
					'parametre3'=>$tab_integration['parametre3'],
					'parametre4'=>$tab_integration['parametre4'],
					'parametre5'=>$tab_integration['parametre5'],
					'parametre6'=>$tab_integration['parametre6'],
					'parametre7'=>$tab_integration['parametre7'],
					'parametre8'=>$tab_integration['parametre8'],
					'parametre9'=>$tab_integration['parametre9'],
					'parametre10'=>$tab_integration['parametre10'],
				));
		}
		// Ajouter les éventuelles entrées manquantes dans la base de données
		include_spip('base/spipr_educ_base_entrees');
		$res['message_ok'] = "La sauvegarde <b>".$nom_sauvegarde."</b> a été restaurée. Pensez à vider le cache de SPIP pour qu'elle s'applique.";
	}
	return $res;
}
?>