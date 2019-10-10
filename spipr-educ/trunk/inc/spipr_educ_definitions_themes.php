<?php
// Définition des divers thèmes proposés
function spipr_educ_definition_themes() {
	$def = array(
		'theme_de_base',
		'terra',
		'spipr_institution',
	);
	return $def;	
}

// Pour chaque thème, on définit les déclinaisons de couleurs qui sont proposées
function spipr_educ_defintion_couleurs($theme) {
	switch ($theme) {
    case 'theme_de_base':
        $retour=array(
			'bleu_clair','IndianRed','LightCoral','Salmon','Red','FireBrick','Maroon','DeepPink','MediumVioletRed','OrangeRed','BlueViolet','DarkOrchid','Purple','Indigo','SlateBlue','DarkSlateBlue','Lime','LimeGreen','SeaGreen','ForestGreen','Green','DarkGreen','OliveDrab','Olive','Teal','SteelBlue','MediumSlateBlue','Blue','DarkBlue','Navy','RosyBrown','DarkGoldenrod','Peru','Chocolate','SaddleBrown','Sienna','SlateGray'
		);
        break;
    case 'terra':
	case 'spipr_institution':
        $retour=array('terra_olive','terra_sapin','terra_amande','terra_vert_imperial','terra_verone','terra_verdure','terra_lime','terra_orange','terra_abricot','terra_carotte','terra_saumon','terra_red','terra_tomato','terra_cramoisi','terra_carmin','terra_pourpre','terra_framboise','terra_fuschia','terra_orchidee','terra_amethyste','terra_darkmagenta','terra_indigo','terra_majorelle','terra_smalt','terra_sarcelle','terra_azur','terra_marine','terra_bleu_nuit','terra_barbeau','terra_bleu_ardoise','terra_ombre','terra_cannelle','terra_bronze');
        break;
	}
	return $retour;
}

// Permet de reprendre une couleur de base lorsqu'on change d'habillage
function spipr_educ_reinitialiser_theme($theme) {
	switch ($theme) {
		case 'theme_de_base' :
			spipr_educ_modif_couleur_theme('theme_de_base','bleu_clair');
		break;
		case 'terra' :
			spipr_educ_modif_couleur_theme('terra','terra_olive');
		break;
		case 'spipr_institution' :
			spipr_educ_modif_couleur_theme('spipr_institution','terra_olive');
		break;
	}
}

// Pour le thème de base, en fonction de la déclinaison de couleurs, on définit le jeu de couleur utile
function spipr_educ_definition_couleurs_theme_de_base($theme_de_couleur) {
	switch ($theme_de_couleur) {
		case 'bleu_clair' :
			// base, base foncée, puis gris (du plus clair au plus fonce)
			$retour=array('#0088cc','#005580');
		break;
		case 'IndianRed' :
			$retour=array('#CD5C5C','#9D3131');
		break;
		case 'LightCoral' :
			$retour=array('#F08080','#C01616');
		break;
		case 'Salmon' :
			$retour=array('#FA8072','#B91806');
		break;
		case 'Red' :
			$retour=array('#FF0000','#910000');
		break;
		case 'FireBrick' :
			$retour=array('#B22222','#7D1717');
		break;
		case 'Maroon' :
			$retour=array('#800000','#550000');
		break;
		case 'DeepPink' :
			$retour=array('#ff1493','#B90066');
		break;
		case 'MediumVioletRed' :
			$retour=array('#c71585','#910F60');
		break;
		case 'OrangeRed' :
			$retour=array('#FF4500','#B33100');
		break;
		case 'BlueViolet' :
			$retour=array('#8A2BE2','#441074');
		break;
		case 'DarkOrchid' :
			$retour=array('#9932CC','#591D76');
		break;
		case 'Purple' :
			$retour=array('#800080','#5E005E');
		break;
		case 'Indigo' :
			$retour=array('#4B0082','#3A0066');
		break;
		case 'SlateBlue' :
			$retour=array('#6A5ACD','#4332A3');
		break;
		case 'DarkSlateBlue' :
			$retour=array('#483D8B','#362E69');
		break;
		case 'Lime' :
			$retour=array('#00FF00','#00A400');
		break;
		case 'LimeGreen' :
			$retour=array('#32CD32','#269B26');
		break;
		case 'SeaGreen' :
			$retour=array('#2E8B57','#267549');
		break;
		case 'ForestGreen' :
			$retour=array('#228B22','#1A681A');
		break;
		case 'Green' :
			$retour=array('#008000','#006400');
		break;
		case 'DarkGreen' :
			$retour=array('#006400','#008000');
		break;
		case 'OliveDrab' :
			$retour=array('#6B8E23','#4E661A');
		break;
		case 'Olive' :
			$retour=array('#808000','#626200');
		break;
		case 'Teal' :
			$retour=array('#008080','#004F4F');
		break;
		case 'SteelBlue' :
			$retour=array('#4682B4','#2F5879');
		break;
		case 'MediumSlateBlue' :
			$retour=array('#7B68EE','#3317D0');
		break;
		case 'Blue' :
			$retour=array('#0000FF','#000082');
		break;
		case 'DarkBlue' :
			$retour=array('#00008B','#00005B');
		break;
		case 'Navy' :
			$retour=array('#000080','#0000D9');
		break;
		case 'RosyBrown' :
			$retour=array('#BC8F8F','#6A4040');
		break;
		case 'DarkGoldenrod' :
			$retour=array('#B8860B','#815C07');
		break;
		case 'Peru' :
			$retour=array('#CD853F','#875523');
		break;
		case 'Chocolate' :
			$retour=array('#D2691E','#793E11');
		break;
		case 'SaddleBrown' :
			$retour=array('#8B4513','#592E0D');
		break;
		case 'Sienna' :
			$retour=array('#A0522D','#733A20');
		break;
		case 'SlateGray' :
			$retour=array('#708090','#465059');
		break;
	}
	return $retour;
}

