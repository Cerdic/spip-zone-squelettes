<?php

/***************************************************************************\
 *                                                                         *
\***************************************************************************/

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/config');
include_spip('inc/presentation');
include_spip('inc/layer');
include_spip('inc/meta');

include_spip('inc/blip_actions');

function exec_BliP() {
	global $connect_statut;
	global $connect_toutes_rubriques;
	global $spip_lang_right;
	global $blip_version_ftp;
	$surligne = "";
  
	if ($connect_statut != '0minirezo' OR !$connect_toutes_rubriques) {
		debut_page(_T('blipconfig:blip_config'), "administration", "BLiP");
		echo _T('avis_non_acces_page');
		fin_page();
		exit;
	}

	if (isset($_GET['action'])) {        
		// Trop fort les switchs ...
        switch ($action = $_GET['action']) {
            case "editer" :
            case "creer" :
                echo BliP_generer_formulaire($action);
                break;
            case "monter" :
            case "descendre" :
            case "activer" :
                if (isset($_GET['id'])) {
                    BliP_activer_ligne($_GET['id']);
                }
                break;
            case "desactiver" :
                if (isset($_GET['id'])) {
                    BliP_desactiver_ligne($_GET['id']);
                }
				break;
            case "supprimer" :
                if (isset($_GET['id'])) {
                    BliP_supprimer_ligne($_GET['id']);
                }				
                break;
            case "install" :
                BliP_installer_blip();
                break;
			case "maj" :
                BliP_maj_blip();
                break;
        }
    }	
	
	debut_page(_T('blipconfig:blip_config'), "administration", "BLiP");
	echo "<br/>";
	
	gros_titre(_T('blipconfig:blip_config'));
	
	if (BliP_verifier_base())
	{
    barre_onglets("blip", "voir");	        
    } 

	
	
	debut_gauche();
	
	debut_boite_info();
	echo _T('blipconfig:blip_voir_info');
	fin_boite_info();

	debut_raccourcis();
	echo _T('blipconfig:blip_raccourcis_documentation');
	fin_raccourcis();
	
	debut_droite();	
	
	debut_cadre_enfonce("racine-site-24.gif", false, "", bouton_block_invisible('blip_general')._T('blipconfig:blip_configuration_voir_general'));
	if (BliP_verifier_base()) {
		$v_instal = $GLOBALS['meta']["blip_version"];
		$v_ftp = BliP_version_ftp();
		if ($v_instal==$v_ftp) {
			echo _T('blipconfig:blip_info_base_ok');
			}
		else {
			echo _T('blipconfig:blip_maj_requise');
			echo '<p /><div align="center">';
			echo '<form method="post" action="'.generer_url_ecrire('blip',"action=maj").'">';
			echo '<input type="submit" name="appliq" value="Mettre &agrave; jour le squelette BLiP" />';
			echo '</form></div>';
			}		
		} 
	else {
        echo _T("blipconfig:blip_info_base_ko");
		echo '<p /><div align="center">';
		echo '<form method="post" action="'.generer_url_ecrire('blip',"action=install").'">';
		echo '<input type="submit" name="appliq" value="Installer le squelette BLiP" />';
		echo '</form></div>';
		}

	echo debut_block_invisible('blip_general');
		if (BliP_verifier_base()) {		
			if ($v_instal==$v_ftp) {
				echo 'Version install&eacute;e : '.$v_instal;
				}
			else {
				echo 'Version install&eacute;e : '.$v_instal;
				echo '<br />Version sur le serveur : '.$v_ftp;
				}		
			} 	
		else {
		echo '<p />';
        echo _T("blipconfig:blip_info_base_ko_bis");

		}
	echo fin_block();
	fin_cadre_enfonce();

	BliP_afficher_configuration ();	

	fin_page();

}
?>
