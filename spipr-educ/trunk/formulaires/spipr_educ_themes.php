<?php
if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_spipr_educ_themes_charger_dist() {
	// Layout précédemment choisi
	$test_theme_parametres=sql_select('nom','spip_spipr_educ',"type='theme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
	$tab_test_theme_parametres=sql_fetch($test_theme_parametres);
	$test_theme_actuel=$tab_test_theme_parametres['nom'];
	$chemin =_DIR_PLUGIN_SPIPR_EDUC.'themes/';
	$valeurs=array();
	$valeurs['theme_actuel'] = $test_theme_actuel;
	$valeurs['chemin'] = $chemin;
	return $valeurs;
}

function formulaires_spipr_educ_themes_traiter_dist() {
	include_spip('inc/spipr_educ_definitions_themes');
	$themes_proposes=spipr_educ_definition_themes();
	$res = array('editable'=>true);
	// On teste le thème actuel : on ne fait rien s'il n'y a pas de changement de thème
	$test_theme_parametres=sql_select('nom','spip_spipr_educ',"type='theme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
	$tab_test_theme_parametres=sql_fetch($test_theme_parametres);
	$test_theme_actuel=$tab_test_theme_parametres['nom'];
	if ($test_theme_actuel==$themes_proposes[_request('theme_choix',$_POST)]) { $res['message_ok'] = "Vous conservez le th&egrave;me actuel, aucune modification n'a &eacute;t&eacute; enregistr&eacute;e.";}
	else {
		foreach($themes_proposes as  $cle => $nom_theme) {
			if (_request('theme_choix',$_POST)==$cle) {
				sql_updateq(
					'spip_spipr_educ',
					array(
						'nom' => $nom_theme,
					),
					"type='theme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				spipr_educ_reinitialiser_theme($themes_proposes[_request('theme_choix',$_POST)]);
			}
		}
		$res['message_ok'] = _T('config_info_enregistree');
	}
	
	return $res;
}
?>