// Pour le thème de terra, en fonction de la déclinaison de couleurs, on définit le jeu de couleur utile
function spipr_educ_definition_couleurs_theme_terra($theme_de_couleur) {
	switch ($theme_de_couleur) {
		case 'terra_olive' :
			// base, base foncée, une couleur en complément, la même tirée vers le très clair, et pour le thème institution le pourcentage d'éclaircissement pour les dégradés
			$retour=array('#447777','#669999','#999966','#f1f1d9','55%');
		break;
		case 'terra_sapin' :
			$retour=array('#095228','#074220','#3d1e3a','#F9F2F8','80%');
		break;
		case 'terra_amande' :
			$retour=array('#82c46c','#60ae46','#7d3b93','#F8F1FA','50%');
		break;
		case 'terra_vert_imperial' :
			$retour=array('#00561b','#004516','#381a3c','#F8F0F9','80%');
		break;
		case 'terra_verone' :
			$retour=array('#5a6521','#48511a','#2f3357','#F1F2F8','65%');
		break;
		case 'terra_verdure' :
			$retour=array('#009966','#00714D','#AAAA2B','#F2F2CC','65%');
		break;
		case 'terra_lime' :
			$retour=array('#00ff00','#00cc00','#92f200','#FAFFF2','46%');
		break;
		case 'terra_orange' :
			$retour=array('#ff7f00','#cc6600','#5096C9','#ECF3F9','45%');
		break;
		case 'terra_abricot' :
			$retour=array('#e67e30','#c66318','#498FCF','#EBF2FA','40%');
		break;
		case 'terra_carotte' :
			$retour=array('#f4661b','#cf4e0a','#5A8ECD','#E7EEF8','40%');
		break;
		case 'terra_saumon' :
			$retour=array('#f88e55','#f56315','#b0bec5','#E9EDEF','30%');
		break;
		case 'terra_red' :
			$retour=array('#ff0000','#cc0000','#00aaff','#F0FAFF','40%');
		break;
		case 'terra_tomato' :
			$retour=array('#de2916','#b22112','#ba7784','#F9F2F3','50%');
		break;
		case 'terra_cramoisi' :
			$retour=array('#dc143c','#b01030','#a09cb0','#EDEDF1','50%');
		break;
		case 'terra_carmin' :
			$retour=array('#990000','#6C0000','#666600','#FFFFB7','67%');
		break;
		case 'terra_pourpre' :
			$retour=array('#9e0e40','#7e0b33','#579896','#EBF3F3','62%');
		break;
		case 'terra_framboise' :
			$retour=array('#c72c48','#9f233a','#bb757d','#F8EFF0','48%');
		break;
		case 'terra_fuschia' :
			$retour=array('#ff00ff','#cc00cc','#ce29ff','#FBECFF','48%');
		break;
		case 'terra_orchidee' :
			$retour=array('#da70d6','#cc3cc7','#63C788','#E8F7ED','32%');
		break;
		case 'terra_amethyste' :
			$retour=array('#884da7','#6d3e86','#719e64','#EEF3ED','47%');
		break;
		case 'terra_darkmagenta' :
			$retour=array('#8b008b','#6f006f','#008b00','#ECFFEC','70%');
		break;
		case 'terra_indigo' :
			$retour=array('#2e006c','#20004A','#007acc','#ECF8FF','76%');
		break;
		case 'terra_majorelle' :
			$retour=array('#6050dc','#3121A3','#87C2C2','#F0F7F7','35%');
		break;
		case 'terra_smalt' :
			$retour=array('#003399','#00297a','#E89C00','#FFF4DF','65%');
		break;
		case 'terra_sarcelle' :
			$retour=array('#008080','#006666','#522e31','#F8EFEF','70%');
		break;
		case 'terra_azur' :
			$retour=array('#007fff','#0066cc','#B1B744','#F3F4E3','43%');
		break;
		case 'terra_marine' :
			$retour=array('#03224c','#021b3d','#4f4f00','#FFFFE6','80%');
		break;
		case 'terra_bleu_nuit' :
			$retour=array('#0f056b','#0c0456','#304f35','#F0F7F1','75%');
		break;
		case 'terra_barbeau' :
			$retour=array('#5472ae','#425b8c','#a89f62','#F4F3EC','42%');
		break;
		case 'terra_bleu_ardoise' :
			$retour=array('#708090','#596673','#8f8271','#F1EEED','44%');
		break;
		case 'terra_ombre' :
			$retour=array('#926D27','#6D511D','#72BC58','#ECF5E7','60%');
		break;
		case 'terra_cannelle' :
			$retour=array('#7e5835','#65462a','#5a7283','#F1F3F5','60%');
		break;
		case 'terra_bronze' :
			$retour=array('#614e1a','#4e3e15','#2f4861','#F2F5F9','69%');
		break;
	}
	return $retour;
}

