<?php
function eva_habillage_install($action){

	$Table1 = 'spip_eva_habillage';
	$Table2 = 'spip_eva_habillage_themes';
	$Table3 = 'spip_eva_habillage_images';
	switch ($action){

		case 'install':
		include_spip('base/eva_habillage_base_patch');
		eva_habillage_patch_table();
		include_spip('base/eva_habillage_base');
		include_spip('base/create');
		creer_base();
		$eva_verif = sql_select("id_habillage",$Table1,"sauvegarde = 'Defaut'");
		$eva_ver_tab = sql_fetch($eva_verif);
		$eva_id_habillage = $eva_ver_tab['id_habillage'];
			if (!isset($eva_id_habillage)) {
				sql_insertq($Table1,array('habillage' => 'eva4_menu_gauche.css','sauvegarde' => 'Defaut'));
			sql_insertq($Table2,array('nom'=>'Defaut'));}
		ecrire_meta('eva_habillage_base_version','0.3');
		$test_eva=$GLOBALS['meta']['eva_habillage_base_version'];
		if (!@opendir(_DIR_IMG."eva_habillage")) {mkdir(_DIR_IMG."eva_habillage");}
		if (!@opendir(_DIR_IMG."eva_habillage/flash")) {mkdir(_DIR_IMG."eva_habillage/flash");}
		if (!@opendir(_DIR_IMG."eva_habillage/favicon")) {mkdir(_DIR_IMG."eva_habillage/favicon");}
		$Table1 = 'spip_eva_habillage';
		$Table2 = 'spip_eva_habillage_themes';
		$Table3 = 'spip_eva_habillage_images';
		$eva_verif_table1=sql_select('id_habillage',$Table1,"sauvegarde = 'Defaut'");
		$eva_verif_table1_tab=sql_fetch($eva_verif_table1);
		$id_verif_table1=$eva_verif_table1_tab['id_habillage'];
		if (!$id_verif_table1) {sql_insertq($Table1,array('habillage' => 'eva4_menu_gauche.css','sauvegarde' => 'Defaut'));}
		$eva_verif_table2=sql_select('id',$Table2,"nom = 'Defaut'");
		$eva_verif_table2_tab=sql_fetch($eva_verif_table2);
		$id_verif_table2=$eva_verif_table2_tab['id'];
		if (!$id_verif_table2) {sql_insertq($Table2,array('nom'=>'Defaut'));}
		ecrire_meta('eva_habillage_base_version','0.4');

		//Préparation à la modlarité
		$test_eva=$GLOBALS['meta']['eva_habillage_base_version'];
		//On commence par la page de sommaire
		include_spip('inc/eva_habillage_transition_module');
		eva_habillage_transition_module();	
		ecrire_meta('eva_habillage_base_version','0.5');
		break;

		case 'test':
		$test_eva=$GLOBALS['meta']['eva_habillage_base_version'];
		include_spip('base/eva_habillage_base_patch');
		eva_habillage_patch_table();
		if (!$GLOBALS['meta']['eva_habillage_base_version']) {return false;}
		else {
			include_spip('base/eva_habillage_base');
			include_spip('base/create');
			creer_base();
			$eva_verif = sql_select("id_habillage",$Table1,"sauvegarde = 'Defaut'");
			$eva_ver_tab = sql_fetch($eva_verif);
			$eva_id_habillage = $eva_ver_tab['id_habillage'];
			if (!isset($eva_id_habillage)) {
				sql_insertq($Table1,array('habillage' => 'eva4_menu_gauche.css','sauvegarde' => 'Defaut'));
			sql_insertq($Table2,array('nom'=>'Defaut'));}
			$test_eva=$GLOBALS['meta']['eva_habillage_base_version'];
			if (!@opendir(_DIR_IMG."eva_habillage")) {mkdir(_DIR_IMG."eva_habillage");}
			if (!@opendir(_DIR_IMG."eva_habillage/flash")) {mkdir(_DIR_IMG."eva_habillage/flash");}
			if (!@opendir(_DIR_IMG."eva_habillage/favicon")) {mkdir(_DIR_IMG."eva_habillage/favicon");}
			$Table1 = 'spip_eva_habillage';
			$Table2 = 'spip_eva_habillage_themes';
			$Table3 = 'spip_eva_habillage_images';
			$eva_verif_table1=sql_select('id_habillage',$Table1,"sauvegarde = 'Defaut'");
			$eva_verif_table1_tab=sql_fetch($eva_verif_table1);
			$id_verif_table1=$eva_verif_table1_tab['id_habillage'];
			if (!$id_verif_table1) {sql_insertq($Table1,array('habillage' => 'eva4_menu_gauche.css','sauvegarde' => 'Defaut'));}
			$eva_verif_table2=sql_select('id',$Table2,"nom = 'Defaut'");
			$eva_verif_table2_tab=sql_fetch($eva_verif_table2);
			$id_verif_table2=$eva_verif_table2_tab['id'];
			if (!$id_verif_table2) {sql_insertq($Table2,array('nom'=>'Defaut'));}
			ecrire_meta('eva_habillage_base_version','0.4');

			//Préparation à la modlarité
			$test_eva=$GLOBALS['meta']['eva_habillage_base_version'];
			//On commence par la page de sommaire
			include_spip('inc/eva_habillage_transition_module');
			eva_habillage_transition_module();	
			ecrire_meta('eva_habillage_base_version','0.5');

			//Préparation au multilinguisme
			$test_eva=$GLOBALS['meta']['eva_habillage_base_version'];
			if ($test_eva=='0.5') {
				$test_langue = sql_select("id","spip_eva_habillage_images","type='fichier_lang' AND attach=''");
				while ($tab = sql_fetch($test_langue)) {
					sql_updateq('spip_eva_habillage_images',array('attach'=>utiliser_langue_site()),"id='".$tab['id']."'");
				}
				ecrire_meta('eva_habillage_base_version','0.6');
			}
			return true;
		}
		break;

		case 'uninstall':
		sql_query('DROP TABLE '.$Table1);
		sql_query('DROP TABLE '.$Table2);
		sql_query('DROP TABLE '.$Table3);
		effacer_meta('eva_habillage_base_version');
		break;
	}
}
?>