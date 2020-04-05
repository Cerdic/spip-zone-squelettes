<?php
if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_spipr_educ_options_articles_charger_dist($id_article) {
	$req_sql=sql_select('*','spip_spipr_educ',"nom='options_articles' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
	$tab_sql=sql_fetch($req_sql);
	$valeurs['articles_exclu_sommaire']= $tab_sql['parametre1'];
	$valeurs['articles_editorial']= $tab_sql['parametre2'];
	$valeurs['articles_une']= $tab_sql['parametre3'];
	$valeurs['article_mentions']= $tab_sql['parametre4'];
	$valeurs['id_article']=$id_article;
	return $valeurs;
}

function formulaires_spipr_educ_options_articles_traiter_dist($id_article) {
	if (_request('hidden_options_articles')=='ok') {
		
		//On récupère tout d'abord les entrées de la base qu'on transforme en array pour le traitement
		$req_sql=sql_select('*','spip_spipr_educ',"nom='options_articles' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
		$tab_sql=sql_fetch($req_sql);
		if ($tab_sql['parametre1']!='') {$tab_articles_exclu_sommaire=explode(",",$tab_sql['parametre1']);} else {$tab_articles_exclu_sommaire='';}
		if ($tab_sql['parametre2']!='') {$tab_articles_editorial=explode(",",$tab_sql['parametre2']);} else {$tab_articles_editorial='';}
		if ($tab_sql['parametre3']!='') {$tab_articles_une=explode(",",$tab_sql['parametre3']);} else {$tab_articles_une='';}
			
		// On traite les articles exclus de la page de sommaire
		if ($tab_articles_exclu_sommaire!='') {
			if (in_array($id_article,$tab_articles_exclu_sommaire)) {
				if (_request('articles_exclu_sommaire',$_POST)!='oui') {
					unset($tab_articles_exclu_sommaire[array_search($id_article, $tab_articles_exclu_sommaire)]);
					sql_updateq(
						'spip_spipr_educ',
						array(
							'parametre1' => implode(",", $tab_articles_exclu_sommaire)
						),
						"nom='options_articles' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
					);
				}
			}
			elseif (_request('articles_exclu_sommaire',$_POST)=='oui') {				
				array_unshift($tab_articles_exclu_sommaire,$id_article);
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre1' => implode(",", $tab_articles_exclu_sommaire)
					),
					"nom='options_articles' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
			}
		}
		elseif (_request('articles_exclu_sommaire',$_POST)=='oui') {
			sql_updateq(
				'spip_spipr_educ',
				array(
					'parametre1' => $id_article
				),
				"nom='options_articles' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
			);
		}
		
		// Puis les articles placés en éditorial
		if ($tab_articles_editorial!='') {
			if (in_array($id_article,$tab_articles_editorial)) {
				if (_request('articles_editorial',$_POST)!='oui') {
					unset($tab_articles_editorial[array_search($id_article, $tab_articles_editorial)]);
					sql_updateq(
						'spip_spipr_educ',
						array(
							'parametre2' => implode(",", $tab_articles_editorial)
						),
						"nom='options_articles' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
					);
				}
			}
			elseif (_request('articles_editorial',$_POST)=='oui') {				
				array_unshift($tab_articles_editorial,$id_article);
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre2' => implode(",", $tab_articles_editorial)
					),
					"nom='options_articles' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
			}
		}
		elseif (_request('articles_editorial',$_POST)=='oui') {
			sql_updateq(
				'spip_spipr_educ',
				array(
					'parametre2' => $id_article
				),
				"nom='options_articles' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
			);
		}
		
		// Puis les articles placés en Une
		if ($tab_articles_une!='') {
			if (in_array($id_article,$tab_articles_une)) {
				if (_request('articles_une',$_POST)!='oui') {
					unset($tab_articles_une[array_search($id_article, $tab_articles_une)]);
					sql_updateq(
						'spip_spipr_educ',
						array(
							'parametre3' => implode(",", $tab_articles_une)
						),
						"nom='options_articles' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
					);
				}
			}
			elseif (_request('articles_une',$_POST)=='oui') {				
				array_unshift($tab_articles_une,$id_article);
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre3' => implode(",", $tab_articles_une)
					),
					"nom='options_articles' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
			}
		}
		elseif (_request('articles_une',$_POST)=='oui') {
			sql_updateq(
				'spip_spipr_educ',
				array(
					'parametre3' => $id_article
				),
				"nom='options_articles' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
			);
		}
		
		// Article placé en mentions légales (lien en bas de page)
		
		if (_request('article_mentions',$_POST)=='oui') {
			sql_updateq(
				'spip_spipr_educ',
				array(
					'parametre4' => $id_article
				),
				"nom='options_articles' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
			);
		}
		elseif ($tab_sql['parametre4']==$id_article) {
			sql_updateq(
				'spip_spipr_educ',
				array(
					'parametre4' => ''
				),
				"nom='options_articles' AND type='gestion bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
			);
		}
		
		echo "<script type='text/javascript'>if (window.jQuery) ajaxReload('configure_articles');</script>";
	}
	return $res;
}
?>