// Ici les appels SQL permettant d'adapter les entrées de la BDD lorsqu'on choisit une déclinaison de couleurs dans un thème et un jeu de couleurs choisis
function spipr_educ_modif_couleur_theme($theme,$theme_de_couleur) {
	switch ($theme) {
		case 'theme_de_base' :
			$couleurs_du_theme=spipr_educ_definition_couleurs_theme_de_base($theme_de_couleur);
			$base=$couleurs_du_theme[0];
			$base_foncee=$couleurs_du_theme[1];
			$gris0='#ffffff';
			$gris1='#eeeeee';
			$gris2='#dddddd';
			$gris3='#bbbbbb';
			$gris4='#aaaaaa';
			$gris5='#333333';
				// Couleur des liens du fil Twitter de la page de sommaire
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre6' => $base,
					),
					"type='bloc de base' AND nom='sommaire_twitter' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				// Couleur des textes
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre1' => $gris5,'parametre2' => $base,'parametre3' => $base_foncee,'parametre4' => $base,'parametre5' => $gris5,'parametre6' => $gris5,'parametre7' => '','parametre8' => '','parametre9' => '','parametre10' => '',
					),
					"type='graphisme' AND nom='graphisme_couleur_textes' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				// Carousel / Une
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre1' => $gris1 ,'parametre2' => $gris5,'parametre3' => $gris2,'parametre4' => $base,'parametre5' => $gris0,'parametre6' => $gris3,'parametre7' => $gris4,'parametre8' => $gris3,'parametre9' => $base,'parametre10' => $gris0,
					),
					"type='graphisme' AND nom='graphisme_carousel' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre1' => $gris2,'parametre2' => $base,'parametre3' => '','parametre4' => '','parametre5' => '','parametre6' => '','parametre7' => '','parametre8' => '','parametre9' => '','parametre10' => '',
					),
					"type='graphisme' AND nom='graphisme_carousel_2' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				// Editorial
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre1' => $gris1,'parametre2' => $base,'parametre3' => $gris5,'parametre4' => '','parametre5' => '','parametre6' => '','parametre7' => '','parametre8' => '','parametre9' => '','parametre10' => '',
					),
					"type='graphisme' AND nom='graphisme_editorial_hero' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				// Typographie
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre1' => '','parametre2' => '','parametre3' => '','parametre4' => '','parametre5' => '14','parametre6' => '20','parametre7' => '','parametre8' => '','parametre9' => '','parametre10' => '',
					),
					"type='graphisme' AND nom='graphisme_typographie' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				// Tableaux
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre1' => '','parametre2' => '','parametre3' => '','parametre4' => 'non','parametre5' => '','parametre6' => '','parametre7' => '','parametre8' => '','parametre9' => '','parametre10' => '',
					),
					"type='graphisme' AND nom='graphisme_tableaux' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				// Paginations
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre1' => '','parametre2' => '','parametre3' => '','parametre4' => 'right','parametre5' => '','parametre6' => '','parametre7' => '','parametre8' => '','parametre9' => '','parametre10' => '',
					),
					"type='graphisme' AND nom='graphisme_pagination' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				// Blocs dyslexie
				$noms_blocs_dys=array('sommaire_dyslexie','article_dyslexie','rubrique_dyslexie','breve_dyslexie','site_dyslexie','auteur_dyslexie','autre_dyslexie');
				foreach ($noms_blocs_dys as $bloc_dys) {
					sql_updateq(
						'spip_spipr_educ',
						array(
							'parametre5' => '','parametre6' => '','parametre7' => '','parametre8' => '',
						),
						"type='bloc de base' AND nom='$bloc_dys' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
					);
				}
				// Bloc des logos
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre6' => '','parametre7' => '','parametre8' => '','parametre9' => '',
					),
					"type='graphisme' AND nom='graphisme_bloc_logos' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				// Bloc des liens vers les partenaires
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre1' => '','parametre2' => '','parametre3' => '','parametre4' => '','parametre5' => '','parametre6' => '','parametre7' => '','parametre9' => '','parametre10' => '',
					),
					"type='graphisme' AND nom='graphisme_liens_partenaires' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				// Menu horizontal : icônes
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre1' => 'oui','parametre2' => 'non','parametre3' => 'non','parametre4' => 'non','parametre5' => '','parametre6' => '','parametre7' => '','parametre8' => '','parametre9' => '','parametre10' => '',
					),
					"type='graphisme' AND nom='graphisme_menu_icones' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				// Menu déroulant
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre1' => '','parametre2' => '','parametre3' => '','parametre4' => '','parametre5' => $base,'parametre6' => '','parametre7' => '','parametre8' => $base,'parametre9' => $base,'parametre10' => '',
					),
					"type='graphisme' AND nom='graphisme_menu_deroulant' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				
				// Marges
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre1' => 'non',
					),
					"type='graphisme' AND nom='graphisme_marges' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				// Ensemble des entrées dont les 10 paramètres sont vidés
				$a_vider=array(
					'graphisme_formulaires', // Formulaires
					// Les blocs perso
					'autre_bloc_perso_1','autre_bloc_perso_2','autre_bloc_perso_3',
					'auteur_bloc_perso_1','auteur_bloc_perso_2','auteur_bloc_perso_3',
					'site_bloc_perso_1','site_bloc_perso_2','site_bloc_perso_3',
					'breve_bloc_perso_1','breve_bloc_perso_2','breve_bloc_perso_3',
					'rubrique_bloc_perso_1','rubrique_bloc_perso_2','rubrique_bloc_perso_3',
					'article_bloc_perso_1','article_bloc_perso_2','article_bloc_perso_3',
					'sommaire_bloc_perso_1','sommaire_bloc_perso_2','sommaire_bloc_perso_3',
					'graphisme_fil_ariane', //fil d'ariane
					'graphisme_css', // CSS
					'graphisme_couleur_fond', // Couleurs des fonds
					'graphisme_menu_horizontal', // Menu horizontal
					'graphisme_menu_vertical', // Menu vertical
				);	
				foreach ($a_vider as $nom_bloc) {
					sql_updateq(
						'spip_spipr_educ',
						array(
							'parametre1' => '','parametre2' => '','parametre3' => '','parametre4' => '','parametre5' => '','parametre6' => '','parametre7' => '','parametre8' => '','parametre9' => '','parametre10' => '',
						),
						"type='graphisme' AND nom='$nom_bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
					);
				}
				
				// Up du nom et de la déclinaison du thème $theme,$theme_de_couleur
				sql_updateq(
					'spip_spipr_educ',
					array(
						'nom' => $theme,'parametre1' => $theme_de_couleur,'parametre2' => '','parametre3' => '','parametre4' => '','parametre5' => '','parametre6' => '','parametre7' => '','parametre8' => '','parametre9' => '','parametre10' => '',
					),
					"type='theme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				$retour='ok';
			break;

		case 'terra' :
			$couleurs_du_theme=spipr_educ_definition_couleurs_theme_terra($theme_de_couleur);
			$couleur1=$couleurs_du_theme[0];
			$couleur1bis=$couleurs_du_theme[1];
			$couleur2=$couleurs_du_theme[2];
			$couleur2bis=$couleurs_du_theme[3];
			$gris0='#ffffff';
			$gris1='#f9f9f9';
			$gris2='#e8e8e8';
			$gris3='#e1e1e1';
			$gris4='#dddddd';
			$gris5='#cccccc';
			$gris6='#bbbbbb';
			$gris7='#aaaaaa';
			$gris8='#777777';
			$gris9='#666666';
			$gris10='#555555';
				// Couleur des liens du fil Twitter de la page de sommaire
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre6' => $couleur1,
					),
					"type='bloc de base' AND nom='sommaire_twitter' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				// Couleur des textes
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre1' => $gris9,'parametre2' => $couleur1bis,'parametre3' => $couleur1,'parametre4' => $couleur1,'parametre5' => $couleur2,'parametre6' => $couleur2,'parametre7' => '','parametre8' => '','parametre9' => '','parametre10' => '',
					),
					"type='graphisme' AND nom='graphisme_couleur_textes' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				// Carousel / Une
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre1' => $gris1 ,'parametre2' => $gris10,'parametre3' => $couleur1,'parametre4' => $couleur1,'parametre5' => $gris0,'parametre6' => $gris6,'parametre7' => $gris7,'parametre8' => $gris6,'parametre9' => $couleur1,'parametre10' => $gris0,
					),
					"type='graphisme' AND nom='graphisme_carousel' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre1' => $gris4,'parametre2' => $couleur1,'parametre3' => '',
					),
					"type='graphisme' AND nom='graphisme_carousel_2' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				// Editorial
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre1' => $gris1,'parametre2' => $couleur2,'parametre3' => $gris10,'parametre4' => '','parametre5' => '','parametre6' => '','parametre7' => '','parametre8' => '','parametre9' => '','parametre10' => '',
					),
					"type='graphisme' AND nom='graphisme_editorial_hero' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				// Typographie
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre1' => '','parametre2' => '','parametre3' => '','parametre4' => '','parametre5' => '14','parametre6' => '20','parametre7' => '','parametre8' => '','parametre9' => '','parametre10' => '',
					),
					"type='graphisme' AND nom='graphisme_typographie' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				// Couleurs des fonds
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre1' => '','parametre2' => '','parametre3' => '','parametre4' => '','parametre5' => '','parametre6' => '','parametre7' => '','parametre8' => '','parametre9' => '','parametre10' => '',
					),
					"type='graphisme' AND nom='graphisme_couleur_fond' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				
				// Tableaux
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre1' => $gris0,'parametre2' => $gris1,'parametre3' => $gris1,'parametre4' => 'oui','parametre5' => $gris4,'parametre6' => '','parametre7' => '','parametre8' => '','parametre9' => '','parametre10' => '',
					),
					"type='graphisme' AND nom='graphisme_tableaux' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				// Paginations
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre1' => $gris0,'parametre2' => $gris1,'parametre3' => $gris4,'parametre4' => 'right','parametre5' => '','parametre6' => '','parametre7' => '','parametre8' => '','parametre9' => '','parametre10' => '',
					),
					"type='graphisme' AND nom='graphisme_pagination' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				// Blocs dyslexie
				$noms_blocs_dys=array('sommaire_dyslexie','article_dyslexie','rubrique_dyslexie','breve_dyslexie','site_dyslexie','auteur_dyslexie','autre_dyslexie');
				foreach ($noms_blocs_dys as $bloc_dys) {
					sql_updateq(
						'spip_spipr_educ',
						array(
							'parametre5' => $gris1,'parametre6' => '','parametre7' => $gris0,'parametre8' => 'box-shadow:0 0 10px '.$gris7.'; padding:10px;',
						),
						"type='bloc de base' AND nom='$bloc_dys' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
					);
				}
				// Bloc des logos
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre6' => $couleur1,'parametre7' => $gris0,'parametre8' => '','parametre9' => 'padding:10px; box-shadow: 0px 0px 6px '.$gris7.';',
					),
					"type='graphisme' AND nom='graphisme_bloc_logos' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				// Bloc des liens vers les partenaires
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre2' => $gris0,'parametre3' => $gris2,'parametre4' => '','parametre5' => $couleur1bis,'parametre6' => $couleur1,'parametre7' => '','parametre9' => $gris3,'parametre10' => '',
					),
					"type='graphisme' AND nom='graphisme_liens_partenaires' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				// Menu vertical
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre1' => $gris0,'parametre2' => $couleur2bis,'parametre3' => $gris0,'parametre4' => $couleur1,'parametre5' => $gris0,'parametre6' => $couleur1bis,'parametre7' => $gris0,'parametre8' => $couleur1,'parametre9' => 'box-shadow : 2px 2px 6px '.$gris5.';','parametre10' => '',
					),
					"type='graphisme' AND nom='graphisme_menu_vertical' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				// Menu horizontal
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre1' => $couleur1,'parametre2' => $couleur1,'parametre3' => $couleur1,'parametre4' => $gris0,'parametre5' => $gris0,'parametre6' => $gris0,'parametre7' => $gris0,'parametre8' => $couleur1bis,'parametre9' => $couleur1bis,'parametre10' => '40',
					),
					"type='graphisme' AND nom='graphisme_menu_horizontal' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				// Menu horizontal : icônes
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre1' => 'non','parametre2' => 'non','parametre3' => 'non','parametre4' => 'non','parametre5' => '','parametre6' => '','parametre7' => '','parametre8' => '','parametre9' => '','parametre10' => '',
					),
					"type='graphisme' AND nom='graphisme_menu_icones' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				// Menu déroulant
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre1' => $gris0,'parametre2' => $gris7,'parametre3' => $gris2,'parametre4' => $gris0,'parametre5' => $couleur1,'parametre6' => $gris0,'parametre7' => $gris0,'parametre8' => $couleur1bis,'parametre9' => $couleur1,'parametre10' => 'non',
					),
					"type='graphisme' AND nom='graphisme_menu_deroulant' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				// Formulaires
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre1' => '','parametre2' => '','parametre3' => '','parametre4' => 'box-shadow:0 0 8px '.$gris8.';',
					),
					"type='graphisme' AND nom='graphisme_formulaires' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);				
				// Marges
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre1' => 'oui',
					),
					"type='graphisme' AND nom='graphisme_marges' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				// Fil d'ariane
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre1' => $couleur2bis,'parametre2' => $gris0,'parametre3' => $couleur1bis,'parametre4' => $couleur1,'parametre5' => '','parametre6' => '','parametre7' => '','parametre8' => '','parametre9' => '','parametre10' => '',
					),
					"type='graphisme' AND nom='graphisme_fil_ariane' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				// CSS
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre1' => '.container {box-shadow:6px 0 6px #CCC,-6px 0 6px #CCC;} #nav .menu {border:none;}','parametre2' => '','parametre3' => '','parametre4' => '','parametre5' => '','parametre6' => '','parametre7' => '','parametre8' => '','parametre9' => '','parametre10' => '',
					),
					"type='graphisme' AND nom='graphisme_css' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				// Ensemble des entrées dont les 10 paramètres sont vidés
				$a_vider=array(
					// Les blocs perso
					'autre_bloc_perso_1','autre_bloc_perso_2','autre_bloc_perso_3',
					'auteur_bloc_perso_1','auteur_bloc_perso_2','auteur_bloc_perso_3',
					'site_bloc_perso_1','site_bloc_perso_2','site_bloc_perso_3',
					'breve_bloc_perso_1','breve_bloc_perso_2','breve_bloc_perso_3',
					'rubrique_bloc_perso_1','rubrique_bloc_perso_2','rubrique_bloc_perso_3',
					'article_bloc_perso_1','article_bloc_perso_2','article_bloc_perso_3',
					'sommaire_bloc_perso_1','sommaire_bloc_perso_2','sommaire_bloc_perso_3',
					
				);	
				foreach ($a_vider as $nom_bloc) {
					sql_updateq(
						'spip_spipr_educ',
						array(
							'parametre1' => '','parametre2' => '','parametre3' => '','parametre4' => '','parametre5' => '','parametre6' => '','parametre7' => '','parametre8' => '','parametre9' => '','parametre10' => '',
						),
						"type='graphisme' AND nom='$nom_bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
					);
				}
				
				// Up du nom et de la déclinaison du thème $theme,$theme_de_couleur
				sql_updateq(
					'spip_spipr_educ',
					array(
						'nom' => $theme,'parametre1' => $theme_de_couleur,'parametre2' => '','parametre3' => '','parametre4' => '','parametre5' => '','parametre6' => '','parametre7' => '','parametre8' => '','parametre9' => '','parametre10' => '',
					),
					"type='theme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				$retour='ok';
			break;
			
			case 'spipr_institution' :
			$couleurs_du_theme=spipr_educ_definition_couleurs_theme_terra($theme_de_couleur);
			$couleur1=$couleurs_du_theme[0];
			$couleur1bis=$couleurs_du_theme[1];
			$couleur2=$couleurs_du_theme[2];
			$couleur2bis=$couleurs_du_theme[3];
			$degrade=$couleurs_du_theme[4];
			$gris0='#ffffff';
			$gris1='#f9f9f9';
			$gris2='#e8e8e8';
			$gris3='#e1e1e1';
			$gris4='#dddddd';
			$gris5='#cccccc';
			$gris6='#bbbbbb';
			$gris7='#aaaaaa';
			$gris8='#777777';
			$gris9='#666666';
			$gris10='#555555';
				// Couleur des liens du fil Twitter de la page de sommaire
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre6' => $couleur1,
					),
					"type='bloc de base' AND nom='sommaire_twitter' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				// Couleur des textes
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre1' => $gris9,'parametre2' => $couleur1bis,'parametre3' => $couleur1,'parametre4' => $couleur1,'parametre5' => $couleur2,'parametre6' => $couleur2,'parametre7' => '','parametre8' => '','parametre9' => '','parametre10' => '',
					),
					"type='graphisme' AND nom='graphisme_couleur_textes' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				// Carousel / Une
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre1' => $gris1 ,'parametre2' => $gris10,'parametre3' => $couleur1,'parametre4' => $couleur1,'parametre5' => $gris0,'parametre6' => $gris6,'parametre7' => $gris7,'parametre8' => $gris6,'parametre9' => $couleur1,'parametre10' => $gris0,
					),
					"type='graphisme' AND nom='graphisme_carousel' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre1' => $gris4,'parametre2' => $couleur1,'parametre3' => '',
					),
					"type='graphisme' AND nom='graphisme_carousel_2' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				// Editorial
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre1' => $gris1,'parametre2' => $couleur2,'parametre3' => $gris10,'parametre4' => '','parametre5' => '','parametre6' => '','parametre7' => '','parametre8' => '','parametre9' => '','parametre10' => '',
					),
					"type='graphisme' AND nom='graphisme_editorial_hero' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				// Typographie
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre1' => '','parametre2' => '','parametre3' => '','parametre4' => '','parametre5' => '14','parametre6' => '20','parametre7' => '','parametre8' => '','parametre9' => '','parametre10' => '',
					),
					"type='graphisme' AND nom='graphisme_typographie' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				// Couleurs des fonds
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre1' => '','parametre2' => '','parametre3' => '','parametre4' => '','parametre5' => '','parametre6' => '','parametre7' => '','parametre8' => '','parametre9' => '','parametre10' => '',
					),
					"type='graphisme' AND nom='graphisme_couleur_fond' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				
				// Tableaux
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre1' => $gris0,'parametre2' => $gris1,'parametre3' => $gris1,'parametre4' => 'oui','parametre5' => $gris4,'parametre6' => '','parametre7' => '','parametre8' => '','parametre9' => '','parametre10' => '',
					),
					"type='graphisme' AND nom='graphisme_tableaux' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				// Paginations
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre1' => $gris0,'parametre2' => $gris1,'parametre3' => $gris4,'parametre4' => 'right','parametre5' => '','parametre6' => '','parametre7' => '','parametre8' => '','parametre9' => '','parametre10' => '',
					),
					"type='graphisme' AND nom='graphisme_pagination' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				// Blocs dyslexie
				$noms_blocs_dys=array('sommaire_dyslexie','article_dyslexie','rubrique_dyslexie','breve_dyslexie','site_dyslexie','auteur_dyslexie','autre_dyslexie');
				foreach ($noms_blocs_dys as $bloc_dys) {
					sql_updateq(
						'spip_spipr_educ',
						array(
							'parametre5' => $gris1,'parametre6' => '','parametre7' => $gris0,'parametre8' => 'box-shadow:0 0 10px '.$gris7.'; padding:10px;',
						),
						"type='bloc de base' AND nom='$bloc_dys' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
					);
				}
				// Bloc des logos
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre6' => $couleur1,'parametre7' => $gris0,'parametre8' => '','parametre9' => 'padding:10px; box-shadow: 0px 0px 6px '.$gris7.';',
					),
					"type='graphisme' AND nom='graphisme_bloc_logos' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				// Bloc des liens vers les partenaires
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre2' => $gris0,'parametre3' => $gris2,'parametre4' => '','parametre5' => $couleur1bis,'parametre6' => $couleur1,'parametre7' => '','parametre9' => $gris3,'parametre10' => '',
					),
					"type='graphisme' AND nom='graphisme_liens_partenaires' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				// Menu vertical
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre1' => $gris0,'parametre2' => $couleur2bis,'parametre3' => $gris0,'parametre4' => $couleur1,'parametre5' => $gris0,'parametre6' => $couleur1bis,'parametre7' => $gris0,'parametre8' => $couleur1,'parametre9' => 'box-shadow : 2px 2px 6px '.$gris5.';','parametre10' => '',
					),
					"type='graphisme' AND nom='graphisme_menu_vertical' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				// Menu horizontal
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre1' => $couleur1,'parametre2' => $couleur1,'parametre3' => $couleur1,'parametre4' => $gris0,'parametre5' => $gris0,'parametre6' => $gris0,'parametre7' => $gris0,'parametre8' => $couleur1bis,'parametre9' => $couleur1bis,'parametre10' => '40',
					),
					"type='graphisme' AND nom='graphisme_menu_horizontal' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				// Menu horizontal : icônes
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre1' => 'non','parametre2' => 'non','parametre3' => 'non','parametre4' => 'non','parametre5' => '','parametre6' => '','parametre7' => '','parametre8' => '','parametre9' => '','parametre10' => '',
					),
					"type='graphisme' AND nom='graphisme_menu_icones' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				// Menu déroulant
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre1' => $gris0,'parametre2' => $gris7,'parametre3' => $gris2,'parametre4' => $gris0,'parametre5' => $couleur1,'parametre6' => $gris0,'parametre7' => $gris0,'parametre8' => $couleur1bis,'parametre9' => $couleur1,'parametre10' => 'non',
					),
					"type='graphisme' AND nom='graphisme_menu_deroulant' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				// Formulaires
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre1' => '','parametre2' => '','parametre3' => '','parametre4' => 'box-shadow:0 0 8px '.$gris8.';',
					),
					"type='graphisme' AND nom='graphisme_formulaires' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);				
				// Marges
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre1' => 'oui',
					),
					"type='graphisme' AND nom='graphisme_marges' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				// Fil d'ariane
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre1' => $couleur2bis,'parametre2' => $gris0,'parametre3' => $couleur1bis,'parametre4' => $couleur1,'parametre5' => '','parametre6' => '','parametre7' => '','parametre8' => '','parametre9' => '','parametre10' => '',
					),
					"type='graphisme' AND nom='graphisme_fil_ariane' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
				// CSS
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre1' =>						
'/* ---------------------------------------------- */
/* CSS spécifiques thème Académie Rouen */
/* ---------------------------------------------- */

