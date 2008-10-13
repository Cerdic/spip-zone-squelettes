<?php
/******************************************************************
***  Ce plugin EVA_habillage, cr�� par Olivier Gautier, est mis ***
***      � disposition sous un contrat Creative Commons BY      *** 
***                 consultable � l'adresse                     ***
***      http://www.creativecommons.org/licenses/by/2.0/fr/     ***
******************************************************************/
function eva_habillage_install($action){
	
	$Table1 = 'spip_eva_habillage';
	$Table2 = 'spip_eva_habillage_themes';
	$Table3 = 'spip_eva_habillage_images';
	switch ($action){
	
	case 'install':
	include_spip('base/eva_habillage_base');
	include_spip('base/create');
	creer_base();
	$eva_verif = sql_select("id_habillage",$Table1,"sauvegarde = 'Defaut'");
	$eva_ver_tab = sql_fetch($eva_verif);
	$eva_id_habillage = $eva_ver_tab['id_habillage'];
	if (!isset($eva_id_habillage)) {
	sql_insertq($Table1,array('habillage' => '0','sauvegarde' => 'Defaut'));
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
	if (!$id_verif_table1) {sql_insertq($Table1,array('habillage' => '0','sauvegarde' => 'Defaut'));}
	$eva_verif_table2=sql_select('id',$Table2,"nom = 'Defaut'");
	$eva_verif_table2_tab=sql_fetch($eva_verif_table2);
	$id_verif_table2=$eva_verif_table2_tab['id'];
	if (!$id_verif_table2) {sql_insertq($Table2,array('nom'=>'Defaut'));}
	ecrire_meta('eva_habillage_base_version','0.4');
	
	//Pr�paration � la modlarit�
	$test_eva=$GLOBALS['meta']['eva_habillage_base_version'];
	//On commence par la page de sommaire
	include_spip('inc/eva_habillage_transition_module');
	eva_habillage_transition_module();	
	ecrire_meta('eva_habillage_base_version','0.5');
	break;
	
	case 'test':
	if (!$GLOBALS['meta']['eva_habillage_base_version']) {return false;}
	else {
	include_spip('base/eva_habillage_base');
	include_spip('base/create');
	creer_base();
	$eva_verif = sql_select("id_habillage",$Table1,"sauvegarde = 'Defaut'");
	$eva_ver_tab = sql_fetch($eva_verif);
	$eva_id_habillage = $eva_ver_tab['id_habillage'];
	if (!isset($eva_id_habillage)) {
	sql_insertq($Table1,array('habillage' => '0','sauvegarde' => 'Defaut'));
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
	if (!$id_verif_table1) {sql_insertq($Table1,array('habillage' => '0','sauvegarde' => 'Defaut'));}
	$eva_verif_table2=sql_select('id',$Table2,"nom = 'Defaut'");
	$eva_verif_table2_tab=sql_fetch($eva_verif_table2);
	$id_verif_table2=$eva_verif_table2_tab['id'];
	if (!$id_verif_table2) {sql_insertq($Table2,array('nom'=>'Defaut'));}
	ecrire_meta('eva_habillage_base_version','0.4');
	
	//Pr�paration � la modlarit�
	$test_eva=$GLOBALS['meta']['eva_habillage_base_version'];
	//On commence par la page de sommaire
	include_spip('inc/eva_habillage_transition_module');
	eva_habillage_transition_module();	
	ecrire_meta('eva_habillage_base_version','0.5');
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