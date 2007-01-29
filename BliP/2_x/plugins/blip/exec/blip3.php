<?php

/***************************************************************************\
 *                                                                         *
\***************************************************************************/

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/config');
include_spip('inc/presentation');
include_spip('inc/layer');
include_spip('inc/meta');

include_spip('inc/blip3_actions');

function exec_BliP3() {
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
        switch ($action = $_GET['action']) {
            case "editer" :
            case "creer" :
                echo BliP_generer_formulaire($action);
                break;
            case "monter" :
            case "descendre" :
                if (isset($_GET['id'])) {
                    BliP_changer_position($_GET['id'], $action);
                }
                break;            
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



	debut_gauche();

	BliP_creer_boite_option(structure);
	BliP_creer_boite_option(theme);
	BliP_creer_boite_option(couleur);	

	debut_raccourcis();
	echo _T('blipconfig:blip_raccourcis_documentation');
	fin_raccourcis();
	
	debut_droite();

	debut_cadre_enfonce("racine-site-24.gif", false, "", bouton_block_invisible('blip_general')._T('blipconfig:blip_configuration_voir_general'));
	
	
	
	fin_cadre_enfonce();

	

	echo fin_gauche(), fin_page();

}
?>
