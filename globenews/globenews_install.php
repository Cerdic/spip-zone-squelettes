<?php
     
     function globenews_install($action){
     
     switch($action){
     		//à la desinstallation, on efface le dépot de stockage dans la table spip_meta
		case 'uninstall':
			if (function_exists('effacer_config'))
			{
			effacer_config('globenews');
			}
			break;
     
     		}
     }
?>