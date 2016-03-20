<?php

if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_evahabillage_menu_horizontal_charger_dist(){
	//Rien à retourner ici : tout est dans le formulaire html et en php
	$valeurs=array();
	return $valeurs;
}


function formulaires_evahabillage_menu_horizontal_traiter_dist(){
	$res = array('editable'=>true);
	$res['message_ok'] = 'Aucune modification n\'a &eacute;t&eacute; enregistr&eacute;e';
	$tab_evabonus_menu=array(
		'evabonus_menu_horizontal_couleur_fond',
		'evabonus_menu_horizontal_couleur_fond_survol',
		'evabonus_menu_horizontal_couleur_fond_actif',
		'evabonus_menu_horizontal_couleur_texte',
		'evabonus_menu_horizontal_couleur_texte_survol',
		'evabonus_menu_horizontal_couleur_texte_actif',
		'evabonus_menu_horizontal_couleur_bordure_style',
		'evabonus_menu_horizontal_couleur_bordure_largeur',
		'evabonus_menu_horizontal_couleur_bordure_couleur'
	);
	// Tailles des logos
	if (_request('test_menu_depliable_horizontal')=='Valider') {
		$res['message_ok'] = 'Modifications graphiques enregistr&eacute;es';
		foreach ($tab_evabonus_menu as $cle_evabonus_menu) {
			sql_delete('spip_eva_habillage_images',"nom_habillage = 'Defaut' AND type='menu_depliable_horizontal' AND nom_div='".$cle_evabonus_menu."'");
			sql_insertq('spip_eva_habillage_images',array('nom_habillage' => 'Defaut','type' => 'menu_depliable_horizontal','nom_div' => $cle_evabonus_menu,'nom_image' => _request($cle_evabonus_menu)));
		}
	}
	return $res;
}