/* -- Base CSS : ombre gauche et droite -- */
.container {box-shadow:6px 0 6px '.$gris5.',-6px 0 6px '.$gris5.';}
#nav .menu {border:none;}

/* -- CSS du pied de page -- */
#footer, #footer.footer {width:100%; padding:0; margin:0;}
#pied {position : relative; clear:both; display:block; background-image:linear-gradient('.$gris0.', lighten('.$couleur1.', '.$degrade.'));}
ul#pied  {margin: 0; padding :0; list-style:none;}
ul#pied li {padding:0; margin:0; text-indent:none; list-style-position:outside; list-style:none;}
ul#pied li.pied_cat {padding: 2% 3%; width:94%; background:none;}
ul#pied .pied_label {width:30%; text-transform:uppercase; display:inline-block; float:left;}
ul#pied ul.pied_liste {width:64%; display:inline-block; float:right;}
li.avec_separateur{border-bottom : 1px solid '.$gris10.';}
#pied li.pied_niv2 {float:left; padding:0 1%; margin: 0;}
#pied li.pied_niv2.avec_separateur_niv2 {border-right: 1px solid '.$gris10.';}
#pied li.pied_niv2, #pied li.pied_niv2 a {font-size : 92%; text-decoration:none;}
#pied li.ecart_gauche {padding-left:10%;}
.liste_DSDEN {padding-top:0.5em;}
#footer-plain {margin:0; padding:0px 2%; text-align:center; width:96%; background-color:'.$couleur1.'; color:'.$gris0.';}
#footer-plain li {padding:0.4% 1%; float:left; color :'.$gris0.'; list-style:none;}
#footer-plain li a {font-size:92%; color :'.$gris0.'; text-decoration:none;}

