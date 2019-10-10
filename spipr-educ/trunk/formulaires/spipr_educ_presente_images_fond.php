<?php
if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_spipr_educ_presente_images_fond_charger_dist() {
	$valeurs = array ();
	return $valeurs;
}

function formulaires_spipr_educ_presente_images_fond_traiter_dist() {
	$res = array();
	$les_secteurs=array('fond_ecran','fond_page','fond_entete','fond_barre_menu','fond_breadcrumb','fond_pied');
	foreach ($les_secteurs as $secteur){
		if (is_numeric(_request($secteur.'_x'))) {
			sql_updateq(
				'spip_spipr_educ',
				array(
					'parametre1' => '',
					'parametre2' => '',
					'parametre3' => '',
					'parametre4' => '',
					'parametre5' => '',
					'parametre6' => '',
					'parametre7' => '',
					'parametre8' => '',
					'parametre9' => '',
					'parametre10' => '',
				),
				"nom='$secteur' AND type='graphisme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
			);
		}
	}
	return $res;
}
?>