<?php
if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_spipr_educ_options_sites_charger_dist($id_syndic) {
	$req_sql=sql_select('*','spip_spipr_educ',"nom='options_sites' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
	$tab_sql=sql_fetch($req_sql);
	$valeurs['bloc_logos']= $tab_sql['parametre2'];
	$valeurs['liste_partenaires']= $tab_sql['parametre3'];
	$valeurs['id_syndic']=$id_syndic;
	return $valeurs;
}

function formulaires_spipr_educ_options_sites_traiter_dist($id_syndic) {
	if (_request('hidden_options_sites')=='ok') {
		// A créer : vérification des checkbox : ensuite 3 cas : si pas de changement => rien, si ajout, mettre en début de chaine, si suppression, retirer de la chaine
		
		//On récupère tout d'abord les entrées de la base qu'on transforme en array pour le traitement
		$req_sql=sql_select('*','spip_spipr_educ',"nom='options_sites' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
		$tab_sql=sql_fetch($req_sql);
		if ($tab_sql['parametre2']!='') {$tab_bloc_logos=explode(",",$tab_sql['parametre2']);} else {$tab_bloc_logos='';}
		if ($tab_sql['parametre3']!='') {$tab_liste_partenaires=explode(",",$tab_sql['parametre3']);} else {$tab_liste_partenaires='';}
			
		// On traite le bloc des logos
		if ($tab_bloc_logos!='') {
			if (in_array($id_syndic,$tab_bloc_logos)) {
				if (_request('bloc_logos',$_POST)!='oui') {
					unset($tab_bloc_logos[array_search($id_syndic, $tab_bloc_logos)]);
					sql_updateq(
						'spip_spipr_educ',
						array(
							'parametre2' => implode(",", $tab_bloc_logos)
						),
						"nom='options_sites' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
					);
				}
			}
			elseif (_request('bloc_logos',$_POST)=='oui') {				
				array_unshift($tab_bloc_logos,$id_syndic);
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre2' => implode(",", $tab_bloc_logos)
					),
					"nom='options_sites' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
			}
		}
		elseif (_request('bloc_logos',$_POST)=='oui') {
			sql_updateq(
				'spip_spipr_educ',
				array(
					'parametre2' => $id_syndic
				),
				"nom='options_sites' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
			);
		}
		
		// Puis la liste des partenaires
		if ($tab_liste_partenaires!='') {
			if (in_array($id_syndic,$tab_liste_partenaires)) {
				if (_request('liste_partenaires',$_POST)!='oui') {
					unset($tab_liste_partenaires[array_search($id_syndic, $tab_liste_partenaires)]);
					sql_updateq(
						'spip_spipr_educ',
						array(
							'parametre3' => implode(",", $tab_liste_partenaires)
						),
						"nom='options_sites' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
					);
				}
			}
			elseif (_request('liste_partenaires',$_POST)=='oui') {				
				array_unshift($tab_liste_partenaires,$id_syndic);
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre3' => implode(",", $tab_liste_partenaires)
					),
					"nom='options_sites' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
			}
		}
		elseif (_request('liste_partenaires',$_POST)=='oui') {
			sql_updateq(
				'spip_spipr_educ',
				array(
					'parametre3' => $id_syndic
				),
				"nom='options_sites' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
			);
		}
		
		echo "<script type='text/javascript'>if (window.jQuery) ajaxReload('configure_sites');</script>";
	}
	return $res;
}
?>