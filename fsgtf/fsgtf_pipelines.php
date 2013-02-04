<?php

if (!defined('_ECRIRE_INC_VERSION')) return;

function fsgtf_affiche_milieu($flux){
	if ($flux['args']['exec'] == 'configurer_avancees')
		$flux['data'] .= recuperer_fond('prive/squelettes/inclure/configurer', array('configurer' => 'configurer_fsgtf'));
	return $flux;
}

function fsgtf_jqueryui_plugins($scripts){
   $scripts[] = "jquery-ui";
   return $scripts;
}

?>
