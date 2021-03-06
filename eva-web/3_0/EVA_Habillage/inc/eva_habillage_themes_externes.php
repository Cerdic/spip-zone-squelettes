<?php
/******************************************************************
***  Ce plugin EVA_habillage, cr�� par Olivier Gautier, est mis ***
***      � disposition sous un contrat Creative Commons BY      *** 
***                 consultable � l'adresse                     ***
***      http://www.creativecommons.org/licenses/by/2.0/fr/     ***
******************************************************************/
function eva_charger_themes() {
global $eva_themes;

$eva_themes = array(
'Vide' => array(
    /* Th�me cr�� par Olivier Gautier */
    "habillage" => "'0'",
    "theme" => "('', 'Defaut', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '')",
    "images" => array()
    ),

'Black Apple' => array(
    /* Th�me cr�� par Olivier Gautier */
    "habillage" => "'eva_style_images_de_fond.css'",
    "theme" => "('', 'Defaut', '#000000', '#252525', '#333333', '#444444', '#000000', '#26a526', '#216f21', '#26a526', '#26a526', '#26a526', '#455245', '#26a526', '#216f21', '#455245', '#444444', '#333333', '#26a526', '#5a6958', '#455245', 'georgia', '#FFFFFF', '#FFFFFF', '#d5f5d9', '#d5f5d9', '#CCC', '#FFF', '#CCC', '#FFFFFF', '#d5f5d9', '#cbf3ef', '#d5f5d9', '#26a526', '#FFFFFF', '#d5f5d9', '#26a526', '#FFFFFF', '#FFFFFF', '#FFFFFF', '#2593d8', '#25d8c1', '#2593d8', '#25d8c1', '#2593d8', '#25d8c1', '#000000', '', '', '#333333', '', '', '#26a526', '', '', '', '', 'none', '#216f21', '', '', '#444444', '', '', '#26a526', '', '', '#444444', '', '', '#333333', '', '', '', '', '', '', '', '130px', '40px')",
    "images" => array(
    "('', 'image', 'Defaut', 'image_page', 'Black/Black_page.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_entete_page', 'Black/BlackApple_pied.png', 'left', '24px', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_edito_titre', 'Black/BlackApple_titre_edito.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_edito', 'Black/BlackApple_edito.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_menu_off', 'Black/BlackApple_bas_bloc.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_bloc', 'Black/BlackApple_bas_bloc.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_barre_auteur', 'Black/BlackApple_entete_arborescence.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_pairs', 'Black/BlackApple_bas_paires.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_ecran', 'Black/BlackApple_degrade_noir_gris.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_pied', 'Black/BlackApple_pied.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_impairs', 'Black/BlackApple_bas_impaires.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_barre_entete_arborescence', 'Black/BlackApple_entete_arborescence.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_menu_on', 'Black/BlackApple_entete_liens.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_titres', 'Black/BlackApple_titres_secteurs.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_titre_entete', 'Black/BlackApple_entete_arborescence.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'perso', 'Defaut', '#Forum .bouton a:first-letter, .divers h4:first-letter, div#Contenu div.lien:first-letter, div#Contenu div.ps h4:first-letter, div#Contenu div.notes h4:first-letter, div#Contenu h4.titre:first-letter, div#Contenu h3:first-letter, div#Contenu .bloc2 h3:first-letter, div#Contenu .bloc2 h3.titre:first-letter, div#Menu h3:first-letter, .divers h4:first-letter, h3:first-letter, div#Contenu .edito h3.titre:first-letter {font-size:130%;}', '', '', '', '', '')",
    "('', 'perso', 'Defaut', 'div#Contenu .edito h3.titre {border : 1px solid #1F1F1F;}	', '', '', '', '', '')"
    ), ),
'Black Cherry' => array(
    /* Th�me cr�� par Olivier Gautier */
    "habillage" => "'eva_style_images_de_fond.css'",
    "theme" => "('', 'Defaut', '#000000', '#252525', '#333333', '#444444', '#000000', '#CD072B', '#87030D', '#87030D', '#CD072B', '#CD072B', '#455245', '#CD072B', '#87030D', '#455245', '#444444', '#333333', '#CD072B', '#5a6958', '#455245', 'georgia', '#FFFFFF', '#FFFFFF', '#FFFFFF', '#FFFFFF', '#CCC', '#FFF', '#CCC', '#FFFFFF', '#d5f5d9', '#fc98a9', '#FFFFFF', '#CD072B', '#FFFFFF', '#FFFFFF', '#CD072B', '#FFFFFF', '#FFFFFF', '#FFFFFF', '#2593d8', '#25d8c1', '#2593d8', '#25d8c1', '#2593d8', '#25d8c1', '#000000', '', '', '#333333', '', '', '#cd072b', '', '', '', '', 'none', '#cd072b', '', '', '#444444', '', '', '#CD072B', '', '', '#444444', '', '', '#333333', '', '', '', '', '', '', '', '130px', '40px')",
    "images" => array(
    "('', 'image', 'Defaut', 'image_page', 'Black/Black_page.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_titres', 'Black/BlackApple_titres_secteurs.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_titre_entete', 'Black/BlackCherry_entete_arborescence.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_entete_page', 'Black/BlackCherry_pied.png', 'left', '24px', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_barre_entete_arborescence', 'Black/BlackCherry_entete_arborescence.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_pied', 'Black/BlackCherry_pied.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_impairs', 'Black/BlackApple_bas_impaires.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_menu_on', 'Black/BlackCherry_entete_liens.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_barre_auteur', 'Black/BlackCherry_entete_arborescence.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_ecran', 'Black/BlackApple_degrade_noir_gris.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_pairs', 'Black/BlackApple_bas_paires.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_bloc', 'Black/BlackApple_bas_bloc.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_menu_off', 'Black/BlackApple_bas_bloc.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_edito', 'Black/BlackApple_edito.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_edito_titre', 'Black/BlackApple_titre_edito.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'perso', 'Defaut', '#Forum .bouton a:first-letter, .divers h4:first-letter, div#Contenu div.lien:first-letter, div#Contenu div.ps h4:first-letter, div#Contenu div.notes h4:first-letter, div#Contenu h4.titre:first-letter, div#Contenu h3:first-letter, div#Contenu .bloc2 h3:first-letter, div#Contenu .bloc2 h3.titre:first-letter, div#Menu h3:first-letter, .divers h4:first-letter, h3:first-letter, div#Contenu .edito h3.titre:first-letter {font-size:130%;}', '', '', '', '', '')",
    "('', 'perso', 'Defaut', 'div#Contenu .edito h3.titre {border : 1px solid #1F1F1F;}	', '', '', '', '', '')"
    ), ),
'Black Lemon' => array(
    /* Th�me cr�� par Olivier Gautier */
    "habillage" => "'eva_style_images_de_fond.css'",
    "theme" => "('', 'Defaut', '#000000', '#252525', '#333333', '#444444', '#000000', '#f1ec1f', '#a5a90c', '#a5a90c', '#f1ec1f', '#f1ec1f', '#455245', '#f1ec1f', '#a5a90c', '#455245', '#444444', '#333333', '#f1ec1f', '#5a6958', '#455245', 'georgia', '#FFFFFF', '#FFFFFF', '#FFFFFF', 'grey', '#CCC', '#FFF', '#CCC', '#FFFFFF', '#222222', 'grey', '#FFFFFF', '#f1ec1f', '#FFFFFF', '#FFFFFF', '#f1ec1f', '#222222', '#222222', '#222222', '#2593d8', '#25d8c1', '#2593d8', '#25d8c1', '#2593d8', '#25d8c1', '#000000', '', '', '#333333', '', '', '#f1ec1f', '', '', '', '', 'none', '#f1ec1f', '', '', '#444444', '', '', '#f1ec1f', '', '', '#444444', '', '', '#333333', '', '', '', '', '', '', '', '130px', '40px')",
    "images" => array(
    "('', 'image', 'Defaut', 'image_page', 'Black/Black_page.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_entete_page', 'Black/BlackLemon_pied.png', 'left', '24px', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_edito', 'Black/BlackApple_edito.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_pairs', 'Black/BlackApple_bas_paires.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_menu_off', 'Black/BlackApple_bas_bloc.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_edito_titre', 'Black/BlackApple_titre_edito.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_bloc', 'Black/BlackApple_bas_bloc.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_ecran', 'Black/BlackApple_degrade_noir_gris.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_barre_entete_arborescence', 'Black/BlackLemon_entete_arborescence.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_pied', 'Black/BlackLemon_pied.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_impairs', 'Black/BlackApple_bas_impaires.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_titre_entete', 'Black/BlackLemon_entete_arborescence.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_menu_on', 'Black/BlackLemon_entete_liens.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_barre_auteur', 'Black/BlackLemon_entete_arborescence.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_titres', 'Black/BlackApple_titres_secteurs.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'perso', 'Defaut', '#Forum .bouton a:first-letter, .divers h4:first-letter, div#Contenu div.lien:first-letter, div#Contenu div.ps h4:first-letter, div#Contenu div.notes h4:first-letter, div#Contenu h4.titre:first-letter, div#Contenu h3:first-letter, div#Contenu .bloc2 h3:first-letter, div#Contenu .bloc2 h3.titre:first-letter, div#Menu h3:first-letter, .divers h4:first-letter, h3:first-letter, div#Contenu .edito h3.titre:first-letter {font-size:130%;}', '', '', '', '', '')",
    "('', 'perso', 'Defaut', 'div#Contenu .edito h3.titre {border : 1px solid #1F1F1F;}	', '', '', '', '', '')"
    ), ),
'Black Orange' => array(
    /* Th�me cr�� par Olivier Gautier */
    "habillage" => "'eva_style_images_de_fond.css'",
    "theme" => "('', 'Defaut', '#000000', '#252525', '#333333', '#444444', '#000000', '#fa520a', '#be3c03', '#be3c03', '#fa520a', '#fa520a', '#455245', '#fa520a', '#be3c03', '#455245', '#444444', '#333333', '#fa520a', '#5a6958', '#455245', 'georgia', '#FFFFFF', '#FFFFFF', '#d5f5d9', '#d5f5d9', '#CCC', '#FFF', '#CCC', '#FFFFFF', '#d5f5d9', '#fc9f78', '#FFFFFF', '#fa520a', '#FFFFFF', '#fc9f78', '#fa520a', '#FFFFFF', '#FFFFFF', '#FFFFFF', '#2593d8', '#25d8c1', '#2593d8', '#25d8c1', '#2593d8', '#25d8c1', '#000000', '', '', '#333333', '', '', '#fa520a', '', '', '', '', 'none', '#be3c03', '', '', '#444444', '', '', '#fa520a', '', '', '#444444', '', '', '#333333', '', '', '', '', '', '', '', '130px', '40px')",
    "images" => array(
    "('', 'image', 'Defaut', 'image_page', 'Black/Black_page.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_barre_entete_arborescence', 'Black/BlackOrange_entete_arborescence.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_impairs', 'Black/BlackApple_bas_impaires.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_entete_page', 'Black/BlackOrange_pied.png', 'left', '24px', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_pied', 'Black/BlackOrange_pied.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_menu_on', 'Black/BlackOrange_entete_liens.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_edito', 'Black/BlackApple_edito.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_titres', 'Black/BlackApple_titres_secteurs.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_edito_titre', 'Black/BlackApple_titre_edito.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_menu_off', 'Black/BlackApple_bas_bloc.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_titre_entete', 'Black/BlackOrange_entete_arborescence.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_bloc', 'Black/BlackApple_bas_bloc.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_pairs', 'Black/BlackApple_bas_paires.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_ecran', 'Black/BlackApple_degrade_noir_gris.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_barre_auteur', 'Black/BlackOrange_entete_arborescence.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'perso', 'Defaut', '#Forum .bouton a:first-letter, .divers h4:first-letter, div#Contenu div.lien:first-letter, div#Contenu div.ps h4:first-letter, div#Contenu div.notes h4:first-letter, div#Contenu h4.titre:first-letter, div#Contenu h3:first-letter, div#Contenu .bloc2 h3:first-letter, div#Contenu .bloc2 h3.titre:first-letter, div#Menu h3:first-letter, .divers h4:first-letter, h3:first-letter, div#Contenu .edito h3.titre:first-letter {font-size:130%;}', '', '', '', '', '')",
    "('', 'perso', 'Defaut', 'div#Contenu .edito h3.titre {border : 1px solid #1F1F1F;}	', '', '', '', '', '')"
    ), ),
'Black Violet' => array(
    /* Th�me cr�� par Olivier Gautier */
    "habillage" => "'eva_style_images_de_fond.css'",
    "theme" => "('', 'Defaut', '#000000', '#252525', '#333333', '#444444', '#000000', '#936cb3', '#5a3c73', '#5a3c73', '#936cb3', '#936cb3', '#455245', '#936cb3', '#5a3c73', '#455245', '#444444', '#333333', '#936cb3', '#5a6958', '#455245', 'georgia', '#FFFFFF', '#FFFFFF', '#d5f5d9', '#d5f5d9', '#CCC', '#FFF', '#CCC', '#FFFFFF', '#d5f5d9', '#c8b3d9', '#FFFFFF', '#936cb3', '#FFFFFF', '#c8b3d9', '#936cb3', '#FFFFFF', '#FFFFFF', '#FFFFFF', '#2593d8', '#25d8c1', '#2593d8', '#25d8c1', '#2593d8', '#25d8c1', '#000000', '', '', '#333333', '', '', '#936cb3', '', '', '', '', 'none', '#5a3c73', '', '', '#444444', '', '', '#936cb3', '', '', '#444444', '', '', '#333333', '', '', '', '', '', '', '', '130px', '40px')",
    "images" => array(
    "('', 'image', 'Defaut', 'image_page', 'Black/Black_page.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_menu_on', 'Black/BlackViolet_entete_liens.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_entete_page', 'Black/BlackViolet_pied.png', 'left', '24px', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_impairs', 'Black/BlackApple_bas_impaires.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_titre_entete', 'Black/BlackViolet_entete_arborescence.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_barre_auteur', 'Black/BlackViolet_entete_arborescence.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_pied', 'Black/BlackViolet_pied.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_titres', 'Black/BlackApple_titres_secteurs.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_edito_titre', 'Black/BlackApple_titre_edito.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_edito', 'Black/BlackApple_edito.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_menu_off', 'Black/BlackApple_bas_bloc.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_bloc', 'Black/BlackApple_bas_bloc.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_barre_entete_arborescence', 'Black/BlackViolet_entete_arborescence.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_pairs', 'Black/BlackApple_bas_paires.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_ecran', 'Black/BlackApple_degrade_noir_gris.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'perso', 'Defaut', '#Forum .bouton a:first-letter, .divers h4:first-letter, div#Contenu div.lien:first-letter, div#Contenu div.ps h4:first-letter, div#Contenu div.notes h4:first-letter, div#Contenu h4.titre:first-letter, div#Contenu h3:first-letter, div#Contenu .bloc2 h3:first-letter, div#Contenu .bloc2 h3.titre:first-letter, div#Menu h3:first-letter, .divers h4:first-letter, h3:first-letter, div#Contenu .edito h3.titre:first-letter {font-size:130%;}', '', '', '', '', '')",
    "('', 'perso', 'Defaut', 'div#Contenu .edito h3.titre {border : 1px solid #1F1F1F;}	', '', '', '', '', '')"
    ), ),
'Black Ocean' => array(
    /* Th�me cr�� par Olivier Gautier */
    "habillage" => "'eva_style_images_de_fond.css'",
    "theme" => "('', 'Defaut', '#000000', '#252525', '#333333', '#444444', '#000000', '#6b60d5', '#312691', '#6b60d5', '#6b60d5', '#6b60d5', '#455245', '#6b60d5', '#312691', '#455245', '#444444', '#333333', '#6b60d5', '#5a6958', '#455245', 'georgia', '#FFFFFF', '#FFFFFF', '#d5f5d9', '#d5f5d9', '#CCC', '#FFF', '#CCC', '#FFFFFF', '#d5f5d9', '#9c95e3', '#b9b4eb', '#6b60d5', '#FFFFFF', '#9c95e3', '#6b60d5', '#FFFFFF', '#FFFFFF', '#FFFFFF', '#2593d8', '#25d8c1', '#2593d8', '#25d8c1', '#2593d8', '#25d8c1', '#000000', '', '', '#333333', '', '', '#6b60d5', '', '', '', '', 'none', '#312691', '', '', '#444444', '', '', '#6b60d5', '', '', '#444444', '', '', '#333333', '', '', '', '', '', '', '', '130px', '40px')",
    "images" => array(
    "('', 'image', 'Defaut', 'image_page', 'Black/Black_page.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_menu_on', 'Black/BlackOcean_entete_liens.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_titres', 'Black/BlackApple_titres_secteurs.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_titre_entete', 'Black/BlackOcean_entete_arborescence.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_pied', 'Black/BlackOcean_pied.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_pairs', 'Black/BlackApple_bas_paires.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_ecran', 'Black/BlackApple_degrade_noir_gris.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_barre_auteur', 'Black/BlackOcean_entete_arborescence.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_impairs', 'Black/BlackApple_bas_impaires.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_entete_page', 'Black/BlackOcean_pied.png', 'left', '24px', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_barre_entete_arborescence', 'Black/BlackOcean_entete_arborescence.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_edito', 'Black/BlackApple_edito.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_menu_off', 'Black/BlackApple_bas_bloc.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_bloc', 'Black/BlackApple_bas_bloc.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_edito_titre', 'Black/BlackApple_titre_edito.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'perso', 'Defaut', '#Forum .bouton a:first-letter, .divers h4:first-letter, div#Contenu div.lien:first-letter, div#Contenu div.ps h4:first-letter, div#Contenu div.notes h4:first-letter, div#Contenu h4.titre:first-letter, div#Contenu h3:first-letter, div#Contenu .bloc2 h3:first-letter, div#Contenu .bloc2 h3.titre:first-letter, div#Menu h3:first-letter, .divers h4:first-letter, h3:first-letter, div#Contenu .edito h3.titre:first-letter {font-size:130%;}', '', '', '', '', '')",
    "('', 'perso', 'Defaut', 'div#Contenu .edito h3.titre {border : 1px solid #1F1F1F;}	', '', '', '', '', '')"
    ), ),
'Black Pig' => array(
    /* Th�me cr�� par Olivier Gautier */
    "habillage" => "'eva_style_images_de_fond.css'",
    "theme" => "('', 'Defaut', '#000000', '#252525', '#333333', '#444444', '#000000', '#f341a8', '#8a0953', '#f341a8', '#f341a8', '#f341a8', '#455245', '#f341a8', '#8a0953', '#455245', '#444444', '#333333', '#f341a8', '#5a6958', '#455245', 'georgia', '#FFFFFF', '#FFFFFF', '#d5f5d9', '#d5f5d9', '#CCC', '#FFF', '#CCC', '#FFFFFF', '#d5f5d9', '#f892cc', '#fbbde0', '#f341a8', '#FFFFFF', '#f892cc', '#f341a8', '#FFFFFF', '#FFFFFF', '#FFFFFF', '#2593d8', '#25d8c1', '#2593d8', '#25d8c1', '#2593d8', '#25d8c1', '#000000', '', '', '#333333', '', '', '#f341a8', '', '', '', '', 'none', '#312691', '', '', '#444444', '', '', '#f341a8', '', '', '#444444', '', '', '#333333', '', '', '', '', '', '', '', '130px', '40px')",
    "images" => array(
    "('', 'image', 'Defaut', 'image_page', 'Black/Black_page.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_edito_titre', 'Black/BlackApple_titre_edito.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_bloc', 'Black/BlackApple_bas_bloc.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_menu_off', 'Black/BlackApple_bas_bloc.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_edito', 'Black/BlackApple_edito.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_impairs', 'Black/BlackApple_bas_impaires.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_pied', 'Black/BlackPink_pied.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_menu_on', 'Black/BlackPink_entete_liens.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_ecran', 'Black/BlackApple_degrade_noir_gris.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_pairs', 'Black/BlackApple_bas_paires.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_titre_entete', 'Black/BlackPink_entete_arborescence.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_barre_auteur', 'Black/BlackPink_entete_arborescence.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_titres', 'Black/BlackApple_titres_secteurs.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_entete_page', 'Black/BlackPink_pied.png', 'left', '24px', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_barre_entete_arborescence', 'Black/BlackPink_entete_arborescence.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'perso', 'Defaut', '#Forum .bouton a:first-letter, .divers h4:first-letter, div#Contenu div.lien:first-letter, div#Contenu div.ps h4:first-letter, div#Contenu div.notes h4:first-letter, div#Contenu h4.titre:first-letter, div#Contenu h3:first-letter, div#Contenu .bloc2 h3:first-letter, div#Contenu .bloc2 h3.titre:first-letter, div#Menu h3:first-letter, .divers h4:first-letter, h3:first-letter, div#Contenu .edito h3.titre:first-letter {font-size:130%;}', '', '', '', '', '')",
    "('', 'perso', 'Defaut', 'div#Contenu .edito h3.titre {border : 1px solid #1F1F1F;}	', '', '', '', '', '')"
    ), ),
'Black Violet Pig' => array(
    /* Th�me cr�� par Olivier Gautier */
    "habillage" => "'eva_style_images_de_fond.css'",
    "theme" => "('', 'Defaut', '#000000', '#252525', '#333333', '#444444', '#000000', '#800080', '#ff95ff', '#ff95ff', '#800080', '#800080', '#455245', '#800080', '#ff95ff', '#455245', '#444444', '#333333', '#800080', '#5a6958', '#455245', 'georgia', '#FFFFFF', '#FFFFFF', '#d5f5d9', '#d5f5d9', '#CCC', '#FFF', '#CCC', '#FFFFFF', '#d5f5d9', '#f892cc', '#fbbde0', '#800080', '#FFFFFF', '#f892cc', '#800080', '#222222', '#FFFFFF', '#222222', '#2593d8', '#25d8c1', '#2593d8', '#25d8c1', '#2593d8', '#25d8c1', '#000000', '', '', '#333333', '', '', '#800080', '', '', '', '', 'none', '#ff95ff', '', '', '#800080', '', '', '#800080', '', '', '#444444', '', '', '#333333', '', '', '', '', '', '', '', '130px', '40px')",
    "images" => array(
    "('', 'perso', 'Defaut', '#Forum .bouton a:first-letter, .divers h4:first-letter, div#Contenu div.lien:first-letter, div#Contenu div.ps h4:first-letter, div#Contenu div.notes h4:first-letter, div#Contenu h4.titre:first-letter, div#Contenu h3:first-letter, div#Contenu .bloc2 h3:first-letter, div#Contenu .bloc2 h3.titre:first-letter, div#Menu h3:first-letter, .divers h4:first-letter, h3:first-letter, div#Contenu .edito h3.titre:first-letter {font-size:130%;}', '', '', '', '', '')",
    "('', 'image', 'Defaut', 'image_titre_entete', 'Black/BlackPig2_entete_liens.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_pied', 'Black/BlackPig2_pied.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_entete_page', 'Black/BlackPig2_pied.png', 'left', '24px', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_titres', 'Black/BlackApple_titres_secteurs.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_barre_auteur', 'Black/BlackPig2_entete_liens.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_pairs', 'Black/BlackApple_bas_paires.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_ecran', 'Black/BlackApple_degrade_noir_gris.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_menu_on', 'Black/BlackPig2_entete_arborescence.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_barre_entete_arborescence', 'Black/BlackPig2_entete_liens.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_impairs', 'Black/BlackApple_bas_impaires.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_edito_titre', 'Black/BlackApple_titre_edito.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_bloc', 'Black/BlackApple_bas_bloc.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_menu_off', 'Black/BlackApple_bas_bloc.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_edito', 'Black/BlackApple_edito.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_page', 'Black/Black_page.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'perso', 'Defaut', 'div#Contenu .edito h3.titre {border : 1px solid #1F1F1F;}	', '', '', '', '', '')"
    ), ),
'Black is Black' => array(
    /* Th�me cr�� par Olivier Gautier */
    "habillage" => "'eva_style_images_de_fond.css'",
    "theme" => "('', 'Defaut', '#000000', '#252525', '#333333', '#444444', '#000000', '#777777', '#000000', '#777777', '#777777', '#777777', '#455245', '#777777', '#000000', '#455245', '#444444', '#333333', '#777777', '#5a6958', '#455245', 'georgia', '#FFFFFF', '#FFFFFF', '#FFFFFF', '#FFFFFF', '#CCC', '#FFF', '#CCC', '#FFFFFF', '#000000', '#000000', '#FFFFFF', '#AAAAAA', '#FFFFFF', '#FFFFFF', '#AAAAAA', '#FFFFFF', '#FFFFFF', '#FFFFFF', '#2593d8', '#25d8c1', '#2593d8', '#25d8c1', '#2593d8', '#25d8c1', '#000000', '', '', '#333333', '', '', '#777777', '', '', '', '', 'none', '#777777', '', '', '#444444', '', '', '#777777', '', '', '#444444', '', '', '#333333', '', '', '', '', '', '', '', '130px', '40px')",
    "images" => array(
    "('', 'image', 'Defaut', 'image_page', 'Black/Black_page.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_edito_titre', 'Black/BlackApple_titre_edito.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_edito', 'Black/BlackApple_edito.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_menu_off', 'Black/BlackApple_bas_bloc.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_pairs', 'Black/BlackApple_bas_paires.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_bloc', 'Black/BlackApple_bas_bloc.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_ecran', 'Black/BlackApple_degrade_noir_gris.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_pied', 'Black/BlackIsBlack_pied.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_menu_on', 'Black/BlackIsBlack_entete_liens.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_impairs', 'Black/BlackApple_bas_impaires.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_titre_entete', 'Black/BlackIsBlack_entete_arborescence.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_entete_page', 'Black/BlackIsBlack_pied.png', 'left', '24px', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_barre_entete_arborescence', 'Black/BlackIsBlack_entete_arborescence.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_barre_auteur', 'Black/BlackIsBlack_entete_arborescence.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_titres', 'Black/BlackApple_titres_secteurs.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'perso', 'Defaut', '#Forum .bouton a:first-letter, .divers h4:first-letter, div#Contenu div.lien:first-letter, div#Contenu div.ps h4:first-letter, div#Contenu div.notes h4:first-letter, div#Contenu h4.titre:first-letter, div#Contenu h3:first-letter, div#Contenu .bloc2 h3:first-letter, div#Contenu .bloc2 h3.titre:first-letter, div#Menu h3:first-letter, .divers h4:first-letter, h3:first-letter, div#Contenu .edito h3.titre:first-letter {font-size:130%;}', '', '', '', '', '')",
    "('', 'perso', 'Defaut', 'div#Contenu .edito h3.titre {border : 1px solid #1F1F1F;}	', '', '', '', '', '')"
    ), ),
'Black Tree' => array(
    /* Th�me cr�� par Olivier Gautier */
    "habillage" => "'eva_style_images_de_fond.css'",
    "theme" => "('', 'Defaut', '#000000', '#252525', '#333333', '#444444', '#000000', '#bb6c64', '#6d3630', '#bb6c64', '#bb6c64', '#bb6c64', '#455245', '#bb6c64', '#6d3630', '#455245', '#444444', '#333333', '#bb6c64', '#5a6958', '#455245', 'georgia', '#FFFFFF', '#FFFFFF', '#FFFFFF', '#edd8d6', '#CCC', '#FFF', '#CCC', '#FFFFFF', '#edd8d6', '#e7ccc9', '#edd8d6', '#bb6c64', '#FFFFFF', '#e7ccc9', '#bb6c64', '#FFFFFF', '#FFFFFF', '#FFFFFF', '#2593d8', '#25d8c1', '#2593d8', '#25d8c1', '#2593d8', '#25d8c1', '#000000', '', '', '#333333', '', '', '#bb6c64', '', '', '', '', 'none', '#bb6c64', '', '', '#444444', '', '', '#bb6c64', '', '', '#444444', '', '', '#333333', '', '', '', '', '', '', '', '130px', '40px')",
    "images" => array(
    "('', 'image', 'Defaut', 'image_page', 'Black/Black_page.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'perso', 'Defaut', 'div#Contenu .edito h3.titre {border : 1px solid #1F1F1F;}	', '', '', '', '', '')",
    "('', 'image', 'Defaut', 'image_menu_on', 'Black/BlackBrown_entete_liens.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'perso', 'Defaut', '#Forum .bouton a:first-letter, .divers h4:first-letter, div#Contenu div.lien:first-letter, div#Contenu div.ps h4:first-letter, div#Contenu div.notes h4:first-letter, div#Contenu h4.titre:first-letter, div#Contenu h3:first-letter, div#Contenu .bloc2 h3:first-letter, div#Contenu .bloc2 h3.titre:first-letter, div#Menu h3:first-letter, .divers h4:first-letter, h3:first-letter, div#Contenu .edito h3.titre:first-letter {font-size:130%;}', '', '', '', '', '')",
    "('', 'image', 'Defaut', 'image_titres', 'Black/BlackApple_titres_secteurs.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_barre_auteur', 'Black/BlackBrown_entete_arborescence.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_titre_entete', 'Black/BlackBrown_entete_arborescence.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_impairs', 'Black/BlackApple_bas_impaires.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_ecran', 'Black/BlackApple_degrade_noir_gris.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_pied', 'Black/BlackBrown_pied.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_bloc', 'Black/BlackApple_bas_bloc.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_barre_entete_arborescence', 'Black/BlackBrown_entete_arborescence.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_pairs', 'Black/BlackApple_bas_paires.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_entete_page', 'Black/BlackBrown_pied.png', 'left', '24px', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_edito_titre', 'Black/BlackApple_titre_edito.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_edito', 'Black/BlackApple_edito.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_menu_off', 'Black/BlackApple_bas_bloc.png', 'left', 'bottom', 'repeat-x', 'scroll')"
    ), ),
'Black Sky' => array(
    /* Th�me cr�� par Olivier Gautier */
    "habillage" => "'eva_style_images_de_fond.css'",
    "theme" => "('', 'Defaut', '#000000', '#252525', '#333333', '#444444', '#000000', '#39eae6', '#109895', '#39eae6', '#39eae6', '#39eae6', '#455245', '#39eae6', '#109895', '#455245', '#444444', '#333333', '#39eae6', '#5a6958', '#455245', 'georgia', '#FFFFFF', '#FFFFFF', '#FFFFFF', '#222222', '#CCC', '#FFF', '#CCC', '#cffaf9', '#222222', '#62eeeb', '#cffaf9', '#39eae6', '#FFFFFF', '#cffaf9', '#39eae6', '#FFFFFF', '#222222', '#222222', '#2593d8', '#25d8c1', '#2593d8', '#25d8c1', '#2593d8', '#25d8c1', '#000000', '', '', '#333333', '', '', '#39eae6', '', '', '', '', 'none', '#39eae6', '', '', '#444444', '', '', '#39eae6', '', '', '#444444', '', '', '#333333', '', '', '', '', '', '', '', '130px', '40px')",
    "images" => array(
    "('', 'image', 'Defaut', 'image_menu_off', 'Black/BlackApple_bas_bloc.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_page', 'Black/Black_page.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'perso', 'Defaut', 'div#Contenu .edito h3.titre {border : 1px solid #1F1F1F;}	', '', '', '', '', '')",
    "('', 'image', 'Defaut', 'image_menu_on', 'Black/BlackSky_entete_liens.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'perso', 'Defaut', '#Forum .bouton a:first-letter, .divers h4:first-letter, div#Contenu div.lien:first-letter, div#Contenu div.ps h4:first-letter, div#Contenu div.notes h4:first-letter, div#Contenu h4.titre:first-letter, div#Contenu h3:first-letter, div#Contenu .bloc2 h3:first-letter, div#Contenu .bloc2 h3.titre:first-letter, div#Menu h3:first-letter, .divers h4:first-letter, h3:first-letter, div#Contenu .edito h3.titre:first-letter {font-size:130%;}', '', '', '', '', '')",
    "('', 'image', 'Defaut', 'image_edito', 'Black/BlackApple_edito.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_pied', 'Black/BlackSky_pied.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_edito_titre', 'Black/BlackApple_titre_edito.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_titre_entete', 'Black/BlackSky_entete_arborescence.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_pairs', 'Black/BlackApple_bas_paires.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_bloc', 'Black/BlackApple_bas_bloc.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_ecran', 'Black/BlackApple_degrade_noir_gris.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_impairs', 'Black/BlackApple_bas_impaires.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_entete_page', 'Black/BlackSky_pied.png', 'left', '24px', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_barre_entete_arborescence', 'Black/BlackSky_entete_arborescence.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_barre_auteur', 'Black/BlackSky_entete_arborescence.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_titres', 'Black/BlackApple_titres_secteurs.png', 'left', 'bottom', 'repeat-x', 'scroll')"
    ), ),
'Black Grey Sky' => array(
    /* Th�me cr�� par Olivier Gautier */
    "habillage" => "'eva_style_images_de_fond.css'",
    "theme" => "('', 'Defaut', '#000000', '#252525', '#333333', '#444444', '#000000', '#3a7474', '#8bc5c5', '#8bc5c5', '#3a7474', '#3a7474', '#455245', '#3a7474', '#8bc5c5', '#455245', '#444444', '#333333', '#3a7474', '#5a6958', '#455245', 'georgia', '#FFFFFF', '#FFFFFF', '#FFFFFF', '#FFFFFF', '#CCC', '#FFF', '#CCC', '#FFFFFF', '#b6dada', '#b6dada', '#FFFFFF', '#3a7474', '#FFFFFF', '#FFFFFF', '#3a7474', '#333333', '#FFFFFF', '#333333', '#2593d8', '#25d8c1', '#2593d8', '#25d8c1', '#2593d8', '#25d8c1', '#000000', '', '', '#333333', '', '', '#3a7474', '', '', '', '', 'none', '#3a7474', '', '', '#444444', '', '', '#3a7474', '', '', '#444444', '', '', '#333333', '', '', '', '', '', '', '', '130px', '40px')",
    "images" => array(
    "('', 'perso', 'Defaut', '#Forum .bouton a:first-letter, .divers h4:first-letter, div#Contenu div.lien:first-letter, div#Contenu div.ps h4:first-letter, div#Contenu div.notes h4:first-letter, div#Contenu h4.titre:first-letter, div#Contenu h3:first-letter, div#Contenu .bloc2 h3:first-letter, div#Contenu .bloc2 h3.titre:first-letter, div#Menu h3:first-letter, .divers h4:first-letter, h3:first-letter, div#Contenu .edito h3.titre:first-letter {font-size:130%;}', '', '', '', '', '')",
    "('', 'image', 'Defaut', 'image_edito_titre', 'Black/BlackApple_titre_edito.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_edito', 'Black/BlackApple_edito.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_menu_off', 'Black/BlackApple_bas_bloc.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_bloc', 'Black/BlackApple_bas_bloc.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_pairs', 'Black/BlackApple_bas_paires.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_ecran', 'Black/BlackApple_degrade_noir_gris.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_pied', 'Black/BlackGreySky_pied.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_menu_on', 'Black/BlackGreySky_entete_liens.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_impairs', 'Black/BlackApple_bas_impaires.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_titre_entete', 'Black/BlackGreySky_entete_arborescence.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_entete_page', 'Black/BlackGreySky_pied.png', 'left', '24px', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_titres', 'Black/BlackApple_titres_secteurs.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_barre_auteur', 'Black/BlackGreySky_entete_arborescence.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_barre_entete_arborescence', 'Black/BlackGreySky_entete_arborescence.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_page', 'Black/Black_page.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'perso', 'Defaut', 'div#Contenu .edito h3.titre {border : 1px solid #1F1F1F;}	', '', '', '', '', '')"
    ), ),
'Black Salmon' => array(
    /* Th�me cr�� par Olivier Gautier */
    "habillage" => "'eva_style_images_de_fond.css'",
    "theme" => "('', 'Defaut', '#000000', '#252525', '#333333', '#444444', '#000000', '#fda971', '#ee6102', '#ee6102', '#fda971', '#fda971', '#455245', '#fda971', '#ee6102', '#455245', '#444444', '#333333', '#fda971', '#5a6958', '#455245', 'georgia', '#FFFFFF', '#FFFFFF', '#d5f5d9', '#222222', '#CCC', '#FFF', '#CCC', '#FFFFFF', '#222222', '#fec49c', '#fec49c', '#fda971', '#FFFFFF', '#fec49c', '#fda971', '#222222', '#222222', '#111111', '#2593d8', '#25d8c1', '#2593d8', '#25d8c1', '#2593d8', '#25d8c1', '#000000', '', '', '#333333', '', '', '#fda971', '', '', '', '', 'none', '#fda971', '', '', '#444444', '', '', '#fda971', '', '', '#444444', '', '', '#333333', '', '', '', '', '', '', '', '130px', '40px')",
    "images" => array(
    "('', 'image', 'Defaut', 'image_menu_off', 'Black/BlackApple_bas_bloc.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_page', 'Black/Black_page.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_bloc', 'Black/BlackApple_bas_bloc.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_edito', 'Black/BlackApple_edito.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_menu_on', 'Black/BlackSalmon_entete_liens.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_edito_titre', 'Black/BlackApple_titre_edito.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_pairs', 'Black/BlackApple_bas_paires.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_barre_entete_arborescence', 'Black/BlackSalmon_entete_arborescence.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_ecran', 'Black/BlackApple_degrade_noir_gris.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_barre_auteur', 'Black/BlackSalmon_entete_arborescence.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_titre_entete', 'Black/BlackSalmon_entete_arborescence.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_entete_page', 'Black/BlackSalmon_pied.png', 'left', '24px', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_impairs', 'Black/BlackApple_bas_impaires.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_titres', 'Black/BlackApple_titres_secteurs.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'perso', 'Defaut', 'div#Contenu .edito h3.titre {border : 1px solid #1F1F1F;}	', '', '', '', '', '')",
    "('', 'image', 'Defaut', 'image_pied', 'Black/BlackSalmon_pied.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'perso', 'Defaut', '#Forum .bouton a:first-letter, .divers h4:first-letter, div#Contenu div.lien:first-letter, div#Contenu div.ps h4:first-letter, div#Contenu div.notes h4:first-letter, div#Contenu h4.titre:first-letter, div#Contenu h3:first-letter, div#Contenu .bloc2 h3:first-letter, div#Contenu .bloc2 h3.titre:first-letter, div#Menu h3:first-letter, .divers h4:first-letter, h3:first-letter, div#Contenu .edito h3.titre:first-letter {font-size:130%;}', '', '', '', '', '')"
    ), ),
'Black Pink Lady' => array(
    /* Th�me cr�� par Olivier Gautier */
    "habillage" => "'eva_style_images_de_fond.css'",
    "theme" => "('', 'Defaut', '#000000', '#252525', '#333333', '#444444', '#000000', '#92e043', '#fe85a6', '#92e043', '#92e043', '#92e043', '#455245', '#92e043', '#fe85a6', '#455245', '#fe85a6', '#333333', '#92e043', '#5a6958', '#455245', 'georgia', '#FFFFFF', '#FFFFFF', '#FFFFFF', '#222222', '#CCC', '#FFF', '#CCC', '#FFFFFF', '#222222', '#cbb077', '#cbb077', '#fe85a6', '#FFFFFF', '#cbb077', '#fe85a6', '#222222', '#FFFFFF', '#222222', '#2593d8', '#25d8c1', '#2593d8', '#25d8c1', '#2593d8', '#25d8c1', '#000000', '', '', '#333333', '', '', '#92e043', '', '', '', '', 'none', '#92e043', '', '', '#444444', '', '', '#92e043', '', '', '#444444', '', '', '#333333', '', '', '', '', '', '', '', '130px', '40px')",
    "images" => array(
    "('', 'perso', 'Defaut', 'div#Contenu .edito h3.titre {border : 1px solid #1F1F1F;}	', '', '', '', '', '')",
    "('', 'perso', 'Defaut', '#Forum .bouton a:first-letter, .divers h4:first-letter, div#Contenu div.lien:first-letter, div#Contenu div.ps h4:first-letter, div#Contenu div.notes h4:first-letter, div#Contenu h4.titre:first-letter, div#Contenu h3:first-letter, div#Contenu .bloc2 h3:first-letter, div#Contenu .bloc2 h3.titre:first-letter, div#Menu h3:first-letter, .divers h4:first-letter, h3:first-letter, div#Contenu .edito h3.titre:first-letter {font-size:130%;}', '', '', '', '', '')",
    "('', 'image', 'Defaut', 'image_edito_titre', 'Black/BlackApple_titre_edito.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_edito', 'Black/BlackApple_edito.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_menu_off', 'Black/BlackApple_bas_bloc.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_bloc', 'Black/BlackApple_bas_bloc.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_pairs', 'Black/BlackApple_bas_paires.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_ecran', 'Black/BlackApple_degrade_noir_gris.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_menu', 'Black/BlackPinkLady_pied.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_barre_auteur', 'Black/BlackPinkLady_entete_arborescence.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_titre_entete', 'Black/BlackPinkLady_entete_arborescence.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_impairs', 'Black/BlackApple_bas_impaires.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_pied', 'Black/BlackPinkLady_pied.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_menu_on', 'Black/BlackPinkLady_entete_liens.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_entete_page', 'Black/BlackPinkLady_pied.png', 'left', '24px', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_titres', 'Black/BlackApple_titres_secteurs.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_page', 'Black/Black_page.png', 'left', 'bottom', 'repeat-x', 'scroll')"
    ), ),
'Black Green Purple' => array(
    /* Th�me cr�� par Olivier Gautier */
    "habillage" => "'eva_style_images_de_fond.css'",
    "theme" => "('', 'Defaut', '#000000', '#252525', '#333333', '#444444', '#000000', '#6d1fbc', '#92e043', '#6d1fbc', '#6d1fbc', '#6d1fbc', '#455245', '#6d1fbc', '#92e043', '#455245', '#444444', '#333333', '#6d1fbc', '#5a6958', '#455245', 'georgia', '#FFFFFF', '#FFFFFF', '#d5f5d9', '#222222', '#CCC', '#FFF', '#CCC', '#FFFFFF', '#d5f5d9', '#a768e6', '#b783eb', '#6d1fbc', '#FFFFFF', '#b783eb', '#6d1fbc', '#222222', '#222222', '#222222', '#2593d8', '#6d1fbc', '#2593d8', '#25d8c1', '#2593d8', '#25d8c1', '#000000', '', '', '#333333', '', '', '#6d1fbc', '', '', '', '', 'none', '#6d1fbc', '', '', '#444444', '', '', '#6d1fbc', '', '', '#444444', '', '', '#333333', '', '', '', '', '', '', '', '130px', '40px')",
    "images" => array(
    "('', 'perso', 'Defaut', 'div#Contenu .edito h3.titre {border : 1px solid #1F1F1F;}	', '', '', '', '', '')",
    "('', 'perso', 'Defaut', '#Forum .bouton a:first-letter, .divers h4:first-letter, div#Contenu div.lien:first-letter, div#Contenu div.ps h4:first-letter, div#Contenu div.notes h4:first-letter, div#Contenu h4.titre:first-letter, div#Contenu h3:first-letter, div#Contenu .bloc2 h3:first-letter, div#Contenu .bloc2 h3.titre:first-letter, div#Menu h3:first-letter, .divers h4:first-letter, h3:first-letter, div#Contenu .edito h3.titre:first-letter {font-size:130%;}', '', '', '', '', '')",
    "('', 'image', 'Defaut', 'image_titre_entete', 'Black/BlackGreenPurple_entete_arborescence.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_pied', 'Black/BlackGreenPurple_pied.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_titres', 'Black/BlackApple_titres_secteurs.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_menu_on', 'Black/BlackGreenPurple_entete_liens.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_impairs', 'Black/BlackApple_bas_impaires.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_barre_auteur', 'Black/BlackGreenPurple_entete_arborescence.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_ecran', 'Black/BlackApple_degrade_noir_gris.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_entete_page', 'Black/BlackGreenPurple_pied.png', 'left', '24px', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_pairs', 'Black/BlackApple_bas_paires.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_barre_entete_arborescence', 'Black/BlackGreenPurple_entete_arborescence.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_edito_titre', 'Black/BlackApple_titre_edito.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_edito', 'Black/BlackApple_edito.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_menu_off', 'Black/BlackApple_bas_bloc.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_bloc', 'Black/BlackApple_bas_bloc.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_page', 'Black/Black_page.png', 'left', 'bottom', 'repeat-x', 'scroll')"
    ), ),
'Black Submarine' => array(
    /* Th�me cr�� par Olivier Gautier */
    "habillage" => "'eva_style_images_de_fond.css'",
    "theme" => "('', 'Defaut', '#000000', '#252525', '#333333', '#444444', '#000000', '#0000ff', '#ffff00', '#ffff00', '#0000ff', '#0000ff', '#455245', '#0000ff', '#ffff00', '#455245', '#444444', '#333333', '#0000ff', '#5a6958', '#455245', 'georgia', '#FFFFFF', '#FFFFFF', '#d5f5d9', '#d5f5d9', '#CCC', '#FFF', '#CCC', '#FFFFFF', '#d5f5d9', '#cbf3ef', '#d5f5d9', '#0000ff', '#FFFFFF', '#d5f5d9', '#0000ff', '#222222', '#FFFFFF', '#111111', '#2593d8', '#25d8c1', '#2593d8', '#25d8c1', '#2593d8', '#25d8c1', '#000000', '', '', '#333333', '', '', '#0000ff', '', '', '', '', 'none', '#0000ff', '', '', '#444444', '', '', '#0000ff', '', '', '#444444', '', '', '#333333', '', '', '', '', '', '', '', '130px', '40px')",
    "images" => array(
    "('', 'perso', 'Defaut', 'div#Contenu .edito h3.titre {border : 1px solid #1F1F1F;}	', '', '', '', '', '')",
    "('', 'image', 'Defaut', 'image_titres', 'Black/BlackApple_titres_secteurs.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_menu_on', 'Black/BlackYellowBleu_entete_liens.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'perso', 'Defaut', '#Forum .bouton a:first-letter, .divers h4:first-letter, div#Contenu div.lien:first-letter, div#Contenu div.ps h4:first-letter, div#Contenu div.notes h4:first-letter, div#Contenu h4.titre:first-letter, div#Contenu h3:first-letter, div#Contenu .bloc2 h3:first-letter, div#Contenu .bloc2 h3.titre:first-letter, div#Menu h3:first-letter, .divers h4:first-letter, h3:first-letter, div#Contenu .edito h3.titre:first-letter {font-size:130%;}', '', '', '', '', '')",
    "('', 'image', 'Defaut', 'image_pied', 'Black/BlackYellowBleu_pied.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_impairs', 'Black/BlackApple_bas_impaires.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_titre_entete', 'Black/BlackYellowBleu_entete_arborescence.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_barre_auteur', 'Black/BlackYellowBleu_entete_arborescence.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_ecran', 'Black/BlackApple_degrade_noir_gris.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_entete_page', 'Black/BlackYellowBleu_pied.png', 'left', '24px', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_pairs', 'Black/BlackApple_bas_paires.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_barre_entete_arborescence', 'Black/BlackYellowBleu_entete_arborescence.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_edito_titre', 'Black/BlackApple_titre_edito.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_edito', 'Black/BlackApple_edito.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_menu_off', 'Black/BlackApple_bas_bloc.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_bloc', 'Black/BlackApple_bas_bloc.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_page', 'Black/Black_page.png', 'left', 'bottom', 'repeat-x', 'scroll')"
    ), ),
'Black Sunrise' => array(
    /* Th�me cr�� par Olivier Gautier */
    "habillage" => "'eva_style_images_de_fond.css'",
    "theme" => "('', 'Defaut', '#000000', '#252525', '#333333', '#444444', '#000000', '#ff0000', '#ffff00', '#ffff00', '#ff0000', '#ff0000', '#455245', '#ff0000', '#ffff00', '#455245', '#444444', '#333333', '#ff0000', '#5a6958', '#455245', 'georgia', '#FFFFFF', '#FFFFFF', '#d5f5d9', '#d5f5d9', '#CCC', '#FFF', '#CCC', '#FFFFFF', '#ffb9b9', '#ffb9b9', '#ffb9b9', '#ff0000', '#FFFFFF', '#ffb9b9', '#ff0000', '#222222', '#222222', '#111111', '#2593d8', '#25d8c1', '#2593d8', '#25d8c1', '#2593d8', '#25d8c1', '#000000', '', '', '#333333', '', '', '#ff0000', '', '', '', '', 'none', '#ff0000', '', '', '#444444', '', '', '#ff0000', '', '', '#444444', '', '', '#333333', '', '', '', '', '', '', '', '130px', '40px')",
    "images" => array(
    "('', 'perso', 'Defaut', 'div#Contenu .edito h3.titre {border : 1px solid #1F1F1F;}	', '', '', '', '', '')",
    "('', 'image', 'Defaut', 'image_titres', 'Black/BlackApple_titres_secteurs.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_menu_on', 'Black/BlackYellowRed_entete_arborescence.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'perso', 'Defaut', '#Forum .bouton a:first-letter, .divers h4:first-letter, div#Contenu div.lien:first-letter, div#Contenu div.ps h4:first-letter, div#Contenu div.notes h4:first-letter, div#Contenu h4.titre:first-letter, div#Contenu h3:first-letter, div#Contenu .bloc2 h3:first-letter, div#Contenu .bloc2 h3.titre:first-letter, div#Menu h3:first-letter, .divers h4:first-letter, h3:first-letter, div#Contenu .edito h3.titre:first-letter {font-size:130%;}', '', '', '', '', '')",
    "('', 'image', 'Defaut', 'image_pied', 'Black/BlackYellowRed_pied.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_impairs', 'Black/BlackApple_bas_impaires.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_titre_entete', 'Black/BlackYellowRed_entete_liens.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_barre_auteur', 'Black/BlackYellowRed_entete_liens.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_ecran', 'Black/BlackApple_degrade_noir_gris.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_entete_page', 'Black/BlackYellowRed_pied.png', 'left', '24px', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_pairs', 'Black/BlackApple_bas_paires.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_barre_entete_arborescence', 'Black/BlackYellowRed_entete_liens.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_edito_titre', 'Black/BlackApple_titre_edito.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_edito', 'Black/BlackApple_edito.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_menu_off', 'Black/BlackApple_bas_bloc.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_bloc', 'Black/BlackApple_bas_bloc.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_page', 'Black/Black_page.png', 'left', 'bottom', 'repeat-x', 'scroll')"
    ), ),
'Plage' => array(
    /* Th�me cr�� par Olivier Gautier */
    "habillage" => "'0'",
    "theme" => "('', 'Defaut', '#f9ebb9', '#f9ebb9', '', '#a27c4b', 'transparent', '#f9ebb9', '#f9ebb9', '#f9ebb9', '#f9ebb9', 'transparent', 'transparent', '#f9ebb9', '#a27c4b', '', '#FFF', '#f9ebb9', '#fbf1ce', '#f9ebb9', '#FFF', 'georgia', '#111', '#a27c4b', '#111', '#444', '#a27c4b', '#111', '#a27c4b', '#111', '#111', '#a27c4b', '#111', '#a27c4b', '#FFF', '#111', '#a27c4b', '#111', '#111', '#111', '#ff8448', '#a27c4b', '#a27c4b', '#111', '#111', '#a27c4b', '#f9ebb9', '', '', '#444', '', '', '#f9ebb9', '', '', '', '', 'none', '#444', '', '', '#444', '', '', '#f9ebb9', '', '', '#444', '', '', '#444', '', '', '', '', '', '', '', '', '')",
    "images" => array(
    "('', 'image', 'Defaut', 'image_edito', 'Plage/fond_edito.jpg', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_entete_page', 'Plage/fond_entete.jpg', 'left', 'bottom', 'no-repeat', 'scroll')",
    "('', 'image', 'Defaut', 'image_pied', 'Plage/Fond_pied.gif', 'left', 'top', 'no-repeat', 'scroll')",
    "('', 'image', 'Defaut', 'image_barre_entete', 'Plage/Fond_bouton.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'perso', 'Defaut', 'div#Menu {padding-left:0px;}', '', '', '', '', '')",
    "('', 'image', 'Defaut', 'image_ecran', 'Plage/poisson4.gif', 'right', 'bottom', 'no-repeat', 'fixed')",
    "('', 'image', 'Defaut', 'image_barre_entete_arborescence', 'Plage/Fond_arborescence.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_page', 'Plage/Poisson1.gif', 'left', 'bottom', 'no-repeat', 'scroll')",
    "('', 'perso', 'Defaut', 'div#Entete h1 span, div#Entete h2 span{border-style:none;}', '', '', '', '', '')",
    "('', 'image', 'Defaut', 'image_menu_on', 'Plage/poisson7.gif', 'right', 'bottom', 'no-repeat', 'scroll')",
    "('', 'image', 'Defaut', 'image_impairs', 'Plage/Liste_impaire.png', 'right', 'top', 'no-repeat', 'scroll')",
    "('', 'perso', 'Defaut', 'div#Contenu, div#Conteneur {margin-right:0; padding-right:0;}', '', '', '', '', '')",
    "('', 'perso', 'Defaut', 'div#Page{padding:0;}', '', '', '', '', '')",
    "('', 'image', 'Defaut', 'image_bloc', 'Plage/poisson13.gif', 'left', 'bottom', 'no-repeat', 'scroll')",
    "('', 'image', 'Defaut', 'image_barre_auteur', 'Plage/poisson15.gif', 'right', 'top', 'no-repeat', 'scroll')",
    "('', 'image', 'Defaut', 'image_menu_off', 'Plage/Menu_off.png', 'right', 'bottom', 'no-repeat', 'scroll')",
    "('', 'image', 'Defaut', 'image_pairs', 'Plage/Liste_paire.png', 'right', 'top', 'no-repeat', 'scroll')"
    ), ),
'Plage 2' => array(
    /* Th�me cr�� par Olivier Gautier */
    "habillage" => "'0'",
    "theme" => "('', 'Defaut', '#f9ebb9', 'transparent', '#FFF', '#FFF', 'transparent', '#f9ebb9', '#f9ebb9', '#f9ebb9', '#f9ebb9', 'transparent', 'transparent', '#f9ebb9', '#a27c4b', '#f9ebb9', '#FFF', '#f9ebb9', '#fbf1ce', '#f9ebb9', '#FFF', 'georgia', '#111', '#a27c4b', '#111', '#111', '#a27c4b', '#111', '#a27c4b', '#111', '#111', '#a27c4b', '#111', '#a27c4b', '#111', '#111', '#a27c4b', '#111', '#111', '#111', '#ff8448', '#a27c4b', '#a27c4b', '#111', '#111', '#a27c4b', 'transparent', '1px', '', 'none', '1px', '', '#111', '1px', '', '', '', '', '#444', '1px', '', 'none', '1px', '', '', '', '', '#444', '1px', '', '#444', '1px', '', '', '', '', '', '', '', '')",
    "images" => array(
    "('', 'perso', 'Defaut', 'ul.liens {height:21px;}', '', '', '', '', '')",
    "('', 'image', 'Defaut', 'image_entete_page', 'Plage/haut_center.jpg', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'perso', 'Defaut', 'div#Entete {height:269px;}', '', '', '', '', '')",
    "('', 'image', 'Defaut', 'image_barre_entete', 'Plage/haut_top.jpg', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'perso', 'Defaut', 'ul.liens {line-height:21px;}', '', '', '', '', '')",
    "('', 'perso', 'Defaut', 'div#Contenu {border-bottom: 1px solid #111;}', '', '', '', '', '')",
    "('', 'perso', 'Defaut', 'body {margin-top:0; margin-bottom:0;}', '', '', '', '', '')",
    "('', 'image', 'Defaut', 'image_pairs', 'Plage/Liste_paire.png', 'right', 'top', 'no-repeat', 'scroll')",
    "('', 'image', 'Defaut', 'image_barre_auteur', 'Plage/poisson15.gif', 'right', 'top', 'no-repeat', 'scroll')",
    "('', 'image', 'Defaut', 'image_menu_off', 'Plage/Menu_off.png', 'right', 'bottom', 'no-repeat', 'scroll')",
    "('', 'perso', 'Defaut', 'div#Page{padding:0;}', '', '', '', '', '')",
    "('', 'image', 'Defaut', 'image_bloc', 'Plage/poisson13.gif', 'left', 'bottom', 'no-repeat', 'scroll')",
    "('', 'perso', 'Defaut', 'div#Contenu, div#Conteneur {margin-right:0; padding-right:0;}', '', '', '', '', '')",
    "('', 'perso', 'Defaut', 'div#Entete h1 span, div#Entete h2 span{border-style:none;}', '', '', '', '', '')",
    "('', 'image', 'Defaut', 'image_menu_on', 'Plage/poisson7.gif', 'right', 'bottom', 'no-repeat', 'scroll')",
    "('', 'image', 'Defaut', 'image_impairs', 'Plage/Liste_impaire.png', 'right', 'top', 'no-repeat', 'scroll')",
    "('', 'image', 'Defaut', 'image_page', 'Plage/Poisson1.gif', 'left', 'bottom', 'no-repeat', 'scroll')",
    "('', 'perso', 'Defaut', 'div#Menu {padding-left:0px;}', '', '', '', '', '')",
    "('', 'image', 'Defaut', 'image_ecran', 'Plage/image_fond.jpg', 'left', 'top', 'repeat-x', 'fixed')",
    "('', 'perso', 'Defaut', 'ul#Logo-Pied, #ul#Pied {margin:0; padding:0;}', '', '', '', '', '')",
    "('', 'perso', 'Defaut', 'ul.liens {margin-top:0px;}', '', '', '', '', '')",
    "('', 'perso', 'Defaut', 'div.edito{margin-bottom:0;}', '', '', '', '', '')",
    "('', 'perso', 'Defaut', 'div.bloc{margin-top:0;}', '', '', '', '', '')",
    "('', 'perso', 'Defaut', 'ul#Logo-Pied, ul#Pied {display:none;}', '', '', '', '', '')",
    "('', 'perso', 'Defaut', 'div.bloc{margin-bottom:0;}', '', '', '', '', '')",
    "('', 'perso', 'Defaut', 'div.edito{margin-top:0;}', '', '', '', '', '')",
    "('', 'perso', 'Defaut', 'div#Arborescence{margin-left:258px;}', '', '', '', '', '')",
    "('', 'image', 'Defaut', 'image_barre_entete_arborescence', 'Plage/haut_back.jpg', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'perso', 'Defaut', 'div#Arborescence{height:30px;}', '', '', '', '', '')",
    "('', 'perso', 'Defaut', 'div#Arborescence, div#Entete, div#Contenu {border-left: 1px solid #111; border-right: 1px solid #111;}', '', '', '', '', '')",
    "('', 'perso', 'Defaut', 'div#Arborescence{height:27px; line-height:27px;}', '', '', '', '', '')",
    "('', 'perso', 'Defaut', 'div#Menu .bloc {border:1px solid #111; }', '', '', '', '', '')",
    "('', 'perso', 'Defaut', 'div#Menu {margin-top:-200px;}', '', '', '', '', '')",
    "('', 'perso', 'Defaut', 'div#ConteneurSeul div#Contenu {margin : 0 0 0 258px;}', '', '', '', '', '')",
    "('', 'perso', 'Defaut', 'div#ConteneurSeul {margin:0;}', '', '', '', '', '')",
    "('', 'perso', 'Defaut', 'div#Entete {margin-left:258px;}', '', '', '', '', '')"
    ), ),
'Nature' => array(
    /* Th�me cr�� par Olivier Gautier */
    "habillage" => "'0'",
    "theme" => "('', 'Defaut', '#ffbf99', '#FFF', '#FFF', '#FFF', 'transparent', '#388c00', '#275300', '#4fa600', '#0012c1', '#0012c1', '#FFF', '#275300', '#FFF', '#ffd2b7', '#fff0e8', '#ffbf99', '#8c3800', '#ffdeca', '#ffd2b7', '', '#444', '#444', '#444', '#FFF', '#388c00', '#275300', '#388c00', '#8c3800', '#ffbf99', '#388c00', '#275300', '#388c00', '#444', '#275300', '#388c00', '#fff', '#fff', '#fff', '#0012c1', '#a24fa4', '#0012c1', '#a24fa4', '#a24fa4', '#0012c1', '#275300', '2px', '', '#388c00', '', '', '#388c00', '', '', 'transparent', '', '', '#000e8c', '', '', '#000e8c', '6px', 'ridge', '#4fc400', '', '', '#ffbf99', '2px', 'double', '#8c3800', '', '', '', '', '', '', '', '', '')",
    "images" => array(
    "('', 'image', 'Defaut', 'image_menu_off', 'Nature/menu_off.png', 'right', 'top', 'repeat-y', 'scroll')",
    "('', 'image', 'Defaut', 'image_menu_on', 'Nature/menu_on.png', 'left', 'top', 'repeat-y', 'scroll')",
    "('', 'image', 'Defaut', 'image_barre_entete', 'Nature/bouton_entete.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_barre_entete_arborescence', 'Nature/arborescence_entete.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_titre_entete', 'Nature/titre_entete.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_barre_auteur', 'Nature/titre_entete.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_entete_page', 'Nature/prescot.gif', 'right', 'bottom', 'no-repeat', 'scroll')",
    "('', 'image', 'Defaut', 'image_pied', 'Nature/bouton_pied.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_ecran', 'Nature/prescot.gif', 'left', 'bottom', 'no-repeat', 'fixed')",
    "('', 'image', 'Defaut', 'image_impairs', 'Nature/Liste_impaire.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_titres', 'Nature/Liste_paire.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_pairs', 'Nature/Liste_paire.png', 'left', 'bottom', 'repeat-x', 'scroll')"
    ), ),
'Un air de Sarka-SPIP' => array(
    /* Th�me cr�� par Olivier Gautier, sur un mod�le issu du site Sarka-SPIP */
    "habillage" => "'eva_style_3_colonnes.css'",
    "theme" => "('', 'Defaut', '#fff', '#fff', '#fff', '#fff', '#6262A4', '#6262A4', '#6262A4', '#6262A4', '#6262A4', '#990000', '#6262A4', '#fff', '#fff', '#6262A4', '#fff', '#6262A4', '#fff', '#fff', '#E0E0E0', '', '#000', '#000', '#000', '#FFF', '#FFF', '#FFF', '#FFF', '#FFF', '#6262A4', '#990000', '#FFF', '#990000', '#000', '#FFF', '#990000', '#FFF', '#FFF', '#000', '#990000', '#990000; text-decoration:underline', '#990000', '#990000; text-decoration:underline', '#990000', '#990000; text-decoration:underline', '', '', 'none', '#6262A4', '', '', '#FFF', '2px', 'solid', '#6262A4', '', '', '#6262A4', '', '', '#6262A4', '10px', 'solid', '#6262A4', '', '', '', '', 'none', '#6262A4', 'thin', 'solid', '', '', '', '', '120px', '', '50px')",
    "images" => array(
    "('', 'perso', 'Defaut', '#MenuDroit ul#Sommaire {margin-top:0;}', '', '', '', '', '')",
    "('', 'perso', 'Defaut', 'a:hover {text-decoration:underline;}', '', '', '', '', '')",
    "('', 'bloc', 'Defaut', 'rubrique_mot', 'centre', '', '', '', '')",
    "('', 'bloc', 'Defaut', 'auteur_navigation', 'gauche', '', '', '', '')",
    "('', 'bloc', 'Defaut', 'breve_breves', 'droite', '', '', '', '')",
    "('', 'bloc', 'Defaut', 'breve_navigation', 'gauche', '', '', '', '')",
    "('', 'bloc', 'Defaut', 'article_meme_rubrique', 'gauche', '', '', '', '')",
    "('', 'bloc', 'Defaut', 'article_petition', 'droite', '', '', '', '')",
    "('', 'bloc', 'Defaut', 'article_navigation', 'gauche', '', '', '', '')",
    "('', 'bloc', 'Defaut', 'article_mot', 'gauche', '', '', '', '')",
    "('', 'bloc', 'Defaut', 'article_compteur', 'droite', '', '', '', '')",
    "('', 'bloc', 'Defaut', 'rubrique_site_syndic', 'centre', '', '', '', '')",
    "('', 'bloc', 'Defaut', 'sommaire_compteur', 'droite', '', '', '', '')",
    "('', 'bloc', 'Defaut', 'rubrique_syndic', 'centre', '', '', '', '')",
    "('', 'perso', 'Defaut', 'div .edito {padding:0;}', '', '', '', '', '')",
    "('', 'perso', 'Defaut', 'div#MenuDroit .bloc {border-color:#808080;}', '', '', '', '', '')",
    "('', 'perso', 'Defaut', 'div#MenuDroit h3.titre {background-color:#808080;}', '', '', '', '', '')",
    "('', 'bloc', 'Defaut', 'sommaire_syndic', 'droite', '', '', '', '')",
    "('', 'bloc', 'Defaut', 'sommaire_mini_calendrier', 'gauche', '', '', '', '')",
    "('', 'perso', 'Defaut', 'ul#Sommaire {margin-top:4px;}', '', '', '', '', '')",
    "('', 'perso', 'Defaut', 'div#Contenu .edito h3.titre {margin:0;}', '', '', '', '', '')",
    "('', 'perso', 'Defaut', 'h3 , div#Contenu h3 , h3:first-letter , div#Contenu h3:first-letter {color:#990000;}', '', '', '', '', '')",
    "('', 'bloc', 'Defaut', 'rubrique_navigation', 'gauche', '', '', '', '')",
    "('', 'perso', 'Defaut', 'div#Contenu .bloc2 h3:first-letter , div#Contenu .bloc2 h3:first-letter , h3 , div#Contenu h3 , h3:first-letter , div#Contenu h3:first-letter {color:#990000;}', '', '', '', '', '')",
    "('', 'perso', 'Defaut', 'div#Menu ul#Sommaire li{margin:1px 0;}', '', '', '', '', '')",
    "('', 'bloc', 'Defaut', 'sommaire_podcast', 'droite', '', '', '', '')",
    "('', 'bloc', 'Defaut', 'sommaire_site', 'droite', '', '', '', '')",
    "('', 'bloc', 'Defaut', 'auteur_articles', 'droite', '', '', '', '')",
    "('', 'bloc', 'Defaut', 'auteur_auteurs', 'gauche', '', '', '', '')",
    "('', 'bloc', 'Defaut', 'sommaire_connexion', 'droite', '', '', '', '')",
    "('', 'bloc', 'Defaut', 'sommaire_navigation', 'gauche', '', '', '', '')",
    "('', 'bloc', 'Defaut', 'sommaire_breve', 'gauche', '', '', '', '')",
    "('', 'bloc', 'Defaut', 'rubrique_site', 'centre', '', '', '', '')",
    "('', 'bloc', 'Defaut', 'sommaire_logo', 'gauche', '', '', '', '')",
    "('', 'bloc', 'Defaut', 'rubrique_breve', 'centre', '', '', '', '')",
    "('', 'perso', 'Defaut', '.edito h3.titre {-moz-border-radius: 0px;}', '', '', '', '', '')"
    ), ),
'Fille ou garcon ?' => array(
    /* Th�me cr�� par Olivier Gautier */
    "habillage" => "'eva_style_basic_menu_a_droite.css'",
    "theme" => "('', 'Defaut', '#9393ff', 'transparent', 'transparent', 'transparent', 'transparent', '#ff9fcf', '#ff9fcf', '#ff9fcf', 'transparent', 'transparent', 'transparent', '#ff9fcf', '#ff9fcf', 'transparent', 'transparent', 'transparent', 'transparent', 'transparent', 'transparent', 'georgia', '#222', '#222', '#333', '#4f4fff', '#222', '#ff379b', '#222', '#ff9fcf', '#ff379b', '#fff', '#222; text-decoration:underline', '#222', '#222', '#222; text-decoration:underline', '#222', '#fff', '#222', '#fff', '#fff', '#444', '', '', '', '', '', '', 'none', '#ff9fcf', '1px', 'solid', '', '', 'none', '#ff9fcf', '1px', 'dashed', '#ff9fcf', '1px', 'dashed', '#ff379b', '4px', 'solid', '', '', 'none', '#ff9fcf', '2px', 'solid', '#ff9fcf', '1px', 'dashed', '100%', '250px', '', '68%', '', '', '')",
    "images" => array(
    "('', 'bloc', 'Defaut', 'article_meme_rubrique', 'gauche', '', '', '', '')",
    "('', 'bloc', 'Defaut', 'article_mot', 'gauche', '', '', '', '')",
    "('', 'bloc', 'Defaut', 'article_compteur', 'centre', '', '', '', '')",
    "('', 'perso', 'Defaut', 'ul#Pied{padding-right:270px;}', '', '', '', '', '')",
    "('', 'perso', 'Defaut', 'ul#Logo-Pied{padding-right:270px;}', '', '', '', '', '')",
    "('', 'perso', 'Defaut', 'ul.liens {padding-right:270px;}', '', '', '', '', '')",
    "('', 'image', 'Defaut', 'image_entete_page', 'FilleGarcon/entete_pied.png', 'right', 'top', 'repeat-y', 'scroll')",
    "('', 'image', 'Defaut', 'image_barre_entete', 'FilleGarcon/entete_pied.png', 'right', 'top', 'repeat-y', 'scroll')",
    "('', 'image', 'Defaut', 'image_barre_entete_arborescence', 'FilleGarcon/entete_pied.png', 'right', 'top', 'repeat-y', 'scroll')",
    "('', 'image', 'Defaut', 'image_pied', 'FilleGarcon/entete_pied.png', 'right', 'top', 'repeat-y', 'scroll')",
    "('', 'image', 'Defaut', 'image_pied-logo', 'FilleGarcon/entete_pied.png', 'right', 'top', 'repeat-y', 'scroll')",
    "('', 'bloc', 'Defaut', 'article_navigation', 'gauche', '', '', '', '')",
    "('', 'bloc', 'Defaut', 'article_petition', 'gauche', '', '', '', '')",
    "('', 'perso', 'Defaut', 'div #ConteneurSeul {padding-right:270px;}', '', '', '', '', '')",
    "('', 'perso', 'Defaut', 'div#Entete ul.liens {text-align:left}', '', '', '', '', '')",
    "('', 'perso', 'Defaut', 'body {margin:0;}', '', '', '', '', '')",
    "('', 'image', 'Defaut', 'image_ecran', 'FilleGarcon/page.png', 'right', 'top', 'repeat-y', 'scroll')"
    ), ),
'Souris' => array(
    /* Th�me cr�� par Olivier Gautier */
    "habillage" => "'eva_style_basic_menu_a_droite.css'",
    "theme" => "('', 'Defaut', '#fff', '#ddd', '#fff', '#fff', '#fff', '#5B5B5B', '#5B5B5B', '#5B5B5B', '#2d2dc9', '#2d2dc9', '#fff', '#5B5B5B', '#5B5B5B', '#fbe195', '#fff', '#4c1e45', '#1b4937', '#fff', '#dbd3fc', '', '#1d3a4a', '#000', '#333', '#fff', '#1b4937', '#491b1b', '#4c1e45', '#fff', '#fff', '#fbe195', '#333; text-decoration:underline', '#4c1e45', '#333', '#fff; font-size:120%', '#fff', '#fff', '#fff', '#fff', '#88258f', '#e1a900; text-decoration:underline', '#95004a', '#95004a; text-decoration:underline', '#1b4937', '#1b4937; text-decoration:underline', '#C0C0C0', '1px', '', '#5B5B5B', '', '', '#C0C0C0', '1px', '', '', '', '', '#5B5B5B', '', '', '#5B5B5B', '', '', '#C0C0C0', '1px', '', '#5B5B5B', '', '', '#5B5B5B', '', '', '', '', '', '', '130px', '', '')",
    "images" => array(
    "('', 'image', 'Defaut', 'image_entete_page', 'souris/bg5.jpg', 'left', 'top', 'repeat', 'scroll')",
    "('', 'image', 'Defaut', 'image_titre_entete', 'souris/carreaux.jpg', 'left', 'top', 'repeat', 'scroll')",
    "('', 'perso', 'Defaut', 'body {margin-top:0; margin-bottom:0;}', '', '', '', '', '')",
    "('', 'image', 'Defaut', 'image_barre_auteur', 'souris/bg5.jpg', 'left', 'top', 'repeat', 'scroll')",
    "('', 'perso', 'Defaut', 'div#Entete h1 span , div#Entete h2 span {border:2px solid #C0C0C0;}', '', '', '', '', '')",
    "('', 'image', 'Defaut', 'image_ecran', 'souris/larg.jpg', 'center', 'top', 'repeat-y', 'scroll')",
    "('', 'image', 'Defaut', 'image_pied', 'souris/bg5.jpg', 'left', 'top', 'repeat', 'scroll')"
    ), ),
'Souris 2' => array(
    /* Th�me cr�� par Olivier Gautier et adapt� par Pascal Rougier */
    "habillage" => "'eva_style_basic_menu_a_gauche.css'",
    "theme" => "('', 'Defaut', '#8378da', '#ddd', '#fff', '#fff', '#fff', '#5B5B5B', '#5B5B5B', '#5B5B5B', '#4c1e45', '#2d2dc9', '#fff', '#5B5B5B', '#5B5B5B', 'transparent', 'transparent', '#4c1e45', '#1b4937', '#fff', '#dddddd', '', '#1d3a4a', '#000', '#333', '#fff', '#1b4937', '#491b1b', '#4c1e45', '#fff', '#fff', '#fbe195', '#f813a5', '#e3345d', '#333', '#f813a5', '#e3345d', '#fff', '#fff', '#fff', '#88258f', '#e1a900; text-decoration:underline', '#95004a', '#95004a; text-decoration:underline', '#1b4937', '#1b4937; text-decoration:underline', '#C0C0C0', '1px', '', '#5B5B5B', '', '', '#C0C0C0', '1px', '', '', '', '', '#5B5B5B', '', '', '#5B5B5B', '', '', '#C0C0C0', '1px', '', 'transparent', '', '', '#5B5B5B', '', '', '', '', '', '', '130px', '', '')",
    "images" => array(
    "('', 'image', 'Defaut', 'image_entete_page', 'souris/Entetedeg.png', 'left', 'bottom', 'repeat-y', 'scroll')",
    "('', 'image', 'Defaut', 'image_titre_entete', 'souris/carreaux.jpg', 'left', 'top', 'repeat', 'scroll')",
    "('', 'perso', 'Defaut', 'body {margin-top:0; margin-bottom:0;}', '', '', '', '', '')",
    "('', 'image', 'Defaut', 'image_barre_auteur', 'souris/bg5.jpg', 'left', 'top', 'repeat', 'scroll')",
    "('', 'perso', 'Defaut', 'div#Entete h1 span , div#Entete h2 span {border:2px solid #C0C0C0;}', '', '', '', '', '')",
     "('', 'perso', 'Defaut', '#Contenu{margin-right:10px;}', '', '', '', '', '')",
     "('', 'perso', 'Defaut', '.bloc2 {padding-left:10px; padding-right:10px;}', '', '', '', '', '')",    
    "('', 'image', 'Defaut', 'image_ecran', 'souris/bleudeg.png', 'center', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_pied', 'souris/bg5.jpg', 'left', 'top', 'repeat', 'scroll')"
    ), ),
'Basic Rouge' => array(
    /* Th�me cr�� par Olivier Gautier */
    "habillage" => "'eva_style_basic_menu_a_gauche.css'",
    "theme" => "('', 'Defaut', '#E8E8E8', '#FFFFFF', 'transparent', 'transparent', 'transparent', '#D00000', 'transparent', '#D00000', 'transparent', 'transparent', 'transparent', 'transparent', 'transparent', 'transparent', 'transparent', 'transparent', 'transparent', 'transparent', 'transparent', '', '#333333', '#333333', '#333333', '#FFFFFF', '#777777', '#111111', '#666666', '#D00000', '#000000', '#333333; text-decoration:underline', '#222222', '#222222', '#333333', '#111111', '#111111', '#FFFFFF', '#333333', '#333333', '#D00000', '#333333; text-decoration:underline', '#D00000', '#333333; text-decoration:underline', '#D00000', '#333333; text-decoration:underline', '#A0A0A0', '2px', 'solid', '', '', 'none', '', '', 'none', '', '', 'none', '', '', 'none', '', '', 'none', '#A0A0A0', '', '', '', '', 'none', '', '', 'none', '', '', '', '', '', '', '')",
    "images" => array(
    "('', 'image', 'Defaut', 'image_barre_entete_arborescence', 'Basic/rouge_bas.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_entete_page', 'Basic/rouge_milieu.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'perso', 'Defaut', 'div #Menu {border-right:1px solid #AAA;}', '', '', '', '', '')",
    "('', 'perso', 'Defaut', 'div #Menu {border-bottom:1px solid #AAA;}', '', '', '', '', '')",
    ), ),
'Basic Bleu' => array(
    /* Th�me cr�� par Olivier Gautier */
    "habillage" => "'eva_style_basic_menu_a_gauche.css'",
    "theme" => "('', 'Defaut', '#E8E8E8', '#FFFFFF', 'transparent', 'transparent', 'transparent', '#64A8E1', 'transparent', '#4281B7', 'transparent', 'transparent', 'transparent', 'transparent', 'transparent', 'transparent', 'transparent', 'transparent', 'transparent', 'transparent', 'transparent', '', '#333333', '#333333', '#333333', '#FFFFFF', '#777777', '#111111', '#666666', '#0066CC', '#000000', '#333333; text-decoration:underline', '#222222', '#222222', '#333333', '#111111', '#111111', '#FFFFFF', '#333333', '#333333', '#0066CC', '#333333; text-decoration:underline', '#0066CC', '#333333; text-decoration:underline', '#0066CC', '#333333; text-decoration:underline', '#A0A0A0', '2px', 'solid', '', '', 'none', '', '', 'none', '', '', 'none', '', '', 'none', '', '', 'none', '#A0A0A0', '', '', '', '', 'none', '', '', 'none', '', '', '', '', '', '', '')",
    "images" => array(
    "('', 'image', 'Defaut', 'image_barre_entete_arborescence', 'Basic/bleu_bas.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_entete_page', 'Basic/bleu_milieu.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'perso', 'Defaut', 'div #Menu {border-right:1px solid #AAA;}', '', '', '', '', '')",
    "('', 'perso', 'Defaut', 'div #Menu {border-bottom:1px solid #AAA;}', '', '', '', '', '')",
    ), ),
'Basic Vert' => array(
    /* Th�me cr�� par Olivier Gautier */
    "habillage" => "'eva_style_basic_menu_a_gauche.css'",
    "theme" => "('', 'Defaut', '#E8E8E8', '#FFFFFF', 'transparent', 'transparent', 'transparent', '#1CAB1C', 'transparent', '#1CAB1C', 'transparent', 'transparent', 'transparent', 'transparent', 'transparent', 'transparent', 'transparent', 'transparent', 'transparent', 'transparent', 'transparent', '', '#333333', '#333333', '#333333', '#FFFFFF', '#777777', '#111111', '#666666', '#1CAB1C', '#000000', '#333333; text-decoration:underline', '#222222', '#222222', '#333333', '#111111', '#111111', '#FFFFFF', '#333333', '#333333', '#1CAB1C', '#333333; text-decoration:underline', '#1CAB1C', '#333333; text-decoration:underline', '#1CAB1C', '#333333; text-decoration:underline', '#A0A0A0', '2px', 'solid', '', '', 'none', '', '', 'none', '', '', 'none', '', '', 'none', '', '', 'none', '#A0A0A0', '', '', '', '', 'none', '', '', 'none', '', '', '', '', '', '', '')",
    "images" => array(
    "('', 'image', 'Defaut', 'image_barre_entete_arborescence', 'Basic/vert_bas.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_entete_page', 'Basic/vert_milieu.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'perso', 'Defaut', 'div #Menu {border-right:1px solid #AAA;}', '', '', '', '', '')",
    "('', 'perso', 'Defaut', 'div #Menu {border-bottom:1px solid #AAA;}', '', '', '', '', '')",
    ), ),
'Eclipse' => array(
    /* Th�me cr�� par Olivier Gautier */
    "habillage" => "'0'",
    "theme" => "('', 'Defaut', '#a94c72', 'transparent', 'transparent', 'transparent', '#932041', 'transparent', 'transparent', 'transparent', 'transparent', 'transparent', 'transparent', 'transparent', 'transparent', '#932041', 'transparent', '#932041', '#932041', 'transparent', 'transparent', '', '#f1fbc5', '#f1fbc5', '#f1fbc5', '#ffffff', '#f1fbc5', '#e5ff6d', '#f1fbc5', '#e5ff6d', '#e5ff6d', '#e5ff6d; text-decoration:underline', '#e5ff6d', '#e5ff6d', '#f1fbc5', '#e5ff6d', '#e5ff6d', '#f1fbc5', '#f1fbc5', '#f1fbc5', '#efea39', '#efea39; text-decoration:underline', '#efea39', '#efea39; text-decoration:underline', '#efea39', '#efea39; text-decoration:underline', 'transparent', '', '', '#932041', '', '', 'transparent', '', '', '#932041', '', '', '#932041', '', '', '#932041', '', '', '#932041', '', '', '#932041', '', '', '#932041', '', '', '', '', '', '', '', '', '')",
    "images" => array(
    "('', 'image', 'Defaut', 'image_ecran', 'Eclipse/eclipse.png', 'left', 'top', 'no-repeat', 'scroll')"
    ), ),
'EVA 1 Style Azure' => array(
    /* Th�me adapt� par Olivier Gautier */
    "habillage" => "'eva_style_basic_menu_a_droite.css'",
    "theme" => "('', 'Defaut', '#fff', '#fff', '#fff8f2', '#fff8f2', '#fff8f2', '#c2d5f2', '#fff8f2', '#fff8f2', '#fff8f2', '#e1e8f4', '#fff8f2', '#fff8f2', '#fff8f2', '#fff8f2', '#c2d5f2', '#fff8f2', '#fff8f2', '#fff8f2', '#e1e8f4', '', '#000', '#000', '#000', '#6f8fbe', '#000', '#000', '#000', '#000', '#ff0000', '#ff0000', '#000', '#000', '#000', '#000', '#000', '#000', '#000', '#000', '#ff8826', '#ff0000', '#ff8826', '#ff0000', '#ff8826', '#ff0000', '#6f8fbe', '2px', '', '#6f8fbe', '', '', '#6f8fbe', '2px', '', '#6f8fbe', '', '', '#6f8fbe', '', '', '#6f8fbe', '', '', '#6f8fbe', '2px', '', '#6f8fbe', '2px', '', '#6f8fbe', '1px', 'dashed', '', '', '', '', '', '', '')",
    "images" => array(),
    ),
'EVA 1 Style Azure degrade' => array(
    /* Th�me adapt� par Olivier Gautier */
    "habillage" => "'eva_style_basic_menu_a_droite.css'",
    "theme" => "('', 'Defaut', '#fff', '#fff', '#fff8f2', '#fff8f2', '#fff8f2', '#c2d5f2', 'transparent', '#fff8f2', '#fff8f2', '#e1e8f4', '#fff8f2', '#49a5fe', '#fff8f2', '#fff8f2', '#c2d5f2', '#fff8f2', '#fff8f2', '#fff8f2', '#e1e8f4', '', '#000', '#000', '#000', '#6f8fbe', '#000', '#000', '#000', '#000', '#ff0000', '#ff0000', '#000', '#000', '#000', '#000', '#000', '#000', '#000', '#000', '#ff8826', '#ff0000', '#ff8826', '#ff0000', '#ff8826', '#ff0000', '#6f8fbe', '2px', '', '#6f8fbe', '', '', '#6f8fbe', '1px', '', '#6f8fbe', '', '', '#6f8fbe', '', '', '#6f8fbe', '', '', '#6f8fbe', '1px', '', '#6f8fbe', '2px', '', '#6f8fbe', '1px', 'dashed', '', '', '', '', '', '', '')",
    "images" => array(
    "('', 'image', 'Defaut', 'image_titre_entete', 'Eva/EVAazure_titre.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_impairs', 'Eva/EVAazure_impair.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_pairs', 'Eva/EVAazure_pair.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_menu', 'Eva/EVAazure_menu.png', 'right', 'top', 'repeat-y', 'scroll')",
    "('', 'image', 'Defaut', 'image_pied-logo', 'Eva/EVAazure_logo.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_pied', 'Eva/EVAazure_pied.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_entete_page', 'Eva/EVAazure_entete.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_barre_entete_arborescence', 'Eva/EVAazure_arborescence.png', 'left', 'top', 'repeat-x', 'scroll')",
    ), ),
'EVA 2 Style Plage' => array(
    /* Th�me adapt� par Olivier Gautier */
    "habillage" => "'0'",
    "theme" => "('', 'Defaut', '#f2faff', '#f2faff', '#f2faff', '#fffef2', '#fff7c0', '#fff7c0', '#fff7c0', '#fff7c0', '#fff7c0', '#fff7c0', '#fff7c0', '#fff7c0', '#fff7c0', '#fff7c0', '#ffe095', '#cde3ff', '#fff', '#f2faff', '#fffbd7', '', '#000', '#000', '#000', '#ff7200', '#000', '#000', '#000', '#000', '#cc3300', '#cc3300', '#000', '#000', '#000', '#000', '#000', '#000', '#000', '#000', '#2593d8', '#cc3300', '#2593d8', '#cc3300', '#2593d8', '#cc3300', '#ff7200', '3px', '', '#ff7200', '', '', '#ff7200', '2px', '', '#ff7200', '2px', '', '#ff7200', '', '', '#ff7200', '', '', '#ff7200', '', '', '#ff7200', '2px', '', '#ff7200', '', '', '', '', '', '', '', '', '')",
    "images" => array(),
    ),
'EVA 2 Style Plage degrade' => array(
    /* Th�me adapt� par Olivier Gautier */
    "habillage" => "'eva_style_images_de_fond.css'",
    "theme" => "('', 'Defaut', '#f2faff', '#f2faff', '#f2faff', '#fffef2', '#fff7c0', '#ff7200', 'transparent', '#fff7c0', '#fff7c0', '#fff7c0', '#fff7c0', '#fff7c0', '#fff7c0', '#fff7c0', '#ffe095', '#cde3ff', '#fff', '#f2faff', '#fffbd7', '', '#000', '#000', '#000', '#ff7200', '#000', '#000', '#000', '#000', '#cc3300', '#cc3300', '#000', '#000', '#000', '#000', '#000', '#000', '#000', '#000', '#2593d8', '#cc3300', '#2593d8', '#cc3300', '#2593d8', '#cc3300', '#ff7200', '2px', '', '#ff7200', '', '', '#ff7200', '1px', '', '#ff7200', '2px', '', '#ff7200', '', '', '#ff7200', '', '', '#ff7200', '', '', '#ff7200', '2px', '', '#ff7200', '', '', '', '', '', '', '', '', '')",
    "images" => array(
    "('', 'image', 'Defaut', 'image_pied', 'Eva/EVAplage_pied.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_pied-logo', 'Eva/EVAplage_logo.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_barre_auteur', 'Eva/EVAplage_liens.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_menu', 'Eva/EVAplage_menu.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_pairs', 'Eva/EVAplage_pair.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_ecran', 'Eva/EVAplage_page.png', 'left', 'top', 'repeat-x', 'fixed')",
    "('', 'image', 'Defaut', 'image_impairs', 'Eva/EVAplage_impair.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_titres', 'Eva/EVAplage_liens.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_titre_entete', 'Eva/EVAplage_liens.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_edito_titre', 'Eva/EVAplage_liens.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_barre_entete_arborescence', 'Eva/EVAplage_arborescence.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_entete_page', 'Eva/EVAplage_entete.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_menu_off', 'Eva/EVAplage_SecteurMenu.png', 'right', 'top', 'repeat-y', 'scroll')"
    ), ),
'EVA 2 Style DarkSide' => array(
    /* Th�me adapt� par Olivier Gautier */
    "habillage" => "'0'",
    "theme" => "('', 'Defaut', '#000000', '#323232', '#000000', '#666666', '#000000', '#323232', '#666666', '#666666', '#000000', '#323232', '#000000', '#666666', '#444444', '#000000', '#323232', '#4c4c4c', '#666666', '#323232', '#666666', '', '#fff', '#fff', '#fff', '#fff', '#fff', '#fff', '#fff', '#fff', '#ffc232', '#ff0000', '#fff', '#fff', '#fff', '#fff', '#fff', '#fff', '#fff', '#fff', '#ff0000', '#ffc232', '#ff0000', '#ffc232', '#ff0000', '#ffc232', '#999', '2px', '', '#999', '', '', '#999', '', '', '#999', '2px', '', '#999', '', '', '#999', '2px', '', '#999', '2px', '', '#999', '2px', '', '#999', '2px', '', '', '', '', '', '', '', '')",
    "images" => array(),
    ),
'EVA 2 Night' => array(
    /* Th�me adapt� par Olivier Gautier */
    "habillage" => "'0'",
    "theme" => "('', 'Defaut', '#0f0f51', '#0f0f51', '#0f0f51', '#333380', '#000', '#000', '#333380', '#333380', '#333380', '#0f0f51', '#000', '#000', '#333380', '#000', '#000', '#141466', '#333380', '#141466', '#0f0f51', '', '#fff', '#fff', '#fff', '#fff', '#fff', '#fff', '#fff', '#ffffb1', '#ffc233', '#ffc233', '#fff', '#fff', '#fff', '#fff', '#fff', '#fff', '#fff', '#fff', '#ffffb1; text-decoration:underline', '#ffc233; text-decoration:underline', '#ffffb1; text-decoration:underline', '#ffc233; text-decoration:underline', '#ffffb1; text-decoration:underline', '#ffc233; text-decoration:underline', '#5959b3', '2px', '', '#5959b3', '', '', '#5959b3', '2px', '', '#5959b3', '', '', '#5959b3', '', '', '#5959b3', '', '', '#5959b3', '2px', '', '#5959b3', '2px', '', '#5959b3', '1px', '', '', '', '', '', '', '', '')",
    "images" => array(),
    ),
'EVA 2 Plume' => array(
    /* Th�me adapt� par Olivier Gautier */
    "habillage" => "'0'",
    "theme" => "('', 'Defaut', '#fff', '#f7f7f7', '#f7f7f7', '#f7f7f7', '#e6ecf2', '#e6ecf2', '#e6ecf2', '#e6ecf2', '#e6ecf2', '#e6ecf2', '#e6ecf2', '#e6ecf2', '#e6ecf2', '#e6ecf2', '#e6ecf2', '#f7f7f7', '#fff', '#f7f7f7', '#e6ecf2', '', '#5c6166', '#5c6166', '#5c6166', '#2164a6', '#5c6166', '#5c6166', '#5c6166', '#5c6166', '#d37324', '#d37324', '#5c6166', '#5c6166', '#5c6166', '#5c6166', '#5c6166', '#2164a6', '#5c6166', '#2164a6', '#2164a6; text-decoration:underline', '#d37324; text-decoration:underline', '#2164a6; text-decoration:underline', '#d37324; text-decoration:underline', '#2164a6; text-decoration:underline', '#d37324; text-decoration:underline', '#adc4d9', '2px', '', '#adc4d9', '', '', '#adc4d9', '', '', '#adc4d9', '', '', '#adc4d9', '', '', '#adc4d9', '', '', '#adc4d9', '2px', '', '#adc4d9', '2px', '', '#adc4d9', '', '', '', '', '', '', '', '', '')",
    "images" => array(),
    ),
'EVA 2 RMLL' => array(
    /* Th�me adapt� par Olivier Gautier */
    "habillage" => "'0'",
    "theme" => "('', 'Defaut', '#FFF', '#faedf4', '#faedf4', '#f7dfeb', '#bf6994', '#bf6994', '#f7dfeb', '#f7dfeb', '#bf6994', '#bf6994', '#bf6994', '#bf6994', '#f7dfeb', '#bf6994', '#993d6b', '#f2c2da', '#FFF', '#faedf4', '#f7dfeb', '', '#000', '#000', '#000', '#fff', '#000', '#000', '#000', '#000', '#b30059', '#b30059', '#000', '#000', '#000', '#000', '#000', '#000', '#000', '#000', '#005fb2', '#b30059', '#005fb2', '#b30059', '#005fb2', '#b30059', '#711141', '2px', '', '#711141', '', '', '#711141', '', '', '#711141', '', '', '#711141', '', '', '#711141', '2px', '', '#711141', '', '', '#711141', '2px', '', '#711141', '', '', '', '', '', '', '', '', '')",
    "images" => array(),
    ),
'EVA 2 RMLL degrade' => array(
    /* Th�me adapt� par Olivier Gautier */
    "habillage" => "'eva_style_basic_menu_a_droite.css'",
    "theme" => "('', 'Defaut', '#FFF', '#faedf4', '#faedf4', '#f7dfeb', '#bf6994', '#bf6994', 'transparent', '#f7dfeb', '#bf6994', '#bf6994', '#bf6994', '#f7dfeb', '#bf6994', '#bf6994', '#993d6b', '#f2c2da', '#FFF', '#faedf4', '#f7dfeb', '', '#000', '#000', '#000', '#fff', '#000', '#000', '#000', '#000', '#b30059', '#b30059', '#000', '#000', '#000', '#000', '#000', '#000', '#000', '#000', '#005fb2', '#b30059', '#005fb2', '#b30059', '#005fb2', '#b30059', '#711141', '2px', '', '#711141', '', '', '#711141', '', '', '#711141', '', '', '#711141', '', '', '#711141', '2px', '', '#711141', '', '', '#711141', '2px', '', '#711141', '', '', '', '', '', '', '', '', '')",
    "images" => array(
    "('', 'image', 'Defaut', 'image_pied', 'Eva/EVArmll_pied.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_pied-logo', 'Eva/EVArmll_logo.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_pairs', 'Eva/EVArmll_pair.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_impairs', 'Eva/EVArmll_impair.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_menu_off', 'Eva/EVArmll_menu_secteurs.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_titres', 'Eva/EVArmll_titres_blocs.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_edito_titre', 'Eva/EVArmll_titres_blocs.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_menu', 'Eva/EVArmll_menu.png', 'left', 'top', 'repeat-y', 'scroll')",
    "('', 'image', 'Defaut', 'image_titre_entete', 'Eva/EVArmll_titre.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_barre_entete_arborescence', 'Eva/EVArmll_arborescence.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_entete_page', 'Eva/EVArmll_entete.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    ), ),
'EVA 2 Toys' => array(
    /* Th�me adapt� par Olivier Gautier */
    "habillage" => "'0'",
    "theme" => "('', 'Defaut', '#fff', '#eff7ff', '#eff7ff', '#d4ffbf', '#79c0f2', '#79c0f2', '#d4ffbf', '#d4ffbf', '#d4ffbf', '#79c0f2', '#d4ffbf', '#79c0f2', '#d4ffbf', '#79c0f2', '#aedef5', '#ff7c4c', '#ffea80', '#eff7ff', '#aedef5', '', '#000', '#000', '#000', '#fff2b2', '#000', '#000', '#000', '#000', '#0058e6', '#0058e6', '#000', '#000', '#000', '#000', '#000', '#ff0000', '#000', '#ff0000', '#ff0000', '#0058e6', '#ff0000', '#0058e6', '#ff0000', '#0058e6', '#177dc2', '2px', '', '#177dc2', '', '', '#177dc2', '', '', '#177dc2', '', '', '#177dc2', '', '', '#177dc2', '2px', '', '#177dc2', '', '', '#177dc2', '2px', '', '#177dc2', '', '', '', '', '', '', '', '', '')",
    "images" => array(),
    ),
'EVA 2 Toys degrade' => array(
    /* Th�me adapt� par Olivier Gautier */
    "habillage" => "'eva_style_basic_menu_a_droite.css'",
    "theme" => "('', 'Defaut', '#fff', '#eff7ff', '#eff7ff', '#d4ffbf', '#79c0f2', '#79c0f2', 'transparent', '#d4ffbf', '#d4ffbf', '#79c0f2', '#d4ffbf', '#79c0f2', '#d4ffbf', '#79c0f2', '#aedef5', '#ff7c4c', '#ffea80', '#eff7ff', '#aedef5', '', '#000', '#000', '#000', '#fff2b2', '#000', '#000', '#000', '#000', '#0058e6', '#0058e6', '#000', '#000', '#000', '#000', '#000', '#ff0000', '#000', '#ff0000', '#ff0000', '#0058e6', '#ff0000', '#0058e6', '#ff0000', '#0058e6', '#177dc2', '2px', '', '#177dc2', '', '', '#177dc2', '', '', '#177dc2', '', '', '#177dc2', '', '', '#177dc2', '2px', '', '#177dc2', '', '', '#177dc2', '2px', '', '#177dc2', '', '', '', '', '', '', '', '', '')",
    "images" => array(
    "('', 'image', 'Defaut', 'image_pied', 'Eva/EVAtoys_pied.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_menu', 'Eva/EVAtoys_menu.png', 'right', 'top', 'repeat-y', 'scroll')",
    "('', 'image', 'Defaut', 'image_pied-logo', 'Eva/EVAtoys_logo.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_menu_on', 'Eva/EVAtoys_menu_actif.png', 'right', 'top', 'repeat-y', 'scroll')",
    "('', 'image', 'Defaut', 'image_menu_off', 'Eva/EVAtoys_menu_secteurs.png', 'right', 'top', 'repeat-y', 'scroll')",
    "('', 'image', 'Defaut', 'image_pairs', 'Eva/EVAtoys_pair.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_impairs', 'Eva/EVAtoys_impair.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_titres', 'Eva/EVAtoys_titre_contenu.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_titre_entete', 'Eva/EVAtoys_titre_entete.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_edito_titre', 'Eva/EVAtoys_titre_contenu.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_edito', 'Eva/EVAtoys_contenu.png', 'left', 'top', 'repeat-y', 'scroll')",
    "('', 'image', 'Defaut', 'image_entete_page', 'Eva/EVAtoys_entete.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_barre_entete_arborescence', 'Eva/EVAtoys_arborescence.png', 'left', 'top', 'repeat-x', 'scroll')",
    "('', 'image', 'Defaut', 'image_barre_entete', 'Eva/EVAtoys_liens.png', 'left', 'bottom', 'repeat-x', 'scroll')",
    ), ),
);
return $eva_themes;
}

?>