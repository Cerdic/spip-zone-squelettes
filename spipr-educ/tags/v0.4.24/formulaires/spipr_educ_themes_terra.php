<?php
if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_spipr_educ_themes_terra_charger_dist() {
	$test_couleur=sql_select('parametre1','spip_spipr_educ',"type='theme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
	$tab_couleur=sql_fetch($test_couleur);
	$valeurs=array();
	$valeurs['couleur_actuelle']=$tab_couleur['parametre1'];
	return $valeurs;
}

function formulaires_spipr_educ_themes_terra_traiter_dist() {
	$res = array('editable'=>true);
	$test_couleur=sql_select('parametre1','spip_spipr_educ',"type='theme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
	$tab_couleur=sql_fetch($test_couleur);
	$couleur=$tab_couleur['parametre1'];
	include_spip('inc/spipr_educ_definitions_themes');
	// On teste la couleur actuelle : on ne fait rien s'il n'y a pas de changement
	$nouvelle_couleur=_request('couleur_choisie',$_POST);
	if ($nouvelle_couleur==$couleur) $retour = "Vous n'avez pas choisi une nouvelle couleur, aucune modification n'a &eacute;t&eacute; enregistr&eacute;e.";
	elseif (in_array($nouvelle_couleur, spipr_educ_defintion_couleurs('terra'))) {
		sql_updateq(
			'spip_spipr_educ',
			array(
				'parametre1' => $nouvelle_couleur,
			),
			"type='theme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
		);
		if (spipr_educ_modif_couleur_theme('terra',$nouvelle_couleur)=='ok') $retour = "Le choix de la couleur \""._T('spipr_educ:'.$nouvelle_couleur)."\" a &eacute;t&eacute; pris en compte.";
	}
	$res['message_ok'] = $retour;
	return $res;
}
?>