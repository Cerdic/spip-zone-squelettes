<?php
if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_spipr_educ_options_rubriques_charger_dist($id_rubrique) {
	$req_sql=sql_select('*','spip_spipr_educ',"nom='options_rubriques' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
	$tab_sql=sql_fetch($req_sql);
	$valeurs['rubriques_exclues_sommaire']= $tab_sql['parametre1'];
	$valeurs['rubriques_exclues_menu']= $tab_sql['parametre2'];
	$valeurs['rubriques_exclues_menu_horizontal']= $tab_sql['parametre5'];
	$valeurs['rubriques_exclues_plan']= $tab_sql['parametre3'];
	$valeurs['rubriques_exclues_rss']= $tab_sql['parametre4'];
	$valeurs['id_rubrique']=$id_rubrique;
	return $valeurs;
}

function formulaires_spipr_educ_options_rubriques_traiter_dist($id_rubrique) {
	if (_request('hidden_options_rubriques')=='ok') {
		
		//On récupère tout d'abord les entrées de la base qu'on transforme en array pour le traitement
		$req_sql=sql_select('*','spip_spipr_educ',"nom='options_rubriques' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
		$tab_sql=sql_fetch($req_sql);
		if ($tab_sql['parametre1']!='') {$tab_rubriques_exclues_sommaire=explode(",",$tab_sql['parametre1']);} else {$tab_rubriques_exclues_sommaire='';}
		if ($tab_sql['parametre2']!='') {$tab_rubriques_exclues_menu=explode(",",$tab_sql['parametre2']);} else {$tab_rubriques_exclues_menu='';}
		if ($tab_sql['parametre3']!='') {$tab_rubriques_exclues_plan=explode(",",$tab_sql['parametre3']);} else {$tab_rubriques_exclues_plan='';}
		if ($tab_sql['parametre4']!='') {$tab_rubriques_exclues_rss=explode(",",$tab_sql['parametre4']);} else {$tab_rubriques_exclues_rss='';}
		if ($tab_sql['parametre5']!='') {$tab_rubriques_exclues_menu_horizontal=explode(",",$tab_sql['parametre5']);} else {$tab_rubriques_exclues_menu_horizontal='';}
			
		// On traite les rubriques exclues de la page de sommaire
		if ($tab_rubriques_exclues_sommaire!='') {
			if (in_array($id_rubrique,$tab_rubriques_exclues_sommaire)) {
				if (_request('rubriques_exclues_sommaire',$_POST)!='oui') {
					unset($tab_rubriques_exclues_sommaire[array_search($id_rubrique, $tab_rubriques_exclues_sommaire)]);
					sql_updateq(
						'spip_spipr_educ',
						array(
							'parametre1' => implode(",", $tab_rubriques_exclues_sommaire)
						),
						"nom='options_rubriques' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
					);
				}
			}
			elseif (_request('rubriques_exclues_sommaire',$_POST)=='oui') {				
				array_unshift($tab_rubriques_exclues_sommaire,$id_rubrique);
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre1' => implode(",", $tab_rubriques_exclues_sommaire)
					),
					"nom='options_rubriques' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
			}
		}
		elseif (_request('rubriques_exclues_sommaire',$_POST)=='oui') {
			sql_updateq(
				'spip_spipr_educ',
				array(
					'parametre1' => $id_rubrique
				),
				"nom='options_rubriques' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
			);
		}
		
		// Puis les rubriques exclues du menu vertical
		if ($tab_rubriques_exclues_menu!='') {
			if (in_array($id_rubrique,$tab_rubriques_exclues_menu)) {
				if (_request('rubriques_exclues_menu',$_POST)!='oui') {
					unset($tab_rubriques_exclues_menu[array_search($id_rubrique, $tab_rubriques_exclues_menu)]);
					sql_updateq(
						'spip_spipr_educ',
						array(
							'parametre2' => implode(",", $tab_rubriques_exclues_menu)
						),
						"nom='options_rubriques' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
					);
				}
			}
			elseif (_request('rubriques_exclues_menu',$_POST)=='oui') {				
				array_unshift($tab_rubriques_exclues_menu,$id_rubrique);
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre2' => implode(",", $tab_rubriques_exclues_menu)
					),
					"nom='options_rubriques' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
			}
		}
		elseif (_request('rubriques_exclues_menu',$_POST)=='oui') {
			sql_updateq(
				'spip_spipr_educ',
				array(
					'parametre2' => $id_rubrique
				),
				"nom='options_rubriques' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
			);
		}
		
		// Puis les rubriques exclues du menu horizontal
		if ($tab_rubriques_exclues_menu_horizontal!='') {
			if (in_array($id_rubrique,$tab_rubriques_exclues_menu_horizontal)) {
				if (_request('rubriques_exclues_menu_horizontal',$_POST)!='oui') {
					unset($tab_rubriques_exclues_menu_horizontal[array_search($id_rubrique, $tab_rubriques_exclues_menu_horizontal)]);
					sql_updateq(
						'spip_spipr_educ',
						array(
							'parametre5' => implode(",", $tab_rubriques_exclues_menu_horizontal)
						),
						"nom='options_rubriques' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
					);
				}
			}
			elseif (_request('rubriques_exclues_menu_horizontal',$_POST)=='oui') {				
				array_unshift($tab_rubriques_exclues_menu_horizontal,$id_rubrique);
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre5' => implode(",", $tab_rubriques_exclues_menu_horizontal)
					),
					"nom='options_rubriques' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
			}
		}
		elseif (_request('rubriques_exclues_menu_horizontal',$_POST)=='oui') {
			sql_updateq(
				'spip_spipr_educ',
				array(
					'parametre5' => $id_rubrique
				),
				"nom='options_rubriques' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
			);
		}
		
		// Puis les rubriques exclues du plan
		if ($tab_rubriques_exclues_plan!='') {
			if (in_array($id_rubrique,$tab_rubriques_exclues_plan)) {
				if (_request('rubriques_exclues_plan',$_POST)!='oui') {
					unset($tab_rubriques_exclues_plan[array_search($id_rubrique, $tab_rubriques_exclues_plan)]);
					sql_updateq(
						'spip_spipr_educ',
						array(
							'parametre3' => implode(",", $tab_rubriques_exclues_plan)
						),
						"nom='options_rubriques' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
					);
				}
			}
			elseif (_request('rubriques_exclues_plan',$_POST)=='oui') {				
				array_unshift($tab_rubriques_exclues_plan,$id_rubrique);
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre3' => implode(",", $tab_rubriques_exclues_plan)
					),
					"nom='options_rubriques' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
			}
		}
		elseif (_request('rubriques_exclues_plan',$_POST)=='oui') {
			sql_updateq(
				'spip_spipr_educ',
				array(
					'parametre3' => $id_rubrique
				),
				"nom='options_rubriques' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
			);
		}
		
		// Puis les rubriques exclues des flux RSS
		if ($tab_rubriques_exclues_rss!='') {
			if (in_array($id_rubrique,$tab_rubriques_exclues_rss)) {
				if (_request('rubriques_exclues_rss',$_POST)!='oui') {
					unset($tab_rubriques_exclues_rss[array_search($id_rubrique, $tab_rubriques_exclues_rss)]);
					sql_updateq(
						'spip_spipr_educ',
						array(
							'parametre4' => implode(",", $tab_rubriques_exclues_rss)
						),
						"nom='options_rubriques' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
					);
				}
			}
			elseif (_request('rubriques_exclues_rss',$_POST)=='oui') {				
				array_unshift($tab_rubriques_exclues_rss,$id_rubrique);
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre4' => implode(",", $tab_rubriques_exclues_rss)
					),
					"nom='options_rubriques' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
			}
		}
		elseif (_request('rubriques_exclues_rss',$_POST)=='oui') {
			sql_updateq(
				'spip_spipr_educ',
				array(
					'parametre4' => $id_rubrique
				),
				"nom='options_rubriques' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
			);
		}
		
		echo "<script type='text/javascript'>if (window.jQuery) ajaxReload('configure_rubriques');</script>";
	}
	return $res;
}
?>