<?php
// Fichier qui sert à injecter les entrées minimales dans la base de données pour un bon fonctionnement si elles ne sont pas présentes
// Les numéros des layout sont stockés dans parametre1, les 3 paramètres suivants servent à stocker les largeurs de colonnes

// Nom de la table du plugin
$Table='spip_spipr_educ';
//Nom de la sauvegarde correspondant aux paramètres en cours d'utilisation
$Nom_sauve='en_cours_d_utilisation_SPIPr';

// Test de présence d'un layout pour une largeur supérieure à 1200px
include_spip('inc/spipr_educ_structure_responsive');
$largeurs_colonnes = spipr_educ_definition_largeurs_colonnes();
$test_layout_1200_sql=sql_select('parametre1',$Table,"nom='layout_1200' AND nom_sauvegarde='$Nom_sauve'");
$tab_test_layout_1200=sql_fetch($test_layout_1200_sql);
$test_layout_1200=$tab_test_layout_1200['parametre1'];
if (!$test_layout_1200) {
	sql_insertq($Table,array(
		'nom'=>'layout_1200',
		'type'=>'layout',
		'nom_sauvegarde'=>$Nom_sauve,
		'parametre1'=>9,
		'parametre2'=>$largeurs_colonnes[9][0],
		'parametre3'=>$largeurs_colonnes[9][1],
		'parametre4'=>$largeurs_colonnes[9][2]
	));
}

// Test de présence d'un layout pour une largeur comprise entre 980 et 1200px
$test_layout_grand_sql=sql_select('parametre1',$Table,"nom='layout_grand' AND nom_sauvegarde='$Nom_sauve'");
$tab_test_layout_grand=sql_fetch($test_layout_grand_sql);
$test_layout_grand=$tab_test_layout_grand['parametre1'];
if (!$test_layout_grand) {
	sql_insertq($Table,array(
		'nom'=>'layout_grand',
		'type'=>'layout',
		'nom_sauvegarde'=>$Nom_sauve,
		'parametre1'=>33,
		'parametre2'=>$largeurs_colonnes[33][0],
		'parametre3'=>$largeurs_colonnes[33][1],
		'parametre4'=>$largeurs_colonnes[33][2]
	));
}

// Test de présence d'un layout pour une largeur comprise entre 768 et 980px
$test_layout_moyen_sql=sql_select('parametre1',$Table,"nom='layout_moyen' AND nom_sauvegarde='$Nom_sauve'");
$tab_test_layout_moyen=sql_fetch($test_layout_moyen_sql);
$test_layout_moyen=$tab_test_layout_moyen['parametre1'];
if (!$test_layout_moyen) {
	sql_insertq($Table,array(
		'nom'=>'layout_moyen',
		'type'=>'layout',
		'nom_sauvegarde'=>$Nom_sauve,
		'parametre1'=>33,
		'parametre2'=>$largeurs_colonnes[33][0],
		'parametre3'=>$largeurs_colonnes[33][1],
		'parametre4'=>$largeurs_colonnes[33][2]
	));
}

// Test de présence d'un layout pour une largeur inférieure à 768px
$test_layout_petit_sql=sql_select('parametre1',$Table,"nom='layout_petit' AND nom_sauvegarde='$Nom_sauve'");
$tab_test_layout_petit=sql_fetch($test_layout_petit_sql);
$test_layout_petit=$tab_test_layout_petit['parametre1'];
if (!$test_layout_petit) {
	sql_insertq($Table,array(
		'nom'=>'layout_petit',
		'type'=>'layout',
		'nom_sauvegarde'=>$Nom_sauve,
		'parametre1'=>27,
		'parametre2'=>$largeurs_colonnes[27][0],
		'parametre3'=>$largeurs_colonnes[27][1],
		'parametre4'=>$largeurs_colonnes[27][2]
	));
}

