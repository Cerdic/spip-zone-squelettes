<?php
$EvaHabillageTable = array( 
	"id_habillage" => "INTEGER NOT NULL AUTO_INCREMENT", 
	"habillage" => "TEXT NOT NULL",
	"sauvegarde" => "TEXT NOT NULL"
);

$EvaHabillageTable_key = array( 
	"PRIMARY KEY" => "id_habillage"
);

$EvaHabillageTable_themes = array(
	"id" => "INTEGER NOT NULL AUTO_INCREMENT",
	"nom" => "TEXT NOT NULL",
	"fond_ecran" => "TEXT NOT NULL",
	"fond_page" => "TEXT NOT NULL",
	"fond_bloc" => "TEXT NOT NULL",
	"fond_edito" => "TEXT NOT NULL",
	"fond_titre_edito" => "TEXT NOT NULL",
	"fond_entete_pages" => "TEXT NOT NULL",
	"fond_barres_entete" => "TEXT NOT NULL",
	"fond_barres_entete_arborescence" => "TEXT NOT NULL",
	"fond_barres_entete_auteur" => "TEXT NOT NULL",
	"fond_barres_entete_texte" => "TEXT NOT NULL",
	"fond_titre_article" => "TEXT NOT NULL",
	"fond_pied_pages" => "TEXT NOT NULL",
	"fond_pied_logos" => "TEXT NOT NULL",
	"fond_titres" => "TEXT NOT NULL",
	"fond_menu_fond" => "TEXT NOT NULL",
	"fond_menu_off" => "TEXT NOT NULL",
	"fond_menu_on" => "TEXT NOT NULL",
	"fond_liste_elements_impairs" => "TEXT NOT NULL",
	"fond_liste_elements_pairs" => "TEXT NOT NULL",
	"texte_police_type" => "TEXT NOT NULL",
	"texte_principal" => "TEXT NOT NULL",
	"texte_liste_paire" => "TEXT NOT NULL",
	"texte_liste_impaire" => "TEXT NOT NULL",
	"texte_entetes" => "TEXT NOT NULL",
	"texte_surtitre" => "TEXT NOT NULL",
	"texte_titre" => "TEXT NOT NULL",
	"texte_soustitre" => "TEXT NOT NULL",
	"texte_couleur_liens_menu" => "TEXT NOT NULL",
	"texte_couleur_liens_menu_actif" => "TEXT NOT NULL",
	"texte_couleur_liens_menu_survol" => "TEXT NOT NULL",
	"texte_barres_entete" => "TEXT NOT NULL",
	"texte_premiere_lettre_entete" => "TEXT NOT NULL",
	"texte_edito" => "TEXT NOT NULL",
	"texte_edito_titre" => "TEXT NOT NULL",
	"texte_edito_titre_premier" => "TEXT NOT NULL",
	"texte_entete_arborescence" => "TEXT NOT NULL",
	"texte_auteur" => "TEXT NOT NULL",
	"texte_pied" => "TEXT NOT NULL",
	"lien_couleur_lien" => "TEXT NOT NULL",
	"lien_couleur_lien_survol" => "TEXT NOT NULL",
	"lien_couleur_lien_impair" => "TEXT NOT NULL",
	"lien_couleur_lien_impair_survol" => "TEXT NOT NULL",
	"lien_couleur_lien_pair" => "TEXT NOT NULL",
	"lien_couleur_lien_pair_survol" => "TEXT NOT NULL",
	"bordure_page" => "TEXT NOT NULL",
	"bordure_largeur_page" => "TEXT NOT NULL",
	"bordure_style_page" => "TEXT NOT NULL",
	"bordure_couleur_bordure" => "TEXT NOT NULL",
	"bordure_largeur_couleur_bordure" => "TEXT NOT NULL",
	"bordure_style_couleur_bordure" => "TEXT NOT NULL",
	"bordure_couleur_bordure_entete" => "TEXT NOT NULL",
	"bordure_largeur_couleur_bordure_entete" => "TEXT NOT NULL",
	"bordure_style_couleur_bordure_entete" => "TEXT NOT NULL",
	"bordure_couleur_titre" => "TEXT NOT NULL",
	"bordure_largeur_titre" => "TEXT NOT NULL",
	"bordure_style_titre" =>  "TEXT NOT NULL",
	"bordure_couleur_bordure_auteur" => "TEXT NOT NULL",
	"bordure_largeur_couleur_bordure_auteur" => "TEXT NOT NULL",
	"bordure_style_couleur_bordure_auteur" => "TEXT NOT NULL",
	"bordure_couleur_bordure_edito" => "TEXT NOT NULL",
	"bordure_largeur_couleur_bordure_edito" => "TEXT NOT NULL",
	"bordure_style_couleur_bordure_edito" => "TEXT NOT NULL",
	"bordure_couleur_bordure_pied" => "TEXT NOT NULL",
	"bordure_largeur_couleur_bordure_pied" => "TEXT NOT NULL",
	"bordure_style_couleur_bordure_pied" => "TEXT NOT NULL",
	"bordure_couleur_bordure_menu" => "TEXT NOT NULL",
	"bordure_largeur_couleur_bordure_menu" => "TEXT NOT NULL",
	"bordure_style_couleur_bordure_menu" => "TEXT NOT NULL",
	"bordure_couleur_bordure_menu_secteurs" => "TEXT NOT NULL",
	"bordure_largeur_couleur_bordure_menu_secteurs" => "TEXT NOT NULL",
	"bordure_style_couleur_bordure_menu_secteurs" => "TEXT NOT NULL",
	"taille_largeur_page" => "TEXT NOT NULL",
	"taille_largeur_menu" => "TEXT NOT NULL",
	"taille_largeur_menudroite" => "TEXT NOT NULL",
	"taille_largeur_contenu" => "TEXT NOT NULL",
	"taille_hauteur_entete" => "TEXT NOT NULL",
	"admin_deplacement_horizontal_bouton_admin" => "TEXT NOT NULL",
	"admin_deplacement_vertical_bouton_admin" => "TEXT NOT NULL"
);

$EvaHabillageTable_themes_key = array( 
	"PRIMARY KEY" => "id"
);

$EvaHabillageTable_images = array( 
	"id" => "INTEGER NOT NULL AUTO_INCREMENT",
	"type" => "TEXT NOT NULL",
	"nom_habillage" => "TEXT NOT NULL",
	"nom_div" => "TEXT NOT NULL",
	"nom_image" => "TEXT NOT NULL",
	"pos_x" => "TEXT NOT NULL",
	"pos_y" => "TEXT NOT NULL",
	"repetition" => "TEXT NOT NULL",
	"attach" => "TEXT NOT NULL"
);

$EvaHabillageTable_images_key = array( 
	"PRIMARY KEY" => "id");

$GLOBALS['tables_principales']['spip_eva_habillage'] = 
	array('field' => &$EvaHabillageTable, 'key' => &$EvaHabillageTable_key);

$GLOBALS['tables_principales']['spip_eva_habillage_themes'] = 
	array('field' => &$EvaHabillageTable_themes, 'key' => &$EvaHabillageTable_themes_key);

$GLOBALS['tables_principales']['spip_eva_habillage_images'] = 
	array('field' => &$EvaHabillageTable_images, 'key' => &$EvaHabillageTable_images_key);

?>