/* -- CSS entête -- */
header.accueil  h1#logo_site_spip img{position:absolute; left:0; top:0; max-width:200px; max-height:100px; margin:auto;}
header.accueil  h1#logo_site_spip #header_separation {position:absolute; left:234px; top:10px; width:2px; height:80px; background-color:'.$gris7.';}
header.accueil  h1#logo_site_spip #nom_site_spip {position:absolute; left:240px; top:35px;}
div#header div#liens_partenaires {margin-bottom:0;}

@media (min-width: 1200px) {
	#menu_racine {width:1140px;}
	header.accueil {margin:0; padding:0; top:0; left:0; width:1170px; height:120px;}
	header.accueil  h1#logo_site_spip {position:absolute; left:30px; top:10px; width: 1140px; height:100px;}
	header.accueil  h1#logo_site_spip #slogan_site_spip {position:absolute; right:30px; bottom:0; width:806px;}
	#header_recherche div#formulaire_recherche {position:absolute; right:20px; width:300px; top:45px; margin:0; padding:0;}
	#header_recherche div#formulaire_recherche.formulaire_spip.formulaire_recherche form div input#recherche {width:220px; margin:0;  margin-right:10px;}
	header.accueil  h1#logo_site_spip #nom_site_spip {width:520px; top:10px;}
}
@media (min-width: 980px) and (max-width: 1199px) {
	#menu_racine {width:880px;}
	header.accueil {margin:0; padding:0, top:0, left:0; width:940px; height:120px;}
	header.accueil  h1#logo_site_spip {position:absolute; left:30px; top:10px; width:910px; height:100px;}
	header.accueil  h1#logo_site_spip #slogan_site_spip {position:absolute; right:30px; bottom:0; width:576px;}
	#header_recherche div#formulaire_recherche {position:absolute; right:20px; width:240px; top:45px; margin:0; padding:0;}
	#header_recherche div#formulaire_recherche.formulaire_spip.formulaire_recherche form div input#recherche {width:160px; margin:0; margin-right:10px;}
	header.accueil  h1#logo_site_spip #nom_site_spip {width:360px; top:10px;}
}
@media (min-width: 768px) and(max-width: 979px) {
	#menu_racine {width:670px;}
	header.accueil {margin:0; padding:0, top:0, left:0; width:720px; height:120px;}
	header.accueil  h1#logo_site_spip {position:absolute; left:30px; top:10px; width:690px; height:100px;}
	header.accueil  h1#logo_site_spip #slogan_site_spip {position:absolute; text-align:right; right:30px; bottom:0; width:356px;  font-size:0.6em;}
	#header_recherche div#formulaire_recherche {position:absolute; right:20px; width:200px; top:10px; margin:0; padding:0;}
	#header_recherche div#formulaire_recherche.formulaire_spip.formulaire_recherche form div input#recherche {width:120px; margin:0; margin-right:10px;}
	header.accueil  h1#logo_site_spip #nom_site_spip {width:380px; top:25px;  font-size:0.9em;}
}
@media (max-width: 767px) {
	header.accueil {margin:0; padding:0, top:0, left:0; width:100%; height:120px;}
	header.accueil  h1#logo_site_spip {position:absolute; left:30px; top:10px; height:100px; width: ~"calc(100% - 60px)";}
	header.accueil  h1#logo_site_spip img {width:100px; height:50px; top:25px;}
	header.accueil  h1#logo_site_spip #nom_site_spip {position:absolute; left:100px; top:30px; width:~"calc(100% - 100px)"; font-size:0.75em;}
	header.accueil  h1#logo_site_spip #header_separation {display:none;}
	header.accueil  h1#logo_site_spip #slogan_site_spip {position:absolute; right:0; bottom:0; width:~"calc(100% - 100px)"; text-align:right; font-size:0.45em;}
	#header_recherche div#formulaire_recherche {position:absolute; right:0; width:220px; top:10px; margin:0; padding:0;}
	#header_recherche div#formulaire_recherche.formulaire_spip.formulaire_recherche form div input#recherche {width:120px; margin:0; margin-right:10px;}
}

