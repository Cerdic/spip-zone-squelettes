<?php

/***************************************************************************\
 *                                                                         *
\***************************************************************************/

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/config');
include_spip('inc/presentation');
include_spip('inc/layer');
include_spip('base/abstract_sql');

include_spip('inc/blip_actions');

function exec_blip_modifier() {
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
	
	debut_page(_T('blipconfig:blip_config'), "administration", "BLiP");
	echo "<br/>";
	
	gros_titre(_T('blipconfig:blip_config'));
	echo barre_onglets("blip", "modifier");
	
	debut_gauche();
	
	debut_boite_info();
	echo _T('blipconfig:blip_modifier_info');
	fin_boite_info();

	debut_raccourcis();
	echo _T('blipconfig:blip_raccourcis_documentation');
	fin_raccourcis();
	
	debut_droite();	

	if (isset($_GET['action'])) {
		$action = $_GET['action'];
			if ($action == 'editer') {
				debut_cadre_trait_couleur("mot-cle-24.gif", false, "", _T('blipconfig:blip_modifier_editer'));
				echo "<div style='padding:5px;'>";
				BliP_generer_formulaire($action);
				echo "</div>";
				fin_cadre_trait_couleur();
			}
			if ($action == 'creer') {
				debut_cadre_trait_couleur("mot-cle-24.gif", false, "", _T('blipconfig:blip_modifier_creer'));
				echo "<div style='padding:5px;'>";
				BliP_generer_formulaire($action);
				echo "</div>";
				fin_cadre_trait_couleur();
			}
			if ($action == 'formulaire') {
                BliP_action_formulaire();
            }
			
    }	
	
	fin_page();

}
?>