// On passe maintenant à l'injection des noisettes de base
// Le schéma est le suivant :
// nom = nom du fichier de la noisette
// type sera toujours "bloc de base" (pour ne pas confondre avec des blocs personnels
// paramètre1 = le nom de la page sur laquelle le bloc s'applique (sommaire, article...)
// paramètre2 = le bloc dans lequel le bloc s'applique (content, aside...)
// paramètre3 = l'ordre dans lequel le bloc est inséré
// Test de présence des noisettes pour la page de sommaire
include_spip('inc/spipr_educ_definitions_noisettes');
include_spip('inc/spipr_educ_deplacement_bloc');
foreach (spipr_educ_toutes_les_noisettes_initialisation() as $def_bloc) {
	$ecureuil=$def_bloc;
	foreach ($ecureuil as $intitule => $valeurs){
		$test_noisette=sql_select('parametre1',$Table,"nom='$intitule' AND type='bloc de base' AND nom_sauvegarde='$Nom_sauve'");
		$tab_noisette=sql_fetch($test_noisette);
		$test_presence_noisette=$tab_noisette['parametre1'];
		if (!$test_presence_noisette) {
			sql_insertq($Table,array(
				'nom'=>$intitule,
				'type'=>'bloc de base',
				'nom_sauvegarde'=>$Nom_sauve,
				'parametre1'=>$valeurs[0],
				'parametre2'=>$valeurs[1],
				'parametre3'=>$valeurs[2],
				'parametre4'=>$valeurs[3],
				'parametre5'=>$valeurs[4],
				'parametre6'=>$valeurs[5],
				'parametre7'=>$valeurs[6],
				'parametre8'=>$valeurs[7],
				'parametre9'=>$valeurs[8],
				'parametre10'=>$valeurs[9]
			));
			spipr_educ_bloc_ranger($valeurs[0],$valeurs[1]);
			// On style un peu le bloc de présentation des compétences à la première installation
			if ($intitule=='article_competences_crcn') {
				sql_updateq(
				'spip_spipr_educ',
				array(
					'parametre5' => 'oui',
					'parametre6' => '24',
					'parametre7' => 'div.competences {
	margin-bottom:30px;
	padding:10px;
	box-shadow:0 0 4px #888;
	h4.h4 {font-size:1.2em;}
	p.legifrance {
		font-size:0.9em;
		margin:10px 0 0 0;
	}
}',
),
					"nom='article_competences_crcn' AND type='bloc de base' AND nom_sauvegarde='$Nom_sauve'"
				);
			}
		}
	}
}
// On passe maintenant à l'injection des paramètres graphiques
// Le schéma est le suivant :
// nom = extension du formulaire concerné
// type sera toujours "graphisme"
// Voir dans le formulaire pour avoir les correspondances des différents paramètres
include_spip('inc/spipr_educ_definitions_graphisme');
foreach (spipr_educ_definition_graphisme() as $def) {
	$test_graphisme=sql_select('id',$Table,"nom='$def[0]' AND type='$def[1]' AND nom_sauvegarde='$Nom_sauve'");
	$tab_graphisme=sql_fetch($test_graphisme);
	$test_presence_graphisme=$tab_graphisme['id'];
	if (!$test_presence_graphisme) {
		sql_insertq($Table,array(
			'nom'=>"$def[0]",
			'type'=>"$def[1]",
			'nom_sauvegarde'=>$Nom_sauve,
			'parametre1'=>'',
			'parametre2'=>'',
			'parametre3'=>'',
			'parametre4'=>'',
			'parametre5'=>'',
			'parametre6'=>'',
			'parametre7'=>'',
			'parametre8'=>'',
			'parametre9'=>'',
			'parametre10'=>''
		));
	}
	
// Ici l'entrée permettant de stocker le nom du thème et sa couleur
	$test_theme=sql_select('id',$Table,"type='theme' AND nom_sauvegarde='$Nom_sauve'");
	$tab_theme=sql_fetch($test_theme);
	$test_presence_theme=$tab_theme['id'];
	if (!$test_presence_theme) {
		sql_insertq($Table,array(
			'nom'=>"theme_de_base",
			'type'=>"theme",
			'nom_sauvegarde'=>$Nom_sauve,
			'parametre1'=>'',
			'parametre2'=>'',
			'parametre3'=>'',
			'parametre4'=>'',
			'parametre5'=>'',
			'parametre6'=>'',
			'parametre7'=>'',
			'parametre8'=>'',
			'parametre9'=>'',
			'parametre10'=>''
		));
	}
}
?>