@media (max-width: 500px) {
	header.accueil  h1#logo_site_spip #nom_site_spip {font-size:0.5em;}
	header.accueil  h1#logo_site_spip #slogan_site_spip {font-size:0.35em;}
}

#spipr_menu_langue{position: absolute; right:30px; bottom: 10px; width:200px;}

/* ------------------------------------------ */
/* --- Menu de navigation horizontal --- */
/* ------------------------------------------ */

/* -- Tailles items menu déplié -- */
@media (min-width: 1200px) {
	.plan_rubriques li.rub {width:275px;}
	.plan_rubriques ul.sous_rubriques_CE {width:265px;}
	.plan_rubriques li.rub span {width: 265px;}
}
@media (min-width: 980px) and (max-width:1199px) {
	.plan_rubriquesli.rub {width:290px;}
	.plan_rubriques ul.sous_rubriques_CE {width:280px;}
	.plan_rubriques li.rub span {width:280px;}
}
@media (min-width: 768px) and (max-width:979px){
	.plan_rubriques li.rub {width:220px;}
	.plan_rubriques ul.sous_rubriques_CE {width:210px;}
	.plan_rubriques li.rub span {width:210px;}
}

.caret {vertical-align:middle;}
#sous_menu{
	width: 100%;
	display:block;
	background:'.$gris0.';
}

