<?php
if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_spipr_educ_save_sauvegarder_charger_dist() {
	$valeurs=array(
	);
	return $valeurs;
}

function formulaires_spipr_educ_save_sauvegarder_traiter_dist() {
	$res = array('editable'=>true);
	if (strpos (_request('nom_sauvegarde'),"'") OR strpos (_request('nom_sauvegarde'),'"') OR strpos (_request('nom_sauvegarde'),"\\")) {
		$res['message_erreur'] = "Merci de ne pas utiliser de caractères spéciaux dans votre nom de sauvegarde. La sauvegarde n'a pas été effectuée.";
	}
	// Si le nom de sauvegarde est 'en_cours_d_utilisation_SPIPr', envoyer le message d'erreur correspondant
	elseif (_request('nom_sauvegarde')=='en_cours_d_utilisation_SPIPr') {
	$res['message_erreur'] = "Ce nom de sauvegarde ne peut être utilisé. La sauvegarde n'a pas été effectuée.";
	}
	else {
		$test_save=sql_select('*','spip_spipr_educ',"type='theme' AND nom_sauvegarde='"._request('nom_sauvegarde')."'");
		$tab_save=sql_fetch($test_save);
		if ($tab_save['id']!='') {
			// Si le nom de sauvegarde est déjà utilisé dans la base refuser la sauvegarde
			$res['message_erreur'] = "Ce nom de sauvegarde est déjà utilisé. Vous ne pouvez pas l'utiliser.";
		}	
		else {
			// Sinon, sauvegarder
			$test_save=sql_select('*','spip_spipr_educ',"nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
			while ($tab_save = sql_fetch($test_save)){
				sql_insertq('spip_spipr_educ',array(
					'nom'=>$tab_save['nom'],
					'type'=>$tab_save['type'],
					'nom_sauvegarde'=>_request('nom_sauvegarde'),
					'parametre1'=>$tab_save['parametre1'],
					'parametre2'=>$tab_save['parametre2'],
					'parametre3'=>$tab_save['parametre3'],
					'parametre4'=>$tab_save['parametre4'],
					'parametre5'=>$tab_save['parametre5'],
					'parametre6'=>$tab_save['parametre6'],
					'parametre7'=>$tab_save['parametre7'],
					'parametre8'=>$tab_save['parametre8'],
					'parametre9'=>$tab_save['parametre9'],
					'parametre10'=>$tab_save['parametre10'],
				));
			}
			echo "<script type='text/javascript'>if (window.jQuery) ajaxReload('save_restaurer');</script>";
		}
	}
	return $res;
}
?>