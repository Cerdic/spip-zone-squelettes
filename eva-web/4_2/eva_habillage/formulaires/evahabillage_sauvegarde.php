<?php

if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_evahabillage_sauvegarde_charger_dist(){
	
	// S'il n'y a pas encore d'habillage par défaut défini, on pose l'habillage eva4_menu_gauche.css
	$test_fri=sql_select('id_habillage','spip_eva_habillage',"sauvegarde='Defaut'");
    $tab_fri=sql_fetch($test_fri);
    if (!isset($tab_fri['id_habillage'])) {sql_insertq('spip_eva_habillage',array('habillage' => 'eva4_menu_gauche.css','sauvegarde' => 'Defaut'));}
	
	//On charge maintenant l'habillage précédemment défini
	$resultat1 = sql_select('habillage','spip_eva_habillage',"sauvegarde = 'Defaut'");
    $resultat1_tableau = sql_fetch($resultat1);
    $mon_habillage = $resultat1_tableau['habillage'];
	
	// Si on est encore avec un habillage par défaut en version EVA 4.1 (habillage 0), alors on passe en habillage par défaut EVA 4.2 (eva4_menu_gauche.css)
	if ($mon_habillage=='0') {
		sql_updateq('spip_eva_habillage',array('habillage' => 'eva4_menu_gauche.css'),"sauvegarde = 'Defaut'");
	}
	
	$valeurs=array();
	$valeurs['changement_habillage'] = $mon_habillage;
	$image_habillage = preg_replace('/.css/','.png',$mon_habillage);
	$valeurs['nom_vignette'] = $image_habillage;
	$valeurs['chemin_vignettes'] = _DIR_PLUGIN_EVASQUELETTES."images/vignettes_styles/";
	$valeurs['chemin_styles'] = _DIR_PLUGIN_EVASQUELETTES."eva_styles/";
	return $valeurs;
}


function formulaires_evahabillage_sauvegarde_traiter_dist(){
	$res = array('editable'=>true);
	if ((_request('sauvegarder')=='Sauvegarder') AND (_request('sauvegarde_habillage')!='Defaut')) {
		$nom_sauvegarde=_request('sauvegarde_habillage');
		echo $nom_sauvegarde;
		/* 
        $nom_habillage_defaut=sql_select("habillage","spip_eva_habillage","sauvegarde = 'Defaut'");
        $tab_habillage_defaut=sql_fetch($nom_habillage_defaut);
        sql_delete("spip_eva_habillage","sauvegarde='".mysql_real_escape_string($nom_sauvegarde)."'");
        sql_insertq("spip_eva_habillage",array('habillage' => $tab_habillage_defaut['habillage'],'sauvegarde' => mysql_real_escape_string($nom_sauvegarde)));
        sql_delete("spip_eva_habillage_themes","nom='".mysql_real_escape_string($nom_sauvegarde)."'");
        sql_insertq("spip_eva_habillage_themes",array('nom' => mysql_real_escape_string($nom_sauvegarde)));
		$result_valeurs=sql_select("*","spip_eva_habillage_themes","nom='Defaut'");
        $tab_valeurs=sql_fetch($result_valeurs);
        foreach($def_themes as $habillage_cles => $habillage_inutile) {sql_updateq('spip_eva_habillage_themes',array($habillage_cles => $tab_valeurs[$habillage_cles]),"nom='".mysql_real_escape_string($nom_sauvegarde)."'");}
        sql_delete("spip_eva_habillage_images","nom_habillage='".mysql_real_escape_string($nom_sauvegarde)."'");
        $result_images_sauve=sql_select('type,nom_div,nom_image,pos_x,pos_y,repetition,attach','spip_eva_habillage_images',"nom_habillage='Defaut'");
        while ($tab=sql_fetch($result_images_sauve)) {
            sql_insertq("spip_eva_habillage_images",array('type' => $tab['type'],'nom_habillage' => mysql_real_escape_string($nom_sauvegarde),'nom_div' => $tab['nom_div'], 'nom_image' => $tab['nom_image'], 'pos_x' => $tab['pos_x'],'pos_y' => $tab['pos_y'],'repetition' => $tab['repetition'], 'attach' => $tab['attach']));
			}
		*/
	}
	$res['message_ok'] = _T('config_info_enregistree');
	return $res;
}