.encart_menu_rub {
	width: 100%;
	position:relative;
	padding: 0px 0px 25px 0px;
	display:none;
	border-bottom : 2px solid '.$gris6.';
	min-height:0;
	background-image:linear-gradient('.$gris0.', lighten('.$couleur1.', '.$degrade.'));
}
.sous_rubrique_active {display:block;}
.plan_rubriques {
	margin-top:10px;
	float:left;
	width:100%;
}
.acces {
	position:absolute;
	bottom:5px;
	right:15px;
	font-size:11px;
	font-weight:normal;
	height:20px;
}
.acces a {text-decoration:none;}
.acces a.fermer_menu {
	color:'.$gris10.';
	background-color:'.$gris0.';
	border:1px solid '.$gris10.';
	padding:2px 5px;
	margin-left:10px;
}

.plan_rubriques li {margin:0; padding:0;}
.plan_rubriques ul {
	padding:0;
	margin:0;
	padding-left:15px;
	list-style-type:none;
}
.plan_rubriques li {margin:0; padding:0;}
.plan_rubriques li.rub {
	float:left;
	margin:0 0 10px 0;
	padding:2px 5px 5px;
}
.plan_rubriques ul.sous_rubriques_CE {
	float:none;
	padding:5px 5px 5px 10px;
	list-style-type:disc;
	list-style-position:inside;
}
.plan_rubriques ul.sous_rubriques_CE li {margin:0; padding:0;}

