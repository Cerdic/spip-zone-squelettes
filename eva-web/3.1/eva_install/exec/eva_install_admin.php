<?php
 function exec_eva_installm_admin() {
  global $connect_statut, $connect_toutes_rubriques, $changer_config;
	if ($connect_statut != '0minirezo' OR !$connect_toutes_rubriques) {
		echo _T('avis_non_acces_page');
		exit;
	}

	// les fonctions de spip necessaires pour afficher les elements de l'interface
	include_spip("inc/presentation");		
	include_spip("inc/eva_install_config");		

//	init_config();
	if ($changer_config == 'oui') appliquer_modifs_config();

	global $flag_revisions, $options ;

	pipeline('exec_init',array('args'=>array('exec'=>'config_fonctions'),'data'=>''));
	debut_page(_T('titre_page_config_fonctions'), "configuration", "configuration");

	echo "<br><br><br>";
	gros_titre(_T('titre_config_fonctions'));
	barre_onglets("configuration", "evainstall");

	debut_gauche();
	//Colonne gauche
	debut_cadre_relief("../"._DIR_PLUGIN_EVAINSTALL."/img_pack/mailcheck24.png", false, "", _T('evainstall:module_titre'));
	echo(_T('evainstall:module_introduction'));
	fin_cadre_relief(false);
	echo pipeline('affiche_gauche',array('args'=>array('exec'=>'evainstall_admin'),'data'=>''));

	//Colonne droite
	creer_colonne_droite();
	echo pipeline('affiche_droite',array('args'=>array('exec'=>'evainstall_admin'),'data'=>''));
	debut_droite();
//	lire_metas();

//	echo generer_url_post_ecrire('antispam_admin');
//	echo "<input type='hidden' name='changer_config' value='oui'>";

  //Colonne du milieu
  //-----------------
  gros_titre(_T('evainstall:configuration_titre'));

  //Texte
  debut_cadre_enfonce("../"._DIR_PLUGIN_EVAINSTALL."/img_pack/text.png", false, "", _T('evainstall:texte_titre'));
  echo evainstall_config_text();
  fin_cadre_enfonce(false);

  //Fonction js
  debut_cadre_enfonce("../"._DIR_PLUGIN_EVAINSTALL."/img_pack/script.png", false, "", _T('evainstall:fonction_titre'));
  echo evainstall_config_fonction();
  fin_cadre_enfonce(false);

  fin_page();

 }

?> 
