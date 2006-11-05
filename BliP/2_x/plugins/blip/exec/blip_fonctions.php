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

function exec_blip_fonctions() {
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
	barre_onglets("blip", "fonctions");
	
	debut_gauche();
	
	debut_boite_info();
	echo _T('blipconfig:blip_fonctions_info');
	fin_boite_info();
	
	debut_raccourcis();
	echo _T('blipconfig:blip_raccourcis_documentation');
	fin_raccourcis();

	debut_droite();

    echo "Prochainement ici, divers formulaires de configuration avancées";
 
	fin_page();

}
?>
