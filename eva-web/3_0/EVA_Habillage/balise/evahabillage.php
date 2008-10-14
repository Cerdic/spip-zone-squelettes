<?php
/******************************************************************
***  Ce plugin EVA_habillage, créé par Olivier Gautier, est mis ***
***      à disposition sous un contrat Creative Commons BY      *** 
***                 consultable à l'adresse                     ***
***      http://www.creativecommons.org/licenses/by/2.0/fr/     ***
******************************************************************/
function balise_EVAHABILLAGE($p) {
$test = _DIR_PLUGIN_EVASQUELETTES;
	if (defined("_DIR_PLUGIN_EVASQUELETTES")) {$chemin_squelettes =$test;} else {$chemin_squelettes = 'squelettes/';}
    $requete1 = "SELECT habillage FROM eva_habillage WHERE sauvegarde = 'Defaut'";
    $resultat1 = spip_query($requete1);
    $resultat1_tableau = spip_fetch_array($resultat1);
    $mon_habillage = $resultat1_tableau['habillage'];
    if (($mon_habillage=='0') OR ($mon_habillage=='')) {
        $envoi='<link rel="stylesheet" type="text/css" href="'.$chemin_squelettes.'eva_style.css" media="screen" />';
    }
    else {
        $envoi='<link rel="stylesheet" type="text/css" href="'.$chemin_squelettes.'eva_styles/'.$mon_habillage.'" media="screen" />';
    }
    $envoi .="\n";
    $envoi .='<style type="text/css">';
    $envoi .="\n";
    include_spip('inc/eva_habillage_definition_themes');
    $eva_habillage_themes = eva_habillage_definition_themes ();
    foreach($eva_habillage_themes as $eva_themes => $eva_proprietes) {
        $verif_themes_defini = "SELECT ".$eva_themes." FROM eva_habillage_themes WHERE nom = 'Defaut'";
        $res_verif_themes_defini = spip_query($verif_themes_defini);
        $res_verif_themes_tableau = spip_fetch_array($res_verif_themes_defini);
        $habillage_temp = $res_verif_themes_tableau[$eva_themes];
        if ($habillage_temp) {
            foreach ($eva_proprietes as $eva_prop => $eva_select) {
                $envoi .= implode(' , ',$eva_select);
                $envoi .="{".$eva_prop.":".$habillage_temp.";}\n";
            }
        }
    }
    $image_def = EVA_div_images();
    foreach ($image_def as $image_cle => $image_val) {
        $verif_image_def = spip_query("SELECT type,nom_image,pos_x,pos_y,repetition,attach FROM eva_habillage_images WHERE nom_habillage = 'Defaut' AND nom_div = '".$image_cle."'");
        $tab_image_def = spip_fetch_array($verif_image_def);
        if ($tab_image_def['type']!='') {
            if (strpos($image_cle,'image_')!==FALSE) {
                $envoi .= implode(' , ',$image_val);
                $envoi .=" {background-image : url("._DIR_PLUGIN_EVA_HABILLAGE."mon_image/".$tab_image_def['nom_image'].");\n";
                $envoi .= "background-position : ".$tab_image_def['pos_x']." ".$tab_image_def['pos_y'].";\n";
                $envoi .= "background-repeat : ".$tab_image_def['repetition'].";\n";
                $envoi .="background-attachment : ".$tab_image_def['attach'].";}\n";
            }
            elseif (strpos($image_cle,'liste_')!==FALSE) {
                $envoi .= implode(', ',$image_val);
                $envoi .=" {list-style-image : url("._DIR_PLUGIN_EVA_HABILLAGE."mon_image/".$tab_image_def['nom_image'].");\n";
                $envoi .= "list-style-position : ".$tab_image_def['pos_x'].";}\n";
            }
        }
    }
    $mes_CSS = spip_query("SELECT nom_div FROM eva_habillage_images WHERE nom_habillage = 'Defaut' AND type = 'perso'");
    while ($CSS = spip_fetch_array($mes_CSS)) {$envoi .=$CSS['nom_div']."\n";}
    $envoi .= '</style>';
    $p->code = "'".$envoi."'";
    $p->interdire_scripts = false;
    return $p;
}

?>