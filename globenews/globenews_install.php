<?php
     
     function globenews_install($action){
     
     switch($action){
     		//� la desinstallation, on efface le d�pot de stockage dans la table spip_meta
		case 'uninstall':
			if (function_exists('effacer_config'))
			{
			effacer_config('globenews');
			}
			break;
     
     		}
     }
?>