.plan_rubriques li.rub span {
	padding:0px 0px 0px 10px;
	display:block;
}
.plan_rubriques a {text-decoration:none;}
a.sous_rub_link {
	font-size:12px;
	font-weight:bold;
}
a.sous_sous_rub {color:'.$gris10.';}

/* ------------------------------------------ */
/* --------- Adaptations menus --------- */
/* ------------------------------------------ */
@media (min-width: 768px) {
	#menu_racine div.encart_menu_rub, #menu_racine .encart_menu_rub div.plan_rubriques, #menu_racine .encart_menu_rub div.acces {display:none;margin:0; padding:0; border:none; height:0; width:0; line-height:0;}
}
@media (max-width:767px){
	#sous_menu {display:none;}
	#menu_racine .encart_menu_rub div.plan_rubriques {
		margin:0;
		padding:10px 0;
		background-image:linear-gradient('.$gris0.', lighten('.$couleur1.', '.$degrade.'));
	}
	#menu_racine .encart_menu_rub div.acces {position:relative; text-align:right;}
}
/* ------------------------------------------ */
/* -------- Adaptations carousel -------- */
/* ------------------------------------------ */

#header .carousel {background-image:linear-gradient(#ffffff, lighten('.$couleur1.', '.$degrade.'));
border-left:none; border-right:none;}
#header h2.titre-du-carousel {display:none;}
#header .carousel strong a span.titre {font-weight:normal;}

@media (min-width: 1200px) {
	#header .carousel, #header .carousel .carousel-inner .item article  {height:279px;}
	.de_980_a_1200,.de_768_a_980,.moins_de_768 {display:none;}
	.carousel .carousel-stop {left:12%;}
	.carousel ol.carousel-indicators{left:16%;}
}

@media (min-width: 980px) and (max-width:1199px) {
	#header .carousel, #header .carousel .carousel-inner .item article  {height:228px;}
	#header .carousel .carousel-inner .item article span.img {width:555px; height:228px;}
	.plus_de_1200,.de_768_a_980,.moins_de_768 {display:none;}
	.carousel .carousel-stop {left:12%;}
	.carousel ol.carousel-indicators{left:16%;}
}

@media (min-width: 768px) and (max-width:980px) {
	#header .carousel, #header .carousel .carousel-inner .item article  {height:178px;}
	#header .carousel .carousel-inner .item article span.img {width:555px; height:178px;}
	.plus_de_1200,.de_980_a_1200,.moins_de_768 {display:none;}
	.carousel .carousel-stop {left:12%;}
	.carousel ol.carousel-indicators{left:16%;}
}
@media (max-width:767px) {
	#header .carousel .carousel-inner .item article  strong.moins_de_768 {height:350px; text-align:center;}
	#header .carousel .carousel-inner .item article  strong.moins_de_768  .logo_moins_de_768{
		display:block;
		position:relative;
		float:left;
		width:100%;
	max-height:150px;
	}
	#header .carousel .carousel-inner .item article  strong.moins_de_768  .logo_moins_de_768 img{
		text-align:center;
		max-height:150px;
	}
	#header .carousel .carousel-inner .item article  strong.moins_de_768  .titre_moins_de_768 {
		display:block;
		position:relative;
		width:100%;
		float:left;
		text-align:center; 
		min-height:50px;
	}
	.plus_de_1200,.de_980_a_1200,.de_768_a_980 {display:none;}
	.carousel .carousel-stop {left:42%;}
	.carousel ol.carousel-indicators{left:50%;}
}
',
					'parametre2' => '','parametre3' => '','parametre4' => '','parametre5' => '','parametre6' => '','parametre7' => '','parametre8' => '','parametre9' => '','parametre10' => '',
				),
				"type='graphisme' AND nom='graphisme_css' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
			);
			// Placer le carousel en bas de l'entête du sommaire
			sql_updateq(
				'spip_spipr_educ',
				array(
					'parametre2' => 'header','parametre3' => '999',
				),
				"type='bloc de base' AND nom='sommaire_carousel' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr' AND parametre1='sommaire'"
			);
			include_spip('inc/spipr_educ_deplacement_bloc');
			spipr_educ_bloc_ranger('sommaire','header');
			
			// Ensemble des entrées dont les 10 paramètres sont vidés
			$a_vider=array(
				// Les blocs perso
				'autre_bloc_perso_1','autre_bloc_perso_2','autre_bloc_perso_3',
				'auteur_bloc_perso_1','auteur_bloc_perso_2','auteur_bloc_perso_3',
				'site_bloc_perso_1','site_bloc_perso_2','site_bloc_perso_3',
				'breve_bloc_perso_1','breve_bloc_perso_2','breve_bloc_perso_3',
				'rubrique_bloc_perso_1','rubrique_bloc_perso_2','rubrique_bloc_perso_3',
				'article_bloc_perso_1','article_bloc_perso_2','article_bloc_perso_3',
				'sommaire_bloc_perso_1','sommaire_bloc_perso_2','sommaire_bloc_perso_3',
				
			);	
			foreach ($a_vider as $nom_bloc) {
				sql_updateq(
					'spip_spipr_educ',
					array(
						'parametre1' => '','parametre2' => '','parametre3' => '','parametre4' => '','parametre5' => '','parametre6' => '','parametre7' => '','parametre8' => '','parametre9' => '','parametre10' => '',
					),
					"type='graphisme' AND nom='$nom_bloc' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
				);
			}
			
			// Up du nom et de la déclinaison du thème $theme,$theme_de_couleur
			sql_updateq(
				'spip_spipr_educ',
				array(
					'nom' => $theme,'parametre1' => $theme_de_couleur,'parametre2' => '','parametre3' => '','parametre4' => '','parametre5' => '','parametre6' => '','parametre7' => '','parametre8' => '','parametre9' => '','parametre10' => '',
				),
				"type='theme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'"
			);
			$retour='ok';
		break;
	}
	return $retour;
}
?>