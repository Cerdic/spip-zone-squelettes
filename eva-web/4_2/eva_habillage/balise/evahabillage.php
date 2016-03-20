<?php
function balise_EVAHABILLAGE($p){
	$test = _DIR_PLUGIN_EVASQUELETTES;
	if (defined("_DIR_PLUGIN_EVASQUELETTES")){
		$chemin_squelettes = $test;
	} else {
		$chemin_squelettes = 'squelettes/';
	}
	$resultat1 = sql_select('habillage', 'spip_eva_habillage', "sauvegarde = 'Defaut'");
	$resultat1_tableau = sql_fetch($resultat1);
	$mon_habillage = $resultat1_tableau['habillage'];
	if (($mon_habillage=='0') OR ($mon_habillage=='')){
		$envoi = '<link rel="stylesheet" type="text/css" href="' . $chemin_squelettes . 'eva_style.css" media="screen" />';
	} else {
		$envoi = '<link rel="stylesheet" type="text/css" href="' . $chemin_squelettes . 'eva_styles/' . $mon_habillage . '" media="screen" />';
	}
	$envoi .= "\n";
	$envoi .= '<style type="text/css">';
	$envoi .= "\n";
	include_spip('inc/eva_habillage_definition_themes');
	$eva_habillage_themes = eva_habillage_definition_themes();
	foreach ($eva_habillage_themes as $eva_themes => $eva_proprietes){
		$res_verif_themes_defini = sql_select($eva_themes, 'spip_eva_habillage_themes', "nom = 'Defaut'");
		$res_verif_themes_tableau = sql_fetch($res_verif_themes_defini);
		$habillage_temp = $res_verif_themes_tableau[$eva_themes];
		if ($habillage_temp){
			foreach ($eva_proprietes as $eva_prop => $eva_select){
				$envoi .= implode(' , ', $eva_select);
				$envoi .= "{" . $eva_prop . ":" . $habillage_temp . ";}\n";
			}
		}
	}
	$image_def = EVA_div_images();
	foreach ($image_def as $image_cle => $image_val){
		$verif_image_def = sql_select('type,nom_image,pos_x,pos_y,repetition,attach', 'spip_eva_habillage_images', "nom_habillage = 'Defaut' AND nom_div = '" . $image_cle . "'");
		$tab_image_def = sql_fetch($verif_image_def);
		if ($tab_image_def['type']!=''){
			if (strpos($image_cle, 'image_')!==FALSE){
				if ($f = find_in_path("eva_habillage/" . $tab_image_def['nom_image'])
				OR file_exists($f=_DIR_IMG . "eva_habillage/" . $tab_image_def['nom_image'])
				OR file_exists($f=_DIR_PLUGIN_EVA_HABILLAGE . "mon_image/" . $tab_image_def['nom_image']) ){
					$envoi .= implode(' , ', $image_val);
					$envoi .= " {background-image : url($f);";
					$envoi .= "background-position : " . $tab_image_def['pos_x'] . " " . $tab_image_def['pos_y'] . ";";
					$envoi .= "background-repeat : " . $tab_image_def['repetition'] . ";";
					$envoi .= "background-attachment : " . $tab_image_def['attach'] . ";}\n";
				}
			} elseif (strpos($image_cle, 'liste_')!==FALSE) {
				if ($f = find_in_path("eva_habillage/" . $tab_image_def['nom_image'])
				OR file_exists($f=_DIR_IMG . "eva_habillage/" . $tab_image_def['nom_image'])
				OR file_exists($f=_DIR_PLUGIN_EVA_HABILLAGE . "mon_image/" . $tab_image_def['nom_image']) ){
					$envoi .= implode(', ', $image_val);
					$envoi .= " {list-style-image : url($f);";
					$envoi .= "list-style-position : " . $tab_image_def['pos_x'] . ";}\n";
				}
			}
		}
	}

//Menu depliable
	$tab_evabonus_menu = EVA_menu_dynamique_horizontal();
	foreach ($tab_evabonus_menu as $cle_evabonus_menu => $val_evabonus_menu){
		$req_menu_depliable = sql_select('nom_image', 'spip_eva_habillage_images', "type='menu_depliable_horizontal' AND nom_habillage='Defaut' AND nom_div='" . $cle_evabonus_menu . "'");
		$tab_menu_depliable = sql_fetch($req_menu_depliable);
		$code_menu_depliable = $tab_menu_depliable['nom_image'];
		if ($code_menu_depliable){
			$envoi .= "$val_evabonus_menu" . $code_menu_depliable . ";}\n";
		}
	}
//Fin Menu depliable

//Menu de langue
	$tab_evabonus_menu = EVA_menu_langue();
	foreach ($tab_evabonus_menu as $cle_evabonus_menu => $val_evabonus_menu){
		$req_menu_depliable = sql_select('nom_image', 'spip_eva_habillage_images', "type='multilinguisme' AND nom_habillage='Defaut' AND nom_div='" . $cle_evabonus_menu . "'");
		$tab_menu_depliable = sql_fetch($req_menu_depliable);
		$code_menu_depliable = $tab_menu_depliable['nom_image'];
		if ($code_menu_depliable){
			$envoi .= "$val_evabonus_menu" . $code_menu_depliable . ";}\n";
		}
	}
//Fin Menu de langue

	$mes_CSS = sql_select('nom_div', 'spip_eva_habillage_images', "nom_habillage = 'Defaut' AND type = 'perso'");
	while ($CSS = sql_fetch($mes_CSS)){
		$CSS_remp = str_replace('/rep_eva_habillage/', _DIR_PLUGIN_EVA_HABILLAGE, $CSS['nom_div']);
		$envoi .= $CSS_remp . "\n";
	}
	$envoi .= '</style>';
	$p->code = "'" . $envoi . "'";
	$p->interdire_scripts = false;
	return $p;
}
?>