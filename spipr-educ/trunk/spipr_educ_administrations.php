<?php
function spipr_educ_install($action){
	
	switch ($action){
		case 'install':
			// On va se préparer une base de données pour stocker les infos de configuration, de sauvegarde, etc, en attendant une meilleure idée pour stocker cela et pouvoir exploiter dans des boucles
			include_spip('base/spipr_educ_base');
			include_spip('base/create');
			creer_base();
			ecrire_meta('spipr_educ_base_version','0.1');
		break;
		
		case 'test':
			if (!$GLOBALS['meta']['spipr_educ_base_version']) {
				return false;
			}
			else {
				include_spip('base/spipr_educ_base_entrees');
				if (!@opendir(_DIR_IMG."spipr_educ")) {mkdir(_DIR_IMG."spipr_educ");}
				if (!@opendir(_DIR_IMG."spipr_educ/favicon")) {mkdir(_DIR_IMG."spipr_educ/favicon");}	
				return true;
			}
		break;
		
		case 'uninstall':
			sql_query('DROP TABLE spip_spipr_educ');
			effacer_meta('spipr_educ_base_version');
		break;
	}
	
}
?>