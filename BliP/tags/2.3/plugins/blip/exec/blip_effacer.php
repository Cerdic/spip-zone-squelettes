<?php

/***************************************************************************\
 *                                                                         *
\***************************************************************************/

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/config');
include_spip('inc/presentation');
include_spip('inc/layer');

include_spip('inc/blip_actions');

function exec_blip_effacer() {
	global $connect_statut;
	global $connect_toutes_rubriques;
	global $spip_lang_right;
	$surligne = "";
  
	if ($connect_statut != '0minirezo' OR !$connect_toutes_rubriques) {
		debut_page(_T('blipconfig:blip_config'), "administration", "BLiP");
		echo _T('avis_non_acces_page');
		fin_page();
		exit;
	}	
	
	if (isset($_GET['action'])) {        
        switch ($action = $_GET['action']) {
            case "desinstaller" :
                BliP_supprimer_blip();
                break;
			case "vider" :
                BliP_vider_table_blip();
                break;
			case "reinitialiser" :
                BliP_installer_configuration();
                break;
        }
    }
	
	
	debut_page(_T('blipconfig:blip_config'), "administration", "BLiP");
	echo "<br/><br/><br/>";
	
	gros_titre(_T('blipconfig:blip_config'));
	
	if (BliP_verifier_base())
	{
    barre_onglets("blip", "maintenance");	        
    } 
	
	
	debut_gauche();
	
	debut_boite_info();
	echo _T('blipconfig:blip_effacer_info');
	fin_boite_info();
	
	debut_raccourcis();
	echo _T('blipconfig:blip_raccourcis_documentation');
	fin_raccourcis();

	debut_droite();

	debut_cadre_enfonce("supprimer.gif", false, "", bouton_block_invisible('blip_vider')._T('blipconfig:blip_maintenance_vider'));
	if (BliP_verifier_base()) {
        echo _T('blipconfig:blip_info_base_ok');        
    } 
	else {
        echo _T("blipconfig:blip_info_deja_ko");
    }
	
	echo debut_block_invisible('blip_vider');
		if (BliP_verifier_base()) {
        debut_boite_alerte();
		echo _T('blipconfig:blip_info_vider');
		echo '<div align="center">';
	    echo '<form method="post" action="'.generer_url_ecrire('blip_effacer',"action=vider").'">';
	    echo '<input type="submit" name="appliq" value="'._T('blipconfig:blip_maintenance_vider').'" />';
	    echo '</form></div>';
		fin_boite_alerte();        
		} 
		else {
		echo " ";
    }
	echo fin_block();
	fin_cadre_enfonce();
	
	
	debut_cadre_enfonce("supprimer.gif", false, "", bouton_block_invisible('blip_reinitialiser')._T('blipconfig:blip_maintenance_reinitialiser'));
	if (BliP_verifier_base()) {
        echo _T('blipconfig:blip_info_base_ok');        
    } 
	else {
        echo _T("blipconfig:blip_info_deja_ko");
    }
	
	echo debut_block_invisible('blip_reinitialiser');
		if (BliP_verifier_base()) {
        debut_boite_alerte();
		echo _T('blipconfig:blip_info_reinitialiser');
		echo '<div align="center">';
	    echo '<form method="post" action="'.generer_url_ecrire('blip_effacer',"action=reinitialiser").'">';
	    echo '<input type="submit" name="appliq" value="'._T('blipconfig:blip_maintenance_reinitialiser').'" />';
	    echo '</form></div>';
		fin_boite_alerte();        
		} 
		else {
		echo " ";
    }
	echo fin_block();
	fin_cadre_enfonce();
	
	
	debut_cadre_enfonce("supprimer.gif", false, "", bouton_block_invisible('blip_desinstaller')._T('blipconfig:blip_maintenance_desinstaller'));
	if (BliP_verifier_base()) {
        echo _T('blipconfig:blip_info_base_ok');        
    } 
	else {
        echo _T("blipconfig:blip_info_deja_ko");
    }
	
	echo debut_block_invisible('blip_desinstaller');
		if (BliP_verifier_base()) {
        debut_boite_alerte();
		echo _T('blipconfig:blip_info_desinstaller');
		echo '<div align="center">';
	    echo '<form method="post" action="'.generer_url_ecrire('blip_effacer',"action=desinstaller").'">';
	    echo '<input type="submit" name="appliq" value="'._T('blipconfig:blip_maintenance_desinstaller').'" />';
	    echo '</form></div>';
		fin_boite_alerte();        
		} 
		else {
		echo " ";
    }
	echo fin_block();
	fin_cadre_enfonce();
	
	fin_page();

}
?>
